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

$colname_Pagos = "-1";
if (isset($_GET['id_determinantes'])) {
  $colname_Pagos = $_GET['id_determinantes'];
}
mysql_select_db($database_SAG, $SAG);
$query_Pagos = sprintf("
SELECT
activo_fijo_partidas.id_determinantes,
determinantes.clave_determinante,
determinantes.descripcion,
determinantes.cambs,
determinantes.cuenta,
determinantes.cuenta2,
if (determinantes.comodato = 1,'X','') AS comodato,
if (determinantes.donacion = 1,'X','') AS donacion,
dependencia.depen_descripcion,
activo_fijo.fecha,
activo_fijo.id_activo_fijo,
activo_fijo_partidas.cantidad

FROM
activo_fijo_partidas
INNER JOIN determinantes ON activo_fijo_partidas.id_determinantes = determinantes.id_determinantes
INNER JOIN activo_fijo ON activo_fijo.id_activo_fijo = activo_fijo_partidas.id_activo_fijo
INNER JOIN dependencia ON dependencia.id_dependencia = activo_fijo.id_dependencia

WHERE  activo_fijo_partidas.id_determinantes = %s 

ORDER BY
determinantes.clave_determinante ASC
", GetSQLValueString($colname_Pagos, "int"));


$Pagos = mysql_query($query_Pagos, $SAG) or die(mysql_error());
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
  <h1>Detalle Determinante</h1></p>
</blockquote>

<p><div class="pull-left">
  </div>
</p>

<table width="100%" border="0" align="center" class="table table-hover">
  <tr>
    <td>Clave</td>
    <td>Descripción</td>
    <td>camba </td>
    <td>cuenta</td>
    <td>cuenta2</td>
    <td>comodato</td>
    <td>donacion</td>
    <td>Plantel</td>
    <td>cantidad</td>
    <td>Fecha</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_Pagos['clave_determinante']; ?></td>
      <td><?php echo $row_Pagos['descripcion']; ?></td>
      <td><?php echo $row_Pagos['cambs']; ?></td>
      <td><?php echo $row_Pagos['cuenta']; ?></td>
      <td><?php echo $row_Pagos['cuenta2']; ?></td>
    <td><?php echo $row_Pagos['comodato']; ?></td>
    <td><?php echo $row_Pagos['donacion']; ?></td>
    <td><?php echo $row_Pagos['depen_descripcion']; ?></td>
    <td><?php echo $row_Pagos['cantidad']; ?></td>
    <td><?php echo $row_Pagos['fecha']; ?></td>
    </tr>
    <?php } while ($row_Pagos = mysql_fetch_assoc($Pagos)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($Pagos);
?>
