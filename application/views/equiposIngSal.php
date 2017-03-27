        
<div class="page-header">
    <h3>SALIDAS E INGRESO DE EQUIPOS</h3>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Salida de equipos</h3>
                </div>
                <div class="panel-body">



                    <form id="formSalidaEquipo" method="post">
                        <div class="row">
                            <div class="col-md-4">

                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                                    <select id="sltUsuario" name="sltUsuario" class="form-control :required" >
                                        <option selected disabled>Usuario</option>
                                        <?php foreach ($usuarios as $us) { ?>
                                            <option value="<?php echo $us->id_usr; ?>"><?php echo $us->nombre_usr; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>


                            </div>
                            
                            
                            <div class="col-md-4">
                            
                            
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-barcode" aria-hidden="true"></i></span>
                                <input id="txtCodidoSale" name="txtCodidoSale" type="text" class="form-control :required" placeholder="Codigo que sale" >
                            </div>
                            
                            </div>
                            
                            
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-sign-out" aria-hidden="true"></i></span>
                                    <select id="sltSalida" name="sltSalida" class="form-control :required" >
                                        <option selected disabled>Tipo de salida</option>
                                        <?php foreach ($tipoSalida as $salida) { ?>
                                            <option value="<?php echo $salida->id; ?>"><?php echo $salida->descripcion; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                            </div>
                        </div>

                          <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <input  type="submit" class="btn btn-primary btn-xs col-md-12" id="" value="REGISTRAR SALIDA" >
                                <!--<button type="button" id="btnSaleEquipo" class="btn btn-primary btn-xs col-md-12">REGISTRAR SALIDA</button>-->
                            </div>

                        </div>
                    </form>



                </div>
            </div>
        </div>

    </div>
    <br/>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Entrada de equipos</h3>
                </div>
                <div class="panel-body">

                    <form id="formEntradaEquipo" method="post">
                        <div class="row">
                            <div class="col-md-4">
                            </div>                            
                            <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-barcode" aria-hidden="true"></i></span>
                                <input id="txtCodigoEntrada" name="txtCodigoEntrada" type="text" class="form-control :required" placeholder="Codigo que entra" >
                            </div>                            
                            </div>
                            <div class="col-md-4">
                            </div>
                        </div>
                          <hr>
                        <div class="row">
                            <div class="col-md-12">
                               <input  type="submit" class="btn btn-primary btn-xs col-md-12" id="" value="REGISTRAR ENTRADA" >

                            </div>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>




<script src="<?= base_url(); ?>vendors/jQuery/jquery-2.2.3.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>vendors/bootstrap-3.3.7/js/bootstrap.min.js" type="text/javascript"></script>
<!--<script src="<?= base_url(); ?>vendors/vanadium/vanadium.js" type="text/javascript"></script>-->
<!--<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>-->


<script>
    $(document).ready(function () {
        
      $('#formSalidaEquipo').submit(function(){
          
          
          var dataForm = $(this).serialize();
          alert(dataForm);
      
           $.ajax({
                data: dataForm,
                url: '<?= base_url(); ?>index.php/ControlDePrueba/pruebaControlPrueba',
                type: 'post',
                cache: false,
                beforeSend: function () {
                  alert('antes');
                },
                success: function (response) {                  
                   alert(response);       
                },
                error: function (e) {
                    alert('ERROR AJAX: ' + e);
                     
                }
            });
          
      });
      
      
       $('#formEntradaEquipo').submit(function(){
          
          
          var dataForm = $(this).serialize();
          alert(dataForm);
      
           $.ajax({
                data: dataForm,
                url: 'registrarEntrada',
                type: 'post',
                cache: false,
                beforeSend: function () {
                alert('antes');

                },
                success: function (response) {
                  
             alert(response);
       
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
