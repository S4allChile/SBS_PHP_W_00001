<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Escritorio
 *
 * @author pfrias
 */
class Aplicacion extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('aplicacion_DAO');
        	
        //$this->output->enable_profiler(TRUE);   
    }
    
    public function escritorio(){
        
        if($this->session->idUsr){
            $this->load->view('includes/head');
            $this->load->view('includes/menu');
            
            $this->load->view('escritorio');
            
        }else{
            
            redirect();
        }
        
        
    }
    
    public function procesoWebSvl(){
        
        if($this->session->idUsr){
            
            $this->load->view('includes/head');
            $this->load->view('includes/menu');
            
            $this->load->view('procesoWebSvl');
            
        }else{
            
            redirect();
        }
        
    }
    
    public function cargaStockWeb(){
        
        echo "REGISTROS STOCK: ".$this->aplicacion_DAO->registrosStock()."<br/>";
        echo '<hr/>';
        $stock = $this->aplicacion_DAO->stockWeb();
        
            
            echo '<table class="table table-condensed">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>CODIGO</th>';
            echo '<th>STOCK</th>';
            echo '<th>ESTADO</th>';
            echo '<tr/>';
            echo '</thead>';
            echo '<tbody>';
            foreach ($stock AS $productos){
            echo '<tr>';
            echo '<td>'.$productos->Codigo_Producto.'</td>';
            echo '<td>'.$productos->Stock.'</td>';
            echo '<td>'.$this->aplicacion_DAO->addStock($productos->Codigo_Producto,$productos->Stock).'</td>';
            echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
            
        
    }
    
    public function stockCodigo(){
        //Capturo el codigo
        $codigo = $this->input->post('codigo');
        $res = $this->aplicacion_DAO->consultaStockProducto($codigo);
        
        
        if(is_object($res)){

            //Busco el nombre y lo muestro
            $producto = $this->aplicacion_DAO->consultaProducto($codigo);
            echo "<strong>Descripcion: </strong> ".$producto->Descripcion;
            echo "<br/>";
            //Busco las cantidades en stock
            $cantidad = $this->aplicacion_DAO->consultaStockProducto($codigo);
            echo "<strong>Cantidad :</strong>".$cantidad->Stock;
            echo "<br/>";
            //Agrego o actualizo segun corresponda
            echo '<span class="label label-success">'.$this->aplicacion_DAO->addStock($codigo,$cantidad->Stock).'</span>';
            
        }else{
            
            echo "No Existe registro de Stock para este Codigo";
        }
       
    }
    
    
    public function revisaPedido(){
        
        if($this->session->idUsr){
            $this->load->view('includes/head');
            $this->load->view('includes/menu');
            
            $this->load->view('revisaPedido');
            
        }else{
            
            redirect();
        }

    }
    
    public function buscaXnp(){
        //capturo el valor
        $valor = $this->input->post('valor');

        //divido valor para ver si tiene el año
        $pedAno = explode('-', $valor);
        if(count($pedAno) > 1){
            $ped = $pedAno[0];
            $ano = $pedAno[1];
        }else{
            $ped = $pedAno[0];
            $ano = date('Y');
        }
        
        $res = $this->aplicacion_DAO->consultaNotaPedido($ano,$ped);
        if(is_object($res)){
            
            echo '<table class="table table-condensed">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>PEDIDO</th>';
            echo '<th>CLIENTE</th>';
            echo '<th>PEDIDO WEB</th>';
            echo '<th>DIR DESPACHO</th>';
            echo '<th>DESPACHO</th>';
            echo '<th>TRACKING</th>';
            echo '<th></th>';
            echo '<tr/>';
            echo '</thead>';
            echo '<tbody>';
            
            $cli = $this->aplicacion_DAO->clienteXcod($res->Codigo_Cliente);
            $ot = $this->aplicacion_DAO->consultaOt($ped,$ano);
            if(empty($ot)){
                $otrans = '<span class="label label-danger">Sin info</span>';
            }
            else{
                $otrans = $ot->ordenFlete;
            }
            echo '<tr>';
            echo '<td>'.$res->Numero_Pedido.'</td>';
            echo '<td>'.$cli->Razon_Social.'</td>';
            echo '<td>'.$res->Orden_Compra.'</td>';
            echo '<td>'.$res->Direccion_Entrega.'</td>';
            if($res->Codigo_Tipo_Retiro == 3){
                $despacho = "Starken";
            }else{
                $despacho = "BlueExpress";
            }
            echo '<td>'.$despacho.'</td>';
            echo '<td>'.$otrans.'</td>';
            echo '<td></td>';

            echo '</tr>';
            echo '</tbody>';
            echo '</table>';
            
        }else{
            
            echo "NO existe nota de pedido";
        }
 
    }
    
    public function documentosPedido($ped,$ano){
        
        $res = $this->aplicacion_DAO->docPedido($ped,$ano);
        
        $doc = "-";
        $tipo = "-";
        if(!empty($res)){
            foreach ($res AS $val){

                $doc .= $val->Numero_Documento."<br/>";
                $tipo .= $val->Codigo_Tipo_Documento."<br/>";

            }
        }
        $datos = array(
            'doc' => $doc,
            'tipo' => $tipo
        );
        return $datos;
        
    }
    
    public function buscaXnw(){
        //capturo el valor
        $valor = $this->input->post('valor');
        $pedido = $this->aplicacion_DAO->consultaVtaWeb($valor);
        
        if(empty($pedido)){
            echo "PEDIDO NO EXISTE";
        }else{
            echo '<table class="table table-condensed">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>PEDIDO</th>';
            echo '<th>CLIENTE</th>';
            echo '<th>FECHA</th>';
            echo '<th>DESPACHO</th>';
            echo '<th>PAGADO</th>';
            echo '<th>ERP</th>';
            echo '<th>TRACKING</th>';
            echo '<th></th>';
            echo '<tr/>';
            echo '</thead>';
            echo '<tbody>';
            
            if($pedido->estado == 2){
                $pagado = '<span class="label label-success">Pagado</span>';
            }else{
                $pagado = '<span class="label label-danger">Sin Pago</span>';
            }
            
            $pedOc = $this->aplicacion_DAO->consultaPedidoXoc($pedido->correlativo);
            if(empty($pedOc)){
                
                $numPedido = '<span class="label label-danger">NO</span>';
                $ped = 0;
                $ano = 0;
                
            }else{
                
                $numPedido = $pedOc->Numero_Pedido."-".$pedOc->Ano_Proceso;
                $ped = $pedOc->Numero_Pedido;
                $ano = $pedOc->Ano_Proceso;
            }
            
            $cliId = $this->aplicacion_DAO->consultaClienteWebId($pedido->id_cliente);
            if(empty($cliId)){
                
                $cliente = '<span class="label label-danger">NO</span>';
                
            }else{
                
                $cliente = $cliId->nombre_cliente." ".$cliId->apellidos;
            }
            
            $ot = $this->aplicacion_DAO->consultaOt($ped,$ano);
            if(empty($ot)){
                
                $numOt = '<span class="label label-danger">NO</span>';
                
            }else{
                
                $numOt = $ot->ordenFlete;
            } 
           
            echo '<tr>';
            echo '<td>'.$pedido->correlativo.'</td>';
            echo '<td>'.$cliente.'</td>';
            echo '<td>'.$pedido->fecha.'</td>';
            echo '<td>'.$pedido->dir_despacho.'</td>';
            echo '<td>'.$pagado.'</td>';
            echo '<td>'.$numPedido.'</td>';
            echo '<td>'.$numOt.'</td>';
            echo '<td>';
                echo '<span class="glyphicon glyphicon-file docs" aria-hidden="true" data-toggle="tooltip" data-placement="top" data-pedido='.$ped.'-'.$ano.' title="Documentos"></span>';
            echo '</td>';
            echo '<tr>';
            echo '</tbody>';
            echo '</table>';
            
            if($ped == 0 && $ano == 0){
                $fechaCompra = "-";
                $fechaPedido = "-";
                $fechaArchivoSVL = "-";
                $fechaPicking = "-";
            }else{
                $picking = $this->aplicacion_DAO->buscaPicking($ped,$ano);
            
                $fechaCompra = fechaMysqlNormal($pedido->fecha);
                $fechaPedido = fechaSqlNormal($pedOc->Fecha_Pedido);
                $fechaArchivoSVL = fechaSqlNormal($picking->fecha_archivo_pedido);
                $fechaPicking = $picking->fecha_ingreso;
            
            }
            echo '<hr/>';
            echo '<h4>Seguimiento</h4>';
            echo '<li> <strong>Fecha de Compra: </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$fechaCompra.' </li>';
            echo '<li> <strong>Fecha de Pedido:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$fechaPedido.' </li>';
            echo '<li> <strong>Fecha de Archivo SVL:</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$fechaArchivoSVL.'</li>';
            echo '<li> <strong>Fecha de Picking:</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$fechaPicking.'</li>';
            
            
            echo '<hr/>';
            echo '<h4>Cliente</h4>';
           
            
            
            
            
        }
        
    }
    
    public function buscaDocumentos(){
        
        $dato = $this->input->post('ped');
        //divido el pedido del año
        $pedAno = explode("-", $dato);
        $ped = $pedAno[0];
        $ano = $pedAno[1];
        
        //busco los documentos
        $docs = $this->aplicacion_DAO->docPedido($ped,$ano);
        if(empty($docs)){
            echo '<span class="label label-danger">NO</span>';
        }else{
             echo '<table class="table table-condensed">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>DOC</th>';
            echo '<th>NUM</th>';
            echo '<th>URL</th>';
            echo '<tr/>';
            echo '</thead>';
            echo '<tbody>';
            foreach ($docs AS $doc){
                echo '<tr>';
                echo '<td>'.$doc->Codigo_Tipo_Documento.'</td>';
                echo '<td>'.$doc->Numero_Documento.'</td>';
                echo '<td>http://192.168.1.4/eugcomdte</td>';
                echo '<tr>';
            }
            echo '</tbody>';
            echo '</table>';
        }
        
    }
}
