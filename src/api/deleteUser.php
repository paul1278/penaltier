<?php
require_once(__DIR__ . "/../lib/autoload.php");
requirePerm("admin");
$name = $_POST["username"];

try {
$d = Database::exec(
    "DELETE FROM users WHERE username = ?",
    "s",
    [$username],
    false
);
if($d->affected_rows == 0) {
    error(400);
}
} catch(Exception $e) {
    //$e->getCode()
    error(400);
}
?>