<?php
/**
 * Created by Jacky.
 * User: Jacky
 * File: Settings.php
 * Project: Caro-Framework
 */

namespace Modules\Backend\Models;


class Settings extends ModelBase
{
    public $id;
    public $created;
    public $user_created_id;
    public $deleted;
    public $name;
    public $value;
}