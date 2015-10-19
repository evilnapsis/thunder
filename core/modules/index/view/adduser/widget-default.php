<?php

$user = new UserData();
$user->name = $_POST["name"];
$user->lastname = $_POST["lastname"];
$user->email = $_POST["email"];
$user->password = sha1(md5($_POST["password"]));

if(isset($_POST["is_admin"]) && $_POST["is_admin"]=="1") { $user->add_admin(); }
else if(isset($_POST["is_cajero"]) && $_POST["is_cajero"]=="1") { $user->add_cajero(); }
else if(isset($_POST["is_mesero"]) && $_POST["is_mesero"]=="1") { $user->add_mesero(); }
 header("Location: index.php?view=users");

?>