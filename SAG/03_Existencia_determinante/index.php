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
$aDep_Area3 = "-1";
if (isset($_COOKIE ["id_dependencia"])) {
  $aDep_Area3 = $_COOKIE ["id_dependencia"];
}
$aPer_Area3 = "-1";
if (isset($_COOKIE ["id_periodo"])) {
  $aPer_Area3 = $_COOKIE ["id_periodo"];
}
mysql_select_db($database_SAG, $SAG);
$query_Area3 = sprintf("SELECT resguardo.id_periodo, resguardo.id_dependencia, resguardo_partidas.id_determinantes, dependencia.clave_dependencia, dependencia.depen_descripcion, determinantes.clave_determinante, determinantes.descripcion, Sum(resguardo_partidas.unidades) AS existencia FROM resguardo INNER JOIN periodo ON periodo.id_periodo = resguardo.id_periodo INNER JOIN dependencia ON dependencia.id_dependencia = resguardo.id_dependencia INNER JOIN resguardo_partidas ON resguardo.id_resguardo = resguardo_partidas.id_resguardo INNER JOIN determinantes ON determinantes.id_determinantes = resguardo_partidas.id_determinantes INNER JOIN empleado AS tm ON tm.id_empleado = resguardo.id_empleado_tm INNER JOIN empleado AS tv ON tv.id_empleado = resguardo.id_empleado_tv WHERE 	resguardo.id_dependencia = %s AND resguardo.id_periodo = %s GROUP BY resguardo.id_periodo, resguardo.id_dependencia, determinantes.clave_determinante ORDER BY determinantes.clave_determinante ASC ", GetSQLValueString($aDep_Area3, "int"),GetSQLValueString($aPer_Area3, "int"));
$Area3 = mysql_query($query_Area3, $SAG) or die(mysql_error());
$row_Area3 = mysql_fetch_assoc($Area3);
$totalRows_Area3 = mysql_num_rows($Area3);

$colname_dependencia = "-1";
if (isset($_COOKIE ['id_dependencia'])) {
  $colname_dependencia = $_COOKIE ['id_dependencia'];
}
mysql_select_db($database_SAG, $SAG);
$query_dependencia = sprintf("SELECT * FROM dependencia WHERE id_dependencia = %s", GetSQLValueString($colname_dependencia, "int"));
$dependencia = mysql_query($query_dependencia, $SAG) or die(mysql_error());
$row_dependencia = mysql_fetch_assoc($dependencia);
$totalRows_dependencia = mysql_num_rows($dependencia);

$colname_periodo = "-1";
if (isset($_COOKIE ['id_periodo'])) {
  $colname_periodo = $_COOKIE ['id_periodo'];
}
mysql_select_db($database_SAG, $SAG);
$query_periodo = sprintf("SELECT * FROM periodo WHERE id_periodo = %s", GetSQLValueString($colname_periodo, "int"));
$periodo = mysql_query($query_periodo, $SAG) or die(mysql_error());
$row_periodo = mysql_fetch_assoc($periodo);
$totalRows_periodo = mysql_num_rows($periodo);

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
<!-- Inicio:Librerias en EXCEL -->
<script type="text/javascript" 
        src="jquery-1.3.2.min.js">
		
</script>
<script language="javascript">
$(document).ready(function() {
$(".botonExcel").click(function(event) {
$("#datos_a_enviar").val( $("<div>").append( $("#Exportar_a_Excel").eq(0).clone()).html());
$("#FormularioExportacion").submit();
});
});
</script>
<!-- Fin:Librerias en EXCEL -->
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

<form action="ficheroExcel.php" method="post" target="_blank" id="FormularioExportacion">
  <img src="../../img/descarga_excel.png" alt="DESCARGA EXCEL" width="283" height="118" class="botonExcel" />
  <input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
</form>


<table width="50%" 
       border="1" 
       cellpadding="10" 
       cellspacing="0" 
       bordercolor="#666666" 
       id="Exportar_a_Excel" 
       style="border-collapse:collapse;">
  <caption> <h1>
COLEGIO DE BACHILLERES </h1>
<h3> (<?php echo $row_dependencia['clave_dependencia']; ?>)  <?php echo $row_dependencia['depen_descripcion']; ?></h3>
  
  <h3> Existencia de Determinantes  <?php echo $row_periodo['semestre']; ?> </h3>
  </caption>    
    <tr>
    <td style=" 
    border: 1px solid black;
    border-collapse: collapse; 
    text-align:center">
    Clave </td>
    <td style=" 
    border: 1px solid black;
    border-collapse: collapse; 
    text-align:center">
    Descripción</td>
    <td style=" 
    border: 1px solid black;
    border-collapse: collapse; 
    text-align:center">
    Existencia </td>
    </tr>
  <?php $nUnidades = 0; ?>
  <?php $nNum = 1; ?>     
<?php do { ?>
    <tr
      <?PHP if (fmod($nNum,2) == 0) { ?>
      style="background-color:#DBFCD6"
      <?PHP } ?>
    >
    <td style=" 
    border: 1px solid black;
    border-collapse: collapse; 
    text-align:center" >
    <div style=" width: 50px;  
                  text-align: center">
<?php echo $row_Area3['clave_determinante']; ?>
</div>
</td>
      <td style=" 
          border: 1px solid black;
          border-collapse: collapse; 
          text-align:center" >
      <div style=" 
      width: 250px;
      font-size: 7px;  
      text-align: left;
      ">
<?php echo $row_Area3['descripcion']; ?>
</div>
</td>
    <td style=" 
    border: 1px solid black;
    border-collapse: collapse; 
    text-align:center" >
    <div style=" width: 50px;  
                  text-align: right">
<?php echo $row_Area3['existencia']; ?>
</div>
</td>
</tr>
<?PHP $nUnidades += $row_Area3['existencia']; ?>
  <?php $nNum += 1; ?>   
  <?php } while ($row_Area3 = mysql_fetch_assoc($Area3)); ?>
  
<tr>
<td>&nbsp;</td>
      <td style=" 
          border: 1px solid black;
          border-collapse: collapse; 
          text-align:center" >
      <div style=" 
      width: 250px;
      font-size: 7px;  
      text-align: right;
      ">
Total :
</div>
</td>
    <td style=" 
    border: 1px solid black;
    border-collapse: collapse; 
    text-align:center" >
    <div style=" width: 50px;  
                  text-align: right">
<?php echo $nUnidades; ?>
</div>
</td>
</tr> 
</table>

</body>
</html>
<?php
mysql_free_result($Area3);

mysql_free_result($dependencia);

mysql_free_result($periodo);

?>
