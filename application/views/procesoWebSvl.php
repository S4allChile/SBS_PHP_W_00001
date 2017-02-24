   
<div class="page-header">
  <h3>Procesos WEB SBS</h3>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <a class="btn btn-block btn-primary" id="procWebSvl" href="http://136.243.24.88/ww2_sbs_cl/SBS/procesos_web.php" target="_blank" >Ejecutar proceso WEB</a>
        </div>
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                  <h3 class="panel-title">Resultado del Proceso</h3>
                </div>
                <div class="panel-body">
                    <div id="ResultProcesoStock"></div>
                </div>
              </div>

        </div>
    </div>
    <hr/>
    <div class="row">
        <div class="col-md-3">
            <button class="btn btn-block btn-primary" id="cargaStockWeb">Carga Stock Web</button>
        </div>
        <div class="col-md-9">
            
            <div class="panel panel-default">
                <div class="panel-heading">
                  <h3 class="panel-title">Resultado del Proceso</h3>
                </div>
                <div class="panel-body">
                    <div id="ResultCargaWeb"></div>
                </div>
              </div>

        </div>
    </div>
    
    <div class="row">
        <div class="col-md-3">
            <form id="cargaStockCodigo" action="#" method="post">
                <button type="submit" class="btn btn-block btn-primary" id="cargaStockWeb">Carga Stock 1 producto</button>
                <br/>
                <div class="form-group">
                    <input type="text" class="form-control :required" name="codigo" id="codigo" placeholder="Codigo" />
                </div>
            </form>
           
           
        </div>
        <div class="col-md-9">
            
            <div class="panel panel-default">
                <div class="panel-heading">
                  <h3 class="panel-title">Resultado del Proceso</h3>
                </div>
                <div class="panel-body">
                    <div id="ResultCargaCodigo"></div>
                </div>
              </div>

        </div>
    </div>
    
    
</div>

                
                
        </div>
        </div>
        
        
        
        <script src="<?= base_url(); ?>/vendors/js/jquery-3.1.1.min.js" type="text/javascript"></script>
        <script src="<?= base_url(); ?>/vendors/bootstrap-3.3.7/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?= base_url(); ?>/vendors/vanadium/vanadium.js" type="text/javascript"></script>
        
        <script>
            $(document).ready(function(){
                
                $('#cargaStockWeb').click(function(){
                   $.ajax({
                        data:  0,
                        url:   'cargaStockWeb',
                        type:  'post',
                        cache: false,
                        beforeSend: function () {
                                $('#ResultCargaWeb').html('Cargando datos...');                    
                            },
                        success:  function (response) {
                               
                                $('#ResultCargaWeb').html(response);
                                
                        },
                        error: function(e){
                            
                            alert('ERROR AJAX: '+e);

                        }
                    }); 
                });
                
                
                $('#cargaStockCodigo').submit(function(e){
                    e.preventDefault();
                    var codigo = $(this).serialize();
                    alert(codigo);
                    
                    $.ajax({
                        data:  codigo,
                        url:   'stockCodigo',
                        type:  'post',
                        cache: false,
                        beforeSend: function () {
                                $('#ResultCargaCodigo').html('Cargando datos...');                    
                            },
                        success:  function (response) {
                               
                                $('#ResultCargaCodigo').html(response);
                                
                        },
                        error: function(e){
                            
                            alert('ERROR AJAX: '+e);

                        }
                    });
                    
                    
                    
                });
                
                
            });
        </script>
        
    </body>
</html>
