<?php
/**
 * Created by Caro Team (info@carocrm.com).
 * User: Jacky (jacky@carocrm.com).
 * Year: 2016
 * File: Users.php
 */

namespace Modules\Backend\Src\Demo\Models;


use Modules\Backend\Models\Users;

class Demo extends Users
{
    public function initialize()
    {
        $this->setSource('users');
        parent::initialize();
    }
}