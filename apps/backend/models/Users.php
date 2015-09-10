<?php
/**
 * Created by Jacky.
 * User: Jacky
 * E-Mail: jacky@carocrm.com or jacky@youaddon.com
 * Date: 7/23/2015
 * Time: 1:33 PM
 */

namespace Modules\Backend\Models;

use Phalcon\Mvc\Model\Validator\Email;
use Phalcon\Mvc\Model\Validator\PresenceOf;
use Phalcon\Mvc\Model\Validator\Uniqueness;
use Phalcon\Validation;

class Users extends ModelCustom
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
            'avatar' => array(
                'type' => 'image',
                'label' => 'Avatar'
            ),
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
            'avatar' => array(
                'type' => 'image',
                'label' => 'Avatar'
            ),
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
                ),
                'buttons' => true
            )
        )
    );

    public $edit_view = array(
        'title' => 'name',
        'fields' => array(
            'avatar' => array(
                'type' => 'image',
                'label' => 'Avatar'
            ),
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
        $this->validate(new PresenceOf(array(
            'field' => 'username',
            'message' => 'The username is required'
        )));
        $this->validate(new Uniqueness(array(
            'field' => 'username',
            'message' => 'The username is already registered'
        )));
        $this->validate(new PresenceOf(array(
            'field' => 'email',
            'message' => 'The email is required'
        )));
        $this->validate(new Email(array(
            'field' => 'email',
            'message' => 'The e-mail is not valid'
        )));
        $this->validate(new Uniqueness(array(
            'field' => 'email',
            'message' => 'The email is already registered'
        )));
        $this->validate(new PresenceOf(array(
            'field' => 'password',
            'message' => 'The password is required'
        )));
        $this->validate(new PresenceOf(array(
            'field' => 'name',
            'message' => 'The name is required'
        )));

        return $this->validationHasFailed() != true;
    }

}