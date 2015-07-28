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
        'username' => 'Username',
        'email' => 'Email',
        'name' => 'Full name'
    );

    protected $edit_view = array(

    );

    protected $detail_view = array(

    );
}