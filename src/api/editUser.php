<?php
require_once(__DIR__ . "/../lib/autoload.php");
requirePerm("queryMain");
$name = $_POST["username"];

if($name != $_SESSION["user"]->username) {
    requirePerm("admin");
}

$pass = $_POST["passwordhash"];
$role = $_POST["role"];
$pass = password_hash($pass, PASSWORD_DEFAULT);

try {
$d = Database::exec(
    "UPDATE users SET passwordhash = ?, role = ? WHERE username = ?",
    "sss",
    [$pass, $role, $username]
);
} catch(Exception $e) {
    //$e->getCode()
    error(400);
}
?>