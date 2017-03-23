<?php

defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('America/Santiago');
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
class Equipos extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('equipos_DAO');
    }

    /**
     * funcion del controlador para cargar vista de mantenedor de equipos
     */
    public function equipoMantenedor() {

        if ($this->session->idUsr) {
            $this->load->view('includes/head');
            $this->load->view('includes/menu');

            $data['equiposActivos'] = $this->equipos_DAO->equiposActivos();
            $data['equiposTipo'] = $this->equipos_DAO->tipoEquipo();
            $data['equiposMarca'] = $this->equipos_DAO->marcaEquipo();

            $this->load->view('equipoMantenedor', $data);
        } else {

            redirect();
        }
    }

    /**
     * funcion del controlador para cargar vista de mantenedor de equipos
     */
    public function equiposGestion() {

        if ($this->session->idUsr) {
            $this->load->view('includes/head');
            $this->load->view('includes/menu');

            $this->load->view('equiposGestion');
        } else {

            redirect();
        }
    }

    /**
     * funcion del controlador para obtener un equipo en base al id
     */
    public function equipoPorId() {

        $idEquipo = $this->input->post('equipoId');
        $resEquipo = $this->equipos_DAO->equipoId($idEquipo);
        $json = json_encode($resEquipo);
        print_r($json);
    }

    /**
     * funcion del controlador CREAR equipo
     */
    public function creaEquipo() {

        $codigo = $this->input->post('txtCodigo');
        $tipo = $this->input->post('sltTipo');
        $serie = $this->input->post('txtSerie');
        $marca = $this->input->post('sltMarca');
        $modelo = $this->input->post('txtModelo');
        $descripcion = $this->input->post('areaDescripcion');
        $origen = $this->input->post('sltOrigen');

        $data = array(
            'codigo' => $codigo,
            'tipo_fk' => $tipo,
            'serie' => $serie,
            'marca_fk' => $marca,
            'modelo' => $modelo,
            'descripcion' => $descripcion,
            'propio' => $origen,
            'fecha_ingreso' => date('Y-m-d'),
            'estado' => 1,
            'activo' => 1,
            'observacion_baja' => 'Equipo activo'
        );

        $validar = $this->equipos_DAO->validarIngresoEquipo($codigo);

        if ($validar > 0) {
            echo 2;
        } else {

            $crearEquipo = $this->equipos_DAO->InsertarEquipo($data);
            print_r($crearEquipo);
        }
    }
    
    
     /**
     * funcion del controlador para EDITAR equipo
     */
    public function editarEquipo() {
        $id=  $this->input->post('hiddenId');
        $codigo = $this->input->post('txtCodigoE');
        $tipo = $this->input->post('sltTipoE');
        $serie = $this->input->post('txtSerieE');
        $marca = $this->input->post('sltMarcaE');
        $modelo = $this->input->post('txtModeloE');
        $descripcion = $this->input->post('areaDescripcionE');
        $origen = $this->input->post('sltOrigenE');

        $data = array(
            'codigo' => $codigo,
            'tipo_fk' => $tipo,
            'serie' => $serie,
            'marca_fk' => $marca,
            'modelo' => $modelo,
            'descripcion' => $descripcion,
            'propio' => $origen,
            'fecha_ingreso' => date('Y-m-d'),
            'estado' => 1,
            'activo' => 1,
            'observacion_baja' => 'Equipo activo'
        );

        

            $crearEquipo = $this->equipos_DAO->editarEquipo($data,$id);
            print_r($crearEquipo);
       
    }
    
    /**
     * funcion para dar de baja un equipo
     */
    public function bajarEquipo() {
        $observacion=  $this->input->post('areaDescripcionB');
        $id = $this->input->post('hiddenIdBaja');
     

        $data = array(
            
            
            'fecha_baja' => date('Y-m-d'),
            'estado' =>3,
            'activo' => 0,
            'observacion_baja' => $observacion
        );

        

            $crearEquipo = $this->equipos_DAO->editarEquipo($data,$id);
            print_r($crearEquipo);
       
    }

}
