<?php

namespace Radchasay\User;

use \Anax\Configure\ConfigureInterface;
use \Anax\Configure\ConfigureTrait;
use \Anax\DI\InjectionAwareInterface;
use \Anax\Di\InjectionAwareTrait;
use Radchasay\User\HTMLForm\AdminUpdateUser;
use Radchasay\User\HTMLForm\AdminCreateUserForm;
use Radchasay\User\HTMLForm\UpdateProfileForm;
use \Radchasay\User\HTMLForm\UserLoginForm;
use \Radchasay\User\HTMLForm\CreateUserForm;
use \Radchasay\User\HTMLForm\AdminDeleteUserForm;

/**
 * A controller class.
 */
class UserController implements
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

        $data = [
            "content" => "An index page",
        ];

        $view->add("default1/article", $data);

        $pageRender->renderPage(["title" => $title]);
    }


    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return void
     */
    public function getPostLogin()
    {
        $title = "A login page";
        $view = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");
        if ($this->di->get("session")->has("email")) {
            $url = $this->di->get("url")->create("user/profile");
            $this->di->get("response")->redirect($url);
        } else {
            $form = new UserLoginForm($this->di);

            $form->check();

            $data = [
                "content" => $form->getHTML(),
            ];

            $view->add("default1/article", $data);

            $pageRender->renderPage(["title" => $title]);
        }
    }


    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return void
     */
    public function getPostCreateUser()
    {
        $title = "A create user page";
        $view = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");
        $form = new CreateUserForm($this->di);

        $form->check();

        $data = [
            "content" => $form->getHTML(),
        ];

        $view->add("default1/article", $data);

        $pageRender->renderPage(["title" => $title]);
    }


    public function getUserProfile()
    {
        $title = "Profile";
        $view = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");
        $user = new User();
        $user->setDb($this->di->get("db"));

        $data = [
            "content" => $user->getInformation($this->di->get("session")->get("email")),
        ];

        $view->add("users/profile", $data);

        $pageRender->renderPage(["title" => $title]);
    }

    public function logout()
    {
        $login = $this->di->get("url")->create("user/login");

        if ($this->di->get("session")->has("email")) {
            $this->di->get("session")->delete("email");
            $this->di->get("response")->redirect($login);
        } else {
            $this->di->get("response")->redirect($login);
        }

        $hasSession = session_status() == PHP_SESSION_ACTIVE;

        if (!$hasSession) {
            $this->di->get("response")->redirect($login);
            return true;
        }
    }

    public function checkLogin()
    {
        $login = $this->di->get("url")->create("user/login");
        $hasSession = session_status() == PHP_SESSION_ACTIVE;
        if (!$hasSession) {
            $this->di->get("response")->redirect($login);
            return true;
        }
    }

    public function editProfile($id)
    {
        if ($this->checkUserIdMatch($id)) {
            $title = "Update an item";
            $view = $this->di->get("view");
            $pageRender = $this->di->get("pageRender");
            $form = new UpdateProfileForm($this->di, $id);

            $form->check();

            $data = [
                "form" => $form->getHTML(),
            ];

            $view->add("users/editProfile", $data);

            $pageRender->renderPage(["title" => $title]);
        }

    }


    public function getAllUsers()
    {
        if ($this->checkAdminLoggedIn()) {
            $title = "A collection of items";
            $view = $this->di->get("view");
            $pageRender = $this->di->get("pageRender");
            $user = new User();
            $user->setDb($this->di->get("db"));

            $data = [
                "items" => $user->findAll(),
            ];

            $view->add("admin/viewUsers", $data);

            $pageRender->renderPage(["title" => $title]);
        }
    }

    public function createUser()
    {
        if ($this->checkAdminLoggedIn()) {
            $this->checkAdminLoggedIn();
            $title = "Create a item";
            $view = $this->di->get("view");
            $pageRender = $this->di->get("pageRender");
            $form = new AdminCreateUserForm($this->di);

            $form->check();

            $data = [
                "form" => $form->getHTML(),
            ];

            $view->add("admin/create", $data);

            $pageRender->renderPage(["title" => $title]);
        }
    }


    public function deleteUser()
    {
        if ($this->checkAdminLoggedIn()) {
            $title = "Delete an item";
            $view = $this->di->get("view");
            $pageRender = $this->di->get("pageRender");
            $form = new AdminDeleteUserForm($this->di);

            $form->check();

            $data = [
                "form" => $form->getHTML(),
            ];

            $view->add("admin/delete", $data);

            $pageRender->renderPage(["title" => $title]);
        }
    }

    public function updateUser($id)
    {
        if ($this->checkAdminLoggedIn()) {
            $title = "Update an item";
            $view = $this->di->get("view");
            $pageRender = $this->di->get("pageRender");
            $form = new AdminUpdateUser($this->di, $id);

            $form->check();

            $data = [
                "form" => $form->getHTML(),
            ];

            $view->add("admin/update", $data);

            $pageRender->renderPage(["title" => $title]);
        }
    }


    // public function checkUserId() {
    //     if ($this->di->get("session")->has("email")) {
    //         $email = $this->di->get("session")->get("email");
    //         $user = new User();
    //         $user->setDb($this->di->get("db"));
    //         $res = $user->find("email", $email);
    //
    //         if ()
    //     }
    // }
    //

    public function checkUserIdMatch($id) {
        if ($this->di->get("session")->has("email")) {
            $email = $this->di->get("session")->get("email");
            $user = new User();
            $user->setDb($this->di->get("db"));
            $res = $user->find("email", $email);
            if ($res->id != $id) {
                $url = $this->di->get("url")->create("user/profile");
                $this->di->get("response")->redirect($url);
                return false;
            }
            return true;
        } else {
            $url = $this->di->get("url")->create("user/profile");
            $this->di->get("response")->redirect($url);
        }


    }

    public function checkAdminLoggedIn() {
        if ($this->di->get("session")->has("email")) {
            $email = $this->di->get("session")->get("email");
            $user = new User();
            $user->setDb($this->di->get("db"));
            $res = $user->find("email", $email);

            if (!$res->permissions == "admin" || $res->permissions == "user") {
                $url = $this->di->get("url")->create("user/login");
                $this->di->get("response")->redirect($url);
            }
            return true;
        } else {
            $url = $this->di->get("url")->create("user/login");
            $this->di->get("response")->redirect($url);
        }

    }
}
