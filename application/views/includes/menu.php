
<div class="container">
    <div class="col-md-12">

    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">SBS Informatica</a>
          </div>

          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">

              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Ventas <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="revisaPedido">Revisar pedidos</a></li>
                  <li><a href="#">Revisar Venta Web</a></li>
                  <li role="separator" class="divider"></li>
                  <li><a href="#">Clientes ERP</a></li>
                  <li><a href="#">Clientes WEB</a></li>
                  <li role="separator" class="divider"></li>
                  <!--<li><a href="#">One more separated link</a></li>-->
                </ul>
              </li>
              
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Procesos <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="procesoWebSvl">Proceso WEB-SVL</a></li>
                  <li><a href="#">Proceso WEB-ERP</a></li>
                  <li role="separator" class="divider"></li>
                  <li><a href="#">Proceso de Stock</a></li>
                  <li role="separator" class="divider"></li>
                  <!--<li><a href="#">One more separated link</a></li>-->
                </ul>
              </li>
              
              <li>
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Equipos Computacionales <span class="caret"></span></a>
              </li>

            </ul>

              

            <ul class="nav navbar-nav navbar-right">
              <li><a href="#"></a></li>
             
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?= $this->session->nomUsr; ?> <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="login/salir">Salir</a></li>
                </ul>
              </li>
              
              
              
            </ul>
          </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
      </nav>
        
        