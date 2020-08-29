<?php

require_once './db.php';

$result = $db->query('CREATE TABLE IF NOT EXISTS users (id BIGINT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT, name VARCHAR(15), created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)');
$result = $db->query('CREATE TABLE IF NOT EXISTS user_relations (user_id BIGINT UNSIGNED NOT NULL, relation_id BIGINT UNSIGNED NOT NULL, type SMALLINT(1) UNSIGNED NOT NULL, created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)');
$result = $db->query('CREATE INDEX `idx-user_relations-user_id` ON user_relations (user_id)');
$result = $db->query('ALTER TABLE user_relations ADD FOREIGN KEY `fk-user_relations-user_id` (user_id) REFERENCES `users` (id) ON DELETE CASCADE');
$result = $db->query('CREATE INDEX `idx-user_relations-relation_id` ON user_relations (relation_id)');
$result = $db->query('ALTER TABLE user_relations ADD FOREIGN KEY `fk-user_relations-relation_id` (relation_id) REFERENCES `users` (id) ON DELETE CASCADE');

$result = $db->query("INSERT INTO users (name) VALUES ('UserA'), ('UserB'), ('UserC'), ('UserD'), ('UserE')");

