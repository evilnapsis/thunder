<?php if(isset($_GET['opt']) && $_GET['opt']=="add"){


//	if($_POST['curp']!=""){
	if(true){

	$ce = ClientData::getByClaveElector($_POST['clave_elector']);
	$cu = ClientData::getByCurp($_POST['curp']);

	$go=false;
	if($_POST["clave_elector"]!=""){
		if($ce==null){
			$go=true;

		}
	}else{
		$go=true;
	}

//	if($cu==null ){
	if(true ){

	if($go){
	$client = new ClientData();
	//$client->user_id = $_POST['user_id'];
	$client->user_id = "NULL";
	$client->curp = $_POST['curp'];
	$client->empresa = $_POST['empresa'];
	$client->name = $_POST['name'];
	$client->name2 = $_POST['name2'];
	$client->lastname = $_POST["lastname"];
	$client->lastname2 = $_POST["lastname2"];
	$client->address = $_POST["address"];
	$client->phone = $_POST["phone"];
	$client->email = $_POST["email"];


	$client->fecha_nacimiento = $_POST["fecha_nacimiento"];
	$client->trabajo_nombre = $_POST["trabajo_nombre"];
	$client->estado = $_POST["estado"];
	$client->municipio = $_POST["municipio"];
	$client->colonia = $_POST["colonia"];
	$client->address_ref = $_POST["address_ref"];
	$client->url_gps = "";//$_POST["url_gps"];
	$client->clave_elector = $_POST["clave_elector"];

/*
	$client->email = $_POST["email"];
	$client->email = $_POST["email"];
	$client->email = $_POST["email"];
	$client->email = $_POST["email"];
	$client->email = $_POST["email"];
*/
/*
$image = "";
$up = new Upload($_FILES["image"]);
if($up->uploaded){
	$up->Process("./storage/clients/");
	if($up->processed){
		$image = $up->file_dst_name;
	}
}
$ine_lado1 = "";
$up = new Upload($_FILES["ine_lado1"]);
if($up->uploaded){
	$up->Process("./storage/clients/");
	if($up->processed){
		$ine_lado1 = $up->file_dst_name;
	}
}
$ine_lado2 = "";
$up = new Upload($_FILES["ine_lado2"]);
if($up->uploaded){
	$up->Process("./storage/clients/");
	if($up->processed){
		$ine_lado2 = $up->file_dst_name;
	}
}
$img_garantia = "";
$up = new Upload($_FILES["img_garantia"]);
if($up->uploaded){
	$up->Process("./storage/clients/");
	if($up->processed){
		$img_garantia = $up->file_dst_name;
	}
}
$img_domicilio = "";
$up = new Upload($_FILES["img_domicilio"]);
if($up->uploaded){
	$up->Process("./storage/clients/");
	if($up->processed){
		$img_domicilio = $up->file_dst_name;
	}
}
*/
/*
$client->image = $image;
$client->ine_lado1 = $ine_lado1;
$client->ine_lado2 = $ine_lado2;
$client->img_garantia = $img_garantia;
$client->img_domicilio = $img_domicilio;
*/
$client->image = "";
$client->ine_lado1 = "";
$client->ine_lado2 = "";
$client->img_garantia = "";
$client->img_domicilio = "";
	$client->add();
}else{
	Core::alert("Error: Clave de Elector Repetida!");

}
}else{
	Core::alert("Error: CURP Repetido!");

}
}else{
	Core::alert("Error: Debe escribir la CURP!");
}
	Core::redir("./?view=clients&opt=all");


}
if(isset($_GET['opt']) && $_GET['opt']=="addajax"){
	
	if($_POST['curp']!=""){
	$ce = ClientData::getByClaveElector($_POST['clave_elector']);
	$cu = ClientData::getByCurp($_POST['curp']);

	$go=false;
	if($_POST["clave_elector"]!=""){
		if($ce==null){
			$go=true;

		}
	}else{
		$go=true;
	}

	if($cu==null ){

	if($go){
	$client = new ClientData();
	//$client->user_id = $_POST['user_id'];
	$client->user_id = "NULL";
	$client->empresa = $_POST['empresa'];
	$client->curp = $_POST['curp'];
	$client->name = $_POST['name'];
	$client->name2 = $_POST['name2'];
	$client->lastname = $_POST["lastname"];
	$client->lastname2 = $_POST["lastname2"];
	$client->address = $_POST["address"];
	$client->phone = $_POST["phone"];
	$client->email = $_POST["email"];


	$client->fecha_nacimiento = $_POST["fecha_nacimiento"];
	$client->trabajo_nombre = $_POST["trabajo_nombre"];
	$client->estado = $_POST["estado"];
	$client->municipio = $_POST["municipio"];
	$client->colonia = $_POST["colonia"];
	$client->address_ref = $_POST["address_ref"];
	$client->url_gps = "";//$_POST["url_gps"];
	$client->clave_elector = $_POST["clave_elector"];

/*
	$client->email = $_POST["email"];
	$client->email = $_POST["email"];
	$client->email = $_POST["email"];
	$client->email = $_POST["email"];
	$client->email = $_POST["email"];
*/
/*
$image = "";
$up = new Upload($_FILES["image"]);
if($up->uploaded){
	$up->Process("./storage/clients/");
	if($up->processed){
		$image = $up->file_dst_name;
	}
}
$ine_lado1 = "";
$up = new Upload($_FILES["ine_lado1"]);
if($up->uploaded){
	$up->Process("./storage/clients/");
	if($up->processed){
		$ine_lado1 = $up->file_dst_name;
	}
}
$ine_lado2 = "";
$up = new Upload($_FILES["ine_lado2"]);
if($up->uploaded){
	$up->Process("./storage/clients/");
	if($up->processed){
		$ine_lado2 = $up->file_dst_name;
	}
}
$img_garantia = "";
$up = new Upload($_FILES["img_garantia"]);
if($up->uploaded){
	$up->Process("./storage/clients/");
	if($up->processed){
		$img_garantia = $up->file_dst_name;
	}
}
$img_domicilio = "";
$up = new Upload($_FILES["img_domicilio"]);
if($up->uploaded){
	$up->Process("./storage/clients/");
	if($up->processed){
		$img_domicilio = $up->file_dst_name;
	}
}
*/
/*
$client->image = $image;
$client->ine_lado1 = $ine_lado1;
$client->ine_lado2 = $ine_lado2;
$client->img_garantia = $img_garantia;
$client->img_domicilio = $img_domicilio;
*/
$client->image = "";
$client->ine_lado1 = "";
$client->ine_lado2 = "";
$client->img_garantia = "";
$client->img_domicilio = "";
	$cx = $client->add();
	echo "Ciudadano agregado con el Id# ".$cx[1];
}else{
echo "clave_repetida";
}
}else{
echo "curp_repetido";
}
}else{
echo "error_curp";
}
}
if(isset($_GET['opt']) && $_GET['opt']=="update"){

	$client = ClientData::getById($_POST["id"]); 
	/* $client->user_id = $_POST['user_id'];*/
	$client->curp = $_POST['curp'];
	$client->name = $_POST['name'];
	$client->name2 = $_POST['name2'];
	$client->lastname = $_POST["lastname"];
	$client->lastname2 = $_POST["lastname2"];
	$client->address = $_POST["address"];
	$client->phone = $_POST["phone"];
	$client->email = $_POST["email"];


	$client->fecha_nacimiento = $_POST["fecha_nacimiento"];
	$client->trabajo_nombre = $_POST["trabajo_nombre"];
	$client->estado = $_POST["estado"];
	$client->municipio = $_POST["municipio"];
	$client->colonia = $_POST["colonia"];
	$client->address_ref = $_POST["address_ref"];
	$client->url_gps = "";//$_POST["url_gps"];
	$client->clave_elector = $_POST["clave_elector"];


$client->image ="";// $image;
$client->ine_lado1 = "";//$ine_lado1;
$client->ine_lado2 = "";//$ine_lado2;
$client->img_domicilio = "";//$img_domicilio;
$client->img_garantia = "";//$img_garantia;

	$client->update();
	Core::redir("./?view=clients&opt=all");

}
if(isset($_GET['opt']) && $_GET['opt']=="del"){
	try{
	$client = ClientData::getById($_GET["id"]);
	$client->del();
}catch(Exception $e){
	//	unset($_SESSION['deleted_item']);

//		Core::alert("Error. No se puede Eliminar!".$e->getMessage());
		Core::alert("Error. No se puede Eliminar!");
	}
	Core::redir("./?view=clients&opt=all");

}

if(isset($_GET['opt']) && $_GET['opt']=="addaddress"){

	$client = new AddressData();

	$client->name = $_POST["name"];
	$client->address = $_POST["address"];

	$client->estado = $_POST["estado"];
	$client->municipio = $_POST["municipio"];
	$client->colonia = $_POST["colonia"];
	$client->address_ref = $_POST["address_ref"];
	$client->client_id = $_POST["id"];
	$client->add();
	Core::redir("./?view=clients&opt=addresses&id=".$_POST['id']);
}
if(isset($_GET['opt']) && $_GET['opt']=="deladdress"){

	$add = AddressData::getById($_GET["id"]);
	$add->del();
	Core::redir("./?view=clients&opt=addresses&id=".$_GET['client_id']);

}

?>