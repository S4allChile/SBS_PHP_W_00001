<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Gerencia_DAO
 *
 * @author pfrias
 */
class Gerencia_DAO extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        
        $this->dbSQL = $this->load->database('eugcom',TRUE);
    }
    
    public function pendientesAgrupados(){
        $campos = array(
            'CODIGO',
            'Descripcion'
            
        );
        $this->dbSQL->SELECT($campos);
        $this->dbSQL->SELECT_SUM('Cantidad');
        $this->dbSQL->SELECT_SUM('Despachado');
        $this->dbSQL->SELECT_SUM('PENDIENTE');
        $this->dbSQL->FROM('PEDIDOS_PENDIENTES');
        $this->dbSQL->WHERE('ANIO',2017);
        $this->dbSQL->GROUP_BY($campos);
        $sql = $this->dbSQL->get();
        
        return $sql->result();
    }
    
    public function stock($bod,$ano,$cod){
        $this->dbSQL->SELECT('*');
        $this->dbSQL->FROM('BoExistencia');
        $this->dbSQL->WHERE('Codigo_HE','0000100002');
        $this->dbSQL->WHERE('Ano_Proceso',$ano);
        $this->dbSQL->WHERE('Codigo_Bodega',$bod);
        $this->dbSQL->WHERE('Codigo_Producto',$cod);
        $sql = $this->dbSQL->get();
        
        return $sql->row();
    }
    
    public function ocPendientes($codigo){
        $this->dbSQL->SELECT('*');
        $this->dbSQL->FROM('OrdenCompraPendientes');
        $this->dbSQL->WHERE('Codigo_Producto',$codigo);
        $sql = $this->dbSQL->get();
        
        return $sql->result();
    }
    
    
    
}
