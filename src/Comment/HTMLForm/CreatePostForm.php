<?php

namespace Radchasay\Comment\HTMLForm;

use \Anax\HTMLForm\FormModel;
use \Anax\DI\DIInterface;
use \Radchasay\Comment\Post;
use \Radchasay\User\User;
use \Radchasay\Comment\PostCategory;
use \Radchasay\Comment\Post2Cat;

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
                "class" => "createNewPostForm"
            ],
            [
                "title" => [
                    "type" => "text",
                ],

                "text" => [
                    "type" => "textarea",
                ],

                "tags" => [
                    "type"        => "text",
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
        $title = htmlentities($this->form->value("title"));
        $data = $this->form->value("text");
        $text = $this->di->get("textfilter")->doFilter($data, ["shortcode", "markdown", "clickable", "bbcode"]);

        if (strlen($title) > 50 ) {
            $this->form->addOutput("Title is too long. Please fix!");
            return false;
        } else {
            $post->posttitle = $title;
        }

        $post->posttext = $text;
        $post->postname = htmlentities($this->di->get("session")->get("email"));

        $tags = htmlspecialchars($this->form->value("tags"));

        $user = new User();
        $user->setDb($this->di->get("db"));
        $user->getInformation($post->postname);
        $user->points += 2;

        $user->save();
        $post->save();


        $this->createCategory($tags, $post->id);

        $url = $this->di->get("url")->create("comment/viewAllPosts");
        $this->di->get("response")->redirect($url);
        return true;
    }


    public function createCategory($tags, $postId)
    {
        $postcat = new PostCategory();
        $postcat->setDb($this->di->get("db"));
        $allCats = $postcat->findall();

        $existingCats = [];

        foreach ($allCats as $ac) {
            array_push($existingCats, $ac->category);
        }

        $tags = array_map('trim', explode(',', $tags));

        $tags = array_map("strtoupper", $tags);

        $uniqueTags = [];

        foreach ($tags as $t) {
            if (!in_array($t, $existingCats)) {
                if (!in_array($t, $uniqueTags)) {
                    array_push($uniqueTags, $t);
                }
            }
        }

        foreach ($uniqueTags as $ut) {
            $pc = new PostCategory();
            $pc->setDb($this->di->get("db"));
            $pc->category = $ut;

            $pc->save();
        }
        //
        foreach ($tags as $t) {
            $pc = new PostCategory();
            $pc->setDb($this->di->get("db"));

            $id = $pc->getId($t);

            $p2c = new Post2Cat();
            $p2c->setDb($this->di->get("db"));
            $p2c->catid = $id;
            $p2c->postid = $postId;

            $p2c->save();
        }
    }
}
