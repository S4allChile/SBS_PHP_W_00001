<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Login_DAO
 *
 * @author pfrias
 */
class Login_DAO extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function validaLogin($user,$pass){
        $this->db->SELECT('*');
        $this->db->FROM('usuarios');
        $this->db->WHERE('username',$user);
        $this->db->WHERE('pass',$pass);
        $sql = $this->db->get();
        if($sql->num_rows() > 0){
            
            return $sql->result();
        }
        else{
            
            return 0;
            
        }
        
    }
}
