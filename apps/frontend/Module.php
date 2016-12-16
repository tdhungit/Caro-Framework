<?php

namespace Modules\Frontend;

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\DiInterface;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Db\Adapter\Pdo\Mysql as MySQLAdapter;

class Module
{
    /**
     * register namespace
     */
    public function registerAutoloaders()
    {

        $loader = new Loader();

        $loader->registerNamespaces(array(
            'Modules\Core' => APP_PATH . 'apps/common/core/',
            'Modules\Frontend\Controllers' => __DIR__ . '/controllers/',
            'Modules\Frontend\Models' => __DIR__ . '/models/',
            'Modules\Frontend\Src' => __DIR__ . '/src/',
        ));

        $loader->register();
    }

    /**
     * register services
     *
     * @param DiInterface $di
     */
    public function registerServices(DiInterface $di)
    {

        /**
         * Read configuration
         */
        $config = require __DIR__ . "/config/config.php";

        $di['dispatcher'] = function () {
            $dispatcher = new Dispatcher();
            $dispatcher->setDefaultNamespace("Modules\Frontend\Controllers");
            return $dispatcher;
        };

        /**
         * Setting up the view component
         */
        $di['view'] = function () use ($config) {
            $view = new View();

            $view->registerEngines(array(
                ".twig" => function ($view, $di) {
                    $volt = new \Phalcon\Mvc\View\Engine\Volt($view, $di);
                    $volt->setOptions(array(
                        "compiledPath" => "../apps/cache/volt/"
                    ));
                    return $volt;
                }
            ));

            return $view;
        };

        /**
         * Database connection is created based in the parameters defined in the configuration file
         */
        $di['db'] = function () use ($config) {
            return new MySQLAdapter(array(
                "host" => $config->database->host,
                "username" => $config->database->username,
                "password" => $config->database->password,
                "dbname" => $config->database->name,
                "charset" => "utf8"
            ));
        };
    }
}
