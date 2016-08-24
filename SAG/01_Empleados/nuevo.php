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
  $insertSQL = sprintf("INSERT INTO determinantes (id_determinantes, clave_determinante, comodato, comodato_fecha, donacion, donacion_fecha, descripcion, cuenta, cuenta2, cambs) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_determinantes'], "int"),
                       GetSQLValueString($_POST['clave'], "text"),
                       GetSQLValueString(isset($_POST['comodato']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['comodato_fecha'], "date"),
                       GetSQLValueString(isset($_POST['donacion']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['donacion_fecha'], "date"),
                       GetSQLValueString($_POST['Descripcion'], "text"),
                       GetSQLValueString($_POST['cuenta'], "text"),
                       GetSQLValueString($_POST['cuenta2'], "text"),
                       GetSQLValueString($_POST['cambs'], "text"));

  mysql_select_db($database_SAG, $SAG);
  $Result1 = mysql_query($insertSQL, $SAG) or die(mysql_error());

  $insertGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_SAG, $SAG);
$query_Reg_tipo_determinante = "SELECT * FROM determinante_tipo ORDER BY deter_descripcion ASC";
$Reg_tipo_determinante = mysql_query($query_Reg_tipo_determinante, $SAG) or die(mysql_error());
$row_Reg_tipo_determinante = mysql_fetch_assoc($Reg_tipo_determinante);
$totalRows_Reg_tipo_determinante = mysql_num_rows($Reg_tipo_determinante);
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
<?PHP $menu = 1; ?>
<?PHP require_once('../barra01.php'); ?>
<!--Menu -->

<!--Inicio:  Bootstrap -->

<blockquote>
  <p>
  <h1>Nuevo Determinante.</h1>
  </p>
</blockquote>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
<input type="hidden" name="id_determinantes" value="" />
  <table align="center">
    <tr valign="baseline">
      <td align="right" nowrap="nowrap">Clave :</td>
      <td colspan="2"><label for="clave"></label>
        <input name="clave" type="text" id="clave" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap">Descripción :</td>
      <td colspan="2"><input name="Descripcion" type="text" id="Descripcion" size="80" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap">Tipo  :</td>
      <td colspan="2"><label for="Tipo"></label>
        <select name="Tipo" id="Tipo">
          <?php
do {  
?>
          <option value="<?php echo $row_Reg_tipo_determinante['id_determinante_tipo']?>"><?php echo $row_Reg_tipo_determinante['deter_descripcion']?></option>
          <?php
} while ($row_Reg_tipo_determinante = mysql_fetch_assoc($Reg_tipo_determinante));
  $rows = mysql_num_rows($Reg_tipo_determinante);
  if($rows > 0) {
      mysql_data_seek($Reg_tipo_determinante, 0);
	  $row_Reg_tipo_determinante = mysql_fetch_assoc($Reg_tipo_determinante);
  }
?>
        </select></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap">Comodato :</td>
      <td align="center"><input  name="comodato" type="checkbox" id="comodato" /></td>
      <td><input name="comodato_fecha" type="text"
           class="alert-success" id="comodato_fecha" value="<?php echo '/ / / '; ?>"readonly="readonly" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap">Donacion :</td>
      <td align="center"><input  type="checkbox" name="donacion" id="donacion" />
        <label for="donacion"></label></td>
      <td><label for="donacion_fecha"></label>
        <input name="donacion_fecha" type="text"
           class="alert-success" id="donacion_fecha" value="<?php echo '/ / / '; ?>" 
readonly="readonly"      /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap">Cuenta : </td>
      <td colspan="2"><label for="cuenta"></label>
        <input name="cuenta" type="text" id="cuenta" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap">Cuenta 2 :</td>
      <td colspan="2"><label for="cuenta2"></label>
        <input name="cuenta2" type="text" id="cuenta2" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap">cambs :</td>
      <td colspan="2"><label for="cambs"></label>
        <input name="cambs" type="text" id="cambs" />
      <label for="comodato_fecha"></label></td>
    </tr>


    <!--Inicio: Bootstrap -->
    <Tr>
      <td colspan="3" align="center" nowrap="nowrap">
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
mysql_free_result($Reg_tipo_determinante);
?>
