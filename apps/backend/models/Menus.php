<?php
/**
 * Created by Caro Team (info@carocrm.com).
 * User: Jacky (jacky@carocrm.com).
 * Year: 2016
 * File: Menus.php
 */

namespace Modules\Backend\Models;


class Menus extends ModelCustom
{
    public $name;
    public $controller;
    public $action;
    public $link;
    public $parent_id;
    public $class;
    public $weight;

    public $list_view = array(
        'fields' => array(
            'name' => array(
                'type' => 'text',
                'label' => 'Name',
                'search' => true,
                'operator' => 'like',
                'link' => true
            ),
            'controller_name' => array(
                'type' => 'text',
                'label' => 'Controller'
            ),
            'action_name' => array(
                'type' => 'text',
                'label' => 'Action'
            ),
            'link' => array(
                'type' => 'text',
                'label' => 'Link'
            ),
            'parent_id' => array(
                'type' => 'relate',
                'label' => 'Parent',
                'model' => 'Menus'
            ),
            'class' => array(
                'type' => 'text',
                'label' => 'Class'
            ),
            'weight' => array(
                'type' => 'number',
                'label' => 'Weight'
            ),
        ),
    );

    public $edit_view = array(
        'title' => 'name',
        'fields' => array(
            'name' => array(
                'type' => 'text',
                'label' => 'Name'
            ),
            'controller_name' => array(
                'type' => 'text',
                'label' => 'Controller'
            ),
            'action_name' => array(
                'type' => 'text',
                'label' => 'Action'
            ),
            'link' => array(
                'type' => 'text',
                'label' => 'Link'
            ),
            'parent_id' => array(
                'type' => 'relate',
                'label' => 'Parent',
                'model' => 'Menus'
            ),
            'class' => array(
                'type' => 'text',
                'label' => 'Class'
            ),
            'weight' => array(
                'type' => 'number',
                'label' => 'Weight'
            ),
        ),
    );

    public $detail_view = array(
        'title' => 'name',
        'fields' => array(
            'name' => array(
                'type' => 'text',
                'label' => 'Name'
            ),
            'controller_name' => array(
                'type' => 'text',
                'label' => 'Controller'
            ),
            'action_name' => array(
                'type' => 'text',
                'label' => 'Action'
            ),
            'link' => array(
                'type' => 'text',
                'label' => 'Link'
            ),
            'parent_id' => array(
                'type' => 'relate',
                'label' => 'Parent',
                'model' => 'Menus'
            ),
            'class' => array(
                'type' => 'text',
                'label' => 'Class'
            ),
            'weight' => array(
                'type' => 'number',
                'label' => 'Weight'
            ),
        ),
    );
}