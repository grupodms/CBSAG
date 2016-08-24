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
$id_area = "-1";
if (isset($_GET['id_area'])) {
  $id_area = $_GET['id_area'];
}
$id_consecutivo = "-1";
if (isset($_GET['id_consecutivo'])) {
  $id_consecutivo = $_GET['id_consecutivo'];
}



$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
#
# Determinante  
#
$colname_Deter2 = "-1";
if (isset($_POST['id_determinante'])) {
  $colname_Deter2 = $_POST['id_determinante'];
}

mysql_select_db($database_SAG, $SAG);
$query_Deter2 = sprintf("SELECT * FROM determinantes WHERE id_determinantes = %s", GetSQLValueString($colname_Deter2, "int"));
$Deter2 = mysql_query($query_Deter2, $SAG) or die(mysql_error());
$row_Deter2 = mysql_fetch_assoc($Deter2);
$totalRows_Deter2 = mysql_num_rows($Deter2);

#--------

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO resguardo_partidas (id_resguardo, id_determinantes,clave_determinante, descripcion, cambs, unidades, id_estado_fisico, num_serie, entrada_vale, numero_inventario, observaciones, num_seriea, alta, baja) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_resguardo'], "int"),
                       GetSQLValueString($_POST['id_determinante'], "int"),

GetSQLValueString($row_Deter2['clave_determinante'], "text"),                       GetSQLValueString($row_Deter2['descripcion'], "text"),
                       GetSQLValueString($row_Deter2['cambs'], "text"),
                       GetSQLValueString($_POST['unidades'], "int"),
                       GetSQLValueString($_POST['id_estado_fisico'], "int"),
                       GetSQLValueString($_POST['num_serie'], "text"),
                       GetSQLValueString($_POST['entrada_vale'], "date"),
                       GetSQLValueString($_POST['numero_inventario'], "text"),
                       GetSQLValueString($_POST['observaciones'], "text"),
                       GetSQLValueString($_POST['num_seriea'], "text"),
                       GetSQLValueString(isset($_POST['alta']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['baja']) ? "true" : "", "defined","1","0"));

  mysql_select_db($database_SAG, $SAG);
  $Result1 = mysql_query($insertSQL, $SAG) or die(mysql_error());

  $insertGoTo = "determinantes_index.php?" . $row_Resguardo['id_resguardo'] . "=";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_SAG, $SAG);
$query_Determinantes = "SELECT * FROM determinantes ORDER BY clave_determinante ASC";
$Determinantes = mysql_query($query_Determinantes, $SAG) or die(mysql_error());
$row_Determinantes = mysql_fetch_assoc($Determinantes);
$totalRows_Determinantes = mysql_num_rows($Determinantes);

mysql_select_db($database_SAG, $SAG);
$query_estado_fisico = "SELECT * FROM estado_fisico ORDER BY clave_estado_fisico ASC";
$estado_fisico = mysql_query($query_estado_fisico, $SAG) or die(mysql_error());
$row_estado_fisico = mysql_fetch_assoc($estado_fisico);
$totalRows_estado_fisico = mysql_num_rows($estado_fisico);

$colname_Resguardo = "-1";
if (isset($_GET['id_resguardo'])) {
  $colname_Resguardo = $_GET['id_resguardo'];
}
mysql_select_db($database_SAG, $SAG);
$query_Resguardo = sprintf("SELECT resguardo.id_resguardo,  resguardo.fecha,  resguardo.id_periodo,  periodo.semestre,  resguardo.id_dependencia,  dependencia.clave_dependencia,  dependencia.depen_descripcion,  resguardo.id_area,  area.clave_area, area.des_area,  resguardo.id_consecutivo,  consecutivo.clave_conse,  consecutivo.descripcion_consecutivo,  resguardo.id_empleado_tm,  empleado_tm.matricula as tm_matricula,  empleado_tm.rfc as tm_rfc,  empleado_tm.curp as tm_curp,  empleado_tm.nombre as tm_nombre,  empleado_tm.puesto as tm_puesto,  empleado_tm.adcripcion as tm_adcripcion, empleado_tm.adcripcion_comision as tm_adcripcion_comision,  resguardo.id_empleado_tv,  empleado_tv.matricula as tv_matricula,  empleado_tv.rfc as tv_rfc,  empleado_tv.curp as tv_curp,  empleado_tv.nombre as tv_nombre,  empleado_tv.puesto as tv_puesto,  empleado_tv.adcripcion as tv_adcripcion, empleado_tv.adcripcion_comision as tv_adcripcion_comision FROM resguardo  INNER JOIN area ON resguardo.id_area = area.id_area INNER JOIN dependencia ON resguardo.id_dependencia = dependencia.id_dependencia  INNER JOIN periodo ON resguardo.id_periodo = periodo.id_periodo  INNER JOIN consecutivo ON resguardo.id_consecutivo = consecutivo.id_consecutivo  INNER JOIN empleado AS empleado_tm ON resguardo.id_empleado_tm = empleado_tm.id_empleado INNER JOIN empleado AS empleado_tv ON resguardo.id_empleado_tv = empleado_tv.id_empleado WHERE id_resguardo = %s", GetSQLValueString($colname_Resguardo, "int"));
$Resguardo = mysql_query($query_Resguardo, $SAG) or die(mysql_error());
$row_Resguardo = mysql_fetch_assoc($Resguardo);
$totalRows_Resguardo = mysql_num_rows($Resguardo);

$colname_Resguardo_detalle = "-1";
if (isset($_GET['id_resguardo'])) {
  $colname_Resguardo_detalle = $_GET['id_resguardo'];
}
mysql_select_db($database_SAG, $SAG);
$query_Resguardo_detalle = sprintf("SELECT * FROM resguardo_partidas WHERE id_resguardo = %s", GetSQLValueString($colname_Resguardo_detalle, "int"));
$Resguardo_detalle = mysql_query($query_Resguardo_detalle, $SAG) or die(mysql_error());
$row_Resguardo_detalle = mysql_fetch_assoc($Resguardo_detalle);
$totalRows_Resguardo_detalle = mysql_num_rows($Resguardo_detalle);


if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1122")) {
  $updateSQL = sprintf(
  "UPDATE asem SET  Ultimo_Pago_Fecha=%s, 
                    Ultimo_Fecha_Inicio=%s, 
					Ultimo_Fecha_Fin=%s 
					WHERE idasem=%s",
                       GetSQLValueString($_POST['fecha_pago'], "date"),
                       GetSQLValueString($_POST['Fecha_inicio'], "date"),
                       GetSQLValueString($_POST['Fecha_fin'], "date"),
                       GetSQLValueString($_POST['idasem'], "int"));

  mysql_select_db($database_Canainpa, $Canainpa);
  $Result1 = mysql_query($updateSQL, $Canainpa) or die(mysql_error());
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<!--Inicio:  Bootstrap -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="../css/bootstrap.min.css" rel="stylesheet">

<!-- bootstrap-datepicker --> 
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />


<title>Nuevo Pago de Socio de ASEM</title>
<!--Fin: Script Bootstrap --> 

</head>

<body>

<!--Inicio: Script Bootstrap -->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../js/bootstrap.min.js"></script>
<!--Script bootstrap-datepicker -->     
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>

<script>
$(function () {
$( "#date1picker" ).datepicker({
defaultDate: "",
numberOfMonths: 1,
dateFormat: 'yy-mm-dd',
});
});

$(function () {
$( "#date2picker" ).datepicker({
defaultDate: "",
numberOfMonths: 1,
dateFormat: 'yy-mm-dd',
});
});

$(function () {
$( "#date3picker" ).datepicker({
defaultDate: "",
numberOfMonths: 1,
dateFormat: 'yy-mm-dd',
});
});

</script>
<!--Fin: Script Bootstrap -->  

<!--Menu -->
<?PHP $menu = 1; ?>
<?PHP require_once('../barra01.php'); ?>
<!--Menu -->

<!--Inicio:  Bootstrap -->
<blockquote>
  <p>
  <h1>Nuevo Determinantes  de Consecutivos.</h1>
  </p>
</blockquote>
<table width="500" border="0" class="btn-group-xs">
  <tr>
    <td width="90" align="left">Semestre: </td>
    <td width="210" align="left"><?php echo $row_Resguardo['semestre']; ?></td>
    <td width="300" align="left">&nbsp;</td>
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
    <td width="90" align="left">TM:</td>
    <td width="210" align="left">(<?php echo $row_Resguardo['tm_matricula']; ?>)</td>
    <td width="300" align="left"><?php echo $row_Resguardo['tm_nombre']; ?></td>
  </tr>
  <tr>
    <td width="90" align="left">TV:</td>
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
<p> </p>
<?PHP echo "editFormAction  ".$editFormAction; ?>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1">
  <table align="center">

    <tr valign="baseline">
      <td nowrap="nowrap" align="right">id:</td>
      <td><input type="text" name="id_resguardo" value="<?php echo $row_Resguardo['id_resguardo']; ?>" size="32" 
                 readonly="readonly" 
                 id = "date1picker"
                 class="alert-success"  
           /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Determinante:</td>
      <td><label for="id_determinante"></label>
        <select name="id_determinante" id="id_determinante">
          <?php
do {  
?>
          <option value="<?php echo $row_Determinantes['id_determinantes']?>"><?php echo  $row_Determinantes['clave_determinante']." (".
$row_Determinantes['comodato']. ") ".
substr($row_Determinantes['descripcion'],1,50)		   ?></option>
          <?php
} while ($row_Determinantes = mysql_fetch_assoc($Determinantes));
  $rows = mysql_num_rows($Determinantes);
  if($rows > 0) {
      mysql_data_seek($Determinantes, 0);
	  $row_Determinantes = mysql_fetch_assoc($Determinantes);
  }
?>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Unidades:</td>
      <td><input type="text" name="unidades" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Estado Fisico:</td>
      <td><label for="id_estado_fisico"></label>
        <select name="id_estado_fisico" id="id_estado_fisico">
          <?php
do {  
?>
          <option value="<?php echo $row_estado_fisico['id_estado_fisico']?>"><?php echo "(". $row_estado_fisico['clave_estado_fisico'].")". $row_estado_fisico['descripcion_estado_fisico']?></option>
          <?php
} while ($row_estado_fisico = mysql_fetch_assoc($estado_fisico));
  $rows = mysql_num_rows($estado_fisico);
  if($rows > 0) {
      mysql_data_seek($estado_fisico, 0);
	  $row_estado_fisico = mysql_fetch_assoc($estado_fisico);
  }
?>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Numero serie:</td>
      <td><input name="num_serie" type="text" id="num_serie" value="" size="32" /></td>
    </tr>

    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Numero de vale entrada:</td>
      <td><input name="entrada_vale" type="text" id="entrada_vale" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Numero inventario:</td>
      <td><input name="numero_inventario" type="text" id="numero_inventario" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap">observaciones:</td>
      <td><label for="observaciones"></label>
      <textarea name="observaciones" id="observaciones" cols="45" rows="5"></textarea></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Num. serie 2:</td>
      <td><input name="num_seriea" type="text" id="num_seriea" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">alta:</td>
      <td><input type="checkbox" name="alta" id="alta" />
      <label for="alta"></label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">baja:</td>
      <td><input type="checkbox" name="baja" id="baja" /></td>
    </tr>                

    <!--Inicio: Bootstrap -->
    <Tr>



    <!--Inicio: Bootstrap -->
    <Tr>
      <td colspan="2" align="center" nowrap="nowrap">
        <!--Inicio: Bootstrap -->
        <P>&nbsp;  </P>
        <input type="submit" 
         class="btn btn-success" 
         value="Insertar registro" />
        <!--Fin: Bootstrap -->      </td>
     </Tr>  
     
     
     
     
     <!--Fin: Bootstrap --> 


  </table>
  <input type="hidden" name="idasem" />


  <input type="hidden" name="idasem_pagos" value="" />
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="MM_insert" value="form1" />
</form>

<a href="index2.php?id_resguardo=<?php echo $row_Resguardo['id_resguardo']; ?>&id_area=<?PHP echo $id_area;?>&id_consecutivo=<?PHP echo $id_consecutivo; ?>">
<button type="button" class="list-group-item-warning">
<span class="glyphicon glyphicon-share-alt"></span> Regresar
</button>
</a>
<p>&nbsp;</p>
<p>&nbsp;</p>

</body>
</html>
<?php
mysql_free_result($Determinantes);

mysql_free_result($estado_fisico);

mysql_free_result($Resguardo);

mysql_free_result($Resguardo_detalle);

mysql_free_result($Deter2);
?>
