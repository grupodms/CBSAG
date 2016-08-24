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
$adm_Usuario    = $_COOKIE ["usuario_global"]; 
$id_periodo     = $_COOKIE ["id_periodo"]; 
$id_dependencia = $_COOKIE ["id_dependencia"];
$id_agrupador   = $_COOKIE ["id_agrupador"]; 

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE resguardo SET id_periodo=%s, id_dependencia=%s, id_area=%s, id_consecutivo=%s, id_empleado_tm=%s, id_empleado_tv=%s, fecha=%s WHERE id_resguardo=%s",
                       GetSQLValueString($_POST['id_periodo'], "int"),
                       GetSQLValueString($_POST['a_c'], "int"),
                       GetSQLValueString($_POST['area'], "int"),
                       GetSQLValueString($_POST['consecutivo'], "int"),
                       GetSQLValueString($_POST['rfc_tm'], "int"),
                       GetSQLValueString($_POST['rfc_tv'], "int"),
                       GetSQLValueString($_POST['fecha'], "date"),
                       GetSQLValueString($_POST['id_resguardo'], "int"));

  mysql_select_db($database_SAG, $SAG);
  $Result1 = mysql_query($updateSQL, $SAG) or die(mysql_error());

  $updateGoTo = "index2.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}


mysql_select_db($database_SAG, $SAG);
$query_Reg_Tipo_Dererminante = "SELECT * FROM determinante_tipo ORDER BY deter_descripcion ASC";
$Reg_Tipo_Dererminante = mysql_query($query_Reg_Tipo_Dererminante, $SAG) or die(mysql_error());
$row_Reg_Tipo_Dererminante = mysql_fetch_assoc($Reg_Tipo_Dererminante);
$totalRows_Reg_Tipo_Dererminante = mysql_num_rows($Reg_Tipo_Dererminante);

mysql_select_db($database_SAG, $SAG);
$query_periodo = "SELECT * FROM `periodo` WHERE cierre = 0 and activo = 1 and activo_fijo =0 ORDER BY semestre ASC";
$periodo = mysql_query($query_periodo, $SAG) or die(mysql_error());
$row_periodo = mysql_fetch_assoc($periodo);
$totalRows_periodo = mysql_num_rows($periodo);

$colname_Area = "-1";
if (isset($_COOKIE ["id_dependencia"])) {
  $colname_Area = $_COOKIE ["id_dependencia"];
}
mysql_select_db($database_SAG, $SAG);
$query_Area = sprintf("SELECT *,CONCAT(area.clave_area,' | ',area.des_area) AS lista FROM area WHERE id_dependencia = %s ORDER BY des_area ASC", GetSQLValueString($colname_Area, "int"));
$Area = mysql_query($query_Area, $SAG) or die(mysql_error());
$row_Area = mysql_fetch_assoc($Area);
$totalRows_Area = mysql_num_rows($Area);

mysql_select_db($database_SAG, $SAG);
$query_Dependencia = "SELECT * FROM dependencia";
$Dependencia = mysql_query($query_Dependencia, $SAG) or die(mysql_error());
$row_Dependencia = mysql_fetch_assoc($Dependencia);
$totalRows_Dependencia = mysql_num_rows($Dependencia);

$colname_Consecutivo = "-1";
if (isset($_COOKIE ["id_dependencia"])) {
  $colname_Consecutivo = $_COOKIE ["id_dependencia"];
}
mysql_select_db($database_SAG, $SAG);
$query_Consecutivo = sprintf("SELECT *,CONCAT(consecutivo.clave_conse,' | ',consecutivo.descripcion_consecutivo) AS lista FROM consecutivo WHERE id_dependencia = %s ORDER BY clave_conse ASC", GetSQLValueString($colname_Consecutivo, "int"));
$Consecutivo = mysql_query($query_Consecutivo, $SAG) or die(mysql_error());
$row_Consecutivo = mysql_fetch_assoc($Consecutivo);
$totalRows_Consecutivo = mysql_num_rows($Consecutivo);

$var_dep_TM = "-1";
if (isset($_COOKIE ["id_agrupador"])) {
  $var_dep_TM = $_COOKIE ["id_agrupador"];
}
mysql_select_db($database_SAG, $SAG);
$query_TM = sprintf("SELECT empleado.id_empleado, CONCAT(empleado.rfc,' | ',empleado.curp,' | ',empleado.matricula,' | ',empleado.nombre) AS lista FROM empleado WHERE id_agrupador = %s ORDER BY lista ASC", GetSQLValueString($var_dep_TM, "int"));
$TM = mysql_query($query_TM, $SAG) or die(mysql_error());
$row_TM = mysql_fetch_assoc($TM);
$totalRows_TM = mysql_num_rows($TM);

$var_dep_TV = "-1";
if (isset($_COOKIE ["id_agrupador"])) {
  $var_dep_TV = $_COOKIE ["id_agrupador"];
}
mysql_select_db($database_SAG, $SAG);
$query_TV = sprintf("SELECT empleado.id_empleado, CONCAT(empleado.rfc,' | ',empleado.curp,' | ',empleado.matricula,' | ',empleado.nombre) AS lista FROM empleado WHERE id_agrupador = %s ORDER BY lista ASC", GetSQLValueString($var_dep_TV, "int"));
$TV = mysql_query($query_TV, $SAG) or die(mysql_error());
$row_TV = mysql_fetch_assoc($TV);
$totalRows_TV = mysql_num_rows($TV);

$colname_Resguardo = "-1";
if (isset($_GET['id_resguardo'])) {
  $colname_Resguardo = $_GET['id_resguardo'];
}
mysql_select_db($database_SAG, $SAG);
$query_Resguardo = sprintf("SELECT * FROM resguardo WHERE id_resguardo = %s", GetSQLValueString($colname_Resguardo, "int"));
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
<!--Fin: Script Bootstrap --> 

<!--Inicio:  Fecha-->
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
 <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
 <link rel="stylesheet" href="/resources/demos/style.css">
<script>
$(document).ready(function () {
    var date = new Date();
    var currentMonth = date.getMonth();
    var currentDate = date.getDate();
    var currentYear = date.getFullYear();

    $('#comodato_fecha').datepicker({
        minDate: new Date(currentYear, currentMonth, currentDate),
        dateFormat: 'yy-mm-dd'
    });
});
$(document).ready(function () {
    var date = new Date();
    var currentMonth = date.getMonth();
    var currentDate = date.getDate();
    var currentYear = date.getFullYear();

    $('#donacion_fecha').datepicker({
        minDate: new Date(currentYear, currentMonth, currentDate),
        dateFormat: 'yy-mm-dd'
    });
});
</script>
<!--Fin:    Fecha -->



<title>Editar Socio Asem</title>
</head>
<body>
<!--Inicio: Script Bootstrap -->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../js/bootstrap.min.js"></script>

<script type="text/javascript" src="../js/bootstrap-datepicker.js"></script>

<!--Fin: Script Bootstrap -->  

<!--Menu -->
<?PHP $menu = 1; 
$hoy = date("y") . "/" . date("m") . "/" . date("d");
?>
<?PHP require_once('../barra01.php'); ?>
<!--Menu -->


<!--Inicio:  Bootstrap -->
<blockquote>
  <p>
  <h1>Editar  Consecutivos</h1>
  </p>

</blockquote>

<!--Fin:  Bootstrap -->
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <input type="hidden" name="id_resguardo" value="<?php echo $row_Resguardo['id_resguardo']; ?>" />
  <table align="center" width="100%">
    <tr valign="baseline">
      <td colspan="2" align="right" nowrap="nowrap">Fecha:</td>
      <td colspan="2"><input name="fecha" type="text"
           class="alert-success" id="comodato_fecha5" value="<?php echo $hoy; ?>"readonly="readonly" /></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" align="right" nowrap="nowrap">Periodo:</td>
      <td colspan="2"><p>
        <label for="id_periodo"></label>
        <input name="id_periodo" type="text" class="alert-success" id="id_periodo" value="<?php echo $row_Resguardo['id_periodo']; ?>" size="11" readonly="readonly" />
      </p></td>
      <td width="118">&nbsp;</td>
      <td width="80">&nbsp;</td>
      <td width="248">&nbsp;</td>
      <td width="24">&nbsp;</td>
      <td width="24">&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td width="10%" align="right" nowrap="nowrap">&nbsp;</td>
      <td width="45">A.C. :</td>
      <td width="41"><label for="a_c"></label>
      <input name="a_c" type="text" id="a_c" value="<?php echo $row_Resguardo['id_dependencia']; ?>" size="3" readonly="readonly" /></td>
      <td width="75">Area:</td>
      <td><select name="area">
        <?php
do {  
?>
        <option value="<?php echo $row_Area['id_area']?>"<?php if (!(strcmp($row_Area['id_area'], $row_Resguardo['id_area']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Area['lista']?></option>
        <?php
} while ($row_Area = mysql_fetch_assoc($Area));
  $rows = mysql_num_rows($Area);
  if($rows > 0) {
      mysql_data_seek($Area, 0);
	  $row_Area = mysql_fetch_assoc($Area);
  }
?>
      </select></td>
      <td>Consecutivo:</td>
      <td><select name="consecutivo">
        <?php
do {  
?>
        <option value="<?php echo $row_Consecutivo['id_consecutivo']?>"<?php if (!(strcmp($row_Consecutivo['id_consecutivo'], $row_Resguardo['id_consecutivo']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Consecutivo['lista']?></option>
        <?php
} while ($row_Consecutivo = mysql_fetch_assoc($Consecutivo));
  $rows = mysql_num_rows($Consecutivo);
  if($rows > 0) {
      mysql_data_seek($Consecutivo, 0);
	  $row_Consecutivo = mysql_fetch_assoc($Consecutivo);
  }
?>
      </select></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap">1</td>
      <td>RFC:</td>
      <td colspan="5"><select name="rfc_tm">
        <option value="0" <?php if (!(strcmp(0, $row_Resguardo['id_empleado_tm']))) {echo "selected=\"selected\"";} ?>> </option>
        <?php
do {  
?>
        <option value="<?php echo $row_TM['id_empleado']?>"<?php if (!(strcmp($row_TM['id_empleado'], $row_Resguardo['id_empleado_tm']))) {echo "selected=\"selected\"";} ?>><?php echo $row_TM['lista']?></option>
        <?php
} while ($row_TM = mysql_fetch_assoc($TM));
  $rows = mysql_num_rows($TM);
  if($rows > 0) {
      mysql_data_seek($TM, 0);
	  $row_TM = mysql_fetch_assoc($TM);
  }
?>
      </select></td>
      <td><?PHP //echo "TM = ".$query_TM; ?></td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap">2</td>
      <td>RFC:</td>
      <td colspan="5"><select name="rfc_tv">
        <option value="0" <?php if (!(strcmp(0, $row_Resguardo['id_empleado_tv']))) {echo "selected=\"selected\"";} ?>> </option>
        <?php
do {  
?>
        <option value="<?php echo $row_TV['id_empleado']?>"<?php if (!(strcmp($row_TV['id_empleado'], $row_Resguardo['id_empleado_tv']))) {echo "selected=\"selected\"";} ?>><?php echo $row_TV['lista']?></option>
        <?php
} while ($row_TV = mysql_fetch_assoc($TV));
  $rows = mysql_num_rows($TV);
  if($rows > 0) {
      mysql_data_seek($TV, 0);
	  $row_TV = mysql_fetch_assoc($TV);
  }
?>
      </select></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <!--Inicio: Bootstrap -->
    <tr>
      <td colspan="9" align="center" nowrap="nowrap"><p>
        <!--Inicio: Bootstrap -->
      </p>
        <p>
          <input type="submit" 
         class="btn btn-success" 
         value="Actualizar Consecutivo" />
        </p>
        <!--Fin: Bootstrap --></td>
    </tr>
    <!--Fin: Bootstrap -->
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
  <input type="hidden" name="MM_update" value="form1" />
</form>
<a href="index.php">
   <button type="button" class="list-group-item-warning">
         <span class="glyphicon glyphicon-share-alt"></span> Regresar
</button>
</a>
</body>
</html>
<?php
mysql_free_result($Reg_Tipo_Dererminante);

mysql_free_result($Consecutivo);

mysql_free_result($Reg_Det);

mysql_free_result($Reg_Tipo_Dererminante);

mysql_free_result($periodo);

mysql_free_result($Area);

mysql_free_result($Dependencia);

mysql_free_result($Consecutivo);

mysql_free_result($TM);

mysql_free_result($TV);

mysql_free_result($Resguardo);
?>
