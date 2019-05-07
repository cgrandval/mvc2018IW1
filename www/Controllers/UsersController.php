<?php

namespace Mvc\Controllers;
use Mvc\Core\Validator;
use Mvc\Core\View;
use Mvc\Models\Users;

class UsersController
{
    private $users;

    public function __construct(Users $users)
    {
        $this->users = $users;
    }

    public function defaultAction()
    {
        echo 'users default';
    }

    public function addAction()
    {
        $form = $this->users->getRegisterForm();

        $v = new View('addUser', 'front');
        $v->assign('form', $form);
    }

    public function saveAction()
    {
        $form = $this->users->getRegisterForm();

        //Est ce qu'il y a des données dans POST ou GET($form["config"]["method"])
        $method = strtoupper($form['config']['method']);
        $data = $GLOBALS['_'.$method];

        if ($_SERVER['REQUEST_METHOD'] == $method && !empty($data)) {
            $validator = new Validator($form, $data);
            $form['errors'] = $validator->errors;

            if (empty($errors)) {
                $this->users->setFirstname($data['firstname']);
                $this->users->setLastname($data['lastname']);
                $this->users->setEmail($data['email']);
                $this->users->setPwd($data['pwd']);
                $this->users->save();
            }
        }

        $v = new View('addUser', 'front');
        $v->assign('form', $form);
    }

    public function loginAction()
    {
        $form = $this->users->getLoginForm();

        $method = strtoupper($form['config']['method']);
        $data = $GLOBALS['_'.$method];
        if ($_SERVER['REQUEST_METHOD'] == $method && !empty($data)) {
            $validator = new Validator($form, $data);
            $form['errors'] = $validator->errors;

            if (empty($errors)) {
                //Connexion avec token
                //$token = md5(substr(uniqid().time(), 4, 10)."mxu(4il");
            }
        }

        $v = new View('loginUser', 'front');
        $v->assign('form', $form);
    }

    public function forgetPasswordAction()
    {
        $v = new View('forgetPasswordUser', 'front');
    }
}
