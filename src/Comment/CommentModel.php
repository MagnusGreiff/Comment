<?php

namespace Radchasay\Comment;

use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;

/**
 * CommentModel
 */
class CommentModel implements InjectionAwareInterface
{
    use InjectionAwareTrait;
    
    public function getPosts()
    {
        $posts = $this->di->get("database")->executeFetchAll("SELECT * FROM Posts");
        
        $this->di->get("view")->add("comment/posts", [
            "content" => $posts,
        ]);
        $this->di->get("pageRender")->renderPage(null, 200, "All Posts");
    }
    
    public function getOnePostAndComments($id)
    {
        if ($this->di->get("session")->has("name")) {
            $email = $this->di->get("session")->get("name");
            $sql = "SELECT permissions FROM Users WHERE email = ?";
            $getPermission = $this->di->get("database")->executeFetch($sql, [$email]);
        } else {
            $getPermission = ["permissions" => "user"];
        }
        
        $sql = "SELECT * FROM Posts WHERE id = ?";
        $post = $this->di->get("database")->executeFetch($sql, [$id]);
        $postAndComments = $this->di->get("database")->executeFetchAll("Call CheckComment($id)");
        $returnArray = [];
        array_push($returnArray, $post);
        array_push($returnArray, $postAndComments);
        array_push($returnArray, $getPermission);
        
        $this->di->get("view")->add("comment/postAndComments", [
            "content" => $returnArray,
        ]);
        $this->di->get("pageRender")->renderPage(null, 200, "Post and comment");
    }
    
    public function postCreate($data)
    {
        $sql = "INSERT INTO Posts (posttitle, postname, posttext) VALUE (?, ? ,?)";
        $this->di->get("database")->execute($sql, [$data["title"], $data["name"], $data["text"]]);
        
        $url = $this->di->get("url")->create("comment/retrieve");
        
        $this->di->get("response")->redirect($url);
    }
    
    public function commentCreate($data)
    {
        $text = $this->di->get("textfilter")->doFilter($data["text"], ["bbcode", "clickable", "shortcode", "markdown", "purify"]);
        $email = $this->di->get("session")->get("name");
        
        $sql = "INSERT INTO Comments (commenttext, idpost, postuser) VALUE (?,?,?)";
        $this->di->get("database")->execute($sql, [$text, $data["id"], $email]);
        
       
        $id = $data["id"];
        $url = $this->di->get("url")->create("comment/retrieve/$id");
    
        $this->di->get("response")->redirect($url);
    }
    
    public function newPost()
    {
        $this->di->get("view")->add("comment/newPost");
        $this->di->get("pageRender")->renderPage(null, 200, "New Post");
    }
    
    public function newComment()
    {
        $this->di->get("view")->add("comment/newComment");
        $this->di->get("pageRender")->renderPage(null, 200, "New Comment");
    }
    
    public function deleteComment($commentId)
    {
        $sql = "DELETE FROM Comments WHERE idcomment = ?";
        $this->di->get("database")->execute($sql, [$commentId]);
        $url = $_SERVER["HTTP_REFERER"];
        $this->di->get("response")->redirect($url);
    }
    
    public function editComment($commentid)
    {
        $sql = "SELECT * FROM Comments WHERE idcomment = ?";
        $getComment = $this->di->get("database")->executeFetch($sql, [$commentid]);
        $this->di->get("view")->add("comment/editComment", [
            "content" => $getComment,
        ]);
        $this->di->get("pageRender")->renderPage(null, 200, "Post and comment");
    }
    
    public function editCommentSubmit($data)
    {
        $sql = "UPDATE Comments SET commenttext = ? WHERE idcomment = ?";
        $this->di->get("database")->execute($sql, [$data["text"], $data["id"]]);
    
        $id = $data["postid"];
        $url = $this->di->get("url")->create("comment/retrieve/$id");
    
        $this->di->get("response")->redirect($url);
    }
}
