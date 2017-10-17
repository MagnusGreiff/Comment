<?php

namespace Radchasay\User\HTMLForm;

use \Anax\HTMLForm\FormModel;
use \Radchasay\User\User;
use \Anax\DI\DIInterface;

/**
 * Example of FormModel implementation.
 */
class CreateUserForm extends FormModel
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
                "id" => __CLASS__,
                "legend" => "Create user",
            ],
            [
                "name" => [
                    "type" => "text",
                ],

                "email" => [
                    "type" => "email",
                ],

                "age" => [
                    "type" => "number"
                ],

                "password" => [
                    "type" => "password"
                ],

                "password-again" => [
                    "type" => "password",
                    "validation" => [
                        "match" => "password"
                    ],
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Create user",
                    "callback" => [$this, "callbackSubmit"]
                ],

                "create" => [
                    "type"     => "submit",
                    "value"    => "Back to login",
                    "callback" => [$this, "backToLogin"],
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
        $name = htmlentities($this->form->value("name"));
        $email = htmlentities($this->form->value("email"));
        $age = htmlentities($this->form->value("age"));
        $password = htmlentities($this->form->value("password"));
        $passwordAgain = htmlentities($this->form->value("password-again"));

        // Check password matches
        if ($password !== $passwordAgain) {
            $this->form->rememberValues();
            $this->form->addOutput("Password did not match.");
            return false;
        }

        if ($password == null || $email == null || $name == null || $passwordAgain == null) {
            $this->form->addOutput("Please fill all inputs!");
            return false;
        }

        // Save to database
        /*$db = $this->di->get("db");
        $password = password_hash($password, PASSWORD_DEFAULT);
        $db->connect()
            ->insert("User", ["acronym", "password"])
            ->execute([$acronym, $password]);*/

        $user = new User();
        $user->setDb($this->di->get("db"));
        $user->name = $name;
        $user->email = $email;
        $user->age = $age;
        $user->setPassword($password);
        $user->save();

        //$this->form->addOutput("User was created.");
        $url = $this->di->get("url")->create("user/login");
        $this->di->get("response")->redirect($url);
        return true;
    }

    public function backToLogin()
    {
        $this->di->get("session")->delete("create");
        $url = $this->di->get("url")->create("user/login");
        $this->di->get("response")->redirect($url);
    }
}
