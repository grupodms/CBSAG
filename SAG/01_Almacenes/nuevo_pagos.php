<?php require_once('../../Connections/Canainpa.php'); ?>
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
  $updateSQL = sprintf(
  "UPDATE asem SET  Ultimo_Pago_Fecha=%s, 
                    Ultimo_Fecha_Inicio=%s, 
					Ultimo_Fecha_Fin=%s 
					WHERE idasem=%s",
                       GetSQLValueString($_POST['fecha_pago'], "date"),
                       GetSQLValueString($_POST['Fecha_inicio'], "date"),
                       GetSQLValueString($_POST['Fecha_fin'], "date"),
                       GetSQLValueString($_POST['idasem'], "int"));

  mysql_select_db($database_Canainpa, $Canainpa);
  $Result1 = mysql_query($updateSQL, $Canainpa) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO asem_pagos (idasem_pagos, idasem, fecha_pago, Referencia, importe, Fecha_inicio, Fecha_fin) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['idasem_pagos'], "int"),
                       GetSQLValueString($_POST['idasem'], "int"),
                       GetSQLValueString($_POST['fecha_pago'], "date"),
                       GetSQLValueString($_POST['Referencia'], "text"),
                       GetSQLValueString($_POST['importe'], "double"),
                       GetSQLValueString($_POST['Fecha_inicio'], "date"),
                       GetSQLValueString($_POST['Fecha_fin'], "date"));

  mysql_select_db($database_Canainpa, $Canainpa);
  $Result1 = mysql_query($insertSQL, $Canainpa) or die(mysql_error());

  $insertGoTo = "index_pagos.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}



$colname_Pago = "-1";
if (isset($_GET['idasem'])) {
  $colname_Pago = $_GET['idasem'];
}
mysql_select_db($database_Canainpa, $Canainpa);
$query_Pago = sprintf("SELECT * FROM asem_pagos WHERE idasem = %s", GetSQLValueString($colname_Pago, "int"));
$Pago = mysql_query($query_Pago, $Canainpa) or die(mysql_error());
$row_Pago = mysql_fetch_assoc($Pago);
$totalRows_Pago = mysql_num_rows($Pago);

$colname_asem = "-1";
if (isset($_GET['idasem'])) {
  $colname_asem = $_GET['idasem'];
}
mysql_select_db($database_Canainpa, $Canainpa);
$query_asem = sprintf("SELECT * FROM asem WHERE idasem = %s", GetSQLValueString($colname_asem, "int"));
$asem = mysql_query($query_asem, $Canainpa) or die(mysql_error());
$row_asem = mysql_fetch_assoc($asem);
$totalRows_asem = mysql_num_rows($asem);
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
  <h1>Nuevo Pago de Socio de ASEM</h1>
  </p>
</blockquote>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">

    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Fecha_pago:</td>
      <td><input type="text" name="fecha_pago" value="" size="32" 
                 readonly="readonly" 
                 id = "date1picker"
                 class="alert-success"  
           /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Referencia:</td>
      <td><input type="text" name="Referencia" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Importe:</td>
      <td><input type="text" name="importe" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Fecha_inicio:</td>
      <td><input type="text" name="Fecha_inicio" value="" size="32" 
                 readonly="readonly" 
                 id = "date2picker"
                 class="alert-success"        /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Fecha_fin:</td>
      <td><input type="text" name="Fecha_fin" value="" size="32" 
                 readonly="readonly" 
                 id = "date3picker"
                 class="alert-success"  
          /></td>
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
  <input type="hidden" name="idasem" value="<?php echo $colname_Pago; ?>" />


  <input type="hidden" name="idasem_pagos" value="" />
  <input type="hidden" name="MM_insert" value="form1" />
  <input type="hidden" name="MM_update" value="form1" />
  
</form>



<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Pago);

mysql_free_result($asem);
?>
