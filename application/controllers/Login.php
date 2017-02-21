<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Login
 *
 * @author pfrias
 */
class Login extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        
        $this->load->model('login_DAO');
    }
    
    public function index(){
        
        $this->load->view('login');
        
    }
    
    public function validaUserPass(){
        
        //Capturo las variables del formulario de login
        $usuario = $this->input->post('user');
        $pass = $this->input->post('pass');
        
        //ENCRIPTAMOS LA CONTRASEÑA
        $pass = sha1($pass);
        
        //ponemos el usuario en minusculas
        $usuario = strtolower($usuario);
        
        //LLamamos al modelo para validar
        $valor = $this->login_DAO->validaLogin($usuario,$pass);
        if($valor == 0){
            
            echo 0;
            
        } else {
            
            foreach ($valor as $nom){
                
                $this->session->set_userdata("nomUsr", $nom->nombre_usr);
                $this->session->set_userdata("idUsr", $nom->id_usr);
                
            }

            echo 1;
        }        
        
    }
    
    public function salir(){
        $this->session->sess_destroy();
        redirect();
    }
    
    
    
    
}
