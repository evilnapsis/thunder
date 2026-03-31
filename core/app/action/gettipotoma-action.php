<?php

$tipo = TipoTomaData::getById($_GET['id']);
if($tipo){
    $tipo_servicio = TipoServicioData::getByToma($tipo->id);
	echo $tipo_servicio->price;
}

?>