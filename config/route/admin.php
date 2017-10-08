<?php
/**
 * Routes for user controller.
 */
return [
    "routes" => [
        [
            "info" => "check admin",
            "requestMethod" => null,
            "path" => "/**",
            "callable" => ["userController", "checkAdminLoggedIn"]
        ],
        [
            "info" => "Admin Tools",
            "requestMethod" => "get",
            "path" => "admin/viewUsers",
            "callable" => ["userController", "getAllUsers"]
        ],
        [
            "info"          => "Create User.",
            "requestMethod" => "get|post",
            "path"          => "admin/create",
            "callable"      => ["userController", "createUser"],
        ],
        [
            "info"          => "Delete User",
            "requestMethod" => "get|post",
            "path"          => "admin/delete",
            "callable"      => ["userController", "deleteUser"],
        ],
        [
            "info"          => "Update User",
            "requestMethod" => "get|post",
            "path"          => "admin/update/{id:digit}",
            "callable"      => ["userController", "updateUser"],
        ],
    ]
];
