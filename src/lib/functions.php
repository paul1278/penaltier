<?php
function getRoles() {
  $ro = Database::dbQuery("SELECT * FROM role");
  $roles = [];
  while ($r = mysqli_fetch_object($ro)) {
    $roles[$r->id] = $r;
  }
  return $roles;
}

function ok($obj) {
  header("Content-Type: application/json; charset=utf-8");
  echo json_encode($obj);
  exit();
}

function error($c) {
  http_response_code($c);
  exit();
}

function requirePerm($name) {
  if(!isset($_SESSION["user"])) {
    error(404);
  }
  $roles = getRoles();
  $role = $_SESSION["user"]->role;
  $role = explode(",", $roles[$role]->perms);
  if(in_array($name, $role)) {
    return true;
  } else {
    error(401);
  }
}
?>