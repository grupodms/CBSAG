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
if (isset($_GET['id_activo_fijo'])) {
  $colname_Pagos = $_GET['id_activo_fijo'];
}
mysql_select_db($database_SAG, $SAG);
$query_Pagos = sprintf("
SELECT
determinantes.clave_determinante,
determinantes.descripcion,
activo_fijo_partidas.cantidad,
determinantes.comodato,
determinantes.comodato_fecha,
determinantes.donacion,
determinantes.donacion_fecha,
determinantes.tecnica,
determinantes.autor,
determinantes.cuenta,
determinantes.cuenta2,
determinantes.cambs,
determinantes.costo,
determinante_tipo.deter_descripcion,
activo_fijo_partidas.id_activo_fijo,
activo_fijo_partidas.id_activo_fijo_partidas,
activo_fijo_partidas.id_determinantes

FROM
activo_fijo_partidas
INNER JOIN determinantes ON activo_fijo_partidas.id_determinantes = determinantes.id_determinantes
INNER JOIN determinante_tipo ON determinantes.id_determinante_tipo = determinante_tipo.id_determinante_tipo
WHERE  activo_fijo_partidas.id_activo_fijo = %s 
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
  <h1>Detalle Activo Fijo</h1></p>
</blockquote>

<p><div class="pull-left">
  </div>
</p>

<table width="100%" border="0" align="center" class="table table-hover">
  <tr>

    <td>Clave</td>
    <td>Descripción</td>
    <td>Cantidad</td>
    <td>comodato</td>
    <td>fecha</td>
    <td>donacion</td>
    <td>fecha</td>
    <td>tecnica</td>
    <td>autor</td>
    <td>cuenta</td>
    <td>cuenta2</td>
    <td>cambs</td>
    <td>costo</td>     


  </tr>
  <?php do { ?>
    <tr>
    <td width="8%"><?php echo $row_Pagos['clave_determinante']; ?></td>
    <td><?php echo $row_Pagos['descripcion']; ?></td>
    <td><?php echo $row_Pagos['cantidad']; ?></td>      
    <td><?php echo $row_Pagos['comodato']; ?></td>
    <td><?php echo $row_Pagos['comodato_fecha']; ?></td>
    <td><?php echo $row_Pagos['donacion']; ?></td>
    <td><?php echo $row_Pagos['donacion_fecha']; ?></td>
    <td><?php echo $row_Pagos['tecnica']; ?></td>
    <td><?php echo $row_Pagos['autor']; ?></td>
    <td><?php echo $row_Pagos['cuenta']; ?></td>
    <td><?php echo $row_Pagos['cuenta2']; ?></td>
    <td><?php echo $row_Pagos['cambs']; ?></td>
    <td><?php echo $row_Pagos['costo']; ?></td>    </tr>
    <?php } while ($row_Pagos = mysql_fetch_assoc($Pagos)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($Pagos);
?>
