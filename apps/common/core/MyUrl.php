<?php
/**
 * Created by PhpStorm.
 * User: Jacky
 * Date: 9/5/2015
 * Time: 10:56 AM
 */

namespace Modules\Core;


use Phalcon\Mvc\Url;

class MyUrl extends Url
{
    /**
     * @var string backend url
     */
    public $backendUrl;

    /**
     * @param array $query
     * @param array $exception
     * @return array
     */
    public function currentQuery($query = [], $exception = [])
    {
        $exception[] = '_url';
        $exception[] = 'submit';

        foreach ($exception as $unset_key) {
            unset($query[$unset_key]);
        }

        return $query;
    }

    /**
     * get backend url
     * example $this->url->backendUrl('/dashboard') => /admin/dashboard
     * @param null $uri
     * @param null $args
     * @param null $local
     * @param null $baseUri
     * @return string
     */
    public function backendUrl($uri = null, $args = null, $local = null, $baseUri = null)
    {
        return $this->get('/' . $this->backendUrl . $uri, $args, $local, $baseUri);
    }

    /**
     * @param null $args
     * @param null $local
     * @param null $baseUri
     * @return string
     */
    public function currentUrl($args = null, $local = null, $baseUri = null)
    {
        $router = $this->getDI()->getRouter();
        $uri = $router->getRewriteUri();
        return $this->get($uri, $args, $local, $baseUri);
    }
}