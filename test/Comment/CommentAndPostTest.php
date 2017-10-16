<?php

namespace Radchasay\Comment;

class CommentAndPostTest extends \PHPUnit\Framework\TestCase
{
    public $commentController;
    public $post;
    public $comment;
    public $updatecommentform;
    public $createpostform;
    public $createcommentform;
    public static $db;
    public static $di;

    public function setUp()
    {
        global $di;
        // self::$di = new \Anax\DI\DIFactoryConfig(__DIR__ . "/../dummy_di.php");
        $di = self::$di;
        //$this->commentController = new \Radchasay\Comment\CommentController();
    }

    /**
     * Sets up for all test cases.
     */
    public static function setUpBeforeClass()
    {
        //global $di;
        self::$di = new \Anax\DI\DIFactoryConfig(__DIR__ . "/../dummy_di.php");
    //    $di = self::$di;

        self::$db = self::$di->get("db");
        // self::$db = new \Anax\Database\DatabaseQueryBuilder([
        //     "dsn" => "sqlite::memory:",
        //     "table_prefix" => "radchasay_",
        //     "debug_connect" => true,
        // ]);
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

    /**
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     */
    public function testNewComment()
    {
        self::$di->get("session")->set("email", "mangegreiff@gmail.com");
        $controller = new CommentController();
        $controller->setDI(self::$di);
        list($body, $data, $status) = $controller->newComment(1);
        $this->assertEquals($data["title"], "Create new comment");
        $this->assertEquals($data["stylesheets"][0], "css/style.css");
        $this->assertEquals($status, 200);
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     */
    public function testNewPost()
    {
        $controller = new CommentController();
        $controller->setDI(self::$di);
        list($body, $data, $status) = $controller->newPost();
        $this->assertEquals($data["title"], "Create new post");
        $this->assertEquals($data["stylesheets"][0], "css/style.css");
        $this->assertEquals($status, 200);
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
}
