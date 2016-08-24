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
  $updateSQL = sprintf("UPDATE determinante_tipo SET deter_descripcion=%s WHERE id_determinante_tipo=%s",
                       GetSQLValueString($_POST['Descripcion'], "text"),
                       GetSQLValueString($_POST['clave'], "int"));

  mysql_select_db($database_SAG, $SAG);
  $Result1 = mysql_query($updateSQL, $SAG) or die(mysql_error());

  $updateGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_Rec_tipo_determinante = "-1";
if (isset($_GET['id_determinante_tipo'])) {
  $colname_Rec_tipo_determinante = $_GET['id_determinante_tipo'];
}
mysql_select_db($database_SAG, $SAG);
$query_Rec_tipo_determinante = sprintf("SELECT * FROM determinante_tipo WHERE id_determinante_tipo = %s", GetSQLValueString($colname_Rec_tipo_determinante, "int"));
$Rec_tipo_determinante = mysql_query($query_Rec_tipo_determinante, $SAG) or die(mysql_error());
$row_Rec_tipo_determinante = mysql_fetch_assoc($Rec_tipo_determinante);
$totalRows_Rec_tipo_determinante = mysql_num_rows($Rec_tipo_determinante);$colname_Rec_tipo_determinante = "-1";
if (isset($_GET['id_determinante_tipo'])) {
  $colname_Rec_tipo_determinante = $_GET['id_determinante_tipo'];
}
mysql_select_db($database_SAG, $SAG);
$query_Rec_tipo_determinante = sprintf("SELECT * FROM determinante_tipo WHERE id_determinante_tipo = %s", GetSQLValueString($colname_Rec_tipo_determinante, "int"));
$Rec_tipo_determinante = mysql_query($query_Rec_tipo_determinante, $SAG) or die(mysql_error());
$row_Rec_tipo_determinante = mysql_fetch_assoc($Rec_tipo_determinante);
$totalRows_Rec_tipo_determinante = mysql_num_rows($Rec_tipo_determinante);
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
  <h1>Editar Tipo de Determinante</h1>
  </p>

</blockquote>
<!--Fin:  Bootstrap -->
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">ID :</td>
      <td><label for="clave"></label>
      <input name="clave" type="text" class="alert-success" id="clave" value="<?php echo $row_Rec_tipo_determinante['id_determinante_tipo']; ?>"readonly="readonly" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Descripción :</td>
      <td><input name="Descripcion" type="text" id="Descripcion" value="<?php echo $row_Rec_tipo_determinante['deter_descripcion']; ?>" size="80" /></td>
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
mysql_free_result($Rec_tipo_determinante);
?>
