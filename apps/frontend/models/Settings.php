<?php
/**
 * Created by Caro Team (info@carocrm.com).
 * User: Jacky (jacky@carocrm.com).
 * Year: 2016
 * File: Settings.php
 */

namespace Modules\Frontend\Models;


use Modules\Core\MyMail;

class Settings extends ModelBase
{
    /**
     * @param $mailSettings
     */
    public function setMailSettings($mailSettings)
    {
        $mymail = new MyMail();
        $mymail->setMailSettings($mailSettings);
    }

    /**
     * @return array
     */
    public function getDefaultSettings()
    {
        $mymail = new MyMail();
        return $mymail->getDefaultSettings($this);
    }

    /**
     * @param $to
     * @param $subject
     * @param $body
     * @return mixed
     */
    public function sendMail($to, $subject, $body)
    {
        $mymail = new MyMail();
        $mymail->setDefaultSettings($this);
        return $mymail->send($to, $subject, $body);
    }
}