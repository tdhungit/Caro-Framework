<?php
/**
 * Created by Jacky.
 * User: Jacky
 * E-Mail: jacky@carocrm.com or jacky@youaddon.com
 * Date: 7/27/2015
 * Time: 5:18 PM
 * Project: carofw
 * File: ErrorsController.php
 */

namespace Modules\Backend\Controllers;


use Modules\Core\MyController;

class ErrorsController extends MyController
{
    public function initialize()
    {
        $this->tag->setTitle('Oops!');
        parent::initialize();
    }

    public function show404Action()
    {

    }

    public function show401Action()
    {

    }

    public function show500Action()
    {

    }
}