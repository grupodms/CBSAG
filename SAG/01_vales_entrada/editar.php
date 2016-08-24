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


if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE  vale_entrada SET  id_vale_entrada_tipo=%s, id_periodo=%s, id_dependencia=%s, id_empleado_tm=%s, id_empleado_tv=%s, fecha=%s, numero_vale=%s, fecha_vale_traspaso=%s, numero_factura=%s, observaciones=%s, id_subdependencia=%s where id_vale_entrada=%s" ,
                
                GetSQLValueString($_POST['id_vale_entrada_tipo'], "int"),
                GetSQLValueString($_POST['id_periodo'], "int"),
                GetSQLValueString($_POST['id_dependencia'], "int"),
                GetSQLValueString($_POST['id_empleado_tm'], "int"),
                GetSQLValueString($_POST['id_empleado_tv'], "int"),
                GetSQLValueString($_POST['fecha'], "date"),
				GetSQLValueString($_POST['numero_vale'], "text"),
				GetSQLValueString($_POST['fecha_vale_traspaso'], "date"),
				GetSQLValueString($_POST['numero_factura'], "text"),
				GetSQLValueString($_POST['observaciones'], "text"),
				GetSQLValueString($_POST['id_subdependencia'], "int"),
				GetSQLValueString($_POST['id_vale_entrada'], "int")
					   );

 
  mysql_select_db($database_SAG, $SAG);
  $Result1 = mysql_query($updateSQL, $SAG) or die(mysql_error());

  $updateGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
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
$query_Area = sprintf("SELECT * FROM area WHERE id_dependencia = %s ORDER BY des_area ASC", GetSQLValueString($colname_Area, "int"));
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
$query_Consecutivo = sprintf("SELECT * FROM consecutivo WHERE id_dependencia = %s ORDER BY clave_conse ASC", GetSQLValueString($colname_Consecutivo, "int"));
$Consecutivo = mysql_query($query_Consecutivo, $SAG) or die(mysql_error());
$row_Consecutivo = mysql_fetch_assoc($Consecutivo);
$totalRows_Consecutivo = mysql_num_rows($Consecutivo);

$var_dep_TM = "-1";
if (isset($_COOKIE ["id_agrupador"])) {
  $var_dep_TM = $_COOKIE ["id_agrupador"];
}
mysql_select_db($database_SAG, $SAG);
$query_TM = sprintf("SELECT empleado.id_empleado, CONCAT(empleado.rfc,' | ',empleado.curp,' | ',empleado.matricula,' | ',empleado.nombre) AS lista FROM empleado WHERE id_dependencia = %s ORDER BY lista ASC", GetSQLValueString($var_dep_TM, "int"));
$TM = mysql_query($query_TM, $SAG) or die(mysql_error());
$row_TM = mysql_fetch_assoc($TM);
$totalRows_TM = mysql_num_rows($TM);

$var_dep_TV = "-1";
if (isset($_COOKIE ["id_agrupador"])) {
  $var_dep_TV = $_COOKIE ["id_agrupador"];
}
mysql_select_db($database_SAG, $SAG);
$query_TV = sprintf("SELECT empleado.id_empleado, CONCAT(empleado.rfc,' | ',empleado.curp,' | ',empleado.matricula,' | ',empleado.nombre) AS lista FROM empleado WHERE id_dependencia = %s ORDER BY lista ASC", GetSQLValueString($var_dep_TV, "int"));
$TV = mysql_query($query_TV, $SAG) or die(mysql_error());
$row_TV = mysql_fetch_assoc($TV);
$totalRows_TV = mysql_num_rows($TV);

$colname_vale_entrada = "-1";
if (isset($_GET['id_vale_entrada'])) {
  $colname_vale_entrada = $_GET['id_vale_entrada'];
}
mysql_select_db($database_SAG, $SAG);
$query_vale_entrada = sprintf("SELECT * FROM vale_entrada WHERE id_vale_entrada = %s", GetSQLValueString($colname_vale_entrada, "int"));
$vale_entrada = mysql_query($query_vale_entrada, $SAG) or die(mysql_error());
$row_vale_entrada = mysql_fetch_assoc($vale_entrada);
$totalRows_vale_entrada = mysql_num_rows($vale_entrada);

mysql_select_db($database_SAG, $SAG);
$query_vale_entrada_tipo = "SELECT * FROM vale_entrada_tipo ORDER BY clave_vale_entrada_tipo ASC";
$vale_entrada_tipo = mysql_query($query_vale_entrada_tipo, $SAG) or die(mysql_error());
$row_vale_entrada_tipo = mysql_fetch_assoc($vale_entrada_tipo);
$totalRows_vale_entrada_tipo = mysql_num_rows($vale_entrada_tipo);
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



<title>Editar Vale de Entrada</title>
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
  <h1>Editar   Vale de Entrada</h1>
  </p>

</blockquote>

<!--Fin:  Bootstrap -->
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <input type="hidden" name="id_vale_entrada" value="<?php echo $row_vale_entrada['id_vale_entrada']; ?>" />
  <table align="center" width="100%">
    <tr valign="baseline">
      <td colspan="2" align="right" nowrap="nowrap"><p align="right">Fecha:</p></td>
      <td colspan="2"><p align="left">
        <input name="fecha" type="text"
           class="alert-success" id="comodato_fecha5" value="<?php echo $row_vale_entrada['fecha']; ?>"readonly="readonly" />
      </p></td>
      <td><p align="right">Numero Vale:</p></td>
      <td><p align="left">
        <input name="numero_vale" type="text"
           id="numero_vale" value="<?php echo $row_vale_entrada['numero_vale']; ?>"  />
      </p></td>
      <td><p align="right">Fecha Vale :</p></td>
      <td><p align="left">
        <input name="fecha_vale_traspaso" type="text"
           class="alert-success" id="fecha_vale_traspaso" value="<?php echo $row_vale_entrada['fecha_vale_traspaso']; ?>" readonly="readonly" />
      </p></td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" align="right" nowrap="nowrap"><p align="right">Periodo:</p></td>
      <td colspan="2"><p align="left">
        <input name="id_periodo" 
       type="text" class="alert-success" 
       id="id_dependencia2" value="<?php echo $_COOKIE ["id_periodo"]; ?>" size="10" readonly="readonly" />
      </p></td>
      <td width="100"><p align="right">Tipo Vale :</p></td>
      <td width="121"><p align="left">
        <select name="id_vale_entrada_tipo" id="id_vale_entrada_tipo">
          <option value="0" <?php if (!(strcmp(0, $row_vale_entrada['id_vale_entrada_tipo']))) {echo "selected=\"selected\"";} ?>></option>
          <?php
do {  
?>
          <option value="<?php echo $row_vale_entrada_tipo['id_vale_entrada_tipo']?>"<?php if (!(strcmp($row_vale_entrada_tipo['id_vale_entrada_tipo'], $row_vale_entrada['id_vale_entrada_tipo']))) {echo "selected=\"selected\"";} ?>><?php echo $row_vale_entrada_tipo['descripcion_vale_entrada_tipo']?></option>
          <?php
} while ($row_vale_entrada_tipo = mysql_fetch_assoc($vale_entrada_tipo));
  $rows = mysql_num_rows($vale_entrada_tipo);
  if($rows > 0) {
      mysql_data_seek($vale_entrada_tipo, 0);
	  $row_vale_entrada_tipo = mysql_fetch_assoc($vale_entrada_tipo);
  }
?>
        </select>
      </p></td>
      <td width="102"><p align="right">Num.  Factura :</p></td>
      <td width="67"><p align="left">
        <input name="numero_factura" type="text"
            id="numero_factura" value="<?php echo $row_vale_entrada['numero_factura']; ?>" />
      </p></td>
      <td width="11">&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td width="59" align="right" nowrap="nowrap">&nbsp;</td>
      <td width="36"><p align="right">A.C. :</p></td>
      <td width="56"><p align="left">
        <input name="id_dependencia" type="text" class="alert-success" id="id_dependencia"
      value="<?php echo $row_vale_entrada['id_dependencia']; ?>" size="11" readonly="readonly" />
      </p></td>
      <td width="62">&nbsp;</td>
      <td><p align="right">SubDependencia:</p></td>
      <td colspan="2"><p align="left">
        <select name="id_subdependencia" id="id_subdependencia">
          <option value="0" <?php if (!(strcmp(0, $row_vale_entrada['id_dependencia']))) {echo "selected=\"selected\"";} ?>></option>
        </select>
        <label for="id_subdependencia"></label>
      </p></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap">&nbsp;</td>
      <td valign="top"><p align="right">Observaciones:</p></td>
      <td colspan="6"><p align="left">
        <textarea name="observaciones" id="observaciones" cols="120
      " rows="5"><?php echo $row_vale_entrada['observaciones']; ?></textarea>
      </p></td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap">1</td>
      <td><p align="right">RFC:</p></td>
      <td colspan="6" ><p align="left">
        <select name="id_empleado_tm" id="id_empleado_tm">
          <option value="0" <?php if (!(strcmp(0, $row_vale_entrada['id_empleado_tm']))) {echo "selected=\"selected\"";} ?>></option>
          <?php
do {  
?>
          <option value="<?php echo $row_TM['id_empleado']?>"<?php if (!(strcmp($row_TM['id_empleado'], $row_vale_entrada['id_empleado_tm']))) {echo "selected=\"selected\"";} ?>><?php echo $row_TM['lista']?></option>
          <?php
} while ($row_TM = mysql_fetch_assoc($TM));
  $rows = mysql_num_rows($TM);
  if($rows > 0) {
      mysql_data_seek($TM, 0);
	  $row_TM = mysql_fetch_assoc($TM);
  }
?>
        </select>
      </p></td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap">2</td>
      <td><p align="right"> RFC:</p></td>
      <td colspan="6"><p align="left">
        <select name="id_empleado_tv" id="id_empleado_tv">
          <option value="0" <?php if (!(strcmp(0, $row_vale_entrada['id_empleado_tv']))) {echo "selected=\"selected\"";} ?>></option>
          <?php
do {  
?>
          <option value="<?php echo $row_TV['id_empleado']?>"<?php if (!(strcmp($row_TV['id_empleado'], $row_vale_entrada['id_empleado_tv']))) {echo "selected=\"selected\"";} ?>><?php echo $row_TV['lista']?></option>
          <?php
} while ($row_TV = mysql_fetch_assoc($TV));
  $rows = mysql_num_rows($TV);
  if($rows > 0) {
      mysql_data_seek($TV, 0);
	  $row_TV = mysql_fetch_assoc($TV);
  }
?>
        </select>
      </p></td>
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
         value="Guardar Vale de Entrada" />
        </p>
        <!--Fin: Bootstrap --></td>
    </tr>
    <!--Fin: Bootstrap -->
  </table>
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

mysql_free_result($vale_entrada);

mysql_free_result($vale_entrada_tipo);
?>
