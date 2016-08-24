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



if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO vale_entrada (id_vale_entrada, id_vale_entrada_tipo, id_periodo, id_dependencia, id_empleado_tm, id_empleado_tv, fecha, numero_vale, fecha_vale_traspaso, numero_factura, observaciones, id_subdependencia ) 
VALUES (%s, %s, %s, %s, %s, %s, %s, %s , %s, %s, %s, %s  )",
                GetSQLValueString($_POST['id_vale_entrada'], "int"),
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
				GetSQLValueString($_POST['id_subdependencia'], "int")
					   );
//echo " insertSQL = ".$insertSQL;
  mysql_select_db($database_SAG, $SAG);
  $Result1 = mysql_query($insertSQL, $SAG) or die(mysql_error());

  $insertGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
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

$colname_area = "-1";
if (isset($_COOKIE ["id_dependencia"])) {
  $colname_area = $_COOKIE ["id_dependencia"];
}
mysql_select_db($database_SAG, $SAG);
$query_area = sprintf("SELECT area.id_area, area.id_dependencia, area.clave_area, area.des_area, CONCAT(area.clave_area,'|',area.des_area) as lista FROM area WHERE id_dependencia = %s ORDER BY clave_area ASC", GetSQLValueString($colname_area, "int"));
$area = mysql_query($query_area, $SAG) or die(mysql_error());
$row_area = mysql_fetch_assoc($area);
$totalRows_area = mysql_num_rows($area);

$colname_consecutivo = "-1";
if (isset($_COOKIE ["id_dependencia"])) {
  $colname_consecutivo = $_COOKIE ["id_dependencia"];
}
mysql_select_db($database_SAG, $SAG);
$query_consecutivo = sprintf("SELECT consecutivo.id_consecutivo, consecutivo.id_dependencia, consecutivo.id_area, consecutivo.clave_conse, consecutivo.descripcion_consecutivo, area.clave_area, area.des_area, CONCAT(consecutivo.clave_conse,'|',consecutivo.descripcion_consecutivo,'|',area.clave_area,'|',area.des_area) as lista FROM consecutivo INNER JOIN area ON consecutivo.id_area = area.id_area WHERE consecutivo.id_dependencia = %s ORDER BY clave_conse ASC", GetSQLValueString($colname_consecutivo, "int"));
$consecutivo = mysql_query($query_consecutivo, $SAG) or die(mysql_error());
$row_consecutivo = mysql_fetch_assoc($consecutivo);
$totalRows_consecutivo = mysql_num_rows($consecutivo);

$aGrup_TM = "-1";
if (isset($_COOKIE ['id_agrupador'])) {
  $aGrup_TM = $_COOKIE ['id_agrupador'];
}
mysql_select_db($database_SAG, $SAG);
$query_TM = sprintf("SELECT empleado.* , CONCAT(empleado.rfc,' | ',empleado.curp,' | ',empleado.matricula,' | ',empleado.nombre) AS lista FROM empleado WHERE id_agrupador = %s ORDER BY rfc ASC", GetSQLValueString($aGrup_TM, "int"));
$TM = mysql_query($query_TM, $SAG) or die(mysql_error());
$row_TM = mysql_fetch_assoc($TM);
$totalRows_TM = mysql_num_rows($TM);

$colname_TV = "-1";
if (isset($_COOKIE ["id_agrupador"])) {
  $colname_TV = $_COOKIE ["id_agrupador"];
}
mysql_select_db($database_SAG, $SAG);
$query_TV = sprintf("SELECT empleado.*, CONCAT(empleado.rfc,' | ',empleado.curp,' | ',empleado.matricula,' | ',empleado.nombre) AS lista FROM empleado WHERE id_agrupador = %s ORDER BY rfc ASC", GetSQLValueString($colname_TV, "int"));
$TV = mysql_query($query_TV, $SAG) or die(mysql_error());
$row_TV = mysql_fetch_assoc($TV);
$totalRows_TV = mysql_num_rows($TV);

mysql_select_db($database_SAG, $SAG);
$query_Periodo = "SELECT * FROM `periodo` where cierre = 0 and activo = 1 and activo_fijo =0 ORDER BY semestre ASC";
$Periodo = mysql_query($query_Periodo, $SAG) or die(mysql_error());
$row_Periodo = mysql_fetch_assoc($Periodo);
$totalRows_Periodo = mysql_num_rows($Periodo);

mysql_select_db($database_SAG, $SAG);
$query_vales_entrada_tipo = "SELECT * FROM vale_entrada_tipo ORDER BY clave_vale_entrada_tipo ASC";
$vales_entrada_tipo = mysql_query($query_vales_entrada_tipo, $SAG) or die(mysql_error());
$row_vales_entrada_tipo = mysql_fetch_assoc($vales_entrada_tipo);
$totalRows_vales_entrada_tipo = mysql_num_rows($vales_entrada_tipo);
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


<title>Nuevo Vale de Entrada</title>
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
$( "#fecha_vale_traspaso" ).datepicker({
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
  <h1>Nuevo Vale de Entrada</h1>
  </p>
</blockquote>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1">
<input type="hidden" name="id_vale_entrada" value="" />
  <table align="center" width="100%">
    <tr valign="baseline">
      <td colspan="2" align="right" nowrap="nowrap"><p align="right">Fecha:</p></td>
      <td colspan="2"><p align="left"><input name="fecha" type="text"
           class="alert-success" id="comodato_fecha5" value="<?php echo $hoy; ?>"readonly="readonly" /></p></td>
      <td><p align="right">Numero Vale:</p></td><td><p align="left"><input name="numero_vale" type="text"
           id="numero_vale"  /></p></td>
      <td><p align="right">Fecha Vale :</p></td>
      <td><p align="left"><input name="fecha_vale_traspaso" type="text"
           class="alert-success" id="fecha_vale_traspaso" readonly="readonly" /></p></td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" align="right" nowrap="nowrap"><p align="right">Periodo:</p></td>
      <td colspan="2"><p align="left">
        <input name="id_periodo" 
       type="text" class="alert-success" 
       id="id_dependencia2" value="<?php echo $_COOKIE ["id_periodo"]; ?>" size="10" readonly="readonly" />
      </p></td>
      <td width="100"><p align="right">Tipo Vale :</p></td>
      <td width="121"><p align="left"><select name="id_vale_entrada_tipo" id="id_vale_entrada_tipo">
        <option value="0"></option>
        <?php
do {  
?>
        <option value="<?php echo $row_vales_entrada_tipo['id_vale_entrada_tipo']?>"><?php echo $row_vales_entrada_tipo['descripcion_vale_entrada_tipo']?></option>
        <?php
} while ($row_vales_entrada_tipo = mysql_fetch_assoc($vales_entrada_tipo));
  $rows = mysql_num_rows($vales_entrada_tipo);
  if($rows > 0) {
      mysql_data_seek($vales_entrada_tipo, 0);
	  $row_vales_entrada_tipo = mysql_fetch_assoc($vales_entrada_tipo);
  }
?>
      </select></p></td>
      <td width="102"><p align="right">Num.  Factura :</p></td>
      <td width="67"><p align="left"><input name="numero_factura" type="text"
            id="numero_factura" /> </p></td>
      <td width="11">&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td width="59" align="right" nowrap="nowrap">&nbsp;</td>
      <td width="36"><p align="right">A.C. :</p></td>
      <td width="56"><p align="left"><input name="id_dependencia" type="text" class="alert-success" id="id_dependencia"
      value="<?php echo $_COOKIE ["id_dependencia"]; ?>" size="11" readonly="readonly" /></p></td>
      <td width="62">&nbsp;</td>
      <td><p align="right">SubDependencia:</p></td>
      <td colspan="2"><p align="left"><select name="id_subdependencia" id="id_subdependencia">
        <option value="0"></option>

      </select>        
        <label for="id_subdependencia"></label></p></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap">&nbsp;</td>
      <td valign="top"><p align="right">Observaciones:</p> </td>
      <td colspan="6"><p align="left">
      <textarea name="observaciones" id="observaciones" cols="120
      " rows="5"></textarea></p></td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap">1</td>
      <td><p align="right">RFC:</p></td>
      <td colspan="6" > <p align="left"><select name="id_empleado_tm" id="id_empleado_tm">
        <option value="0"></option>
        <?php
do {  
?>
        <option value="<?php echo $row_TM['id_empleado']?>"><?php echo $row_TM['lista']?></option>
        <?php
} while ($row_TM = mysql_fetch_assoc($TM));
  $rows = mysql_num_rows($TM);
  if($rows > 0) {
      mysql_data_seek($TM, 0);
	  $row_TM = mysql_fetch_assoc($TM);
  }
?>
      </select> </p></td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap">2</td>
      <td><p align="right"> RFC:</p></td>
      <td colspan="6"><p align="left"> <select name="id_empleado_tv" id="id_empleado_tv">
        <option value="0"></option>
        <?php
do {  
?>
        <option value="<?php echo $row_TV['id_empleado']?>"><?php echo $row_TV['lista']?></option>
        <?php
} while ($row_TV = mysql_fetch_assoc($TV));
  $rows = mysql_num_rows($TV);
  if($rows > 0) {
      mysql_data_seek($TV, 0);
	  $row_TV = mysql_fetch_assoc($TV);
  }
?>
      </select></p></td>
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
         value="Insertar Vale de Entrada" />
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

mysql_free_result($vales_entrada_tipo);
?>
