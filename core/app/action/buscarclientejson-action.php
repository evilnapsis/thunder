<?php
if(isset($_GET["code"]) && $_GET['code']!=""){
$client = ClientData::getLikeOne($_GET['code']);

if($client):
  //  print_r($client);
//$client = ClientData::getById($contrato->client_id);



echo json_encode(array(
"id"=>$client->id,
"name"=>$client->name,
"name2"=>$client->name2,
"lastname"=>$client->lastname,
"lastname2"=>$client->lastname2,
"curp"=>$client->curp,
"clave_elector"=>$client->clave_elector,
"address"=>$client->address,
"address_ref"=>$client->address_ref,
"estado"=>$client->estado,
"municipio"=>$client->municipio,
"colonia"=>$client->colonia,
"trabajo_nombre"=>$client->trabajo_nombre,
));
endif;
}
?>
