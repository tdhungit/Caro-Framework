<?php

namespace Modules\Backend\Controllers;

use Phalcon\Dispatcher;
use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    protected $model_name;
    protected $list_view;
    protected $edit_view;
    protected $detail_view;

    protected $controller_name;
    protected $action_name;

    protected function initialize()
    {
        $this->tag->prependTitle('Caro Framework | ');
    }

    public function beforeExecuteRoute(Dispatcher $dispatcher)
    {
        $this->controller_name = $dispatcher->getControllerName();
        $this->action_name = $dispatcher->getActionName();
    }

    protected function getModel()
    {
        if ($this->model_name) {
            $model = '\\Modules\Backend\Models\\' . $this->model_name;
            return new $model();
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
        $this->view->list_view = $this->list_view;

        $controller = strtolower($this->controller_name);
        $action = strtolower($this->action_name);

        $this->view->controller = $controller;
        $this->view->action = $action;

        $exists = $this->view->exists($controller . '/' . $action);
        if (!$exists) {
            $this->view->pick('view_default/list');
        }
    }

    /**
     * Detail
     */
    public function detailAction($id)
    {
        $data = null;

        $model = $this->getModel();
        if ($id) {
            $data = $model::findFirst("id = $id");
        }

        $this->view->edit_view = $this->edit_view;
        $this->view->data = $data;

        $controller = strtolower($this->controller_name);
        $action = strtolower($this->action_name);

        $this->view->controller = $controller;
        $this->view->action = $action;

        $exists = $this->view->exists($controller . '/' . $action);
        if (!$exists) {
            $this->view->pick('view_default/detail');
        }
    }

    /**
     * Edit
     */
    public function editAction()
    {

    }

}
