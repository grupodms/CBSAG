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
  $updateSQL = sprintf("UPDATE empleado SET id_dependencia = %s  WHERE id_empleado = %s",
GetSQLValueString($_POST['id_dependencia'], "int"),
GetSQLValueString($_POST['id_empleado'], "int"));

mysql_select_db($database_SAG, $SAG);
echo "1 ==  ".$updateSQL."<BR>";
$Result1 = mysql_query($updateSQL, $SAG) or die(mysql_error());

  $updateGoTo = "index2.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_Reg_Det = "-1";
if (isset($_GET['id_empleado'])) {
  $colname_Reg_Det = $_GET['id_empleado'];
}
mysql_select_db($database_SAG, $SAG);
$query_Reg_Det = sprintf("SELECT * FROM empleado WHERE id_empleado = %s", GetSQLValueString($colname_Reg_Det, "int"));
$Reg_Det = mysql_query($query_Reg_Det, $SAG) or die(mysql_error());
$row_Reg_Det = mysql_fetch_assoc($Reg_Det);
$totalRows_Reg_Det = mysql_num_rows($Reg_Det);

mysql_select_db($database_SAG, $SAG);
$query_dEPENDENCIAS = "SELECT * FROM dependencia ORDER BY depen_descripcion ASC";
$dEPENDENCIAS = mysql_query($query_dEPENDENCIAS, $SAG) or die(mysql_error());
$row_dEPENDENCIAS = mysql_fetch_assoc($dEPENDENCIAS);
$totalRows_dEPENDENCIAS = mysql_num_rows($dEPENDENCIAS);
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
  <h1>Editar Empleado </h1>
  </p>

</blockquote>

<!--Fin:  Bootstrap -->
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1">
  <input  name="id_empleado" type="hidden" id="id_empleado" value="<?php echo $row_Reg_Det['id_empleado']; ?>" readonly="readonly" />
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Matricula :</td>
      <td><label for="clave"></label>
      <input name="matricula" type="text" id="matricula" value="<?php echo $row_Reg_Det['matricula']; ?>" readonly="readonly" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">RFC :</td>
      <td align="left"><label for="rfc"></label>
      <input name="rfc" type="text" id="rfc" value="<?php echo $row_Reg_Det['rfc']; ?>" readonly="readonly" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">CURP :</td>
      <td align="left"><label for="curp"></label>
      <input name="curp" type="text" id="curp" value="<?php echo $row_Reg_Det['curp']; ?>" readonly="readonly" />        <label for="donacion_fecha"></label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">NOMBRE : </td>
      <td><label for="cuenta">
        <input name="nombre" type="text" id="nombre" value="<?php echo $row_Reg_Det['nombre']; ?>" size="80" readonly="readonly" />
      </label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">PUESTO :</td>
      <td><label for="puesto"></label>
      <input name="puesto" type="text" id="puesto" value="<?php echo $row_Reg_Det['puesto']; ?>" readonly="readonly" /></td>
    </tr>
    <tr valign="baseline">
      <td height="42" align="right" nowrap="nowrap">ADSCRIPCION:</td>
      <td><input name="puesto2" type="text" id="puesto2" value="<?php echo $row_Reg_Det['adcripcion']; ?>" size="80" readonly="readonly" /></td>
    </tr>
    <tr valign="baseline">
      <td height="42" align="right" nowrap="nowrap">Depedencia :</td>
      <td><label for="cuenta2">
        <select name="id_dependencia" id="id_depedencia">
          <?php
do {  
?>
          <option value="<?php echo $row_dEPENDENCIAS['id_dependencia']?>"<?php if (!(strcmp($row_dEPENDENCIAS['id_dependencia'], $row_Reg_Det['id_dependencia']))) {echo "selected=\"selected\"";} ?>><?php echo $row_dEPENDENCIAS['depen_descripcion']?></option>
          <?php
} while ($row_dEPENDENCIAS = mysql_fetch_assoc($dEPENDENCIAS));
  $rows = mysql_num_rows($dEPENDENCIAS);
  if($rows > 0) {
      mysql_data_seek($dEPENDENCIAS, 0);
	  $row_dEPENDENCIAS = mysql_fetch_assoc($dEPENDENCIAS);
  }
?>
        </select>
      </label></td>
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
mysql_free_result($Reg_Det);

mysql_free_result($dEPENDENCIAS);
?>
