<?php

namespace Radchasay\Comment;

use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;

/**
 * A controller for commentsystem
 *
 * @SuppressWarnings(PHPMD.ExitExpression)
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class CommentController implements InjectionAwareInterface
{

    use InjectionAwareTrait;

    public function checkLogin($modelName, $id = null)
    {
        if ($this->di->get("session")->has("email")) {
            if ($id !== null) {
                $this->di->get("commentModel")->$modelName($id);
            }
            $this->di->get("commentModel")->$modelName();
        } else {
            $login = $this->di->get("url")->create("user/login");
            $this->di->get("response")->redirect($login);
            exit;
        }
    }

    public function commentConnect()
    {
        $this->di->get("database")->connect();
    }

    public function deleteComment($commentId)
    {
        $this->di->get("commentModel")->deleteComment($commentId);
    }

    public function editComment($commentId)
    {
        $this->di->get("commentModel")->editComment($commentId);
    }
    // public function editCommentSubmit()
    // {
    //     $data = $this->di->get("request")->getPost();
    //     $this->di->get("commentModel")->editCommentSubmit($data);
    // }



    public function newPost()
    {
        $this->di->get("commentModel")->newPost();
    }


    public function viewAllPosts()
    {
        $this->di->get("commentModel")->viewAllPosts();
    }


    public function newComment($id)
    {
        $this->checkLogin("newComment", $id);
    }

    public function postAndComments($id)
    {
        $this->di->get("commentModel")->postAndComments($id);
    }
}
