<?php
/**
 * Created by Jacky.
 * User: Jacky
 * File: BuilderController.php
 * Project: Caro-Framework
 */

namespace Modules\Backend\Controllers;


class BuilderController extends ControllerCustom
{
    public $types = array(
        'int', 'date', 'varchar', 'decimal', 'datetime', 'char', 'text', 'float', 'boolean', 'double', 'tinyblob', 'blob', 'mediumblob', 'longblob', 'bigint', 'json', 'jsonb'
    );

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

    public function indexAction()
    {
        $models = array();
        $model_path = APP_PATH . '/apps/backend/models/*.php';

        foreach (glob($model_path) as $model) {
            $name = basename($model, '.php');
            if ($name != 'ModelBase' && $name != 'ModelCustom' && $name != 'CaroLogs') {
                $models[] = $name;
            }
        }

        $this->view->models = $models;
    }

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

    public function ajax_add_fieldAction($name, $type, $size, $notnull)
    {
        $this->view->types = $this->types;
        $this->view->field_name = $name;
        $this->view->field_type = $type;
        $this->view->field_size = $size;
        $this->view->notnull = $notnull;

        $this->view->setTemplateAfter('ajax');
    }

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
                        'type' => (int) $field['type'],
                        'size' => (int) $field['size'],
                        'notNull' => (bool) $field['notnull']
                    );
                }
            }

            $databases[$table]['indexes'] = array();
            if ($indexes) {
                foreach($indexes as $index) {
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

    public function create_modelAction()
    {
        if ($this->request->isPost()) {
            $model_name = $this->request->getPost('model_name');
            if ($model_name) {
                $model_file = APP_PATH . "apps/backend/models/$model_name.php";

                if (is_file($model_file)) {
                    $this->flash->error('Exits this model!');
                } else {
                    if (is_file(APP_PATH . 'apps/config/database_structures.ini.php')) {
                        $databases = include APP_PATH . 'apps/config/database_structures.ini.php';
                    } else {
                        $databases = include APP_PATH . 'apps/config/database_structures.php';
                    }

                    $databases[strtolower($model_name)] = array(
                        'fields' => array(),
                        'indexes' => array(),
                    );

                    // write db
                    $file = fopen(APP_PATH . "apps/config/database_structures.ini.php", "w");
                    fwrite($file, "<?php\n\n return " . var_export($databases, true) . ";\n");
                    fclose($file);

                    // write model
                    $file = fopen($model_file, "w");
                    $content = "<?php\n\nnamespace Modules\Backend\Models;\n\nclass $model_name extends ModelCustom \n{\n\n}";
                    fwrite($file, $content);
                    fclose($file);

                    // write controller
                    $controller_file = APP_PATH . "apps/backend/controllers/{$model_name}Controller.php";
                    if (!is_file($controller_file)) {
                        $file = fopen($controller_file, "w");
                        $content = "<?php\n\nnamespace Modules\Backend\Controllers;\n\nclass {$model_name}Controller extends ControllerCustom \n{\n\tprotected \$model_name = '$model_name';\n\n\tpublic function indexAction()\n\t{\n\t\t\$this->listAction();\n\t}\n}";
                        fwrite($file, $content);
                        fclose($file);
                    }
                }

                $this->backendRedirect('/builder');
            }
        }
    }

    public function edit_layoutAction($model_name = null)
    {
        if ($this->request->isPost()) {
            $model_name = $this->request->getPost('model_name');
            //$model = $this->getModel($model_name);

            $fields = $this->request->getPost('fields');

            $list_view = array();
            $edit_view = array();
            $detail_view = array();
            foreach ($fields as $field => $options) {
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

                    if (!empty($options['list'])) {
                        $list_view['fields'][$field] = $options;
                    }

                    if (!empty($options['edit'])) {
                        $edit_view['title'] = 'name';
                        $edit_view['fields'][$field] = $options;
                    }

                    if (!empty($options['detail'])) {
                        $detail_view['title'] = 'name';
                        $detail_view['fields'][$field] = $options;
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

        $model = $this->getModel($model_name);
        $fields = $model->allFields();
        
        $this->view->model_name = $model_name;
        // all fields
        $this->view->fields = $fields['fields'];
        // selected fields
        $this->view->list_fields = array_merge($model->list_view, $model->edit_view, $model->detail_view);
        // all type
        $this->view->types = array(
            'text' => 'Text',
            'number' => 'Number',
            'select' => 'Select',
            'image' => 'Image',
            'relate' => 'Relate',
            'textarea' => 'TextArea',
            'note' => 'Note'
        );
        // all model
        $this->view->all_models = $model->getAllModels();
        // all list dropdown
        $all_lists = array();
        foreach ($this->carofw['app_list_strings'] as $list_dropdown => $value) {
            $all_lists[$list_dropdown] = $list_dropdown;
        }
        $this->view->all_lists = $all_lists;
    }
}