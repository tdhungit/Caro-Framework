<?php
/**
 * Created by jacky.
 * User: jacky
 * Date: 7/23/2015
 * Time: 1:33 PM
 */

namespace Modules\Backend\Models;

use Phalcon\Validation;

class Users extends ModelBase
{
    public $id;
    public $created;
    public $user_created_id;
    public $deleted;
    public $username;
    public $email;
    public $password;
    public $name;
    public $status;

    public function validation()
    {
        $validation = new Validation();

        $validation->add('username', new Validation\Validator\PresenceOf(array('message' => _('The username is required'))));
        $validation->add('username', new Validation\Validator\Uniqueness(array('message' => _('The username is already registered'))));
        $validation->add('email', new Validation\Validator\PresenceOf(array('message' => _('The email is required'))));
        $validation->add('email', new Validation\Validator\Email(array('message' => _('The e-mail is not valid'))));
        $validation->add('email', new Validation\Validator\Uniqueness(array('message' => _('The email is already registered'))));
        $validation->add('password', new Validation\Validator\PresenceOf(array('message' => _('The password is required'))));
        $validation->add('name', new Validation\Validator\PresenceOf(array('message' => _('The name is required'))));
    }

}