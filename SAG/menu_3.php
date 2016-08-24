<?php require_once('../Connections/SAG.php'); ?>
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

$colname_dependencia = "-1";
if (isset($_COOKIE ["id_dependencia"])) {
  $colname_dependencia = $_COOKIE ["id_dependencia"];
}
mysql_select_db($database_SAG, $SAG);
$query_dependencia = sprintf("SELECT * FROM dependencia WHERE id_dependencia = %s", GetSQLValueString($colname_dependencia, "int"));
$dependencia = mysql_query($query_dependencia, $SAG) or die(mysql_error());
$row_dependencia = mysql_fetch_assoc($dependencia);
$totalRows_dependencia = mysql_num_rows($dependencia);

$colname_usuario = "-1";
if (isset($_COOKIE ["usuario_global"])) {
  $colname_usuario = $_COOKIE ["usuario_global"];
}
mysql_select_db($database_SAG, $SAG);
$query_usuario = sprintf("SELECT * FROM usuario WHERE email = %s", GetSQLValueString($colname_usuario, "text"));
$usuario = mysql_query($query_usuario, $SAG) or die(mysql_error());
$row_usuario = mysql_fetch_assoc($usuario);
$totalRows_usuario = mysql_num_rows($usuario);

$colname_periodo = "-1";
if (isset($_COOKIE ["id_periodo"])) {
  $colname_periodo = $_COOKIE ["id_periodo"];
}
mysql_select_db($database_SAG, $SAG);
$query_periodo = sprintf("SELECT * FROM periodo WHERE id_periodo = %s", GetSQLValueString($colname_periodo, "int"));
$periodo = mysql_query($query_periodo, $SAG) or die(mysql_error());
$row_periodo = mysql_fetch_assoc($periodo);
$totalRows_periodo = mysql_num_rows($periodo);

$adm_Usuario    = $_COOKIE ["usuario_global"];
$id_periodo     = $_COOKIE ["id_periodo"]; 
$id_dependencia = $_COOKIE ["id_dependencia"];$id_agrupacion  = $_COOKIE ["id_agrupacion"]; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<title>Menu Principal S.I.I.A.F.I.</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
    #apDiv1 {
	position: absolute;
	width: 134px;
	height: 128px;
	z-index: 1;
	left: 7px;
	top: 94px;
	background-image: url(img/4.png);
}
    </style>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>

<!--Menu -->
<?PHP  



$adm_NomPerfil = "";
switch ($adm_Perfil)
   {
	 case 1:
	      $adm_NomPerfil = "Administrador";
		  require_once('barra01.php');
		  break;
	 case 2:
	      $adm_NomPerfil = "Usuario";
		  require_once('barra02.php');
		  break;
	default:
	      $adm_NomPerfil = "Usuario";
		  require_once('barra01.php');
		  break;
		  	   
   }

    
?>
<?PHP $menu = 0; ?>
<!--Menu -->

<div >
   <div id="top" class="header">
       <div class="vert-text">
   <div class="panel panel-success">
                        <div class="panel-heading">
                          <table width="200" border="0" align="center" class="alert-success">
                            <tr>
                              <td><img src="img/inv_01.png" width="128" height="121" /></td>
                              <td><img src="img/inv_02.png" width="82" height="111" /></td>
                              <td><img src="img/inv_03.png" width="212" height="126" /></td>
                              <td><img src="img/inv_04.png" alt="" width="102" height="95" /></td>
                              <td><img src="img/inv_05.png" alt="" width="67" height="150" /></td>
                              <td><img src="img/inv_06.png" alt="" width="110" height="95" /></td>
                            </tr>
                            <tr>
                              <td colspan="3"  class="btn-success"><p align="left">
                            Usuario :<?php echo $_COOKIE ["usuario_global"]; ?>
   <?php echo trim($row_usuario['nombre']); ?>&nbsp;<?php echo trim($row_usuario['apellido_paterno']); ?></p> </td>
                              <td align="right" >&nbsp;</td>
 <td>&nbsp;</td>
                       <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td colspan="3"  class="btn-success"><p align="left">Dependencia: (<?php echo $row_dependencia['clave_dependencia']; ?>)&nbsp;<?php echo $row_dependencia['depen_descripcion']; ?> </p></td>
                              <td rowspan="2">&nbsp;</td>
                              <td colspan="2" rowspan="2" align="left">&nbsp;</td>
                            </tr>
                            <tr align="right">
                              <td colspan="3" class="btn-success"><p align="left">Periodo:&nbsp; <?php echo $row_periodo['semestre']; ?> </p></td>
                            </tr>
                            <tr>
                              <td><img src="img/inv_07.png" width="202" height="187" /></td>
                              <td><img src="img/inv_08.png" width="144" height="159" /></td>
                              <td><img src="img/inv_09.png" width="121" height="153" /></td>
                              <td><img src="img/inv_10.png" width="182" height="156" /></td>
                              <td><img src="img/inv_11.png" width="156" height="167" /></td>
                              <td><img src="img/inv_12.png" width="188" height="200" /></td>
                            </tr>
                            <tr>
                              <td>  <a href="../SAG_MANUAL/index.html" target="_blank" class="btn btn-primary btn-lg" role="button">Manual S.I.I.A.F.</a></td>
                              <td>  <a href="http://grupodms.com/prod/00Plantilla/06sb-admin-v2/index.html" target="_blank" class="btn btn-primary btn-lg" role="button">Reportes S.I.I.A.F.</a></td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                            </tr>
                          </table>
                          <p>&nbsp;</p>
                          <p>
                            
                          </p>
                          <p>&nbsp;</p>
     </div>


         </div>



 
</div>
<h4 class="btn-success" >
<p >&nbsp;</p>
<p >&nbsp;</p>
<p >&nbsp;</p>
<p >&nbsp;</p>
</h4>


</body>
</html>
<?php
mysql_free_result($dependencia);

mysql_free_result($usuario);

mysql_free_result($periodo);
?>
