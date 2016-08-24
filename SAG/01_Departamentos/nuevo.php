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
  $insertSQL = sprintf("INSERT INTO consecutivo (id_consecutivo, id_dependencia, id_area, clave_conse, descripcion_consecutivo) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_consecutivo'], "int"),
                       GetSQLValueString($_POST['id_dependencia'], "int"),
                       GetSQLValueString($_POST['id_area'], "int"),
                       GetSQLValueString($_POST['clave_departamento'], "text"),
                       GetSQLValueString($_POST['des_dependencia'], "text"));

  mysql_select_db($database_SAG, $SAG);
  $Result1 = mysql_query($insertSQL, $SAG) or die(mysql_error());

  $insertGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$colname_Dependencia = "-1";
if (isset($_COOKIE ["id_dependencia"])) {
  $colname_Dependencia = $_COOKIE ["id_dependencia"];
}
mysql_select_db($database_SAG, $SAG);
$query_Dependencia = sprintf("SELECT * FROM dependencia WHERE id_dependencia = %s ORDER BY depen_descripcion ASC", GetSQLValueString($colname_Dependencia, "int"));
$Dependencia = mysql_query($query_Dependencia, $SAG) or die(mysql_error());
$row_Dependencia = mysql_fetch_assoc($Dependencia);
$totalRows_Dependencia = mysql_num_rows($Dependencia);

$colname_Area = "-1";
if (isset($_COOKIE['id_dependencia'])) {
  $colname_Area = $_COOKIE['id_dependencia'];
}
mysql_select_db($database_SAG, $SAG);
$query_Area = sprintf("SELECT * FROM area WHERE id_dependencia = %s ORDER BY clave_area ASC", GetSQLValueString($colname_Area, "int"));
$Area = mysql_query($query_Area, $SAG) or die(mysql_error());
$row_Area = mysql_fetch_assoc($Area);
$totalRows_Area = mysql_num_rows($Area);
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


$( "#fecha_inicio" ).datepicker({
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
  <h1>Nuevo Departamento.</h1>
  </p>
</blockquote>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
<input type="hidden" name="id_consecutivo" value="" />
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Dependencia</td>
      <td><label for="id_dependencia"></label>
        <select name="id_dependencia" id="id_dependencia">
          <?php
do {  
?>
          <option value="<?php echo $row_Dependencia['id_dependencia']?>"><?php echo $row_Dependencia['depen_descripcion']?></option>
          <?php
} while ($row_Dependencia = mysql_fetch_assoc($Dependencia));
  $rows = mysql_num_rows($Dependencia);
  if($rows > 0) {
      mysql_data_seek($Dependencia, 0);
	  $row_Dependencia = mysql_fetch_assoc($Dependencia);
  }
?>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Area</td>
      <td><label for="id_area"></label>
        <select name="id_area" id="id_area">
          <?php
do {  
?>
          <option value="<?php echo $row_Area['id_area']?>"><?php echo $row_Area['des_area']?></option>
          <?php
} while ($row_Area = mysql_fetch_assoc($Area));
  $rows = mysql_num_rows($Area);
  if($rows > 0) {
      mysql_data_seek($Area, 0);
	  $row_Area = mysql_fetch_assoc($Area);
  }
?>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Clave Departamento:</td>
      <td><input name="clave_departamento" type="text" id="clave_departamento" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Descripción :</td>
      <td><input name="des_dependencia" type="text" id="des_dependencia" value="" size="32" /></td>
    </tr>


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
mysql_free_result($Dependencia);

mysql_free_result($Area);
?>
