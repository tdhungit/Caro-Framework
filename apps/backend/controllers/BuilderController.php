<?php
/**
 * Created by Jacky.
 * User: Jacky
 * File: BuilderController.php
 * Project: Caro-Framework
 */

namespace Modules\Backend\Controllers;


use Modules\Backend\Helpers\CsvHelper;

class BuilderController extends ControllerBase
{
    /**
     * @var array database types
     */
    public $types = [
        'int', 'date', 'varchar', 'decimal', 'datetime', 'char', 'text', 'float', 'boolean', 'double', 'tinyblob', 'blob', 'mediumblob', 'longblob', 'bigint', 'json', 'jsonb'
    ];

    /**
     * @param $model_name
     * @return string
     */
    public static function getDefaultDBFromModel($model_name)
    {
        $table = '';
        for ($i = 0; $i < strlen($model_name); $i++) {
            if ($i != 0 && ctype_upper($model_name[$i]) == true) {
                $table .= '_' . strtolower($model_name[$i]);
            } else {
                $table .= strtolower($model_name[$i]);
            }
        }

        return $table;
    }

    /**
     * all model
     */
    public function indexAction()
    {
        $models = array();
        $model_path = APP_PATH . '/apps/backend/models/*.php';

        foreach (glob($model_path) as $model) {
            $name = basename($model, '.php');
            if ($name != 'ModelBase' && $name != 'CaroLogs') {
                $models[] = $name;
            }
        }

        $this->view->models = $models;
    }

    /**
     * edit model
     *
     * @param $model_name
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    public function edit_modelAction($model_name)
    {
        $model = $this->getModel($model_name);

        if (!$model) {
            return $this->backendRedirect('/builder');
        }

        $table_name = $model->getSource();

        if (is_file(APP_PATH . 'apps/config/database_structures.ini.php')) {
            $databases = include APP_PATH . 'apps/config/database_structures.ini.php';
        } else {
            $databases = include APP_PATH . 'apps/config/database_structures.php';
        }

        if (empty($databases[$table_name]['fields'])) {
            $databases[$table_name]['fields'] = array();
        }

        if (empty($databases[$table_name]['indexes'])) {
            $databases[$table_name]['indexes'] = array();
        }

        $this->view->table = $databases[$table_name];
        $this->view->types = $this->types;

        $this->view->model_name = $model_name;
    }

    /**
     * add new field to model
     *
     * @param $name
     * @param $type
     * @param $size
     * @param $notnull
     */
    public function ajax_add_fieldAction($name, $type, $size, $notnull)
    {
        $this->view->types = $this->types;
        $this->view->field_name = $name;
        $this->view->field_type = $type;
        $this->view->field_size = $size;
        $this->view->notnull = $notnull;

        $this->view->setTemplateAfter('ajax');
    }

    /**
     * add indexes to model
     *
     * @param $model_name
     * @param $number
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    public function ajax_add_indexAction($model_name, $number)
    {
        $model = $this->getModel($model_name);

        if (!$model) {
            return $this->backendRedirect('/builder');
        }

        $table_name = $model->getSource();

        if (is_file(APP_PATH . 'apps/config/database_structures.ini.php')) {
            $databases = include APP_PATH . 'apps/config/database_structures.ini.php';
        } else {
            $databases = include APP_PATH . 'apps/config/database_structures.php';
        }

        $databases = $databases[$table_name];
        $fields = array();
        foreach ($databases['fields'] as $field => $options) {
            $fields[$field] = $field;
        }

        $this->view->fields = $fields;
        $this->view->number = "add$number";
        $this->view->setTemplateAfter('ajax');
    }

    /**
     * update fields to model
     */
    public function update_fieldsAction()
    {
        $this->view->disable();
        if ($this->request->isPost()) {
            $model_name = $this->request->getPost('model');
            $model = $this->getModel($model_name);
            $table = $model->getSource();

            $fields = $this->request->getPost('fields');
            $indexes = $this->request->getPost('indexes');

            if (is_file(APP_PATH . 'apps/config/database_structures.ini.php')) {
                $databases = include APP_PATH . 'apps/config/database_structures.ini.php';
            } else {
                $databases = include APP_PATH . 'apps/config/database_structures.php';
            }

            $databases[$table]['fields'] = array();
            if ($fields) {
                foreach ($fields as $field) {
                    $databases[$table]['fields'][$field['name']] = array(
                        'type' => (int)$field['type'],
                        'size' => (int)$field['size'],
                        'notNull' => (bool)$field['notnull']
                    );
                }
            }

            $databases[$table]['indexes'] = array();
            if ($indexes) {
                foreach ($indexes as $index) {
                    $databases[$table]['indexes'][$index['name']] = array(
                        'type' => $index['type'],
                        'fields' => explode(',', $index['fields'])
                    );
                }
            }

            $file = fopen(APP_PATH . "apps/config/database_structures.ini.php", "w");
            fwrite($file, "<?php\n\n return " . var_export($databases, true) . ";\n");
            fclose($file);
        }

        $this->backendRedirect('/builder/edit_model/' . $model_name);
    }

    /**
     * create new model
     */
    public function create_modelAction()
    {
        if ($this->request->isPost()) {
            $main_module = $this->request->getPost('main_module');
            $module_name = $this->request->getPost('module_name');
            $model_name = $this->request->getPost('model_name');

            // check model name
            if (!$model_name) {
                $this->flash->error($this->t->_('Please input model name!'));
                return $this->backendRedirect('/builder/create_model');
            }

            // check module name
            if ($main_module != 'core' && !$module_name) {
                $this->flash->error($this->t->_('Please input module name!'));
                return $this->backendRedirect('/builder/create_model');
            }

            $model_file = APP_PATH . "apps/backend/models/{$model_name}.php";
            $model_file_front = APP_PATH . "apps/frontend/models/{$model_name}.php";

            if ($main_module == 'core') {
                $model_file_module = null;
            } else {
                @mkdir(APP_PATH . "apps/{$main_module}/src/{$module_name}");
                @mkdir(APP_PATH . "apps/{$main_module}/src/{$module_name}/Models");
                @mkdir(APP_PATH . "apps/{$main_module}/src/{$module_name}/Controllers");
                @mkdir(APP_PATH . "apps/{$main_module}/src/{$module_name}/config");
                @mkdir(APP_PATH . "apps/{$main_module}/src/{$module_name}/views");
                $model_file_module = APP_PATH . "apps/{$main_module}/src/{$module_name}/Models/{$model_name}.php";
            }

            if (is_file($model_file) || is_file($model_file_front) || is_file($model_file_module)) {
                $this->flash->error('Exits this model!');
                return $this->backendRedirect('/builder/create_model');
            }

            $ucfirst_main_module = ucfirst($main_module);

            // write model backend
            $file = fopen($model_file, 'w');
            $content = "<?php\n\nnamespace Modules\\Backend\\Models;\n\nclass $model_name extends ModelBase \n{\n\n}";
            fwrite($file, $content);
            fclose($file);

            // write model front-end
            $file = fopen($model_file_front, 'w');
            $content = "<?php\n\nnamespace Modules\\Frontend\\Models;\n\nclass $model_name extends ModelBase\n{\n\n}";
            fwrite($file, $content);
            fclose($file);

            // write controller
            if ($main_module == 'core') { // write core controller
                $controller_file = APP_PATH . "apps/backend/controllers/{$model_name}Controller.php";
                if (!is_file($controller_file)) {
                    $file = fopen($controller_file, 'w');
                    $content = "<?php\n\nnamespace Modules\\Backend\\Controllers;\n\n";
                    $content .= "class {$model_name}Controller extends ControllerBase \n{\n";
                    $content .= "\tprotected \$model_name = '$model_name';\n\n";
                    $content .= "\tpublic function indexAction()\n\t{\n\t\t\$this->listAction();\n\t}\n}";
                    fwrite($file, $content);
                    fclose($file);
                }
            } else { // write module controller and model
                // write model module
                $file = fopen($model_file_module, 'w');
                $content = "<?php\n\nnamespace Modules\\{$ucfirst_main_module}\\Src\\{$module_name}\\Models;\n\n\n";
                $content .= "class $model_name extends \\Modules\\{$ucfirst_main_module}\\Models\\{$model_name}\n{\n\n}";
                fwrite($file, $content);
                fclose($file);

                // write controller
                $controller_file = APP_PATH . "apps/{$main_module}/src/{$module_name}/Controllers/{$model_name}Controller.php";
                if (!is_file($controller_file)) {
                    $file = fopen($controller_file, 'w');
                    $content = "<?php\n\nnamespace Modules\\{$ucfirst_main_module}\\Src\\{$module_name}\\Controllers;\n\n\n";
                    $content .= "use Modules\\{$ucfirst_main_module}\\Controllers\\ControllerBase;\n\n";
                    $content .= "class {$model_name}Controller extends ControllerBase \n{\n";
                    $content .= "\tprotected \$module_name = '{$module_name}';\n\n";
                    $content .= "\tprotected \$model_name = '{$model_name}';\n\n";
                    $content .= "\tpublic function indexAction()\n";
                    $content .= "\t{\n\t\t\$this->listAction();\n\t}\n}";
                    fwrite($file, $content);
                    fclose($file);
                }

                // write router
                $router_file = APP_PATH . "apps/{$main_module}/src/{$module_name}/config/router.php";
                $file = fopen($router_file, 'w');
                $default_router = [
                    '/module/' . strtolower($module_name) . '/:controller/:action/:params' => [
                        'controller' => 1,
                        'action' => 2,
                        'params' => 3,
                        'namespace' => "Modules\\{$ucfirst_main_module}\\Src\\{$module_name}\\Controllers",
                        'module' => $main_module
                    ]
                ];
                fwrite($file, "<?php\n\n return " . var_export($default_router, true) . ';');
                fclose($file);

                // write view readme file
                $view_file = APP_PATH . "apps/{$main_module}/src/{$module_name}/views/readme.txt";
                $file = fopen($view_file, 'w');
                fwrite($file, 'Views file with ext: *.twig');
                fclose($file);
            }

            $this->flash->success($this->t->_('Successful!'));
            $this->backendRedirect('/builder');
        }
    }

    /**
     * edit layout list/edit/detail/subpanel
     *
     * @param null $model_name
     */
    public function edit_layoutAction($model_name = null)
    {
        // save layout
        if ($this->request->isPost()) {
            //$this->view->disable(); echo '<pre>'; print_r($this->request->getPost()); die();
            $model_name = $this->request->getPost('model_name');
            //$model = $this->getModel($model_name);

            // detail view / edit view layout
            $detail_view['fields'] = $this->request->getPost('detail_fields');
            $edit_view['fields'] = $this->request->getPost('edit_fields');

            // title
            $detail_view['title'] = $edit_view['title'] = $this->request->getPost('title_field');

            // list view layout
            $list_fields = $this->request->getPost('list_fields');
            $list_view = array();
            foreach ($list_fields as $field => $options) {
                if ($options['type']) {
                    if ($options['search']) {
                        $options['search'] = 1;
                        $options['operator'] = 'like';
                    } else {
                        $options['search'] = 0;
                    }

                    if ($field == 'name') {
                        $options['link'] = 1;
                    }

                    $list_view['fields'][$field] = $options;
                }
            }

            // subpanel layout
            $subpanels = $this->request->getPost('subpanels');
            foreach ($subpanels as $subpanel) {
                if ($subpanel['name']) {
                    $detail_view['subpanels'][$subpanel['name']] = [
                        'type' => $subpanel['type'],
                        'current_model' => $subpanel['current_model'],
                        'current_field' => $subpanel['current_field'],
                        'rel_model' => $subpanel['rel_model'],
                        'rel_field' => $subpanel['rel_field']
                    ];

                    // mid rel model
                    if ($subpanel['type'] == 'many-many') {
                        $detail_view['subpanels'][$subpanel['name']]['mid_model'] = $subpanel['mid_model'];
                        $detail_view['subpanels'][$subpanel['name']]['mid_field1'] = $subpanel['mid_field1'];
                        $detail_view['subpanels'][$subpanel['name']]['mid_field2'] = $subpanel['mid_field2'];
                    }

                    // list layout
                    foreach ($subpanel['list'] as $subpanel_list_field => $subpanel_list) {
                        if ($subpanel_list['label']) {
                            $detail_view['subpanels'][$subpanel['name']]['list'][$subpanel_list_field] = $subpanel_list;
                        }
                    }
                }
            }

            $config_name = $model_name . '.conf.php';
            $file_config = APP_PATH . 'apps/backend/config/' . $config_name;
            $file = fopen($file_config, "w");
            $content = "<?php";
            $content .= "\n\n\$layout_config_list_view = " . var_export($list_view, true) . ";";
            $content .= "\n\n\$layout_config_edit_view = " . var_export($edit_view, true) . ";";
            $content .= "\n\n\$layout_config_detail_view = " . var_export($detail_view, true) . ";";
            fwrite($file, $content);
            fclose($file);

            return $this->backendRedirect('/builder/edit_layout/' . $model_name);
        }

        // view layout
        $model = $this->getModel($model_name);
        $fields = $model->allFields();

        $layout_fields = [];
        foreach ($fields['fields'] as $field => $options) {
            $layout_fields[$field] = $field;
        }

        // all fields
        $this->view->fields = $fields['fields'];
        $this->view->layout_fields = $layout_fields;

        $this->view->model_name = $model_name;

        // title field
        $this->view->title_field = $model->detail_view['title'];

        // selected fields
        $this->view->list_fields = $model->list_view;
        $this->view->edit_fields = $model->edit_view;
        $this->view->detail_fields = $model->detail_view;
        // all type
        $this->view->types = $model->getFieldTypes();
        // all model
        $this->view->all_models = $model->getAllModels();
        // all list dropdown
        $all_lists = array();
        foreach ($this->carofw['app_list_strings'] as $list_dropdown => $value) {
            $all_lists[$list_dropdown] = $list_dropdown;
        }
        $this->view->all_lists = $all_lists;
    }

    /**
     * load subpanel to edit layout
     */
    public function load_subpanelAction()
    {
        $this->view->setTemplateAfter('ajax');

        $type = $this->request->get('type');
        $model_name = $this->request->get('model_name');

        $current_model = $this->getModel($model_name);
        $current_fields = $current_model->allFields();

        // option all current model fields
        $options_current_fields = '<option value="id">id</option>';
        foreach ($current_fields['fields'] as $field => $options) {
            $options_current_fields .= '<option value="' . $field . '">' . $field . '</option>';
        }
        $this->view->options_current_fields = $options_current_fields;

        $this->view->type = $type;
        $this->view->model_name = $model_name;
        $this->view->models = $current_model->getAllModels();
        $this->view->i = $this->request->get('i');
    }

    /**
     * load all fields in model
     */
    public function load_relmodelfieldsAction()
    {
        $this->view->setTemplateAfter('ajax');

        $model_name = $this->request->get('model_name');
        $model = $this->getModel($model_name);
        $fields = $model->allFields();

        // options fields
        $options_fields = '<option value="id">id</option>';
        foreach ($fields['fields'] as $field => $options) {
            $options_fields .= '<option value="' . $field . '">' . $field . '</option>';
        }
        $this->view->options_fields = $options_fields;

        // list view for subpanel
        $this->view->fields = $fields['fields'];

        // view
        $this->view->model_name = $model_name;
        $this->view->type = $this->request->get('type');
        $this->view->field_types = $model->getFieldTypes();
        $this->view->i = $this->request->get('i');
    }

    /**
     * import csv
     */
    public function import_csvAction($model_name = null)
    {
        if ($this->request->isPost()) {
            $this->view->disable();
            $posts = $this->request->getPost();

            $csvObj = new CsvHelper($posts['full_path_csv_file'], true, ",");
            $data = $csvObj->get(0, $posts['change_fields']);

            if ($posts['model']) {
                $message = '';
                foreach ($data as $d) {
                    $model = $this->getModel($posts['model']);
                    $model->id = null;
                    foreach ($d as $field => $value) {
                        $model->$field = $value;
                    }

                    if ($model->create()) {
                        $message[] = 'Success: ' . implode(', ', $d);
                    } else {
                        $msg = '';
                        foreach ($model->getMessages() as $m) {
                            $msg .= $this->t->_((string)$m) . ' | ';
                        }
                        $message[] = 'Error: ' . $msg . 'Detail: ' . implode(', ', $d);
                    }
                }

                $this->flash->notice(implode('<br>', $message));
            }

            $this->backendRedirect('/builder/import_csv');
        }

        if ($model_name) {
            $this->view->title = $this->t->_('Import CSV: ') . $model_name;
        } else {
            $this->view->title = $this->t->_('Choose module import');
        }

        $models = array();
        $model_path = APP_PATH . '/apps/backend/models/*.php';

        foreach (glob($model_path) as $model) {
            $name = basename($model, '.php');
            if ($name != 'ModelBase' && $name != 'CaroLogs') {
                $models[$name] = $name;
            }
        }

        $this->view->models = $models;
    }

    /**
     * load import UI
     */
    public function load_csv_importAction()
    {
        $this->view->setTemplateAfter('empty');

        $file_path = $this->request->getPost('csv_file');

        // get header csv file
        $csvObj = new CsvHelper($file_path, true, ",");
        $this->view->header = $csvObj->getHeader();

        // get all fields
        $model = $this->getModel($this->request->getPost('model'));
        $table = $model->getSource();

        if (is_file(APP_PATH . 'apps/config/database_structures.ini.php')) {
            $databases = include APP_PATH . 'apps/config/database_structures.ini.php';
        } else {
            $databases = include APP_PATH . 'apps/config/database_structures.php';
        }

        $fields = ['id' => 'id'];
        foreach ($databases[$table]['fields'] as $field => $options) {
            $fields[$field] = $field;
        }

        $this->view->fields = $fields;
    }
}