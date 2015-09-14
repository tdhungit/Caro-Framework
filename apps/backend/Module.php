<?php
/**
 * Created by Jacky.
 * User: Jacky
 * E-Mail: jacky@carocrm.com or jacky@youaddon.com
 * Date: 7/23/2015
 * Time: 1:33 PM
 */

namespace Modules\Backend;

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\DiInterface;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Db\Adapter\Pdo\Mysql as MySQLAdapter;
use Phalcon\Events\Manager as EventsManager;

class Module
{

    public function registerAutoloaders()
    {

        $loader = new Loader();

        $loader->registerNamespaces(array(
            'Modules\Core' => APP_PATH . 'apps/common/core/',
            'Modules\Backend\Controllers' => __DIR__ . '/controllers/',
            'Modules\Backend\Models' => __DIR__ . '/models/',
            'Modules\Backend\Plugins' => __DIR__ . '/plugins/',
            'Modules\Backend\Libraries' => __DIR__ . '/libraries',
        ));

        $loader->register();
    }

    public function registerServices(DiInterface $di)
    {

        /**
         * Read configuration
         */
        $config = include __DIR__ . "/config/config.php";

        $di['dispatcher'] = function () {
            // Security
            $eventsManager = new EventsManager;
            // Check if the user is allowed to access certain action using the SecurityPlugin
            $eventsManager->attach('dispatch:beforeDispatch', new Plugins\SecurityPlugin);
            // Handle exceptions and not-found exceptions using NotFoundPlugin
            //$eventsManager->attach('dispatch:beforeException', new Plugins\NotFoundPlugin);

            $dispatcher = new Dispatcher();
            $dispatcher->setDefaultNamespace("Modules\Backend\Controllers");
            $dispatcher->setEventsManager($eventsManager);
            return $dispatcher;
        };

        /**
         * Setting up the view component
         */
        $di['view'] = function () {

            $view = new View();

            $view->setViewsDir(__DIR__ . '/views/');
            $view->setLayoutsDir('../../common/layouts/backend/');
            $view->setTemplateAfter('/default');

            $view->registerEngines(array(
                ".tpl" => function ($view, $di) {
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
