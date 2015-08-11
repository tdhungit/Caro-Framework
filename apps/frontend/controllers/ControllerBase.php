<?php

namespace Modules\Frontend\Controllers;


use Modules\Core\MyController;

class ControllerBase extends MyController
{

    protected function initialize()
    {
        parent::initialize();
        $this->tag->setTitle('Caro Framework');
    }

    /**
     * get Model
     *
     * @param null|string $model_name
     * @return null
     */
    protected function getModel($model_name = null)
    {
        if ($model_name) {
            $this->model_name = $model_name;
        }

        if ($this->model_name) {
            $model_path = '\\Modules\Frontend\Models\\' . $this->model_name;
            $model = new $model_path();

            return $model;
        }

        return null;
    }

}
