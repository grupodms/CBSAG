<?php require_once('../../Connections/sag.php'); ?>
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

$colname_Pagos = "-1";
if (isset($_GET['idasem'])) {
  $colname_Pagos = $_GET['idasem'];
}
mysql_select_db($database_Canainpa, $Canainpa);
$query_Pagos = sprintf("SELECT * FROM asem_pagos WHERE idasem = %s ORDER BY fecha_pago DESC", GetSQLValueString($colname_Pagos, "int"));
$Pagos = mysql_query($query_Pagos, $Canainpa) or die(mysql_error());
$row_Pagos = mysql_fetch_assoc($Pagos);
$totalRows_Pagos = mysql_num_rows($Pagos);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<!--Inicio:  Bootstrap -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="../css/bootstrap.min.css" rel="stylesheet">
<title>Partidas Almacen por Area</title>
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

<?PHP $menu = 1; ?>
<?PHP require_once('../barra01.php'); ?>
<!--Menu -->

<!--Inicio:  Bootstrap -->
<blockquote>
  <p>
  <h1>Partidas Almacen por Area.</h1></p>
</blockquote>

<p><div class="pull-left">
   <a href="nuevo_pagos.php?idasem=<?PHP echo $colname_Pagos ;?>  ">
   <button type="button" class="btn btn-primary">Nuevo</button>
   </a></div>
</p>

<table width="100%" border="0" align="center" class="table table-hover">
  <tr>
    <td>Partida</td>
    <td>Num. Almacen</td>
    <td>Clave Deter</td>
    <td>Determinante</td>
    <td>Cantidad</td>
    <td>Costo</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_Pagos['id_almacen_partidas']; ?></td>
      <td><?php echo $row_Pagos['id_almacen']; ?></td>
      <td><?php echo $row_Pagos['Referencia']; ?></td>
      <td><?php echo $row_Pagos['importe']; ?></td>
      <td><?php echo $row_Pagos['cantidad']; ?></td>
      <td><?php echo $row_Pagos['costo']; ?></td>
    </tr>
    <?php } while ($row_Pagos = mysql_fetch_assoc($Pagos)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($Pagos);
?>
