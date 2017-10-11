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
      "userController" => [
            "shared" => true,
            "callback" => function () {
                $obj = new \Radchasay\User\UserController();
                $obj->setDI($this);
                return $obj;
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
    ]
];
