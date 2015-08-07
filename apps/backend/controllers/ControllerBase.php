<?php
/**
 * Created by Jacky.
 * User: Jacky
 * E-Mail: jacky@carocrm.com or jacky@youaddon.com
 * Date: 8/4/2015
 * Time: 1:27 PM
 * Project: carofw
 * File: ControllerBase.php
 */

namespace Modules\Backend\Controllers;

use Phalcon\Dispatcher;
use Phalcon\Mvc\Controller;
use Phalcon\Translate\Adapter\NativeArray;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;

class ControllerBase extends Controller
{
    // relate model
    protected $model_name;
    // base controller
    protected $controller_name;
    protected $action_name;
    protected $action_detail = 'detail';
    protected $action_edit = 'edit';
    protected $action_delete = 'delete';
    // button action
    protected $link_action = null;
    // translation
    protected $t;

    protected function initialize()
    {
        $this->tag->prependTitle('Management System');
        // config
        $this->view->setVar('carofw', $this->carofw);
        // language
        $this->t = $this->getTranslation();
        $this->view->setVar('t', $this->t);
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

    /**
     * @param $url_query
     * @param $view_fields
     * @return array
     */
    protected function getFieldsSearch($url_query, $view_fields)
    {
        $conditions = 'deleted = 0';
        $search = array();
        foreach ($url_query as $field => $value) {
            if (!empty($view_fields[$field]['search']) && $view_fields[$field]['search'] == true) {
                $operator = !empty($view_fields[$field]['operator']) ? $view_fields[$field]['operator'] : '=';
                switch ($operator) {
                    case 'like':
                        if ($value) {
                            $conditions .= " AND $field like :$field:";
                            $search[$field] = "%$value%";
                        }
                        break;
                    default:
                        if ($value) {
                            $conditions .= " AND $field = :$field:";
                            $search[$field] = $value;
                        }
                }
            }
        }

        return array(
            'conditions' => ($conditions == '1') ? '' : $conditions,
            'parameters' => $search
        );
    }

    /**
     * @return NativeArray
     */
    protected function getTranslation()
    {
        $language = $this->request->getBestLanguage();

        if (file_exists(APP_PATH . "apps/language/" . $language . ".php")) {
            $lang = require APP_PATH . "apps/language/" . $language . ".php";

        } else {
            $lang = require APP_PATH . "apps/language/en.php";

        }

        return new NativeArray(array(
            "content" => $lang
        ));

    }

    /**
     * save/update a record
     *
     * @param array $data fields value, can use post data from form. This function filter same edit_view and save to db
     * @return bool|null|object record
     */
    protected function saveRecord($data)
    {
        $model_name = !empty($data['model_name']) ? $data['model_name'] : null;

        // get model
        $model = $this->getModel($model_name);

        $id = $data['id'];

        if (!empty($id)) { // update a record
            // get record
            $row = $model::findFirst($id);

            // set data update
            foreach ($model->edit_view['fields'] as $field => $opt) {
                $row->$field = $data[$field];
            }

            if ($row->update() == false) {
                return false;
            }

            return $row;

        } else { // save new record
            // set data save
            foreach ($model->edit_view['fields'] as $field => $opt) {
                $model->$field = $data[$field];
            }

            // save
            if ($model->save() == false) {
                return false;
            }

            return $model;
        }
    }

    /**
     * Make folder upload. Example: <$folder>/2015/08/06
     *
     * @param string $folder folder need upload file. example images, photos, ...
     * @return array return 2 params. sub_folder: uri link to file upload. folder full path go file upload
     */
    protected function makeFolderUpload($folder)
    {
        $folder = !empty($folder) ? $folder: '';
        $sub_folder = $folder . '/' . date('Y') . '/' . date('m') . '/' . date('d') . '/';
        $path_uri = '/public/uploads/' . $sub_folder;
        $path_full = APP_PATH . $path_uri;
        if (!is_dir($path_full)) {
            mkdir($path_full, 0777, true);
        }

        return array(
            'sub_folder' => $path_uri,
            'folder' => $path_full
        );
    }

    // BASE ACTION //
    /**
     * List
     */
    public function listAction()
    {
        $title = $this->t->_('List ') . $this->t->_($this->model_name);
        $this->tag->setTitle($title);
        $this->view->title = $title;

        $model = $this->getModel();

        if (is_null($model)) {
            $this->response->redirect('/admin/dashboard');
        }

        $query_urls = $this->request->getQuery();
        unset($query_urls['_url']);
        unset($query_urls['submit']);
        unset($query_urls['page']);

        // search
        $search_opt = $this->getFieldsSearch($query_urls, $model->list_view['fields']);
        $conditions = $search_opt['conditions'];
        $parameters = $search_opt['parameters'];
        // sort

        $list_data = $model::find(array(
            $conditions,
            'bind' => $parameters
        ));

        // pagination
        $currentPage = $this->request->getQuery('page');
        $paginator_limit = 20; // @TODO
        $paginator = new PaginatorModel(array(
            "data"  => $list_data,
            "limit" => $paginator_limit,
            "page"  => $currentPage > 0 ? $currentPage : 1
        ));
        // get page
        $page = $paginator->getPaginate();

        $this->view->page = $page;
        $this->view->data = $page->items;
        $this->view->list_view = $model->list_view;
        $this->view->search = $query_urls;

        $controller = strtolower($this->controller_name);
        $action = strtolower($this->action_name);

        $this->view->controller = $controller;
        $this->view->action = $action;
        $this->view->action_detail = $this->action_detail;
        $this->view->action_edit = $this->action_edit;
        $this->view->action_delete = $this->action_delete;
        $this->view->menu = $model->menu;
        $this->view->link_action = $this->link_action;

        $query_urls = empty($query_urls) ? array('nosearch' => 1) : $query_urls;
        $this->view->current_url = $this->url->get("/admin/$controller/$action", $query_urls);

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

        $title = $this->t->_('Detail ') . $this->t->_($this->model_name) . ': ' . $data->{$model->detail_view['title']};
        $this->tag->setTitle($title);
        $this->view->title = $title;

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

        // edit view data
        $data = null;

        if ($id) {
            $data = $model::findFirst($id);

            $title = $this->t->_('Edit ') . $this->t->_($this->model_name) . ': ' . $data->{$model->edit_view['title']};

        } else {
            $title = $this->t->_('Create ') . $this->t->_($this->model_name);
        }

        $this->tag->setTitle($title);
        $this->view->title = $title;

        $this->view->edit_view = $model->edit_view;
        $this->view->data = $data;

        $controller = strtolower($this->controller_name);
        $action = strtolower($this->action_name);

        $this->view->model_name = $this->model_name;
        $this->view->controller = $controller;
        $this->view->action = $action;
        $this->view->menu = $model->menu;
        $this->view->action_detail = $this->action_detail;

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
        $title = $this->t->_('List ') . $this->t->_($rel_model);
        //$this->tag->setTitle($title);
        $this->view->title = $title;

        $this->view->setTemplateAfter('ajax');
        $model = $this->getModel($rel_model);

        $query_urls = $this->request->getQuery();
        unset($query_urls['_url']);
        unset($query_urls['submit']);
        unset($query_urls['page']);

        // search
        $search_opt = $this->getFieldsSearch($query_urls, $model->list_view['fields']);
        $conditions = $search_opt['conditions'];
        $parameters = $search_opt['parameters'];

        $list_data = $model::find(array(
            $conditions,
            'bind' => $parameters
        ));

        // pagination
        $currentPage = (int) $_GET["page"];
        $paginator_limit = 20; // @TODO
        $paginator = new PaginatorModel(array(
            "data"  => $list_data,
            "limit" => $paginator_limit,
            "page"  => $currentPage
        ));
        // get page
        $page = $paginator->getPaginate();

        $this->view->page = $page;
        $this->view->data = $page->items;
        $this->view->list_view = $model->list_view;
        $this->view->search = $query_urls;

        $controller = strtolower($this->controller_name);
        $action = strtolower($this->action_name);

        $this->view->controller = $controller;
        $this->view->action = $action;

        $this->view->rel_model = $rel_model;
        $this->view->current_model = $current_model;
        $this->view->current_id = $current_id;
        $this->view->subpanel_name = $subpanel_name;

        $query_urls = empty($query_urls) ? array('nosearch' => 1) : $query_urls;
        $this->view->current_uri = "/admin/$controller/$action/$rel_model/$current_model/$current_id/$subpanel_name";
        $this->view->current_url = $this->url->get($this->view->current_uri, $query_urls);

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
                        $this->flash->error($this->t->_('Sorry, can not add this record relate'));
                    }

                    $save_data->$subpanel_def['rel_field'] = 0;
                    if ($func == 'del' && $save_data->update() == false) {
                        $this->flash->error($this->t->_('Sorry, can not remove this record relate'));
                    }

                } else if ($type == 'many-many') {
                    $mid_model = $this->getModel($subpanel_def['mid_model']);
                    $mid_model->$subpanel_def['mid_field1'] = $current_id;
                    $mid_model->$subpanel_def['mid_field2'] = $rel_id;

                    if ($func == 'ins' && $mid_model->save() == false) {
                        $this->flash->error($this->t->_('Sorry, can not add this record relate'));
                    }

                    if ($func == 'del') {
                        $mid_data = $mid_model::findFirst(array(
                            $subpanel_def['mid_field1'] . '=' . $current_id,
                            $subpanel_def['mid_field2'] . '=' . $rel_id
                        ));
                        if ($mid_data->delete() == false) {
                            $this->flash->error($this->t->_('Sorry, can not remove this record relate'));
                        }
                    }

                }
            }
        }
    }

    /**
     * Save Record
     */
    public function saveAction()
    {
        // save data
        if ($this->request->isPost()) {
            $model_name = $this->request->getPost('model_name');
            $model_name = ($model_name) ? $model_name : null;

            // get model
            $model = $this->getModel($model_name);

            $post_id = $this->request->getPost('id');
            if (!empty($post_id)) {
                $data = $model::findFirst($post_id);
                // update data
                foreach ($model->edit_view['fields'] as $field => $opt) {
                    $data->$field = $this->request->getPost($field);
                }

                if ($data->update() == false) {
                    $this->flash->error($this->t->_('Fail, record was not updated successfully!'));
                } else {
                    $this->flash->success($this->t->_('Great, record was updated successfully!'));
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
                    $this->flash->success($this->t->_('Great, record was saved successfully!'));
                }
            }

            $action_detail = $this->request->getPost('action_detail');
            $action_detail = ($action_detail) ? $action_detail : $this->action_detail;

            $this->response->redirect('/admin/' . $this->controller_name . '/' . $action_detail . '/' . $id);
        }
    }

    /**
     * Delete Record
     *
     * @param $id
     * @return mixed
     */
    protected function deleteRecord($id)
    {
        // get model
        $model = $this->getModel();
        $data = $model::findFirst($id);
        $data->deleted = 1;
        return $data->update();
    }

    /**
     * Delete Record
     *
     * @param null $id
     */
    public function deleteAction($id = null)
    {
        if ($id) {
            $result = $this->deleteRecord($id);

            if ($result == false) {
                $this->flash->error($this->t->_('Fail, record was not deleted successfully!'));
            } else {
                $this->flash->success($this->t->_('Great, record was deleted successfully!'));
            }

            $this->response->redirect('/admin/' . $this->controller_name . '/list');

        } else {
            if ($this->request->isPost()) {
                $ids = $this->request->getPost('ids');

                foreach ($ids as $id) {
                    $this->deleteRecord($id);
                }

                    $this->response->redirect('/admin/' . $this->controller_name . '/list');
            }
        }
    }

    /**
     * Upload file
     */
    public function uploadAction()
    {
        $upload_uri = 'public/uploads/';
        $isUploaded = false;
        $data_upload = array();
        // Check if the user has uploaded files
        if ($this->request->hasFiles() == true) {
            // Set upload folder
            $base_location = $this->request->getPost('location');
            $base_path = $this->makeFolderUpload($base_location);
            $upload_path = $base_path['folder'];
            // Process upload file
            foreach ($this->request->getUploadedFiles() as $file){
                // Move the file into the application
                $path_file = $upload_path . $file->getName();
                $upload_result = $file->moveTo($path_file);
                // result upload
                if ($upload_result) {
                    $isUploaded = true;
                    $data_upload[] = array(
                        'name' => $file->getName(),
                        'size' => $file->getSize(),
                        'path' => $this->url->get($base_path['sub_folder']) . $file->getName()
                    );
                } else {
                    $isUploaded = false;
                }
            }
        }

        if ($isUploaded == false) {
            $this->resJson(array(
                'status' => 0
            ));
        } else {
            $this->resJson(array(
                'status' => 1,
                'data' => $data_upload
            ));
        }
    }

}
