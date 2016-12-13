<?php
/**
 * Created by Jacky.
 * User: Jacky
 * E-Mail: jacky@carocrm.com or jacky@youaddon.com
 * Date: 7/29/2015
 * Time: 9:24 AM
 * Project: carofw
 */

error_reporting(E_ALL);

try {
    define('APP_PATH', realpath('..') . '/');

    /**
     * load config
     */
    $config = new \Phalcon\Config\Adapter\Ini('../apps/config/config.ini');

    /**
     * The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
     */
    $di = new \Phalcon\DI\FactoryDefault();

    /**
     * Registering a router
     */
    $di['router'] = function () use ($config) {
        include APP_PATH . '/apps/config/router.php';
        return getCaroRouter($config);
    };

    /**
     * The URL component is used to generate all kind of urls in the application
     */
    $di->set('url', function () use ($config) {
        $url = new \Modules\Core\MyUrl();
        $url->setBaseUri($config->application->baseUrl);
        $url->backendUrl = $config->application->backendUrl;
        return $url;
    });

    /**
     * Start the session the first time some component request the session service
     */
    $di->set('session', function () {
        $session = new \Phalcon\Session\Adapter\Files();
        $session->start();
        return $session;
    });

    /**
     * Set up the flash session service as flash
     */
    $di->set('flash', function () {
        return new Phalcon\Flash\Session([
            'error' => 'alert alert-block alert-danger',
            'success' => 'alert alert-block alert-success',
            'notice' => 'alert alert-block alert-info',
            'warning' => 'alert alert-block alert-warning'
        ]);
    });

    /**
     * Set Cookies
     */
    $di->set('cookies', function () {
        $cookies = new Phalcon\Http\Response\Cookies();
        $cookies->useEncryption(false);
        return $cookies;
    });

    /**
     * Setup const var
     */
    $di->set('carofw', function () use ($config) {
        $caroApp = include APP_PATH . 'apps/config/const.php';
        $caroApp['backendUrl'] = $config->application->backendUrl;
        return $caroApp;
    });

    /**
     * Handle the request
     */
    $application = new \Phalcon\Mvc\Application();

    $application->setDI($di);

    /**
     * Register application modules
     */
    $application->registerModules(array(
        'frontend' => array(
            'className' => 'Modules\Frontend\Module',
            'path' => '../apps/frontend/Module.php'
        ),
        'backend' => array(
            'className' => 'Modules\Backend\Module',
            'path' => '../apps/backend/Module.php'
        )
    ));

    echo $application->handle()->getContent();

} catch (Phalcon\Exception $e) {
    echo $e->getMessage();
} catch (PDOException $e) {
    echo $e->getMessage();
}
