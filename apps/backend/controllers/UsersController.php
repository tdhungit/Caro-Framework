<?php
/**
 * Created by jacky.
 * User: jacky
 * Date: 7/23/2015
 * Time: 2:05 PM
 */

namespace Modules\Backend\Controllers;

class UsersController extends ControllerBase
{
    protected $model_name = 'Users';

    public function indexAction()
    {
        $this->listAction();
    }

    public function groupsAction()
    {
        $this->model_name = 'UserGroups';
        $this->indexAction();
    }

    public function editgroupAction($id = null)
    {
        $this->model_name = 'UserGroups';
        $this->editAction($id);
    }

    public function rolesAction()
    {

    }

    public function editroleAction()
    {

    }
}