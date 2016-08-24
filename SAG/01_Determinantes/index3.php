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

$colname_cedula = "-1";
if (isset($_GET['id_determinantes'])) {
  $colname_cedula = $_GET['id_determinantes'];
}
mysql_select_db($database_SAG, $SAG);
$query2_cedula = "SELECT
cedula_resumen_partidas.id_determinantes,
Sum(cedula_resumen_partidas.cantidad) AS tot
FROM
cedula_resumen_partidas
where id_determinantes = %s
GROUP BY
cedula_resumen_partidas.id_determinantes
 ";
$query_cedula = sprintf($query2_cedula, GetSQLValueString($colname_cedula, "int"));
$cedula = mysql_query($query_cedula, $SAG) or die(mysql_error());
$row_cedula = mysql_fetch_assoc($cedula);
$totalRows_cedula = mysql_num_rows($cedula);

mysql_select_db($database_SAG, $SAG);
$query_Reg_Deter = "SELECT determinantes.* , determinante_tipo.id_determinante_tipo, determinante_tipo.deter_descripcion, determinantes.id_determinantes, determinantes.clave_determinante, determinantes.id_determinante_tipo, determinantes.comodato, determinantes.comodato_fecha, determinantes.donacion, determinantes.donacion_fecha, determinantes.descripcion, determinantes.cuenta, determinantes.cuenta2, determinantes.cambs
FROM determinantes INNER JOIN determinante_tipo ON determinantes.id_determinante_tipo = determinante_tipo.id_determinante_tipo
ORDER BY
determinantes.clave_determinante ASC
; ";
$Reg_Deter = mysql_query($query_Reg_Deter, $SAG) or die(mysql_error());
$row_Reg_Deter = mysql_fetch_assoc($Reg_Deter);
$totalRows_Reg_Deter = mysql_num_rows($Reg_Deter);

mysql_select_db($database_SAG, $SAG);

if ((isset($_POST["buscar"])) &&  
    (isset($_POST["campo"]))  &&
	(isset($_POST["boton_buscar"])))
{
$buscar =$_POST["buscar"];
$campo  =$_POST["campo"];
$query_V_ASEM = "
   SELECT * 
     FROM areas 
          Where ".$campo." LIKE '%".$buscar."%'";

}
else
{
	
$query_V_ASEM = "
   SELECT * 
     FROM areas";
}



$V_ASEM = mysql_query($query_V_ASEM, $SAG);
# or die(mysql_error());
$row_V_ASEM = mysql_fetch_assoc($V_ASEM);
$totalRows_V_ASEM = mysql_num_rows($V_ASEM);
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
  <h1>Determinantes</h1> 
  
  </p>
</blockquote>
<table width="100%" border="0" align="center" class="table table-hover">

  <tr class="info">
    <td colspan="4">id</td>
    <td>Clave</td>
    <td>Tipo</td>
    <td>Descripcion </td>
    <td>Cuenta</td>
    <td>Cuenta 2 </td>

    
    <td align="center">Cambs</td>
    <td colspan="2" align="center">Comodato</td>
    <td colspan="2" align="center">Donacion</td>
    <td colspan="2" align="center">Acciones</td>
  </tr>
  <?PHP $cCla = ""; ?>
  <?php do { ?>
  <tr>
    <td colspan="4"><?php echo $row_Reg_Deter['id_determinantes']; ?></td>
      <td rowspan="3"
      
      <?PHP if ($cCla == $row_Reg_Deter['clave_determinante'] ) { ?>
      bgcolor="#FF0000" 
      <?PHP } ?>
      >   
               
        <?php echo $row_Reg_Deter['clave_determinante']; ?>
        <?PHP $cCla = $row_Reg_Deter['clave_determinante']; ?>
      </td>
   <td rowspan="3"><?php echo $row_Reg_Deter['deter_descripcion']; ?></td>
   <td rowspan="3"><?php echo $row_Reg_Deter['descripcion']; ?><br />
<?PHP echo $row_Reg_Deter['tecnica']; ?><br />   
<?PHP echo $row_Reg_Deter['autor']; ?><br />   
   </td>
   <td rowspan="3"><?php echo $row_Reg_Deter['cuenta']; ?></td>
   <td rowspan="3"><?php echo $row_Reg_Deter['cuenta2']; ?></td>

   <td rowspan="3"><?php echo $row_Reg_Deter['cambs']; ?></td>
   <td rowspan="3"><?php echo $row_Reg_Deter['comodato']; ?></td>
   <td rowspan="3"><?php echo $row_Reg_Deter['comodato_fecha']; ?></td>
   <td rowspan="3"><?php echo $row_Reg_Deter['donacion']; ?></td>
   <td rowspan="3"><?php echo $row_Reg_Deter['donacion_fecha']; ?></td>      
      
<td rowspan="3"><a href="editar.php?id_determinantes=<?PHP echo $row_Reg_Deter['id_determinantes'];?>  ">
<button type="button" class="btn btn-success">
       <span class="glyphicon glyphicon-pencil"></span>Editar      </button>
</a></td>
      <td rowspan="3"><a href="eliminar.php?id_determinantes=<?PHP echo $row_Reg_Deter['id_determinantes'];?>"
      onclick="return confirmar()">
      <button type="button" class="btn btn-danger">
      <span class="glyphicon glyphicon-trash"></span>
      Eliminar      </button></a></td>
    </tr>
  <tr>
    <td>Cedula</td>
    <td>Resguardo</td>
    <td>Vales Entrada</td>
    <td>Vales Salida</td>
  </tr>
  <tr>
    <td>
<?PHP    
    $query_cedula = sprintf($query2_cedula, GetSQLValueString($row_Reg_Deter['id_determinantes'], "int"));
$cedula = mysql_query($query_cedula, $SAG) or die(mysql_error());
$row_cedula = mysql_fetch_assoc($cedula);
$totalRows_cedula = mysql_num_rows($cedula);

?>
    <?PHP echo $row_cedula['tot']; ?>
    </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
    <?php } while ($row_Reg_Deter = mysql_fetch_assoc($Reg_Deter)); ?>
</table>


</body>
</html>
<?php
mysql_free_result($cedula);

mysql_free_result($Reg_Deter);

mysql_free_result($V_ASEM);
?>
