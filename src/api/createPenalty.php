<?php
require_once(__DIR__ . "/../lib/autoload.php");
requirePerm("queryMain");
$name = $_POST["name"] ?? null;
$payAmount = $_POST["payAmount"] ?? null;
try {
    $d = Database::exec(
        "INSERT INTO penalties
            (name, payAmount)
        VALUES
            (?, ?)",
        "s",
        [$name, $payAmount]
    );
} catch(Exception $e) {
    //$e->getCode()
    error(400);
}
?>