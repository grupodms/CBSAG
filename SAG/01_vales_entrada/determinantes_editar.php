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

//$editFormAction = $_SERVER['PHP_SELF'];
//if (isset($_SERVER['QUERY_STRING'])) {
//  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
//}
#
# Determinante  
#
$colname_Deter2 = "-1";
if (isset($_POST['id_determinante'])) {
  $colname_Deter2 =$_POST['id_determinante'] ;
}

$id_area = "-1";
if (isset($_GET['id_area'])) {
  $id_area = $_GET['id_area'];
}

$id_consecutivo = "-1";
if (isset($_GET['id_consecutivo'])) {
  $id_consecutivo = $_GET['id_consecutivo'];
}

#--------

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE vale_entrada_partidas SET id_vale_entrada=%s, id_estado_fisico=%s, num_serie=%s, entrada_vale=%s, numero_inventario=%s, observaciones=%s, num_seriea=%s, num_serieb=%s, alta=%s, baja=%s , id_determinantes =%s, unidades =%s WHERE id_vale_entrada_partidas =%s",
 GetSQLValueString($_POST['id_vale_entrada'], "int"),
 GetSQLValueString($_POST['id_estado_fisico'], "int"),
                       GetSQLValueString($_POST['num_serie'], "text"),
                       GetSQLValueString($_POST['entrada_vale'], "date"),
                       GetSQLValueString($_POST['numero_inventario'], "text"),
                       GetSQLValueString($_POST['observaciones'], "text"),
                       GetSQLValueString($_POST['num_seriea'], "text"),
                       GetSQLValueString($_POST['num_serieb'], "text"),
                       GetSQLValueString(isset($_POST['alta']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['baja']) ? "true" : "", "defined","1","0"),
			GetSQLValueString($_POST['id_determinante'], "text"),
GetSQLValueString($_POST['unidades'], "int"),
GetSQLValueString($_POST['id_vale_entrada_partidas'], "int"));
// echo  $updateSQL; 
  mysql_select_db($database_SAG, $SAG);
  $Result1 = mysql_query($updateSQL, $SAG) or die(mysql_error());

 $updateGoTo = "determinantes_index.php";
 $updateGoTo .= "?id_vale_entrada=".$_POST['id_vale_entrada'];

 // $updateGoTo = "index2.php";
 // $updateGoTo .= "?id_area=".$id_area;
//  $updateGoTo .= "&id_consecutivo=".$id_consecutivo;
  if (isset($_SERVER['QUERY_STRING'])) {
	//$updateGoTo .= "?id_area = ".$_POST['id_area'];
	//$updateGoTo .= "&id_consecutivo = ".$_POST['id_consecutivo'];

	  
   // $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
   // $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_SAG, $SAG);
$query_estado_fisico = "SELECT * FROM estado_fisico ORDER BY clave_estado_fisico ASC";
$estado_fisico = mysql_query($query_estado_fisico, $SAG) or die(mysql_error());
$row_estado_fisico = mysql_fetch_assoc($estado_fisico);
$totalRows_estado_fisico = mysql_num_rows($estado_fisico);

$colname_vale_entrada = "-1";
if (isset($_GET['id_vale_entrada'])) {
  $colname_vale_entrada = $_GET['id_vale_entrada'];
}
mysql_select_db($database_SAG, $SAG);
$query_vale_entrada = sprintf("SELECT vale_entrada.id_vale_entrada,  vale_entrada.fecha,  vale_entrada.id_periodo,  periodo.semestre,  vale_entrada.id_dependencia,  dependencia.clave_dependencia,  dependencia.depen_descripcion,  vale_entrada.id_empleado_tm,  empleado_tm.matricula as tm_matricula,  empleado_tm.rfc as tm_rfc,  empleado_tm.curp as tm_curp,  empleado_tm.nombre as tm_nombre,  empleado_tm.puesto as tm_puesto,  empleado_tm.adcripcion as tm_adcripcion,   vale_entrada.id_empleado_tv,  empleado_tv.matricula as tv_matricula,  empleado_tv.rfc as tv_rfc,  empleado_tv.curp as tv_curp,  empleado_tv.nombre as tv_nombre,  empleado_tv.puesto as tv_puesto,  empleado_tv.adcripcion as tv_adcripcion FROM vale_entrada  INNER JOIN dependencia ON vale_entrada.id_dependencia = dependencia.id_dependencia  INNER JOIN periodo ON vale_entrada.id_periodo = periodo.id_periodo INNER JOIN empleado AS empleado_tm ON vale_entrada.id_empleado_tm = empleado_tm.id_empleado INNER JOIN empleado AS empleado_tv ON vale_entrada.id_empleado_tv = empleado_tv.id_empleado WHERE id_vale_entrada = %s", GetSQLValueString($colname_vale_entrada, "int"));
$vale_entrada = mysql_query($query_vale_entrada, $SAG) or die(mysql_error());
$row_vale_entrada = mysql_fetch_assoc($vale_entrada);
$totalRows_vale_entrada = mysql_num_rows($vale_entrada);

$colname_vale_entrada_detalle = "-1";
if (isset($_GET['id_vale_entrada_partidas'])) {
  $colname_vale_entrada_detalle = $_GET['id_vale_entrada_partidas'];
}


mysql_select_db($database_SAG, $SAG);
$query_vale_entrada_detalle = sprintf("SELECT * FROM vale_entrada_partidas WHERE id_vale_entrada_partidas = %s", GetSQLValueString($colname_vale_entrada_detalle, "int"));
$vale_entrada_detalle = mysql_query($query_vale_entrada_detalle, $SAG) or die(mysql_error());
$row_vale_entrada_detalle = mysql_fetch_assoc($vale_entrada_detalle);
$totalRows_vale_entrada_detalle = mysql_num_rows($vale_entrada_detalle);

mysql_select_db($database_SAG, $SAG);
$query_determinante_2 = "SELECT * FROM determinantes ORDER BY clave_determinante ASC";
$determinante_2 = mysql_query($query_determinante_2, $SAG) or die(mysql_error());
$row_determinante_2 = mysql_fetch_assoc($determinante_2);
$totalRows_determinante_2 = mysql_num_rows($determinante_2);



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


<title>Editar Determinantes de Vale de entrada</title>
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
  <h1>Editar Determinantes  de Vale de entrada.</h1>
  </p>
</blockquote>
<?php
echo "$updateGoTo = ".$updateGoTo."<br>";
?>
<table width="500" border="0" class="btn-group-xs">
  <tr>
    <td width="90" align="left">Semestre: </td>
    <td width="210" align="left"><?php echo $row_vale_entrada['semestre']; ?></td>
    <td width="300" align="left">&nbsp;</td>
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
    <td width="90" align="left">Area:</td>
    <td width="210" align="left">(<?php echo $row_vale_entrada['clave_area']; ?>)</td>
    <td width="300" align="left"><?php echo $row_vale_entrada['des_area']; ?></td>
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
<p> </p>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1">
  <table align="center">

    <tr valign="baseline">
      <td width="154" align="right" nowrap="nowrap">id:</td>
      <td colspan="3"><input type="text" name="id_vale_entrada" value="<?php echo $row_vale_entrada['id_vale_entrada']; ?>" size="32" 
                 readonly="readonly" 
                 id = "date1picker"
                 class="alert-success"  
           />
      <input type="text" name="id_vale_entrada_partidas" value="<?php echo $row_vale_entrada_detalle['id_vale_entrada_partidas']; ?>" size="32" 
                 readonly="readonly" 
                 id = "date1picker2"
                 class="alert-success"  
           /></td>
    </tr>
    <tr valign="baseline">
      <td height="25" align="right" nowrap="nowrap">Determinante:</td>
      <td width="36"><label for="id_determinantes"></label>
      <input name="id_determinantes" type="text" class="alert-success" id="id_determinantes" value="<?php echo $row_vale_entrada_detalle['id_determinantes']; ?>" size="5" readonly="readonly" /></td>
      <td width="48"><label for="clave_determinante"></label>
      <input name="clave_determinante" type="text" class="alert-success" id="clave_determinante" value="<?php echo $row_vale_entrada_detalle['clave_determinante']; ?>" size="10" readonly="readonly" /></td>
      <td width="226"><label for="descripcion"></label>
        <label for="descripcion"></label>
        <label for="id_determinante"></label>
        <select name="id_determinante" id="id_determinante">
          <?php
do {  
?>
          <option value="<?php echo $row_determinante_2['id_determinantes']?>"<?php if (!(strcmp($row_determinante_2['id_determinantes'], $row_vale_entrada_detalle['id_determinantes']))) {echo "selected=\"selected\"";} ?>><?php echo $row_determinante_2['clave_determinante']?></option>
          <?php
} while ($row_determinante_2 = mysql_fetch_assoc($determinante_2));
  $rows = mysql_num_rows($determinante_2);
  if($rows > 0) {
      mysql_data_seek($determinante_2, 0);
	  $row_determinante_2 = mysql_fetch_assoc($determinante_2);
  }
?>
        </select>
      <label for="des_det"></label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td colspan="3"><textarea name="descripcion" cols="45" rows="5" readonly="readonly" class="alert-success" id="descripcion"><?php echo $row_vale_entrada_detalle['descripcion']; ?></textarea></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Unidades:</td>
      <td colspan="3"><input name="unidades" type="text" value="<?php echo $row_vale_entrada_detalle['unidades']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Estado Fisico:</td>
      <td colspan="3"><label for="id_estado_fisico"></label>
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
      <td colspan="3"><input name="num_serie" type="text" id="num_serie" value="<?php echo $row_vale_entrada_detalle['num_serie']; ?>" size="32" /></td>
    </tr>

    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Numero de vale entrada:</td>
      <td colspan="3"><input name="entrada_vale" type="text" class="alert-success" id="entrada_vale" value="<?php echo $row_vale_entrada_detalle['entrada_vale']; ?>" size="32" readonly="readonly" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Numero inventario:</td>
      <td colspan="3"><input name="numero_inventario" type="text" id="numero_inventario" value="<?php echo $row_vale_entrada_detalle['numero_inventario']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap">observaciones:</td>
      <td colspan="3"><label for="observaciones"></label>
      <textarea name="observaciones" id="observaciones" cols="45" rows="5"><?php echo $row_vale_entrada_detalle['observaciones']; ?></textarea></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Num. serie 2:</td>
      <td colspan="3"><input name="num_seriea" type="text" id="num_seriea" value="<?php echo $row_vale_entrada_detalle['num_seriea']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Num. serie 3:</td>
      <td colspan="3"><input name="num_serieb" type="text" id="num_seriea2" value="<?php echo $row_vale_entrada_detalle['num_serieb']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">alta:</td>
      <td colspan="3"><input <?php if (!(strcmp($row_vale_entrada_detalle['alta'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" name="alta" id="alta" />
      <label for="alta"></label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">baja:</td>
      <td colspan="3"><input <?php if (!(strcmp($row_vale_entrada_detalle['baja'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" name="baja" id="baja" /></td>
    </tr>                

    <!--Inicio: Bootstrap -->
    <Tr>



    <!--Inicio: Bootstrap -->
    <Tr>
      <td colspan="4" align="center" nowrap="nowrap">
        <!--Inicio: Bootstrap -->
        <P>&nbsp;  </P>
        <input type="submit" 
         class="btn btn-success" 
         value="Actualizar registro" />
        <!--Fin: Bootstrap -->      </td>
     </Tr>  
     
     
     
     
     <!--Fin: Bootstrap --> 


  </table>
  <input type="hidden" name="idasem" />


  <input type="hidden" name="idasem_pagos" value="" />
  <input type="hidden" name="MM_update" value="form1" />
</form>

<a href="determinantes_index.php?id_vale_entrada=<?php echo $row_vale_entrada['id_vale_entrada']; ?>">
   <button type="button" class="list-group-item-warning">
         <span class="glyphicon glyphicon-share-alt"></span> Regresar
</button>
</a>
<p>&nbsp;</p>
<p>&nbsp;</p>

</body>
</html>
<?php
mysql_free_result($estado_fisico);

mysql_free_result($vale_entrada);

mysql_free_result($vale_entrada_detalle);

mysql_free_result($determinante_2);
?>
