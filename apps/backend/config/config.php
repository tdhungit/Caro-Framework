<?php

return new \Phalcon\Config(array(
	'database' => include __DIR__ . '/../../config/database.php',
	'application' => array(
		'controllersDir' => __DIR__ . '/../controllers/',
		'modelsDir' => __DIR__ . '/../models/',
		'viewsDir' => __DIR__ . '/../views/',
	)
));
