<?php

namespace Radchasay\Comment;

use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;
use \Radchasay\Comment\Post;
use \Radchasay\Comment\Comment;
use \Radchasay\Comment\CommentComments;
use \Radchasay\Comment\PostCategory;
use \Radchasay\User\User;
use \Radchasay\Comment\HTMLForm\CreatePostForm;
use \Radchasay\Comment\HTMLForm\CreateCommentForm;
use \Radchasay\Comment\HTMLForm\UpdateCommentForm;
use \Radchasay\Comment\HTMLForm\CreateCommentCommentForm;

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


        $commentComments = new CommentComments();
        $commentComments->setDb($this->di->get("db"));

        $test = $commentComments->getAllCommentFromComments([$commentId]);

        $commentComments->getNext();

        if (!empty($test)) {
            foreach ($test as $t) {
                $this->deleteCommentComment($t->idcommentc, true);
                $commentComments->getNext();
            }
        }

        $comment->delete("idcomment", $commentId);
        $createUrl = $this->di->get("url")->create("comment/viewAllPosts");
        $url = isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : $createUrl;
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

        return $pageRender->renderPage(["title" => $title]);
    }

    public function viewAllPosts()
    {
        $title = "Retrieve all posts";
        $view = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");
        $post = new Post();
        $post->setDb($this->di->get("db"));

        $posts = $post->getAllPosts();

        $allPosts = [];

        foreach ($posts as $p) {
            array_push($allPosts, [$p, $post->getTags([$p->postid])]);
        }

        $data = [
            "items" => $allPosts,
        ];

        $view->add("comment/viewAllPosts", $data);

        return $pageRender->renderPage(["title" => $title]);
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

        return $pageRender->renderPage(["title" => $title]);
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

            return $pageRender->renderPage(["title" => $title]);
        } else {
            $login = $this->di->get("url")->create("user/login");
            $this->di->get("response")->redirect($login);
            return false;
        }
    }

    public function postAndComments($id)
    {
        $title = "Retrieve one post with comments";
        $view = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");
        $post = new Post();
        $post->setDb($this->di->get("db"));
        if ($post->checkId($id)) {
            if ($this->di->get("session")->has("email")) {
                $email = $this->di->get("session")->get("email");
                $user = new User();
                $user->setDb($this->di->get("db"));
                $permissions = $user->returnPermissions($email);
            } else {
                $permissions = "user";
            }

            $comment = new Comment();
            $comment->setDb($this->di->get("db"));
            $comments = $comment->getAllCommentsFromSpecificPost([$id]);

            $comment->getNext();

            $commentComments = new CommentComments();
            $commentComments->setDb($this->di->get("db"));

            $allComments = [];

            foreach ($comments as $comment) {
                array_push($allComments, [$comment,
                $commentComments->getAllCommentFromComments([$comment->idcomment])]);
                $commentComments->getNext();
            }

            $data = [
                "post" => $post->getPostInfo([$id]),
                "comments" => $allComments,
                "permissions" => $permissions,
                "tags" => $post->getTags([$id])
            ];

            $view->add("comment/onePostWithComment", $data);

            return $pageRender->renderPage(["title" => $title]);
        } else {
            $url = $this->di->get("url")->create("comment/viewAllPosts");
            $this->di->get("response")->redirect($url);
        }
    }

    public function newCommentComment($idcomment, $idpost)
    {
        if ($this->di->get("session")->has("email")) {
            $title = "Create new comment";
            $view = $this->di->get("view");
            $pageRender = $this->di->get("pageRender");
            $form = new CreateCommentCommentForm($this->di, $idcomment, $idpost);

            $form->check();

            $data = [
                "form" => $form->getHTML(),
            ];

            $view->add("comment/addNewComment", $data);

            return $pageRender->renderPage(["title" => $title]);
        } else {
            $login = $this->di->get("url")->create("user/login");
            $this->di->get("response")->redirect($login);
            return false;
        }
    }

    public function deleteCommentComment($id, $nested = false)
    {
        if (!$nested) {
            $commentcomments = new CommentComments();
            $commentcomments->setDb($this->di->get("db"));
            $commentcomments->delete("idcommentc", $id);
            $createUrl = $this->di->get("url")->create("comment/viewAllPosts");
            $url = isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : $createUrl;
            $this->di->get("response")->redirect($url);
        } else {
            $commentcomments = new CommentComments();
            $commentcomments->setDb($this->di->get("db"));
            $commentcomments->delete("idcommentc", $id);
        }
    }


    public function returnCatId($category)
    {
        $cat = new PostCategory();
        $cat->setDb($this->di->get("db"));
        $id = $cat->getId($category);
        return $id;
    }
}
