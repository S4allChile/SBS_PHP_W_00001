        
<div class="page-header">
  <h3>Revision de Pedidos</h3>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-2">
            <form id="numPedido" action="#" method="post">
                <div class="form-group">
                    <input type="text" class="form-control :required" name="valor" id="codigo" placeholder="Pedido-Año" />
                </div>
              
                <button type="submit" class="btn btn-block btn-primary" id="cargaStockWeb">Numero Pedido</button>
            </form>
        </div>
        <div class="col-md-2">
            <form id="numWeb" action="#" method="post">
                <div class="form-group">
                    <input type="text" class="form-control :required" name="valor" id="codigo" placeholder="Nª Web" />
                </div>
              
                <button type="submit" class="btn btn-block btn-primary" id="cargaStockWeb">Numero Web</button>
            </form>
        </div>
        <div class="col-md-2">
            <form id="pedidoRut" action="#" method="post">
                <div class="form-group" id="valRut">
                    <input type="text" class="form-control :required" name="rut" id="rut" placeholder="Rut" />
                    <span id="msjRut"></span>
                </div>
              
                <button type="submit" class="btn btn-block btn-primary" id="cargaStockWeb">Rut Cliente</button>
            </form>
        </div>
        <div class="col-md-2">
            <form id="cargaStockCodigo" action="#" method="post">
                <div class="form-group">
                    <input type="text" class="form-control :required" name="codigo" id="codigo" placeholder="email" />
                </div>
              
                <button type="submit" class="btn btn-block btn-primary" id="cargaStockWeb">Email Cliente</button>
            </form>
        </div>
        <div class="col-md-2">
            <form id="cargaStockCodigo" action="#" method="post">
                <div class="form-group">
                    <input type="text" class="form-control :required" name="codigo" id="codigo" placeholder="Fecha" />
                </div>
              
                <button type="submit" class="btn btn-block btn-primary" id="cargaStockWeb">Fecha Venta</button>
            </form>
        </div>
        <div class="col-md-2">
            <form id="cargaStockCodigo" action="#" method="post">
                <div class="form-group">
                    <input type="text" class="form-control :required" name="codigo" id="codigo" placeholder="4 ultimos " />
                </div>
              
                <button type="submit" class="btn btn-block btn-primary" id="cargaStockWeb">Numero Tarjeta</button>
            </form>
        </div>
    </div>
    <br/>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                  <h3 class="panel-title">Resultado de la consulta</h3>
                </div>
                <div class="panel-body">
                    <div id="resultados"></div>
                </div>
              </div>
        </div>
    </div>
</div>

                
                
        </div>
        </div>
        
        
        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Documentos Pedido</h4>
              </div>
                <div class="modal-body" id="valores">
                
                </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
               
              </div>
            </div>
          </div>
        </div>
        
        
        
        
        
        <script src="<?= base_url(); ?>/vendors/js/jquery-3.1.1.min.js" type="text/javascript"></script>
        <script src="<?= base_url(); ?>/vendors/bootstrap-3.3.7/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?= base_url(); ?>/vendors/vanadium/vanadium.js" type="text/javascript"></script>
        <script src="<?= base_url(); ?>vendors/jquery.rut/jquery.rut.min.js" type="text/javascript"></script>
        
        <script>
            $(document).ready(function(){
                $("input#rut").rut({
                    formatOn: 'keyup',
                    minimumLength: 8, // validar largo mínimo; default: 2
                    validateOn: 'change' // si no se quiere validar, pasar null
                });
                
                $("input#rut").rut().on('rutInvalido', function(e) {
                    $('#valRut').addClass('has-error');
                    $(this).val("");
                    $(this).focus();
                    $("#pedidoRut").submit(function() {
                        return false;
                    });

                });

                
                $('#numPedido').submit(function(e){
                    e.preventDefault();
                    var dato = $(this).serialize();

                    $.ajax({
                        data:  dato,
                        url:   'buscaXnp',
                        type:  'post',
                        cache: false,
                        beforeSend: function () {
                                $('#resultados').html('Cargando datos...');                    
                            },
                        success:  function (response) {
                               
                                $('#resultados').html(response);
                                
                        },
                        error: function(e){
                            
                            alert('ERROR AJAX: '+e);

                        }
                    });
                    
                    
                    
                });
                
                $('#numWeb').submit(function(e){
                    e.preventDefault();
                    var dato = $(this).serialize();

                    $.ajax({
                        data:  dato,
                        url:   'buscaXnw',
                        type:  'post',
                        cache: false,
                        beforeSend: function () {
                                $('#resultados').html('Cargando datos...');                    
                            },
                        success:  function (response) {
                               
                                $('#resultados').html(response);
                                
                        },
                        error: function(e){
                            
                            alert('ERROR AJAX: '+e);

                        }
                    });
                    
                    
                    
                });
                
                
                $('.panel').on('click','.docs',function(){
                    
                    var pedido = $(this).attr('data-pedido');
                    
                    $.ajax({
                        data:  'ped='+pedido,
                        url:   'buscaDocumentos',
                        type:  'post',
                        cache: false,
                        beforeSend: function () {
                                $('#valores').html('Cargando datos ....');                    
                            },
                        success:  function (response) {
                               
                                $('#valores').html(response);
                                
                        },
                        error: function(e){
                            
                            alert('ERROR AJAX: '+e);

                        }
                    });
                    
                    $('#myModal').modal('show');
                });

                
                
                
                
            });
        </script>
        
    </body>
</html>
