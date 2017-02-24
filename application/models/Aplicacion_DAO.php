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
            'Ano_Proceso'
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
   
}
