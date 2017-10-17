<?php

namespace Radchasay\Comment\HTMLForm;

use \Anax\HTMLForm\FormModel;
use \Anax\DI\DIInterface;
use \Radchasay\Comment\Post;

/**
 * Example of FormModel implementation.
 */
class CreatePostForm extends FormModel
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
                "legend" => "Create Post",
            ],
            [
                "title" => [
                    "type" => "text",
                ],

                "text" => [
                    "type" => "text",
                ],

                "submit" => [
                    "type"     => "submit",
                    "value"    => "Create Post",
                    "callback" => [$this, "callbackSubmit"],
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
        //
        $post = new Post();
        $post->setDB($this->di->get("db"));
        $post->posttitle = htmlentities($this->form->value("title"));
        $post->posttext = htmlentities($this->form->value("text"));
        $post->postname = htmlentities($this->di->get("session")->get("email"));


        $post->save();

        $url = $this->di->get("url")->create("comment/viewAllPosts");
        $this->di->get("response")->redirect($url);
        return true;
    }
}
