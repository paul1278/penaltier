<?php
require_once(__DIR__ . "/../lib/autoload.php");
$username = $_POST["username"] ?? null;
$password = $_POST["password"] ?? null;

function tryLogin($username, $password) {
    $pr = Database::exec("SELECT * FROM users WHERE username = ?", "s", [$username]);
    if($pr->num_rows != 1) {
        return false;
    }
    $user = mysqli_fetch_object($pr);
    if(password_verify($password, $user->passwordhash)) {
        return $user;
    } else {
        return false;
    }
}
$l = tryLogin($username, $password);
if($l != false) {
    $l->passwordhash = "****";
    $_SESSION["user"] = $l;
    $roles = getRoles();
    ok([
        "roles" => $l->role,
        "perms" => $roles[$l->role]->perms
    ]);
}
error(403);
?>