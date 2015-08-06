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
	'database' => include __DIR__ . '/../../config/database.php',
	'application' => array(
		'controllersDir' => __DIR__ . '/../controllers/',
		'modelsDir' => __DIR__ . '/../models/',
		'viewsDir' => __DIR__ . '/../views/',
	)
));
