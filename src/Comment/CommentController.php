<?php

namespace Radchasay\Comment;

use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;
use \Radchasay\Comment\Post;
use \Radchasay\Comment\Comment;
use \Radchasay\User\User;
use \Radchasay\Comment\HTMLForm\CreatePostForm;
use \Radchasay\Comment\HTMLForm\CreateCommentForm;
use \Radchasay\Comment\HTMLForm\UpdateCommentForm;

/**
 * CommentModel
 */
class CommentController implements InjectionAwareInterface
{
    use InjectionAwareTrait;

    public function deleteComment($commentId)
    {
        $comment = new Comment();
        $comment->setDb($this->di->get("db"));
        $comment->delete("idcomment", $commentId);
        $url = $_SERVER["HTTP_REFERER"];
        $this->di->get("response")->redirect($url);
    }

    public function editComment($commentid)
    {
        $title = "Update comment";
        $view = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");
        $form = new UpdateCommentForm($this->di, $commentid);

        $form->check();

        $data = [
            "form" => $form->getHTML(),
        ];

        $view->add("comment/editComment", $data);

        $pageRender->renderPage(["title" => $title]);
    }

    public function viewAllPosts()
    {
        $title = "Retrieve all posts";
        $view = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");
        $post = new Post();
        $post->setDb($this->di->get("db"));

        $data = [
            "items" => $post->findAll(),
        ];

        $view->add("comment/viewAllPosts", $data);

        $pageRender->renderPage(["title" => $title]);
    }

    public function newPost()
    {
        $title = "Create new post";
        $view = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");
        $form = new CreatePostForm($this->di);

        $form->check();

        $data = [
            "form" => $form->getHTML(),
        ];

        $view->add("comment/addNewPost", $data);

        $pageRender->renderPage(["title" => $title]);
    }

    public function newComment($id)
    {
        if ($this->di->get("session")->has("email")) {
            $title = "Create new comment";
            $view = $this->di->get("view");
            $pageRender = $this->di->get("pageRender");
            $form = new CreateCommentForm($this->di, $id);

            $form->check();

            $data = [
                "form" => $form->getHTML(),
            ];

            $view->add("comment/addNewComment", $data);

            $pageRender->renderPage(["title" => $title]);
        } else {
            $login = $this->di->get("url")->create("user/login");
            $this->di->get("response")->redirect($login);
            exit;
        }
    }

    public function postAndComments($id)
    {
        $title = "Retrieve one post with comments";
        $view = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");
        $post = new Post();
        $post->setDb($this->di->get("db"));
        if ($this->di->get("session")->has("email")) {
            $user = new User();
            $user->setDb($this->di->get("db"));
            $email = $this->di->get("session")->get("email");
            $userInfo = $user->find("email", $email);
            $permissions = $userInfo->permissions;
        } else {
            $permissions = "user";
        }


        $data = [
            "post" => $post->find("id", $id),
            "comments" => $this->di->get("db")->executeFetchAll("Call CheckComment($id)"),
            "permissions" => $permissions
        ];

        $view->add("comment/onePostWithComment", $data);

        $pageRender->renderPage(["title" => $title]);
    }
}
