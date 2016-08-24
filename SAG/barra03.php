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
      <a class="navbar-brand" href="<?PHP echo $com;?>menu_0.php">
                1) Menu Principal</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
 
   
        
    <li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Catalogos <b class="caret"></b></a>
    <ul class="dropdown-menu">
	 <li><a href="<?PHP echo $com;?>01_Areas/index.php">Areas Responsables</a></li>
	 <li><a href="#">Edificios</a></li>
	 <li><a href="#">Departamentos</a></li>
     <li><a href="<?PHP echo $com;?>01_Determinantes/index.php">Determinantes</a></li> 
     <li><a href="#">Tipos de Determiantes</a></li>
    </ul>
    </li> 
    

        <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown">Reportes <b class="caret"></b></a>
          <ul class="dropdown-menu">
              <li><a href="#">Repote 1</a></li>
          </ul>
        </li>




   
    
    </ul>









        </li>
      </ul>
    </div><!-- /.navbar-collapse -->


  </div><!-- /.container-fluid -->
</nav>


<!--Menu -->
