<?php require_once('../../Connections/SAG.php'); ?>
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
$colname_Area3 = "-1";
if (isset($_COOKIE ["id_dependencia"])) {
  $colname_Area3 = $_COOKIE ["id_dependencia"];
}
$colname2_Area3 = "-1";
if (isset($_COOKIE ["id_periodo"])) {
  $colname2_Area3 = $_COOKIE ["id_periodo"];
}
mysql_select_db($database_SAG, $SAG);
$query_Area3 = sprintf("SELECT resguardo.id_resguardo, resguardo.id_periodo,  resguardo.id_dependencia,  resguardo.id_area, resguardo.id_consecutivo,  periodo.semestre, dependencia.clave_dependencia, dependencia.depen_descripcion, area.clave_area,  area.des_area,  consecutivo.clave_conse,  consecutivo.descripcion_consecutivo, resguardo_partidas.id_resguardo_partidas, resguardo_partidas.unidades,  determinantes.id_determinantes,  determinantes.clave_determinante,  determinantes.descripcion,  tm.matricula AS 1matricula,  tm.rfc AS 1rfc,  tm.nombre AS 1nombre,  tv.matricula AS 2matricula,  tv.rfc AS 2rfc,  tv.nombre AS 2nombre FROM resguardo  INNER JOIN periodo ON periodo.id_periodo = resguardo.id_periodo INNER JOIN dependencia ON dependencia.id_dependencia = resguardo.id_dependencia INNER JOIN area ON area.id_dependencia = resguardo.id_dependencia  INNER JOIN consecutivo ON consecutivo.id_consecutivo = resguardo.id_consecutivo  INNER JOIN resguardo_partidas ON resguardo.id_resguardo = resguardo_partidas.id_resguardo  INNER JOIN determinantes ON determinantes.id_determinantes = resguardo_partidas.id_determinantes  INNER JOIN empleado AS tm ON tm.id_empleado = resguardo.id_empleado_tm  INNER JOIN empleado AS tv ON tv.id_empleado = resguardo.id_empleado_tv WHERE resguardo.id_dependencia = %s and resguardo.id_periodo = %s ORDER BY determinantes.clave_determinante ASC, area.clave_area ASC, consecutivo.clave_conse ASC ", GetSQLValueString($colname_Area3, "int"),GetSQLValueString($colname2_Area3, "int"));
$Area3 = mysql_query($query_Area3, $SAG) or die(mysql_error());
$row_Area3 = mysql_fetch_assoc($Area3);
$totalRows_Area3 = mysql_num_rows($Area3);

mysql_select_db($database_SAG, $SAG);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<!--Inicio:  Bootstrap -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="../css/bootstrap.min.css" rel="stylesheet">
<title>Activos por Determinantes.</title>
<!--Fin: Script Bootstrap --> 

</head>

<body>

<!--Inicio: Script Bootstrap -->
<script>
function confirmar()
{
	if(confirm('¿Estas seguro de eliminar este Registro?'))
		return true;
	else
		return false;
}
</script>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../js/bootstrap.min.js"></script>
<!--Fin: Script Bootstrap -->  

<!--Menu -->
<?PHP 
$adm_Usuario   = $_COOKIE ["usuario_global"]; 
?>
<?PHP $menu = 1; ?>
<?PHP require_once('../barra01.php'); ?>
<!--Menu -->

<!--Inicio:  Bootstrap -->
<blockquote>
  <p>
  <h1>Activos por Determinantes.</h1> 
  Orden del Reporte  Clave Determinante, Area, Consecutivo </blockquote>
&nbsp;
<?PHP // echo "Query ".$query_Area3; ?>


<table width="260%" border="0" align="center" class="table table-hover">
    
    <tr class="info">
      <td><h4>Num </h4></td>
      <td rowspan="2"><h4>Cant</h4></td>
      <td colspan="2"><h4>Determinante</h4></td>
      <td colspan="2"><h4>Área</h4></td>
      <td colspan="2"><h4>Concecutivo</h4></td>
      <td><h4>Num</h4></td>
      <td colspan="3"><h4>RFC 1</h4></td>
      <td colspan="3"><h4>RFC 2</h4></td>
      <td rowspan="2"><h4>Semestre</h4>
        <h4>&nbsp;</h4></td>
      <td colspan="2"><h4>Dependencia</h4></td>

    </tr>
    <tr class="info">
      <td><h5> Resguardo</h5></td>
      <td><h5>Clave </h5></td>
      <td><h5>Descripción</h5></td>
      <td><h5>Clave </h5></td>
      <td><h5>Descripción</h5></td>
      <td><h5>Clave </h5></td>
      <td><h5>Descripción</h5></td>
      <td><h5>Resguardo Partida</h5></td>
      <td><h5>Matricula</h5></td>
      <td><h5>RFC</h5></td>
      <td><h5>Nombre</h5></td>
      <td><h5>Matricula</h5></td>
      <td><h5>RFC</h5></td>
      <td><h5>Nombre</h5></td>
      <td><h5>Clave </h5></td>
      <td><h5>Descripción</h5></td>
   
    </tr>
<?php $nUnidades = 0; ?>     
<?php do { ?>
<tr>
<td><h6><?php echo $row_Area3['id_resguardo']; ?></h6></td>
<td><h6><?php echo $row_Area3['unidades']; ?></h6></td>
<td><h6><?php echo $row_Area3['clave_determinante']; ?></h6></td>
<td><h6><?php echo $row_Area3['descripcion']; ?></h6></td>
<td><h6><?php echo $row_Area3['clave_area']; ?></h6></td>
<td><h6><?php echo $row_Area3['des_area']; ?></h6></td>
<td><h6><?php echo $row_Area3['clave_conse']; ?></h6></td>
<td><h6><?php echo $row_Area3['descripcion_consecutivo']; ?></h6></td>
<td><h6><?php echo $row_Area3['id_resguardo_partidas']; ?></h6></td>
<td><h6><?php echo $row_Area3['1matricula']; ?></h6></td>
<td><h6><?php echo $row_Area3['1rfc']; ?></h6></td>
<td><h6><?php echo $row_Area3['1nombre']; ?></h6></td>
<td><h6><?php echo $row_Area3['2matricula']; ?></h6></td>
<td><h6><?php echo $row_Area3['2rfc']; ?></h6></td>
<td><h6><?php echo $row_Area3['2nombre']; ?></h6></td>
<td><h6><?php echo $row_Area3['semestre']; ?></h6></td>
<td><h6><?php echo $row_Area3['clave_dependencia']; ?></h6></td>
<td><h6><?php echo $row_Area3['depen_descripcion']; ?></h6></td>

</tr>
<?PHP $nUnidades += $row_Area3['unidades']; ?>
  <?php } while ($row_Area3 = mysql_fetch_assoc($Area3)); ?>
  
<tr>
<td>Total:</td>
<td><?php echo $nUnidades; ?></td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr> 
  </table>

</body>
</html>
<?php
mysql_free_result($Area3);

?>
