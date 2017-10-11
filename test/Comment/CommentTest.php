<?php

namespace Radchasay\Comment;

class CommentTest extends \PHPUnit\Framework\TestCase
{
    public $di;
    public $commentController;
    public $post;
    public $comment;
    public $updatecommentform;
    public $createpostform;
    public $createcommentform;
    public function setUp()
    {
        $this->di = new \Anax\DI\DIFactoryConfig(__DIR__ . "/../dummy_di.php");
        $this->commentController = new \Radchasay\Comment\CommentController();
        $this->post = new \Radchasay\Comment\Post();
        $this->comment = new \Radchasay\Comment\Comment();
    }

    public function testObject()
    {
        $this->assertInstanceOf("\Radchasay\Comment\CommentController", $this->commentController);
    }

    public function testPostGetInformation()
    {
        $this->post->setDb($this->di->get("db"));
        $res = $this->post->getInformation("hej@ööfld.com");
        $this->assertEquals($res->postname, "hej@ööfld.com");
        $this->assertEquals($res->posttitle, "post2");
        $this->assertEquals($res->posttext, "some post about something random");
    }


    public function testCommentGetSpecificCommentsFromPost()
    {
        $this->comment->setDb($this->di->get("db"));
        $res = $this->comment->getAllCommentsFromSpecificPost("Call CheckComment(?)", [2]);
        $this->assertEquals($res[0]->idcomment, 3);
        $this->assertEquals($res[0]->commenttext, "fsdfsdf");
        $this->assertEquals($res[0]->idpost, 2);
        $this->assertEquals($res[1]->Text, "some post about something random");
    }


    public function testCommentGetInformation()
    {
        $this->comment->setDb($this->di->get("db"));
        $res = $this->comment->getInformation("l@lc.com");
        $this->assertEquals($res->postuser, "l@lc.com");
        $this->assertEquals($res->idpost, "2");
        $this->assertEquals($res->commenttext, "fsdfsdf");
        $this->assertEquals($res->idcomment, "3");
    }

    public function testUpdateCommentForm()
    {
        $this->updatecommentform = new \Radchasay\Comment\HTMLForm\UpdateCommentForm($this->di, 1);
        $res = $this->updatecommentform->getitemDetails(3);
        $this->assertEquals($res->postuser, "l@lc.com");
        $this->assertEquals($res->idpost, "2");
        $this->assertEquals($res->commenttext, "fsdfsdf");
        $this->assertEquals($res->idcomment, "3");
    }

    public function testCreateCommentForm()
    {
        $this->createcommentform = new \Radchasay\Comment\HTMLForm\CreateCommentForm($this->di, 1);
    }
    //
    //
    public function testCreatePostForm()
    {
        $this->createpostform = new \Radchasay\Comment\HTMLForm\CreatePostForm($this->di);
    }


    // public function testCreateCommentAndDelete()
    // {
    //     $this->comment->setDb($this->di->get("db"));
    //     $this->comment->commenttext = "halloj";
    //     $this->comment->idpost = 2;
    //     $this->comment->postuser = "comment@comment.com";
    //
    //     $this->comment->save();
    //
    //     $res = $this->comment->getInformation("comment@comment.com");
    //
    //     $this->assertEquals($res->postuser, "comment@comment.com");
    //
    //     var_dump($res->idcomment);
    //
    //     // var_dump($res->idcomment);
    //     $this->commentController->deleteComment($res->idcomment);
    //     // $res = $this->comment->getInformation("comment@comment.com");
    //     // $this->assertEquals($res->postuser, false);
    //
    //
    // }
}
