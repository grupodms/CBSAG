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
  $insertSQL = sprintf("INSERT INTO determinantes (id_determinantes, clave_determinante, id_determinante_tipo, id_determinante_marca, id_determinante_clasificacion1, id_determinante_clasificacion2, comodato, comodato_fecha, donacion, donacion_fecha, descripcion, tecnica, autor, cuenta, cuenta2, cambs, costo) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_determinantes'], "int"),
                       GetSQLValueString($_POST['clave'], "text"),
                       GetSQLValueString($_POST['Tipo'], "int"),
                       GetSQLValueString($_POST['id_determinante_marca'], "int"),
                       GetSQLValueString($_POST['id_determinante_clasificacion1'], "int"),
                       GetSQLValueString($_POST['id_determinante_clasificacion2'], "int"),
                       GetSQLValueString(isset($_POST['comodato']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['comodato_fecha'], "date"),
                       GetSQLValueString(isset($_POST['donacion']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['donacion_fecha'], "date"),
                       GetSQLValueString($_POST['Descripcion'], "text"),
                       GetSQLValueString($_POST['tecnica'], "text"),
                       GetSQLValueString($_POST['autor'], "text"),
                       GetSQLValueString($_POST['cuenta'], "text"),
                       GetSQLValueString($_POST['cuenta2'], "text"),
                       GetSQLValueString($_POST['cambs'], "text"),
                       GetSQLValueString($_POST['cambs'], "double"));

  mysql_select_db($database_SAG, $SAG);
  $Result1 = mysql_query($insertSQL, $SAG) or die(mysql_error());

  $insertGoTo = "index2.php";
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

mysql_select_db($database_SAG, $SAG);
$query_Marca = "SELECT * FROM determinante_marca ORDER BY marca ASC";
$Marca = mysql_query($query_Marca, $SAG) or die(mysql_error());
$row_Marca = mysql_fetch_assoc($Marca);
$totalRows_Marca = mysql_num_rows($Marca);

mysql_select_db($database_SAG, $SAG);
$query_Clasifica1 = "SELECT * FROM determinante_clasificacion1 ORDER BY clasificacion1 ASC";
$Clasifica1 = mysql_query($query_Clasifica1, $SAG) or die(mysql_error());
$row_Clasifica1 = mysql_fetch_assoc($Clasifica1);
$totalRows_Clasifica1 = mysql_num_rows($Clasifica1);

mysql_select_db($database_SAG, $SAG);
$query_Clasifica2 = "SELECT * FROM determinante_clasificacion2 ORDER BY clasificacion2 ASC";
$Clasifica2 = mysql_query($query_Clasifica2, $SAG) or die(mysql_error());
$row_Clasifica2 = mysql_fetch_assoc($Clasifica2);
$totalRows_Clasifica2 = mysql_num_rows($Clasifica2);
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
      <td align="right" nowrap="nowrap">Tipo  :</td>
      <td colspan="2"><select name="Tipo" id="Tipo">
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
      <td align="right" nowrap="nowrap">Marca :</td>
      <td colspan="2"><label for="id_determinante_marca"></label>
        <select name="id_determinante_marca" id="id_determinante_marca">
          <?php
do {  
?>
          <option value="<?php echo $row_Marca['id_determinante_marca']?>"><?php echo $row_Marca['marca']?></option>
          <?php
} while ($row_Marca = mysql_fetch_assoc($Marca));
  $rows = mysql_num_rows($Marca);
  if($rows > 0) {
      mysql_data_seek($Marca, 0);
	  $row_Marca = mysql_fetch_assoc($Marca);
  }
?>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap">Clasifica 1:</td>
      <td colspan="2"><label for="id_determinante_clasificacion1"></label>
        <select name="id_determinante_clasificacion1" id="id_determinante_clasificacion1">
          <?php
do {  
?>
          <option value="<?php echo $row_Clasifica1['id_determinante_clasificacion1']?>"><?php echo $row_Clasifica1['clasificacion1']?></option>
          <?php
} while ($row_Clasifica1 = mysql_fetch_assoc($Clasifica1));
  $rows = mysql_num_rows($Clasifica1);
  if($rows > 0) {
      mysql_data_seek($Clasifica1, 0);
	  $row_Clasifica1 = mysql_fetch_assoc($Clasifica1);
  }
?>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap">Clasifica 2:</td>
      <td colspan="2"><label for="id_determinante_clasificacion2"></label>
        <select name="id_determinante_clasificacion2" id="id_determinante_clasificacion2">
          <?php
do {  
?>
          <option value="<?php echo $row_Clasifica2['id_determinante_clasificacion2']?>"><?php echo $row_Clasifica2['clasificacion2']?></option>
          <?php
} while ($row_Clasifica2 = mysql_fetch_assoc($Clasifica2));
  $rows = mysql_num_rows($Clasifica2);
  if($rows > 0) {
      mysql_data_seek($Clasifica2, 0);
	  $row_Clasifica2 = mysql_fetch_assoc($Clasifica2);
  }
?>
      </select>        <label for="Tipo"></label></td>
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
      <td align="right" nowrap="nowrap">Descripción :</td>
      <td colspan="2"><input name="Descripcion" type="text" id="Descripcion" size="100" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap">Técnica :</td>
      <td colspan="2"><input name="tecnica" type="text" id="tecnica" size="100" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap">Autor :</td>
      <td colspan="2"><input name="autor" type="text" id="autor" size="100" /></td>
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
      <td colspan="2"><input name="cambs" type="text" id="cambs" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap">Costo :</td>
      <td colspan="2"><label for="cambs"></label>
      <label for="comodato_fecha">
        <input name="costo" type="text" id="costo" />
      </label></td>
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

mysql_free_result($Marca);

mysql_free_result($Clasifica1);

mysql_free_result($Clasifica2);
?>
