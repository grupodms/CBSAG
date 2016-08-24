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


$aIdCedula_cedula_resumen_partidas = "-1";
if (isset($_GET['id_cedula_resumen'])) {
  $aIdCedula_cedula_resumen_partidas = $_GET['id_cedula_resumen'];
}
mysql_select_db($database_SAG, $SAG);
$query_cedula_resumen_partidas = sprintf("SELECT cedula_resumen_partidas.id_cedula_resumen_partidas, cedula_resumen_partidas.id_cedula_resumen, cedula_resumen_partidas.id_determinantes, cedula_resumen_partidas.cantidad, determinantes.clave_determinante, determinantes.descripcion, determinantes.tecnica, determinantes.autor, determinantes.cuenta, determinantes.cuenta2 FROM cedula_resumen_partidas INNER JOIN determinantes ON cedula_resumen_partidas.id_determinantes = determinantes.id_determinantes WHERE id_cedula_resumen = %s ORDER BY determinantes.clave_determinante ASC ", GetSQLValueString($aIdCedula_cedula_resumen_partidas, "int"));
$cedula_resumen_partidas = mysql_query($query_cedula_resumen_partidas, $SAG) or die(mysql_error());
$row_cedula_resumen_partidas = mysql_fetch_assoc($cedula_resumen_partidas);
$totalRows_cedula_resumen_partidas = mysql_num_rows($cedula_resumen_partidas);

$nValeEnt_cedula_resumen = "-1";
if (isset($_GET['id_cedula_resumen'])) {
  $nValeEnt_cedula_resumen = $_GET['id_cedula_resumen'];
}
mysql_select_db($database_SAG, $SAG);
$query_cedula_resumen = sprintf("SELECT cedula_resumen.id_cedula_resumen, cedula_resumen.id_periodo, periodo.semestre, cedula_resumen.id_dependencia, dependencia.clave_dependencia, dependencia.depen_descripcion FROM cedula_resumen INNER JOIN dependencia ON cedula_resumen.id_dependencia = dependencia.id_dependencia INNER JOIN periodo ON cedula_resumen.id_periodo = periodo.id_periodo WHERE id_cedula_resumen = %s", GetSQLValueString($nValeEnt_cedula_resumen, "int"));
$cedula_resumen = mysql_query($query_cedula_resumen, $SAG) or die(mysql_error());
$row_cedula_resumen = mysql_fetch_assoc($cedula_resumen);
$totalRows_cedula_resumen = mysql_num_rows($cedula_resumen);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<!--Inicio:  Bootstrap -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="../css/bootstrap.min.css" rel="stylesheet">
<title>Articulos Cedula Resumen</title>
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

<?PHP $menu = 1; ?>
<?PHP require_once('../barra01.php'); ?>
<!--Menu -->

<!--Inicio:  Bootstrap -->
<blockquote>

  <h1>Articulos Cedula Resumen</h1>
</blockquote>
<table width="500" border="0" class="btn-group-xs">
  <tr>
    <td width="90" align="left">Semestre: </td>
    <td width="210" align="left"><?php echo $row_cedula_resumen['semestre']; ?></td>
    <td width="300" align="left"><?php echo $row_cedula_resumen['id_cedula_resumen']; ?></td>
  </tr>
  <tr>
    <td width="90" align="left">Fecha: </td>
    <td width="210" align="left"><?php echo $row_cedula_resumen['periodo_fecha']; ?></td>
    <td width="300" align="left">&nbsp;</td>
  </tr>
  <tr>
    <td width="90" align="left">Dependencia:</td>
    <td width="210" align="left">(<?php echo $row_cedula_resumen['clave_dependencia']; ?>)</td>
    <td width="300" align="left"><?php echo $row_cedula_resumen['depen_descripcion']; ?></td>
  </tr>
  <tr>
    <td width="90" align="left">&nbsp;</td>
    <td width="210" align="left">&nbsp;</td>
    <td width="300" align="left">&nbsp;</td>
  </tr>
</table>

<p><div class="pull-left">
   <a href="determinantes_nuevo.php?id_cedula_resumen=<?PHP echo $row_cedula_resumen['id_cedula_resumen'];?>  ">
   <button type="button" class="btn btn-primary">Nuevo</button>
   </a></div>
</p>

<table width="100%" border="0" align="center" class="table table-hover">
  <tr>
    <td>Num</td>
    <td>id</td>
    
    <td>DETER</td>
    <td>CAMBS</td>
    <td>DESCRIPCION</td>
    <td>UNIDADES</td>
    <td colspan="2">ACCIONES</td>
  </tr>
  <?PHP $Num = 0; 
        $nSUni = 0;
		$nTUni = 0;
		$i = 0;
		$cCla = "";
  ?>
  
 <?php do { ?>
 <?php $Num += 1; ?>
 <?PHP if  (fmod($Num,25) == 0) { ?>    <? if ($i == 0) 
           { $i=1;}
	    else { $i = 0;}
	?>		    
    <tr bgcolor="#99CCFF">
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>subTotal:</td>
      <td><?PHP echo $nSUni; ?>
          <?PHP $nSUni = 0; ?>
          </td>
      <td></td>
      <td>&nbsp;</td>
    </tr>
 <?PHP }  ?>    <tr
      <?PHP if (fmod($Num,2) == 0) { ?>
      style="background-color:#DBFCD6"
      <?PHP } ?>
    >
      <td><?PHP echo $Num ; ?></td>
      <td><?php echo $row_cedula_resumen_partidas['id_cedula_resumen_partidas']; ?></td>
      
      <td 
      <?PHP if ($cCla == $row_cedula_resumen_partidas['clave_determinante'] ) { ?>
      bgcolor="#FF0000"
      <?PHP } ?>
      >
	  
	  <?php echo $row_cedula_resumen_partidas['clave_determinante']; ?>
      <?PHP $cCla = $row_cedula_resumen_partidas['clave_determinante']; ?></td>
      <td><?php echo $row_cedula_resumen_partidas['comodato']; ?></td>
      <td><?php echo $row_cedula_resumen_partidas['descripcion']; ?></td>
      <td 
      <?PHP if ($row_cedula_resumen_partidas['cantidad'] == 0 ) { ?>
      bgcolor="#FF0000"
      <?PHP } ?>
      >	  
	  <?php echo $row_cedula_resumen_partidas['cantidad']; ?>
<?PHP   $nSUni += $row_cedula_resumen_partidas['cantidad'];
		$nTUni += $row_cedula_resumen_partidas['cantidad'];
?>		      </td>
      <td></td>
                <td><a href="determinantes_eliminar.php?id_cedula_resumen=<?PHP echo $row_cedula_resumen['id_cedula_resumen'];?>&id_cedula_resumen_partidas= <?php echo $row_cedula_resumen_partidas['id_cedula_resumen_partidas'];?> "
onclick="return confirmar()">
        <button type="button" class="btn btn-danger"> <span class="glyphicon glyphicon-trash"></span> Eliminar </button>
      </a></td>  
      
      
    </tr>

   
    <?php } while ($row_cedula_resumen_partidas = mysql_fetch_assoc($cedula_resumen_partidas)); ?>
    <tr bgcolor="#99CCFF">
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>subTotal:</td>
      <td><?PHP echo $nSUni; 
	            $uSUni = 0; ?></td>
      <td></td>
      <td>&nbsp;</td>
    </tr>
        <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>Total:</td>
      <td><?PHP echo $nTUni; ?></td>
      <td></td>
      <td>&nbsp;</td>
    </tr>    
</table>

<a href="index2.php">
   <button type="button" class="list-group-item-warning">
         <span class="glyphicon glyphicon-share-alt"></span> Regresar
</button>
</a>
</body>
</html>
<?php
mysql_free_result($cedula_resumen_partidas);

mysql_free_result($cedula_resumen);
?>
