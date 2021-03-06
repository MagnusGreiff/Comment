<?php

namespace Radchasay\User\HTMLForm;

use \Anax\HTMLForm\FormModel;
use \Anax\DI\DIInterface;
use \Radchasay\User\User;

/**
 * Example of FormModel implementation.
 */
class UserLoginForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Anax\DI\DIInterface $di a service container
     */
    public function __construct(DIInterface $di)
    {
        parent::__construct($di);

        $this->form->create(
            [
                "id"     => __CLASS__,
                "legend" => "User Login",
            ],
            [
                "email" => [
                    "type" => "email",
                    //"description" => "Here you can place a description.",
                    //"placeholder" => "Here is a placeholder",
                ],

                "password" => [
                    "type" => "password",
                    //"description" => "Here you can place a description.",
                    //"placeholder" => "Here is a placeholder",
                ],

                "submit" => [
                    "type"     => "submit",
                    "value"    => "Login",
                    "callback" => [$this, "callbackSubmit"],
                ],

                "create" => [
                    "type"     => "submit",
                    "value"    => "Create User",
                    "callback" => [$this, "createUser"],
                ],
            ]
        );
    }


    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return boolean true if okey, false if something went wrong.
     */
    public function callbackSubmit()
    {
        // Get values from the submitted form
        $email = htmlentities($this->form->value("email"));
        $password = htmlentities($this->form->value("password"));

        $user = new User();
        $user->setDB($this->di->get("db"));
        $res = $user->verifyPassword($email, $password);

        if (!$res) {
            //$this->form->remeberValues();
            $this->form->addOutput("User or password did not match");
            return false;
        }


        $this->di->get("session")->set("email", $user->email);
        $url = $this->di->get("url")->create("user/profile");
        $this->di->get("response")->redirect($url);
        $this->form->addOutput("User " . $user->email . " logged in.");
        return true;
    }

    public function createUser()
    {
        $this->di->get("session")->set("create", "true");
        $url = $this->di->get("url")->create("user/create");
        $this->di->get("response")->redirect($url);
    }
}
