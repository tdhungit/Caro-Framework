<?php
/**
 * Created by Jacky.
 * User: Jacky
 * E-Mail: jacky@carocrm.com or jacky@youaddon.com
 * Date: 8/4/2015
 * Time: 1:27 PM
 * Project: carofw
 * File: IndexController.php
 */

namespace Modules\Backend\Controllers;


use Modules\Backend\Models\AuthRoles;
use Modules\Backend\Models\UserGroups;
use Modules\Backend\Models\UserGroupsUsers;
use Modules\Backend\Models\Users;

class IndexController extends ControllerCustom
{

    private function _setSessionUser($user)
    {
        $roles = array();
        if ($user->username != 'admin') {
            try {
                $group_ids = UserGroupsUsers::find("user_id = '{$user->id}'");
                foreach ($group_ids as $group_id) {
                    $group = UserGroups::findFirst($group_id);
                    if ($group) {
                        $role = AuthRoles::findFirst($group->role_id);
                        $roles[$role->unique_name] = $role->unique_name;
                    }
                }
            } catch (\ErrorException $e) {
            }
        }

        $this->session->set('auth', array(
            'id'    => $user->id,
            'username' => $user->username,
            'email' => $user->email,
            'roles' => $roles
        ));
    }

    public function indexAction()
    {
        // auth
        $auth = $this->session->get('auth');
        if ($auth) {
            $this->backendRedirect('/dashboard');
        }

        if ($this->request->isPost()) {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            $user = Users::findFirst(array(
                "(username = :username: OR email = :username:) AND password = :password: AND status = 'Active'",
                'bind' => array('username' => $username, 'password' => md5($password))
            ));

            if ($user != false) {
                $this->_setSessionUser($user);
                $this->flash->success('Welcome ' . $user->name);
                return $this->backendRedirect('/dashboard');
            } else {
                $this->flash->error('Wrong email/password');
                return $this->backendRedirect();
            }
        }

        $this->view->setTemplateAfter('empty');
    }

    public function logoutAction()
    {
        $this->session->destroy();
        $this->response->redirect();
        $this->backendRedirect();
    }
}
