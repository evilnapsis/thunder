<?php

print_r($_POST);

$isadmin =0;
if(isset($_POST["is_admin"])){$isadmin=1;}

$user =  UserData::getById($_POST["user_id"]);
$user->name = $_POST["name"];
$user->lastname = $_POST["lastname"];
$user->username = $_POST["username"];
$user->email = $_POST["email"];

$user->is_admin = $isadmin;

$user->update();
if($_POST["password"]!=""){
$user->password = sha1(md5($_POST["password"]));
$user->update_password();
}

setcookie("userupdated","userupdated");
header("Location: index.php?view=users");
?>