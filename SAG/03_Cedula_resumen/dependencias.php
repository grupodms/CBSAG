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
$query_per_dep_det = sprintf("SELECT DISTINCT id_dependencia, id_periodo, id_determinantes, clave_determinante, cambs, cuenta, cuenta2, descripcion  FROM `per_dep_det` WHERE id_dependencia = %s AND id_periodo in (%s,%s) ORDER BY clave_determinante ", GetSQLValueString($aDep_per_dep_det, "int"),GetSQLValueString($aPer_A_per_dep_det, "int"),GetSQLValueString($aPer_B_per_dep_det, "int"));
$per_dep_det = mysql_query($query_per_dep_det, $SAG) or die(mysql_error());
$row_per_dep_det = mysql_fetch_assoc($per_dep_det);
$totalRows_per_dep_det = mysql_num_rows($per_dep_det);

mysql_select_db($database_SAG, $SAG);
$query_dependencia = "SELECT * FROM dependencia";
$dependencia = mysql_query($query_dependencia, $SAG) or die(mysql_error());
$row_dependencia = mysql_fetch_assoc($dependencia);
$totalRows_dependencia = mysql_num_rows($dependencia);

$colname_Periodo_Anteriror = "-1";
if (isset($_COOKIE ['id_periodo'])) {
  $colname_Periodo_Anteriror = $_COOKIE ['id_periodo']-1;
}
mysql_select_db($database_SAG, $SAG);
$query_Periodo_Anteriror = sprintf("SELECT * FROM periodo WHERE id_periodo = %s", GetSQLValueString($colname_Periodo_Anteriror, "int"));
$Periodo_Anteriror = mysql_query($query_Periodo_Anteriror, $SAG) or die(mysql_error());
$row_Periodo_Anteriror = mysql_fetch_assoc($Periodo_Anteriror);
$totalRows_Periodo_Anteriror = mysql_num_rows($Periodo_Anteriror);

$colname_Periodo_Actual = "-1";
if (isset($_COOKIE ['id_periodo'])) {
  $colname_Periodo_Actual = $_COOKIE ['id_periodo'];
}
mysql_select_db($database_SAG, $SAG);
$query_Periodo_Actual = sprintf("SELECT * FROM periodo WHERE id_periodo = %s", GetSQLValueString($colname_Periodo_Actual, "int"));
$Periodo_Actual = mysql_query($query_Periodo_Actual, $SAG) or die(mysql_error());
$row_Periodo_Actual = mysql_fetch_assoc($Periodo_Actual);
$totalRows_Periodo_Actual = mysql_num_rows($Periodo_Actual);

$aDep_inventario_fisico = "-1";
if (isset($_COOKIE ['id_dependencia'])) {
  $aDep_inventario_fisico = $_COOKIE ['id_dependencia'];
}
$aPer_inventario_fisico = "-1";
if (isset($_COOKIE ['id_periodo'])) {
  $aPer_inventario_fisico = $_COOKIE ['id_periodo'];
}
$aDet_inventario_fisico = "-1";
if (isset($Row_nDet)) {
  $aDet_inventario_fisico = $Row_nDet;
}
mysql_select_db($database_SAG, $SAG);
$query2_inventario_fisico ="SELECT resguardo.id_dependencia, resguardo.id_periodo, determinantes.id_determinantes, resguardo_partidas.id_resguardo_partidas, determinantes.clave_determinante, determinantes.descripcion, determinantes.cuenta, determinantes.cuenta2, determinantes.cambs, Sum(resguardo_partidas.unidades) AS total FROM resguardo_partidas INNER JOIN determinantes ON resguardo_partidas.id_determinantes = determinantes.id_determinantes INNER JOIN resguardo ON resguardo_partidas.id_resguardo = resguardo.id_resguardo where resguardo.id_dependencia = %s and resguardo.id_periodo = %s  GROUP BY resguardo.id_dependencia, resguardo.id_periodo"; 

$query_inventario_fisico = sprintf($query2_inventario_fisico, GetSQLValueString($aDep_inventario_fisico, "int"),GetSQLValueString($aPer_inventario_fisico, "int")
);
$inventario_fisico = mysql_query($query_inventario_fisico, $SAG) or die(mysql_error());
$row_inventario_fisico = mysql_fetch_assoc($inventario_fisico);
$totalRows_inventario_fisico = mysql_num_rows($inventario_fisico);

//********************************
//***
//********************************

$aDep_vales_entrada = "-1";
if (isset($_COOKIE ['id_dependencia'])) {
  $aDep_vales_entrada = $_COOKIE ['id_dependencia'];
}
$aPer_vales_entrada = "-1";
if (isset($_COOKIE ['id_periodo'])) {
  $aPer_vales_entrada = $_COOKIE ['id_periodo'];
}
$aDet_vales_entrada = "-1";
if (isset($row_Det)) {
  $aDet_vales_entrada = $row_Det;
}
$aTipo_vales_entrada = "-1";
if (isset($aVale)) {
  $aTipo_vales_entrada = $aVale;
}
mysql_select_db($database_SAG, $SAG);
$query2_vales_entrada = "SELECT vale_entrada.id_dependencia, vale_entrada.id_periodo, determinantes.id_determinantes, vale_entrada_partidas.id_vale_entrada_partidas, determinantes.clave_determinante, determinantes.descripcion, determinantes.cuenta, determinantes.cuenta2, determinantes.cambs, vale_entrada_tipo.id_vale_entrada_tipo, vale_entrada_tipo.clave_vale_entrada_tipo, Sum(vale_entrada_partidas.unidades) AS total FROM vale_entrada_partidas INNER JOIN determinantes ON vale_entrada_partidas.id_determinantes = determinantes.id_determinantes INNER JOIN vale_entrada ON vale_entrada_partidas.id_vale_entrada = vale_entrada.id_vale_entrada INNER JOIN vale_entrada_tipo ON vale_entrada.id_vale_entrada_tipo = vale_entrada_tipo.id_vale_entrada_tipo where vale_entrada.id_dependencia = %s and vale_entrada.id_periodo = %s and vale_entrada_tipo.id_vale_entrada_tipo = %s GROUP BY vale_entrada.id_dependencia ";

$query_vales_entrada = sprintf($query2_vales_entrada, GetSQLValueString($aDep_vales_entrada, "int"),GetSQLValueString($aPer_vales_entrada, "int"),GetSQLValueString($aTipo_vales_entrada, "int"));
$vales_entrada = mysql_query($query_vales_entrada, $SAG) or die(mysql_error());
$row_vales_entrada = mysql_fetch_assoc($vales_entrada);
$totalRows_vales_entrada = mysql_num_rows($vales_entrada);
//*******************************************

//********************************
//***
//********************************

$aDep_vales_salida = "-1";
if (isset($_COOKIE ['id_dependencia'])) {
  $aDep_vales_salida = $_COOKIE ['id_dependencia'];
}
$aPer_vales_salida = "-1";
if (isset($_COOKIE ['id_periodo'])) {
  $aPer_vales_salida = $_COOKIE ['id_periodo'];
}
$aDet_vales_salida = "-1";
if (isset($row_Det)) {
  $aDet_vales_salida = $row_Det;
}
$aTipo_vales_salida = "-1";
if (isset($aVale)) {
  $aTipo_vales_salida = $aVale;
}
mysql_select_db($database_SAG, $SAG);
$query2_vales_salida = "SELECT vale_salida.id_dependencia, vale_salida.id_periodo, determinantes.id_determinantes, vale_salida_partidas.id_vale_salida_partidas, determinantes.clave_determinante, determinantes.descripcion, determinantes.cuenta, determinantes.cuenta2, determinantes.cambs, vale_salida_tipo.id_vale_salida_tipo, vale_salida_tipo.clave_vale_salida_tipo, Sum(vale_salida_partidas.unidades) AS total FROM vale_salida_partidas INNER JOIN determinantes ON vale_salida_partidas.id_determinantes = determinantes.id_determinantes INNER JOIN vale_salida ON vale_salida_partidas.id_vale_salida = vale_salida.id_vale_salida INNER JOIN vale_salida_tipo ON vale_salida.id_vale_salida_tipo = vale_salida_tipo.id_vale_salida_tipo where vale_salida.id_dependencia = %s and vale_salida.id_periodo = %s and vale_salida_tipo.id_vale_salida_tipo = %s GROUP BY vale_salida.id_dependencia ";

$query_vales_salida = sprintf($query2_vales_salida, GetSQLValueString($aDep_vales_salida, "int"),GetSQLValueString($aPer_vales_salida, "int"),GetSQLValueString($aTipo_vales_salida, "int"));
$vales_salida = mysql_query($query_vales_salida, $SAG) or die(mysql_error());
$row_vales_salida = mysql_fetch_assoc($vales_salida);
$totalRows_vales_salida = mysql_num_rows($vales_salida);
//*******************************************

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
$query2_cedula_resumen_partidas = "SELECT cedula_resumen.id_dependencia, cedula_resumen.id_periodo, determinantes.id_determinantes, cedula_resumen_partidas.id_cedula_resumen_partidas, determinantes.clave_determinante, determinantes.descripcion, determinantes.cuenta, determinantes.cuenta2, determinantes.cambs, Sum(cedula_resumen_partidas.cantidad) AS total FROM 	cedula_resumen_partidas INNER JOIN determinantes ON cedula_resumen_partidas.id_determinantes = determinantes.id_determinantes INNER JOIN cedula_resumen ON cedula_resumen_partidas.id_cedula_resumen = cedula_resumen.id_cedula_resumen where  	cedula_resumen.id_dependencia = %s 	and cedula_resumen.id_periodo = %s 	GROUP BY cedula_resumen.id_dependencia ";

$query_cedula_resumen_partidas = sprintf($query2_cedula_resumen_partidas,GetSQLValueString($aDep_cedula_resumen_partidas, "int"),
GetSQLValueString($aPer_cedula_resumen_partidas, "int")
);

$cedula_resumen_partidas = mysql_query($query_cedula_resumen_partidas, $SAG) or die(mysql_error());
$row_cedula_resumen_partidas = mysql_fetch_assoc($cedula_resumen_partidas);
$totalRows_cedula_resumen_partidas = mysql_num_rows($cedula_resumen_partidas);

echo $row_cedula_resumen_partidas ['total'];


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

<!--Inicio: Imprimri -->
<script type="text/javascript">
function imprSelec(muestra)
{var ficha=document.getElementById(muestra);var ventimp=window.open(' ','popimpr');ventimp.document.write(ficha.innerHTML);ventimp.document.close();ventimp.print();ventimp.close();}
</script>
<!--Fin: Imprimri -->
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
<!-- Inicio:Librerias en EXCEL -->
<script type="text/javascript" 
        src="jquery-1.3.2.min.js">
		
</script>
<script language="javascript">
$(document).ready(function() {
$(".botonExcel").click(function(event) {
$("#datos_a_enviar").val( $("<div>").append( $("#Exportar_a_Excel").eq(0).clone()).html());
$("#FormularioExportacion").submit();
});
});
</script>
<!-- Fin:Librerias en EXCEL -->

<!--Menu -->
<?PHP 
$path = 'cedula_dependencia.csv';
$fp = fopen($path, 'w');
$adm_Usuario   = $_COOKIE ["usuario_global"]; 
$adm_Nombre    = $_COOKIE ["nombre"]; 
$adm_Perfil    = $_COOKIE ["id_perfil"]; 
setlocale (LC_TIME,"spanish");

fputcsv($fp, array(
        'Dependencia',
        'id_dependencia',
		'id_determinantes',
		'clave_determinante',
		'descripcion',
		'Inventario Fisico Inicial',
		'Entradas',
		'Salidas',
		'Saldo Contable',
		'Inventario Fisico Final',
		'Dif +',
		'Dif -'
		));



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
<?PHP $nPag = 1;?>

<div id="muestra">

<!--Inicio:Tabla -->
<table width="627" border="0" summary="Resumen" style="page-break-before: always;">
  <caption> <h3>
COLEGIO DE BACHILLERES </h3>
<h4> INVENTARIO FISICO AL 
  <?php 
  $Fecha_1ini = $row_Periodo_Actual['periodo_fecha'];
  $fecha_2ini = date("d-m-Y", strtotime("$Fecha_1ini"));
  echo $fecha_2ini;
  ?> Página <?PHP echo $nPag ;?> </h4>
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
    CLAVE
    </P></th>
    <th width="62" rowspan="4" scope="col"
    style="border: 1px solid black;
    border-collapse: collapse; ">
    <P style="width: 50px; 
              text-align: center;
              font-size:8px">&nbsp;</P></th>
    
    
    <th colspan="3" width="6" rowspan="4" scope="col" 
    style="border: 1px solid black;
    border-collapse: collapse; ">
    <P style ="width: 100px; 
       text-align: center;
       font-size:12px"> 
    DEPENDENCIA
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
    <th colspan="13" scope="col" 
    style="border: 1px solid black;
    border-collapse: collapse; 
    text-align:center">
    <span class="table-condensed">
    MOVIMIENTOS
    </span></th>
    <th width="6" rowspan="4" scope="col"     
    style="border: 1px solid black;
    border-collapse: collapse; ">
    <P style="width: 50px; 
              text-align: center;
              font-size:8px"> 
      SALDO CONTABLE <br /> 
        <?php 
 $Fecha_1ini = $row_Periodo_Actual['periodo_fecha'];
  $fecha_2ini = date("d-m-Y", strtotime("$Fecha_1ini"));
  echo $fecha_2ini;

  ?>
    </p></th>
    <th width="6" rowspan="4" scope="col"    style="border: 1px solid black;
    border-collapse: collapse; ">
    <P style="width: 70px; 
              text-align: center;
              font-size:8px"> 
    (<?php echo $row_Periodo_Actual['id_periodo']; ?>)<br />INVENTARIO FISICO <br />
      <?php 
  $Fecha_1ini = $row_Periodo_Actual['periodo_fecha'];
  $fecha_2ini = date("d-m-Y", strtotime("$Fecha_1ini"));
  echo $fecha_2ini;
  ?>
    </P></th>
    <th colspan="2" rowspan="2" scope="col"
    style="border: 1px solid black;
    border-collapse: collapse; 
    text-align:center">
    <span class="table-condensed">
    DIFERENCIAS
    </span></th>
    <th width="6" rowspan="4" scope="col"
    style="border: 1px solid black;
    border-collapse: collapse; ">
    <P style="width: 60px; 
              text-align: center;
              font-size:8px"> 
    Causa que origino la diferencia
    </p></th>
  </tr>
  <tr>
    <th colspan="6" scope="col" 
    style="border: 1px solid black;
    border-collapse: collapse; text-align:center"><span class="table-condensed">
      <?php 
  $Fecha_1ini = $row_Periodo_Actual['fecha_inicio'];
  $fecha_2ini = date("d-m-y", strtotime("$Fecha_1ini"));
  echo $fecha_2ini;
  ?>&nbsp;AL&nbsp;
<?php 
  $Fecha_1ini = $row_Periodo_Actual['fecha_cierre_contable'];
  $fecha_2ini = date("d-m-Y", strtotime("$Fecha_1ini"));
  echo $fecha_2ini;
  ?>
    </span></th>
    <th width="20" bgcolor="#006600" scope="col">&nbsp;</th>
    <th colspan="6" scope="col" 
    style="border: 1px solid black;
    border-collapse: collapse; 
    text-align:center">
    <span class="table-condensed">
    Posteriores 
<?php echo $row_Periodo_Actual['semestre'];?>
    </span></th>
  </tr>
  <tr>
    <th colspan="3" scope="col" 
    style="border: 1px solid black;
    border-collapse: collapse; 
    text-align:center">
    <span class="table-condensed">
    ENTRADAS
    </span></th>
    <th width="6" colspan="3" scope="col"     
    style="border: 1px solid black;
    border-collapse: collapse; 
    text-align:center">
    <span class="table-condensed">
    SALIDAS
    </span></th>
    <th width="20" bgcolor="#006600" scope="col">&nbsp;</th>
    <th width="6" colspan="3" scope="col"
    style="border: 1px solid black;
    border-collapse: collapse; 
    text-align:center">
    <span class="table-condensed">
    ENTRADAS
    </span></th>
    <th width="6" colspan="3" scope="col"
    style="border: 1px solid black;
    border-collapse: collapse; 
    text-align:center">
    <span class="table-condensed">
    SALIDAS
    </span></th>
    <th width="6" rowspan="2" scope="col" 
    style="border: 1px solid black;
    border-collapse: collapse; ">
    <P style="width: 30px; 
              text-align: center;
              font-size:10px"> 
    +
    </p></th>
    <th width="6" rowspan="2" scope="col"
    style="border: 1px solid black;
    border-collapse: collapse; ">
    <P style="width: 30px; 
              text-align: center;
              font-size:10px"> 
    -
    </p></th>
  </tr>
  <tr>
    <th width="6" scope="col" 
    style="border: 1px solid black;
    border-collapse: collapse; ">
    <P style="width: 30px; 
              text-align: center;
              font-size:8px"> 
    BAJAS
    </P></th>
    <th scope="col" 
    style="border: 1px solid black;
    border-collapse: collapse; ">
    <P style="width: 30px; 
              text-align: center;
              font-size:8px"> 
    TRAS
    </P></th>
    <th scope="col"
    style="border: 1px solid black;
    border-collapse: collapse; ">
    <P style="width: 30px; 
              text-align: center;
              font-size:8px"> 
    AD
    </p></th>
    <th width="6" scope="col" 
    style="border: 1px solid black;
    border-collapse: collapse; ">
    <P style="width: 30px; 
              text-align: center;
              font-size:8px"> 
    BAJAS
    </p></th>
    <th width="2" scope="col" 
    style="border: 1px solid black;
    border-collapse: collapse; ">
    <P style="width: 30px; 
              text-align: center;
              font-size:8px"> 
    TRAS
    </p></th>
    <th width="6" scope="col" 
    style="border: 1px solid black;
    border-collapse: collapse; ">
    <P style="width: 30px; 
              text-align: center;
              font-size:8px"> 
    AD
    </p></th>
    <th width="20" bgcolor="#006600" scope="col">&nbsp;</th>
    <th width="6" scope="col"
    style="border: 1px solid black;
    border-collapse: collapse; ">
    <P style="width: 30px; 
              text-align: center;
              font-size:8px"> 
    BAJAS
    </p></th>
    <th width="2" scope="col"
    style="border: 1px solid black;
    border-collapse: collapse; ">
    <P style="width: 30px; 
              text-align: center;
              font-size:8px"> 
    TRAS
    </p></th>
    <th width="6" scope="col"
    style="border: 1px solid black;
    border-collapse: collapse; ">
    <P style="width: 30px; 
              text-align: center;
              font-size:8px"> 
    AD
    </p></th>
    <th width="6" scope="col"
    style="border: 1px solid black;
    border-collapse: collapse; ">
    <P style="width: 30px; 
              text-align: center;
              font-size:8px"> 
    BAJAS
    </p></th>
    <th width="2" scope="col"
    style="border: 1px solid black;
    border-collapse: collapse; ">
    <P style="width: 30px; 
              text-align: center;
              font-size:8px"> 
    TRAS
    </p></th>
    <th width="6" scope="col"
    style="border: 1px solid black;
    border-collapse: collapse; ">
    <P style="width: 30px; 
              text-align: center;
              font-size:8px"> 
    AD
    </p></th>
  </tr>
  <!--Fin:Tabla -->
  
  
  <?php 
  $nNum = 1;

  $nTot = 0; 
  $nTotContable = 0;
  $nTotInvFisico = 0;
  $nTotDifMas=0;
  $nTotDifMenos=0;
  
  $nE1Tot =0;
  $nE2Tot =0;
  $nE3Tot =0;

  $nS1Tot =0;
  $nS2Tot =0;
  $nS3Tot =0;
  
  $nPE1Tot =0;
  $nPE2Tot =0;
  $nPE3Tot =0;

  $nPS1Tot =0;
  $nPS2Tot =0;
  $nPS3Tot =0;



  $nE1PTot =0;
  $nE2PTot =0;
  $nE3PTot =0;

  $nS1PTot =0;
  $nS2PTot =0;
  $nS3PTot =0;
  
  $nPE1PTot =0;
  $nPE2PTot =0;
  $nPE3PTot =0;

  $nPS1PTot =0;
  $nPS2PTot =0;
  $nPS3PTot =0;
  

  $nPTot = 0; 
  $nPTotContable = 0;
  $nPTotInvFisico = 0;
  $nPTotDifMas=0;
  $nPTotDifMenos=0;
  
  ?>
  <?php do { ?>
    <tr
      <?PHP if (fmod($nNum,2) == 0) { ?>
      style="background-color:#DBFCD6"
      <?PHP } ?>
    >

      <?PHP if (fmod($nNum,25) == 0) { ?>

<!-- SubTotales -->
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>
        <P style="width: 100px; 
              text-align: left;
              font-size:10px"> 
    <strong>SubTotal por Hoja </strong></P></td>
    <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
	<strong><?php echo $nPTot; ?></strong> </td>

    <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
	<strong><?php echo $nE1PTot; ?></strong> </td>
    <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
	<strong><?php echo $nE2PTot; ?></strong> </td>
    <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
	<strong><?php echo $nE3PTot; ?></strong> </td>
    <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
	<strong><?php echo $nS1PTot; ?></strong> </td>
    <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
	<strong><?php echo $nS2PTot; ?></strong> </td>
    <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
	<strong><?php echo $nS3PTot; ?></strong> </td>
<td>&nbsp;</td>
    <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
	<strong><?php echo $nPE1PTot; ?></strong> </td>
    <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
	<strong><?php echo $nPE2PTot; ?></strong> </td>
    <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
	<strong><?php echo $nPE3PTot; ?></strong> </td>
    <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
	<strong><?php echo $nPS1PTot; ?></strong> </td>
    <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
	<strong><?php echo $nPS2PTot; ?></strong> </td>
    <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
	<strong><?php echo $nPS3PTot; ?></strong> </td>

    <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
	<strong><?php echo $nPTotContable; ?></strong> </td>
    <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center"><strong><?php echo $nPTotInvFisico; ?></strong>
    </td>
        <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center"><strong><?php echo $nPTotDifMas; ?></strong>
    </td>
        <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center"><strong><?php echo $nPTotDifMenos; ?></strong>
    </td>
    
  </tr>
<!-- SubTotales -->
<!-- SubTotales Cero -->
<?PHP

  $nE1PTot =0;
  $nE2PTot =0;
  $nE3PTot =0;

  $nS1PTot =0;
  $nS2PTot =0;
  $nS3PTot =0;
  
  $nPE1PTot =0;
  $nPE2PTot =0;
  $nPE3PTot =0;

  $nPS1PTot =0;
  $nPS2PTot =0;
  $nPS3PTot =0;
  

  $nPTot = 0; 
  $nPTotContable = 0;
  $nPTotInvFisico = 0;
  $nPTotDifMas=0;
  $nPTotDifMenos=0;

?>


<!-- SubTotales Cero -->
</table>      
<!--Inicio:Tabla -->
<table width="627" border="0" summary="Resumen" style="page-break-before: always;">
  <caption> <h3>
COLEGIO DE BACHILLERES </h3>
<h4> INVENTARIO FISICO AL 
  <?php 
  $Fecha_1ini = $row_Periodo_Actual['periodo_fecha'];
  $fecha_2ini = date("d-m-Y", strtotime("$Fecha_1ini"));
  echo $fecha_2ini;
  ?> Página <?PHP $nPag += 1; echo $nPag;?></h4>
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
    CLAVE
    </P></th>
    <th width="62" rowspan="4" scope="col"
    style="border: 1px solid black;
    border-collapse: collapse; ">
    <P style="width: 50px; 
              text-align: center;
              font-size:8px">&nbsp;</P></th>
    
    <th colspan="3" rowspan="4"
    style="border: 1px solid black;
    border-collapse: collapse; " scope="col">
      
      <P style="width: 100px; 
         text-align: center;
         font-size:12px"> 
        DEPENDENCIA
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
    <th colspan="13" scope="col" 
    style="border: 1px solid black;
    border-collapse: collapse; 
    text-align:center">
    <span class="table-condensed">
    MOVIMIENTOS
    </span></th>
    <th width="6" rowspan="4" scope="col"     
    style="border: 1px solid black;
    border-collapse: collapse; ">
    <P style="width: 50px; 
              text-align: center;
              font-size:8px"> 
      SALDO CONTABLE <br /> 
        <?php 
 $Fecha_1ini = $row_Periodo_Actual['periodo_fecha'];
  $fecha_2ini = date("d-m-Y", strtotime("$Fecha_1ini"));
  echo $fecha_2ini;

  ?>
    </p></th>
    <th width="6" rowspan="4" scope="col"    style="border: 1px solid black;
    border-collapse: collapse; ">
    <P style="width: 70px; 
              text-align: center;
              font-size:8px"> 
    (<?php echo $row_Periodo_Actual['id_periodo']; ?>)<br />INVENTARIO FISICO <br />
      <?php 
  $Fecha_1ini = $row_Periodo_Actual['periodo_fecha'];
  $fecha_2ini = date("d-m-Y", strtotime("$Fecha_1ini"));
  echo $fecha_2ini;
  ?>
    </P></th>
    <th colspan="2" rowspan="2" scope="col"
    style="border: 1px solid black;
    border-collapse: collapse; 
    text-align:center">
    <span class="table-condensed">
    DIFERENCIAS
    </span></th>
    <th width="6" rowspan="4" scope="col"
    style="border: 1px solid black;
    border-collapse: collapse; ">
    <P style="width: 60px; 
              text-align: center;
              font-size:8px"> 
    Causa que origino la diferencia
    </p></th>
  </tr>
  <tr>
    <th colspan="6" scope="col" 
    style="border: 1px solid black;
    border-collapse: collapse; text-align:center"><span class="table-condensed">
      <?php 
  $Fecha_1ini = $row_Periodo_Actual['fecha_inicio'];
  $fecha_2ini = date("d-m-y", strtotime("$Fecha_1ini"));
  echo $fecha_2ini;
  ?>&nbsp;AL&nbsp;
<?php 
  $Fecha_1ini = $row_Periodo_Actual['fecha_cierre_contable'];
  $fecha_2ini = date("d-m-Y", strtotime("$Fecha_1ini"));
  echo $fecha_2ini;
  ?>
    </span></th>
    <th width="20" bgcolor="#006600" scope="col">&nbsp;</th>
    <th colspan="6" scope="col" 
    style="border: 1px solid black;
    border-collapse: collapse; 
    text-align:center">
    <span class="table-condensed">
    Posteriores 
<?php echo $row_Periodo_Actual['semestre'];?>
    </span></th>
  </tr>
  <tr>
    <th colspan="3" scope="col" 
    style="border: 1px solid black;
    border-collapse: collapse; 
    text-align:center">
    <span class="table-condensed">
    ENTRADAS
    </span></th>
    <th width="6" colspan="3" scope="col"     
    style="border: 1px solid black;
    border-collapse: collapse; 
    text-align:center">
    <span class="table-condensed">
    SALIDAS
    </span></th>
    <th width="20" bgcolor="#006600" scope="col">&nbsp;</th>
    <th width="6" colspan="3" scope="col"
    style="border: 1px solid black;
    border-collapse: collapse; 
    text-align:center">
    <span class="table-condensed">
    ENTRADAS
    </span></th>
    <th width="6" colspan="3" scope="col"
    style="border: 1px solid black;
    border-collapse: collapse; 
    text-align:center">
    <span class="table-condensed">
    SALIDAS
    </span></th>
    <th width="6" rowspan="2" scope="col" 
    style="border: 1px solid black;
    border-collapse: collapse; ">
    <P style="width: 30px; 
              text-align: center;
              font-size:10px"> 
    +
    </p></th>
    <th width="6" rowspan="2" scope="col"
    style="border: 1px solid black;
    border-collapse: collapse; ">
    <P style="width: 30px; 
              text-align: center;
              font-size:10px"> 
    -
    </p></th>
  </tr>
  <tr>
    <th width="6" scope="col" 
    style="border: 1px solid black;
    border-collapse: collapse; ">
    <P style="width: 30px; 
              text-align: center;
              font-size:8px"> 
    BAJAS
    </P></th>
    <th scope="col" 
    style="border: 1px solid black;
    border-collapse: collapse; ">
    <P style="width: 30px; 
              text-align: center;
              font-size:8px"> 
    TRAS
    </P></th>
    <th scope="col"
    style="border: 1px solid black;
    border-collapse: collapse; ">
    <P style="width: 30px; 
              text-align: center;
              font-size:8px"> 
    AD
    </p></th>
    <th width="6" scope="col" 
    style="border: 1px solid black;
    border-collapse: collapse; ">
    <P style="width: 30px; 
              text-align: center;
              font-size:8px"> 
    BAJAS
    </p></th>
    <th width="2" scope="col" 
    style="border: 1px solid black;
    border-collapse: collapse; ">
    <P style="width: 30px; 
              text-align: center;
              font-size:8px"> 
    TRAS
    </p></th>
    <th width="6" scope="col" 
    style="border: 1px solid black;
    border-collapse: collapse; ">
    <P style="width: 30px; 
              text-align: center;
              font-size:8px"> 
    AD
    </p></th>
    <th width="20" bgcolor="#006600" scope="col">&nbsp;</th>
    <th width="6" scope="col"
    style="border: 1px solid black;
    border-collapse: collapse; ">
    <P style="width: 30px; 
              text-align: center;
              font-size:8px"> 
    BAJAS
    </p></th>
    <th width="2" scope="col"
    style="border: 1px solid black;
    border-collapse: collapse; ">
    <P style="width: 30px; 
              text-align: center;
              font-size:8px"> 
    TRAS
    </p></th>
    <th width="6" scope="col"
    style="border: 1px solid black;
    border-collapse: collapse; ">
    <P style="width: 30px; 
              text-align: center;
              font-size:8px"> 
    AD
    </p></th>
    <th width="6" scope="col"
    style="border: 1px solid black;
    border-collapse: collapse; ">
    <P style="width: 30px; 
              text-align: center;
              font-size:8px"> 
    BAJAS
    </p></th>
    <th width="2" scope="col"
    style="border: 1px solid black;
    border-collapse: collapse; ">
    <P style="width: 30px; 
              text-align: center;
              font-size:8px"> 
    TRAS
    </p></th>
    <th width="6" scope="col"
    style="border: 1px solid black;
    border-collapse: collapse; ">
    <P style="width: 30px; 
              text-align: center;
              font-size:8px"> 
    AD
    </p></th>
  </tr>
  <!--Fin:Tabla -->
      
    <?PHP } ?>


    
    <td style="border: 1px solid black;
               border-collapse: collapse; 
              ">
    <P style="width: 10px; 
                text-align: left;
                font-size:9px"> 
	<?PHP echo $nNum; ?>
    </P>
    </td>
    
    <td style="border: 1px solid black;
               border-collapse: collapse; 
               ">
    <P style="width: 30px; 
              text-align: left;
              font-size:9px"><?php echo $row_dependencia['clave_dependencia']; ?></P></td>

    <td colspan="4" style="border: 1px solid black;
               border-collapse: collapse; 
               ">

      <P style="width: 250px; 
          text-align: left;
          font-size:12px">    
        <?php echo $row_dependencia['depen_descripcion']; ?>
</P></td>

    <td style="border: 1px solid black;
               border-collapse: collapse;
               text-align:center">
        <?php
$aDep =  $row_dependencia['id_dependencia'];	


$query_cedula_resumen_partidas = sprintf($query2_cedula_resumen_partidas, GetSQLValueString($aDep, "int"),GetSQLValueString($aPer_cedula_resumen_partidas, "int"));

$cedula_resumen_partidas = mysql_query($query_cedula_resumen_partidas, $SAG) or die(mysql_error());
$row_cedula_resumen_partidas = mysql_fetch_assoc($cedula_resumen_partidas);
$totalRows_cedula_resumen_partidas = mysql_num_rows($cedula_resumen_partidas);
$nCedulaResumen = $row_cedula_resumen_partidas ['total']; 
$nTot += $nCedulaResumen;
$nPTot += $nCedulaResumen;

echo $nCedulaResumen;
	 ?>
      </td>
    <td style="border: 1px solid black;
               border-collapse: collapse; 
               ">
    <P style="width: 30px; 
              text-align: center;
              font-size:9px"> 
    
<?PHP
$query_vales_entrada = sprintf($query2_vales_entrada, 
GetSQLValueString($aDep, "int"),GetSQLValueString($aPer_vales_entrada, "int"),
GetSQLValueString(1, "int"));
$vales_entrada = mysql_query($query_vales_entrada, $SAG) or die(mysql_error());
$row_vales_entrada = mysql_fetch_assoc($vales_entrada);
$totalRows_vales_entrada = mysql_num_rows($vales_entrada);

$nValeEnt1 = $row_vales_entrada['total']; 
$nE1Tot  += $row_vales_entrada['total'];
$nE1PTot += $row_vales_entrada['total'];

echo $nValeEnt1;
?>    
      </P>    
      </td>
    <td style="border: 1px solid black;
               border-collapse: collapse; 
               ">
    <P style="width: 30px; 
              text-align: center;
              font-size:9px"> 
    
<?PHP
$query_vales_entrada = sprintf($query2_vales_entrada, 
GetSQLValueString($aDep, "int"),GetSQLValueString($aPer_vales_entrada, "int"),
GetSQLValueString(2, "int"));
$vales_entrada = mysql_query($query_vales_entrada, $SAG) or die(mysql_error());
$row_vales_entrada = mysql_fetch_assoc($vales_entrada);
$totalRows_vales_entrada = mysql_num_rows($vales_entrada);

$nValeEnt2 = $row_vales_entrada['total']; 
$nE2Tot  += $row_vales_entrada['total'];
$nE2PTot += $row_vales_entrada['total'];
echo $nValeEnt2;
?>    
      </P>    
      </td>
    <td style="border: 1px solid black;
               border-collapse: collapse; 
               ">
    <P style="width: 30px; 
              text-align: center;
              font-size:9px"> 
    
<?PHP
$query_vales_entrada = sprintf($query2_vales_entrada, 
GetSQLValueString($aDep, "int"),GetSQLValueString($aPer_vales_entrada, "int"),
GetSQLValueString(3, "int"));
$vales_entrada = mysql_query($query_vales_entrada, $SAG) or die(mysql_error());
$row_vales_entrada = mysql_fetch_assoc($vales_entrada);
$totalRows_vales_entrada = mysql_num_rows($vales_entrada);

$nValeEnt3 = $row_vales_entrada['total']; 
$nE3Tot  += $row_vales_entrada['total'];
$nE3PTot += $row_vales_entrada['total'];


echo $nValeEnt3;
?>    
      </P>    
      </td>
    <td style="border: 1px solid black;
               border-collapse: collapse; 
               ">
    <P style="width: 30px; 
              text-align: center;
              font-size:9px"> 
    
<?PHP
$query_vales_salida = sprintf($query2_vales_salida, 
GetSQLValueString($aDep, "int"),GetSQLValueString($aPer_vales_salida, "int"),
GetSQLValueString(1, "int"));
$vales_salida = mysql_query($query_vales_salida, $SAG) or die(mysql_error());
$row_vales_salida = mysql_fetch_assoc($vales_salida);
$totalRows_vales_salida = mysql_num_rows($vales_salida);

$nValeSal1 = $row_vales_salida['total']; 

$nS1Tot  += $row_vales_salida['total'];
$nS1PTot += $row_vales_salida['total'];

echo $nValeSal1;
?>    
      </P>    
      </td>
       
    <td style="border: 1px solid black;
               border-collapse: collapse; 
               ">
    <P style="width: 30px; 
              text-align: center;
              font-size:9px"> 
    
<?PHP
$query_vales_salida = sprintf($query2_vales_salida, 
GetSQLValueString($aDep, "int"),GetSQLValueString($aPer_vales_salida, "int"),
GetSQLValueString(2, "int"));
$vales_salida = mysql_query($query_vales_salida, $SAG) or die(mysql_error());
$row_vales_salida = mysql_fetch_assoc($vales_salida);
$totalRows_vales_salida = mysql_num_rows($vales_salida);

$nValeSal2 = $row_vales_salida['total']; 

$nS2Tot  += $row_vales_salida['total'];
$nS2PTot += $row_vales_salida['total'];

echo $nValeSal2;
?>    
      </P>    
      </td>
    <td style="border: 1px solid black;
               border-collapse: collapse; 
               ">
    <P style="width: 30px; 
              text-align: center;
              font-size:9px"> 
    
<?PHP
$query_vales_salida = sprintf($query2_vales_salida, 
GetSQLValueString($aDep, "int"),GetSQLValueString($aPer_vales_salida, "int"),
GetSQLValueString(3, "int"));
$vales_salida = mysql_query($query_vales_salida, $SAG) or die(mysql_error());
$row_vales_salida = mysql_fetch_assoc($vales_salida);
$totalRows_vales_salida = mysql_num_rows($vales_salida);

$nValeSal3 = $row_vales_salida['total']; 

$nS3Tot  += $row_vales_salida['total'];
$nS3PTot += $row_vales_salida['total'];

echo $nValeSal3;
?>    
      </P>    
      </td>
      <td bgcolor="#006600" style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
<P style="width: 1px; 
  text-align: center;
  font-size:9px">&nbsp;	    
    
    
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
    border-collapse: collapse; text-align:center">
    <?PHP 
	$nContable  = $nCedulaResumen;
	$nContable += $nValeEnt1;
	$nContable += $nValeEnt2;
	$nContable += $nValeEnt3;
	$nContable -= $nValeSal1;
	$nContable -= $nValeSal2;
	$nContable -= $nValeSal3;
    
	$nPTotContable += $nContable;   
    
	echo $nContable; ?>
     
      &nbsp;</td>
      <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center"><?php 
$query_inventario_fisico = sprintf($query2_inventario_fisico,
GetSQLValueString($aDep, "int"),
GetSQLValueString($aPer_inventario_fisico, "int"));
$inventario_fisico = mysql_query($query_inventario_fisico, $SAG) or die(mysql_error());
$row_inventario_fisico = mysql_fetch_assoc($inventario_fisico);
$totalRows_inventario_fisico = mysql_num_rows($inventario_fisico);
	
$nInvFisico = $row_inventario_fisico['total'];	

$nPTotInvFisico += $nInvFisico;
	
	echo $nInvFisico; ?>
      </td>
      <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
    <?PHP
	 $nDifMas=0;
	 $nDifMenos=0;
	 $nDif = $nInvFisico - $nContable;
	 
	
	 
	 if ($nDif > 0) {
		 ?>
         <p style=" color: #00F" >
         <?PHP
		  $nPTotDifMas += $nDif;
		 echo $nDif; $nDifMas=$nDif;
		 ?>
         </p>
         <?PHP 
		 }
	?>
      </td>
      <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
    <?PHP
	 $nDif = $nInvFisico - $nContable;
	 
	 if ($nDif < 0) {
		 ?>
         <p style=" color:#F00" >
		 <?php
		 $nPTotDifMenos += $nDif;
		 echo $nDif; $nDifMenos=$nDif;
		 ?>
         </p>
         <?php
		 }
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
	$nNum += 1;
	?>
    <?php } while ($row_dependencia = mysql_fetch_assoc($dependencia)); ?>
    
<!-- SubTotales -->
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td width="6">&nbsp;</td>
    <td width="6">
        <P style="width: 100px; 
              text-align: left;
              font-size:10px"> 
    <strong>SubTotal por Hoja </strong></P></td>
    <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
	<strong><?php echo $nPTot; ?></strong> </td>

    <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
	<strong><?php echo $nE1PTot; ?></strong> </td>
    <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
	<strong><?php echo $nE2PTot; ?></strong> </td>
    <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
	<strong><?php echo $nE3PTot; ?></strong> </td>
    <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
	<strong><?php echo $nS1PTot; ?></strong> </td>
    <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
	<strong><?php echo $nS2PTot; ?></strong> </td>
    <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
	<strong><?php echo $nS3PTot; ?></strong> </td>
<td>&nbsp;</td>
    <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
	<strong><?php echo $nPE1PTot; ?></strong> </td>
    <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
	<strong><?php echo $nPE2PTot; ?></strong> </td>
    <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
	<strong><?php echo $nPE3PTot; ?></strong> </td>
    <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
	<strong><?php echo $nPS1PTot; ?></strong> </td>
    <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
	<strong><?php echo $nPS2PTot; ?></strong> </td>
    <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
	<strong><?php echo $nPS3PTot; ?></strong> </td>

    <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
	<strong><?php echo $nPTotContable; ?></strong> </td>
    <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center"><strong><?php echo $nPTotInvFisico; ?></strong>
    </td>
        <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center"><strong><?php echo $nPTotDifMas; ?></strong>
    </td>
        <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center"><strong><?php echo $nPTotDifMenos; ?></strong>
    </td>
    
  </tr>
<!-- SubTotales -->
    
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
    
    <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
	<strong><?php echo $nE1Tot; ?></strong> </td>
    <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
	<strong><?php echo $nE2Tot; ?></strong> </td>
    <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
	<strong><?php echo $nE3Tot; ?></strong> </td>
    <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
	<strong><?php echo $nS1Tot; ?></strong> </td>
    <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
	<strong><?php echo $nS2Tot; ?></strong> </td>
    <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
	<strong><?php echo $nS3Tot; ?></strong> </td>
<td>&nbsp;</td>
    <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
	<strong><?php echo $nPE1Tot; ?></strong> </td>
    <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
	<strong><?php echo $nPE2Tot; ?></strong> </td>
    <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
	<strong><?php echo $nPE3Tot; ?></strong> </td>
    <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
	<strong><?php echo $nPS1Tot; ?></strong> </td>
    <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
	<strong><?php echo $nPS2Tot; ?></strong> </td>
    <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
	<strong><?php echo $nPS3Tot; ?></strong> </td>
    
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
    <td colspan="3">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td colspan="2" >&nbsp;</td>
    <td colspan="2" >&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<?PHP
fclose($fp);
?>  

</div>
<a href="cedula_dependencia.csv">
<img src="../../img/descarga_excel.png" alt="Cedulas Resumen" width="140" height="59" class="botonExcel" />
</a>
</body>
</html>
<?php
mysql_free_result($cedula_resumen_partidas);

mysql_free_result($dependencia);

mysql_free_result($Periodo_Anteriror);

mysql_free_result($Periodo_Actual);

mysql_free_result($inventario_fisico);

mysql_free_result($vales_entrada);

mysql_free_result($vales_salida);

mysql_free_result($per_dep_det);
?>
