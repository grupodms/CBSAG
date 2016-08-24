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
  $updateSQL = sprintf("UPDATE usuario SET password=%s, reset_password=%s, menu=%s, id_perfil=%s, nombre=%s, apellido_paterno=%s, apellido_materno=%s, todos_dependencias=%s, id_dependencia=%s, telefono=%s, celular=%s, whatsapp=%s, email_personal=%s, email_trabajo=%s WHERE id_usuario=%s AND email=%s",
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString(isset($_POST['reset_password']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['menu'], "text"),
                       GetSQLValueString($_POST['id_perfil'], "int"),
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['apellido_paterno'], "text"),
                       GetSQLValueString($_POST['apellido_materno'], "text"),
                       GetSQLValueString(isset($_POST['todos_dependencias']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['id_dependencia'], "int"),
                       GetSQLValueString($_POST['telefono'], "text"),
                       GetSQLValueString($_POST['celular'], "text"),
                       GetSQLValueString(isset($_POST['whatsapp']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['email_personal'], "text"),
                       GetSQLValueString($_POST['email_trabajo'], "text"),
                       GetSQLValueString($_POST['id_usario'], "int"),
                       GetSQLValueString($_POST['email'], "text"));

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
if (isset($_GET['id_usuario'])) {
  $colname_Recordset1 = $_GET['id_usuario'];
}
mysql_select_db($database_SAG, $SAG);
$query_Recordset1 = sprintf("SELECT * FROM usuario WHERE id_usuario = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $SAG) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_SAG, $SAG);
$query_Dependencias = "SELECT * FROM dependencia ORDER BY clave_dependencia ASC";
$Dependencias = mysql_query($query_Dependencias, $SAG) or die(mysql_error());
$row_Dependencias = mysql_fetch_assoc($Dependencias);
$totalRows_Dependencias = mysql_num_rows($Dependencias);

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

<title>Editar Usuario</title>
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
  <h1>Editar Usuario </h1>
  </p>
</blockquote>
<!--Fin:  Bootstrap -->
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">id</td>
      <td><label for="id_usario"></label>
      <input name="id_usario" type="text" class="bg-success" id="id_usario" value="<?php echo $row_Recordset1['id_usuario']; ?>" readonly="readonly" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">email</td>
      <td><label for="email"></label>
      <input name="email" type="text" id="email" value="<?php echo $row_Recordset1['email']; ?>" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Pasword</td>
      <td><label for="password"></label>
      <input name="password" type="text" id="password" value="<?php echo $row_Recordset1['password']; ?>" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Usuario Cambie Contraseña : </td>
      <td><input <?php if (!(strcmp($row_Recordset1['reset_password'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" name="reset_password" id="reset_password" />
      <label for="reset_password"></label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Menu Asgnado:</td>
      <td><label for="menu"></label>
      <input name="menu" type="text" id="menu" value="<?php echo $row_Recordset1['menu']; ?>" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Perfil:</td>
      <td><label for="id_perfil"></label>
        <select name="id_perfil" id="id_perfil">
          <option value="0" <?php if (!(strcmp(0, $row_Recordset1['id_perfil']))) {echo "selected=\"selected\"";} ?>>Administrador</option>
          <option value="1" <?php if (!(strcmp(1, $row_Recordset1['id_perfil']))) {echo "selected=\"selected\"";} ?>>Almacen General</option>
          <option value="2" <?php if (!(strcmp(2, $row_Recordset1['id_perfil']))) {echo "selected=\"selected\"";} ?>>Coordinador</option>
          <option value="3" <?php if (!(strcmp(3, $row_Recordset1['id_perfil']))) {echo "selected=\"selected\"";} ?>>Responsable Plantel</option>
          <option value="4" <?php if (!(strcmp(4, $row_Recordset1['id_perfil']))) {echo "selected=\"selected\"";} ?>>Almacen Plantel</option>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Nombre:</td>
      <td><label for="nombre"></label>
      <input name="nombre" type="text" id="nombre" value="<?php echo $row_Recordset1['nombre']; ?>" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Paterno:</td>
      <td><label for="apellido_paterno"></label>
      <input name="apellido_paterno" type="text" id="apellido_paterno" value="<?php echo $row_Recordset1['apellido_paterno']; ?>" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Materno:</td>
      <td><label for="des_area">
        <input name="apellido_materno" type="text" id="apellido_paterno2" value="<?php echo $row_Recordset1['apellido_materno']; ?>" />
      </label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Todas Dependencias:</td>
      <td><input <?php if (!(strcmp($row_Recordset1['todos_dependencias'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" name="todos_dependencias" id="todos_dependencias" />
      <label for="todos_dependencias"></label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Dependencia:</td>
      <td><label for="id_dependencia"></label>
        <select name="id_dependencia" id="id_dependencia">
          <?php
do {  
?>
          <option value="<?php echo $row_Dependencias['id_dependencia']?>"<?php if (!(strcmp($row_Dependencias['id_dependencia'], $row_Recordset1['id_dependencia']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Dependencias['depen_descripcion']?></option>
          <?php
} while ($row_Dependencias = mysql_fetch_assoc($Dependencias));
  $rows = mysql_num_rows($Dependencias);
  if($rows > 0) {
      mysql_data_seek($Dependencias, 0);
	  $row_Dependencias = mysql_fetch_assoc($Dependencias);
  }
?>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Telefono Local :</td>
      <td><label for="telefono"></label>
      <input name="telefono" type="text" id="telefono" value="<?php echo $row_Recordset1['telefono']; ?>" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Celular : </td>
      <td><input name="celular" type="text" id="celular" value="<?php echo $row_Recordset1['celular']; ?>" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">whatsapp</td>
      <td><input <?php if (!(strcmp($row_Recordset1['whatsapp'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" name="whatsapp" id="whatsapp" />
      <label for="whatsapp"></label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Email Personal:</td>
      <td><input name="email_personal" type="text" id="email_personal" value="<?php echo $row_Recordset1['email_personal']; ?>" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Email Trabajo:</td>
      <td><input name="email_trabajo" type="text" id="email_trabajo" value="<?php echo $row_Recordset1['email_trabajo']; ?>" /></td>
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


<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Dependencias);
?>
