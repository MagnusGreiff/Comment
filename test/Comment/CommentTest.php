<?php

namespace Radchasay\Comment;

class CommentTest extends \PHPUnit\Framework\TestCase
{
    public $di;
    public $commentController;
    public $commentModel;
    public $post;
    public $comment;
    public $updatecommentform;
    public $createpostform;
    public $createcommentform;
    public function setUp()
    {
        $this->di = new \Anax\DI\DIFactoryConfig("di.php");
        $this->commentController = new \Radchasay\Comment\CommentController();
        $this->commentModel = new \Radchasay\Comment\CommentModel();
        $this->post = new \Radchasay\Comment\Post();
        $this->comment = new \Radchasay\Comment\Comment();
    }

    public function testObject()
    {
        $this->assertInstanceOf("\Radchasay\Comment\CommentController", $this->commentController);
        $this->assertInstanceOf("\Radchasay\Comment\commentModel", $this->commentModel);
    }

    public function testPostGetInformation()
    {
        $this->post->setDb($this->di->get("db"));
        $res = $this->post->getInformation("hej@ööfld.com");
        $this->assertEquals($res->postname, "hej@ööfld.com");
        $this->assertEquals($res->posttitle, "post2");
        $this->assertEquals($res->posttext, "some post about something random");
    }


    public function testCommentGetInformation()
    {
        $this->comment->setDb($this->di->get("db"));
        $res = $this->comment->getInformation("hej@d.com");
        $this->assertEquals($res->postuser, "hej@d.com");
        $this->assertEquals($res->idpost, "1");
        $this->assertEquals($res->commenttext, "jfkldsjflksdjklfsqq");
        $this->assertEquals($res->idcomment, "2");
    }

    public function testUpdateCommentForm()
    {
        $this->updatecommentform = new \Radchasay\Comment\HTMLForm\UpdateCommentForm($this->di, 1);
        $res = $this->updatecommentform->getitemDetails(1);
        $this->assertEquals($res->postuser, "some@f.com");
        $this->assertEquals($res->idpost, "1");
        $this->assertEquals($res->commenttext, "jfsdsjifdsjifdsjifdjifdsio");
        $this->assertEquals($res->idcomment, "1");
    }

    public function testCreateCommentForm()
    {
        $this->createcommentform = new \Radchasay\Comment\HTMLForm\CreateCommentForm($this->di, 1);
    }


    public function testCreatePostForm()
    {
        $this->createpostform = new \Radchasay\Comment\HTMLForm\CreatePostForm($this->di);
    }
}
