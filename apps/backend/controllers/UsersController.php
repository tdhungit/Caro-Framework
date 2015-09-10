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

use Modules\Backend\Models\AuthRoles;

class UsersController extends ControllerCustom
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
        $this->action_edit = 'edit_group';
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
                'label' => $this->t->_('Edit'),
                'link' => $this->url->backendUrl('/users/edit_role/<ID>'),
                'icon' => 'fa-edit',
            ),
            array(
                'label' => $this->t->_('Set Permissions'),
                'link' => $this->url->backendUrl('/users/set_permissions/<ID>'),
                'icon' => 'fa-cog',
            ),
            array(
                'label' => $this->t->_('Delete'),
                'link' => $this->url->backendUrl('/users/delete_role/<ID>'),
                'icon' => 'fa-remove',
            ),
        );
        $this->indexAction();
    }

    public function register_rolesAction()
    {
        $this->view->disable();
        $roles = AuthRoles::find("deleted = 0 AND status = 'Active'");
        $write_roles = "";
        foreach ($roles as $role) {
            $write_roles .= "'{$role->unique_name}' => new Role('$role->unique_name'),\n";
        }

        $write_roles = "<?php\nuse Phalcon\\Acl\\Role;\nreturn array(\n$write_roles);";

        $file = fopen(AuthRoles::rolesPath(), "w");
        fwrite($file, "$write_roles");
        fclose($file);

        $this->flash->success($this->t->_('Register success'));
        $this->backendRedirect('/settings');
    }

    public function detail_roleAction($id = null)
    {
        $this->model_name = 'AuthRoles';
        $this->action_detail = 'detail_role';
        $this->action_edit = 'edit_role';
        $this->detailAction($id);
    }

    public function edit_roleAction($id = null)
    {
        $this->model_name = 'AuthRoles';
        $this->action_detail = 'detail_role';
        $this->editAction($id);
    }

    public function set_permissionsAction($role_id = null) {
        // get all resources
        $resources = include AuthRoles::resourcesPath();

        // save permission
        if ($this->request->isPost()) {
            $role_id = $this->request->getPost('role_id');
            if ($role_id) {
                // get Role
                $focus_role = AuthRoles::findFirst($role_id);
                $role_unique_name = $focus_role->unique_name;
                // set resource setting
                $set_resources = $this->request->getPost('resources');
                // generate save resource
                $save_resources = array();
                $allow_resources = array();
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
                        // allow_resource
                        if ($is_access == 1) {
                            $allow_resources[$resource][] = $method;
                        }
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
                $file = fopen(AuthRoles::permissionSavePath() . 'role_' . $role_unique_name . '.php', "w");
                fwrite($file, "<?php\n return " . var_export($save_resources, true) . ";\n");
                fclose($file);

                $file = fopen(AuthRoles::permissionSavePath() . 'role_allow_' . $role_unique_name . '.php', "w");
                fwrite($file, "<?php\n return " . var_export($allow_resources, true) . ";\n");
                fclose($file);

                $this->flash->success($this->t->_('Save role success'));
                $this->backendRedirect('/users/set_permissions/' . $role_id);
            }
        }

        // get all roles
        $role_model = $this->getModel('AuthRoles');
        $role = $role_model::findFirst($role_id);
        $role_unique_name = $role->unique_name;
        $other_roles = $role_model::find("deleted = 0 AND id <> $role_id");

        // set exists permission
        if (is_file(AuthRoles::permissionSavePath() . 'role_allow_' . $role_unique_name . '.php')) {
            $allowed_resources = include AuthRoles::permissionSavePath() . 'role_allow_' . $role_unique_name . '.php';
        }

        $current_resources = array();
        foreach($resources as $resource => $access) {
            foreach($access as $method) {
                if (in_array($method, $allowed_resources[$resource])) {
                    $current_resources[$resource][$method] = 1;
                } else {
                    $current_resources[$resource][$method] = 0;
                }
            }
        }

        $this->view->role_id = $role_id;
        $this->view->role = $role;
        $this->view->other_roles = $other_roles;
        $this->view->resources = $current_resources;
    }
}