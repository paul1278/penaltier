<?php
require_once(__DIR__ . "/../lib/autoload.php");
requirePerm("queryMain");
$penalty = $_POST["penalty"] ?? null;
$d = Database::exec(
    "DELETE FROM assigned_penalties
    WHERE id = ?",
    "i",
    [$penalty]
);
?>