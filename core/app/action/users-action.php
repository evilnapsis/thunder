<?php
if(isset($_GET["opt"]) && $_GET["opt"]=="add"){
	if(count($_POST)>0){
		$user = new UserData();
		$user->name = $_POST["name"];
		$user->lastname = $_POST["lastname"];
		$user->email = $_POST["email"];
		$user->password = sha1(md5($_POST["password"]));

		if(isset($_POST["kind"]) && $_POST["kind"]=="admin") { $user->add_admin(); }
		else if(isset($_POST["kind"]) && $_POST["kind"]=="cajero") { $user->add_cajero(); }
		else if(isset($_POST["kind"]) && $_POST["kind"]=="mesero") { $user->add_mesero(); }
		else { $user->add(); } // Default add if no specific kind

		header("Location: index.php?view=users&opt=all");
	}
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="update"){
	if(count($_POST)>0){
		$user =  UserData::getById($_POST["user_id"]);
		$user->name = $_POST["name"];
		$user->lastname = $_POST["lastname"];
		$user->email = $_POST["email"];
		
		// Reset de roles para asegurar que solo uno esté activo (lógica de radio)
		$user->is_admin = 0;
		$user->is_cajero = 0;
		$user->is_mesero = 0;

		if($_POST["kind"]=="admin") { $user->is_admin = 1; }
		else if($_POST["kind"]=="cajero") { $user->is_cajero = 1; }
		else if($_POST["kind"]=="mesero") { $user->is_mesero = 1; }

		$user->update();
		if($_POST["password"]!=""){
			$user->password = sha1(md5($_POST["password"]));
			$user->update_password();
		}

		header("Location: index.php?view=users&opt=all");
	}
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="del"){
	$user = UserData::getById($_GET["id"]);
	$user->del();
	header("Location: index.php?view=users&opt=all");
}
?>