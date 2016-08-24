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

$colname_Reg_Emple = "-1";
if (isset($_COOKIE ["id_agrupador"])) {
  $colname_Reg_Emple = $_COOKIE ["id_agrupador"];
}
mysql_select_db($database_SAG, $SAG);
$query_Reg_Emple = sprintf("SELECT empleado.id_empleado, empleado.id_dependencia, dependencia.clave_dependencia, dependencia.depen_descripcion, empleado.matricula, empleado.rfc, empleado.curp, empleado.nombre, empleado.puesto, empleado.adcripcion FROM empleado INNER JOIN dependencia ON empleado.id_dependencia = dependencia.id_dependencia WHERE empleado.id_agrupador = %s ORDER BY rfc ASC", GetSQLValueString($colname_Reg_Emple, "int"));
$Reg_Emple = mysql_query($query_Reg_Emple, $SAG) or die(mysql_error());
$row_Reg_Emple = mysql_fetch_assoc($Reg_Emple);
$totalRows_Reg_Emple = mysql_num_rows($Reg_Emple);

mysql_select_db($database_SAG, $SAG);
$query_Reg_Deter = "
SELECT
empleado.id_empleado,
empleado.id_dependencia,
dependencia.clave_dependencia,
dependencia.depen_descripcion,
empleado.matricula,
empleado.rfc,
empleado.curp,
empleado.nombre,
empleado.puesto,
empleado.adcripcion
FROM
empleado
INNER JOIN dependencia ON empleado.id_dependencia = dependencia.id_dependencia
ORDER BY
empleado.rfc ASC
; ";
$Reg_Deter = mysql_query($query_Reg_Deter, $SAG) or die(mysql_error());
$row_Reg_Deter = mysql_fetch_assoc($Reg_Deter);
$totalRows_Reg_Deter = mysql_num_rows($Reg_Deter);

mysql_select_db($database_SAG, $SAG);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<!--Inicio:  Bootstrap -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="../css/bootstrap.min.css" rel="stylesheet">
<title>Empleados</title>
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
  <h1>Empleados</h1> 
  
  </p>
</blockquote>

<table width="100%" border="0" align="center" class="table table-hover">

  <tr class="info">
    <td>Id</td>
    <td>Matricula</td>
    <td>RFC </td>
    <td>CURP</td>
    <td>NOMBRE</td>
    <td align="center">PUESTO</td>

    
    <td align="center">DEPENDENCIA</td>
    <td align="center">COMISION</td>
  </tr>
  <?php do { ?>
  <tr>
   <td><?php echo $row_Reg_Emple['id_empleado']; ?></td>
   <td><?php echo $row_Reg_Emple['matricula']; ?></td>
   <td><?php echo $row_Reg_Emple['rfc']; ?></td>
   <td><?php echo $row_Reg_Emple['curp']; ?></td>
   <td><?php echo $row_Reg_Emple['nombre']; ?></td>
   <td><?php echo $row_Reg_Emple['puesto']; ?></td>
   <td><?php echo $row_Reg_Emple['depen_descripcion']; ?></td>
   <td>&nbsp;</td>
    </tr>
    <?php } while ($row_Reg_Emple = mysql_fetch_assoc($Reg_Emple)); ?>
</table>


</body>
</html>
<?php
mysql_free_result($Reg_Emple);

mysql_free_result($Reg_Deter);


?>
