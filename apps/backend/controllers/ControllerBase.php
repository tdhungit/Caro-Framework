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

    protected $t;

    protected function initialize()
    {
        $this->tag->prependTitle('Caro Framework | ');
        $this->view->setVar('carofw', $this->carofw);
        $this->view->setVar('main_title', $this->model_name);
    }

    public function beforeExecuteRoute(Dispatcher $dispatcher)
    {
        $this->controller_name = $dispatcher->getControllerName();
        $this->action_name = $dispatcher->getActionName();
    }

    /**
     * get Model
     *
     * @param null|string $model_name
     * @return null
     */
    protected function getModel($model_name = null)
    {
        if ($model_name) {
            $this->model_name = $model_name;
        }

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

    /**
     * Return Json
     *
     * @param $data
     */
    protected function resJson($data)
    {
        $this->response->setContentType('application/json', 'UTF-8');
        $this->view->disable();
        echo json_encode($data);
    }

    /**
     * @param array $defs
     * @param Object $data
     * @return array
     */
    protected function getSubpanels($defs, $data)
    {
        $subpanels = array();
        foreach ($defs as $name => $def) {
            $subpanels[$name] = $this->getSubpanel($def, $data);
        }
        return $subpanels;
    }

    /**
     * @param array $def
     * @param Object $data
     * @return array
     */
    protected function getSubpanel($def, $data)
    {
        $panel = array();
        if ($def['type'] == 'one-many') {
            $rel_model = $this->getModel($def['rel_model']);
            $panel = $rel_model::find($def['rel_field'] .'=' . $data->id);

        } else if ($def['type'] == 'many-many') {
            $namespace = 'Modules\Backend\Models\\';

            $current_model = $namespace . $def['current_model'];
            $current_field = $current_model . '.' . $def['current_field'];

            $rel_model = $namespace . $def['rel_model'];
            $rel_field = $rel_model . '.' . $def['rel_field'];

            $mid_model = $namespace . $def['mid_model'];
            $mid_field1 = $mid_model . '.' . $def['mid_field1'];
            $mid_field2 = $mid_model . '.' . $def['mid_field2'];

            $panel = $this->modelsManager->createBuilder()
                ->from($rel_model)
                ->join($mid_model, $mid_field2 . '=' . $rel_field)
                ->join($current_model, $current_field . '=' . $mid_field1)
                ->where($current_field . '=' . $data->id)
                ->getQuery()->execute();
        }
        return $panel;
    }

    protected function getTranslation()
    {

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
            // check subpanel
            $supanels = null;
            if (!empty($model->detail_view['subpanels'])) {
                $supanels = $this->getSubpanels($model->detail_view['subpanels'], $data);
            }
        }

        if ($data == null) {
            $this->response->redirect('/admin/' . $this->controller_name);
        }

        $this->view->detail_view = $model->detail_view;
        $this->view->data = $data;
        $this->view->subpanels = $supanels;

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
                $data = $model::findFirst($post_id);
                // update data
                foreach ($model->edit_view['fields'] as $field => $opt) {
                    $data->$field = $this->request->getPost($field);
                }

                if ($data->update() == false) {
                    $this->flash->error("Fail, update {$this->controller_name} was not saved successfully!");
                } else {
                    $this->flash->success("Great, update {$this->controller_name} was saved successfully!");
                    $id = $post_id;
                }

            } else {
                // set save data
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
                    $id = $model->id;
                    $this->flash->success("Great, a new {$this->controller_name} was saved successfully!");
                }
            }

            $this->response->redirect('/admin/' . $this->controller_name . '/' . $this->action_detail . '/' . $id);
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

    /**
     * Popup
     *
     * @param $rel_model
     * @param $current_model
     * @param $current_id
     * @param $subpanel_name
     */
    public function popupAction($rel_model, $current_model, $current_id, $subpanel_name)
    {
        $this->view->setTemplateAfter('ajax');
        $model = $this->getModel($rel_model);
        $data = $model::find();

        $this->view->data = $data;
        $this->view->list_view = $model->list_view;

        $controller = strtolower($this->controller_name);
        $action = strtolower($this->action_name);

        $this->view->rel_model = $rel_model;
        $this->view->current_model = $current_model;
        $this->view->current_id = $current_id;
        $this->view->subpanel_name = $subpanel_name;

        $exists = $this->view->exists($controller . '/' . $action);
        if (!$exists) {
            $this->view->pick('view_default/popup');
        }
    }

    /**
     * Save relate record
     */
    public function save_relateAction()
    {
        $this->view->disable();

        if ($this->request->isPost()) {
            $rel_model = $this->request->getPost('rel_model');
            $rel_id = $this->request->getPost('rel_id');
            $current_model = $this->request->getPost('current_model');
            $current_id = $this->request->getPost('current_id');
            $subpanel_name = $this->request->getPost('subpanel_name');
            $func = $this->request->getPost('func');

            if ($rel_model && $rel_id
                && $current_model && $current_id
                && $subpanel_name
            ) {
                $focus = $this->getModel($current_model);
                $subpanel_def = $focus->detail_view['subpanels'][$subpanel_name];
                $type = $subpanel_def['type'];

                if ($type == 'one-many') {
                    $save_model = $this->getModel($rel_model);
                    $save_data = $save_model::findFirst($rel_id);
                    $save_data->$subpanel_def['rel_field'] = $current_id;

                    if ($func == 'ins' && $save_data->update() == false) {
                        $this->flash->error('Save relate error!');
                    }

                    if ($func == 'del' && $save_data->delete() == false) {
                        $this->flash->error('Remove relate error!');
                    }

                } else if ($type == 'many-many') {
                    $mid_model = $this->getModel($subpanel_def['mid_model']);
                    $mid_model->$subpanel_def['mid_field1'] = $current_id;
                    $mid_model->$subpanel_def['mid_field2'] = $rel_id;

                    if ($func == 'ins' && $mid_model->save() == false) {
                        $this->flash->error('Save relate error!');
                    }

                    if ($func == 'del') {
                        $mid_data = $mid_model::findFirst(array(
                            $subpanel_def['mid_field1'] . '=' . $current_id,
                            $subpanel_def['mid_field2'] . '=' . $rel_id
                        ));
                        if ($mid_data->delete() == false) {
                            $this->flash->error('Remove relate error!');
                        }
                    }

                }
            }
        }
    }

}
