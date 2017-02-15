<?php

return array(
    '/[ADMIN]' =>
        array(
            'module' => 'backend',
            'controller' => 'index',
            'action' => 'index',
        ),
    '/[ADMIN]/:controller/:action/:params' =>
        array(
            'module' => 'backend',
            'controller' => 1,
            'action' => 2,
            'params' => 3,
        ),
    '/[ADMIN]/:controller/:action/:params.(json|xml)' =>
        array(
            'module' => 'backend',
            'controller' => 1,
            'action' => 2,
            'params' => 3,
            'format' => 4
        ),
    '/[ADMIN]/:controller' =>
        array(
            'module' => 'backend',
            'controller' => 1,
            'action' => 'index',
        ),
    '/api/:params' =>
        array(
            'module' => 'backend',
            'controller' => 'rest',
            'action' => 'execute',
            'params' => 1,
        ),
    '/module/demo/:controller/:action/:params' =>
        array(
            'controller' => 1,
            'action' => 2,
            'params' => 3,
            'namespace' => 'Modules\\Backend\\Src\\Demo\\Controllers',
            'module' => 'backend',
        ),
    '/demo/demo' =>
        array(
            'controller' => 'Demo',
            'action' => 'index',
            'namespace' => 'Modules\\Backend\\Src\\Demo\\Controllers',
            'module' => 'backend',
        ),
);

