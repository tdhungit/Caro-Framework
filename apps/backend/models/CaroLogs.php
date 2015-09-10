<?php
/**
 * Created by Jacky.
 * User: Jacky
 * File: CaroLogs.php
 * Project: Caro-Framework
 */

namespace Modules\Backend\Models;


class CaroLogs
{
    static $folder_log = APP_PATH . '/apps/logs/';

    public static function log($message, $log_file = 'caro')
    {
        if (is_array($message) || is_object($message)) {
            $message = json_encode($message);
        }

        $file = fopen(CaroLogs::$folder_log . $log_file . '.log', "a+");
        fwrite($file, "$message\n");
        fclose($file);
    }

    public static function logObject($object, $log_file = 'caro') {
        $file = fopen(CaroLogs::$folder_log . $log_file . '.log', "a+");
        fwrite($file, var_export($object, true) . "\n");
        fclose($file);
    }
}