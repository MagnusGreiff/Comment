<?php
return [

    // Services to add to the container.
    "services" => [

        "commentController" => [
            "shared" => true,
            "callback" => function () {
                $commentController = new \Radchasay\Comment\CommentController();
                $commentController->setDI($this);
                return $commentController;
            }
        ],
        "db" => [
            "shared" => true,
            "callback" => function () {
                $obj = new \Anax\Database\DatabaseQueryBuilder();
                $obj->configure("database.php");
                return $obj;
            }
        ],
        "userController" => [
            "shared" => true,
            "callback" => function () {
                $obj = new \Radchasay\User\UserController();
                $obj->setDI($this);
                return $obj;
            }
        ],
        "overviewController" => [
            "shared" => true,
            "callback" => function () {
                $obj = new \Radchasay\Overview\OverviewController();
                $obj->setDI($this);
                return $obj;
            }
        ],
        "tagController" => [
            "shared" => true,
            "callback" => function () {
                $obj = new \Radchasay\Tag\TagController();
                $obj->setDI($this);
                return $obj;
            }
        ],
        "gravatar" => [
            "shared" => true,
            "callback" => function () {
                $obj = new \Radchasay\Gravatar\Gravatar();
                return $obj;
            }
        ]
    ]
];
