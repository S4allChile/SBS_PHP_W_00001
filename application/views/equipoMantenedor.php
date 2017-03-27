<?php
$ci = &get_instance();
$ci->load->model("gerencia_DAO");
?>



<div class="page-header">
    <div class="row">

        <div class="col-md-2"> <h3>GESTION DE EQUIPOS</h3></div>

        <div class="col-md-3">

            <button type="button" class="btn btn-default btn-sm " data-toggle="modal" data-target="#agregarEquipo"><i class="fa fa-plus"> Agregar nuevo equipo</i></button>
        </div>


    </div>

</div>


<div class="container"><!---inicio del contenedor-->



    <div class="row">
        <div class="row">
            <div class="col-md-7">
                <!------------------------------inicio del los filtros--------------------------------------------------------->
                <div class="col-md-6">
                    <form id="porCodigo" action="#" method="post">
                        <div class="form-group">
                            <input type="text" class="form-control :required" name="valor" id="codigo" placeholder="Busca por codigo" />
                        </div>

                        <button type="submit" class="btn btn-block btn-primary btn-xs" id="btnBuscaPorCodigo">Codigo</button>
                    </form>
                </div>
                <div class="col-md-6">
                    <form id="porSerie" action="#" method="post">
                        <div class="form-group">
                            <input type="text" class="form-control :required" name="valor" id="codigo" placeholder="Busca por serie" />
                        </div>

                        <button type="submit" class="btn btn-block btn-primary btn-xs" id="btnBuscaPorSerie">Numero Web</button>
                    </form>
                </div>

            </div><!--fin de las cold7-->

            <div class="col-md-5" >

                <div style=" background-color: whitesmoke; color: black; border-radius:5px">

                    <h4 align="center">  FICHA EQUIPO <br><small style=" background-color: whitesmoke; color: black;">selecciona equipo</small> </h4>


                </div>


            </div><!--fin de las cold45-->

        </div><!---fibn de la row 2-->



        <hr>

        <!------------------------------fin del los filtros--------------------------------------------------------->

        <div class="col-md-7">





            <table id="" class="table table-condensed" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>CODIGO</th>
                        <th>TIPO</th>
                        <th>SERIE</th>
                        <th>ESTADO</th>
                        <th>FICHA</th>


                    </tr>
                </thead>

                <tbody>
                    <?php
                    foreach ($equiposActivos AS $equipos) {
                        ?>
                        <tr>
                            <td><?= $equipos->codigo; ?></td>
                            <td><?= $equipos->tipo; ?></td>
                            <td><?= $equipos->serie; ?></td>
                            <td><?php
                                if ($equipos->id_estado == 3) {

                                    echo '<button type="button" class="btn btn-danger btn-xs">Baja</button>';
                                }
                                if ($equipos->id_estado == 1) {

                                    echo '<button type="button" class="btn btn-success btn-xs">Disponible</button>';
                                }
                                if ($equipos->id_estado == 2) {

                                    echo '<button type="button" class="btn btn-warning btn-xs">No disponible</button>';
                                }
                                ?>


                            </td>
                            <td><button class="btn btn-xs btn-primary btnFicha" data-id="<?= $equipos->id; ?>"><i class="fa fa-list-alt" aria-hidden="true"></i></button></td>


                        </tr>
                    <?php } ?>    
                </tbody>
            </table>
        </div>


        <div class="col-md-5" >


            <div id="tablaMuestraFicha">

                <!-----tabla de la ficha------->

            </div>
        </div>

    </div><!----fin del row-------->



    <br/>

</div>



</div>
</div>

<!----------------------------------------------#MODAL-------------------------------------------------->

<div class="modal fade " id="agregarEquipo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #101010; color: White" >
                <h4 class="modal-title">Agregar nuevo equipo</h4>
            </div>
            <form id="formIngresarEquipo" >
                <div class="modal-body" id="">

                    <div class="row">

                        <div class="col-md-6">
                            <!--                            <hr>-->
                            <!--                            <div class="input-group ">
                                                            <span class="input-group-addon"><i class="fa fa-barcode" aria-hidden="true" ></i></span>
                                                            <input id="txtCodigo" name="txtCodigo" type="text" class="form-control :required" placeholder="Codigo" >
                                                        </div>-->

                            <hr>

                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-laptop" aria-hidden="true"></i></span>
                                <select id="sltTipo" name="sltTipo" class="form-control :required" >
                                    <option selected disabled>Tipo</option>
                                    <?php foreach ($equiposTipo as $tipo) { ?>
                                        <option value="<?php echo $tipo->id; ?>"><?php echo $tipo->descripcion; ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <hr>

                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-barcode" aria-hidden="true"></i></span>
                                <input id="txtSerie" name="txtSerie" type="text" class="form-control :required" placeholder="Serie" >
                            </div>

                            <hr>

                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-registered" aria-hidden="true"></i></span>
                                <select id="sltMarca" name="sltMarca" class="form-control :required" >
                                    <option selected disabled>Marca</option>

                                    <?php foreach ($equiposMarca as $marca) { ?>
                                        <option value="<?php echo $marca->id; ?>"><?php echo $marca->descripcion; ?></option>

                                    <?php } ?>
                                </select>
                            </div>

                            <hr>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-barcode" aria-hidden="true"></i></span>
                                <input id="txtModelo" name="txtModelo" type="text" class="form-control :required" placeholder="Modelo" >
                            </div>



                        </div>
                        <div class="col-md-6">
                            <hr>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-barcode" aria-hidden="true"></i></span>                            
                                ​<textarea class="form-control :required" id="areaDescripcion" name="areaDescripcion" rows="4" cols="70" placeholder="Descripcion" ></textarea>
                            </div>

                            <hr>

                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-laptop" aria-hidden="true"></i></span>
                                <select id="sltOrigen" name="sltOrigen" class="form-control :required" >
                                    <option selected disabled>Origen</option>
                                    <option value="1">Propio</option>
                                    <option value="2">Arrendado</option>

                                </select>
                            </div>
                            <hr>


                        </div>
                        </form>   

                    </div><!--fin class row--->




                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" value="Guardar">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!----------------------------------------------#MODAL MODIFICAR---------------------------------------------->

<div class="modal fade " id="editarEquipo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #101010; color: White" >
                <h4 class="modal-title">Editar equipo</h4>
            </div>
            <form id="formEditarEquipo" >
                <div class="modal-body" id="">

                    <div class="row">

                        <div class="col-md-6">
                            <!--<hr>-->
                            <!--                            <div class="input-group ">
                                                            <span class="input-group-addon"><i class="fa fa-barcode" aria-hidden="true" ></i></span>
                                                            <input id="txtCodigoE" name="txtCodigoE" type="text" class="form-control :required" placeholder="Codigo" >
                                                            
                                                        </div>-->

                            <hr>

                            <div class="input-group">
                                <input id="hiddenId" name="hiddenId" type="hidden" >
                                <span class="input-group-addon"><i class="fa fa-laptop" aria-hidden="true"></i></span>
                                <select id="sltTipoE" name="sltTipoE" class="form-control :required" >
                                    <option selected  id="edTipoOldId"></option>
                                    <?php foreach ($equiposTipo as $tipo) { ?>
                                        <option value="<?php echo $tipo->id; ?>"><?php echo $tipo->descripcion; ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <hr>

                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-barcode" aria-hidden="true"></i></span>
                                <input id="txtSerieE" name="txtSerieE" type="text" class="form-control :required" placeholder="Serie" >
                            </div>

                            <hr>

                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-registered" aria-hidden="true"></i></span>
                                <select id="sltMarcaE" name="sltMarcaE" class="form-control :required" >
                                    <option selected  id="edMarcaOldId"></option>

                                    <?php foreach ($equiposMarca as $marca) { ?>
                                        <option value="<?php echo $marca->id; ?>"><?php echo $marca->descripcion; ?></option>

                                    <?php } ?>
                                </select>
                            </div>

                            <hr>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-barcode" aria-hidden="true"></i></span>
                                <input id="txtModeloE" name="txtModeloE" type="text" class="form-control :required" placeholder="Modelo" >
                            </div>



                        </div>
                        <div class="col-md-6">
                            <hr>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-barcode" aria-hidden="true"></i></span>                            
                                ​<textarea class="form-control :required" id="areaDescripcionE" name="areaDescripcionE" rows="4" cols="70" placeholder="Descripcion" ></textarea>
                            </div>

                            <hr>

                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-laptop" aria-hidden="true"></i></span>
                                <select id="sltOrigenE" name="sltOrigenE" class="form-control :required" >
                                    <option selected  value="1">Propio</option>
                                    <option value="1">Propio</option>
                                    <option value="2">Arrendado</option>

                                </select>
                            </div>
                            <hr>


                        </div>
                        </form>   

                    </div><!--fin class row--->




                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" value="Guardar">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<!----------------------------------------------#MODAL MODIFICAR---------------------------------------------->

<div class="modal fade " id="bajarEquipo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #101010; color: White" >
                <h4 class="modal-title">Dar de baja un equipo</h4>
            </div>
            <form id="formBajarEquipo" >
                <div class="modal-body" id="">




                    <hr>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-barcode" aria-hidden="true"></i></span>                            
                        ​<textarea class="form-control :required" id="areaDescripcionB" name="areaDescripcionB" rows="4" cols="70" placeholder="Motivos de la baja" ></textarea>
                        <input id="hiddenIdBaja" name="hiddenIdBaja" type="hidden" >
                    </div>

                    <hr>




                </div><!--fin class row--->




                <div class="modal-footer">
                    <input type="submit" class="btn btn-danger" value="Guardar">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

                </div>

            </form>   

        </div>
        </form>
    </div>
</div>

<!---------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------->
<!--------------------------------inicio del javaScript----------------------------------------------->
<!--------------------------------inicio del javaScript----------------------------------------------->
<!---------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------->



<script src="<?= base_url(); ?>/vendors/js/jquery-3.1.1.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>/vendors/bootstrap-3.3.7/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>/vendors/vanadium/vanadium.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>/vendors/jquery.rut/jquery.rut.min.js" type="text/javascript"></script>
<!-- datepicker -->
<script src="<?= base_url(); ?>/vendors/datepicker/bootstrap-datepicker.js"></script>


<script>
    $('.fecha').datepicker({
        autoclose: true
    });
    $(document).ready(function () {


        //:-------------------------------------------------------------------------
        //: cargar modal de editar equipo
        //:-------------------------------------------------------------------------

        $('body').on('click', '#btnBajar', function () {

            var dataId = $('#btnBajar').attr('data-id');
            $('#hiddenIdBaja').val(dataId);
        });

        //:-------------------------------------------------------------------------
        //: dar de baja un equipo
        //:-------------------------------------------------------------------------

        $('#formBajarEquipo').submit(function () {

            var dataForm = $(this).serialize();
            // alert(dataForm);


            $.ajax({
                data: dataForm,
                url: 'bajarEquipo',
                type: 'post',
                cache: false,
                beforeSend: function () {

                },
                success: function (response) {
                    //  alert(response);
                    if (response == 0) {
                        alert('Problemas al bajar equipo');
                    }
                    if (response == 1) {
                        alert('¡EQUIPO DADO DE BAJA CON EXITO!');
                       window.location.reload();
                    }

                },
                error: function (e) {
                    alert('ERROR AJAX: ' + e);
                }
            });
        });

        //:-------------------------------------------------------------------------
        //: cargar modal de editar equipo
        //:-------------------------------------------------------------------------
        $('body').on('click', '#btnEditar', function () {


            var dataId = $('#btnEditar').attr('data-id');
            var data = "equipoId=" + dataId;

            $.ajax({
                data: data,
                url: 'equipoPorId',
                type: 'post',
                cache: false,
                beforeSend: function () {
               //     $('#valores').html('Cargando datos ....');
                },
                success: function (response) {
                    var dataEquipo = eval(response);

                    var codigo = "";
                    var marca = "";
                    var tipo = "";
                    var estado = "";
                    var ingreso = "";
                    var baja = "";
                    var modelo = "";
                    var serie = "";
                    var origen = "";
                    var descripcion = "";
                    var obsbaja = "";
                    var id = "";
                    var id_marca = "";
                    var id_tipo = "";

                    for (var i = 0; i < dataEquipo.length; i++) {

                        codigo = dataEquipo[0]['codigo'];
                        marca = dataEquipo[0]['marca'];
                        id_marca = dataEquipo[0]['id_marca'];
                        tipo = dataEquipo[0]['tipo'];
                        id_tipo = dataEquipo[0]['id_tipo'];
                        estado = dataEquipo[0]['estado'];
                        ingreso = dataEquipo[0]['fecha_ingreso'];
                        baja = dataEquipo[0]['fecha_baja'];
                        modelo = dataEquipo[0]['modelo'];

                        serie = dataEquipo[0]['serie'];
                        origen = dataEquipo[0]['propio'];
                        descripcion = dataEquipo[0]['descripcion'];
                        obsbaja = dataEquipo[0]['observacion_baja'];
                        id = dataEquipo[0]['id'];

                    }
                    $('#hiddenId').val(id);
                    $('#txtCodigoE').val(codigo);
                    $('#txtSerieE').val(serie);
                    $('#areaDescripcionE').val(descripcion);
                    $('#txtModeloE').val(modelo);
                    $('#edTipoOldId').val(id_tipo);
                    $('#edTipoOldId').html(tipo);
                    $('#edMarcaOldId').val(id_marca);
                    $('#edMarcaOldId').html(marca);






                },
                error: function (e) {
                    alert('ERROR AJAX: ' + e);
                }
            });


        });

        //:-------------------------------------------------------------------------
        //: modificar equipo
        //:-------------------------------------------------------------------------

        $('#formEditarEquipo').submit(function () {

            var dataForm = $(this).serialize();
            // alert(dataForm);


            $.ajax({
                data: dataForm,
                url: 'editarEquipo',
                type: 'post',
                cache: false,
                beforeSend: function () {

                },
                success: function (response) {
                    //  alert(response);
                    if (response == 0) {
                        alert('Problemas editar el equipo');
                    }
                    if (response == 1) {
                        alert('¡EQUIPO EDITADO CON EXITO!');
window.location.reload();
                    }

                },
                error: function (e) {
                    alert('ERROR AJAX: ' + e);
                }
            });


        });

        //:-------------------------------------------------------------------------
        //: crear nuevo equipo
        //:-------------------------------------------------------------------------

        $('#formIngresarEquipo').submit(function () {

            var dataForm = $(this).serialize();
            //alert(dataForm);

            $.ajax({
                data: dataForm,
                url: 'creaEquipo',
                type: 'post',
                cache: false,
                beforeSend: function () {

                },
                success: function (response) {
                    alert(response);
                    //window.location.reload();
                    
//                    if (response == 0) {
//                        alert('Problemas al ingresar el equipo');
//                    }
//                    if (response == 1) {
//                        alert('¡EQUIPO CREADO CON EXITO!');
//
//                    }
//                    if (response == 2) {
//                        alert('¡CODIGO A CREAR YA EXISTE');
//                    }

                },
                error: function (e) {
                    alert('ERROR AJAX: ' + e);
                }
            });


        });
        //:-------------------------------------------------------------------------
        //: ver ficha de equipo
        //:-------------------------------------------------------------------------

        $('.btnFicha').click(function () {


            var dataId = $(this).attr('data-id');
            var data = "equipoId=" + dataId;

            $.ajax({
                data: data,
                url: 'equipoPorId',
                type: 'post',
                cache: false,
                beforeSend: function () {
                    $('#valores').html('Cargando datos ....');
                },
                success: function (response) {

                    var dataEquipo = eval(response);
                    var html = "";
                    //  html+="";

                    var codigo = "";
                    var marca = "";
                    var tipo = "";
                    var estado = "";
                    var ingreso = "";
                    var baja = "";
                    var modelo = "";
                    var serie = "";
                    var origen = "";
                    var descripcion = "";
                    var obsbaja = "";
                    var id = "";


                    for (var i = 0; i < dataEquipo.length; i++) {

                        codigo = dataEquipo[0]['codigo'];
                        marca = dataEquipo[0]['marca'];
                        tipo = dataEquipo[0]['tipo'];
                        estado = dataEquipo[0]['estado'];
                        ingreso = dataEquipo[0]['fecha_ingreso'];
                        baja = dataEquipo[0]['fecha_baja'];
                        modelo = dataEquipo[0]['modelo'];
                        serie = dataEquipo[0]['serie'];
                        origen = dataEquipo[0]['propio'];
                        descripcion = dataEquipo[0]['descripcion'];
                        obsbaja = dataEquipo[0]['observacion_baja'];
                        id = dataEquipo[0]['id'];

                    }



                    html += '<div class="btn-group pull-right">';
                    html += '<button type="button" data-id="' + id + '" id="btnEditar" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editarEquipo"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
                    html += '<button type="button" data-id="' + id + '" id="btnBajar" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#bajarEquipo"><i class="fa fa-trash-o" aria-hidden="true"></i></button>';

                    html += '</div>';

                    html += '<table class="table">';

                    html += '<tr>';
                    html += '<th>Codigo</th>';
                    html += '<td>' + codigo + '</td>';
                    html += '</tr>';

                    html += '<tr>';
                    html += '<th>Serie</th>';
                    html += '<td>' + serie + '</td>';
                    html += '</tr>';

                    html += '<tr>';
                    html += '<th>Marca</th>';
                    html += '<td>' + marca + '</td>';
                    html += '</tr>';

                    html += '<tr>';
                    html += '<th>Tipo</th>';
                    html += '<td>' + tipo + '</td>';
                    html += '</tr>';

                    html += '<tr>';
                    html += '<th>Modelo</th>';
                    html += '<td>' + modelo + '</td>';
                    html += '</tr>';

                    html += '<tr>';
                    html += '<th>Estado</th>';
                    html += '<td>' + estado + '</td>';
                    html += '</tr>';

                    html += '<tr>';
                    html += '<th>Fecha ingreso</th>';
                    html += '<td>' + ingreso + '</td>';
                    html += '</tr>';

                    html += '<tr>';
                    html += '<th>Fecha Baja</th>';
                    html += '<td>' + baja + '</td>';
                    html += '</tr>';

                    html += '<tr>';
                    html += '<th>Origen</th>';
                    html += '<td>' + origen + '</td>';
                    html += '</tr>';

                    html += '<tr>';
                    html += '<th>Descripcion</th>';
                    html += '<td>' + descripcion + '</td>';
                    html += '</tr>';

                    html += '<tr>';
                    html += '<th>Observacion de baja</th>';
                    html += '<td>' + obsbaja + '</td>';
                    html += '</tr>';

                    html += '</table>';





                    $('#tablaMuestraFicha').html(html);

                },
                error: function (e) {

                    alert('ERROR AJAX: ' + e);

                }
            });


        });


    });
</script>

</body>
</html>
