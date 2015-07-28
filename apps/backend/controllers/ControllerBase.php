<?php

namespace Modules\Backend\Controllers;

use Phalcon\Dispatcher;
use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    protected $model_name;

    protected $controller_name;
    protected $action_name;
    protected $action_detail = 'detail';

    protected function initialize()
    {
        $this->tag->prependTitle('Caro Framework | ');
    }

    public function beforeExecuteRoute(Dispatcher $dispatcher)
    {
        $this->controller_name = $dispatcher->getControllerName();
        $this->action_name = $dispatcher->getActionName();
    }

    /**
     * get model
     *
     * @return null
     */
    protected function getModel()
    {
        if ($this->model_name) {
            $model_path = '\\Modules\Backend\Models\\' . $this->model_name;
            $model = new $model_path();
            if (empty($model->menu)) {
                $model->menu = array(
                    'View ' . ucfirst($this->controller_name) => '/admin/' . $this->controller_name . '/list',
                    'Create ' . ucfirst($this->controller_name) => '/admin/' . $this->controller_name . '/edit'
                );
            }
            return $model;
        }

        return null;
    }

    // BASE ACTION //
    /**
     * List
     */
    public function listAction()
    {
        $model = $this->getModel();

        if (is_null($model)) {
            $this->response->redirect('/admin/dashboard');
        }

        $list_data = $model::find();

        $this->view->data = $list_data;
        $this->view->list_view = $model->list_view;

        $controller = strtolower($this->controller_name);
        $action = strtolower($this->action_name);

        $this->view->controller = $controller;
        $this->view->action = $action;
        $this->view->action_detail = $this->action_detail;
        $this->view->menu = $model->menu;

        $exists = $this->view->exists($controller . '/' . $action);
        if (!$exists) {
            $this->view->pick('view_default/list');
        }
    }

    /**
     * Detail
     */
    public function detailAction($id = null)
    {
        $data = null;

        $model = $this->getModel();
        if ($id) {
            $data = $model::findFirst($id);
        }

        $this->view->detail_view = $model->detail_view;
        $this->view->data = $data;

        $controller = strtolower($this->controller_name);
        $action = strtolower($this->action_name);

        $this->view->controller = $controller;
        $this->view->action = $action;
        $this->view->menu = $model->menu;

        $exists = $this->view->exists($controller . '/' . $action);
        if (!$exists) {
            $this->view->pick('view_default/detail');
        }
    }

    /**
     * Edit
     */
    public function editAction($id = null)
    {
        // get model
        $model = $this->getModel();

        // save data
        if ($this->request->isPost()) {
            $post_id = $this->request->getPost('id');
            if (!empty($post_id)) {
                $data = $model::findFirst($id);
            }

            // set data
            foreach ($model->edit_view['fields'] as $field => $opt) {
                $model->$field = $this->request->getPost($field);
            }

            // save
            if ($model->save() == false) {
                $msg = '';
                foreach ($model->getMessages() as $message) {
                    $msg .= $message . '<br>';
                }
                $this->flash->error($msg);
            } else {
                $this->flash->success("Great, a new {$this->controller_name} was saved successfully!");
            }

            $this->response->redirect('/admin/' . $this->controller_name . '/' . $this->action_name);
        }

        // edit view data
        $data = null;

        if ($id) {
            $data = $model::findFirst($id);
        }

        $this->view->edit_view = $model->edit_view;
        $this->view->data = $data;

        $controller = strtolower($this->controller_name);
        $action = strtolower($this->action_name);

        $this->view->controller = $controller;
        $this->view->action = $action;
        $this->view->menu = $model->menu;

        $exists = $this->view->exists($controller . '/' . $action);
        if (!$exists) {
            $this->view->pick('view_default/edit');
        }
    }

}
