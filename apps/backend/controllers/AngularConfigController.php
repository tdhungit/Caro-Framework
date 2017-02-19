<?php
/**
 * Created by Caro Team (carodev.com).
 * User: Jacky (jacky@youaddon.com).
 * Year: 2017
 * File: AngularConfigController.php
 */

namespace Modules\Backend\Controllers;


/******** Define chunk path for angular *********/

class AngularConfigController extends ControllerBase
{
    public function chunksAction($index)
    {
        $this->view->disable();

        echo file_get_contents(APP_PATH . 'public/themes/' . $this->theme . '/dist/' . $index . '.chunk.js');
    }
}