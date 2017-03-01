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
