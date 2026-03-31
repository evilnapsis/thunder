<?php
if(isset($_GET["code"]) && $_GET['code']!=""){
$client = ClientData::getLike($_GET['code']);

if($client):
  //  print_r($client);
//$client = ClientData::getById($contrato->client_id);

$array_data = array();

foreach($client as $cli){
  $array_data[] = array(
"id"=>$cli->id,
"name"=>$cli->name,
"name2"=>$cli->name2,
"lastname"=>$cli->lastname,
"lastname2"=>$cli->lastname2,
"curp"=>$cli->curp,
"clave_elector"=>$cli->clave_elector,
"address"=>$cli->address,
"address_ref"=>$cli->address_ref,
"estado"=>$cli->estado,
"municipio"=>$cli->municipio,
"colonia"=>$cli->colonia,
"trabajo_nombre"=>$cli->trabajo_nombre,
);
}

echo json_encode($array_data);
endif;
}
?>
