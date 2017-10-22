<?php
/**
 * Config file for Database.
 *
 * Example for MySQL.
 *  "dsn" => "mysql:host=localhost;dbname=test;",
 *  "username" => "test",
 *  "password" => "test",
 *  "driver_options"  => [\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"],
 *
 * Example for SQLite.
 *  "dsn" => "sqlite:memory::",
 *
 */

//if ($_SERVER["HTTP_HOST"] === 'dbwebb' || $_SERVER["HTTP_HOST"] === "localhost:8080" || $_SERVER["HTTO_HOST"] === "localhost") {
    return [
        'dsn' => "mysql:host=127.0.0.1;dbname=anaxdb;",
        'username' => "anax",
        'password' => "anax",
        'driver_options' => [\PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true, \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"],
        'table_prefix' => null,
        'fetch_mode' => \PDO::FETCH_OBJ,
        'session_key' => 'Anax\Database',
        'verbose' => false,
        'debug_connect' => true,
    ];
// } else {
//     return [
//         'dsn' => "mysql:host=blu-ray.student.bth.se;dbname=magp16;",
//         'username' => "magp16",
//         'password' => "GnJ9UTiVBh8b",
//         'driver_options' => "[\PDO::MYSQL_ATTR_INIT_COMMAND => \"SET NAMES 'UTF8'\"]",
//         'table_prefix' => null,
//         'fetch_mode' => \PDO::FETCH_OBJ,
//         'session_key' => 'Anax\Database',
//         'verbose' => true,
//         'debug_connect' => true,
//     ];
// }
