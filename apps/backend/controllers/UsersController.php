<?php
/**
 * Created by Jacky.
 * User: Jacky
 * E-Mail: jacky@carocrm.com or jacky@youaddon.com
 * Date: 7/24/2015
 * Time: 4:58 PM
 * Project: carofw
 * File: UsersController.php
 */

namespace Modules\Backend\Controllers;

class UsersController extends ControllerBase
{
    protected $model_name = 'Users';

    public function indexAction()
    {
        $this->listAction();
    }

    public function groupsAction()
    {
        $this->model_name = 'UserGroups';
        $this->action_detail = 'detail_group';
        $this->indexAction();
    }

    public function detail_groupAction($id = null)
    {
        $this->model_name = 'UserGroups';
        $this->detailAction($id);
    }

    public function edit_groupAction($id = null)
    {
        $this->model_name = 'UserGroups';
        $this->action_detail = 'detail_group';
        $this->editAction($id);
    }

    public function rolesAction()
    {
        $this->model_name = 'AuthRoles';
        $this->action_detail = 'detail_role';
        $this->link_action = array(
            array(
                'link' => $this->url->get('/admin/users/edit_role/<ID>'),
                'icon' => 'icon-edit',
            ),
            array(
                'link' => $this->url->get('/admin/users/set_permissions/<ID>'),
                'icon' => 'icon-cog',
            ),
            array(
                'link' => $this->url->get('/admin/users/delete_role/<ID>'),
                'icon' => 'icon-remove',
            ),
        );
        $this->indexAction();
    }

    public function detail_roleAction($id = null)
    {
        $this->model_name = 'AuthRoles';
        $this->action_detail = 'detail_role';
        $this->detailAction($id);
    }

    public function edit_roleAction($id = null)
    {
        $this->model_name = 'AuthRoles';
        $this->editAction($id);
    }

    public function set_permissionsAction($role_id = null) {
        $permission_save_path = APP_PATH . '/apps/backend/permissions/';
        // get all resources
        $resources = include $permission_save_path . 'resources.php';

        // save permission
        if ($this->request->isPost()) {
            $role_id = $this->request->getPost('role_id');
            if ($role_id) {
                // set resource setting
                $set_resources = $this->request->getPost('resources');
                // generate save resource
                $save_resources = array();
                foreach ($resources as $resource => $access) {
                    // resource default no access
                    // modify set access resource
                    foreach ($access as $method) {
                        $is_access = 0;
                        if (!empty($set_resources[$resource][$method])) {
                            $is_access = $set_resources[$resource][$method];
                        }
                        // override
                        $save_resources[$resource][$method] = $is_access;
                    }
                }
                // save to file permission
                // filename: role_<role_id>.php
                // structure:
                // return array(
                //  <resource> => array(
                //      <action> => 0|1
                //      <action> => 0|1
                //  )
                // )
                $file = fopen($permission_save_path . 'role_' . $role_id . '.php', "w");
                fwrite($file, "<?php\n return " . var_export($save_resources, true) . ";\n");
                fclose($file);

                $this->response->redirect('/admin/users/set_permissions/' . $role_id);
            }
        }

        // set exists permission
        if (is_file($permission_save_path . 'role_' . $role_id . '.php')) {
            $current_resources = include $permission_save_path . 'role_' . $role_id . '.php';
        } else { // not set permission
            $current_resources = array();
            foreach($resources as $resource => $access) {
                foreach($access as $method) {
                    $current_resources[$resource][$method] = 0;
                }
            }
        }

        $this->view->role_id = $role_id;
        $this->view->resources = $current_resources;
    }
}