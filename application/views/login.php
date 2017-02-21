<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link href="<?= base_url(); ?>/vendors/bootstrap-3.3.7/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?= base_url(); ?>/vendors/css/login.css" rel="stylesheet" type="text/css"/>
        <link href="<?= base_url(); ?>/vendors/vanadium/vanadium.css" rel="stylesheet" type="text/css"/>
        <link href="<?= base_url(); ?>/vendors/css/propio.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="modal_ajax">CARGANDO....</div>
        <div class="modal-dialog">
                <div class="loginmodal-container">
                    <h1>Sistemas informatica SBS</h1><br>
                    <form id="login" method="post">
                        <input type="text" class=":required :email" name="user" placeholder="Email">
                        <input type="password" class=":required" name="pass" placeholder="Contraseña">
                        <input type="submit" name="login" class="login loginmodal-submit" value="Ingresar">
                    </form>
                </div>
        </div>		
        
        
        <script src="<?= base_url(); ?>/vendors/js/jquery-3.1.1.min.js" type="text/javascript"></script>
        <script src="<?= base_url(); ?>/vendors/bootstrap-3.3.7/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?= base_url(); ?>/vendors/vanadium/vanadium.js" type="text/javascript"></script>
        <script>
             $(window).load(function () {
                // Una vez se cargue al completo la página desaparecerá el div "cargando"
                $('body').removeClass('loading');
              });
        </script>
        <script>
            $(document).ready(function(){
                $('#login').submit(function(e){
                    e.preventDefault();
                    var parametros = $('#login').serialize();
                 

                    $.ajax({
                        data:  parametros,
                        url:   'index.php/login/validaUserPass',
                        type:  'post',
                        beforeSend: function () {
                                $('body').addClass('loading');                    
                            },
                        success:  function (response) {
                                $('body').removeClass('loading');
                                
                                switch(response){
                                    
                                    case '0':
                                        alert('Usuario o pass incorrecto');
                                        break;
                                    
                                    case '1':
                                        window.location.replace('index.php/aplicacion/escritorio');
                                        break;
                                }
                        },
                        error: function(e){
                            $('body').removeClass('loading');
                            alert('ERROR AJAX: '+e);

                        }
                    });

                    
                });
            });
        </script>
    </body>
</html>
