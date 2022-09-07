<?php
require_once(__DIR__ . "/../lib/autoload.php");
requirePerm("admin");
$name = $_POST["username"];
$pass = $_POST["passwordhash"];
$role = $_POST["role"];
$pass = password_hash($pass, PASSWORD_DEFAULT);

try {
$d = Database::exec(
    "INSERT INTO users
        (username, passwordhash, role)
    VALUES
        (?, ?, ?)",
    "sss",
    [$username, $pass, $role]
);
} catch(Exception $e) {
    //$e->getCode()
    error(400);
}
?>