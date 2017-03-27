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
 * @author Frios
 * 
 */
class EquiposController extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('equipos_DAO');
        $this->load->model('usuarios_DAO');
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
     * 
     * prueba de envio para firefox
     * 
     * 
     */
    
    public function pruebadeenvio(){
        echo "prueba de envio";
        
    }   

    /**
     * funcion del controlador para cargar vista de mantenedor de equipos
     */
    public function equiposIngSal() {

        if ($this->session->idUsr) {
            $this->load->view('includes/head');
            $this->load->view('includes/menu');

            $data['usuarios']   = $this->usuarios_DAO->todosUsuarios();
            $data['tipoSalida'] = $this->equipos_DAO->tipoSalida();

            $this->load->view('equiposIngSal', $data);
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

        $selectUltimoEquipo = $this->equipos_DAO->selectUltimoEquipo();
        $ultimoRegistro = "";
        foreach ($selectUltimoEquipo as $ultimo) {
            $ultimoRegistro = $ultimo->id;
        }
        $ultimoMasUno = $ultimoRegistro + 1;
        $ultimoZeroFill = str_pad($ultimoMasUno, 6, "0", STR_PAD_LEFT);


        $codigo = $origen . $tipo . $marca . $ultimoZeroFill;
        // echo $codigo;


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
            echo "Se creo el codigo " . $codigo;
        }
    }

    /**
     * funcion del controlador para EDITAR equipo
     */
    public function editarEquipo() {
        $id = $this->input->post('hiddenId');
        // $codigo = $this->input->post('txtCodigoE');
        $tipo = $this->input->post('sltTipoE');
        $serie = $this->input->post('txtSerieE');
        $marca = $this->input->post('sltMarcaE');
        $modelo = $this->input->post('txtModeloE');
        $descripcion = $this->input->post('areaDescripcionE');
        $origen = $this->input->post('sltOrigenE');

        $data = array(
            //    'codigo' => $codigo,
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



        $editarEquipo = $this->equipos_DAO->editarEquipo($data, $id);
        print_r($editarEquipo);
    }

    /**
     * funcion para dar de baja un equipo
     */
    public function bajarEquipo() {
        $observacion = $this->input->post('areaDescripcionB');
        $id = $this->input->post('hiddenIdBaja');


        $data = array(
            'fecha_baja' => date('Y-m-d'),
            'estado' => 3,
            'activo' => 0,
            'observacion_baja' => $observacion
        );



        $crearEquipo = $this->equipos_DAO->editarEquipo($data, $id);
        print_r($crearEquipo);
    }

    /**
     * funcion para registrar salida de equipos
     */
    public function registrarSalida() {


        echo "filtro principal<br>";
        $usuario = $this->input->post('sltUsuario');
        $tipoSalida = $this->input->post('sltSalida');
        $fechaSalida = date('Y-m-d');
        $fechaEntrada = '0000-00-00';
        $codigo = $this->input->post('txtCodidoSale');

        echo "filtro antes de la validacion<br>";
        $validarEquipo = $this->equipos_DAO->validarIngresoEquipoParaSalidaEntrada($codigo); //:valido que el equipo exista 
        print_r($validarEquipo);

        if ($validarEquipo == 0) {
            echo "El equipo no existe";
        } else {
            $id = "";
            $estadoEq = "";
            foreach ($validarEquipo as $val) {
                $id = $val->id;
                $estadoEq = $val->estado;
            }
            if ($estadoEq == 3) {
                echo "El equipo fue dado de baja";
            }
            if ($estadoEq == 2) {
                echo "El equipo no esta disponible";
            }
            if ($estadoEq == 1) {
                $data = array(
                    'equipo_fk' => $id,
                    'usuario_fk' => $usuario,
                    'salida_fk' => $tipoSalida,
                    'fecha_salida' => $fechaSalida,
                    'fecha_entrada' => $fechaEntrada,
                    'estado' => 1
                );
                $dataModEstado = array(
                    'estado' => 2
                );

                $modificarEstadoEquipo = $this->equipos_DAO->editarEquipo($dataModEstado, $id);
                $registrarSalida = $this->equipos_DAO->registarMovimientoEquipo($data);



                echo "Se ha registrado la salida correctamente";
            }
        }
    }

    /**
     * funcion para registrar entrada de equipos
     */
    public function registrarEntrada() {
        echo "filro 1<br>";
        $codigo = $this->input->post('txtCodigoEntrada');
        $validarEquipo = $this->equipos_DAO->validarIngresoEquipoParaSalidaEntrada($codigo); //:valido que el equipo exista 

        echo "filtro2<br>";
        if ($validarEquipo == 0) {
            echo "El equipo no existe";
        } else {
            // print_r($validarEquipo);
            $id = "";
            $estado = "";
            foreach ($validarEquipo as $val) {//:datos del equipo
                $id = $val->id;
                $estado = $val->estado;
            }

            if ($estado == 3) {
                echo "El equipo fue dado de baja";
            } else if ($estado == 2) {


                $buscarDatosDelUso = $this->equipos_DAO->buscarDatosDelUltimoUso($id, 1);

                if ($buscarDatosDelUso == 0) {

                    echo "El equipo no tiene salidas";
                } else {
                    $equipo = "";
                    $usuario_fk = "";
                    $salida = "";
                    $fecha_salida = '0000-00-00';
                    $fecha_entrada = date('Y-m-d');



                    // print_r($buscarDatosDelUso);
                    foreach ($buscarDatosDelUso as $buscar) {

                        $equipo = $buscar->equipo_fk;
                        $usuario_fk = $buscar->usuario_fk;
                        $salida = $buscar->salida_fk;
                    }

                    $dataRegistroEntrada = array(
                        'equipo_fk' => $equipo,
                        'usuario_fk' => $usuario_fk,
                        'salida_fk' => $salida,
                        'fecha_salida' => $fecha_salida,
                        'fecha_entrada' => $fecha_entrada,
                        'estado' => 0);


                    $dataModificarEstadoUso = array('estado' => 0); //: deja el estado del uso en 0 (registro antiguo)
                    $registrarEntrada = $this->equipos_DAO->modificarMovimientoEquipo($dataModificarEstadoUso, $id, 1);


                    $dataModEstado = array('estado' => 1);  //: deja el equipo con estado 1 (disponible)                 
                    $modificarEstadoEquipo = $this->equipos_DAO->editarEquipo($dataModEstado, $id);

                    $registraEstrada = $this->equipos_DAO->registarMovimientoEquipo($dataRegistroEntrada);

                    echo "Se ha registrado la entrada correctamente";
                }
            } else if ($estado == 1) {
                echo "El equipo no puedo ser ingresado por que no ha salido";
            }
        }
    }
    
   

}
