<?php

namespace Radchasay\User\HTMLForm;

use \Anax\HTMLForm\FormModel;
use \Anax\DI\DIInterface;
use \Radchasay\User\User;

/**
 * Form to delete an item.
 */
class AdminDeleteUserForm extends FormModel
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
                "legend" => "Delete an item",
            ],
            [
                "select" => [
                    "type"    => "select",
                    "label"   => "Select item to delete:",
                    "options" => $this->getAllItems(),
                ],
                
                "submit" => [
                    "type"     => "submit",
                    "value"    => "Delete item",
                    "callback" => [$this, "callbackSubmit"],
                ],
            ]
        );
    }
    
    
    /**
     * Get all items as array suitable for display in select option dropdown.
     *
     * @return array with key value of all items.
     */
    protected function getAllItems()
    {
        $user = new User();
        $user->setDb($this->di->get("db"));
        
        $users = ["-1" => "Select an item..."];
        foreach ($user->findAll() as $obj) {
            $users[ $obj->id ] = "{$obj->email} ({$obj->id})";
        }
        
        return $users;
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
        $user->find("id", $this->form->value("select"));
        $user->delete();
        $this->di->get("response")->redirect("admin/viewUsers");
    }
}
