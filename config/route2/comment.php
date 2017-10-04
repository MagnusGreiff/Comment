<?php


return [
    "routes" => [
        [
            "info"          => "Connect to database",
            "requestMethod" => null,
            "path"          => "/**",
            "callable"      => ["commentController", "commentConnect"],
        ],
        [
            "info"          => "Route to form",
            "requestMethod" => "get",
            "path"          => "newPost",
            "callable"      => ["commentController", "newPost"],
        ],
        [
            "info"          => "Retrieve posts",
            "requestMethod" => "get",
            "path"          => "retrieve",
            "callable"      => ["commentController", "postRetrieve"],
        ],
        [
            "info"          => "Retrieve one post with comments",
            "requestMethod" => "get",
            "path"          => "retrieve/{id:digit}",
            "callable"      => ["commentController", "postRetrieveOneAndComments"],
        ],
        [
            "info"          => "Create new post",
            "requestMethod" => "post",
            "path"          => "submit/",
            "callable"      => ["commentController", "postCreate"],
        ],
        [
            "info"          => "Route to commentform",
            "requestMethod" => null,
            "path"          => "newComment/{id:digit}",
            "callable"      => ["commentController", "newComment"],
        ],
        [
            "info"          => "Create new comment",
            "requestMethod" => "post",
            "path"          => "submitComment/{id:digit}",
            "callable"      => ["commentController", "commentCreate"],
        ],
        [
            "info" => "Delete comment",
            "requestMethod" => "get",
            "path" => "deleteComment/{id:digit}",
            "callable" => ["commentController", "deleteComment"]
        ],
        [
            "info" => "Edit comment",
            "requestMethod" => "get",
            "path" => "editComment/{id:digit}",
            "callable" => ["commentController", "editComment"]
        ],
        [
            "info" => "Submit edited comment",
            "requestMethod" => "post",
            "path" => "editComment/Submit/{id:digit}",
            "callable" => ["commentController", "editCommentSubmit"]
        ]
    ],
];
