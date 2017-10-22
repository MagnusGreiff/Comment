<?php
/**
 * Routes for user controller.
 */
return [
    "routes" => [
        [
            "info" => "Tags",
            "requestMethod" => "get",
            "path" => "tag/tags",
            "callable" => ["tagController", "getAllTags"]
        ],
        [
            "info" => "Specific tag",
            "requestMethod" => "get",
            "path" => "tag/tag/{arg}",
            "callable" => ["tagController", "getSpecificTag"]
        ]
    ]
];
