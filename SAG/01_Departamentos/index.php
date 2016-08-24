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
$id_dependencia = "-1";
if (isset($_COOKIE ["id_dependencia"])){
$id_dependencia = $_COOKIE ["id_dependencia"];}

$id_area = "-1";
if (isset($_COOKIE ["id_area"])) {
  $id_area = $_COOKIE ["id_area"];
}

mysql_select_db($database_SAG, $SAG);
$query_Consecutivo = sprintf("SELECT
consecutivo.id_consecutivo,
consecutivo.id_dependencia,
consecutivo.clave_conse,
consecutivo.descripcion_consecutivo,
dependencia.depen_descripcion,
consecutivo.id_area,
area.clave_area,
area.des_area
FROM
consecutivo
INNER JOIN dependencia ON consecutivo.id_dependencia = dependencia.id_dependencia
INNER JOIN area ON consecutivo.id_area = area.id_area WHERE consecutivo.id_dependencia= %s  
ORDER BY clave_area, clave_conse ASC", 
GetSQLValueString($id_dependencia, "int")
);
$Consecutivo = mysql_query($query_Consecutivo, $SAG) or die(mysql_error());
$row_Consecutivo = mysql_fetch_assoc($Consecutivo);
$totalRows_Consecutivo = mysql_num_rows($Consecutivo);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<!--Inicio:  Bootstrap -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="../css/bootstrap.min.css" rel="stylesheet">
<title>Consecutivos /Departamentos de Asignación.</title>
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
  <h1>Consecutivos /Departamentos de Asignación.</h1> 
  
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
      <td colspan="2">Dependencia</td>
      <td colspan="2">Area</td>
      <td>Departamento</td>
      <td>Descripción </td>
      
      
      <td colspan="3" align="center">Acciones </td>
    </tr>	
<?php do { ?>

    <tr>
      <td><?php echo $row_Consecutivo['id_consecutivo']; ?></td>
      <td><?php echo $row_Consecutivo['id_dependencia']; ?></td>
      <td><?php echo $row_Consecutivo['depen_descripcion']; ?></td>
      <td><?php echo $row_Consecutivo['clave_area']; ?></td>
      <td><?php echo $row_Consecutivo['des_area']; ?></td>
      <td><?php echo $row_Consecutivo['clave_conse']; ?></td>
      <td><?php echo $row_Consecutivo['descripcion_consecutivo']; ?></td>
      <td></td>
      <td><a href="editar.php?id_consecutivo=<?PHP echo $row_Consecutivo['id_consecutivo'];?>  ">
        <button type="button" class="btn btn-success"> <span class="glyphicon glyphicon-pencil"></span>Editar </button>
      </a></td>
      <td><a href="eliminar.php?id_consecutivo=<?PHP echo $row_Consecutivo['id_consecutivo'];?>"
      onclick="return confirmar()">
        <button type="button" class="btn btn-danger"> <span class="glyphicon glyphicon-trash"></span> Eliminar </button>
      </a></td>
    </tr>

  <?php } while ($row_Consecutivo = mysql_fetch_assoc($Consecutivo)); ?>
  </table>

</body>
</html>
<?php
mysql_free_result($Consecutivo);


?>
