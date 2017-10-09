<?php

namespace Radchasay\User\HTMLForm;

use \Anax\HTMLForm\FormModel;
use \Anax\DI\DIInterface;
use \Radchasay\User\User;

/**
 * Form to update an item.
 */
class AdminUpdateUser extends FormModel
{
    /**
     * Constructor injects with DI container and the id to update.
     *
     * @param Anax\DI\DIInterface $di a service container
     * @param integer             $id to update
     */
    public function __construct(DIInterface $di, $id)
    {
        parent::__construct($di);
        $user = $this->getItemDetails($id);
        $this->form->create(
            [
                "id"     => __CLASS__,
                "legend" => "Update details of the item",
            ],
            [
                "id" => [
                    "type"       => "text",
                    "validation" => ["not_empty"],
                    "readonly"   => true,
                    "value"      => $user->id,
                ],

                "name" => [
                    "type"       => "text",
                    "validation" => ["not_empty"],
                    "value"      => $user->name,
                ],

                "email" => [
                    "type"       => "text",
                    "validation" => ["not_empty"],
                    "value"      => $user->email,
                ],

                "age" => [
                    "type"       => "number",
                    "validation" => ["not_empty"],
                    "value"      => $user->age,
                ],

                "submit" => [
                    "type"     => "submit",
                    "value"    => "Save",
                    "callback" => [$this, "callbackSubmit"],
                ],

                "reset" => [
                    "type" => "reset",
                ],
            ]
        );
    }


    /**
     * Get details on item to load form with.
     *
     * @param integer $id get details on item with id.
     *
     * @return $user
     */
    public function getItemDetails($id)
    {
        $user = new User();
        $user->setDb($this->di->get("db"));
        $user->find("id", $id);
        return $user;
    }


    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return boolean true if okey, false if something went wrong.
     */
    public function callbackSubmit()
    {
        $user = new User();
        $user->setDb($this->di->get("db"));
        $user->find("id", $this->form->value("id"));
        $user->name = $this->form->value("name");
        $user->email = $this->form->value("email");
        $user->age = $this->form->value("age");
        $user->save();
        $url = $this->di->get("url")->create("admin");
        $this->di->get("response")->redirect($url . "/update/{$user->id}");
    }
}
