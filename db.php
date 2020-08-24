<?php

/**
 * Database connection
 */

$db_config = require_once(__DIR__ . '/config/db.php');

$db = new mysqli($db_config['host'], $db_config['user'], $db_config['password'], $db_config['db'], $db_config['port']);

if($db->connect_errno) {
    echo "Failed to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
}

$db->set_charset($db_config['charset']);

