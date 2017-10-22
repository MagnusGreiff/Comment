<?php
/**
 * Configuration file for routes.
 */
return [
    // Load these routefiles in order specified and optionally mount them
    // onto a base route.
    "routeFiles" => [
        [
            "mount" => null,
            "file" => __DIR__ . "/route2/always.php",
        ],
        [
            "mount" => null,
            "file" => __DIR__ . "/route2/overview.php",
        ],
        [
            "mount" => null,
            "file" => __DIR__ . "/route2/tag.php",
        ],
        [
            "mount" => "comment",
            "file" => __DIR__ . "/route2/comment.php"
        ],
        [
            // For creating users....
            "mount" => null,
            "file" => __DIR__ . "/route2/userController.php",
        ],
        [
            // For creating users....
            "mount" => null,
            "file" => __DIR__ . "/route2/admin.php",
        ]
    ],
];
