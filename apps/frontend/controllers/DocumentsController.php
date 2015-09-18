<?php
/**
 * Created by Jacky.
 * User: Jacky
 * E-Mail: jacky@carocrm.com or jacky@youaddon.com
 * Date: 8/17/2015
 * Time: 11:14 AM
 * Project: carofw
 * File: DocumentsController.php
 */

namespace Modules\Frontend\Controllers;


class DocumentsController extends ControllerCustom
{
    public function indexAction()
    {
        $this->view->setTemplateAfter('document');
        $page = $this->request->getQuery('step');
        switch ($page) {
            case 'start':
                $this->view->pick('documents/start');
                break;
            case 'structure':
                $this->view->pick('documents/structure');
                break;
            case 'backend_crud':
                $this->view->pick('documents/backend_crud');
                break;
            case 'fields_type':
                $this->view->pick('documents/fields_type');
                break;
            case 'subpanels':
                $this->view->pick('documents/subpanels');
                break;
            case 'permissions':
                $this->view->pick('documents/permissions');
                break;
            case 'api':
                $this->view->pick('documents/api');
                break;
            case 'logs':
                $this->view->pick('documents/logs');
                break;
            default:
                break;
        }
    }
}