<?php
require_once(__DIR__ . "/../lib/autoload.php");
requirePerm("queryMain");
$name = $_POST["name"];
try {
$d = Database::exec(
    "INSERT INTO penalties
        (name)
    VALUES
        (?)",
    "s",
    [$name]
);
} catch(Exception $e) {
    //$e->getCode()
    error(400);
}
?>