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

    protected $list_view = array(
        'username' => array(
            'type' => 'text',
            'label' => 'Username',
            'link' => true
        ),
        'email' => array(
            'type' => 'text',
            'label' => 'Email'
        ),
        'name' => array(
            'type' => 'text',
            'label' => 'Full name'
        )
    );

    protected $detail_view = array(
        'title' => 'name',
        'fields' => array(
            'username' => array(
                'type' => 'text',
                'label' => 'Username'
            ),
            'email' => array(
                'type' => 'text',
                'label' => 'Email'
            ),
            'name' => array(
                'type' => 'text',
                'label' => 'Full name'
            )
        )
    );

    protected $edit_view = array(
        'title' => 'name',
        'fields' => array(
            'username' => array(
                'type' => 'text',
                'label' => 'Username',
                'required' => true
            ),
            'email' => array(
                'type' => 'text',
                'label' => 'Email',
                'required' => true
            ),
            'name' => array(
                'type' => 'text',
                'label' => 'Full name',
                'required' => true
            ),
            'password' => array(
                'type' => 'password',
                'label' => 'Password',
                'required' => true
            ),
            'status' => array(
                'type' => 'text',
                'label' => 'Status',
                'required' => true
            ),
        )
    );

    protected $menu = array(
        'View Users' => '/admin/users/list',
        'Create User' => '/admin/users/edit',
        'Groups' => '/admin/users/groups',
        'Create Group' => '/admin/users/editgroup',
        'Roles' => '/admin/users/roles',
        'Create Role' => '/admin/users/editrole'
    );

    public function indexAction()
    {
        $this->listAction();
    }
}