<?php
/**
 * Created by Jacky.
 * User: Jacky
 * E-Mail: jacky@carocrm.com or jacky@youaddon.com
 * Date: 7/28/2015
 * Time: 6:00 PM
 * Project: carofw
 * File: AuthRoles.php
 */

namespace Modules\Backend\Models;


class AuthRoles extends ModelCustom
{
    public $id;
    public $created;
    public $user_created_id;
    public $deleted;
    public $name;
    public $unique_name;
    public $status;
    public $description;

    public $list_view = array(
        'fields' => array(
            'name' => array(
                'type' => 'text',
                'label' => 'Name',
                'link' => true
            ),
            'unique_name' => array(
                'type' => 'text',
                'label' => 'Unique Name'
            ),
            'status' => array(
                'type' => 'select',
                'label' => 'Status',
                'options' => 'users_status_list',
                'search' => true
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
            'unique_name' => array(
                'type' => 'text',
                'label' => 'Unique Name',
                'required' => true
            ),
            'status' => array(
                'type' => 'select',
                'label' => 'Status',
                'options' => 'users_status_list',
            ),
            'description' => array(
                'type' => 'textarea',
                'label' => 'Description'
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
            'unique_name' => array(
                'type' => 'text',
                'label' => 'Unique Name'
            ),
            'status' => array(
                'type' => 'select',
                'label' => 'Status',
                'options' => 'users_status_list',
            ),
            'description' => array(
                'type' => 'text',
                'label' => 'Description'
            ),
        ),
        'subpanels' => array(
            'user_groups' => array(
                'type' => 'one-many',
                'current_model' => 'AuthRoles',
                'current_field' => 'id',
                'rel_model' => 'UserGroups',
                'rel_field' => 'role_id',
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

    public $menu;

    public static function permissionSavePath()
    {
        return APP_PATH . '/apps/backend/permissions/';
    }

    public static function resourcesPath()
    {
        return APP_PATH . '/apps/backend/permissions/resources.php';
    }

    public static function rolesPath()
    {
        return APP_PATH . '/apps/backend/permissions/roles.php';
    }

    public static function publicResources()
    {
        return array(
            'errors' => '*',
            'index' => array('index', 'logout'),
            'rest' => '*'
        );
    }

    public function initialize()
    {
        parent::initialize();
        $user = new Users();
        $this->menu = $user->menu;
    }

}