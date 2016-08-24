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

$aDep_vales_entrada = "-1";
if (isset($_COOKIE ['id_dependencia'])) {
  $aDep_vales_entrada = $_COOKIE ['id_dependencia'];
}
mysql_select_db($database_SAG, $SAG);
$query_vales_entrada = sprintf("SELECT vale_entrada.id_vale_entrada, vale_entrada.fecha, vale_entrada.id_periodo, periodo.semestre, vale_entrada.id_dependencia, dependencia.clave_dependencia, dependencia.depen_descripcion, vale_entrada.id_empleado_tm, empleado_tm.matricula AS tm_matricula, empleado_tm.rfc AS tm_rfc, empleado_tm.curp AS tm_curp, empleado_tm.nombre AS tm_nombre, empleado_tm.puesto AS tm_puesto, empleado_tm.adcripcion AS tm_adcripcion, empleado_tm.adcripcion_comision AS tm_adcripcion_comision, vale_entrada.id_empleado_tv, empleado_tv.matricula AS tv_matricula, empleado_tv.rfc AS tv_rfc, empleado_tv.curp AS tv_curp, empleado_tv.nombre AS tv_nombre, empleado_tv.puesto AS tv_puesto, empleado_tv.adcripcion AS tv_adcripcion, empleado_tv.adcripcion_comision AS tv_adcripcion_comision, vale_entrada.id_vale_entrada_tipo, vale_entrada_tipo.clave_vale_entrada_tipo, vale_entrada_tipo.descripcion_vale_entrada_tipo FROM vale_entrada INNER JOIN dependencia ON vale_entrada.id_dependencia = dependencia.id_dependencia INNER JOIN periodo ON vale_entrada.id_periodo = periodo.id_periodo INNER JOIN empleado AS empleado_tm ON vale_entrada.id_empleado_tm = empleado_tm.id_empleado INNER JOIN empleado AS empleado_tv ON vale_entrada.id_empleado_tv = empleado_tv.id_empleado INNER JOIN vale_entrada_tipo ON vale_entrada.id_vale_entrada_tipo = vale_entrada_tipo.id_vale_entrada_tipo WHERE vale_entrada.id_dependencia = %s ORDER BY vale_entrada.id_vale_entrada ASC, 	vale_entrada.id_periodo ASC ", GetSQLValueString($aDep_vales_entrada, "int"));
$vales_entrada = mysql_query($query_vales_entrada, $SAG) or die(mysql_error());
$row_vales_entrada = mysql_fetch_assoc($vales_entrada);
$totalRows_vales_entrada = mysql_num_rows($vales_entrada);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<!--Inicio:  Bootstrap -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="../css/bootstrap.min.css" rel="stylesheet">
<title>Vales de Entrada</title>
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
<?PHP require_once('../barra01.php'); ?>
<!--Menu -->

<!--Inicio:  Bootstrap -->
<blockquote>
  <p>
  
  <table width="100%" border="0">
  <tr>
    <td><h1>Vales de Entrada</h1> </td>
    </tr>
</table> 
  </p>
</blockquote>
<?php
function dias($fecha_i,$fecha_f)
{
	$dias	= (strtotime($fecha_i)-strtotime($fecha_f))/86400;
	//$dias =   abs($dias); 
	$dias = floor($dias);
	$dias++;
	return $dias;
}
$hoy = date("Y-m-d");

function estado_texto ($dias)
{
	$estado = "";
	if     ($dias <= 30)  
	       {$estado = "Vigente";}
	elseif (($dias >= 31) && ($dias <= 60))
	       {$estado = "Condicionado";}
	elseif ($dias >= 61)  
           {$estado = "Sin Servicio";}
	else
	  	   {$estado = " ";}
	return $estado;    
}           




?>
 <a href="nuevo.php">
  	             <button type="button" class="btn btn-success">
                         <span class="glyphicon glyphicon-pencil"></span>Nuevo
 </button>
</a>

<table width="100%" border="0" align="center" class="table table-hover">
    
  <tr class="info">
      <td>id</td>
      <td>Sem.</td>
      <td>Fecha:</td>
      <td>Fec_act:</td>
      <td>A.C.:</td>
      <td>Tipo de Vale:</td>
      <td>1.:</td>
      <td>2.:</td>
      <td colspan="4" align="center">Acciones</td>
    </tr>
<?php do { ?>    
    <tr>
      <td><?php echo $row_vales_entrada['id_vale_entrada']; ?></td>
      <td><?php echo $row_vales_entrada['semestre']; ?></td>
      <td>
<?php echo substr($row_vales_entrada['periodo_fecha'],8,2).
   "/".
   substr($row_vales_entrada['periodo_fecha'],5,2).
   "/".
   substr($row_vales_entrada['periodo_fecha'],0,4) ?>	  
</td>
      <td><?php echo substr($row_vales_entrada['fecha'],8,2).
   "/".
   substr($row_vales_entrada['fecha'],5,2).
   "/".
   substr($row_vales_entrada['fecha'],0,4) ?></td>
      <td><?php echo $row_vales_entrada['depen_descripcion']; ?></td>
      <td><?php echo $row_vales_entrada['clave_vale_entrada_tipo']; ?></td>
      <td><?php echo $row_vales_entrada['tm_nombre']; ?></td>
      <td><?php echo $row_vales_entrada['tv_nombre']; ?></td>
      <td><a href="editar.php?id_vale_entrada=<?PHP echo $row_vales_entrada['id_vale_entrada'];?>  ">
      
        <button type="button" class="btn btn-success"> <span class="glyphicon glyphicon-pencil"></span>Editar </button>
      </a></td>
      <td><a href="determinantes_index.php?id_vale_entrada=<?PHP echo $row_vales_entrada['id_vale_entrada'];?>  ">
        <button type="button" class="btn btn-primary"> <span class="glyphicon glyphicon-pencil"></span>Articulos </button>
      </a></td>
      <td><a href="imprimir.php?id_vale_entrada=<?PHP echo $row_vales_entrada['id_vale_entrada'];?>  ">
        <button type="button" class="btn progress-bar-success"> <span class="glyphicon glyphicon-pencil"></span>Vale </button>
      </a></td>
      <td><a href="eliminar.php?id_vale_entrada=<?PHP echo $row_vales_entrada['id_vale_entrada'];?>"
      onclick="return confirmar()">
        <button type="button" class="btn btn-danger"> <span class="glyphicon glyphicon-trash"></span> Eliminar </button>
      </a></td>
    </tr>

  <?php } while ($row_vales_entrada = mysql_fetch_assoc($vales_entrada)); ?>
 </table>  
</body>
</html>
<?php
mysql_free_result($vales_entrada);

mysql_free_result($Reg_Deter);

mysql_free_result($V_ASEM);
?>
