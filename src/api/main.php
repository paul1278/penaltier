<?php
require_once(__DIR__ . "/../lib/autoload.php");
requirePerm("queryMain");
$penalties = Database::dbQuery("SELECT * FROM penalties");
$penalties = Database::resultToArray($penalties);
$users = Database::dbQuery("SELECT username, role, role.perms FROM users INNER JOIN role on role.id = role");
$users = Database::resultToArray($users);
ok([
    "penalties" => $penalties,
    "users" => $users
]);
?>