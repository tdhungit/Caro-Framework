<?php

namespace Modules\Backend\Controllers;

use Modules\Backend\Models\Users;

class IndexController extends ControllerBase
{

    private function _setSessionUser($user)
    {
        $this->session->set('auth', array(
            'id'    => $user->id,
            'name'  => $user->name
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
