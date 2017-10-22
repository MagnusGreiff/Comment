<?php

namespace Radchasay\Comment\HTMLForm;

use \Anax\HTMLForm\FormModel;
use \Anax\DI\DIInterface;
use \Radchasay\Comment\Comment;
use \Radchasay\User\User;

/**
 * Example of FormModel implementation.
 */
class CreateCommentForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Anax\DI\DIInterface $di a service container
     */
    public function __construct(DIInterface $di, $id)
    {
        parent::__construct($di);

        $this->form->create(
            [
                "id"     => __CLASS__,
                "legend" => "Create new comment",
            ],
            [
                    "text"    => [
                        "type"     => "textarea"
                    ],

                    "hidden" => [
                        "type"       => "hidden",
                        "value"      => $id,
                    ],

                    "submit" => [
                        "type"     => "submit",
                        "value"    => "Create comment",
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

        $comment = new Comment();
        $comment->setDB($this->di->get("db"));
        $data = $this->form->value("text");
        $text = $this->di->get("textfilter")->doFilter($data, ["shortcode", "markdown", "clickable", "bbcode"]);
        $comment->commenttext = $text;
        $comment->idpost = $this->form->value("hidden");
        $comment->postuser = $this->di->get("session")->get("email");

        $user = new User();
        $user->setDb($this->di->get("db"));
        $user->getInformation($comment->postuser);
        $user->points += 1;


        $comment->save();
        $user->save();

        $url = $this->di->get("url")->create("comment/retrieve/$comment->idpost");
        $this->di->get("response")->redirect($url);
        return true;
    }
}
