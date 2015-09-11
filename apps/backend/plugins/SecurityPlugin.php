<?php
/**
 * Created by Jacky.
 * User: Jacky
 * E-Mail: jacky@carocrm.com or jacky@youaddon.com
 * Project: carofw
 * File: SecurityPlugin.php
 */

namespace Modules\Backend\Plugins;

use Modules\Backend\Models\AuthRoles;
use Modules\Backend\Models\CaroLogs;
use Phalcon\Acl;
use Phalcon\Acl\Role;
use Phalcon\Acl\Resource;
use Phalcon\Events\Event;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Acl\Adapter\Memory as AclList;

/**
 * SecurityPlugin
 *
 * This is the security plugin which controls that users only have access to the modules they're assigned to
 */
class SecurityPlugin extends Plugin
{

    /**
     * Returns an existing or new access control list
     *
     * @returns AclList
     */
    public function getAcl()
    {
        if (!isset($this->persistent->acl)) {

            $acl = new AclList();

            $acl->setDefaultAction(Acl::DENY);

            // Register roles
            $roles = include AuthRoles::rolesPath();
            foreach ($roles as $role) {
                $acl->addRole($role);
            }

            $resources = include AuthRoles::resourcesPath();
            foreach ($resources as $resource => $actions) {
                $acl->addResource(new Resource($resource), $actions);
            }

            //Grant access to public areas to both users and guests
            foreach ($roles as $role) {
                $file_allow_resource = AuthRoles::permissionSavePath() . 'role_allow_' . $role . '.php';
                if (is_file($file_allow_resource)) {
                    $allow_resources = include $file_allow_resource;
                    foreach ($allow_resources as $resource => $actions) {
                        foreach ($actions as $action) {
                            $acl->allow($role->getName(), $resource, $action);
                        }
                    }
                }
            }

            //The acl is stored in session, APC would be useful here too
            $this->persistent->acl = $acl;
        }

        return $this->persistent->acl;
    }

    /**
     * This action is executed before execute any action in the application
     *
     * @param Event $event
     * @param Dispatcher $dispatcher
     * @return bool
     */
    public function beforeDispatch(Event $event, Dispatcher $dispatcher)
    {
        $auth = $this->session->get('auth');
        $controller = $dispatcher->getControllerName();
        $action = $dispatcher->getActionName();

        // public resources
        $public_resources = AuthRoles::publicResources();
        foreach ($public_resources as $public_resource => $public_actions) {
            if (is_array($public_actions)) {
                if ($controller == $public_resource && in_array($action, $public_actions)) {
                    return true;
                }
            } else {
                if ($controller == $public_resource && $public_actions == '*') {
                    return true;
                }
            }
        }

        // admin
        if (!empty($auth['username']) && $auth['username'] == 'admin') {
            return true;
        }

        // not admin
        if (!$auth || empty($auth['roles'])) {
            $roles = array('guests');
        } else {
            $roles = $auth['roles'];
        }

        $acl = $this->getAcl();
        foreach ($roles as $role) {
            $allowed = $acl->isAllowed($role, $controller, $action);
            if ($allowed == Acl::ALLOW) {
                return true;
                break;
            }
        }

        if ($allowed != Acl::ALLOW) {
            $dispatcher->forward(array(
                'controller' => 'errors',
                'action' => 'show401'
            ));

            /*if ($auth) {
                $this->session->destroy();
            }*/

            return false;
        }

    }
}
