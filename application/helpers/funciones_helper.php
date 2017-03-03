<?php

function fechaMysqlNormal($fecha){
    $fechaHora = explode(' ', $fecha);
    $fecha = $fechaHora[0];
    $hora = $fechaHora[1];
    
    $fechaCom = explode('-', $fecha);
    $ano = $fechaCom[0];
    $mes = $fechaCom[1];
    $dia = $fechaCom[2];
    
    return $dia."-".$mes."-".$ano." ".$hora;
    
}

function fechaSqlNormal($fecha){
    
    return date('d-m-Y H:i:s', strtotime($fecha));
}

function valida_stock_svl($codigo){
	//PARAMETROS
	$empresa = "SBS";
	$producto = $codigo;
	$usuario = "PFRIAS";
	$pass = "81dc9bdb52d04dc20036dbd8313ed055";
	$url = "http://www.degesis.cl/svl/consultas/webservices/stock_producto.php?empresa=".$empresa."&producto=".$producto."&usuario=".$usuario."&password=".$pass;

	//INICIAMOS LA CONSULTA DE STOCK
	try{
		$valor = file_get_contents($url);
		$arreglo = explode("\n",$valor);
		$cantidad = count($arreglo);
		if($cantidad > 2) {
			for ($i = 1; $i < $cantidad - 1; $i++)
			{
				$final = explode(";", $arreglo[$i]);
				$cant = $final[4];
			}
			return $cant;
		}
		else {
			throw new Exception('Codigo no existe');
		}

	}
	catch(Exception $e){

		return $e->getMessage();
	}

}

function salida_pantalla(){
    ob_end_flush();
    //ob_flush();
    flush();
    ob_start();
}
