<?php

$tipo = ServicioTesoreriaData::getById($_GET['id']);
if($tipo){
	echo $tipo->price;
}

?>