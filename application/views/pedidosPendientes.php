<?php
$ci = &get_instance();
$ci->load->model("gerencia_DAO");
?>



<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
           
            <ol class="breadcrumb">
                <li><a href="../gerencia/index">Inicio</a></li>
                <li><a href="#">Gerencia</a></li>
                <li class="active">Productos Pendientes</li>
            </ol>
            
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="page-header">
                        <h3>Productos Pendientes <small>Lista de pedidos con productos pendientes</small></h3>
                        <button class="btn btn-success" id="exportarXls"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Descargar</button>
                    </div>
                    
                    
   
                                 
                    <table id="tblProdPendientes" class="display" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>PEDIDO</th>
                                <th>CLIENTE</th>
                                <th>CODIGO</th>
                                <th>DESCRIPCION</th>
                                <th>PROVEEDOR</th>
                                <th>PENDIENTE</th>
                                <th>STK SBS</th>
                                <th>STK SVL</th>
                                <th>TRANSITO</th>
                                <th>DIF</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                        <?php
                        foreach ($pedidosPendientes AS $producto){
                            
                            $stock = $ci->gerencia_DAO->stock(1,2017,$producto->CODIGO);
                            $svl = valida_stock_svl($producto->CODIGO);
                            if($svl == "Codigo no existe"){
                                
                                $stkSvl = 0;
                            }else{
                                $stkSvl = intval($svl);
                            }
                            
                            
                            $marca = "";        
                            if($stkSvl < $producto->PENDIENTE){
                                $marca = 'style="color: red"';
                            }        
                        ?>
                            <tr <?= $marca; ?> >
                                <td><?= $producto->N_PEDIDO;  ?></td>
                                <td><?= $producto->NOMBRE_FANTASIA;  ?></td>
                                <td><?= $producto->CODIGO;  ?></td>
                                <td><?= utf8_encode($producto->Descripcion); ?></td>
                                <td><?= $producto->PROVEEDOR;  ?></td>
                                <td><?= $producto->PENDIENTE; ?></td>
                                <td><?= (empty($stock->Stock))?'<span class="label label-danger">Sin info</span>':$stock->Stock ; ?></td>
                                <td><?= intval($svl); ?></td>
                                
                                <?php
                                $ocs = $ci->gerencia_DAO->ocPendientes($producto->CODIGO);
                                $totCant = 0;
                                $numOC = "";
                                foreach ($ocs AS $oc){
                                    $totCant += $oc->Cantidad;
                                    
                                 }  
                                 
                                 $dif = $stkSvl+$totCant-$producto->PENDIENTE;
                                ?>
                                
                                <td><?= $totCant; ?> </td>
                                <td>
                                <?= ($dif < 0)?'<span class="label label-danger">'.$dif.'</span>':'<span class="label label-default">'.$dif.'</span>'  ?>
                                </td>
                               
                            </tr>
                        <?php  } ?>    
                        </tbody>
                    </table>
                    
                </div>
              </div>
            
        </div>
    </div>
</div>

                
                
        </div>
        </div>
        
        
        
        <script src="<?= base_url(); ?>/vendors/js/jquery-3.1.1.min.js" type="text/javascript"></script>
        <script src="<?= base_url(); ?>/vendors/bootstrap-3.3.7/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?= base_url(); ?>/vendors/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="<?= base_url(); ?>/vendors/table2excel/src/jquery.table2excel.js" type="text/javascript"></script>
        <script>
            $(document).ready(function() {
                $('#tblProdPendientes').DataTable({
                    "paging":   false,
                    "info":     false,
                    "order": [[ 7, "asc" ]],
                    "language":{
                        "search": "Buscar:"
                    }
                });
                
                $("#exportarXls").click(function(){
                    $("#tblProdPendientes").table2excel({
                        exclude: ".noExl",
                        name: "Productos_pendientes"
                    });
                });
                
            });
        </script>
        
    </body>
</html>
