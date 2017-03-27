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
class Usuarios_DAO extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        
        $this->dbSQL = $this->load->database('eugcom',TRUE);
    }
    

    /**
     * Funcion para buscar todos los usuarios
     */
    public function todosUsuarios(){
        
         $this->db->SELECT('*');
         $this->db->FROM('usuarios');
         $this->db->WHERE('estado',1);
        
        $sql = $this->db->get();
        
        return $sql->result();
        
        
    }
    
    
    }
