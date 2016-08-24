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
  $updateSQL = sprintf("UPDATE asem SET no_socio=%s, idasem_canainpa=%s, rfc_socio=%s, razon_social_socio=%s, nombre_comercial=%s, Servicios=%s, Cuota=%s, total=%s, grupo_comercial=%s, contacto_cobranza=%s, Domicilio=%s, Telefono=%s, Email=%s, Contacto=%s, Mapa=%s, Ultimo_Pago_Fecha=%s, Ultimo_Fecha_Inicio=%s, Ultimo_Fecha_Fin=%s, password=%s WHERE idasem=%s",
                       GetSQLValueString($_POST['no_socio'], "text"),
                       GetSQLValueString($_POST['idasem_canainpa'], "int"),
                       GetSQLValueString($_POST['rfc_socio'], "text"),
                       GetSQLValueString($_POST['razon_social_socio'], "text"),
                       GetSQLValueString($_POST['nombre_comercial'], "text"),
                       GetSQLValueString($_POST['Servicios'], "text"),
                       GetSQLValueString($_POST['Cuota'], "text"),
                       GetSQLValueString($_POST['total'], "double"),
                       GetSQLValueString($_POST['grupo_comercial'], "text"),
                       GetSQLValueString($_POST['contacto_cobranza'], "text"),
                       GetSQLValueString($_POST['Domicilio'], "text"),
                       GetSQLValueString($_POST['Telefono'], "text"),
                       GetSQLValueString($_POST['Email'], "text"),
                       GetSQLValueString($_POST['Contacto'], "text"),
                       GetSQLValueString($_POST['Mapa'], "text"),
                       GetSQLValueString($_POST['Ultimo_Pago_Fecha'], "date"),
                       GetSQLValueString($_POST['Ultimo_Fecha_Inicio'], "date"),
                       GetSQLValueString($_POST['Ultimo_Fecha_Fin'], "date"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['idasem'], "int"));

  mysql_select_db($database_Canainpa, $Canainpa);
  $Result1 = mysql_query($updateSQL, $Canainpa) or die(mysql_error());

  $updateGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_Socio_Asem = "-1";
if (isset($_GET['idasem'])) {
  $colname_Socio_Asem = $_GET['idasem'];
}
mysql_select_db($database_Canainpa, $Canainpa);
$query_Socio_Asem = sprintf("SELECT * FROM asem WHERE idasem = %s", GetSQLValueString($colname_Socio_Asem, "int"));
$Socio_Asem = mysql_query($query_Socio_Asem, $Canainpa) or die(mysql_error());
$row_Socio_Asem = mysql_fetch_assoc($Socio_Asem);
$totalRows_Socio_Asem = mysql_num_rows($Socio_Asem);

mysql_select_db($database_Canainpa, $Canainpa);
$query_Cana = "SELECT * FROM canainpa ORDER BY no_socio ASC";
$Cana = mysql_query($query_Cana, $Canainpa) or die(mysql_error());
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
  <h1>Editar Socio Asem</h1>
  </p>
</blockquote>
<!--Fin:  Bootstrap -->
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">No Socio:</td>
      <td><input type="text" name="no_socio" value="<?php echo htmlentities($row_Socio_Asem['no_socio'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">No de Socio Canainpa:</td>
      <td><select name="idasem_canainpa">
        <?php 
do {  
?>
        <option value="<?php echo $row_Cana['idcanainpa']?>" <?php if (!(strcmp($row_Cana['idcanainpa'], htmlentities($row_Socio_Asem['idasem_canainpa'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_Cana['no_socio']?></option>
        <?php
} while ($row_Cana = mysql_fetch_assoc($Cana));
?>
      </select></td>
    </tr>
    <tr> </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">R.F.C.:</td>
      <td><input type="text" name="rfc_socio" value="<?php echo htmlentities($row_Socio_Asem['rfc_socio'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right" valign="top">Razon Social:</td>
      <td><textarea name="razon_social_socio" cols="50" rows="5"><?php echo htmlentities($row_Socio_Asem['razon_social_socio'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right" valign="top">Nombre Comercial:</td>
      <td><textarea name="nombre_comercial" cols="50" rows="5"><?php echo htmlentities($row_Socio_Asem['nombre_comercial'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right" valign="top">Servicios:</td>
      <td><textarea name="Servicios" cols="50" rows="5"><?php echo htmlentities($row_Socio_Asem['Servicios'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right" valign="top">Cuota:</td>
      <td><textarea name="Cuota" cols="50" rows="5"><?php echo htmlentities($row_Socio_Asem['Cuota'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Total:</td>
      <td><input type="text" name="total" value="<?php echo htmlentities($row_Socio_Asem['total'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right" valign="top">Grupo Comercial:</td>
      <td><textarea name="grupo_comercial" cols="50" rows="5"><?php echo htmlentities($row_Socio_Asem['grupo_comercial'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right" valign="top">Contacto Cobranza:</td>
      <td><textarea name="contacto_cobranza" cols="50" rows="5"><?php echo htmlentities($row_Socio_Asem['contacto_cobranza'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right" valign="top">Domicilio:</td>
      <td><textarea name="Domicilio" cols="50" rows="5"><?php echo htmlentities($row_Socio_Asem['Domicilio'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right" valign="top">Telefono:</td>
      <td><textarea name="Telefono" cols="50" rows="5"><?php echo htmlentities($row_Socio_Asem['Telefono'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right" valign="top">Email:</td>
      <td><textarea name="Email" cols="50" rows="5"><?php echo htmlentities($row_Socio_Asem['Email'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right" valign="top">Contacto:</td>
      <td><textarea name="Contacto" cols="50" rows="5"><?php echo htmlentities($row_Socio_Asem['Contacto'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right" valign="top">Mapa:</td>
      <td><textarea name="Mapa" cols="50" rows="5"><?php echo htmlentities($row_Socio_Asem['Mapa'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Ultima Fecha de Pago:</td>
      <td><input type="text" name="Ultimo_Pago_Fecha" value="<?php echo htmlentities($row_Socio_Asem['Ultimo_Pago_Fecha'], ENT_COMPAT, 'utf-8'); ?>" size="32" 
           readonly="readonly"
           class="alert-success"
          /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Fecha Inicio del Servicio:</td>
      <td><input type="text" name="Ultimo_Fecha_Inicio" value="<?php echo htmlentities($row_Socio_Asem['Ultimo_Fecha_Inicio'], ENT_COMPAT, 'utf-8'); ?>" size="32" 
           readonly="readonly"
           class="alert-success"
          /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Fecha Fin del Servicio:</td>
      <td><input type="text" name="Ultimo_Fecha_Fin" value="<?php echo htmlentities($row_Socio_Asem['Ultimo_Fecha_Fin'], ENT_COMPAT, 'utf-8'); ?>" size="32" 
           readonly="readonly"
           class="alert-success"
          /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Password:</td>
      <td><input type="text" name="password" value="<?php echo htmlentities($row_Socio_Asem['password'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
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
  <input type="hidden" name="idasem" value="<?php echo $row_Socio_Asem['idasem']; ?>" />
  <input type="hidden" name="MM_update" value="form1" />
  
</form>


<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Socio_Asem);

mysql_free_result($Cana);
?>
