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
class Equipos_DAO extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        
        $this->dbSQL = $this->load->database('eugcom',TRUE);
    }

    /*
     * funcion que rescata todos los equipos activos 
     */
    public function equiposActivos(){
        $this->db->SELECT('*');
        $this->db->FROM('descripcion_equipos_completa');
       // $this->db->WHERE('id_estado',1);       
        $sql = $this->db->get();
        
        return $sql->result();
    
    }
    
    
    /*
     * funcion que rescata todos los tipos de equipo 
     */
    public function tipoEquipo(){
        $this->db->SELECT('*');
        $this->db->FROM('equipo_tipo');
        $this->db->ORDER_BY('descripcion','asc');
        $sql = $this->db->get();
        
        return $sql->result();
    
    }
    /*
     * funcion que rescata todos las marcas de equipos 
     */
    public function marcaEquipo(){
        $this->db->SELECT('*');
        $this->db->FROM('equipo_marca');
        $this->db->ORDER_BY('descripcion','asc');
        $sql = $this->db->get();
        
        return $sql->result();
    
    }
    
    /*
     * funcion para buscar equipo por el id
     */
    public function equipoId($idEquipo){
        $this->db->SELECT('*');
        $this->db->FROM('descripcion_equipos_completa');
        $this->db->WHERE('id',$idEquipo);
        
        $sql = $this->db->get();
        
        return $sql->result();
    
    }
    
    /**
     * funcion para insertar un nuevo equipo
     */
    
    public function insertarEquipo($data){
        
     $insert =  $this->db->insert('equipos', $data);
       return $insert;
    }
    /**
     * funcion para validar ingreso de equipos
     */
    
    public function validarIngresoEquipo($codigo){
        
        
        $this->db->select('*');
        $this->db->from('equipos');
        $this->db->where('codigo', $codigo);
       
        $sql = $this->db->get();
        $numReg = $sql->num_rows();

        if ($numReg == 0) {
            return 0;
        } else {

            return 1;
        }
        
    }
    
   /**
     * funcion para insertar un nuevo equipo
     */
    
    public function editarEquipo($data,$id){
        
        $this->db->where('id', $id);
        return $this->db->update('equipos', $data);
    }
    
    }