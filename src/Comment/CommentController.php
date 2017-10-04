<?php

namespace Radchasay\Comment;

use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;

/**
 * A controller for commentsystem
 *
 * @SuppressWarnings(PHPMD.ExitExpression)
 */
class CommentController implements InjectionAwareInterface
{
    
    use InjectionAwareTrait;
    
    public function commentConnect()
    {
        $this->di->get("database")->connect();
    }
    
    public function postRetrieve()
    {
        $this->di->get("commentModel")->getPosts();
    }
    
    public function postRetrieveOneAndComments($postId)
    {
        $this->di->get("commentModel")->getOnePostAndComments($postId);
    }
    
    public function postCreate()
    {
        $data = $this->di->get("request")->getPost();
        $this->di->get("commentModel")->postCreate($data);
    }
    
    public function commentCreate()
    {
        $data = $this->di->get("request")->getPost();
        
        $this->di->get("commentModel")->commentCreate($data);
    }
    
    public function newPost()
    {
        $this->di->get("commentModel")->newPost();
    }
    
    public function newComment()
    {
        $this->checkLogin("newComment");
    }
    
    
    public function checkLogin($modelName)
    {
        if ($this->di->get("session")->has("name")) {
            $this->di->get("commentModel")->$modelName();
        } else {
            $login = $this->di->get("url")->create("user/login");
            $this->di->get("response")->redirect($login);
            exit;
        }
    }
    
    public function deleteComment($commentId)
    {
        $this->di->get("commentModel")->deleteComment($commentId);
    }
    
    public function editComment($commentId)
    {
        $this->di->get("commentModel")->editComment($commentId);
    }
    
    public function editCommentSubmit()
    {
        $data = $this->di->get("request")->getPost();
        $this->di->get("commentModel")->editCommentSubmit($data);
    }
}
