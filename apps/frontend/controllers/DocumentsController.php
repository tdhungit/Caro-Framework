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


class DocumentsController extends ControllerBase
{
    public $documents_page = [
        'install_phalcon' => 'Install PhalconPHP',
        'start' => 'Getting Start',
        'structure' => 'Caro Framework Structure',
        'backend_crud' => 'Create Module with CRUD',
        'backend_layout' => 'Create/Edit module layout',
        'fields_type' => 'Fields Type',
        'subpanels' => 'Sub Panels',
        'permissions' => 'Permissions',
        'api' => 'REST API',
        'logs' => 'Logs',
    ];

    /**
     * initialize
     */
    public function initialize()
    {
        parent::initialize();

        $this->tag->setTitle(' - Caro Framework Documents');

        $this->view->setViewsDir(APP_PATH . 'apps/frontend/views/caro/');
        $this->view->setLayoutsDir('layouts/');
        $this->view->setTemplateAfter('document');

        $this->view->setVar('theme_uri', '/themes/caro');

        // documents sub page
        $this->view->setVar('documents_page', $this->documents_page);
    }

    /**
     * Documents
     */
    public function indexAction()
    {
        $page = $this->request->getQuery('step');

        if (empty($this->documents_page[$page])) {
            $this->tag->prependTitle('Overview');
        } else {
            $this->tag->prependTitle($this->documents_page[$page]);
        }

        if (is_file(APP_PATH . 'apps/frontend/views/caro/documents/' . $page . '.twig')) {
            $this->view->pick('documents/' . $page);
        } else {
            $this->view->pick('documents/index');
        }

        $this->view->setVar('page', $page);
    }
}