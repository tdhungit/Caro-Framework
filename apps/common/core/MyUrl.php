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
    public $backendUrl;

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
}