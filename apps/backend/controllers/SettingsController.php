<?php
/**
 * Created by Jacky.
 * User: Jacky
 * E-Mail: jacky@carocrm.com or jacky@youaddon.com
 * Date: 7/24/2015
 * Time: 4:58 PM
 * Project: carofw
 * File: SettingsController.php
 */

namespace Modules\Backend\Controllers;

use Modules\Backend\Models\Settings;
use Modules\Core\MyMail;
use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Text;

class SettingsController extends ControllerCustom
{
    protected $model_name = 'Settings';

    public function indexAction()
    {

    }

    /**
     * Repair database
     * read database structure from config/database_structures.php
     * generate to database
     */
    public function repairAction()
    {
        if (is_file(__DIR__ . "/../../config/database_structures.ini.php")) {
            $tables = include  __DIR__ . "/../../config/database_structures.ini.php";
        } else {
            $tables = include __DIR__ . "/../../config/database_structures.php";   
        }

        foreach ($tables as $table_name => $table_data) {
            $exists = $this->db->tableExists($table_name);

            if ($exists) {
                $current_fields = $this->db->describeColumns($table_name);
                foreach ($table_data['fields'] as $field_name => $options) {
                    $exists_field = true;
                    foreach ($current_fields as $c_field) {
                        if ($c_field->getName() == $field_name) {
                            $exists_field = true;
                            break;
                        } else {
                            $exists_field = false;
                        }
                    }

                    if ($exists_field == true) {
                        $this->db->modifyColumn($table_name, null, new Column($field_name, $options));
                    } else {
                        $this->db->addColumn($table_name, null, new Column(
                            $field_name, $options));
                    }
                }

                $current_indexes = $this->db->describeIndexes($table_name);
                foreach ($table_data['indexes'] as $index => $index_data) {
                    $create_index = true;
                    foreach ($current_indexes as $c_index => $c_index_fields) {
                        if ($index == $c_index) {
                            if (
                                $index_data['fields'] != $c_index_fields->getColumns()
                                || $index_data['type'] != $c_index_fields->getType()) {
                                $this->db->dropIndex($table_name, null, $c_index);
                                $create_index = true;
                            } else {
                                $create_index = false;
                            }
                        }
                    }

                    if ($create_index == true) {
                        if (strtolower($index_data['type']) == 'index') {
                            $this->db->addIndex($table_name, null, new Index($index, $index_data['fields']));
                        } else {
                            $this->db->addIndex($table_name, null, new Index($index, $index_data['fields'], $index_data['type']));
                        }
                    }
                }

            } else {
                $new_columns = array(
                    'columns' => array(
                        new Column(
                            'id',
                            array(
                                'type' => Column::TYPE_INTEGER,
                                'size' => 10,
                                'notNull' => true,
                                'autoIncrement' => true,
                                'unsigned' => true
                            )
                        ),
                        new Column(
                            'created',
                            array(
                                'type' => Column::TYPE_DATETIME,
                                'notNull' => true,
                            )
                        ),
                        new Column(
                            'user_created_id',
                            array(
                                'type' => Column::TYPE_INTEGER,
                                'size' => 10,
                                'notNull' => true
                            )
                        ),
                        new Column(
                            'deleted',
                            array(
                                'type' => Column::TYPE_INTEGER,
                                'size' => 1,
                                'notNull' => true,
                                'default' => 0
                            )
                        )
                    ),
                    'indexes' => array(
                        new Index('PRIMARY', array('id'))
                    )
                );

                foreach($table_data['fields'] as $field_name => $options) {
                    $new_columns['columns'][] = new Column($field_name, $options);
                }

                foreach($table_data['indexes'] as $index => $index_data) {
                    if (strtolower($index_data['type']) == 'index') {
                        $new_columns['indexes'][] = new Index($index, $index_data['fields']);
                    } else {
                        $new_columns['indexes'][] = new Index($index, $index_data['fields'], $index_data['type']);
                    }
                }

                $this->db->createTable($table_name, null, $new_columns);
            }
        }

        $this->flash->success('Repair success!');
        $this->backendRedirect('/settings');
    }

    /**
     * Rebuild cache resource permission (controller/action)
     * all controller action will write in cache
     * in config backend/config/resources.php
     * structure
     * return array(
     *   '<controller> => array(
     *      <action>
     *      <action>
     *  )
     * )
     */
    public function rebuild_resourcesAction()
    {
        $this->view->disable();
        $resources = $this->_getAllResources();

        if (!empty($resources)) {
            $file = fopen(APP_PATH . "apps/backend/permissions/resources.php", "w");
            fwrite($file, "<?php\n return " . var_export($resources, true) . ";\n");
            fclose($file);
        }

        $this->flash->success($this->t->_('Rebuild Resources success'));
        $this->backendRedirect('/settings');
    }

    /**
     * scan folder controllers and get all controller in here
     * @return array array(
     *  <controller> => (
     *      <action>
     *      <action>
     *  )
     * )
     */
    private function _getAllResources()
    {
        $controllers = array();
        $controller_path = APP_PATH . '/apps/backend/controllers/*Controller.php';

        foreach (glob($controller_path) as $controller) {
            $name = basename($controller, '.php');
            $className = 'Modules\Backend\Controllers\\' . $name;
            $resource = strtolower(str_replace('Controller', '', $name));
            $controllers[$resource] = [];
            $methods = (new \ReflectionClass($className))->getMethods(\ReflectionMethod::IS_PUBLIC);

            foreach ($methods as $method) {
                if (Text::endsWith($method->name, 'Action')) {
                    $controllers[$resource][] = str_replace('Action', '', $method->name);
                }
            }
        }

        return $controllers;
    }

    /**
     * Page Send Mail config
     */
    public function mail_configAction()
    {
        $data = null;
        $mail_config = Settings::findFirst("name = 'mail_config'");
        if ($mail_config && $mail_config->value) {
            $data = json_decode($mail_config->value);
        }

        $this->view->data = $data;

        if ($this->request->isPost()) {
            // get data from form
            $from_name = $this->request->getPost('from_name');
            $from_email = $this->request->getPost('from_email');
            $smtp_server = $this->request->getPost('smtp_server');
            $smtp_port = $this->request->getPost('smtp_port');
            $smtp_security = $this->request->getPost('smtp_security');
            $smtp_username = $this->request->getPost('smtp_username');
            $smtp_password = $this->request->getPost('smtp_password');
            $smtp_test = $this->request->getPost('smtp_test');

            // check data
            if (!$from_name || !$from_email || !$smtp_server) {
                $this->flash->error($this->t->_('Please input data'));
                $this->backendRedirect('/settings/mail_config');
            }

            // default port
            if (!$smtp_port) {
                $smtp_port = 25;
            }
            // default not security
            if (!$smtp_security) {
                $smtp_security = 0;
            }

            // send test mail
            if ($smtp_test == '1') {
                $email = new MyMail();
                $email->setMailSettings(array(
                    'fromName' => $from_name,
                    'fromEmail' => $from_email,
                    'smtp' => array(
                        'server' => $smtp_server,
                        'port' => $smtp_port,
                        'security' => $smtp_security,
                        'username' => $smtp_username,
                        'password' => $smtp_password
                    )
                ));

                try {
                    $email->send($from_email, 'Caro Framework Send Test Mail', 'Caro Framework Send Test Mail');
                    $this->flash->warning($this->t->_('Please check your email to see mail test.') . ' Email: ' . $from_email);
                } catch (\Swift_SwiftException $e) {
                    $this->flash->error($e->getMessage());
                }

                $this->backendRedirect('/settings/mail_config');

            } else {
                // create/update settings
                if ($mail_config) {
                    $mail_config->name = 'mail_config';
                    $mail_config->value = json_encode(array(
                        'from_name' => $from_name,
                        'from_email' => $from_email,
                        'smtp_server' => $smtp_server,
                        'smtp_port' => $smtp_port,
                        'smtp_security' => $smtp_security,
                        'smtp_username' => $smtp_username,
                        'smtp_password' => $smtp_password,
                    ));
                    $mail_config->update();

                } else {
                    $settings = new Settings();
                    $settings->name = 'mail_config';
                    $settings->value = json_encode(array(
                        'from_name' => $from_name,
                        'from_email' => $from_email,
                        'smtp_server' => $smtp_server,
                        'smtp_port' => $smtp_port,
                        'smtp_security' => $smtp_security,
                        'smtp_username' => $smtp_username,
                        'smtp_password' => $smtp_password,
                    ));
                    $settings->save();
                }

                $this->flash->success($this->t->_('Update mail server is success'));
                $this->backendRedirect('/settings/mail_config');
            }
        }
    }

}