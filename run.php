<?php

/**
 * Entry script
 */

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/src/Interfaces.php';
require_once __DIR__ . '/src/User.php';
require_once __DIR__ . '/src/UserRelations.php';

$user = new User(1);
$ur = new UserRelations($db, $user);

