<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Gerencia
 *
 * @author pfrias
 */
class Gerencia extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        
        $this->load->model('gerencia_DAO');
    }
    
    public function index(){
        
        if($this->session->idUsr){
                
            $this->load->view('includes/head');
            $this->load->view('includes/menu');
            
            $this->load->view('escritorioGerencia');
            
        }else{
            
            redirect();
        }
        
    }
    
    public function productos_pendientes(){
        
        if($this->session->idUsr){
                
            $this->load->view('includes/head');
            $this->load->view('includes/menu');
            $data = array(
                'productosPendientes' => $this->gerencia_DAO->pendientesAgrupados()
                
            );
            $this->load->view('productosPendientes',$data);
            
        }else{
            
            redirect();
        }
    }
   
}
