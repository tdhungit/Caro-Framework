<?php

return new \Phalcon\Config(array(
    'database' => new \Phalcon\Config\Adapter\Ini(__DIR__ . '/../../config/database.ini'),
));
