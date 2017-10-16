<?php

namespace Radchasay\Comment;

class CommentTest extends \PHPUnit\Framework\TestCase
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
    }

    public function testCreateCommentForm()
    {
        $this->createcommentform = new \Radchasay\Comment\HTMLForm\CreateCommentForm(self::$di, 1);
    }

    public function testCreatePostForm()
    {
        $this->createpostform = new \Radchasay\Comment\HTMLForm\CreatePostForm(self::$di);
    }
}
