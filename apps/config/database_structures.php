<?php
/**
 * Created by Jacky.
 * User: Jacky
 * Date: 7/24/2015
 * Time: 5:09 PM
 * Project: carofw
 * File: database_structures.php
 */

use \Phalcon\Db\Column as Column;

return array(
    // Users
    'users' => array(
        'fields' => array(
            'avatar' => array(
                "type"    => Column::TYPE_VARCHAR,
                "size"    => 255,
                "notNull" => true,
            ),
            'username' => array(
                "type"    => Column::TYPE_VARCHAR,
                "size"    => 255,
                "notNull" => true,
            ),
            'email' => array(
                "type"    => Column::TYPE_VARCHAR,
                "size"    => 255,
                "notNull" => true,
            ),
            'password' => array(
                "type"    => Column::TYPE_CHAR,
                "size"    => 32,
                "notNull" => true,
            ),
            'name' => array(
                "type"    => Column::TYPE_VARCHAR,
                "size"    => 255,
                "notNull" => true,
            ),
            'status' => array(
                "type"    => Column::TYPE_VARCHAR,
                "size"    => 255,
                "notNull" => true,
            ),
        ),
        'indexes' => array(
            'idx_username' => array(
                'type' => 'Unique',
                'fields' => array('username')
            ),
            'idx_email' => array(
                'type' => 'Unique',
                'fields' => array('email')
            )
        )
    ),
    // ACL
    'user_groups' => array(
        'fields' => array(
            'name' => array(
                'type' => Column::TYPE_VARCHAR,
                'size' => 255,
                'notNull' => true
            ),
            'status' => array(
                'type' => Column::TYPE_VARCHAR,
                'size' => 255,
                'notNull' => true
            ),
            'description' => array(
                'type' => Column::TYPE_TEXT
            ),
            'role_id' => array(
                'type' => Column::TYPE_INTEGER,
                'size' => 10
            )
        ),
        'indexes' => array()
    ),
    'user_groups_users' => array(
        'fields' => array(
            'user_id' => array(
                'type' => Column::TYPE_INTEGER,
                'size' => 10,
                'notNull' => true
            ),
            'group_id' => array(
                'type' => Column::TYPE_INTEGER,
                'size' => 10,
                'notNull' => true
            )
        ),
        'indexes' => array(
            'idx_unique' => array(
                'type' => 'Unique',
                'fields' => array('user_id', 'group_id')
            )
        )
    ),
    'auth_roles' => array(
        'fields' => array(
            'name' => array(
                'type' => Column::TYPE_VARCHAR,
                'size' => 255,
                'notNull' => true
            ),
            'unique_name' => array(
                'type' => Column::TYPE_VARCHAR,
                'size' => 255,
                'notNull' => true
            ),
            'status' => array(
                'type' => Column::TYPE_VARCHAR,
                'size' => 255,
            ),
            'description' => array(
                'type' => Column::TYPE_TEXT
            ),
        ),
        'indexes' => array(
            'idx_unique_name' => array(
                'type' => 'Unique',
                'fields' => array('unique_name')
            )
        )
    ),
    // Menu Admin
    'menus' => array(
        'fields' => array(
            'name' => array(
                "type"    => Column::TYPE_VARCHAR,
                "size"    => 200,
                "notNull" => true
            ),
            'controller_name' => array(
                "type"    => Column::TYPE_VARCHAR,
                "size"    => 200,
                "notNull" => false
            ),
            'action_name' => array(
                "type"    => Column::TYPE_VARCHAR,
                "size"    => 200,
                "notNull" => false
            ),
            'link' => array(
                "type"    => Column::TYPE_VARCHAR,
                "size"    => 255,
                "notNull" => false
            ),
            'parent_id' => array(
                "type"    => Column::TYPE_INTEGER,
                "size"    => 10,
                "notNull" => false
            ),
            'class' => array(
                "type"    => Column::TYPE_VARCHAR,
                "size"    => 200,
                "notNull" => false
            ),
            'weight' => array(
                "type"    => Column::TYPE_INTEGER,
                "size"    => 10,
                "notNull" => false
            ),
        ),
        'indexes' => array()
    ),
    // Settings
    'settings' => array(
        'fields' => array(
            'name' => array(
                "type"    => Column::TYPE_VARCHAR,
                "size"    => 255,
                "notNull" => true,
            ),
            'value' => array(
                "type"    => Column::TYPE_TEXT,
                "notNull" => false,
            ),
        ),
        'indexes' => array(
            'idx_unique' => array(
                'type' => 'Unique',
                'fields' => array('name')
            )
        )
    ),

);