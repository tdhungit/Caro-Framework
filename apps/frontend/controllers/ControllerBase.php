<?php

namespace Modules\Frontend\Controllers;


use Modules\Core\MyController;

class ControllerBase extends MyController
{
    /**
     * init controller
     */
    protected function initialize()
    {
        parent::initialize();
        $this->tag->setTitle('Caro Framework');

        // set viewDir
        if (!$this->module_name) {
            $this->view->setViewsDir(APP_PATH . 'apps/' . $this->dispatcher->getModuleName() . '/views/');
            $this->view->setLayoutsDir('../../common/layouts/backend/');
        } else {
            $this->view->setViewsDir(APP_PATH . 'apps/' . $this->dispatcher->getModuleName() . '/src/' . '/' . $this->module_name . '/views/');
            $this->view->setLayoutsDir('../../../../common/layouts/backend/');
        }
    }

    /**
     * get Model
     *
     * @param null|string $model_name
     * @return null
     */
    protected function getModel($model_name = null)
    {
        if ($this->ext_model_name) {
            $model_focus = $this->ext_model_name;
        } else {
            $model_focus = $this->model_name;
        }

        if ($model_name) {
            $model_focus = $model_name;
        }

        if ($this->model_name) {
            if ($this->module_name && !$this->ext_model_name) {
                $model_path = '\\Modules\\Frontend\\Src\\' . $this->module_name . '\\Models\\' . $model_focus;
            } else {
                $model_path = '\\Modules\Frontend\Models\\' . $model_focus;
            }

            $model = new $model_path();
            $model->initialize();

            return $model;
        }

        return null;
    }

}
