<?php
/**
 * Created by Jacky.
 * User: Jacky
 * E-Mail: jacky@carocrm.com or jacky@youaddon.com
 * Date: 8/11/2015
 * Time: 12:02 PM
 * Project: Course_Management
 * File: MyController.php
 */

namespace Modules\Core;


use Phalcon\Dispatcher;
use Phalcon\Mvc\Controller;
use Phalcon\Translate\Adapter\NativeArray;

class MyController extends Controller
{
    // relate model
    protected $model_name;
    // base
    protected $controller_name;
    protected $action_name;
    // translation
    protected $t;

    protected function initialize()
    {
        $this->tag->prependTitle('Caro Framework | ');
        // config
        $this->view->setVar('carofw', $this->carofw);
        // language
        $this->t = $this->getTranslation();
        $this->view->setVar('t', $this->t);
        // controller, action
        $this->view->setVar('current_controller', $this->controller_name);
        $this->view->setVar('current_action', $this->action_name);
    }

    public function beforeExecuteRoute(Dispatcher $dispatcher)
    {
        $this->controller_name = $dispatcher->getControllerName();
        $this->action_name = $dispatcher->getActionName();
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

    /**
     * redirect
     * @param null $uri
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    protected function redirect($uri = null)
    {
        return $this->response->redirect($uri);
    }

    /**
     * redirect to backend module
     * @param null $uri
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    protected function backendRedirect($uri = null)
    {
        return $this->response->redirect('/' . $this->url->backendUrl . $uri);
    }

}