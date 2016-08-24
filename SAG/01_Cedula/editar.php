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
  $updateSQL = sprintf("UPDATE areas SET clave_area=%s, area_descripcion=%s WHERE id_areas=%s",
                       GetSQLValueString($_POST['clave_area'], "text"),
                       GetSQLValueString($_POST['area_descripcion'], "text"),
                       GetSQLValueString($_POST['id_areas'], "int"));

  mysql_select_db($database_SAG, $SAG);
  $Result1 = mysql_query($updateSQL, $SAG) or die(mysql_error());

  $updateGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_Socio_Asem = "-1";
if (isset($_GET['id_areas'])) {
  $colname_Socio_Asem = $_GET['id_areas'];
}
mysql_select_db($database_SAG, $SAG);
$query_Socio_Asem = sprintf("SELECT * FROM areas WHERE id_areas = %s", GetSQLValueString($colname_Socio_Asem, "int"));
$Socio_Asem = mysql_query($query_Socio_Asem, $SAG) or die(mysql_error());
$row_Socio_Asem = mysql_fetch_assoc($Socio_Asem);
$totalRows_Socio_Asem = mysql_num_rows($Socio_Asem);

mysql_select_db($database_SAG, $SAG);
$query_Cana = "SELECT * FROM areas ORDER BY id_areas ASC";
$Cana = mysql_query($query_Cana, $SAG) or die(mysql_error());
$row_Cana = mysql_fetch_assoc($Cana);
$totalRows_Cana = mysql_num_rows($Cana);
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
  <h1>Editar  Area de Asignación</h1>
  </p>
</blockquote>
<!--Fin:  Bootstrap -->
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
<input type="hidden" name="id_areas" value="<?php echo htmlentities($row_Socio_Asem['id_areas'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Clave</td>
      <td><input type="text" name="clave_area" value="<?php echo htmlentities($row_Socio_Asem['clave_area'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Descripción :</td>
      <td><input type="text" name="area_descripcion" value="<?php echo htmlentities($row_Socio_Asem['area_descripcion'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>



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
     <!--Fin: Bootstrap--> 
  </table>
  <input type="hidden" name="idasem" value="<?php echo $row_Socio_Asem['id_areas']; ?>" />
  <input type="hidden" name="MM_update" value="form1" />
  
</form>


<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Socio_Asem);

mysql_free_result($Cana);
?>
