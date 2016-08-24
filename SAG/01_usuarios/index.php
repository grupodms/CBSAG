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

mysql_select_db($database_SAG, $SAG);
$query_Area3 = "SELECT usuario.id_usuario, usuario.email, usuario.`password`, usuario.reset_password, usuario.menu, usuario.id_perfil, usuario.nombre, usuario.apellido_paterno, usuario.apellido_materno, usuario.todos_dependencias, usuario.id_dependencia, dependencia.clave_dependencia, dependencia.depen_descripcion FROM usuario INNER JOIN dependencia ON usuario.id_dependencia = dependencia.id_dependencia ORDER BY usuario.email ASC";
$Area3 = mysql_query($query_Area3, $SAG) or die(mysql_error());
$row_Area3 = mysql_fetch_assoc($Area3);
$totalRows_Area3 = mysql_num_rows($Area3);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<!--Inicio:  Bootstrap -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="../css/bootstrap.min.css" rel="stylesheet">
<title>Usuarios</title>
<!--Fin: Script Bootstrap --> 

</head>

<body>

<!--Inicio: Script Bootstrap -->
<script>
function confirmar()
{
	if(confirm('¿Estas seguro de eliminar este Registro?'))
		return true;
	else
		return false;
}
</script>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../js/bootstrap.min.js"></script>
<!--Fin: Script Bootstrap -->  

<!--Menu -->
<?PHP 
$adm_Usuario   = $_COOKIE ["usuario_global"]; 

?>
<?PHP $menu = 1; ?>
<?PHP require_once('../barra01.php'); ?>
<!--Menu -->

<!--Inicio:  Bootstrap -->
<blockquote>
  <p>
  <h1>Usuarios.</h1> 
  
  </p>
</blockquote>
&nbsp;

<a href="nuevo.php">
<button type="button" class="btn btn-success">
                         <span class="glyphicon glyphicon-pencil"></span>Nuevo
</button>
</a>


<table width="100%" border="0" align="center" class="table table-hover">
    
    <tr class="info">
      <td>id</td>
      <td>Todos Dependencias</td>
      <td colspan="3">Dependencia</td>
      <td>Email</td>
      <td colspan="3">Nombre </td>
      
      
      <td colspan="3" align="center">Acciones </td>
    </tr>	
<?php do { ?>

    <tr>
      <td><?php echo $row_Area3['id_usuario']; ?></td>
      <td><?php echo $row_Area3['todos_dependencias']; ?></td>
      <td><?php echo $row_Area3['id_dependencia']; ?></td>
      <td><?php echo $row_Area3['depen_descripcion']; ?></td>
      <td><?php echo $row_Area3['email']; ?></td>
      <td><?php echo $row_Area3['nombre']; ?></td>
      <td><?php echo $row_Area3['apellido_paterno']; ?></td>
      <td><?php echo $row_Area3['apellido_materno']; ?></td>
      <td></td>
      <td><a href="editar.php?id_usuario=<?PHP echo $row_Area3['id_usuario'];?>  ">
        <button type="button" class="btn btn-success"> <span class="glyphicon glyphicon-pencil"></span>Editar </button>
      </a></td>
      <td><a href="eliminar.php?id_usuario=<?PHP echo $row_Area3['id_usuario'];?>"
      onclick="return confirmar()">
        <button type="button" class="btn btn-danger"> <span class="glyphicon glyphicon-trash"></span> Eliminar </button>
      </a></td>
    </tr>

  <?php } while ($row_Area3 = mysql_fetch_assoc($Area3)); ?>
</table>

</body>
</html>
<?php
mysql_free_result($Area3);
?>
