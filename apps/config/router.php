<?php
/**
 * Created by Caro Team (info@carocrm.com).
 * User: Jacky (jacky@carocrm.com).
 * Year: 2016
 * File: router.php
 */

/**
 * @param $config
 * @return \Phalcon\Mvc\Router
 */
function getCaroRouter($config)
{
    $router = new \Phalcon\Mvc\Router(false);
    $router->removeExtraSlashes(true);

    // backend
    $backend = include APP_PATH . 'apps/backend/config/router.ini.php';
    // front end
    $frontend = include APP_PATH . 'apps/frontend/config/router.ini.php';

    // all router
    $routes = array_merge($backend, $frontend);
    // add router
    foreach ($routes as $uri => $route) {
        $uri = str_replace('[ADMIN]', $config->application->backendUrl, $uri);
        $router->add($uri, $route);
    }

    return $router;
}