<?php
require_once(__DIR__ . "/../lib/autoload.php");
requirePerm("queryMain");
$limit = isset($_GET["limit"]) ? +$_GET["limit"] : 10;
$offset = isset($_GET["offset"]) ? +$_GET["offset"] : 0;

if($limit < 0 || $limit >= PHP_INT_MAX) {
    $limit = 10;
}

if($offset < 0 || $offset >= PHP_INT_MAX) {
    $offset = 0;
}

$d = Database::dbQuery(
    "SELECT
        assigned_penalties.user,
        assigned_penalties.assigned_by,
        assigned_penalties.assigned_on,
        assigned_penalties.id,
        penalties.name
    FROM assigned_penalties INNER JOIN penalties on penalties.id = assigned_penalties.penalty LIMIT $offset,$limit");
$d = Database::resultToArray($d);
$count = Database::dbQuery("SELECT COUNT(*) as c FROM assigned_penalties");
$count = +Database::resultToArray($count)[0]->c;
ok(["limit" => $limit, "offset" => $offset, "penalties" => $d, "total" => $count]);
?>