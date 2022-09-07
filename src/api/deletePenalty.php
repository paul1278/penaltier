<?php
require_once(__DIR__ . "/../lib/autoload.php");
requirePerm("peadmin");
$penalty = $_POST["penalty"] ?? null;
$d = Database::exec(
    "DELETE FROM penalties WHERE id = ?",
    "i",
    [$penalty],
    false
);
if($d->affected_rows == 0) {
    error(400);
}
?>