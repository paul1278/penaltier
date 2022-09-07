<?php
require_once(__DIR__ . "/../lib/autoload.php");
requirePerm("queryMain");
$penalty = $_POST["penalty"];
$user = $_POST["user"];
try {
$d = Database::exec(
    "INSERT INTO assigned_penalties
        (penalty, user, assigned_by)
    VALUES
        (?, ?, ?)",
    "iss",
    [$penalty, $user, $_SESSION["user"]->username]
);
} catch(Exception $e) {
    //$e->getCode()
    error(400);
}
?>