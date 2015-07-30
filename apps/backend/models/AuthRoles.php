<?php
/**
 * Created by Jacky.
 * User: Jacky
 * Date: 7/28/2015
 * Time: 6:00 PM
 * Project: carofw
 * File: AuthRoles.php
 */

namespace Modules\Backend\Models;


class AuthRoles extends ModelBase
{
    public $id;
    public $created;
    public $user_created_id;
    public $deleted;
    public $name;
    public $status;
    public $description;

    public $list_view = array(
        'name' => array(
            'type' => 'text',
            'label' => 'Name',
            'link' => true
        ),
        'description' => array(
            'type' => 'text',
            'label' => 'Description'
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
            'description' => array(
                'type' => 'text',
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

    public function initialize()
    {
        $user = new Users();
        $this->menu = $user->menu;
    }
}