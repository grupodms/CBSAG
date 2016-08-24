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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE resguardo_partidas SET id_resguardo=%s  WHERE id_resguardo_partidas=%s",
                       GetSQLValueString($_POST['id_resguardo'], "int"),
                       GetSQLValueString($_POST['id_resguardo_partidas'], "int"));

  mysql_select_db($database_SAG, $SAG);
  $Result1 = mysql_query($updateSQL, $SAG) or die(mysql_error());

  $updateGoTo = "index2.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}


$colname_Determinantes = "-1";
if (isset($_GET['id_determinantes'])) {
  $colname_Determinantes = $_GET['id_determinantes'];
}
mysql_select_db($database_SAG, $SAG);
$query_Determinantes = sprintf("SELECT * FROM determinantes WHERE id_determinantes = %s ORDER BY clave_determinante ASC", GetSQLValueString($colname_Determinantes, "int"));
$Determinantes = mysql_query($query_Determinantes, $SAG) or die(mysql_error());
$row_Determinantes = mysql_fetch_assoc($Determinantes);
$totalRows_Determinantes = mysql_num_rows($Determinantes);

$colname_estado_fisico = "-1";
if (isset($_GET['id_estado_fisico'])) {
  $colname_estado_fisico = $_GET['id_estado_fisico'];
}
mysql_select_db($database_SAG, $SAG);
$query_estado_fisico = sprintf("SELECT * FROM estado_fisico WHERE id_estado_fisico = %s ORDER BY clave_estado_fisico ASC", GetSQLValueString($colname_estado_fisico, "int"));
$estado_fisico = mysql_query($query_estado_fisico, $SAG) or die(mysql_error());
$row_estado_fisico = mysql_fetch_assoc($estado_fisico);
$totalRows_estado_fisico = mysql_num_rows($estado_fisico);

$colname_Resguardo = "-1";
if (isset($_GET['id_resguardo'])) {
  $colname_Resguardo = $_GET['id_resguardo'];
}
mysql_select_db($database_SAG, $SAG);
$query_Resguardo = sprintf("SELECT resguardo.id_resguardo,  resguardo.fecha,  resguardo.id_periodo,  periodo.semestre,  resguardo.id_dependencia,  dependencia.clave_dependencia,  dependencia.depen_descripcion,  resguardo.id_area,  area.clave_area, area.des_area,  resguardo.id_consecutivo,  consecutivo.clave_conse,  consecutivo.descripcion_consecutivo,  resguardo.id_empleado_tm,  empleado_tm.matricula as tm_matricula,  empleado_tm.rfc as tm_rfc,  empleado_tm.curp as tm_curp,  empleado_tm.nombre as tm_nombre,  empleado_tm.puesto as tm_puesto,  empleado_tm.adcripcion as tm_adcripcion,   resguardo.id_empleado_tv,  empleado_tv.matricula as tv_matricula,  empleado_tv.rfc as tv_rfc,  empleado_tv.curp as tv_curp,  empleado_tv.nombre as tv_nombre,  empleado_tv.puesto as tv_puesto,  empleado_tv.adcripcion as tv_adcripcion FROM resguardo  INNER JOIN area ON resguardo.id_area = area.id_area INNER JOIN dependencia ON resguardo.id_dependencia = dependencia.id_dependencia  INNER JOIN periodo ON resguardo.id_periodo = periodo.id_periodo  INNER JOIN consecutivo ON resguardo.id_consecutivo = consecutivo.id_consecutivo  INNER JOIN empleado AS empleado_tm ON resguardo.id_empleado_tm = empleado_tm.id_empleado INNER JOIN empleado AS empleado_tv ON resguardo.id_empleado_tv = empleado_tv.id_empleado WHERE id_resguardo = %s", GetSQLValueString($colname_Resguardo, "int"));
$Resguardo = mysql_query($query_Resguardo, $SAG) or die(mysql_error());
$row_Resguardo = mysql_fetch_assoc($Resguardo);
$totalRows_Resguardo = mysql_num_rows($Resguardo);

$colname_Resguardo_detalle = "-1";
if (isset($_GET['id_resguardo_partidas'])) {
  $colname_Resguardo_detalle = $_GET['id_resguardo_partidas'];
}
mysql_select_db($database_SAG, $SAG);
$query_Resguardo_detalle = sprintf("SELECT * FROM resguardo_partidas WHERE id_resguardo_partidas = %s", GetSQLValueString($colname_Resguardo_detalle, "int"));
$Resguardo_detalle = mysql_query($query_Resguardo_detalle, $SAG) or die(mysql_error());
$row_Resguardo_detalle = mysql_fetch_assoc($Resguardo_detalle);
$totalRows_Resguardo_detalle = mysql_num_rows($Resguardo_detalle);

$adm_Usuario    = $_COOKIE ["usuario_global"]; 
$id_periodo     = $_COOKIE ["id_periodo"]; 
$id_dependencia = $_COOKIE ["id_dependencia"];
$id_agrupador   = $_COOKIE ["id_agrupador"]; 

$colname_Listado_resguardo = "-1";
if (isset($_COOKIE ["id_dependencia"])) {
  $colname_Listado_resguardo = $_COOKIE ["id_dependencia"];
}
$colname2_Listado_resguardo = "-1";
if (isset($_COOKIE ["id_periodo"])) {
  $colname2_Listado_resguardo = $_COOKIE ["id_periodo"];
}
mysql_select_db($database_SAG, $SAG);
$query_Listado_resguardo = sprintf("SELECT resguardo.id_resguardo, resguardo.id_periodo, resguardo.id_area, resguardo.id_consecutivo, resguardo.id_empleado_tm, resguardo.id_empleado_tv, resguardo.fecha, periodo.semestre, dependencia.clave_dependencia, area.clave_area, consecutivo.clave_conse,CONCAT(resguardo.id_resguardo,' | ',dependencia.clave_dependencia,' | ',area.clave_area,' | ',consecutivo.clave_conse) As DescResg FROM resguardo INNER JOIN periodo ON resguardo.id_periodo = periodo.id_periodo INNER JOIN dependencia ON dependencia.id_dependencia = resguardo.id_dependencia INNER JOIN area ON area.id_area = resguardo.id_area INNER JOIN consecutivo ON resguardo.id_consecutivo = consecutivo.id_consecutivo WHERE resguardo.id_dependencia = %s and resguardo.id_periodo = %s ORDER BY area.clave_area ASC, consecutivo.clave_conse ASC", GetSQLValueString($colname_Listado_resguardo, "int"),GetSQLValueString($colname2_Listado_resguardo, "int"));
$Listado_resguardo = mysql_query($query_Listado_resguardo, $SAG) or die(mysql_error());
$row_Listado_resguardo = mysql_fetch_assoc($Listado_resguardo);
$totalRows_Listado_resguardo = mysql_num_rows($Listado_resguardo);



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
  <h1>Traspaso  Determinantes  de Consecutivo Resguardo a otro.</h1>
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
<p> </p>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1">
  <table align="center">

    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><p>Resguardo Cambiar: <br />
      (NumRes, AC, Area, Conse)</p></td>
      <td><input type="text" name="id_resguardo2" value="<?php echo $row_Resguardo['id_resguardo']; ?>" size="5" 
                 readonly="readonly" 
                 id = "date1picker"
                 class="alert-success"  
           /><br /> <select name="id_resguardo">
        <?php
do {  
?>
        <option value="<?php echo $row_Listado_resguardo['id_resguardo']?>"<?php if (!(strcmp($row_Listado_resguardo['id_resguardo'], $row_Resguardo_detalle['id_resguardo']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Listado_resguardo['DescResg']?></option>
        <?php
} while ($row_Listado_resguardo = mysql_fetch_assoc($Listado_resguardo));
  $rows = mysql_num_rows($Listado_resguardo);
  if($rows > 0) {
      mysql_data_seek($Listado_resguardo, 0);
	  $row_Listado_resguardo = mysql_fetch_assoc($Listado_resguardo);
  }
?>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">id:</td>
      <td><input type="text" name="id_resguardo_partidas" value="<?php echo $row_Resguardo_detalle['id_resguardo_partidas']; ?>" size="5" 
                 readonly="readonly" 
                 id = "date1picker2"
                 class="alert-success"  
           /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Determinante:</td>
      <td><label for="id_determinante"></label>
      <input name="id_determinante" type="text" id="id_determinante" value="<?php echo $row_Resguardo_detalle['id_determinantes']; ?>" size="6" readonly="readonly" />
     &nbsp;<?php echo $row_Resguardo_detalle['clave_determinante']; ?><br />
     <?php echo $row_Resguardo_detalle['descripcion']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Unidades:</td>
      <td><input name="unidades" type="text" value="<?php echo $row_Resguardo_detalle['unidades']; ?>" size="32" readonly="readonly" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Estado Fisico:</td>
      <td><label for="id_estado_fisico"></label>
        <label for="id_estado_fisico2"></label>
      <input name="id_estado_fisico" type="text" id="id_estado_fisico2" value="<?php echo $row_Resguardo_detalle['id_estado_fisico']; ?>" size="6" readonly="readonly" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Numero serie:</td>
      <td><input name="num_serie" type="text" id="num_serie" value="<?php echo $row_Resguardo_detalle['num_serie']; ?>" size="32" readonly="readonly" /></td>
    </tr>

    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Numero de vale entrada:</td>
      <td><input name="entrada_vale" type="text" id="entrada_vale" value="<?php echo $row_Resguardo_detalle['entrada_vale']; ?>" size="32" readonly="readonly" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Numero inventario:</td>
      <td><input name="numero_inventario" type="text" id="numero_inventario" value="<?php echo $row_Resguardo_detalle['numero_inventario']; ?>" size="32" readonly="readonly" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap">observaciones:</td>
      <td><label for="observaciones"></label>
      <textarea name="observaciones" cols="45" rows="5" readonly="readonly" id="observaciones"><?php echo $row_Resguardo_detalle['observaciones']; ?></textarea></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Num. serie 2:</td>
      <td><input name="num_seriea" type="text" id="num_seriea" value="<?php echo $row_Resguardo_detalle['num_seriea']; ?>" size="32" readonly="readonly" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">alta:</td>
      <td><label for="alta2"></label>
      <input name="alta" type="text" id="alta2" value="<?php echo $row_Resguardo_detalle['alta']; ?>" size="2" readonly="readonly" />        <label for="alta"></label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">baja:</td>
      <td><label for="baja"></label>
      <input name="baja" type="text" id="baja" value="<?php echo $row_Resguardo_detalle['baja']; ?>" size="2" readonly="readonly" /></td>
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
         value="Guardar registro" />
        <!--Fin: Bootstrap -->      </td>
     </Tr>  
     
     
     
     
     <!--Fin: Bootstrap --> 


  </table>
  <input type="hidden" name="MM_update" value="form1" />
</form>

<a href="determinantes_index.php?<?php echo $row_Resguardo['id_resguardo']; ?>=">
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

mysql_free_result($Listado_resguardo);
?>
