<?php require_once('Connections/SAG.php'); ?>
<script type="text/javascript" src="js/cokies.js"></script>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
   if ($_REQUEST <> null) 
      {
       $usuario = $_REQUEST['usuario'];
       $clave   = $_REQUEST['clave'];
      }
$colname_usuarios = "-1";
if (isset( $_COOKIE ["usuario_global"])) {
  $colname_usuarios =  $_COOKIE ["usuario_global"];
}
mysql_select_db($database_SAG, $SAG);
$query_usuarios = sprintf("SELECT * FROM usuario WHERE email = %s", GetSQLValueString($colname_usuarios, "text"));
$usuarios = mysql_query($query_usuarios, $SAG) or die(mysql_error());
$row_usuarios = mysql_fetch_assoc($usuarios);
$totalRows_usuarios = mysql_num_rows($usuarios);

mysql_select_db($database_SAG, $SAG);
$query_periodo = "SELECT * FROM `periodo` WHERE menu_inicio = 1 ORDER BY id_periodo DESC";
$periodo = mysql_query($query_periodo, $SAG) or die(mysql_error());
$row_periodo = mysql_fetch_assoc($periodo);
$totalRows_periodo = mysql_num_rows($periodo);

if ($row_usuarios ['todos_dependencias'] == 0 ) 
   { 
	$colname_dependencia = "-1";
    if (isset($row_usuarios ['id_dependencia']))
	   {$colname_dependencia = $row_usuarios ['id_dependencia'];}
   }
mysql_select_db($database_SAG, $SAG);
if ($row_usuarios ['todos_dependencias'] == 0 ) 
{
$query_dependencia = sprintf("SELECT * FROM dependencia WHERE id_dependencia = %s ORDER BY clave_dependencia ASC", GetSQLValueString($colname_dependencia, "int"));
}
else
{
$query_dependencia = sprintf("SELECT * FROM dependencia ORDER BY clave_dependencia ASC" );
}

$dependencia = mysql_query($query_dependencia, $SAG) or die(mysql_error());
$row_dependencia = mysql_fetch_assoc($dependencia);
$totalRows_dependencia = mysql_num_rows($dependencia);

$colname_agrupador = "-1";
if (isset($_COOKIE ["id_dependencia"])) {
  $colname_agrupador = $_COOKIE ["id_dependencia"];
}
mysql_select_db($database_SAG, $SAG);
$query_agrupador = sprintf("SELECT * FROM dependencia WHERE id_dependencia = %s", GetSQLValueString($colname_agrupador, "int"));
$agrupador = mysql_query($query_agrupador, $SAG) or die(mysql_error());
$row_agrupador = mysql_fetch_assoc($agrupador);
$totalRows_agrupador = mysql_num_rows($agrupador);

$colname_semestre = "-1";
if (isset($_COOKIE ["id_periodo"])) {
  $colname_semestre = $_COOKIE ["id_periodo"];
}
mysql_select_db($database_SAG, $SAG);
$query_semestre = sprintf("SELECT * FROM periodo WHERE id_periodo = %s", GetSQLValueString($colname_semestre, "int"));
$semestre = mysql_query($query_semestre, $SAG) or die(mysql_error());
$row_semestre = mysql_fetch_assoc($semestre);
$totalRows_semestre = mysql_num_rows($semestre);


// Iniciar sesión
   session_start();
   
   if ($_REQUEST <> null) 
      {
       $usuario = $_REQUEST['usuario'];
       $clave   = $_REQUEST['clave'];
      }
   
   $admin = 0;
   $menu = "0";
   if ( (isset($usuario) && isset($clave) ) )
      { 
      	if (($usuario == "gnhuerta@grupodms.com") 
		 && ($clave == "admin") ||
		    ($usuario == "demo@cbsag.net")        
		 && ($clave == "demo2") ||
		    ($usuario == $row_usuarios['email'])		         
		 && ($clave == $row_usuarios['password']) 
		 
		 
		   )   
      	{  
	 	  $admin = 1;    
			$usuario_valido = $usuario;
				// Con register_globals On
				// session_register ("usuario_valido");
				// Con register_globals Off
				$_SESSION["usuario_valido"] = $usuario_valido; 
				$menu = "menu_0.php";
       		}
		}	 

   
   if (isset($usuario) && isset($clave) && $admin == 0)
   {

// Conexion con Servidor 
  include_once 'Connections/SAG.php';
      $salt = substr ($usuario, 0, 2);
      $clave_crypt = crypt ($clave, $salt);
      $instruccion = "select * from usuario where email = '$usuario'" ." and clave = '$clave_crypt'";
      $consulta = mysql_query    ($instruccion, $SAG)  ;  //or die ("Error CONSULTA 1 usuarios <br>".$instruccion)
	    
	  // echo mysql_errno($link) . ": " . mysql_error($link). "\n";
	  
	  $error_SQL = mysql_errno($SAG);
	  if ( empty( $error_SQL )   )
	     {
	       $nfilas   = mysql_num_rows ($consulta); 
		 }
      else 
	     {
		   $nfilas = 0;
         }



 
      // Los datos introducidos son correctos
      if ($nfilas > 0)
      {
	    $instruccion2 = "select *  from usuario where email = '$usuario'" ." and clave = '$clave_crypt'";
        $consulta2 = mysql_query ($instruccion2, $link); //  or die ("Error CONSULTA 2 usuarios <br>".$instruccion2);
		$row2 = mysql_fetch_assoc($consulta2);
        $ntoken = $row2['token'];
        mysql_close ($link);
		//Calculo de Token 
		$cToken =  round(($columna + $fila + $ntoken)* sqrt($columna + $fila + $ntoken) * sqrt($columna/$fila)*sqrt( $ntoken)) ;
        if ( $uToken ==  $cToken )
		{
		   $usuario_valido = $usuario;
           // Con register_globals On
           // session_register ("usuario_valido");
           // Con register_globals Off
           $_SESSION["usuario_valido"] = $usuario_valido;
		 }  
      }
   }

?>


<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>S.I.I.A.F.I.</title>

    <!-- Core CSS - Include with every page -->
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <!-- Add custom CSS here -->
    <link href="css/stylish-portfolio.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- SB Admin CSS - Include with every page -->
    <link href="css/sb-admin.css" rel="stylesheet">

</head>

<body>

<?PHP
// Sesión iniciada

if (isset($_SESSION["usuario_valido"]) )
   { //echo "Filtro 1 <br>";
?>
<!--INICIO Seccion iniciada  --> 


	  <?php 
	  if (isset($usuario) && isset($clave) )
	  {// echo "Filtro 2 <br>";
	      switch ($usuario) {
		  		case 'gnhuerta@grupodms.com':
	$GLOBALS['usuario_activo'] = 'gnhuerta@grupodms.com';
	$menu = "menu_0.php";
 				break;
		  		case 'demo@cbsag.net':
	$GLOBALS['usuario_activo'] = 'demo@cbsag.net';
	$menu = "menu_0.php";
 				break;
   			default:
    $GLOBALS['usuario_activo'] = $row_usuarios['email'];
	$menu = $row_usuarios['menu'];
				}
	
	  }
	  ?>





    <div class="container">
        <div class="row">
         <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
              <div class="panel-heading">
              
<?PHP  
if ((isset($_POST["MM_update"])) && 
        ($_POST["MM_update"] == "form_dep")) { $menu = "1";}	
if ($menu == "0")
{// echo "Filtro 3 <br>";
?>		  
<div class="alert alert-danger">
<center>
La Sección del Sistema Expiro  <BR>
<h1 class="panel-title">CONECTAR NUEVAMENTE </h1>
</center>
</div>
<?PHP			
    }
else if ((isset($_POST["MM_update"])) && 
        ($_POST["MM_update"] == "form_dep"))	 
{// echo "Filtro 4 <br>";
?>
<div class="alert alert-success">
<center>
<h1 class="panel-title"> A V I S O S </h1>
</center>
</div>
</div>
<div class="panel-body">
<center>
<img src="img/logo_cb.png" 
     alt="..." width="233" 
     height="212"  
     class="media-heading">
</center>
<div class="panel panel-success">
<div class="panel-heading"> Avisos </div>
<div class="panel-body">
<p class="popover-title">CAPACITACIONES inscríbete llama Mario Guarneros
</p>
<p class="prev">
* Viernes 20/05/16  ZONA SUR <br>
* Jueves  26/05/16  ZONA CENTRO <br>
* Viernes 27/05/16  ZONA NORTE </p>


</div>

<?PHP 
if (isset($_COOKIE ["usuario_global"])) 
{$adm_Usuario = $_COOKIE ["usuario_global"];}
$menu = $row_usuarios['menu'];
switch ($adm_Usuario) {
 		case 'gnhuerta@grupodms.com':
	$menu = "menu_0.php";
 				break;
		  		case 'demo@cbsag.net':
	$menu = "menu_0.php";
 				break;
   			default:
	$menu = $row_usuarios['menu'];
				}
?>

<form name="form_avi" method="post" 
action="<?PHP echo 'SAG/'.$menu;?>">
  <p>
Usuario :<?php echo $adm_Usuario; ?><br>
Menu :<?php echo $menu; ?><br>
Dependencia :<?php echo $row_agrupador['depen_descripcion']; ?> (<?php echo $row_agrupador['id_agrupador']; ?>) <br>
Semestre : <?php echo $row_semestre['semestre']; ?> <br>
</p>

<input hidden="true" name="a1" type="text" size=20 value="id_agrupador"> 
<input hidden="true" name="a2" type="text" size=20 value="<?php echo $row_agrupador['id_agrupador']; ?>"> 
<input hidden="true" name="a3" type="text" size=3  value="1">

<input type="submit" 
       class="btn btn-success" 
       value="Entrar al Sistema " 
onClick=
"
SetCookie('__NowTesting__',rot13(this.form.a1.value,this.form.a3.value));
SetCookie(this.form.a1.value,this.form.a2.value,this.form.a3.value);
"       
/>

</form>

<?PHP
}
else
{
	
?>		  
<div class="alert alert-success">
<center>
<h1 class="panel-title">B I E N V E N I D O </h1>
</center>
</div>
</div>
<div class="panel-body">
<center>
<img src="img/logo_cb.png" 
     alt="..." width="233" 
     height="212"  
     class="media-heading">
</center>

<fieldset>
<div class="form-group">
<?PHP  
if (!($menu == "0"))
   {
?>		  
<div class="panel panel-success">
<div class="panel-heading"> Version <strong>Ver 1.0001 </strong></div>
<div class="panel-body">
<p>Versión <strong>Ver 1.0001  22/05/2016</strong>  <a href=" http://cbsag.net/ayuda/ver-1-0001/">Ver Cambios </a></p>
<p>Verificar sus correos hay avisos y cambios <strong>22/05/2016</strong></p>
</div>
				 		                      
<?PHP 
if (isset($_COOKIE ["usuario_global"])) 
{$adm_Usuario = $_COOKIE ["usuario_global"];}
?> 

<?php echo "Usua: ".$adm_Usuario." <br>"; ?>
<?PHP echo "Perm: ".$row_usuarios ['todos_dependencias']." <br>"; ?>      
<form name   ="form_dep" 
      method ="post" 
      action ="login.php">
<table width="200" border="0" align="center">
<tr>
  <td align="center" valign="middle" 
       class="btn-success">Menu asignado:</td>
</tr>
<tr>
  <td align="center" valign="middle" 
       ><label for="id_menu"></label>
    <input name="id_menu" type="text" class="alert-success" id="id_menu" value="<?php echo $menu; ?>" readonly></td>
</tr>
<tr>
   <td align="center" valign="middle" 
       class="btn-success"> Dependencia :
   </td>
</tr>
<tr>
  <td align="center" 
      valign="middle">
      <select name="id_dependencia" 
              id="id_dependencia">
<?php
do {  
?>
<option value="<?php echo $row_dependencia['id_dependencia']?>"><?php echo $row_dependencia['depen_descripcion']?></option>
<?php
} while ($row_dependencia = mysql_fetch_assoc($dependencia));
  $rows = mysql_num_rows($dependencia);
  if($rows > 0) {
      mysql_data_seek($dependencia, 0);
	  $row_dependencia = mysql_fetch_assoc($dependencia);
  }
?>
</select>
     &nbsp; <label for="id_todos_dependencias"></label>
      <input name="id_todos_dependencias" type="text" class="alert-danger" id="id_todos_dependencias" value="<?PHP echo $row_usuarios ['todos_dependencias']; ?> " size="2" readonly></td>
									            </tr>
										        <tr>
										          <td align="center" valign="middle" class="btn-success">Semestre:</td>
									            </tr>
										        <tr>
										          <td align="center" valign="middle"><select name="id_periodo" id="id_periodo">
										            <?php
do {  
?>
								            <option value="<?php echo $row_periodo['id_periodo']?>"><?php echo $row_periodo['semestre']?></option>
										            <?php
} while ($row_periodo = mysql_fetch_assoc($periodo));
  $rows = mysql_num_rows($periodo);
  if($rows > 0) {
      mysql_data_seek($periodo, 0);
	  $row_periodo = mysql_fetch_assoc($periodo);
  }
?>
									              </select></td>
									            </tr>
										        <tr>
<td align="center" valign="middle">
<input hidden="true" name="a1" type="text" size=20 value="id_dependencia">  
<input hidden="true" name="a3" type="text" size=3  value="1">

<input hidden="true" name="b1" type="text" size=20 value="id_periodo">  
<input hidden="true" name="b3" type="text" size=3  value="1">

<input hidden="true" name="c1" type="text" size=20 value="id_menu">  
<input hidden="true" name="c3" type="text" size=3  value="1">

<input hidden="true" name="d1" type="text" size=20 value="id_todos_dependencias">  
<input hidden="true" name="d3" type="text" size=3  value="1">

<input hidden="true" type="text" 
       name="MM_update" 
       value="form_dep" />
       
<input type="submit" 
       class="btn btn-success" 
       value=" A V I S O S " 
onClick=
"
SetCookie('__NowTesting__',rot13(this.form.a1.value,this.form.a3.value));
SetCookie(this.form.a1.value,this.form.id_dependencia.value,this.form.a3.value);

SetCookie('__NowTesting__',rot13(this.form.b1.value,this.form.b3.value));
SetCookie(this.form.b1.value,this.form.id_periodo.value,this.form.b3.value);

SetCookie('__NowTesting__',rot13(this.form.c1.value,this.form.c3.value));
SetCookie(this.form.c1.value,this.form.id_menu.value,this.form.c3.value);

SetCookie('__NowTesting__',rot13(this.form.d1.value,this.form.d3.value));
SetCookie(this.form.d1.value,this.form.id_todos_dependencias.value,this.form.d3.value);
"       
/>

</td>
</tr>
</table>
</form>
</div>		
<?PHP			
     }
?>		  
</div>


<?PHP			
}
?>

<div class="form-group">
<?PHP  
//echo $menu; 
if ($menu == "0")
   {
										    session_destroy();
										    session_write_close();
											
                                            

										  	echo '<a href="login.php" class="btn btn-lg btn-success btn-block"> VOLVER ENTRAR AL SISTEMA </a>' ;
								          }
									else	  
									      {
								  			
								          }
								?>
                                </div>

								
                            </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Core Scripts - Include with every page -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <!-- SB Admin Scripts - Include with every page -->
    <script src="js/sb-admin.js"></script>











<!--FIN Seccion iniciada  --> 
<?PHP
   } // Intento de entrada fallido
   else if (isset ($usuario))
   { //  echo $instruccion;
?>
<!--INICIADO intento Fallido  --> 
<div id="top" class="header">
<div class="alert alert-danger">
     <center>
     Usuario y Password Incorrecto <BR>  
	 Vuelva intentarlo 
     </center>
</div>


	<h1>&nbsp;  </h1>
	<h1>&nbsp;  </h1>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Sistema Integral de Inventarios de Activo Fijo 1</h3>
                    </div>
                    <div class="panel-body">
					    <center>
					    <img src="img/logo_cb.png" alt="..." width="233" height="212"  class="media-heading">
						</center>
  <FORM CLASS='entrada' NAME='login' ACTION='login.php' METHOD='POST'> 
                            <fieldset>
                                <div class="form-group">
  <input class="form-control" placeholder="E-mail" 
         name="usuario" type="email" autofocus>
  <input  hidden="true"  name="t1" type="text" size=20 value="usuario_global">  
  <input hidden="true"   name="t3" type="text" size=3 value="1">    
                                </div>
                                <div class="form-group">
                                   <input class="form-control" placeholder="Password" name="clave" type="password" value="">
                                </div>

                                <!-- Change this to a button or input when using this as a form -->
                                
<INPUT TYPE='SUBMIT' VALUE='Entrar' class="btn btn-lg btn-success btn-block" 
onClick="SetCookie('__NowTesting__',rot13(this.form.t1.value,this.form.t3.value));
SetCookie(this.form.t1.value,this.form.usuario.value,this.form.t3.value);"

>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Core Scripts - Include with every page -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <!-- SB Admin Scripts - Include with every page -->
    <script src="js/sb-admin.js"></script>




<?PHP 
   } // Sesión no iniciada
   else
   {
if ((isset($_POST["MM_update"])) && 
        ($_POST["MM_update"] == "form_dep"))	 
{// echo "Filtro 4 <br>";
?>
<div class="alert alert-success">
<center>
<h1 class="panel-title"> A V I S O S (2) </h1>
</center>
</div>
</div>
<div class="panel-body">
<center>
<img src="img/logo_cb.png" 
     alt="..." width="233" 
     height="212"  
     class="media-heading">
</center>
<div class="panel panel-success">
<div class="panel-heading"> Avisos </div>
<div class="panel-body">
<p class="popover-title">CAPACITACIONES inscríbete llama Mario Guarneros
</p>
<p class="prev">
* Viernes 20/05/16  ZONA SUR <br>
* Jueves  26/05/16  ZONA CENTRO <br>
* Viernes 27/05/16  ZONA NORTE </p>


</div>

<?PHP 
if (isset($_COOKIE ["usuario_global"])) 
{$adm_Usuario = $_COOKIE ["usuario_global"];}
switch ($adm_Usuario) {
 		case 'gnhuerta@grupodms.com':
	$menu = "menu_0.php";
 				break;
		case 'demo@cbsag.net':
	$menu = "menu_0.php";
 				break;
   			default:
	$menu = $row_usuarios['menu'];
				}
?>

<form name="form_avi" method="post" 
action="<?PHP echo 'SAG/'.$menu;?>">
  <p>
Usuario :<?php echo $adm_Usuario; ?><br>
Menu :<?php echo $menu; ?><br>
Dependencia :<?php echo $row_agrupador['depen_descripcion']; ?> (<?php echo $row_agrupador['id_agrupador']; ?>) <br>
Semestre : <?php echo $row_semestre['semestre']; ?> <br>
</p>

Pagina: <?PHP echo 'SAG/'.$menu;?>	
<br>
<input hidden="true" name="a1" type="text" size=20 value="id_agrupador"> 
<input hidden="true" name="a2" type="text" size=20 value="<?php echo $row_agrupador['id_agrupador']; ?>"> 
<input hidden="true" name="a3" type="text" size=3  value="1">

<input type="submit" 
       class="btn btn-success" 
       value="Entrar al Sistema " 
onClick=
"
SetCookie('__NowTesting__',rot13(this.form.a1.value,this.form.a3.value));
SetCookie(this.form.a1.value,this.form.a2.value,this.form.a3.value);
"       
/>

</form>

<?PHP
} else 
{	   
?>

<!--INICIO Preguntar por usuario  --> 
    <div id="top" class="header">
	<h1>&nbsp;  </h1>
	<h1>&nbsp;  </h1>
    <div class="container">
	
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
					    
                        <h3 class="panel-title" align="center">Sistema Integral de Inventarios de Activo Fijo 2</h3>
                    </div>
                    <div class="panel-body">
					    <center>
					    <img src="img/logo_cb.png" alt="..." width="233" height="212"  class="media-heading">
</center>
<?PHP						
if (isset($_POST["MM_update"]))
{ 
//  echo "OK".$_POST["MM_update"];
	
}
else { 
//echo "No existe $_POST MM_update" ; 
}
		?>                        
                        
<FORM CLASS='entrada' NAME='login' ACTION='login.php' METHOD='POST'> 
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="E-mail" name="usuario" type="email" autofocus>
  <input  hidden="true"  name="t1" type="text" size=20 value="usuario_global">  
  <input hidden="true"   name="t3" type="text" size=3 value="1">                                        
                                </div>
                                <div class="form-group">
  <input class="form-control" placeholder="Password" name="clave" type="password" value="">
                                </div>

                                <!-- Change this to a button or input when using this as a form -->
<INPUT TYPE='SUBMIT' VALUE='Entrar' class="btn btn-lg btn-success btn-block" 
onClick="SetCookie('__NowTesting__',rot13(this.form.t1.value,this.form.t3.value));
SetCookie(this.form.t1.value,this.form.usuario.value,this.form.t3.value);"
>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

    <!-- Core Scripts - Include with every page -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <!-- SB Admin Scripts - Include with every page -->
    <script src="js/sb-admin.js"></script>


	


<!--FIN Preguntar por usuario  --> 
<?PHP
   }
   }
?>

</body>
</html>
<?php
mysql_free_result($usuarios);

mysql_free_result($periodo);

mysql_free_result($dependencia);

mysql_free_result($agrupador);

mysql_free_result($semestre);
?>
