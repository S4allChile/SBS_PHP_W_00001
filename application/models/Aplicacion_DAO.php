<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Aplicacion_DAO
 *
 * @author pfrias
 */
class Aplicacion_DAO extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        
        $this->dbSQL = $this->load->database('eugcom',TRUE);
    }
    
    /**
     * 
     * @return array
     */
    public function stockWeb(){
        
        $this->dbSQL->SELECT('*');
        $this->dbSQL->FROM('BoExistencia');
        $this->dbSQL->WHERE('Codigo_HE','0000100002');
        $this->dbSQL->WHERE('Ano_Proceso',2017);
        $this->dbSQL->WHERE('Codigo_Bodega',189);
        $sql = $this->dbSQL->get();
        
        return $sql->result();
        
    }
    
    public function registrosStock(){
        
        $this->dbSQL->SELECT('*');
        $this->dbSQL->FROM('BoExistencia');
        $this->dbSQL->WHERE('Codigo_HE','0000100002');
        $this->dbSQL->WHERE('Ano_Proceso',2017);
        $this->dbSQL->WHERE('Codigo_Bodega',189);
        $sql = $this->dbSQL->get();
        
        return $sql->num_rows();
        
    }
    
    /**
     * Funcion que busca si un producto esta en la tabla de stock
     * 
     * @param int $codigo
     * @param int $stock
     * @return string
     */
    public function addStock($codigo,$stock){
        
        //Pregunto si el producto existe en la tabla de stock
        $this->db->SELECT('cod_producto');
        $this->db->FROM('w_stock');
        $this->db->WHERE('cod_bodega',189);
        $this->db->WHERE('cod_producto',$codigo);
        $sql = $this->db->get();
        
        if($sql->num_rows()>0){
            //Actualizamos
            $datos = array(
                'stock' => $stock
            );
            $this->db->WHERE('cod_producto',$codigo);
            $rs = $this->db->UPDATE('w_stock',$datos);
            if($rs > 0){
                return 'ACTUALIZADO'; 
            }else{
                return 'ERROR ACTUALIZAR';
            }
                    
        } else {
            $datos = array(
                'cod_bodega' => 189,
                'cod_producto' => $codigo,
                'stock' => $stock
            );
            $rs = $this->db->INSERT('w_stock',$datos);
            if($rs){
                return 'INSERTADO'; 
            }else{
                return 'ERROR INSERTAR';
            }
            
        }
        
    }
    
    public function consultaStockProducto($codigo){
        //Buscamos si el producto existe en eugcom
        $this->dbSQL->SELECT('*');
        $this->dbSQL->FROM('BoExistencia');
        $this->dbSQL->WHERE('Codigo_HE','0000100002');
        $this->dbSQL->WHERE('Ano_Proceso',2017);
        $this->dbSQL->WHERE('Codigo_Bodega',189);
        $this->dbSQL->WHERE('Codigo_Producto',$codigo);
        $sql = $this->dbSQL->get();
        if($sql->num_rows() > 0){
            
            return $sql->row();
            
        }
        else{
            return 0;
        }
        
    }
    
    public function consultaProducto($codigo){
        
        $this->dbSQL->SELECT('*');
        $this->dbSQL->FROM('SiProducto');
        $this->dbSQL->WHERE('Codigo_HE','0000100002');
        $this->dbSQL->WHERE('Codigo_Producto',$codigo);
        $sql = $this->dbSQL->get();
        if($sql->num_rows() > 0){
            
            return $sql->row();
            
        }
        else{
            return 0;
        }
    }
    
    public function consultaNotaPedido($ano,$numero){
        $this->dbSQL->SELECT('*');
        $this->dbSQL->FROM('VeEncabezado_Pedido');
        $this->dbSQL->WHERE('Codigo_HE','0000100002');
        $this->dbSQL->WHERE('Ano_Proceso',$ano);
        $this->dbSQL->WHERE('Numero_Pedido',$numero);
        $sql = $this->dbSQL->get();
        
        if($sql->num_rows() > 0){
            
            return $sql->row();
            
        }
        else{
            return 0;
        }
        
    }
    
    public function clienteXcod($cod){
        
        $this->dbSQL->SELECT('*');
        $this->dbSQL->FROM('VeCliente');
        $this->dbSQL->WHERE('Codigo_HE','0000100002');
        $this->dbSQL->WHERE('Codigo_Cliente',$cod);
        $sql = $this->dbSQL->get();
        return $sql->row();
        
    }
    
    /**
     * Funcion que devuelve los documentos que se generaron de un pedido
     * @param type $ped : Entero numero de pedido ERP
     * @param type $ano : Entero Año de proceso del pedido
     * @return type
     */
    public function docPedido($ped,$ano){
        $campos = array(
            'Codigo_Tipo_Documento',
            'Numero_Documento'
        );
        $this->dbSQL->SELECT($campos);
        $this->dbSQL->FROM('VePedido_Doc_Venta');
        $this->dbSQL->WHERE('Codigo_HE','0000100002');
        $this->dbSQL->WHERE('Ano_Proceso_Pedido',$ano);
        $this->dbSQL->WHERE('Numero_Pedido',$ped);
        $this->dbSQL->GROUP_BY($campos);
        $sql = $this->dbSQL->get();
        
        return $sql->result();
        
    }
    
    public function consultaOt($ped,$ano){
        
        $this->db->SELECT('ordenFlete');
        $this->db->FROM('ws_starken');
        $this->db->WHERE('ano_proceso',$ano);
        $this->db->WHERE('numPedido',$ped);
        $sql = $this->db->get();
        
        return $sql->row();
        
    }
    
    public function consultaVtaWeb($correlativo){
        $this->db->SELECT('*');
        $this->db->FROM('w_encabezado_pedido');
        $this->db->WHERE('correlativo',$correlativo);
        $sql = $this->db->get();
        
        return $sql->row();
        
    }
    
    public function consultaPedidoXoc($oc){
        $campos = array(
            'Numero_Pedido',
            'Ano_Proceso',
            'Fecha_Pedido'
        );
        $this->dbSQL->SELECT($campos);
        $this->dbSQL->FROM('VeEncabezado_Pedido');
        $this->dbSQL->WHERE('Codigo_HE','0000100002');
        $this->dbSQL->WHERE('Orden_Compra',$oc);
        $sql = $this->dbSQL->get();
        
        return $sql->row();
        
    }
    
    public function consultaClienteWebId($id){
        
        $this->db->SELECT('*');
        $this->db->FROM('w_cliente');
        $this->db->WHERE('id_cliente',$id);
        $sql = $this->db->get();
        
        return $sql->row();
        
    }
    
    public function buscaPicking($ped,$ano){
        $this->dbSQL->SELECT('*');
        $this->dbSQL->FROM('Picking_archivo_pedido');
        $this->dbSQL->WHERE('anio',$ano);
        $this->dbSQL->WHERE('pedido',$ped);
        $sql = $this->dbSQL->get();
        
        return $sql->row();
        
        
    }
    
    public function detallePedido($pedido,$ano){
        $this->dbSQL->SELECT('*');
        $this->dbSQL->FROM('VeDetalle_Pedido');
        $this->dbSQL->JOIN('SiProducto', 'SiProducto.Codigo_Producto = VeDetalle_Pedido.Codigo_Producto');
        $this->dbSQL->WHERE('Ano_Proceso',$ano);
        $this->dbSQL->WHERE('Numero_Pedido',$pedido);
        $this->dbSQL->WHERE('VeDetalle_Pedido.Codigo_HE','0000100002');
        $codigos = array('DESPACHO WEB');
        $this->dbSQL->WHERE_NOT_IN('VeDetalle_Pedido.Codigo_producto',$codigos);
        $sql = $this->dbSQL->get();
        
        return $sql->result();
    }
    
    public function consultaStock($codigo,$bodega){
        
        $this->dbSQL->SELECT('*');
        $this->dbSQL->FROM('BoExistencia');
        $this->dbSQL->JOIN('SiProducto', 'SiProducto.Codigo_Producto = BoExistencia.Codigo_Producto');
        $this->dbSQL->WHERE('BoExistencia.Codigo_HE','0000100002');
        $this->dbSQL->WHERE('BoExistencia.Codigo_Producto',$codigo);
        $this->dbSQL->WHERE('Codigo_Bodega',$bodega);
        $this->dbSQL->WHERE('Ano_Proceso',2017);
        $sql = $this->dbSQL->get();
        
        return $sql->row();
        
    }
    
    public function pedidosWebRut($rut){
        
        $this->db->SELECT('*');
        $this->db->FROM('w_encabezado_pedido');
        $this->db->JOIN('w_cliente', 'w_cliente.id_cliente = w_encabezado_pedido.id_cliente');
        $this->db->WHERE('w_cliente.rut',$rut);
        $sql = $this->db->get();
        
        return $sql->result();
        
    }
    
    public function consultaTransbank($tarjeta){
        
        $this->db->SELECT('*');
        $this->db->FROM('trans_webpay');
        $this->db->WHERE('tbk_final_numero_tarjeta',$tarjeta);
        $sql = $this->db->get();
        
        return $sql->result();
        
    }
   
}
