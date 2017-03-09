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
            
          
            echo '</tbody>';
            echo '</table>';
            
            echo '<hr/>';
            echo '<h4 class="page-header">Detalle del Pedido</h4>';
            
            $detalle = $this->aplicacion_DAO->detallePedido($ped,$ano);
            
            echo '<table class="table table-condensed">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>CODIGO</th>';
            echo '<th>DESCRIPCION</th>';
            echo '<th>CANTIDAD</th>';
            echo '<th>DESPACHADO</th>';
            echo '<th>STK SVL</th>';
            echo '<tr/>';
            echo '</thead>';
            echo '<tbody>';
            
            foreach ($detalle AS $producto){
                
                echo '<tr>';
                echo '<td>'.$producto->Codigo_Producto.'</td>';
                echo '<td>'.$producto->Descripcion.'</td>';
                echo '<td>'.$producto->Cantidad.'</td>';
                echo '<td>'.$producto->Despachado.'</td>';
                echo '<td>'. number_format(valida_stock_svl($producto->Codigo_Producto),0).'</td>';
                echo '<tr>';
            }
            
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
            echo '<h4 class="page-header">Seguimiento</h4>';
            echo '<ul class="list-group">';
                echo '<li class="list-group-item list-group-item-info">
                  <span class="badge">'.$fechaCompra.'</span>
                  <strong>Fecha de Compra:</strong>
                </li>';
                
                echo '<li class="list-group-item list-group-item-info">
                  <span class="badge">'.$fechaPedido.'</span>
                  <strong>Fecha de Pedido:</strong>
                </li>';
                
                echo '<li class="list-group-item list-group-item-info">
                  <span class="badge">'.$fechaArchivoSVL.'</span>
                  <strong>Fecha de Archivo SVL:</strong>
                </li>';
                
                echo '<li class="list-group-item list-group-item-info">
                  <span class="badge">'.$fechaPicking.'</span>
                  <strong>Fecha de Picking:</strong>
                </li>';
                
            echo '</ul>';
            
   
            
            if($cliId->id_erp == ''){
                $idERP = '<a class="btn btn-primary btn-xs" href="#">Enviar ERP</a>';
            }else{
                $idERP = $cliId->id_erp;
            }
            
            echo '<hr/>';
            echo '<h4 class="page-header">Cliente</h4>';
            echo '<ul class="list-group">';
                echo '<li class="list-group-item list-group-item-info">
                  <span class="badge">'.$cliId->nombre_cliente.' '.$cliId->apellidos.'</span>
                  <strong>Nombre:</strong>
                </li>';
                
                echo '<li class="list-group-item list-group-item-info">
                  <span class="badge">'.$cliId->rut.'</span>
                  <strong>RUT:</strong>
                </li>';
                
                echo '<li class="list-group-item list-group-item-info">
                  <span class="badge">'.$idERP.'</span>
                  <strong>ID ERP:</strong>
                </li>';
                
            echo '</ul>';
            
            
            $detallePedido = $this->aplicacion_DAO->detallePedidoWeb($pedido->id_enc_pedido);
            echo '<hr/>';
            echo '<h4 class="page-header">Detalle Pedido</h4>';
            echo '<table class="table table-condensed">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>CODIGO</th>';
            echo '<th>DESCRIPCION</th>';
            echo '<th>CANTIDAD</th>';
            echo '<th>VALOR</th>';
            echo '<th>TOTAL</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            foreach ($detallePedido AS $detalle){
                
                echo '<tr>';
                    echo '<td>'.$detalle->isbn.'</td>';
                    echo '<td>'.$detalle->descripcion.'</td>';
                    echo '<td>'.$detalle->cantidad.'</td>';
                    echo '<td>'.$detalle->valor.'</td>';
                    echo '<td>'.$detalle->total_linea.'</td>';
                echo '</tr>';
                
            }
            
            echo '</tbody>';
            echo '</table>';
            
            
            
            
            
            
            
            
            
            
            
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
    
    public function stockProducto(){
        $codigo = $this->input->post('codigo');
        
        $stkWeb = $this->aplicacion_DAO->consultaStock($codigo,189);
        $stkPrincipal = $this->aplicacion_DAO->consultaStock($codigo,1);
        $stkSVL = valida_stock_svl($codigo);
        
        echo '<table class="table table-condensed">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>CODIGO</th>';
            echo '<th>DESCRIPCION</th>';
            echo '<th>STK WEB</th>';
            echo '<th>STK SBS</th>';
            echo '<th>STK SVL</th>';
            echo '<tr/>';
            echo '</thead>';
            echo '<tbody>';
            echo '<tr>';
                echo '<td>'.$codigo.'</td>';
                echo '<td>'.$stkWeb->Descripcion.'</td>';
                echo '<td>'.$stkWeb->Stock.'</td>';
                echo '<td>'.$stkPrincipal->Stock.'</td>';
                echo '<td>'.$stkSVL.'</td>';
                
                echo '<tr>';
            echo '</tbody>';
            echo '</table>';
        
    }
    
    public function pedidoWebRut(){
        $rut = $this->input->post('rut');
        
        $pedidos = $this->aplicacion_DAO->pedidosWebRut($rut);
        
        echo '<table class="table table-condensed">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>RUT</th>';
            echo '<th>ID_CLIENTE</th>';
            echo '<th>PEDIDO</th>';
            echo '<th>PAGADO</th>';
            echo '<tr/>';
            echo '</thead>';
            echo '<tbody>';
            foreach ($pedidos AS $pedido){
                
                $pagado = $pedido->estado;
                if($pagado == 1){
                    
                    $pago = '<span class="label label-danger">Sin Pago</span>';
                    $linea = 'style="color:red"';
                }else{
                    $pago = '<span class="label label-success">OK</span>';
                    $linea = '';
                }
                
            echo '<tr '.$linea.'>';
                echo '<td>'.$pedido->rut.'</td>';
                echo '<td>'.$pedido->id_cliente.'</td>';
                echo '<td>'.$pedido->correlativo.'</td>';
                echo '<td>'.$pago.'</td>';
            echo '<tr>';
            }
            echo '</tbody>';
            echo '</table>';
        
        
    }
    
    public function transbank(){
        $tarjeta = $this->input->post('tarjeta');
        
        $tbk = $this->aplicacion_DAO->consultaTransbank($tarjeta);
        
        echo '<table class="table table-condensed">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>PEDIDO</th>';
            echo '<th>MONTO</th>';
            echo '<th>FECHA</th>';
            echo '<tr/>';
            echo '</thead>';
            echo '<tbody>';
            foreach ($tbk AS $dato){

            echo '<tr>';
                echo '<td>'.$dato->tbk_orden_compra.'</td>';
                echo '<td>'.number_format($dato->tbk_monto,0,",",".").'</td>';
                echo '<td>'.$dato->fechaCompleta.'</td>';
            echo '<tr>';
            }
            echo '</tbody>';
            echo '</table>';
        
        
    }
    
    
}
