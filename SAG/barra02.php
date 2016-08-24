<!--Menu -->

<?PHP 
if (isset($menu))
   {
	if ($menu==0) 
		{$com = '';}
	else
		{$com = '../';}
	#echo "Menu = ".$com;
   }
   else
   {
	 $com = '';
   }
?>

<nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?PHP echo $com;?>menu.php">
                2) Menu Principal</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
 
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Reportes <b class="caret"></b></a>
          <ul class="dropdown-menu">
   <li><a href="#">Repote 1</a></li>
          </ul>
        </li>
        
        
    <li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Socios <b class="caret"></b></a>
    <ul class="dropdown-menu">
     <li><a href="<?PHP echo $com;?>ASEM/index2.php">Consulta Asem</a></li> 
     <li><a href="#">Canainpa</a></li>
    </ul>
    </li> 
    

    <li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Revistas <b class="caret"></b></a>
    <ul class="dropdown-menu">
     <li><a href="#">Revistas</a></li>  
     <li><a href="#">Suscriptores</a></li>
    </ul>
    </li> 


   
    
    </ul>






      <ul class="nav navbar-nav">
        
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Cátalogos <b class="caret"></b></a>
          <ul class="dropdown-menu">
   <li><a href="#">Productos</a></li>
   
   <li class="divider"></li>
   <li><a href="#">Clientes</a></li>
   
   
   <li class="divider"></li>
   <li><a href="#">Proveedores</a></li>
   

   
          </ul>
        </li>
      </ul>

<!-- inicia: Menu Configuración -->
      <ul class="nav navbar-nav">        
      <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Configuración <b class="caret"></b></a>
          <ul class="dropdown-menu">
   <li><a href="#">Tipos de Entrada</a></li>
   <li><a href="#">Tipos de Salida</a></li>
   

          </ul>
      
      </li>
      </ul>
<!-- Fin: Menu Configuración -->



        </li>
      </ul>
    </div><!-- /.navbar-collapse -->


  </div><!-- /.container-fluid -->
</nav>


<!--Menu -->
