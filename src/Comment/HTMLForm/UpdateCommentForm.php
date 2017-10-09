<?php

namespace Radchasay\Comment\HTMLForm;

use \Anax\HTMLForm\FormModel;
use \Anax\DI\DIInterface;
use \Radchasay\Comment\Comment;

/**
 * Form to update an item.
 */
class UpdateCommentForm extends FormModel
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
        $commentInfo = $this->getItemDetails($id);
        $this->form->create(
            [
                "id"     => __CLASS__,
                "legend" => "Update details of the item",
            ],
            [
                "id"    => [
                    "type"     => "hidden",
                    "value"    => $commentInfo->idcomment,
                ],
                "text" => [
                    "type"       => "text",
                    "value"      => $commentInfo->commenttext,
                ],

                "submit" => [
                    "type"     => "submit",
                    "value"    => "Edit comment",
                    "callback" => [$this, "callbackSubmit"],
                ],
            ]
        );
    }


    /**
     * Get details on item to load form with.
     *
     * @param integer $id get details on item with id.
     *
     * @return $comment
     */
    public function getItemDetails($id)
    {
        $comment = new Comment();
        $comment->setDb($this->di->get("db"));
        $comment->find("idcomment", $id);
        return $comment;
    }


    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return boolean true if okey, false if something went wrong.
     */
    public function callbackSubmit()
    {
        $comment = new Comment();
        $comment->setDb($this->di->get("db"));
        $comment->find("idcomment", $this->form->value("id"));
        $data = $this->form->value("text");
        $text = $this->di->get("textfilter")->doFilter($data, ["bbcode",
        "clickable", "shortcode", "markdown", "purify"]);
        $comment->commenttext = $text;
        $id = $this->form->value("id");
        $comment->save("idcomment", $id);
        $id = $this->form->value("id");
        $postid = $comment->idpost;
        $url = $this->di->get("url")->create("comment/retrieve/{$postid}");
        $this->di->get("response")->redirect($url);
    }
}
