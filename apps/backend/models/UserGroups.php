<?php
/**
 * Created by Jacky.
 * User: Jacky
 * E-Mail: jacky@carocrm.com or jacky@youaddon.com
 * Date: 7/28/2015
 * Time: 5:24 PM
 * Project: carofw
 * File: UserGroups.php
 */

namespace Modules\Backend\Models;


class UserGroups extends ModelCustom
{
    public $id;
    public $created;
    public $user_created_id;
    public $deleted;
    public $name;
    public $status;
    public $description;
    public $role_id;

    public $list_view = array(
        'fields' => array(
            'name' => array(
                'type' => 'text',
                'label' => 'Name',
                'link' => true,
                'search' => true
            ),
            'status' => array(
                'type' => 'select',
                'label' => 'Status',
                'options' => 'users_status_list',
                'search' => true
            ),
            'role_id' => array(
                'type' => 'relate',
                'model' => 'AuthRoles',
                'label' => 'Role'
            )
        )
    );

    public $edit_view = array(
        'title' => 'name',
        'fields' => array(
            'name' => array(
                'type' => 'text',
                'label' => 'Name',
                'required' => true
            ),
            'status' => array(
                'type' => 'select',
                'label' => 'Status',
                'options' => 'users_status_list',
                'required' => true
            ),
            'role_id' => array(
                'type' => 'relate',
                'model' => 'AuthRoles',
                'label' => 'Role'
            ),
            'description' => array(
                'type' => 'textarea',
                'label' => 'Description',
                'required' => true
            ),
        )
    );

    public $detail_view = array(
        'title' => 'name',
        'fields' => array(
            'name' => array(
                'type' => 'text',
                'label' => 'Name'
            ),
            'status' => array(
                'type' => 'select',
                'label' => 'Status',
                'options' => 'users_status_list',
            ),
            'role_id' => array(
                'type' => 'relate',
                'model' => 'AuthRoles',
                'label' => 'Role'
            ),
            'description' => array(
                'type' => 'text',
                'label' => 'Description'
            ),
        )
    );

    public $menu;

    public function initialize()
    {
        parent::initialize();
        $user = new Users();
        $this->menu = $user->menu;
    }
}