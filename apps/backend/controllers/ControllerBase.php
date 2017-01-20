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


use Modules\Backend\Models\Menus;
use Modules\Backend\Models\Users;
use Modules\Core\MyController;

/**
 * Class ControllerBase
 * @package Modules\Backend\Controllers
 */
class ControllerBase extends MyController
{
    /**
     * @var bool ajax view
     */
    protected $is_ajax = false;

    /**
     * @var string action list name
     */
    protected $action_list = 'list';
    /**
     * @var string action detail name
     */
    protected $action_detail = 'detail';
    /**
     * @var string action edit name
     */
    protected $action_edit = 'edit';
    /**
     * @var string action delete name
     */
    protected $action_delete = 'delete';
    /**
     * @var null|string link action detail
     */
    protected $link_detail = null;
    /**
     * @var null|array button action
     */
    protected $link_action = null;

    /**
     * @var null|string where condition
     */
    protected $where = null;

    /**
     * initialize
     */
    protected function initialize()
    {
        parent::initialize();
        $this->tag->appendTitle('Admin Page | ');

        // set viewDir
        if (!$this->module_name) {
            $this->view->setViewsDir(APP_PATH . 'apps/' . $this->dispatcher->getModuleName() . '/views/');
            $this->view->setLayoutsDir('layouts/');
        } else {
            $this->view->setViewsDir(APP_PATH . 'apps/' . $this->dispatcher->getModuleName() . '/src/' . $this->module_name . '/views/');
            $this->view->setLayoutsDir('../../../views/layouts/');
        }

        // auth
        $auth = $this->session->get('auth');
        if ($auth) {
            $current_user = Users::findFirst($auth['id']);
            $this->view->setVar('current_user', $current_user);
        }

        // menus
        $this->view->setVar('current_menus', $this->getAllMenus());

        // current module
        $this->view->setVar('module_name', $this->module_name);
    }

    /**
     * get Model
     *
     * @param null|string $model_name
     * @return null
     */
    protected function getModel($model_name = null)
    {
        if ($this->ext_model_name) {
            $model_focus = $this->ext_model_name;
        } else {
            $model_focus = $this->model_name;
        }

        if ($model_name) {
            $model_focus = $model_name;
        }

        if ($model_focus) {
            if ($this->module_name && !$this->ext_model_name) {
                $model_path = '\\Modules\\Backend\\Src\\' . $this->module_name . '\\Models\\' . $model_focus;
            } else {
                $model_path = '\\Modules\\Backend\\Models\\' . $model_focus;
            }

            $model = new $model_path();
            $model->initialize();
            if (empty($model->menu)) {
                $model->menu = array(
                    'View ' . ucfirst($this->controller_name) => '/portal/' . $this->controller_name . '/list',
                    'Create ' . ucfirst($this->controller_name) => '/portal/' . $this->controller_name . '/edit'
                );
            }
            return $model;
        }

        return null;
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
     * @param $defs
     * @param $data
     * @param $currentPage
     * @param $paginator_limit
     * @return array
     */
    protected function getSubpanels($defs, $data, $currentPage, $paginator_limit)
    {
        $subpanels = array();
        foreach ($defs as $name => $def) {
            $subpanels[$name] = $this->getSubpanel($def, $data, $currentPage, $paginator_limit);
        }
        return $subpanels;
    }

    /**
     * @param $def
     * @param $data
     * @param $currentPage
     * @param $paginator_limit
     * @return mixed
     */
    protected function getSubpanel($def, $data, $currentPage, $paginator_limit)
    {
        if ($def['type'] == 'one-many') {
            $rel_model = $this->getModel($def['rel_model']);
            $panel = $rel_model::find($def['rel_field'] . '=' . $data->id);

            return $rel_model->pagination($panel, $paginator_limit, $currentPage);

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

            $rel_model = $this->getModel($def['rel_model']);
            return $rel_model->pagination($panel, $paginator_limit, $currentPage);
        }
    }

    /**
     * @return \Phalcon\Mvc\Model\ResultsetInterface
     */
    public function getAllMenus()
    {
        $menus = array();

        $file_menu = APP_PATH . 'apps/backend/permissions/menus.php';
        if (is_file($file_menu)) {
            return include $file_menu;
        } else {
            $parent_menus = Menus::find(array(
                'conditions' => "deleted = 0 AND (parent_id IS NULL OR parent_id = '')",
                'order' => 'weight ASC'
            ));
            if ($parent_menus) {
                $i = 0;
                foreach ($parent_menus->toArray() as $p_menus) {
                    $menus[$i] = $p_menus;
                    $menus[$i]['children'] = Menus::find(array(
                        'conditions' => "deleted = 0 AND parent_id = :menu_id:",
                        'bind' => array('menu_id' => $p_menus['id']),
                        'order' => 'weight ASC'
                    ))->toArray();
                    $i++;
                }
            }

            $file = fopen($file_menu, "w");
            $content = "<?php";
            $content .= "\n\nreturn " . var_export($menus, true) . ";";
            fwrite($file, $content);
            fclose($file);
        }

        return $menus;
    }

    /**
     * save/update a record
     *
     * @param array $data fields value, can use post data from form. This function filter same edit_view and save to db
     * @param array return errors message
     * @return bool|null|object record
     */
    protected function saveRecord($data, &$errors_msg = array())
    {
        $model_name = !empty($data['model_name']) ? $data['model_name'] : null;

        // get model
        $model = $this->getModel($model_name);

        $id = !empty($data['id']) ? $data['id'] : null;

        if (!empty($id)) { // update a record
            // get record
            $row = $model::findFirst($id);

            // set data update
            foreach ($model->edit_view['fields'] as $field => $opt) {
                if ($opt['type'] != 'password' && $opt['type'] != 'hidden') {
                    $row->$field = $data[$field];
                }
            }

            if ($row->update() == false) {
                $errors_msg = $row->getMessages();
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
                $errors_msg = $model->getMessages();
                return false;
            }

            return $model;
        }
    }

    /**
     * Delete Record
     *
     * @param $id
     * @param $model_name
     * @return mixed
     */
    protected function deleteRecord($id, $model_name = null)
    {
        // get model
        $model = $this->getModel($model_name);
        $data = $model::findFirst($id);
        $data->deleted = 1;
        return $data->update();
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
            $this->backendRedirect('/dashboard');
        }

        $query_urls = $this->url->currentQuery($this->request->getQuery(), ['page']);

        // search
        $search_opt = $this->getFieldsSearch($query_urls, $model->list_view['fields']);
        $conditions = $search_opt['conditions'];
        $parameters = $search_opt['parameters'];
        // sort

        // custom where
        if ($this->where) {
            $conditions .= ' ' . $this->where;
        }

        $list_data = $model::find(array(
            $conditions,
            'bind' => $parameters
        ));

        // pagination
        $currentPage = $this->request->getQuery('page');
        $paginator_limit = 20; // @TODO
        $page = $model->pagination($list_data, $paginator_limit, $currentPage);

        $this->view->page = $page;
        $this->view->data = $page->items;
        $this->view->list_view = $model->list_view;
        $this->view->search = $query_urls;

        $controller = strtolower($this->controller_name);
        $action = strtolower($this->action_name);

        $this->view->model_name = $this->model_name;
        $this->view->controller = $controller;
        $this->view->action = $action;
        $this->view->action_detail = $this->action_detail;
        $this->view->action_edit = $this->action_edit;
        $this->view->action_delete = $this->action_delete;
        $this->view->menu = $model->menu;
        $this->view->link_action = $this->link_action;

        $query_urls = empty($query_urls) ? array('nosearch' => 1) : $query_urls;
        $this->view->current_url = $this->url->currentUrl($query_urls);

        $exists = $this->view->exists($controller . '/' . $action);
        if (!$exists) {
            if ($this->module_name) {
                $this->view->pick('../../../views/view_default/list');
            } else {
                $this->view->pick('view_default/list');
            }
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
            $currentPage = $this->request->getQuery('page');
            $paginator_limit = 20; // @TODO
            if (!empty($model->detail_view['subpanels'])) {
                $supanels = $this->getSubpanels($model->detail_view['subpanels'], $data, $currentPage, $paginator_limit);
            }
            $query_urls = empty($query_urls) ? array('nosearch' => 1) : $query_urls;
            $this->view->current_url = $this->url->currentUrl($query_urls);
        }

        if ($data == null) {
            $this->backendRedirect('/' . $this->controller_name);
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
        $this->view->action_list = $this->action_list;
        $this->view->action_edit = $this->action_edit;
        $this->view->link_detail = $this->link_detail;

        $exists = $this->view->exists($controller . '/' . $action);
        if (!$exists) {
            if ($this->module_name) {
                $this->view->pick('../../../views/view_default/detail');
            } else {
                $this->view->pick('view_default/detail');
            }
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
        $this->view->model = $model;
        $this->view->data = $data;

        $controller = strtolower($this->controller_name);
        $action = strtolower($this->action_name);

        $this->view->model_name = $this->model_name;
        $this->view->controller = $controller;
        $this->view->action = $action;
        $this->view->menu = $model->menu;
        $this->view->action_list = $this->action_list;
        $this->view->action_detail = $this->action_detail;

        $exists = $this->view->exists($controller . '/' . $action);
        if (!$exists) {
            if ($this->module_name) {
                $this->view->pick('../../../views/view_default/edit');
            } else {
                $this->view->pick('view_default/edit');
            }
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

        $query_urls = $this->url->currentQuery($this->request->getQuery(), ['page']);

        // search
        $search_opt = $this->getFieldsSearch($query_urls, $model->list_view['fields']);
        $conditions = $search_opt['conditions'];
        $parameters = $search_opt['parameters'];

        $list_data = $model::find(array(
            $conditions,
            'bind' => $parameters
        ));

        // pagination
        $currentPage = (int)$_GET["page"];
        $paginator_limit = 20; // @TODO
        $page = $model->pagination($list_data, $paginator_limit, $currentPage);

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
        //'/' . $this->url->backendUrl . "/$controller/$action/$rel_model/$current_model/$current_id/$subpanel_name";
        $this->view->current_uri = $this->router->getRewriteUri();
        $this->view->current_url = $this->url->get($this->view->current_uri, $query_urls);

        $exists = $this->view->exists($controller . '/' . $action);
        if (!$exists) {
            if ($this->module_name) {
                $this->view->pick('../../../views/view_default/popup');
            } else {
                $this->view->pick('view_default/popup');
            }
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
                            "conditions" => $subpanel_def['mid_field1'] . '=' . $current_id . " and " . $subpanel_def['mid_field2'] . '=' . $rel_id
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
                    if ($opt['type'] != 'password' && $opt['type'] != 'hidden') {
                        $data->$field = $this->request->getPost($field);
                    }
                }

                if ($data->update() == false) {
                    $msg = '';
                    foreach ($data->getMessages() as $message) {
                        $msg .= $this->t->_((string)$message) . '<br>';
                    }
                    $this->flash->error($msg);
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
                        $msg .= $this->t->_((string)$message) . '<br>';
                    }
                    $this->flash->error($msg);
                } else {
                    $id = $model->id;
                    $this->flash->success($this->t->_('Great, record was saved successfully!'));
                }
            }

            $action_detail = $this->request->getPost('action_detail');
            $action_detail = ($action_detail) ? $action_detail : $this->action_detail;

            $this->backendRedirect('/' . $this->controller_name . '/' . $action_detail . '/' . $id);
        }
    }

    /**
     * Delete Record
     *
     * @param null|int $id
     * @param $model_name
     * @return mixed
     */
    public function deleteAction($id = null, $model_name = null)
    {
        if ($id) {
            $result = $this->deleteRecord($id, $model_name);

            if ($result == false) {
                $this->flash->error($this->t->_('Fail, record was not deleted successfully!'));
            } else {
                $this->flash->success($this->t->_('Great, record was deleted successfully!'));
            }

            if ($this->request->getQuery('return')) {
                return $this->backendRedirect('/' . $this->request->getQuery('return'));
            }

            return $this->backendRedirect("/{$this->controller_name}/{$this->action_list}");

        } else {
            if ($this->request->isPost()) {
                $ids = $this->request->getPost('ids');

                foreach ($ids as $id) {
                    $this->deleteRecord($id);
                }

                return $this->backendRedirect("/{$this->controller_name}/{$this->action_list}");
            }
        }
    }

    /**
     * Upload file
     */
    public function uploadAction()
    {
        $isUploaded = false;
        $data_upload = array();
        // Check if the user has uploaded files
        if ($this->request->hasFiles() == true) {
            // Set upload folder
            $base_location = $this->request->getPost('location');
            $base_path = $this->makeFolderUpload($base_location);
            $upload_path = $base_path['folder'];
            // Process upload file
            foreach ($this->request->getUploadedFiles() as $file) {
                // Move the file into the application
                $file_upload_name = $file->getName();
                // hash file name
                //$file_upload_name = md5($file->getName()) . '.' . $file->getExtension();
                $path_file = $upload_path . $file_upload_name;
                $upload_result = $file->moveTo($path_file);
                // result upload
                if ($upload_result) {
                    $isUploaded = true;
                    $data_upload[] = array(
                        'folder' => $base_path['folder'],
                        'sub_folder' => $base_path['sub_folder'],
                        'name' => $file->getName(),
                        'size' => $file->getSize(),
                        'path' => $this->url->get($base_path['uri']) . $file_upload_name
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
