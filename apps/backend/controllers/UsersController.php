<?php
/**
 * Created by Jacky.
 * User: Jacky
 * E-Mail: jacky@carocrm.com or jacky@youaddon.com
 * Date: 7/24/2015
 * Time: 4:58 PM
 * Project: carofw
 * File: UsersController.php
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
        $this->action_detail = 'detailgroup';
        $this->indexAction();
    }

    public function detailgroupAction($id = null)
    {
        $this->model_name = 'UserGroups';
        $this->detailAction($id);
    }

    public function editgroupAction($id = null)
    {
        $this->model_name = 'UserGroups';
        $this->action_detail = 'detailgroup';
        $this->editAction($id);
    }

    public function rolesAction()
    {
        $this->model_name = 'AuthRoles';
        $this->action_detail = 'detailrole';
        $this->indexAction();
    }

    public function detailroleAction($id = null)
    {
        $this->model_name = 'AuthRoles';
        $this->action_detail = 'detailrole';
        $this->detailAction($id);
    }

    public function editroleAction($id = null)
    {
        $this->model_name = 'AuthRoles';
        $this->editAction($id);
    }
}