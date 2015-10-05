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

        $databases = include APP_PATH . 'apps/config/database_structures.php';
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

        $databases = include APP_PATH . 'apps/config/database_structures.php';
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

            $databases = include APP_PATH . 'apps/config/database_structures.php';

            $databases[$table]['fields'] = array();
            foreach ($fields as $field) {
                $databases[$table]['fields'][$field['name']] = array(
                    'type' => $field['type'],
                    'size' => $field['size'],
                    'notNull' => $field['notnull']
                );
            }

            $databases[$table]['indexes'] = array();
            foreach($indexes as $index) {
                $databases[$table]['indexes'][$index['name']] = array(
                    'type' => $index['type'],
                    'fields' => explode(',', $index['fields'])
                );
            }

            $file = fopen(APP_PATH . "apps/config/database_structures.php", "w");
            fwrite($file, "<?php\n\n use \\Phalcon\\Db\\Column as Column; \n\nreturn " . var_export($databases, true) . ";\n");
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
                    $databases = include APP_PATH . 'apps/config/database_structures.php';
                    $databases[strtolower($model_name)] = array(
                        'fields' => array(),
                        'indexes' => array(),
                    );

                    // write db
                    $file = fopen(APP_PATH . "apps/config/database_structures.php", "w");
                    fwrite($file, "<?php\n\n use \\Phalcon\\Db\\Column as Column; \n\nreturn " . var_export($databases, true) . ";\n");
                    fclose($file);

                    // write model
                    $file = fopen($model_file, "w");
                    $content = "<?php\n\nnamespace Modules\Backend\Models;\n\nclass $model_name extends ModelCustom \n{\n\n}";
                    fwrite($file, $content);
                    fclose($file);
                }

                $this->backendRedirect('/builder');
            }
        }
    }
}