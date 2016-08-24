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

$colname_vale_entrada_partidas = "-1";
if (isset($_GET['id_vale_entrada'])) {
  $colname_vale_entrada_partidas = $_GET['id_vale_entrada'];
}
mysql_select_db($database_SAG, $SAG);
$query_vale_entrada_partidas = sprintf("SELECT * FROM vale_entrada_partidas WHERE id_vale_entrada = %s ORDER BY clave_determinante ASC", GetSQLValueString($colname_vale_entrada_partidas, "int"));
$vale_entrada_partidas = mysql_query($query_vale_entrada_partidas, $SAG) or die(mysql_error());
$row_vale_entrada_partidas = mysql_fetch_assoc($vale_entrada_partidas);
$totalRows_vale_entrada_partidas = mysql_num_rows($vale_entrada_partidas);$colname_vale_entrada_partidas = "-1";
if (isset($_GET['id_vale_entrada'])) {
  $colname_vale_entrada_partidas = $_GET['id_vale_entrada'];
}
mysql_select_db($database_SAG, $SAG);
$query_vale_entrada_partidas = sprintf("SELECT * FROM  vale_entrada_partidas WHERE id_vale_entrada = %s ORDER BY clave_determinante ASC", GetSQLValueString($colname_vale_entrada_partidas, "int"));
$vale_entrada_partidas = mysql_query($query_vale_entrada_partidas, $SAG) or die(mysql_error());
$row_vale_entrada_partidas = mysql_fetch_assoc($vale_entrada_partidas);
$totalRows_vale_entrada_partidas = mysql_num_rows($vale_entrada_partidas);

$nValeEnt_vale_entrada = "-1";
if (isset($_GET['id_vale_entrada'])) {
  $nValeEnt_vale_entrada = $_GET['id_vale_entrada'];
}
mysql_select_db($database_SAG, $SAG);
$query_vale_entrada = sprintf("SELECT 	vale_entrada.id_vale_entrada, 	vale_entrada.fecha, 	vale_entrada.id_periodo, 	periodo.semestre, 	vale_entrada.id_dependencia, 	dependencia.clave_dependencia, 	dependencia.depen_descripcion, 	vale_entrada.id_empleado_tm, 	empleado_tm.matricula AS tm_matricula, 	empleado_tm.rfc AS tm_rfc, 	empleado_tm.curp AS tm_curp, 	empleado_tm.nombre AS tm_nombre, 	empleado_tm.puesto AS tm_puesto, 	empleado_tm.adcripcion AS tm_adcripcion, 	empleado_tm.adcripcion_comision AS tm_adcripcion_comision, 	vale_entrada.id_empleado_tv, 	empleado_tv.matricula AS tv_matricula, 	empleado_tv.rfc AS tv_rfc, 	empleado_tv.curp AS tv_curp, 	empleado_tv.nombre AS tv_nombre, 	empleado_tv.puesto AS tv_puesto, 	empleado_tv.adcripcion AS tv_adcripcion, 	empleado_tv.adcripcion_comision AS tv_adcripcion_comision FROM 	vale_entrada INNER JOIN dependencia ON vale_entrada.id_dependencia = dependencia.id_dependencia INNER JOIN periodo ON vale_entrada.id_periodo = periodo.id_periodo INNER JOIN empleado AS empleado_tm ON vale_entrada.id_empleado_tm = empleado_tm.id_empleado INNER JOIN empleado AS empleado_tv ON vale_entrada.id_empleado_tv = empleado_tv.id_empleado WHERE 	id_vale_entrada = %s", GetSQLValueString($nValeEnt_vale_entrada, "int"));
$vale_entrada = mysql_query($query_vale_entrada, $SAG) or die(mysql_error());
$row_vale_entrada = mysql_fetch_assoc($vale_entrada);
$totalRows_vale_entrada = mysql_num_rows($vale_entrada);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<!--Inicio:  Bootstrap -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="../css/bootstrap.min.css" rel="stylesheet">
<title>Articulos Vale de Entrada</title>
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

  <h1>Articulos Vale de Entrada</h1>
</blockquote>
<table width="500" border="0" class="btn-group-xs">
  <tr>
    <td width="90" align="left">Semestre: </td>
    <td width="210" align="left"><?php echo $row_vale_entrada['semestre']; ?></td>
    <td width="300" align="left"><?php echo $row_vale_entrada['id_vale_entrada']; ?></td>
  </tr>
  <tr>
    <td width="90" align="left">Fecha: </td>
    <td width="210" align="left"><?php echo $row_vale_entrada['periodo_fecha']; ?></td>
    <td width="300" align="left">&nbsp;</td>
  </tr>
  <tr>
    <td width="90" align="left">Dependencia:</td>
    <td width="210" align="left">(<?php echo $row_vale_entrada['clave_dependencia']; ?>)</td>
    <td width="300" align="left"><?php echo $row_vale_entrada['depen_descripcion']; ?></td>
  </tr>
  <tr>
    <td width="90" align="left">&nbsp;</td>
    <td width="210" align="left">&nbsp;</td>
    <td width="300" align="left"></td>
  </tr>
  <tr>
    <td width="90" align="left">1:</td>
    <td width="210" align="left">(<?php echo $row_vale_entrada['tm_matricula']; ?>)</td>
    <td width="300" align="left"><?php echo $row_vale_entrada['tm_nombre']; ?></td>
  </tr>
  <tr>
    <td width="90" align="left">2:</td>
    <td width="210" align="left">(<?php echo $row_vale_entrada['tv_matricula']; ?>)</td>
    <td width="300" align="left"><?php echo $row_vale_entrada['tv_nombre']; ?></td>
  </tr>
  <tr>
    <td width="90" align="left">&nbsp;</td>
    <td width="210" align="left">&nbsp;</td>
    <td width="300" align="left">&nbsp;</td>
  </tr>
  <tr>
    <td width="90" align="left">&nbsp;</td>
    <td width="210" align="left">&nbsp;</td>
    <td width="300" align="left">&nbsp;</td>
  </tr>
</table>

<p><div class="pull-left">
   <a href="determinantes_nuevo.php?id_vale_entrada=<?PHP echo $row_vale_entrada['id_vale_entrada'];?>  ">
   <button type="button" class="btn btn-primary">Nuevo</button>
   </a></div>
</p>

<table width="100%" border="0" align="center" class="table table-hover">
  <tr>
    <td>id</td>
    
    <td>DETER</td>
    <td>CAMBS</td>
    <td>DESCRIPCION</td>
    <td>UNIDADES</td>
    <td>EDO_FIS</td>
    <td>OBSERVACIONES</td>
    <td colspan="2">ACCIONES</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_vale_entrada_partidas['id_vale_entrada_partidas']; ?></td>
      
      <td><?php echo $row_vale_entrada_partidas['clave_determinante']; ?></td>
      <td><?php echo $row_vale_entrada_partidas['comodato']; ?></td>
      <td><?php echo $row_vale_entrada_partidas['descripcion']; ?></td>
      <td><?php echo $row_vale_entrada_partidas['unidades']; ?></td>
      <td><?php echo $row_vale_entrada_partidas['clave_estado_fisico']; ?></td>
      <td>
        
      <form id="form1" name="form1" method="post" action="">
        <label for="obs"></label>
        <textarea name="obs" id="obs" cols="45" rows="2"><?php echo $row_vale_entrada_partidas['observaciones']; ?></textarea>
      </form></td>
      <td><a href="determinantes_editar.php?id_vale_entrada=<?PHP echo $row_vale_entrada['id_vale_entrada'];?>&id_vale_entrada_partidas= <?php echo $row_vale_entrada_partidas['id_vale_entrada_partidas'];?> ">
        <button type="button" class="btn btn-success"> <span class="glyphicon glyphicon-pencil"></span>Editar </button>
      </a></td>
                <td><a href="determinantes_eliminar.php?id_vale_entrada=<?PHP echo $row_vale_entrada['id_vale_entrada'];?>&id_vale_entrada_partidas= <?php echo $row_vale_entrada_partidas['id_vale_entrada_partidas'];?> "
onclick="return confirmar()">
        <button type="button" class="btn btn-danger"> <span class="glyphicon glyphicon-trash"></span> Eliminar </button>
      </a></td>  
      
      
    </tr>
    <?php } while ($row_vale_entrada_partidas = mysql_fetch_assoc($vale_entrada_partidas)); ?>
</table>

<a href="index.php">
   <button type="button" class="list-group-item-warning">
         <span class="glyphicon glyphicon-share-alt"></span> Regresar
</button>
</a>
</body>
</html>
<?php
mysql_free_result($vale_entrada_partidas);

mysql_free_result($vale_entrada);
?>
