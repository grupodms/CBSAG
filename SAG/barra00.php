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


<style type="text/css">
.aa1 {
	font-weight: bold;
	font-size:24px;
	background-color:#008f85
}
.aa2 {
	font-size:14px
}
</style>
<table width="100%" border="0">
  <tr>
    <td width="20%" align="center" >
    <img src="../img/logo_CB_2.png" 
         width="50" height="50" />
    </td>
    <td width="60%">
<h4 ><center> COLEGIO DE BACHILLERES </span><br />
<span class="aa2">
Sistema Integral de Inventarios de Activo Fijo 
</span>
</center> </font><br />
</h4>    
    
    </td>
    <td width="20%" align="center" >
    <img src="../img/logo_CB_2.png" 
         width="50" height="50" />
    </td>
  </tr>
</table>


<nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" 
      class="navbar-toggle" 
      data-toggle="collapse" 
      data-target="#bs-example-navbar-collapse-1">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?PHP echo $com;?><?PHP echo $_COOKIE ["id_menu"]; ?>">
      <span class="glyphicon glyphicon-home"></span>
                Inicio</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" 
         id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">

<!-- Movimientos Inicio-->         
     <li class="dropdown">
     <a href="#" 
        class="dropdown-toggle" 
        data-toggle="dropdown">
        <span class="glyphicon glyphicon-duplicate"></span>
        Movimientos<b class="caret"></b>
     </a>
     <ul class="dropdown-menu">
         <li><a href="<?PHP echo $com;?>01_Consecutivos/index2.php">Consecutivos/Resguardos</a></li>
         
         
	     <li><a href="<?PHP echo $com;?>01_vales_entrada/index.php">Vales de Entrada</a></li>
         <li><a href="<?PHP echo $com;?>01_vales_salida/index.php">Vales de Salida</a></li>
         <li><a href="<?PHP echo $com;?>01_Empleados/index.php">Empleados</a></li>
     	 <li><a href="<?PHP echo $com;?>01_Determinantes/index.php">Determinantes</a></li> 
     	 <li><a href="<?PHP echo $com;?>01_Areas/index.php">Areas</a></li>
     	 <li><a href="<?PHP echo $com;?>01_Departamentos/index.php">Consecutivos/Departamentos</a></li>
     </ul>
     </li>
<!-- Movimientos Fin-->  

<!-- Consultas Inicio-->         
         <li class="dropdown"> <a href="#" 
            class="dropdown-toggle" 
            data-toggle="dropdown"> Consultas<b class="caret"></b> </a>
           <ul class="dropdown-menu">
             <li><a href="<?PHP echo $com;?>02_Area/index.php">Activos por Areas</a></li>
             <li><a href="<?PHP echo $com;?>02_Consecutivo/index.php">Activos por Consecutivos</a></li>
             <li><a href="<?PHP echo $com;?>02_Determinante/index.php">Activos por Determinantes</a></li>
             <li class="divider"></li>
             <li><a href="<?PHP echo $com;?>02_Resguardos/index.php">Resguardos por Número de Resguardo </a></li>
             <li><a href="<?PHP echo $com;?>02_Resguardos/index2.php">Resguardos por Area </a></li>
             <li><a href="<?PHP echo $com;?>02_Resguardos/index3.php">Resguardos por Consecutivo </a></li>
              <li class="divider"></li>
     		  <li><a href="<?PHP echo $com;?>02_estado/index_estado_c.php">Resguardos por Estado C </a></li>              
           </ul>
        </li>
<!-- Consultas Fin-->

<!-- Reportes Inicio-->         
<li class="dropdown">
<a href="#" 
   class="dropdown-toggle" 
   data-toggle="dropdown">
   Reportes<b class="caret"></b>
</a>
<ul class="dropdown-menu">
  <li><a href="<?PHP echo $com;?>03_Resguardo_activo/index.php">Resguardo de Activo Fijo</a></li>
  <li><a href="<?PHP echo $com;?>03_Concentrado_bienes/index.php">Concentrado de Bienes</a></li>
  <li> <a href="<?PHP echo $com;?>03_Concentrado_areas/index.php">Concentrado de Areas / Edificios</a></li>
  <li><a href="<?PHP echo $com;?>03_Cedula_resumen/index.php">Cedula Resumen</a></li>
  <li class="divider"></li>
  <li><a href="<?PHP echo $com;?>03_Existencia_determinante/index.php">Existencia de Determinante en Gral</a></li>
  <li><a href="#">Existencia de Determinante x Area</a></li>
  <li><a href="#">Existencia de un solo Determinante</a></li>
  <li><a href="#">Existencia x Fecha de Adquisicion</a></li>
  <li><a href="#">Existencia de Det en Gral (Texto)</a></li>
  <li><a href="#">Impresion de Etiquetas (General)</a></li>
  <li><a href="#">Estado Fisico de Bienes</a></li>
  <li></li>
</ul>
</li>
<!-- Reportes Fin-->

<!-- Utilerias Inicio-->         
<li class="dropdown">
<a href="#" 
   class="dropdown-toggle" 
   data-toggle="dropdown">
   Utilerias<b class="caret"></b>
</a>
<ul class="dropdown-menu">
<li><a href="#">Reindexado</a></li>
<li><a href="#">Activar otro Periodo</a></li>
<li class="divider"></li>
<li><a href="#">Copia Inventario Anterior</a></li>
<li><a href="#">Copiar Datos</a></li>
<li><a href="#">Respaldo de Datos</a></li>
<li><a href="#">Recupera Respaldo</a></li>
<li><a href="#">Pega Datos</a></li>
<li class="divider"></li>
<li><a href="<?PHP echo $com;?>01_usuarios/index.php" >Usuarios</a></li>
<li><a href="#">Password</a></li>
<li><a href="#">Tipo de Impresora</a></li>
<li><a href="#">Purga de Datos</a></li>
<li><a href="#">Acerca de</a></li>
<li><a href="#">Cambio de Base</a></li>
</ul>
</li>
<!-- Utilerias Fin-->

<!-- Activo Fijo Inicio-->         
<li class="dropdown">
<a href="#" 
   class="dropdown-toggle" 
   data-toggle="dropdown">
   Activo Fijo<b class="caret"></b>
</a>
<ul class="dropdown-menu">
<li><a href="<?PHP echo $com;?>01_Consecutivos/index.php">Consecutivos</a></li>
<li><a href="<?PHP echo $com;?>01_Areas/index.php">Areas Responsables</a></li>
<li><a href="#">Edificios</a></li>
<li><a href="#">Departamentos</a></li>
<li><a href="<?PHP echo $com;?>01_Determinantes/index2.php">Determinantes</a></li>
<li><a href="<?PHP echo $com;?>01_Determinantes/index3.php">Determinantes Detalle</a></li> 
<li><a href="<?PHP echo $com;?>01_Determinantes_tipo/index.php">Tipos de Determiantes</a></li>
<li><a href="<?PHP echo $com;?>01_Empleados/index.php">Empleados</a></li>
<li class="divider"></li>
<li><a href="<?PHP echo $com;?>01_Almacenes/index.php">Almacenes </a></li> 
<li><a href="<?PHP echo $com;?>03_Cedula_resumen/dependencias.php">Cedula Resumen Dependencias</a></li>
<li><a href="<?PHP echo $com;?>03_Cedula_resumen/index2.php">Cedula Resumen</a></li>
<li><a href="<?PHP echo $com;?>03_Cedula_resumen/index4.php">Cedula Resumen Desglose</a></li>
</ul>
</li>
<!-- Activo Fijo Fin-->



<!-- Salir Inicio-->
<li class="dropdown">
     <a href="<?PHP echo $com;?>salir_confirma.php" 
        class="">
        Salir<b class="caret"></b>
     </a>
<ul class="nav navbar-nav navbar-right">     
     <a href="<?PHP echo $com;?>salir_confirma.php" 
        class="">
        Salir<b class="caret"></b>
     </a>
    
</ul>    </li>  
<!-- Salir Fin-->  




    
 

        </li>
      </ul>
    </div><!-- /.navbar-collapse -->


  </div><!-- /.container-fluid -->
</nav>




<!--Menu -->
