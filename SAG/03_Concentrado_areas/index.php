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

$colname_Areas = "-1";
if (isset($_COOKIE ['id_dependencia'])) {
  $colname_Areas = $_COOKIE ['id_dependencia'];
}
mysql_select_db($database_SAG, $SAG);
$query_Areas = sprintf("SELECT * FROM area WHERE id_dependencia = %s ORDER BY clave_area ASC", GetSQLValueString($colname_Areas, "int"));
$Areas = mysql_query($query_Areas, $SAG) or die(mysql_error());
$row_Areas = mysql_fetch_assoc($Areas);
$totalRows_Areas = mysql_num_rows($Areas);

$aDep_concentrado_areas = "-1";
if (isset($_COOKIE ['id_dependencia'])) {
  $aDep_concentrado_areas = $_COOKIE ['id_dependencia'];
}
$aPer_concentrado_areas = "-1";
if (isset($_COOKIE ['id_periodo'])) {
  $aPer_concentrado_areas = $_COOKIE ['id_periodo'];
}
mysql_select_db($database_SAG, $SAG);
$query_concentrado_areas = sprintf("SELECT resguardo.id_periodo, periodo.semestre, resguardo.id_dependencia, dependencia.clave_dependencia, dependencia.depen_descripcion, resguardo.id_area, area.clave_area, area.des_area, resguardo_partidas.id_determinantes, determinantes.clave_determinante, determinantes.descripcion, Sum(resguardo_partidas.unidades) AS uni FROM resguardo_partidas INNER JOIN resguardo ON resguardo_partidas.id_resguardo = resguardo.id_resguardo INNER JOIN area ON resguardo.id_area = area.id_area INNER JOIN determinantes ON resguardo_partidas.id_determinantes = determinantes.id_determinantes INNER JOIN dependencia ON resguardo.id_dependencia = dependencia.id_dependencia INNER JOIN periodo ON resguardo.id_periodo = periodo.id_periodo where resguardo.id_periodo = %s and resguardo.id_dependencia = %s GROUP BY resguardo.id_periodo, resguardo.id_dependencia, resguardo.id_area, resguardo_partidas.id_determinantes ORDER BY resguardo_partidas.id_determinantes ASC", GetSQLValueString($aPer_concentrado_areas, "int"),GetSQLValueString($aDep_concentrado_areas, "int"));
$concentrado_areas = mysql_query($query_concentrado_areas, $SAG) or die(mysql_error());
$row_concentrado_areas = mysql_fetch_assoc($concentrado_areas);
$totalRows_concentrado_areas = mysql_num_rows($concentrado_areas);

$aPer_determinantes = "-1";
if (isset($_COOKIE ['id_periodo'])) {
  $aPer_determinantes = $_COOKIE ['id_periodo'];
}
$aDep_determinantes = "-1";
if (isset($_COOKIE ['id_dependencia'])) {
  $aDep_determinantes = $_COOKIE ['id_dependencia'];
}
mysql_select_db($database_SAG, $SAG);
$query_determinantes = sprintf("SELECT 	resguardo.id_periodo, 	resguardo.id_dependencia, 	dependencia.clave_dependencia, 	dependencia.depen_descripcion, 	resguardo_partidas.id_determinantes, 	determinantes.clave_determinante, 	determinantes.descripcion, 	Sum( 		resguardo_partidas.unidades 	) AS uni FROM 	resguardo_partidas INNER JOIN resguardo ON resguardo_partidas.id_resguardo = resguardo.id_resguardo INNER JOIN area ON resguardo.id_area = area.id_area INNER JOIN determinantes ON resguardo_partidas.id_determinantes = determinantes.id_determinantes INNER JOIN dependencia ON resguardo.id_dependencia = dependencia.id_dependencia INNER JOIN periodo ON resguardo.id_periodo = periodo.id_periodo WHERE 	resguardo.id_periodo = %s AND resguardo.id_dependencia = %s GROUP BY 	resguardo.id_periodo, 	resguardo.id_dependencia, 	resguardo_partidas.id_determinantes ORDER BY 	resguardo_partidas.clave_determinante ASC", GetSQLValueString($aPer_determinantes, "int"),GetSQLValueString($aDep_determinantes, "int"));
$determinantes = mysql_query($query_determinantes, $SAG) or die(mysql_error());
$row_determinantes = mysql_fetch_assoc($determinantes);
$totalRows_determinantes = mysql_num_rows($determinantes);

$aPer_unidades_edi = "-1";
if (isset($_COOKIE ['id_periodo'])) {
  $aPer_unidades_edi = $_COOKIE ['id_periodo'];
}
$aDep_unidades_edi = "-1";
if (isset($_COOKIE ['id_dependencia'])) {
  $aDep_unidades_edi = $_COOKIE ['id_dependencia'];
}
$aDet_unidades_edi = "-1";
if (isset($aDet)) {
  $aDet_unidades_edi = $aDet;
}
mysql_select_db($database_SAG, $SAG);
$query_unidades_edi = sprintf("SELECT 	resguardo.id_periodo, 	resguardo.id_dependencia, 	dependencia.clave_dependencia, 	dependencia.depen_descripcion, 	resguardo_partidas.id_determinantes, 	determinantes.clave_determinante, 	determinantes.descripcion, 	Sum( 		resguardo_partidas.unidades 	) AS uni FROM 	resguardo_partidas INNER JOIN resguardo ON resguardo_partidas.id_resguardo = resguardo.id_resguardo INNER JOIN area ON resguardo.id_area = area.id_area INNER JOIN determinantes ON resguardo_partidas.id_determinantes = determinantes.id_determinantes INNER JOIN dependencia ON resguardo.id_dependencia = dependencia.id_dependencia INNER JOIN periodo ON resguardo.id_periodo = periodo.id_periodo WHERE 	resguardo.id_periodo = %s AND resguardo.id_dependencia = %s and resguardo_partidas.id_determinantes = %s GROUP BY 	resguardo.id_periodo, 	resguardo.id_dependencia, 	resguardo_partidas.id_determinantes ORDER BY 	resguardo_partidas.id_determinantes ASC", GetSQLValueString($aPer_unidades_edi, "int"),GetSQLValueString($aDep_unidades_edi, "int"),GetSQLValueString($aDet_unidades_edi, "int"));
$unidades_edi = mysql_query($query_unidades_edi, $SAG) or die(mysql_error());
$row_unidades_edi = mysql_fetch_assoc($unidades_edi);
$totalRows_unidades_edi = mysql_num_rows($unidades_edi);

$colname_dependencia = "-1";
if (isset($_COOKIE ['id_dependencia'])) {
  $colname_dependencia = $_COOKIE ['id_dependencia'];
}
mysql_select_db($database_SAG, $SAG);
$query_dependencia = sprintf("SELECT * FROM dependencia WHERE id_dependencia = %s", GetSQLValueString($colname_dependencia, "int"));
$dependencia = mysql_query($query_dependencia, $SAG) or die(mysql_error());
$row_dependencia = mysql_fetch_assoc($dependencia);
$totalRows_dependencia = mysql_num_rows($dependencia);

mysql_select_db($database_SAG, $SAG);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<!--Inicio:  Bootstrap -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="../css/bootstrap.min.css" rel="stylesheet">
<title>Activos por Area Asignación.</title>
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

<!--Menu -->
<?PHP 
$adm_Usuario   = $_COOKIE ["usuario_global"]; 
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

<?PHP 
$numEle = 20;

$nPag = 1; ?>


<div id="muestra" style="width:100%; height:100%;">
<table width='100%' 
       border='0' 
       cellspacing='0' 
       bordercolor='#666666'
 style='
  border-collapse:collapse;
  page-break-before: always;
  table-layout: auto;'>
 <caption> <h3>
COLEGIO DE BACHILLERES </h3>
<h4> (<?php echo $row_determinantes['clave_dependencia']; ?>)  <?php echo $row_determinantes['depen_descripcion']; ?> LISTADO DE CONCENTRADO DE BIENES POR AREA <?php echo $row_concentrado_areas['semestre']." Página: ".$nPag; ?></h3>
  </caption>

  <col style="width:10;" />
  <col style="width:20;" />
  <col style="width:50;" />
  <col style="width:20;" />


  <?php 
   $nArea = 0;
   $nEdif = array();
   $nTotEdif = array();
   $nPag = 1;
   ?>
  <tr>
      <th scope="col" style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
    <span class="table-condensed">
      Num</th>
      <th scope="col" style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
    <span class="table-condensed">
    &nbsp;Clave&nbsp;</th>
    <th scope="col" style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
    <span class="table-condensed">
    Descripción</th>
      <?php do { ?>
<?PHP 
array_push($nEdif,$row_Areas['id_area']);
array_push($TotnEdif,0);

?>
        <th  width="30" 
        style="border: 1px solid black;
    border-collapse: collapse; text-align:center"> 
    <P style="width: 30px; 
              text-align: center;
              font-size:9px"> 
         <?php echo $row_Areas['clave_area'];?>
         <?php //echo $row_Areas['id_area'];?>
         </P>
         </th>
        <?php $nArea += 1; ?>
      <?php } while ($row_Areas = mysql_fetch_assoc($Areas)); ?>
  <th  width="30" 
        style="border: 1px solid black;
    border-collapse: collapse; text-align:center"> <span class="table-condensed" >    
     TOTAL 
  </th>    
  </tr>
    <?php 
	  $nDet = 1; 
	  $nTotGen = 0;
	?>
    <?php do { ?>

<?PHP if (fmod($nDet,$numEle) == 0) { $nPag +=1;?>

<?PHP
$Areas = mysql_query($query_Areas, $SAG) or die(mysql_error());
$row_Areas = mysql_fetch_assoc($Areas);
?>
<tr>
<td style="border: 1px solid black;
    border-collapse: collapse; text-align:right" colspan="2" >&nbsp;
    
</td>
<td style="border: 1px solid black;
    border-collapse: collapse; text-align:right"  ><strong>SUBTOTAL : &nbsp;</strong></td>

<?PHP
for ($i2 = 0; $i2 < $nArea; $i2++) 
{
?>
        <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
<?php 
echo $nTotEdif [$i2];
}
?>	
        </td>
        <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
<strong> <?PHP echo $nTotGen."&nbsp;"; ?></strong>	
        </td>

        
</tr> 
    </table>
<table width='100%' 
       border='0' 
       cellspacing='0' 
       bordercolor='#666666'
 style='
  border-collapse:collapse;
  page-break-before: always;
  table-layout: auto;'>
 <caption> <h1>
COLEGIO DE BACHILLERES </h1>
<h3> (<?php echo $row_determinantes['clave_dependencia']; ?>)  <?php echo $row_determinantes['depen_descripcion']; ?></h3>
  
  <h3>LISTADO DE CONCENTRADO DE BIENES POR AREA <?php echo $row_concentrado_areas['semestre']." Página: ".$nPag; ?></h3>
  </caption>

  <col style="width:10;" />
  <col style="width:20;" />
  <col style="width:50;" />
  <col style="width:20;" />
  <tr>
      <th scope="col" style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
    <span class="table-condensed">
      Num</th>
      <th scope="col" style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
    <span class="table-condensed">
    &nbsp;Clave&nbsp;</th>
    <th scope="col" style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
    <span class="table-condensed">
    Descripción</th>
      <?php do { ?>
        <th  width="30" 
        style="border: 1px solid black;
    border-collapse: collapse; text-align:center"> <span class="table-condensed" > 
         (<?php echo $row_Areas['clave_area'];?>)<br />
         <?php //echo $row_Areas['id_area'];?>
         
        </th>
      <?php } while ($row_Areas = mysql_fetch_assoc($Areas)); ?>
  <th  width="30" 
        style="border: 1px solid black;
    border-collapse: collapse; text-align:center"> <span class="table-condensed" >    
     TOTAL 
  </th>    
  </tr>
<?PHP } ?>        
    
    <tr
      <?PHP if (fmod($nDet,2) == 0) { ?>
      style="background-color:#DBFCD6"
      <?PHP } ?>
    >

        
      <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center"><?PHP echo $nDet; ?> </td>
        <td style="border: 1px solid black; border-collapse: collapse; text-align: center;
        
        font-size: 7px;  ">
        
		<?php echo $row_determinantes['clave_determinante']; ?>
        
        </td>
        <td style="border: 1px solid 
                   black; border-collapse: collapse;
                   font-size: 7px;  ">
        <P style="width: 200px; text-align: left;">   
		<?php echo substr($row_determinantes['descripcion'],0,40); ?>
        </P>
     
      </td>

<?PHP
for ($i = 0; $i < $nArea; $i++) 
{
?>
        <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
<?php 

$query_unidades_edi = sprintf("SELECT 	resguardo.id_periodo, 	resguardo.id_dependencia, 	dependencia.clave_dependencia, 	dependencia.depen_descripcion, 	resguardo_partidas.id_determinantes, 	determinantes.clave_determinante, 	determinantes.descripcion, 	Sum( 		resguardo_partidas.unidades 	) AS uni FROM 	resguardo_partidas INNER JOIN resguardo ON resguardo_partidas.id_resguardo = resguardo.id_resguardo INNER JOIN area ON resguardo.id_area = area.id_area INNER JOIN determinantes ON resguardo_partidas.id_determinantes = determinantes.id_determinantes INNER JOIN dependencia ON resguardo.id_dependencia = dependencia.id_dependencia INNER JOIN periodo ON resguardo.id_periodo = periodo.id_periodo 
WHERE 	resguardo.id_periodo = %s 
    AND resguardo.id_dependencia = %s 
	AND resguardo.id_area = %s 
	AND resguardo_partidas.id_determinantes = %s 
	
GROUP BY 	resguardo.id_periodo, 	resguardo.id_dependencia, 	resguardo_partidas.id_determinantes ORDER BY 	resguardo_partidas.id_determinantes ASC", GetSQLValueString($aPer_unidades_edi, "int"),GetSQLValueString($aDep_unidades_edi, "int"),GetSQLValueString($nEdif [$i], "int"),
GetSQLValueString($row_determinantes['id_determinantes'], "int"));
$unidades_edi = mysql_query($query_unidades_edi, $SAG) or die(mysql_error());
$row_unidades_edi = mysql_fetch_assoc($unidades_edi);
$totalRows_unidades_edi = mysql_num_rows($unidades_edi);

//echo $nEdif [$i]."<br>" ;
//echo $totalRows_unidades_edi."<br>";

if ( $totalRows_unidades_edi > 0 )
{
echo  $row_unidades_edi['uni'];
$nTotEdif [$i] += $row_unidades_edi['uni'];
$nTotGen += $row_unidades_edi['uni'];
}
else
{
echo " "; 
}

?>	
      </td>
<?PHP
}
?>
<td style="border: 1px solid black;
    border-collapse: collapse; text-align:center"><?php echo $row_determinantes['uni']; ?>
    
    
</td>        
        
        
    </tr>
    <?php $nDet += 1; ?>
      <?php } while ($row_determinantes = mysql_fetch_assoc($determinantes)); ?>




<tr>
<td style="border: 1px solid black;
    border-collapse: collapse; text-align:right" colspan="2" >&nbsp;
    
</td>
<td style="border: 1px solid black;
    border-collapse: collapse; text-align:right"  ><strong>TOTAL : &nbsp;</strong></td>

<?PHP
for ($i = 0; $i < $nArea; $i++) 
{
?>
        <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
<?php 
echo $nTotEdif [$i];
}
?>	
        </td>
        <td style="border: 1px solid black;
    border-collapse: collapse; text-align:center">
<strong> <?PHP echo $nTotGen."&nbsp;"; ?></strong>	
        </td>

        
</tr>


</table>
<table width="100%" 
       border="0" 
       <?PHP if ($nNum > 20) 
	         {?> 
       style="page-break-before:always "
       <?PHP } ?>
       >
  
  <tr>
    <td colspan="2">
    <strong>Elaboro</strong>
    </td>
    <td>&nbsp;</td>
    <td colspan="3"><strong>Reviso</strong></td>
    <td>&nbsp;</td>
    <td colspan="5"><strong>Visto Bueno</strong></td>
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
    <td colspan="2" >&nbsp;</td>
    </tr>


  <tr>
    <td colspan="2">
  <P style="width: 250px; 
  text-align: center;
  font-size:9px">----------------------------------------------
    </P>
    </td>
    <td>&nbsp;</td>
    <td colspan="3">
<P style="width: 250px; 
  text-align: center;
  font-size:9px">    ----------------------------------------------
  </P>
  </td>
    <td>&nbsp;</td>
    <td colspan="5">
      <P style="width: 250px; 
  text-align: center;
  font-size:9px">    ----------------------------------------------
        </P>
    </td>
    </tr>
  <tr>
    <td colspan="2">
  <P style="width: 250px; 
  text-align: center;
  font-size:9px">	
    <?php echo $row_dependencia['cedula_elaboro_nombre']; ?>
    </P>
    </td>
    <td>&nbsp;</td>
    <td colspan="3">
<P style="width: 250px; 
  text-align: center;
  font-size:9px">
	<?php echo $row_dependencia['cedula_reviso1_nombre']; ?>
    </P>
    </td>
    <td>&nbsp;</td>
    <td colspan="5">
      <P style="width: 250px; 
  text-align: center;
  font-size:9px">	
        <?php echo $row_dependencia['cedula_vistobueno_nombre']; ?>
        </P>
    </td>
    </tr>
  <tr>
    <td colspan="2">
  <P style="width: 250px; 
  text-align: center;
  font-size:8px">	
    <?php echo $row_dependencia['cedula_elaboro_puesto']; ?>
    </P>
    </td>
    <td>&nbsp;</td>
    <td colspan="3">
<P style="width: 250px; 
  text-align: center;
  font-size:8px">		
	<?php echo $row_dependencia['cedula_reviso1_puesto']; ?>
    </P>
    </td>
    <td>&nbsp;</td>
    <td colspan="5">
      <P style="width: 250px; 
  text-align: center;
  font-size:8px">		
        <?php echo $row_dependencia['cedula_vistobueno_puesto']; ?>
        </P>
    </td>
    </tr>


</table>
</div>

</body>
</html>
<?php
mysql_free_result($Areas);

mysql_free_result($concentrado_areas);

mysql_free_result($determinantes);

mysql_free_result($unidades_edi);

mysql_free_result($dependencia);

?>
