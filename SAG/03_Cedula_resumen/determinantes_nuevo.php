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
  $insertSQL = sprintf("INSERT INTO cedula_resumen_partidas (id_cedula_resumen_partidas, id_cedula_resumen, id_determinantes, cantidad) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_cedula_resumen_partidas'], "int"),
                       GetSQLValueString($_POST['id_cedula_resumen'], "int"),
                       GetSQLValueString($_POST['id_determinantes'], "int"),
                       GetSQLValueString($_POST['cantidad'], "int"));

  mysql_select_db($database_SAG, $SAG);
  $Result1 = mysql_query($insertSQL, $SAG) or die(mysql_error());

  $insertGoTo = "determinantes_index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
$id_area = "-1";
if (isset($_GET['id_area'])) {
  $id_area = $_GET['id_area'];
}
$id_consecutivo = "-1";
if (isset($_GET['id_consecutivo'])) {
  $id_consecutivo = $_GET['id_consecutivo'];
}




#
# Determinante  
#
$colname_Determinantes = "-1";
if (isset($_POST['id_determinante'])) {
  $colname_Determinantes = $_POST['id_determinante'];
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

$nValeEnt_cedula_resumen = "-1";
if (isset($_GET['id_cedula_resumen'])) {
  $nValeEnt_cedula_resumen = $_GET['id_cedula_resumen'];
}
mysql_select_db($database_SAG, $SAG);
$query_cedula_resumen = sprintf("SELECT cedula_resumen.id_cedula_resumen, cedula_resumen.id_periodo, periodo.semestre, cedula_resumen.id_dependencia, dependencia.clave_dependencia, dependencia.depen_descripcion FROM cedula_resumen INNER JOIN dependencia ON cedula_resumen.id_dependencia = dependencia.id_dependencia INNER JOIN periodo ON cedula_resumen.id_periodo = periodo.id_periodo WHERE id_cedula_resumen = %s", GetSQLValueString($nValeEnt_cedula_resumen, "int"));
$cedula_resumen = mysql_query($query_cedula_resumen, $SAG) or die(mysql_error());
$row_cedula_resumen = mysql_fetch_assoc($cedula_resumen);
$totalRows_cedula_resumen = mysql_num_rows($cedula_resumen);

$colname_cedula_resumen_partidas = "-1";
if (isset($_GET['id_cedula_resumen_partidas'])) {
  $colname_cedula_resumen_partidas = $_GET['id_cedula_resumen_partidas'];
}
mysql_select_db($database_SAG, $SAG);
$query_cedula_resumen_partidas = sprintf("SELECT * FROM cedula_resumen_partidas WHERE id_cedula_resumen_partidas = %s", GetSQLValueString($colname_cedula_resumen_partidas, "int"));
$cedula_resumen_partidas = mysql_query($query_cedula_resumen_partidas, $SAG) or die(mysql_error());
$row_cedula_resumen_partidas = mysql_fetch_assoc($cedula_resumen_partidas);
$totalRows_cedula_resumen_partidas = mysql_num_rows($cedula_resumen_partidas);

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


<title>Nuevo Articulo de Vales de Salida</title>
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
  <h1>Nuevo Articulos Cedula Resumen</h1>
  </p>
</blockquote>
<p> </p>
<?PHP echo "editFormAction  ".$editFormAction; ?>
<table width="665" border="0" class="btn-group-xs">
  <tr>
    <td width="87" align="left">Semestre: </td>
    <td width="288" align="left"><?php echo $row_cedula_resumen['semestre']; ?></td>
    <td width="238" align="left">&nbsp;</td>
  </tr>
  <tr>
    <td width="87" align="left">Fecha: </td>
    <td width="288" align="left"><?php echo $row_cedula_resumen['periodo_fecha']; ?></td>
    <td width="238" align="left">&nbsp;</td>
  </tr>
  <tr>
    <td width="87" align="left">Dependencia:</td>
    <td width="288" align="left">(<?php echo $row_cedula_resumen['clave_dependencia']; ?>)</td>
    <td width="238" align="left"><?php echo $row_cedula_resumen['depen_descripcion']; ?></td>
  </tr>
  <tr>
    <td width="87" align="left">&nbsp;</td>
    <td width="288" align="left">&nbsp;</td>
    <td width="238" align="left"></td>
  </tr>
</table>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1">
  <input name="id_cedula_resumen_partidas" type="hidden" id="id_cedula_resumen_partidas" />
  <input name="id_cedula_resumen" type="hidden" id="id_cedula_resumen" value="<?php echo $row_cedula_resumen['id_cedula_resumen']; ?>" />
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Determinante:</td>
      <td><label for="id_determinantes">
        <select name="id_determinantes" id="id_determinantes">
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
        </select>
      </label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Unidades:</td>
      <td><input name="cantidad" type="text" id="cantidad" value="" size="5" /></td>
    </tr>                

    <!--Inicio: Bootstrap -->
    <Tr>
      <td colspan="2" align="center" nowrap="nowrap">
        <!--Inicio: Bootstrap -->
      
        <input type="submit" 
         class="btn btn-success" 
         value="Insertar registro" />
        <!--Fin: Bootstrap -->      </td>
     </Tr>  
     
     
     
     
     <!--Fin: Bootstrap --> 


  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>

<a href="index.php?id_cedula_resumen=<?php echo $row_cedula_resumen['id_cedula_resumen']; ?>">
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

mysql_free_result($cedula_resumen);

mysql_free_result($cedula_resumen_partidas);
?>
