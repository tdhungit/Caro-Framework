<?php
/**
 * Created by Jacky.
 * User: Jacky
 * E-Mail: jacky@carocrm.com or jacky@youaddon.com
 * Date: 8/4/2015
 * Time: 1:27 PM
 * Project: carofw
 * File: config.php
 */

return new \Phalcon\Config(array(
	'database' => new \Phalcon\Config\Adapter\Ini(__DIR__ . '/../../config/database.ini'),
));
