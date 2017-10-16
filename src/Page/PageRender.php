<?php

namespace Anax\Page;

use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;

/**
 * A default page rendering class.
 */
class PageRender implements PageRenderInterface, InjectionAwareInterface
{
    use InjectionAwareTrait;


    /**
     * Render a standard web page using a specific layout.
     *
     * @param array $data variables to expose to layout view.
     * @param integer $status code to use when delivering the result.
     *
     * @SuppressWarnings(PHPMD.ExitExpression)
     * @param string $title
     * @return void
     */
    public function renderPage($data = null, $status = 200)
    {
        $data["stylesheets"] = ["css/style.min.css"];
        $view = $this->di->get("view");
        // Add common header, navbar and footer
        $view->add("default/header", [], "header");
        $view->add("navbar/navbar", [], "navbar");
        $view->add("default/footer", [], "footer");

        // Add layout, render it, add to response and send.
        $view->add("default1/layout", $data, "layout");
        $body = $view->renderBuffered("layout");
        $this->di->get("response")->setBody($body)
                                  ->send($status);
        exit;
    }

    /**
     * Render a standard web page using a specific layout.
     *
     * @param array $data variables to expose to layout view.
     * @param integer $status code to use when delivering the result.
     *
     * @SuppressWarnings(PHPMD.ExitExpression)
     * @param string $title
     * @return void
     */
    public function renderLogin($data = null, $status = 200)
    {
        $data["stylesheets"] = ["css/style.min.css"];
        $view = $this->di->get("view");
        // Add common header, navbar and footer
        // $view->add("default/header", [], "header");
        // $view->add("navbar/navbar", [], "navbar");
        // $view->add("default/footer", [], "footer");

        // Add layout, render it, add to response and send.
        $view->add("default1/layout", $data, "layout");
        $body = $view->renderBuffered("layout");
        $this->di->get("response")->setBody($body)
                                  ->send($status);
        exit;
    }
}
