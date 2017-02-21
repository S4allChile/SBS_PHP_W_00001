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
   
}
