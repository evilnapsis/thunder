<?php

$tipo = ServicioSeguridadData::getById($_GET['id']);
if($tipo){
	echo $tipo->price;
}

?>