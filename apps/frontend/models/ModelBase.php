<?php

/**
 * Created by Jacky.
 * User: Jacky
 * File: ModelBase.php
 * Project: Caro-Framework
 */

namespace Modules\Frontend\Models;


use Phalcon\Mvc\Model;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;

class ModelBase extends Model
{
    /**
     * init model
     */
    public function initialize() {

    }

    /**
     * @param null $data
     * @param null $whiteList
     * @return bool
     */
    public function create($data = null, $whiteList = null)
    {
        if (empty($this->created)) {
            $this->created = date('Y-m-d H:i:s');
        }

        if (empty($this->user_created_id)) {
            $this->user_created_id = 0;
        }

        if (empty($this->deleted)) {
            $this->deleted = 0;
        }

        if (!empty($this->password)) {
            $this->password = md5($this->password);
        }

        return parent::create($data, $whiteList);
    }

    /**
     * @param $data
     * @param $limit
     * @param $current_page
     * @return \stdclass
     */
    public static function pagination($data, $limit, $current_page)
    {
        $paginator = new PaginatorModel(array(
            "data"  => $data,
            "limit" => $limit,
            "page"  => $current_page > 0 ? $current_page : 1
        ));

        return $paginator->getPaginate();
    }
}