<?php
/**
 * Routes for user controller.
 */
return [
    "routes" => [
        [
            "info" => "test",
            "requestMethod" => "get",
            "path" => "/**",
            "callable" => ["userController", "checkLogin"]
        ],
        [
            "info" => "User Controller index.",
            "requestMethod" => "get",
            "path" => "",
            "callable" => ["userController", "getIndex"],
        ],
        [
            "info" => "Login a user.",
            "requestMethod" => "get|post",
            "path" => "user/login",
            "callable" => ["userController", "getPostLogin"],
        ],
        [
            "info" => "Create a user.",
            "requestMethod" => "get|post",
            "path" => "user/create",
            "callable" => ["userController", "getPostCreateUser"],
        ],
        [
            "info" => "Profile",
            "requestMethod" => "get",
            "path" => "user/profile",
            "callable" => ["userController", "getUserProfile"],
        ],
        [
            "info" => "Logout",
            "requestMethod" => "get",
            "path" => "user/logout",
            "callable" => ["userController", "logout"],
        ],
        [
            "info" => "Edit Profile",
            "requestMethod" => "get|post",
            "path" => "user/editProfile/{id:digit}",
            "callable" => ["userController", "editProfile"]
        ],
        [
            "info" => "All Users",
            "requestMethod" => "get",
            "path" => "user/showAll",
            "callable" => ["userController", "getAllUsersPublic"]
        ],
        [
            "info" => "All Things",
            "requestMethod" => "get",
            "path" => "user/all/{id:digit}",
            "callable" => ["userController", "getAllPostsAndCommentsFromSpecificUser"]
        ],
    ]
];
