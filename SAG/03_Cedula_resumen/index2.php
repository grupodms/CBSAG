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

$colname_cedula_resumen = "-1";
if (isset($_COOKIE ["id_dependencia"])) {
  $colname_cedula_resumen = $_COOKIE ["id_dependencia"];
}
mysql_select_db($database_SAG, $SAG);
$query_cedula_resumen = sprintf("SELECT cedula_resumen.id_cedula_resumen, periodo.semestre, dependencia.clave_dependencia, dependencia.depen_descripcion FROM cedula_resumen INNER JOIN periodo ON cedula_resumen.id_periodo = periodo.id_periodo INNER JOIN dependencia ON cedula_resumen.id_dependencia = dependencia.id_dependencia WHERE cedula_resumen.id_dependencia = %s ", GetSQLValueString($colname_cedula_resumen, "int"));
$cedula_resumen = mysql_query($query_cedula_resumen, $SAG) or die(mysql_error());
$row_cedula_resumen = mysql_fetch_assoc($cedula_resumen);
$totalRows_cedula_resumen = mysql_num_rows($cedula_resumen);mysql_select_db($database_SAG, $SAG);
$query_cedula_resumen = "SELECT cedula_resumen.id_cedula_resumen, periodo.semestre, dependencia.clave_dependencia, dependencia.depen_descripcion FROM cedula_resumen INNER JOIN periodo ON cedula_resumen.id_periodo = periodo.id_periodo INNER JOIN dependencia ON cedula_resumen.id_dependencia = dependencia.id_dependencia ";
$cedula_resumen = mysql_query($query_cedula_resumen, $SAG) or die(mysql_error());
$row_cedula_resumen = mysql_fetch_assoc($cedula_resumen);
$totalRows_cedula_resumen = mysql_num_rows($cedula_resumen);


///////////////////////////////////


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<!--Inicio:  Bootstrap -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="../css/bootstrap.min.css" rel="stylesheet">
<title>Socios ASEM</title>
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
$adm_Nombre    = $_COOKIE ["nombre"]; 
$adm_Perfil    = $_COOKIE ["id_perfil"]; 
?>
<?PHP $menu = 1; ?>
<?PHP require_once('../barra01.php'); ?>
<!--Menu -->

<!--Inicio:  Bootstrap -->
<blockquote>
  <p>
  <h1>Cedulas Resumen.</h1> 
  
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
      <td>Periodo</td>
      <td colspan="4" align="center">Acciones </td>
    </tr>	
<?php do { ?>

    <tr>
      <td><?php echo $row_cedula_resumen['id_cedula_resumen']; ?></td>
      <td><?php echo $row_cedula_resumen['clave_dependencia']; ?></td>
      <td><?php echo $row_cedula_resumen['depen_descripcion']; ?></td>
      <td><?php echo $row_cedula_resumen['semestre']; ?></td>
      <td></td>
      <td><a href="determinantes_index.php?id_cedula_resumen=<?PHP echo $row_cedula_resumen['id_cedula_resumen'];?>  ">
      <button type="button" class="btn btn-primary"> <span class="glyphicon glyphicon-pencil"></span> Determinantes </button>
      </a></td>
      <td><a href="editar.php?id_cedula_resumen=<?PHP echo $row_cedula_resumen['id_cedula_resumen'];?>  ">
      <button type="button" class="btn btn-success"> <span class="glyphicon glyphicon-pencil"></span>Editar </button>
      </a></td>
      <td><a href="eliminar.php?id_cedula_resumen=<?PHP echo $row_cedula_resumen['id_cedula_resumen'];?>"
      onclick="return confirmar()">
        <button type="button" class="btn btn-danger"> <span class="glyphicon glyphicon-trash"></span> Eliminar </button>
      </a></td>
    </tr>

  <?php } while ($row_cedula_resumen = mysql_fetch_assoc($cedula_resumen)); ?>
  </table>

</body>
</html>
<?php
mysql_free_result($cedula_resumen);
?>
