<?php

namespace Radchasay\Tag;

use \Anax\Configure\ConfigureInterface;
use \Anax\Configure\ConfigureTrait;
use \Anax\DI\InjectionAwareInterface;
use \Anax\Di\InjectionAwareTrait;
use \Radchasay\Tag\Tag;

/**
 * A controller class.
 */
class TagController implements
    ConfigureInterface,
    InjectionAwareInterface
{
    use ConfigureTrait,
        InjectionAwareTrait;


    /**
     * @var $data description
     */
    //private $data;

    public function getSpecificTag($tag)
    {
        $title = "Specific Tag";
        $view = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");
        $db = $this->di->get("db");

        $tags = new Tag();
        $tags->setDb($db);
        $res = $tags->returnAllSpecificTag([$tag]);

        $data = [
            "content" => $res,
        ];

        $view->add("tag/oneTag", $data);

        $pageRender->renderPage(["title" => $title]);
    }

    public function getAllTags()
    {
        $title = "All Tags";
        $view = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");
        $db = $this->di->get("db");

        $tags = new Tag();
        $tags->setDb($db);
        $res = $tags->returnAllTags();

        $data = [
            "tags" => $res,
        ];

        $view->add("tag/viewAllTags", $data);

        $pageRender->renderPage(["title" => $title]);
    }
}
