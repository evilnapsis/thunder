<?php

$tipo = TipoServicioData::getById($_GET['id']);
if($tipo){
	echo $tipo->price;
}

?>