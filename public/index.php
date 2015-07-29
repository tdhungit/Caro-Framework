<?php

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
    $di['router'] = function () {

        $router = new \Phalcon\Mvc\Router(false);

        $router->add('/admin', array(
            'module' => 'backend',
            'controller' => 'index',
            'action' => 'index'
        ));

        $router->add('/admin/:controller/:action/:params', array(
            'module' => 'backend',
            'controller' => 1,
            'action' => 2,
            'params' => 3
        ));

        $router->add('/admin/:controller', array(
            'module' => 'backend',
            'controller' => 1,
            'action' => 'index'
        ));

        $router->add('/index', array(
            'module' => 'frontend',
            'controller' => 'index',
            'action' => 'index'
        ));

        $router->add('/', array(
            'module' => 'frontend',
            'controller' => 'index',
            'action' => 'index'
        ));

        return $router;
    };

    /**
     * The URL component is used to generate all kind of urls in the application
     */
    $di->set('url', function () use ($config) {
        $url = new \Phalcon\Mvc\Url();
        $url->setBaseUri($config->application->baseUrl);
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
            'error'     => 'alert alert-block alert-danger',
            'success'   => 'alert alert-block alert-success',
            'notice'    => 'alert alert-block alert-info',
            'warning'   => 'alert alert-block alert-warning'
        ]);
    });

    /**
     * Setup const var
     */
    $di->set('carofw', function() {
        return include APP_PATH . 'apps/config/const.php';
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
