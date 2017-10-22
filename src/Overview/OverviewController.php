<?php

namespace Radchasay\Overview;

use \Anax\Configure\ConfigureInterface;
use \Anax\Configure\ConfigureTrait;
use \Anax\DI\InjectionAwareInterface;
use \Anax\Di\InjectionAwareTrait;
use \Radchasay\Comment\Post;
use \Radchasay\Comment\Comment;
use \Radchasay\Comment\CommentComments;
use \Radchasay\Overview\Overview;
use \Radchasay\Comment\PostCategory;

/**
 * A controller class.
 */
class OverviewController implements
    ConfigureInterface,
    InjectionAwareInterface
{
    use ConfigureTrait,
        InjectionAwareTrait;


    /**
     * @var $data description
     */
    //private $data;


    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return void
     */
    public function getIndex()
    {
        $title = "A index page";
        $view = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");
        $db = $this->di->get("db");

        $user = new User();
        $user->setDb($db);
        $res = $user->getInformationLimit(5);

        $data = [
            "content" => "An index page",
        ];

        $view->add("default1/article", $data);

        $pageRender->renderPage(["title" => $title]);
    }

    public function overview()
    {
        $title = "Overview";
        $view = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");

        $posts = $this->getPosts();

        $allPosts = [];

        foreach ($posts as $p) {
            array_push($allPosts, [$p, $this->getTags([$p->postid])]);
        }

        $data = [
            "items" => $this->getUsers(),
            "posts" => $allPosts,
            "popularTags" => $this->getPopularTags()
        ];

        $view->add("overview/overview", $data);

        $pageRender->renderPage(["title" => $title]);
    }

    public function getUsers()
    {
        $overview = new Overview();

        $data = $overview->returnLimitUsers($this->di->get("db"), "points desc", 5);

        return $data;
    }

    public function getPosts()
    {
        $overview = new Overview();

        $data = $overview->returnLimitPosts($this->di->get("db"));

        return $data;
    }

    public function getTags($id)
    {
        $overview = new Overview();

        $data = $overview->returnAllTagsFromPost($this->di->get("db"), [$id]);

        return $data;
    }

    public function getPopularTags()
    {
        $overview = new Overview();

        $data = $overview->returnPopularTags($this->di->get("db"));

        return $data;
    }

    public function getCatName($id)
    {
        $postcat = new PostCategory();
        $postcat->setDb($this->di->get("db"));
        $res = $postcat->getCatName($id);
        return $res;
    }
}
