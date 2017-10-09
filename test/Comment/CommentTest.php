<?php

namespace Radchasay\Comment;

class CommentTest extends \PHPUnit\Framework\TestCase
{
    public $di;
    public $comment;
    public function setUp()
    {
        $this->di = new \Anax\DI\DIFactoryConfig("di.php");
        $this->comment = new \Radchasay\Comment\CommentController();
    }

    public function testObject()
    {
        $this->assertInstanceOf("\Radchasay\Comment\CommentModel", $this->comment);
    }

}
