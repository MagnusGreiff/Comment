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
      "commentModel" => [
          "shared" => true,
          "callback" => function () {
              $commentModel = new \Radchasay\Comment\CommentModel();
              $commentModel->setDI($this);
              return $commentModel;
          }
      ],
      "database" => [
          "shared" => false,
          "callback" => function () {
              $database = new \Anax\Database\DatabaseConfigure();
              //$database->setDI($this);
              $database->configure("database.php");
              $database->connect();
              return $database;
          }
      ],
    ]
];
