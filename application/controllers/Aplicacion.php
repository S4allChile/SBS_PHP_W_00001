<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Escritorio
 *
 * @author pfrias
 */
class Aplicacion extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('aplicacion_DAO');
    }
    
    public function escritorio(){
        
        if($this->session->idUsr){
            $this->load->view('includes/head');
            $this->load->view('includes/menu');
            
            $this->load->view('escritorio');
            
        }else{
            
            redirect();
        }
        
        
    }
    
    public function procesoWebSvl(){
        
        if($this->session->idUsr){
            
            $this->load->view('includes/head');
            $this->load->view('includes/menu');
            
            $this->load->view('procesoWebSvl');
            
        }else{
            
            redirect();
        }
        
    }
    
    public function cargaStockWeb(){
        
        echo "REGISTROS STOCK: ".$this->aplicacion_DAO->registrosStock()."<br/>";
        echo '<hr/>';
        $stock = $this->aplicacion_DAO->stockWeb();
        
            
            echo '<table class="table table-condensed">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>CODIGO</th>';
            echo '<th>STOCK</th>';
            echo '<th>ESTADO</th>';
            echo '<tr/>';
            echo '</thead>';
            echo '<tbody>';
            foreach ($stock AS $productos){
            echo '<tr>';
            echo '<td>'.$productos->Codigo_Producto.'</td>';
            echo '<td>'.$productos->Stock.'</td>';
            echo '<td>'.$this->aplicacion_DAO->addStock($productos->Codigo_Producto,$productos->Stock).'</td>';
            echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
            
        
    }
}
