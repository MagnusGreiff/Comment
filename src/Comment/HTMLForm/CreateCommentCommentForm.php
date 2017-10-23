<?php

namespace Radchasay\Comment\HTMLForm;

use \Anax\HTMLForm\FormModel;
use \Anax\DI\DIInterface;
use \Radchasay\Comment\CommentComments;
use \Radchasay\User\User;

/**
 * Example of FormModel implementation.
 */
class CreateCommentCommentForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Anax\DI\DIInterface $di a service container
     */
    public function __construct(DIInterface $di, $idcomment, $idpost)
    {
        parent::__construct($di);

        $this->form->create(
            [
                "id"     => __CLASS__,
                "legend" => "Create new comment"
            ],
            [
                    "text"    => [
                        "type"     => "textarea"
                    ],

                    "hiddenid" => [
                        "type"       => "hidden",
                        "value"      => $idcomment,
                    ],

                    "hiddenpost" => [
                        "type" => "hidden",
                        "value" => $idpost,
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
        //
        $commentComment = new CommentComments();
        $commentComment->setDB($this->di->get("db"));
        $data = $this->form->value("text");
        $text = $this->di->get("textfilter")->doFilter($data, ["bbcode", "clickable",
        "shortcode", "markdown", "purify"]);
        $commentComment->textcomment = $text;
        $commentComment->idcommentcomment = htmlentities($this->form->value("hiddenid"));
        $commentComment->postuser = $this->di->get("session")->get("email");

        $idpost = htmlentities($this->form->value("hiddenpost"));
        $user = new User();
        $user->setDb($this->di->get("db"));
        $user->getInformation($commentComment->postuser);
        $user->points += 1;

        $user->save();
        $commentComment->save();

        $url = $this->di->get("url")->create("comment/retrieve/$idpost");
        $this->di->get("response")->redirect($url);
        return true;
    }
}
