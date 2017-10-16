<?php

namespace Radchasay\Comment;

class ViewAllTest extends \PHPUnit\Framework\TestCase
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

    public function testViewAllPosts()
    {
        $post = new Post();
        $post->setDb(self::$db);
        $post->postname = "Magnus Greiff";
        $post->posttitle = "Who is Munge?";
        $post->posttext = "Who is Munge?";
        $post->save();

        $controller = new CommentController();
        $controller->setDI(self::$di);
        list($body, $data, $status) = $controller->viewAllPosts();
        $doc = new \DOMDocument();
        $doc->loadHTML($body);
        $res = $doc->getElementsByTagName('p');
        $this->assertEquals($res[0]->textContent, "Create  new post: Click here.");
        $this->assertEquals($res[1]->textContent, "Text: Who is Munge?");
        $this->assertEquals($res[2]->textContent, "Author: Magnus Greiff");
        $this->assertEquals($data["title"], "Retrieve all posts");
        $this->assertEquals($data["stylesheets"][0], "css/style.css");
        $this->assertEquals($status, 200);
    }
}
