<?php
/**
 * Created by Caro Team (info@carocrm.com).
 * User: Jacky (jacky@carocrm.com).
 * Year: 2016
 * File: ControllerAjax.php
 */

namespace Modules\Backend\Controllers;


class ControllerAjax extends ControllerBase
{
    protected $is_ajax = true;
    
    /**
     * initialize
     */
    public function initialize()
    {
        $this->view->disable();
        $this->response->setContentType('application/json', 'UTF-8');
    }
}