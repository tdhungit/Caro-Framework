<?php
/**
 * Created by Jacky.
 * User: Jacky
 * File: RestController.php
 * Project: Caro-Framework
 */

namespace Modules\Backend\Controllers;


use Phalcon\Http\Response;
use Phalcon\Mvc\Controller;

define('ERROR_AUTHENTICATE', -401);
define('ERROR_EMPTYDATA', -403);
define('ERROR_NOTFOUND', -404);
define('ERROR_INTERNALSERVER', -500);

class RestController extends Controller
{
    /**
     * @var array
     * Structure:
     * <model/function> => <method>
     * Example:
     * Users/list => get
     */
    protected $register_api = array(
        'AuthRoles/find' => 'get'
    );

    /**
     * initialize
     */
    public function initialize()
    {
        $this->view->disable();
        $this->response->setContentType('application/json', 'UTF-8');
    }

    /**
     * @param $status
     */
    public function returnError($status)
    {
        $message = '';
        echo json_encode(array(
            'status' => $status,
            'message' => $message
        ));
    }

    /**
     * @param $data
     */
    public function returnData($data)
    {
        echo json_encode(array(
            'status' => 1,
            'data' => $data
        ));
    }

    /**
     * @param $model
     * @param $function
     */
    public function executeAction($model, $function)
    {
        if (!$model || !$function) {
            return $this->returnError(ERROR_EMPTYDATA);
        }

        $register_key = "$model/$function";
        if (empty($this->register_api[$register_key])) {
            return $this->returnError(ERROR_NOTFOUND);
        }

        $model_path = '\\Modules\Backend\Models\\' . $model;
        $focus = new $model_path();

        $data = array();
        $method = $this->register_api[$register_key];
        switch(strtolower($method)) {
            case 'get':
                $params = $this->request->getQuery('params');
                $params = base64_decode($params);
                $params = @json_decode($params, true);
                $params = ($params) ? $params : array();
                if (method_exists($focus, $function)) {
                    $data = call_user_func_array(array($focus, $function), $params);
                }
                break;
            case 'post':
                if (!$this->request->isPost()) {
                    return $this->returnError(ERROR_EMPTYDATA);
                    break;
                }
                $params = $this->request->getPost('params');
                $params = @json_decode($params, true);
                $params = ($params) ? $params : array();
                if ( method_exists($focus, $function) ) {
                    $data = call_user_func_array(array($focus, $function), $params);
                }
                break;
            default:
                return $this->returnError(ERROR_INTERNALSERVER);
                break;
        }

        return $this->returnData($data);
    }
}