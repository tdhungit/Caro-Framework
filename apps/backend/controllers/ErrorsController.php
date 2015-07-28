<?php
/**
 * Created by Jacky.
 * User: Jacky
 * Date: 7/27/2015
 * Time: 5:18 PM
 * Project: carofw
 * File: ErrorsController.php
 */

namespace Modules\Backend\Controllers;

class ErrorsController extends ControllerBase
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