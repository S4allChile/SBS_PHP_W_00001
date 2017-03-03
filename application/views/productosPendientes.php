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
                    </div>
                    
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>CODIGO</th>
                                <th>DESCRIPCION</th>
                                <th>PENDIENTE</th>
                                <th>STK SBS</th>
                                <th>STK SVL</th>
                                <th>TRANSITO</th>
                                <th>NºOC</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($productosPendientes AS $producto){
                            
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
                                <td><?= $producto->CODIGO;  ?></td>
                                <td><?= utf8_encode($producto->Descripcion); ?></td>
                                <td><?= $producto->PENDIENTE; ?></td>
                                <td><?= (empty($stock->Stock))?'<span class="label label-danger">Sin info</span>':$stock->Stock ; ?></td>
                                <td><?= intval($svl); ?></td>
                                
                                <?php
                                $ocs = $ci->gerencia_DAO->ocPendientes($producto->CODIGO);
                                $totCant = 0;
                                $numOC = "";
                                foreach ($ocs AS $oc){
                                    $totCant += $oc->Cantidad;
                                    $numOc = $oc->Numero_Orden_Compra;
                                 }   
                                ?>
                                
                                <td><?= $totCant; ?> </td>
                                <td><?= $numOc; ?></td>
                               
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
        
        <script>
            
        </script>
        
    </body>
</html>
