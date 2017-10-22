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
            "info"          => "Create new Post",
            "requestMethod" => "get|post",
            "path"          => "newPost",
            "callable"      => ["commentController", "newPost"],
        ],
        [
            "info" => "Get all posts",
            "requestMethod" => "get|post",
            "path" => "viewAllPosts",
            "callable" => ["commentController", "viewAllPosts"],
        ],
        [
            "info" => "Create new comment",
            "requestMethod" => "get|post",
            "path" => "newComment/{id:digit}",
            "callable" => ["commentController", "newComment"],
        ],
        [
            "info" => "Get post and comments",
            "requestMethod" => "get|post",
            "path" => "retrieve/{id:digit}",
            "callable" => ["commentController", "postAndComments"],
        ],
        [
            "info" => "Delete comment",
            "requestMethod" => "get",
            "path" => "deleteComment/{id:digit}",
            "callable" => ["commentController", "deleteComment"]
        ],
        [
            "info" => "Edit comment",
            "requestMethod" => "get|post",
            "path" => "editComment/{id:digit}",
            "callable" => ["commentController", "editComment"]
        ],
        [
            "info" => "Add new comment comment",
            "requestMethod" => "get|post",
            "path" => "newCommentComment/{id:digit}/{id:digit}",
            "callable" => ["commentController", "newCommentComment"],
        ],
        [
            "info" => "Delete comment comment",
            "requestMethod" => "get|post",
            "path" => "deleteCommentComment/{id:digit}",
            "callable" => ["commentController", "deleteCommentComment"],
        ],
    ],
];
