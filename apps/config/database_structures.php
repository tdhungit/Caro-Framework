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
    'users' => array(
        'fields' => array(
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
        ),
        'indexes' => array()
    ),
    'user_group_roles' => array(
        'fields' => array(
            'group_id' => array(
                'type' => Column::TYPE_INTEGER,
                'size' => 10,
                'notNull' => true
            ),
            'auth_role_id' => array(
                'type' => Column::TYPE_INTEGER,
                'size' => 10,
                'notNull' => true
            )
        ),
        'indexes' => array(
            'idx_unique' => array(
                'type' => 'Unique',
                'fields' => array('group_id', 'auth_role_id')
            )
        )
    ),
    'auth_role' => array(
        'fields' => array(
            'name' => array(
                'type' => Column::TYPE_VARCHAR,
                'size' => 255,
                'notNull' => true
            ),
            'description' => array(
                'type' => Column::TYPE_TEXT
            ),
        ),
        'indexes' => array()
    ),

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