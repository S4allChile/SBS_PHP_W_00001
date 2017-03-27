<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ControlDePrueba extends CI_Controller {

    public function __construct() {
        parent::__construct();
         

       // $this->load->model('equipos_DAO');
        //$this->load->model('usuarios_DAO');
    }

    
    
    public function pruebaControlPrueba(){        
        
         echo "prueba control prueba";
    }
}