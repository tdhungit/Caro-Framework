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

use Modules\Backend\Models\UserGroupsUsers;
use Modules\Backend\Models\Users;

class IndexController extends ControllerBase
{

    private function _setSessionUser($user)
    {
        $groups = UserGroupsUsers::find("user_id = '{$user->id}'");

        $this->session->set('auth', array(
            'id'    => $user->id,
            'name'  => $user->name,
            'groups' => $groups
        ));
    }

    public function indexAction()
    {
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
                return $this->response->redirect('/admin/dashboard');
            } else {
                $this->flash->error('Wrong email/password');
                return $this->response->redirect('/admin');
            }
        }

        $this->view->setTemplateAfter('empty');
    }
}
