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
  $updateSQL = sprintf("UPDATE determinantes SET clave_determinante=%s, id_determinante_tipo=%s, id_determinante_marca=%s, id_determinante_clasificacion1=%s, id_determinante_clasificacion2=%s, comodato=%s, comodato_fecha=%s, donacion=%s, donacion_fecha=%s, descripcion=%s, tecnica=%s, autor=%s, cuenta=%s, cuenta2=%s, cambs=%s, costo=%s WHERE id_determinantes=%s",
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
                       GetSQLValueString($_POST['costo'], "double"),
                       GetSQLValueString($_POST['id_determinantes'], "int"));

  mysql_select_db($database_SAG, $SAG);
  $Result1 = mysql_query($updateSQL, $SAG) or die(mysql_error());

  $updateGoTo = "index2.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_Determinantes = "-1";
if (isset($_GET['id_determinantes'])) {
  $colname_Determinantes = $_GET['id_determinantes'];
}
mysql_select_db($database_SAG, $SAG);
$query_Determinantes = sprintf("SELECT * FROM determinantes WHERE id_determinantes = %s", GetSQLValueString($colname_Determinantes, "int"));
$Determinantes = mysql_query($query_Determinantes, $SAG) or die(mysql_error());
$row_Determinantes = mysql_fetch_assoc($Determinantes);
$totalRows_Determinantes = mysql_num_rows($Determinantes);

mysql_select_db($database_SAG, $SAG);
$query_Tipo = "SELECT * FROM determinante_tipo ORDER BY deter_descripcion ASC";
$Tipo = mysql_query($query_Tipo, $SAG) or die(mysql_error());
$row_Tipo = mysql_fetch_assoc($Tipo);
$totalRows_Tipo = mysql_num_rows($Tipo);

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
<!--Fin: Script Bootstrap --> 

<!--Inicio:  Fecha-->
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
 <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
 <link rel="stylesheet" href="/resources/demos/style.css">
<script>
$(document).ready(function () {
    var date = new Date();
    var currentMonth = date.getMonth();
    var currentDate = date.getDate();
    var currentYear = date.getFullYear();

    $('#comodato_fecha').datepicker({
        minDate: new Date(currentYear, currentMonth, currentDate),
        dateFormat: 'yy-mm-dd'
    });
});
$(document).ready(function () {
    var date = new Date();
    var currentMonth = date.getMonth();
    var currentDate = date.getDate();
    var currentYear = date.getFullYear();

    $('#donacion_fecha').datepicker({
        minDate: new Date(currentYear, currentMonth, currentDate),
        dateFormat: 'yy-mm-dd'
    });
});
</script>
<!--Fin:    Fecha -->



<title>Editar Socio Asem</title>
</head>
<body>
<!--Inicio: Script Bootstrap -->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../js/bootstrap.min.js"></script>

<script type="text/javascript" src="../js/bootstrap-datepicker.js"></script>

<!--Fin: Script Bootstrap -->  

<!--Menu -->
<?PHP $menu = 1; ?>
<?PHP require_once('../barra01.php'); ?>
<!--Menu -->


<!--Inicio:  Bootstrap -->




<blockquote>
  <p>
  <h1>Editar  Determinante</h1>
  </p>

</blockquote>
<!--Fin:  Bootstrap -->
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1">
  <input type="hidden" name="id_determinantes" value="<?php echo $row_Determinantes['id_determinantes']; ?>" />
  <table align="center">
    <tr valign="baseline">
      <td align="right" nowrap="nowrap">Clave :</td>
      <td colspan="2"><label for="clave"></label>
        <input name="clave" type="text" id="clave" value="<?php echo $row_Determinantes['clave_determinante']; ?>" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap">Tipo  :</td>
      <td colspan="2"><select name="Tipo" id="Tipo">
        <?php
do {  
?>
        <option value="<?php echo $row_Tipo['id_determinante_tipo']?>"<?php if (!(strcmp($row_Tipo['id_determinante_tipo'], $row_Determinantes['id_determinante_tipo']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Tipo['deter_descripcion']?></option>
        <?php
} while ($row_Tipo = mysql_fetch_assoc($Tipo));
  $rows = mysql_num_rows($Tipo);
  if($rows > 0) {
      mysql_data_seek($Tipo, 0);
	  $row_Tipo = mysql_fetch_assoc($Tipo);
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
          <option value="<?php echo $row_Marca['id_determinante_marca']?>"<?php if (!(strcmp($row_Marca['id_determinante_marca'], $row_Determinantes['id_determinante_marca']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Marca['marca']?></option>
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
          <option value="<?php echo $row_Clasifica1['id_determinante_clasificacion1']?>"<?php if (!(strcmp($row_Clasifica1['id_determinante_clasificacion1'], $row_Determinantes['id_determinante_clasificacion1']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Clasifica1['clasificacion1']?></option>
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
          <option value="<?php echo $row_Clasifica2['id_determinante_clasificacion2']?>"<?php if (!(strcmp($row_Clasifica2['id_determinante_clasificacion2'], $row_Determinantes['id_determinante_clasificacion2']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Clasifica2['clasificacion2']?></option>
          <?php
} while ($row_Clasifica2 = mysql_fetch_assoc($Clasifica2));
  $rows = mysql_num_rows($Clasifica2);
  if($rows > 0) {
      mysql_data_seek($Clasifica2, 0);
	  $row_Clasifica2 = mysql_fetch_assoc($Clasifica2);
  }
?>
        </select>
      <label for="Tipo"></label></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap">Comodato :</td>
      <td align="center"><input <?php if (!(strcmp($row_Determinantes['comodato'],1))) {echo "checked=\"checked\"";} ?>  name="comodato" type="checkbox" id="comodato" /></td>
      <td><input name="comodato_fecha" type="text"
           class="alert-success" id="comodato_fecha" value="<?php echo $row_Determinantes['comodato_fecha']; ?>"readonly="readonly" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap">Donacion :</td>
      <td align="center"><input <?php if (!(strcmp($row_Determinantes['donacion'],1))) {echo "checked=\"checked\"";} ?>  type="checkbox" name="donacion" id="donacion" />
        <label for="donacion"></label></td>
      <td><label for="donacion_fecha"></label>
        <input name="donacion_fecha" type="text"
           class="alert-success" id="donacion_fecha" value="<?php echo $row_Determinantes['donacion_fecha']; ?>" 
readonly="readonly"      /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap">Descripción :</td>
      <td colspan="2"><input name="Descripcion" type="text" id="Descripcion" value="<?php echo $row_Determinantes['descripcion']; ?>" size="100" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap">Técnica :</td>
      <td colspan="2"><input name="tecnica" type="text" id="tecnica" value="<?php echo $row_Determinantes['tecnica']; ?>" size="100" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap">Autor :</td>
      <td colspan="2"><input name="autor" type="text" id="autor" value="<?php echo $row_Determinantes['autor']; ?>" size="100" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap">Cuenta : </td>
      <td colspan="2"><label for="cuenta"></label>
        <input name="cuenta" type="text" id="cuenta" value="<?php echo $row_Determinantes['cuenta']; ?>" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap">Cuenta 2 :</td>
      <td colspan="2"><label for="cuenta2"></label>
        <input name="cuenta2" type="text" id="cuenta2" value="<?php echo $row_Determinantes['cuenta2']; ?>" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap">cambs :</td>
      <td colspan="2"><input name="cambs" type="text" id="cambs" value="<?php echo $row_Determinantes['cambs']; ?>" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap">Costo :</td>
      <td colspan="2"><label for="cambs"></label>
        <label for="comodato_fecha">
          <input name="costo" type="text" id="costo" value="<?php echo $row_Determinantes['costo']; ?>" />
      </label></td>
    </tr>
    <!--Inicio: Bootstrap -->
    <tr>
      <td colspan="3" align="center" nowrap="nowrap"><!--Inicio: Bootstrap -->
        <p>&nbsp; </p>
        <input type="submit" 
         class="btn btn-success" 
         value="guardae registro" />
        <!--Fin: Bootstrap --></td>
    </tr>
    <!--Fin: Bootstrap -->
  </table>
  <input type="hidden" name="MM_update" value="form1" />
</form>
<a href="index.php">
   <button type="button" class="list-group-item-warning">
         <span class="glyphicon glyphicon-share-alt"></span> Regresar
</button>
</a>
</body>
</html>
<?php
mysql_free_result($Determinantes);

mysql_free_result($Tipo);

mysql_free_result($Marca);

mysql_free_result($Clasifica1);

mysql_free_result($Clasifica2);
?>
