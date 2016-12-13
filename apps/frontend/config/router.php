<?php
/**
 * Created by Caro Team (info@carocrm.com).
 * User: Jacky (jacky@carocrm.com).
 * Year: 2016
 * File: router.php
 */

return [
    '/' => [
        'module' => 'frontend',
        'controller' => 'index',
        'action' => 'index'
    ],
    '/index' => [
        'module' => 'frontend',
        'controller' => 'index',
        'action' => 'index'
    ],
    '/documents' => [
        'module' => 'frontend',
        'controller' => 'documents',
        'action' => 'index'
    ],
];