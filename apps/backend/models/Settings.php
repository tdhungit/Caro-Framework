<?php
/**
 * Created by Jacky.
 * User: Jacky
 * File: Settings.php
 * Project: Caro-Framework
 */

namespace Modules\Backend\Models;


use Modules\Core\MyMail;

class Settings extends ModelBase
{
    public $id;
    public $created;
    public $user_created_id;
    public $deleted;
    public $name;
    public $value;

    public function setMailSettings($mailSettings)
    {
        $mymail = new MyMail();
        $mymail->setMailSettings($mailSettings);
    }

    public function getDefaultSettings()
    {
        $mymail = new MyMail();
        return $mymail->getDefaultSettings($this);
    }

    public function sendMail($to, $subject, $body)
    {
        $mymail = new MyMail();
        $mymail->setDefaultSettings($this);
        return $mymail->send($to, $subject, $body);
    }
}