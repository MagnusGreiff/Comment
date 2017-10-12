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
    public static $db;

    public function setUp()
    {
        global $di;
        $this->di = new \Anax\DI\DIFactoryConfig(__DIR__ . "/../dummy_di.php");
        $di = $this->di;
        //$this->commentController = new \Radchasay\Comment\CommentController();
    }

    /**
     * Sets up for all test cases.
     */
    public static function setUpBeforeClass()
    {
        self::$db = new \Anax\Database\DatabaseQueryBuilder([
            "dsn" => "sqlite::memory:",
            "table_prefix" => "radchasay_",
            "debug_connect" => true,
        ]);
        self::$db->connect();
        self::$db->createTable(
            "Posts",
            [
                "id" => ["integer", "primary key", "not null"],
                "posttitle" => ["VARCHAR"],
                "posttext" => ["VARCHAR"],
                "postname" => ["VARCHAR"]
            ]
        )->execute();
        self::$db->createTable(
            "Comments",
            [
                "idcomment" => ["integer", "primary key", "not null"],
                "commenttext" => ["text"],
                "idpost" => ["integer"],
                "postuser" => ["VARCHAR"]
            ]
        )->execute();
    }

    public function testComment()
    {
        $comment = new Comment();
        $comment->setDb(self::$db);
        $comment->idcomment = 1;
        $comment->commenttext = "Halloj";
        $comment->idpost = 1;
        $comment->postuser = "comment@comment.com";
        $comment->save();


        $findComment = new Comment();
        $findComment->setDb(self::$db);
        $res = $findComment->getInformation("comment@comment.com");
        $this->assertEquals($comment->postuser, $res->postuser);
        $this->assertEquals($comment->idcomment, $res->idcomment);
    }

    // public function testDeleteComment()
    // {
    //     $comment = new Comment();
    //     $comment->setDb(self::$db);
    //     $comment->idcomment = 2;
    //     $comment->commenttext = "Halloj";
    //     $comment->idpost = 1;
    //     $comment->postuser = "comment@comment.com";
    //     $comment->save();
    //
    //     $controller = new CommentController();
    //     $controller->setDI($this->di);
    //     $controller->deleteComment($comment->idcomment);
    // }

    // public function testViewAllPosts()
    // {
    //     ob_start();
    //     $controller = new CommentController();
    //     $controller->setDI($this->di);
    //     $controller->viewAllPosts();
    //     $length = ob_get_length();
    //     ob_end_clean();
    //
    //     echo $length;
    //     echo "meh";
    // }

    public function testObject()
    {
        $controller = new CommentController();
        $this->assertInstanceOf("\Radchasay\Comment\CommentController", $controller);
    }

    public function testPost()
    {
        $post = new Post();
        $post->setDb(self::$db);
        $post->postname = "Magnus Greiff";
        $post->posttitle = "Who is Munge?";
        $post->posttext = "Who is Munge?";
        $post->save();

        $findPost = new Post();
        $findPost->setDb(self::$db);
        $res = $findPost->getInformation("Magnus Greiff");
        $this->assertEquals($res->postname, $post->postname);
        $this->assertEquals($res->posttitle, $post->posttitle);
    }

    public function testCreateCommentForm()
    {
        $this->createcommentform = new \Radchasay\Comment\HTMLForm\CreateCommentForm($this->di, 1);
    }

    public function testCreatePostForm()
    {
        $this->createpostform = new \Radchasay\Comment\HTMLForm\CreatePostForm($this->di);
    }
//
//
// public function testGetAllCommentsFromSpecificPost()
// {
//     $post = new Post();
//     $post->setDb(self::$db);
//     $post->postname = "Munge";
//     $post->posttitle = "Who is Munge?";
//     $post->posttext = "Who is Munge?";
//     $post->save();
//
//     $comment = new Comment();
//     $comment->setDb(self::$db);
//     $comment->idcomment = 1;
//     $comment->commenttext = "Halloj";
//     $comment->idpost = 1;
//     $comment->postuser = "comment@comment.com";
//     $comment->save();
//
//     $getSpecific = new Comment();
//     $getSpecific->setDb(self::$db);
//     $getSpecific->getAllCommentsFromSpecificPost()
// }
}
