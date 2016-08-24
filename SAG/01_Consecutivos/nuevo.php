<?php require_once('../../Connections/SAG.php'); ?>
<?php require_once('../../Connections/SAG.php'); ?>
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO resguardo (id_periodo, id_dependencia, id_area, id_consecutivo, id_empleado_tm, id_empleado_tv, fecha) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['Periodo'], "int"),
                       GetSQLValueString($_POST['a_c'], "int"),
                       GetSQLValueString($_POST['area'], "int"),
                       GetSQLValueString($_POST['consecutivo'], "int"),
                       GetSQLValueString($_POST['rfc_tm'], "int"),
                       GetSQLValueString($_POST['rfc_tv'], "int"),
                       GetSQLValueString($_POST['fecha'], "date"));

  mysql_select_db($database_SAG, $SAG);
  $Result1 = mysql_query($insertSQL, $SAG) or die(mysql_error());

  $insertGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
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

mysql_select_db($database_SAG, $SAG);
$query_Reg_tipo_determinante = "SELECT * FROM determinante_tipo ORDER BY deter_descripcion ASC";
$Reg_tipo_determinante = mysql_query($query_Reg_tipo_determinante, $SAG) or die(mysql_error());
$row_Reg_tipo_determinante = mysql_fetch_assoc($Reg_tipo_determinante);
$totalRows_Reg_tipo_determinante = mysql_num_rows($Reg_tipo_determinante);

mysql_select_db($database_SAG, $SAG);
$query_AC = "SELECT * FROM dependencia ORDER BY clave_dependencia ASC";
$AC = mysql_query($query_AC, $SAG) or die(mysql_error());
$row_AC = mysql_fetch_assoc($AC);
$totalRows_AC = mysql_num_rows($AC);

mysql_select_db($database_SAG, $SAG);
$query_area = "SELECT * FROM area ORDER BY clave_area ASC";
$area = mysql_query($query_area, $SAG) or die(mysql_error());
$row_area = mysql_fetch_assoc($area);
$totalRows_area = mysql_num_rows($area);

mysql_select_db($database_SAG, $SAG);
$query_consecutivo = "SELECT * FROM consecutivo ORDER BY clave_conse ASC";
$consecutivo = mysql_query($query_consecutivo, $SAG) or die(mysql_error());
$row_consecutivo = mysql_fetch_assoc($consecutivo);
$totalRows_consecutivo = mysql_num_rows($consecutivo);

mysql_select_db($database_SAG, $SAG);
$query_TM = "SELECT * FROM empleado ORDER BY rfc ASC";
$TM = mysql_query($query_TM, $SAG) or die(mysql_error());
$row_TM = mysql_fetch_assoc($TM);
$totalRows_TM = mysql_num_rows($TM);

mysql_select_db($database_SAG, $SAG);
$query_TV = "SELECT * FROM empleado ORDER BY rfc ASC";
$TV = mysql_query($query_TV, $SAG) or die(mysql_error());
$row_TV = mysql_fetch_assoc($TV);
$totalRows_TV = mysql_num_rows($TV);

mysql_select_db($database_SAG, $SAG);
$query_Periodo = "SELECT * FROM `periodo` where cierre = 0 and activo = 1 and activo_fijo =0 ORDER BY semestre ASC";
$Periodo = mysql_query($query_Periodo, $SAG) or die(mysql_error());
$row_Periodo = mysql_fetch_assoc($Periodo);
$totalRows_Periodo = mysql_num_rows($Periodo);
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


<title>Nuevo Socio de ASEM</title>
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
$( "#comodato_fecha" ).datepicker({
defaultDate: "",
numberOfMonths: 1,
dateFormat: 'yy-mm-dd',
});
});

$(function () {
$( "#donacion_fecha" ).datepicker({
defaultDate: "",
numberOfMonths: 1,
dateFormat: 'yy-mm-dd',
});
});
</script>
<!--Fin: Script Bootstrap -->  

<!--Menu -->
<?PHP 
$menu = 1; 
$hoy = date("y") . "/" . date("m") . "/" . date("d");
?>
<?PHP require_once('../barra01.php'); ?>
<!--Menu -->

<!--Inicio:  Bootstrap -->

<blockquote>
  <p>
  <h1>Nuevo Consecutivo.</h1>
  </p>
</blockquote>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1">
<input type="hidden" name="id_determinantes" value="" />
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
        <select name="Periodo" id="Periodo">
          <?php
do {  
?>
          <option value="<?php echo $row_Periodo['id_periodo']?>"><?php echo $row_Periodo['semestre']?></option>
          <?php
} while ($row_Periodo = mysql_fetch_assoc($Periodo));
  $rows = mysql_num_rows($Periodo);
  if($rows > 0) {
      mysql_data_seek($Periodo, 0);
	  $row_Periodo = mysql_fetch_assoc($Periodo);
  }
?>
        </select>
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
      <td width="41"><select name="a_c">
        <?php
do {  
?>
        <option value="<?php echo $row_AC['id_dependencia']?>"><?php echo $row_AC['depen_descripcion']?></option>
        <?php
} while ($row_AC = mysql_fetch_assoc($AC));
  $rows = mysql_num_rows($AC);
  if($rows > 0) {
      mysql_data_seek($AC, 0);
	  $row_AC = mysql_fetch_assoc($AC);
  }
?>
      </select></td>
      <td width="75">Area:</td>
      <td><select name="area">
        <?php
do {  
?>
        <option value="<?php echo $row_area['id_area']?>"><?php echo $row_area['des_area']?></option>
        <?php
} while ($row_area = mysql_fetch_assoc($area));
  $rows = mysql_num_rows($area);
  if($rows > 0) {
      mysql_data_seek($area, 0);
	  $row_area = mysql_fetch_assoc($area);
  }
?>
      </select></td>
      <td>Consecutivo:</td>
      <td><select name="consecutivo">
        <?php
do {  
?>
        <option value="<?php echo $row_consecutivo['id_consecutivo']?>"><?php echo $row_consecutivo['descripcion_consecutivo']?></option>
        <?php
} while ($row_consecutivo = mysql_fetch_assoc($consecutivo));
  $rows = mysql_num_rows($consecutivo);
  if($rows > 0) {
      mysql_data_seek($consecutivo, 0);
	  $row_consecutivo = mysql_fetch_assoc($consecutivo);
  }
?>
      </select></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap">T.M</td>
      <td>RFC:</td>
      <td colspan="5"><select name="rfc_tm">
        <?php
do {  
?>
        <option value="<?php echo $row_TM['id_empleado']?>"><?php echo $row_TM['rfc']?></option>
        <?php
} while ($row_TM = mysql_fetch_assoc($TM));
  $rows = mysql_num_rows($TM);
  if($rows > 0) {
      mysql_data_seek($TM, 0);
	  $row_TM = mysql_fetch_assoc($TM);
  }
?>
      </select></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap">TV</td>
      <td>RFC:</td>
      <td colspan="5"><select name="rfc_tv">
        <?php
do {  
?>
        <option value="<?php echo $row_TV['id_empleado']?>"><?php echo $row_TV['rfc']?></option>
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
    <Tr>
      <td colspan="9" align="center" nowrap="nowrap">
        <p>
          <!--Inicio: Bootstrap -->        </p>
        <p>
          <input type="submit" 
         class="btn btn-success" 
         value="Insertar Consecutivo" />
        </p>
        <!--Fin: Bootstrap -->      </td>
</Tr>  
     <!--Fin: Bootstrap --> 
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
  
</form>


<a href="index.php">
   <button type="button" class="list-group-item-warning">
         <span class="glyphicon glyphicon-share-alt"></span> Regresar
</button>
</a>





</body>
</html>
<?php
mysql_free_result($Reg_tipo_determinante);

mysql_free_result($AC);

mysql_free_result($area);

mysql_free_result($consecutivo);

mysql_free_result($TM);

mysql_free_result($TV);

mysql_free_result($Periodo);
?>
