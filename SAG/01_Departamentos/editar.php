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
  $updateSQL = sprintf("UPDATE consecutivo SET id_dependencia=%s, clave_conse=%s, descripcion_consecutivo=%s WHERE id_consecutivo=%s",
                       GetSQLValueString($_POST['id_dependencia'], "int"),
                       GetSQLValueString($_POST['clave_conse'], "text"),
                       GetSQLValueString($_POST['descripcion_consecutivo'], "text"),
                       GetSQLValueString($_POST['id_consecutivo'], "int"));

  mysql_select_db($database_SAG, $SAG);
  $Result1 = mysql_query($updateSQL, $SAG) or die(mysql_error());

  $updateGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_Recordset1 = "-1";
if (isset($_GET['id_consecutivo'])) {
  $colname_Recordset1 = $_GET['id_consecutivo'];
}
mysql_select_db($database_SAG, $SAG);
$query_Recordset1 = sprintf("SELECT consecutivo.id_consecutivo, consecutivo.id_dependencia, consecutivo.clave_conse, consecutivo.descripcion_consecutivo, dependencia.depen_descripcion, consecutivo.id_area, area.clave_area, area.des_area FROM consecutivo INNER JOIN dependencia ON consecutivo.id_dependencia = dependencia.id_dependencia INNER JOIN area ON consecutivo.id_area = area.id_area WHERE id_consecutivo = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $SAG) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_Socio_Asem = "-1";
if (isset($_GET['id_area'])) {
  $colname_Socio_Asem = $_GET['id_area'];
}
mysql_select_db($database_SAG, $SAG);
$query_Socio_Asem = sprintf("SELECT * FROM area WHERE id_area = %s", GetSQLValueString($colname_Socio_Asem, "int"));
$Socio_Asem = mysql_query($query_Socio_Asem, $SAG) or die(mysql_error());
$row_Socio_Asem = mysql_fetch_assoc($Socio_Asem);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<!--Inicio:  Bootstrap -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="../css/bootstrap.min.css" rel="stylesheet">
<!--Fin: Script Bootstrap --> 

<title>Editar Socio Asem</title>
</head>
<body>
<!--Inicio: Script Bootstrap -->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../js/bootstrap.min.js"></script>
<!--Fin: Script Bootstrap -->  

<!--Menu -->
<?PHP $menu = 1; ?>
<?PHP require_once('../barra01.php'); ?>
<!--Menu -->


<!--Inicio:  Bootstrap -->
<blockquote>
  <p>
  <h1>Editar  Consecutivos /Departamentos de Asignación.</h1>
  </p>
</blockquote>
<!--Fin:  Bootstrap -->
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
<input name="id_consecutivo" type="hidden" id="id_consecutivo" value="<?php echo $row_Recordset1['id_consecutivo']; ?>" size="32" />
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Dependencia</td>
      <td colspan="3"><input name="id_dependencia" type="text" class="alert-success" id="id_dependencia" value="<?php echo $row_Recordset1['id_dependencia']; ?>" size="32" readonly="readonly" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Área</td>
      <td><label for="id_area"></label>
      <input name="id_area" type="text" class="alert-success" id="id_area" value="<?php echo $row_Recordset1['id_area']; ?>" size="6" readonly="readonly" /></td>
      <td><label for="clave_area"></label>
      <input name="clave_area" type="text" class="alert-success" id="clave_area" value="<?php echo $row_Recordset1['clave_area']; ?>" size="10" readonly="readonly" /></td>
      <td><label for="des_area2"></label>
      <input name="des_area" type="text" class="alert-success" id="des_area2" value="<?php echo $row_Recordset1['des_area']; ?>" readonly="readonly" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Clave</td>
      <td colspan="3"><input name="clave_conse" type="text" value="<?php echo $row_Recordset1['clave_conse']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Descripción :</td>
      <td colspan="3"><label for="des_area"></label>
      <input name="descripcion_consecutivo" type="text" id="descripcion_consecutivo" value="<?php echo $row_Recordset1['descripcion_consecutivo']; ?>" size="32" /></td>
    </tr>



     <!--Inicio: Bootstrap -->
    <Tr>
      <td colspan="4" align="center" nowrap="nowrap">
        <!--Inicio: Bootstrap -->
        <P>&nbsp;  </P>
        <input type="submit" 
         class="btn btn-success" 
         value="Guardar registro" />
        <!--Fin: Bootstrap -->      </td>
    </Tr>  
     <!--Fin: Bootstrap--> 
  </table>

  <input type="hidden" name="MM_update" value="form1" />
  
</form>


<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
