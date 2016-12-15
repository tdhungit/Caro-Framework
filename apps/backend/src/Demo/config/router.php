<?php
/**
 * Created by Caro Team (info@carocrm.com).
 * User: Jacky (jacky@carocrm.com).
 * Year: 2016
 * File: router.php
 */

return [
    '/demo/:controller/:action/:params' => [
        'controller' => 1,
        'action' => 2,
        'params' => 3
    ],
    '/demo/demo' => [
        'controller' => 'Demo',
        'action' => 'index'
    ]
];