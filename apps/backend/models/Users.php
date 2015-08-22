<?php
/**
 * Created by Jacky.
 * User: Jacky
 * E-Mail: jacky@carocrm.com or jacky@youaddon.com
 * Date: 7/23/2015
 * Time: 1:33 PM
 */

namespace Modules\Backend\Models;

use Phalcon\Validation;

class Users extends ModelBase
{
    public $id;
    public $created;
    public $user_created_id;
    public $deleted;
    public $username;
    public $email;
    public $password;
    public $name;
    public $status;

    public $list_view = array(
        'fields' => array(
            'username' => array(
                'type' => 'text',
                'label' => 'Username',
                'link' => true,
                'search' => true,
                'operator' => 'like'
            ),
            'email' => array(
                'type' => 'text',
                'label' => 'Email'
            ),
            'name' => array(
                'type' => 'text',
                'label' => 'Full name'
            )
        ),
    );

    public $detail_view = array(
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
        ),
        'subpanels' => array(
            'user_groups' => array(
                'type' => 'many-many',
                'current_model' => 'Users',
                'current_field' => 'id',
                'rel_model' => 'UserGroups',
                'rel_field' => 'id',
                'mid_model' => 'UserGroupsUsers',
                'mid_field1' => 'user_id',
                'mid_field2' => 'group_id',
                'list' => array(
                    'name' => array(
                        'type' => 'text',
                        'label' => 'Name',
                    ),
                    'status' => array(
                        'type' => 'select',
                        'label' => 'Status'
                    ),
                )
            )
        )
    );

    public $edit_view = array(
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
                'type' => 'select',
                'label' => 'Status',
                'required' => true,
                'options' => 'users_status_list'
            ),
        )
    );

    public $menu = array(
        'View Users' => '/admin/users/list',
        'Create User' => '/admin/users/edit',
        'Groups' => '/admin/users/groups',
        'Create Group' => '/admin/users/edit_group',
        'Roles' => '/admin/users/roles',
        'Create Role' => '/admin/users/edit_role'
    );

    public function validation()
    {
        $validation = new Validation();

        $validation->add('username', new Validation\Validator\PresenceOf(array('message' => _('The username is required'))));
        $validation->add('username', new Validation\Validator\Uniqueness(array('message' => _('The username is already registered'))));
        $validation->add('email', new Validation\Validator\PresenceOf(array('message' => _('The email is required'))));
        $validation->add('email', new Validation\Validator\Email(array('message' => _('The e-mail is not valid'))));
        $validation->add('email', new Validation\Validator\Uniqueness(array('message' => _('The email is already registered'))));
        $validation->add('password', new Validation\Validator\PresenceOf(array('message' => _('The password is required'))));
        $validation->add('name', new Validation\Validator\PresenceOf(array('message' => _('The name is required'))));
    }

}