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
$aDep_per_dep_det = "-1";
if (isset($_COOKIE ['id_dependencia'])) {
  $aDep_per_dep_det = $_COOKIE ['id_dependencia'];
}
$aPer_A_per_dep_det = "-1";
if (isset($_COOKIE ['id_periodo'])) {
  $aPer_A_per_dep_det = $_COOKIE ['id_periodo'];
}
$aPer_B_per_dep_det = "-1";
if (isset($_COOKIE ['id_periodo'])) {
  $aPer_B_per_dep_det = $_COOKIE ['id_periodo'];
}
mysql_select_db($database_SAG, $SAG);
$query_per_dep_det = sprintf("SELECT DISTINCT id_dependencia, id_periodo, id_determinantes, clave_determinante, cambs, cuenta, cuenta2, descripcion, destino FROM `per_dep_det` WHERE id_dependencia = %s AND id_periodo in (%s,%s) ORDER BY clave_determinante", GetSQLValueString($aDep_per_dep_det, "int"),GetSQLValueString($aPer_A_per_dep_det, "int"),GetSQLValueString($aPer_B_per_dep_det, "int"));
$per_dep_det = mysql_query($query_per_dep_det, $SAG) or die(mysql_error());
$row_per_dep_det = mysql_fetch_assoc($per_dep_det);
$totalRows_per_dep_det = mysql_num_rows($per_dep_det);

$colname_dependencia = "-1";
if (isset($_COOKIE ['id_dependencia'])) {
  $colname_dependencia = $_COOKIE ['id_dependencia'];
}
mysql_select_db($database_SAG, $SAG);
$query_dependencia = sprintf("SELECT * FROM dependencia WHERE id_dependencia = %s", GetSQLValueString($colname_dependencia, "int"));
$dependencia = mysql_query($query_dependencia, $SAG) or die(mysql_error());
$row_dependencia = mysql_fetch_assoc($dependencia);
$totalRows_dependencia = mysql_num_rows($dependencia);

$colname_Periodo_Anteriror = "-1";
if (isset($row_cedula_resumen['id_periodo'])) {
  $colname_Periodo_Anteriror = $row_cedula_resumen['id_periodo'];
}
mysql_select_db($database_SAG, $SAG);
$query_Periodo_Anteriror = sprintf("SELECT * FROM periodo WHERE id_periodo = %s", GetSQLValueString($colname_Periodo_Anteriror, "int"));
$Periodo_Anteriror = mysql_query($query_Periodo_Anteriror, $SAG) or die(mysql_error());
$row_Periodo_Anteriror = mysql_fetch_assoc($Periodo_Anteriror);
$totalRows_Periodo_Anteriror = mysql_num_rows($Periodo_Anteriror);

$colname_Periodo_Actual = "-1";
if (isset($row_cedula_resumen['id_periodo'])) {
  $colname_Periodo_Actual = $row_cedula_resumen['id_periodo']+1;
}
mysql_select_db($database_SAG, $SAG);
$query_Periodo_Actual = sprintf("SELECT * FROM periodo WHERE id_periodo = %s", GetSQLValueString($colname_Periodo_Actual, "int"));
$Periodo_Actual = mysql_query($query_Periodo_Actual, $SAG) or die(mysql_error());
$row_Periodo_Actual = mysql_fetch_assoc($Periodo_Actual);
$totalRows_Periodo_Actual = mysql_num_rows($Periodo_Actual);

$aDependencia_inventario_fisico = "-1";
if (isset($nDep)) {
  $aDependencia_inventario_fisico = $nDep;
}
$aPeriodo_inventario_fisico = "-1";
if (isset($nPer)) {
  $aPeriodo_inventario_fisico = $nPer;
}
$aDeterminante_inventario_fisico = "-1";
if (isset($nDet)) {
  $aDeterminante_inventario_fisico = $nDet;
}
mysql_select_db($database_SAG, $SAG);
$query_inventario_fisico = sprintf("SELECT unidad_resguardo FROM resguardo_determinantes where id = CONCAT(%s,%s,%s)", GetSQLValueString($aDependencia_inventario_fisico, "int"),GetSQLValueString($aPeriodo_inventario_fisico, "int"),GetSQLValueString($aDeterminante_inventario_fisico, "int"));
$inventario_fisico = mysql_query($query_inventario_fisico, $SAG) or die(mysql_error());
$row_inventario_fisico = mysql_fetch_assoc($inventario_fisico);
$totalRows_inventario_fisico = mysql_num_rows($inventario_fisico);


///////////////////////////////////


?>
<?PHP
///Funciones  
function C_Cedula_Resumen ($FcDet)
{
$aDep_cedula_resumen_partidas = "-1";
if (isset($_COOKIE ['id_dependencia'])) {
  $aDep_cedula_resumen_partidas = $_COOKIE ['id_dependencia'];
}
$aPer_cedula_resumen_partidas = "-1";
if (isset($_COOKIE ['id_periodo'])) {
  $aPer_cedula_resumen_partidas = $_COOKIE ['id_periodo']-1;
}
$aDet_cedula_resumen_partidas = "-1";
if (isset($FcDet)) {
  $aDet_cedula_resumen_partidas = $FcDet;
}
mysql_select_db($database_SAG, $SAG);
$query_cedula_resumen_partidas = sprintf("SELECT cedula_resumen.id_dependencia, cedula_resumen.id_periodo, determinantes.id_determinantes, cedula_resumen_partidas.id_cedula_resumen_partidas, determinantes.clave_determinante, determinantes.descripcion, determinantes.cuenta, determinantes.cuenta2, determinantes.cambs, Sum(cedula_resumen_partidas.cantidad) AS total FROM 	cedula_resumen_partidas INNER JOIN determinantes ON cedula_resumen_partidas.id_determinantes = determinantes.id_determinantes INNER JOIN cedula_resumen ON cedula_resumen_partidas.id_cedula_resumen = cedula_resumen.id_cedula_resumen where  	cedula_resumen.id_dependencia = %s 	and cedula_resumen.id_periodo = %s 	and determinantes.id_determinantes = %s GROUP BY cedula_resumen.id_dependencia, cedula_resumen.id_periodo, determinantes.id_determinantes, cedula_resumen_partidas.id_cedula_resumen_partidas, determinantes.clave_determinante, determinantes.descripcion, determinantes.cuenta, determinantes.cuenta2, determinantes.cambs", GetSQLValueString($aDep_cedula_resumen_partidas, "int"),GetSQLValueString($aPer_cedula_resumen_partidas, "int"),GetSQLValueString($aDet_cedula_resumen_partidas, "int"));
$cedula_resumen_partidas = mysql_query($query_cedula_resumen_partidas, $SAG) or die(mysql_error());
$row_cedula_resumen_partidas = mysql_fetch_assoc($cedula_resumen_partidas);
$totalRows_cedula_resumen_partidas = mysql_num_rows($cedula_resumen_partidas);

return $row_cedula_resumen_partidas ['total'];
}


?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<!--Inicio:  Bootstrap -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="../css/bootstrap.min.css" rel="stylesheet">
<title>Cedulas Resumen</title>
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
setlocale (LC_TIME,"spanish");
?>
<?PHP $menu = 1; ?>
<?PHP require_once('../barra01.php'); ?>
<!--Menu -->

<!--Inicio:  Bootstrap -->
 <a href="javascript:imprSelec('muestra')">
 <button type="button" 
         class="btn btn-success">
 <span class="glyphicon glyphicon-print"></span>
 Imprimir
 </button>
</a>

<table width="627" border="1" summary="Resumen">
  <caption> <h1>
COLEGIO DE BACHILLERES </h1>
<h3> (<?php echo $row_dependencia['depen_descripcion']; ?>) <?php echo $row_dependencia['depen_descripcion']; ?> </h3>
  
  <h3>INVENTARIO FISICO AL 
  <?php 
  $Fecha_1ini = $row_Periodo_Actual['periodo_fecha'];
  $fecha_2ini = date("d-m-Y", strtotime("$Fecha_1ini"));
  echo $fecha_2ini;
  ?> </h3>
  </caption>
  <tr>
    <th width="23" rowspan="4" scope="col"
    style="border: 1px solid black;
    border-collapse: collapse; ">
    <P style="width: 30px; 
              text-align:center;
              font-size:9px"> 
    Num
    </P>
    </th>
    <th width="79" rowspan="4" scope="col"
    style="border: 1px solid black;
    border-collapse: collapse; ">
    <P style="width: 30px; 
              text-align: center;
              font-size:8px"> 
    CUENTA CONTABLE
    </P></th>
    <th width="62" rowspan="4" scope="col"
    style="border: 1px solid black;
    border-collapse: collapse; ">
    <P style="width: 50px; 
              text-align: center;
              font-size:8px"> 
    CUENTA CONAC
    </P></th>
    <th width="148" rowspan="4" scope="col"
    style="border: 1px solid black;
    border-collapse: collapse; ">
    <P style="width: 50px; 
              text-align: center;
              font-size:8px"> 
    CAMBS
    </P></th>
    <th width="6" rowspan="4" scope="col"
    style="border: 1px solid black;
    border-collapse: collapse; ">
    <P style="width: 40px; 
              text-align: center;
              font-size:8px"> 
    DETER
    </P></th>
    <th width="6" rowspan="4" scope="col" 
    style="border: 1px solid black;
    border-collapse: collapse; ">
    <P style="width: 100px; 
              text-align: center;
              font-size:8px"> 
    DESCRIPCION
    </p></th>
    <th width="6" rowspan="4" scope="col" 
    style="border: 1px solid black;
    border-collapse: collapse; ">
    <P style="width: 50px; 
              text-align: center;
              font-size:8px"> 
    (<?php echo $row_Periodo_Anteriror['id_periodo']; ?>)<br />
      INVENTARIO FISICO <br />
      <?php 
  $Fecha_1ini = $row_Periodo_Anteriror['periodo_fecha'];
  $fecha_2ini = date("d-m-Y", strtotime("$Fecha_1ini"));
  echo $fecha_2ini;
  ?>
    </P></th>
    <th colspan="13" scope="col" style="border: 1px solid black;
    border-collapse: collapse; text-align:center">MOVIMIENTOS</th>
    <th width="6" rowspan="4" scope="col" style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
      <p align="center"><span class="table-condensed">SALDO CONTABLE <br /> 
        <?php 
  $Fecha_1ini = $row_Periodo_Anteriror['periodo_fecha'];
  $fecha_2ini = date("d-m-Y", strtotime("$Fecha_1ini"));
  echo $fecha_2ini;
  ?>
    </span></p></th>
    <th width="6" rowspan="4" scope="col" style="border: 1px solid black;
    border-collapse: collapse; text-align:center"><P align="center"> <span class="table-condensed" >(<?php echo $row_Periodo_Actual['id_periodo']; ?>)<br />INVENTARIO FISICO <br />
      <?php 
  $Fecha_1ini = $row_Periodo_Actual['periodo_fecha'];
  $fecha_2ini = date("d-m-Y", strtotime("$Fecha_1ini"));
  echo $fecha_2ini;
  ?>
    </span></P></th>
    <th colspan="2" rowspan="2" scope="col"
    style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
    <span class="table-condensed">DIFERENCIAS</span></th>
    <th width="6" rowspan="4" scope="col"
    style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
    <span class="table-condensed">Causa que origino la diferencia</span></th>
  </tr>
  <tr>
    <th colspan="6" scope="col" style="border: 1px solid black;
    border-collapse: collapse; text-align:center"><span class="table-condensed">
      <?php 
  $Fecha_1ini = $row_Periodo_Anteriror['periodo_fecha'];
  $fecha_2ini = date("d-m-y", strtotime("$Fecha_1ini"));
  echo $fecha_2ini;
  ?>&nbsp;AL&nbsp;
<?php 
  $Fecha_1ini = $row_Periodo_Actual['periodo_fecha'];
  $fecha_2ini = date("d-m-Y", strtotime("$Fecha_1ini"));
  echo $fecha_2ini;
  ?>
    </span></th>
    <th width="20" bgcolor="#006600" scope="col">&nbsp;</th>
    <th colspan="6" scope="col" 
    style="border: 1px solid black;
    border-collapse: collapse; text-align:center">Posteriores 
      <?php echo $row_Periodo_Actual['semestre']; ?></th>
  </tr>
  <tr>
    <th colspan="3" scope="col" 
    style="border: 1px solid black;
    border-collapse: collapse; text-align:center"
    ><span class="table-condensed">ENTRADAS</span></th>
    <th width="6" colspan="3" scope="col"style="border: 1px solid black;
    border-collapse: collapse; text-align:center"><span class="table-condensed">SALIDAS</span></th>
    <th width="20" bgcolor="#006600" scope="col">&nbsp;</th>
    <th width="6" colspan="3" scope="col"
    style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
    <span class="table-condensed">ENTRADAS</span></th>
    <th width="6" colspan="3" scope="col"
    style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
    <span class="table-condensed">SALIDAS</span></th>
    <th width="6" rowspan="2" scope="col" 
    style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
    <span class="table-condensed">+</span></th>
    <th width="6" rowspan="2" scope="col"
    style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
    <span class="table-condensed">-</span></th>
  </tr>
  <tr>
    <th width="6" scope="col" style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
    <span class="table-condensed">BAJAS</span></th>
    <th scope="col"style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
    <span class="table-condensed">TRAS</span></th>
    <th scope="col"style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
    <span class="table-condensed">AD</span></th>
    <th width="6" scope="col" style="border: 1px solid black;border-collapse: collapse; text-align:center">
    <span class="table-condensed">BAJAS</span></th>
    <th width="2" scope="col" style="border: 1px solid black; border-collapse: collapse; text-align:center">
    <span class="table-condensed">TRAS</span></th>
    <th width="6" scope="col" style="border: 1px solid black; border-collapse: collapse; text-align:center"><span class="table-condensed">AD</span></th>
    <th width="20" bgcolor="#006600" scope="col">&nbsp;</th>
    <th width="6" scope="col"
    style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
    <span class="table-condensed">BAJAS</span></th>
    <th width="2" scope="col"
    style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
    <span class="table-condensed">TRAS</span></th>
    <th width="6" scope="col"
    style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
    <span class="table-condensed">AD</span></th>
    <th width="6" scope="col"
    style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
    <span class="table-condensed">BAJAS</span></th>
    <th width="2" scope="col"
    style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
    <span class="table-condensed">TRAS</span></th>
    <th width="6" scope="col"
    style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
    <span class="table-condensed">AD</span></th>
  </tr>
  <?php 
  $nTot = 0; 
  $nTotContable = 0;
  $nTotInvFisico = 0;
  $nTotDifMas=0;
  $nTotDifMenos=0;
  $nDet = 1;
  ?>
  <?php do { ?>
    <tr
      <?PHP if (fmod($nDet,2) == 0) { ?>
      style="background-color:#DBFCD6"
      <?PHP } ?>
    >
    
    <td style="border: 1px solid black;
               border-collapse: collapse; 
              ">
    <P style="width: 10px; 
                text-align: left;
                font-size:9px"> 
	<?PHP echo $nDet; ?>
    </P>
    </td>
    
    <td style="border: 1px solid black;
               border-collapse: collapse; 
               ">
    <P style="width: 30px; 
              text-align: left;
              font-size:9px"> 
    <?php echo $row_per_dep_det['cuenta'];?>
    </P>
    </td>

    <td style="border: 1px solid black;
               border-collapse: collapse; 
               ">
    <P style="width: 30px; 
              text-align: left;
              font-size:9px"> 
    <?php echo $row_per_dep_det['cuenta2'];?>
    </P>
    </td>

    <td style="border: 1px solid black;
               border-collapse: collapse; 
               ">
    <P style="width: 30px; 
              text-align: left;
              font-size:9px"> 
    <?php echo $row_per_dep_det['cambs']; ?>
    </P>
    </td>
    <td style="border: 1px solid black;
               border-collapse: collapse; 
               ">
    <P style="width: 30px; 
              text-align: left;
              font-size:9px"> 
<?php echo $row_per_dep_det['clave_determinante']; ?>
    </P>
    </td>
      <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
<P style="width: 100px; 
          text-align: left;
          font-size:7px">    
	<?php echo substr($row_per_dep_det['descripcion'],1,40); ?></P></td>
    <td style="border: 1px solid black;
               border-collapse: collapse; 
               ">
    <P style="width: 30px; 
              text-align: left;
              font-size:9px"> 
    <?php echo C_Cedula_Resumen ($row_per_dep_det['id_determinantes']); ?>
    </P>
    </td>
      <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">&nbsp;
      </td>
      <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">&nbsp;</td>
      <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">&nbsp;</td>
      <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">&nbsp;
      </td>
      <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">&nbsp;</td>
      <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">&nbsp;</td>
      <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">&nbsp;
      </td>
      <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">&nbsp;
      </td>
      <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">&nbsp;</td>
      <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">&nbsp;</td>
      <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">&nbsp;
      </td>
      <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">&nbsp;</td>
      <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">&nbsp;</td>
      <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
    <?PHP $nContable = $row_cedula_resumen_partidas['cantidad'];
	echo $nContable; ?>
     
      &nbsp;</td>
      <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
	<?php 
$nDep = $row_cedula_resumen_partidas['id_dependencia'];
$nPer = $row_cedula_resumen_partidas['id_periodo']+1;
$nDet = $row_cedula_resumen_partidas['id_determinantes'];
// echo $nDep.",".$nPer.",".$nDet;

$nInvFisico = 0;
 if ($totalRows_inventario_fisico == 0)
 { $nInvFisico = 0;}
 else
 {$nInvFisico = $row_inventario_fisico['unidad_resguardo'];}
	 ?> 
	<?php echo $nInvFisico; ?>
      </td>
      <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center" >
    <?PHP
	 $nDifMas=0;
	 $nDifMenos=0;
	 $nDif =  $nContable - $nInvFisico ;
	 if ($nDif > 0) {echo $nDif; $nDifMas=$nDif; }
	?>
      </td>
      <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
    <?PHP
	 $nDif =  $nContable - $nInvFisico ;
	 if ($nDif < 0) {echo $nDif; $nDifMenos=$nDif;}
	?>
      </td>
      <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">&nbsp;
    </td>
    </tr>
    <?php 
	$nTot += $row_cedula_resumen_partidas['cantidad']; 
	$nTotContable  += $nContable;
	$nTotInvFisico += $nInvFisico;
	$nTotDifMas    += $nDifMas;
	$nTotDifMenos  += $nDifMenos;
	$nDet += 1;
	?>
    <?php } while ($row_per_dep_det = mysql_fetch_assoc($per_dep_det)); ?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><strong>Total</strong></td>
    <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
	<strong><?php echo $nTot; ?></strong> </td>
    <td colspan="3">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
	<strong><?php echo $nTotContable; ?></strong> </td>
    <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center"><strong><?php echo $nTotInvFisico; ?></strong>
    </td>
        <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center"><strong><?php echo $nTotDifMas; ?></strong>
    </td>
        <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center"><strong><?php echo $nTotDifMenos; ?></strong>
    </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td colspan="2" style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
	<strong><?php 
	echo $nTotContable." - ".$nTotInvFisico." = ".$nTotContable-$nTotInvFisico ; ?></strong> 
    
    </td>
        <td colspan="2" style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
	<strong><?php 
	echo $nTotDifMas." ".$nTotDifMenos." = ".$nTotDifMas+$nTotDifMenos ; ?></strong> 
    
    </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>



</body>
</html>
<?php
mysql_free_result($cedula_resumen_partidas);

mysql_free_result($dependencia);

mysql_free_result($Periodo_Anteriror);

mysql_free_result($Periodo_Actual);

mysql_free_result($inventario_fisico);

mysql_free_result($per_dep_det);
?>
