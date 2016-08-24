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

$colname_Resguardos_detalle = "-1";
if (isset($_GET['id_resguardo'])) {
  $colname_Resguardos_detalle = $_GET['id_resguardo'];
}
mysql_select_db($database_SAG, $SAG);
$query_Resguardos_detalle = sprintf("SELECT * FROM resguardo_partidas WHERE id_resguardo = %s ORDER BY clave_determinante ASC", GetSQLValueString($colname_Resguardos_detalle, "int"));
$Resguardos_detalle = mysql_query($query_Resguardos_detalle, $SAG) or die(mysql_error());
$row_Resguardos_detalle = mysql_fetch_assoc($Resguardos_detalle);
$totalRows_Resguardos_detalle = mysql_num_rows($Resguardos_detalle);

$colname_Resguardo = "-1";
if (isset($_GET['id_resguardo'])) {
  $colname_Resguardo = $_GET['id_resguardo'];
}
mysql_select_db($database_SAG, $SAG);
$query_Resguardo = sprintf("SELECT resguardo.id_resguardo,  resguardo.fecha,  resguardo.id_periodo,  periodo.semestre,  resguardo.id_dependencia,  dependencia.clave_dependencia,  dependencia.depen_descripcion,  resguardo.id_area,  area.clave_area, area.des_area,  resguardo.id_consecutivo,  consecutivo.clave_conse,  consecutivo.descripcion_consecutivo,  resguardo.id_empleado_tm,  empleado_tm.matricula as tm_matricula,  empleado_tm.rfc as tm_rfc,  empleado_tm.curp as tm_curp,  empleado_tm.nombre as tm_nombre,  empleado_tm.puesto as tm_puesto,  empleado_tm.adcripcion as tm_adcripcion, empleado_tm.adcripcion_comision as tm_adcripcion_comision,  resguardo.id_empleado_tv,  empleado_tv.matricula as tv_matricula,  empleado_tv.rfc as tv_rfc,  empleado_tv.curp as tv_curp,  empleado_tv.nombre as tv_nombre,  empleado_tv.puesto as tv_puesto,  empleado_tv.adcripcion as tv_adcripcion, empleado_tv.adcripcion_comision as tv_adcripcion_comision FROM resguardo  INNER JOIN area ON resguardo.id_area = area.id_area INNER JOIN dependencia ON resguardo.id_dependencia = dependencia.id_dependencia  INNER JOIN periodo ON resguardo.id_periodo = periodo.id_periodo  INNER JOIN consecutivo ON resguardo.id_consecutivo = consecutivo.id_consecutivo  INNER JOIN empleado AS empleado_tm ON resguardo.id_empleado_tm = empleado_tm.id_empleado INNER JOIN empleado AS empleado_tv ON resguardo.id_empleado_tv = empleado_tv.id_empleado WHERE id_resguardo = %s", GetSQLValueString($colname_Resguardo, "int"));
$Resguardo = mysql_query($query_Resguardo, $SAG) or die(mysql_error());
$row_Resguardo = mysql_fetch_assoc($Resguardo);
$totalRows_Resguardo = mysql_num_rows($Resguardo);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<!--Inicio:  Bootstrap -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="../css/bootstrap.min.css" rel="stylesheet">
<title>Resguardos_detalle de Socios ASEM</title>
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

  <h1>Determinantes  de Consecutivos.</h1>
</blockquote>
<table width="500" border="0" class="btn-group-xs">
  <tr>
    <td width="90" align="left">Semestre: </td>
    <td width="210" align="left"><?php echo $row_Resguardo['semestre']; ?></td>
    <td width="300" align="left"><?php echo $row_Resguardo['id_resguardo']; ?></td>
  </tr>
  <tr>
    <td width="90" align="left">Fecha: </td>
    <td width="210" align="left"><?php echo $row_Resguardo['periodo_fecha']; ?></td>
    <td width="300" align="left">&nbsp;</td>
  </tr>
  <tr>
    <td width="90" align="left">Dependencia:</td>
    <td width="210" align="left">(<?php echo $row_Resguardo['clave_dependencia']; ?>)</td>
    <td width="300" align="left"><?php echo $row_Resguardo['depen_descripcion']; ?></td>
  </tr>
  <tr>
    <td width="90" align="left">Area:</td>
    <td width="210" align="left">(<?php echo $row_Resguardo['clave_area']; ?>)</td>
    <td width="300" align="left"><?php echo $row_Resguardo['des_area']; ?></td>
  </tr>
  <tr>
    <td width="90" align="left">1:</td>
    <td width="210" align="left">(<?php echo $row_Resguardo['tm_matricula']; ?>)</td>
    <td width="300" align="left"><?php echo $row_Resguardo['tm_nombre']; ?></td>
  </tr>
  <tr>
    <td width="90" align="left">2:</td>
    <td width="210" align="left">(<?php echo $row_Resguardo['tv_matricula']; ?>)</td>
    <td width="300" align="left"><?php echo $row_Resguardo['tv_nombre']; ?></td>
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
   <a href="determinantes_nuevo.php?id_resguardo=<?PHP echo $row_Resguardo['id_resguardo'];?>  ">
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
      <td><?php echo $row_Resguardos_detalle['id_resguardo_partidas']; ?></td>
      
      <td><?php echo $row_Resguardos_detalle['clave_determinante']; ?></td>
      <td><?php echo $row_Resguardos_detalle['comodato']; ?></td>
      <td><?php echo $row_Resguardos_detalle['descripcion']; ?></td>
      <td><?php echo $row_Resguardos_detalle['unidades']; ?></td>
      <td><?php echo $row_Resguardos_detalle['clave_estado_fisico']; ?></td>
      <td>
        
      <form id="form1" name="form1" method="post" action="">
        <label for="obs"></label>
        <textarea name="obs" id="obs" cols="45" rows="2"><?php echo $row_Resguardos_detalle['observaciones']; ?></textarea>
      </form></td>
      <td><a href="determinantes_editar.php?id_resguardo=<?PHP echo $row_Resguardo['id_resguardo'];?>&amp;id_resguardo_partidas= <?php echo $row_Resguardos_detalle['id_resguardo_partidas'];?> ">
        <button type="button" class="btn btn-success"> <span class="glyphicon glyphicon-pencil"></span>Editar </button>
      </a></td>
                <td><a href="determinantes_eliminar.php?id_resguardo=<?PHP echo $row_Resguardo['id_resguardo'];?>&amp;id_resguardo_partidas= <?php echo $row_Resguardos_detalle['id_resguardo_partidas'];?> "
onclick="return confirmar()">
        <button type="button" class="btn btn-danger"> <span class="glyphicon glyphicon-trash"></span> Eliminar </button>
      </a></td>  
      
      
    </tr>
    <?php } while ($row_Resguardos_detalle = mysql_fetch_assoc($Resguardos_detalle)); ?>
</table>

<a href="index.php">
   <button type="button" class="list-group-item-warning">
         <span class="glyphicon glyphicon-share-alt"></span> Regresar
</button>
</a>
</body>
</html>
<?php
mysql_free_result($Resguardos_detalle);

mysql_free_result($Resguardo);
?>
