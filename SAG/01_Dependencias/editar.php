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
  $updateSQL = sprintf("UPDATE dependencia SET clave_dependencia=%s, depen_descripcion=%s, cedula_elaboro_nombre=%s, cedula_elaboro_puesto=%s, cedula_reviso1_nombre=%s, cedula_reviso1_puesto=%s, cedula_reviso2_nombre=%s, cedula_reviso2_puesto=%s, cedula_vistobueno_nombre=%s, cedula_vistobueno_puesto=%s WHERE id_dependencia=%s",
                       GetSQLValueString($_POST['clave_dependencia'], "text"),
                       GetSQLValueString($_POST['depen_descripcion'], "text"),
                       GetSQLValueString($_POST['cedula_elaboro_nombre'], "text"),
                       GetSQLValueString($_POST['cedula_elaboro_puesto'], "text"),
                       GetSQLValueString($_POST['cedula_reviso1_nombre'], "text"),
                       GetSQLValueString($_POST['cedula_reviso1_puesto'], "text"),
                       GetSQLValueString($_POST['cedula_reviso2_nombre'], "text"),
                       GetSQLValueString($_POST['cedula_reviso2_puesto'], "text"),
                       GetSQLValueString($_POST['cedula_vistobueno_nombre'], "text"),
                       GetSQLValueString($_POST['cedula_vistobueno_puesto'], "text"),
                       GetSQLValueString($_POST['id_dependencia'], "int"));

  mysql_select_db($database_SAG, $SAG);
  $Result1 = mysql_query($updateSQL, $SAG) or die(mysql_error());

  $updateGoTo = "../menu_1.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_dependencia = "-1";
if (isset($_COOKIE ['id_dependencia'])) {
  $colname_dependencia = $_COOKIE ['id_dependencia'];
}
mysql_select_db($database_SAG, $SAG);
$query_dependencia = sprintf("SELECT * FROM dependencia WHERE id_dependencia = %s", GetSQLValueString($colname_dependencia, "int"));
$dependencia = mysql_query($query_dependencia, $SAG) or die(mysql_error());
$row_dependencia = mysql_fetch_assoc($dependencia);
$totalRows_dependencia = mysql_num_rows($dependencia);

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
  <h1>Parámetros Dependencia</h1>
  </p>
</blockquote>
<!--Fin:  Bootstrap -->
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1">
<input name="id_dependencia" type="hidden" id="id_dependencia" value="<?php echo $row_dependencia['id_dependencia']; ?>" size="32" />
  <table align="center">
    <tr valign="baseline">
      <td width="114" align="right" nowrap="nowrap" style="border: 1px solid black;
    border-collapse: collapse; "><p align="right">Clave :</p></td>
      <td colspan="2" style="border: 1px solid black;
    border-collapse: collapse; "> <p align="left"> <input name="clave_dependencia" type="text" class="alert-success" id="clave_dependencia" value="<?php echo $row_dependencia['clave_dependencia']; ?>" size="10" readonly="readonly" /> </p></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right" style="border: 1px solid black;
    border-collapse: collapse; "><p align="right">Dependencia :</p></td>
      <td colspan="2" style="border: 1px solid black;
    border-collapse: collapse; "><p align="left"> <input name="depen_descripcion" type="text" class="alert-success" id="depen_descripcion" value="<?php echo $row_dependencia['depen_descripcion']; ?>" size="50" readonly="readonly" /></p></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td width="104"
style="border: 1px solid black;
    border-collapse: collapse; ">
    Nombre</td>
      <td width="141"
style="border: 1px solid black;
    border-collapse: collapse; "      >Puesto</td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"
style="border: 1px solid black;
    border-collapse: collapse; "
><p align="right">Elaboro ;</p></td>
      <td style="border: 1px solid black;
    border-collapse: collapse; ">
      <input name="cedula_elaboro_nombre" type="text" id="cedula_elaboro_nombre" value="<?php echo $row_dependencia['cedula_elaboro_nombre']; ?>" /></td>
      <td style="border: 1px solid black;
    border-collapse: collapse; "><input name="cedula_elaboro_puesto" type="text" id="cedula_elaboro_puesto" value="<?php echo $row_dependencia['cedula_elaboro_puesto']; ?>" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"
style="border: 1px solid black;
    border-collapse: collapse; "      ><p align="right">Reviso 1 ;</p></td>
      <td style="border: 1px solid black;
    border-collapse: collapse; "><input name="cedula_reviso1_nombre" type="text" id="cedula_reviso1_nombre" value="<?php echo $row_dependencia['cedula_reviso1_nombre']; ?>" /></td>
      <td style="border: 1px solid black;
    border-collapse: collapse; "><input name="cedula_reviso1_puesto" type="text" id="cedula_reviso1_puesto" value="<?php echo $row_dependencia['cedula_reviso1_puesto']; ?>" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right" 
style="border: 1px solid black;
    border-collapse: collapse; "
          ><p align="right">Reviso 2 :</p></td>
      <td style="border: 1px solid black;
    border-collapse: collapse; "><input name="cedula_reviso2_nombre" type="text" id="cedula_reviso2_nombre" value="<?php echo $row_dependencia['cedula_reviso2_nombre']; ?>" /></td>
      <td style="border: 1px solid black;
    border-collapse: collapse; "><input name="cedula_reviso2_puesto" type="text" id="cedula_reviso2_puesto" value="<?php echo $row_dependencia['cedula_reviso2_puesto']; ?>" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"
style="border: 1px solid black;
    border-collapse: collapse; "
          ><p align="right">Visto Bueno :</p></td>
      <td style="border: 1px solid black;
    border-collapse: collapse; "><input name="cedula_vistobueno_nombre" type="text" id="cedula_vistobueno_nombre" value="<?php echo $row_dependencia['cedula_vistobueno_nombre']; ?>" /></td>
      <td style="border: 1px solid black;
    border-collapse: collapse; "><input name="cedula_vistobueno_puesto" type="text" id="cedula_vistobueno_puesto" value="<?php echo $row_dependencia['cedula_vistobueno_puesto']; ?>" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td colspan="2"><label for="depen_descripcion"></label></td>
    </tr>



     <!--Inicio: Bootstrap -->
    <Tr>
      <td colspan="3" align="center" nowrap="nowrap">
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
mysql_free_result($dependencia);
?>
