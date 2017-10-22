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

return [
    'dsn' => "mysql:host=127.0.0.1;dbname=anaxdb;",
    'username' => "anax",
    'password' => "anax",
    'driver_options' => [\PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true, \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8", \PDO::ATTR_EMULATE_PREPARES => true],
    'table_prefix' => null,
    'fetch_mode' => \PDO::FETCH_OBJ,
    'session_key' => 'Anax\Database',
    'verbose' => false,
    'debug_connect' => true,
];
