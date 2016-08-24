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
$aDep_area = "-1";
if (isset($_COOKIE ['id_dependencia'])) {
  $aDep_area = $_COOKIE ['id_dependencia'];
}
mysql_select_db($database_SAG, $SAG);
$query_area = sprintf("SELECT *,CONCAT(area.clave_area,' | ',area.des_area) AS lista FROM area WHERE id_dependencia = %s ORDER BY clave_area ASC", GetSQLValueString($aDep_area, "int"));
$area = mysql_query($query_area, $SAG) or die(mysql_error());
$row_area = mysql_fetch_assoc($area);
$totalRows_area = mysql_num_rows($area);


$aPer_determinantes = "-1";
if (isset($_COOKIE ['id_periodo'])) {
  $aPer_determinantes = $_COOKIE ['id_periodo'];
}
$aDep_determinantes = "-1";
if (isset($_COOKIE ['id_dependencia'])) {
  $aDep_determinantes = $_COOKIE ['id_dependencia'];
}
$aArea_determinantes = $row_area['id_area'];
if (isset($_POST['id_area'])) {
  $aArea_determinantes = $_POST['id_area'];
}
mysql_select_db($database_SAG, $SAG);
$query_determinantes = sprintf("SELECT resguardo.id_periodo, resguardo.id_dependencia, resguardo_partidas.id_determinantes, determinantes.clave_determinante, Sum(resguardo_partidas.unidades) AS total FROM resguardo_partidas INNER JOIN resguardo ON resguardo_partidas.id_resguardo = resguardo.id_resguardo INNER JOIN determinantes ON resguardo_partidas.id_determinantes = determinantes.id_determinantes WHERE resguardo.id_periodo = %s and resguardo.id_dependencia = %s  and  resguardo.id_area = %s GROUP BY resguardo.id_periodo, resguardo.id_dependencia, resguardo_partidas.id_determinantes, determinantes.clave_determinante ORDER BY resguardo.id_periodo ASC, resguardo.id_dependencia ASC, determinantes.clave_determinante ASC", GetSQLValueString($aPer_determinantes, "int"),GetSQLValueString($aDep_determinantes, "int"),GetSQLValueString($aArea_determinantes, "int"));
$determinantes = mysql_query($query_determinantes, $SAG) or die(mysql_error());
$row_determinantes = mysql_fetch_assoc($determinantes);
$totalRows_determinantes = mysql_num_rows($determinantes);


$aPer_det_enc = "-1";
if (isset($_COOKIE ['id_periodo'])) {
  $aPer_det_enc = $_COOKIE ['id_periodo'];
}
$aDep_det_enc = "-1";
if (isset($_COOKIE ['id_dependencia'])) {
  $aDep_det_enc = $_COOKIE ['id_dependencia'];
}
$aArea_det_enc = $row_area['id_area'];
if (isset($_POST['id_area'])) {
  $aArea_det_enc = $_POST['id_area'];
}
mysql_select_db($database_SAG, $SAG);
$query_det_enc = sprintf("SELECT resguardo.id_periodo, resguardo.id_dependencia, resguardo_partidas.id_determinantes, determinantes.clave_determinante, Sum(resguardo_partidas.unidades) AS total FROM resguardo_partidas INNER JOIN resguardo ON resguardo_partidas.id_resguardo = resguardo.id_resguardo INNER JOIN determinantes ON resguardo_partidas.id_determinantes = determinantes.id_determinantes WHERE resguardo.id_periodo = %s and resguardo.id_dependencia = %s  and  resguardo.id_area = %s GROUP BY resguardo.id_periodo, resguardo.id_dependencia, resguardo_partidas.id_determinantes, determinantes.clave_determinante ORDER BY resguardo.id_periodo ASC, resguardo.id_dependencia ASC, determinantes.clave_determinante ASC", GetSQLValueString($aPer_det_enc, "int"),GetSQLValueString($aDep_det_enc, "int"),GetSQLValueString($aArea_det_enc, "int"));
$det_enc = mysql_query($query_det_enc, $SAG) or die(mysql_error());
$row_det_enc = mysql_fetch_assoc($det_enc);
$totalRows_det_enc = mysql_num_rows($det_enc);



$colname_dependencia = "-1";
if (isset($_COOKIE ['id_dependencia'])) {
  $colname_dependencia = $_COOKIE ['id_dependencia'];
}
mysql_select_db($database_SAG, $SAG);
$query_dependencia = sprintf("SELECT * FROM dependencia WHERE id_dependencia = %s", GetSQLValueString($colname_dependencia, "int"));
$dependencia = mysql_query($query_dependencia, $SAG) or die(mysql_error());
$row_dependencia = mysql_fetch_assoc($dependencia);
$totalRows_dependencia = mysql_num_rows($dependencia);

$colname_periodo = "-1";
if (isset($_COOKIE ['id_periodo'])) {
  $colname_periodo = $_COOKIE ['id_periodo'];
}
mysql_select_db($database_SAG, $SAG);
$query_periodo = sprintf("SELECT * FROM periodo WHERE id_periodo = %s", GetSQLValueString($colname_periodo, "int"));
$periodo = mysql_query($query_periodo, $SAG) or die(mysql_error());
$row_periodo = mysql_fetch_assoc($periodo);
$totalRows_periodo = mysql_num_rows($periodo);

$aPer_emple = "-1";
if (isset($_COOKIE ['id_periodo'])) {
  $aPer_emple = $_COOKIE ['id_periodo'];
}
$aDep_emple = "-1";
if (isset($_COOKIE ['id_dependencia'])) {
  $aDep_emple = $_COOKIE ['id_dependencia'];
}
$aArea_emple = $row_area['id_area'];
if (isset($_POST['id_area'])) {
  $aArea_emple = $_POST['id_area'];
}

mysql_select_db($database_SAG, $SAG);
$query_emple = sprintf("SELECT resguardo.id_periodo, resguardo.id_dependencia, resguardo.id_empleado_tm, tm.matricula as tm_matricula, tm.rfc as tm_rfc, tm.nombre as tm_nombre FROM resguardo INNER JOIN empleado AS tm ON resguardo.id_empleado_tm = tm.id_empleado WHERE 
resguardo.id_periodo = %s AND resguardo.id_dependencia = %s AND 
resguardo.id_area = %s
GROUP BY resguardo.id_empleado_tm ORDER BY resguardo.id_periodo ASC, resguardo.id_dependencia ASC, tm.rfc ASC ", GetSQLValueString($aPer_emple, "int"),GetSQLValueString($aDep_emple, "int"),GetSQLValueString($aArea_emple, "int"));

$emple = mysql_query($query_emple, $SAG) or die(mysql_error());
$row_emple = mysql_fetch_assoc($emple);
$totalRows_emple = mysql_num_rows($emple);


$aPer_deter_emple = "-1";
if (isset($_COOKIE ['id_periodo'])) {
  $aPer_deter_emple = $_COOKIE ['id_periodo'];
}

$aArea_deter_emple = $row_area['id_area'];
if (isset($_POST['id_area'])) {
  $aArea_deter_emple = $_POST['id_area'];
}
$aDet_deter_emple = "-1";
if (isset($aDet)) {
  $aDet_deter_emple = $aDet;
}
$aDep_deter_emple = "-1";
if (isset($_COOKIE ['id_dependencia'])) {
  $aDep_deter_emple = $_COOKIE ['id_dependencia'];
}
$aEmp_deter_emple = "-1";
if (isset($aEmp)) {
  $aEmp_deter_emple = $aEmp;
}
mysql_select_db($database_SAG, $SAG);
$query_deter2_emple = "SELECT 	resguardo.id_periodo, 	resguardo.id_dependencia, 	resguardo.id_empleado_tm AS tm_id_empleado, 	tm.matricula AS tm_matricula, 	tm.rfc AS tm_rfc, 	resguardo_partidas.id_determinantes, 	determinantes.clave_determinante, 	Sum( 		resguardo_partidas.unidades 	) AS total FROM 	resguardo_partidas INNER JOIN resguardo ON resguardo_partidas.id_resguardo = resguardo.id_resguardo INNER JOIN determinantes ON resguardo_partidas.id_determinantes = determinantes.id_determinantes INNER JOIN empleado AS tm ON resguardo.id_empleado_tm = tm.id_empleado WHERE 	resguardo.id_periodo = %s AND resguardo.id_dependencia = %s AND resguardo.id_area = %s AND resguardo.id_empleado_tm = %s AND resguardo_partidas.id_determinantes = %s GROUP BY 	resguardo.id_periodo, 	resguardo.id_dependencia,   resguardo.id_area, 	resguardo.id_empleado_tm, 	resguardo_partidas.id_determinantes";
$query_deter_emple = sprintf($query_deter2_emple, GetSQLValueString($aPer_deter_emple, "int"),GetSQLValueString($aDep_deter_emple, "int"),GetSQLValueString($aArea_deter_emple, "int"),GetSQLValueString($aEmp_deter_emple, "int"),GetSQLValueString($aDet_deter_emple, "int"));
$deter_emple = mysql_query($query_deter_emple, $SAG) or die(mysql_error());
$row_deter_emple = mysql_fetch_assoc($deter_emple);
$totalRows_deter_emple = mysql_num_rows($deter_emple);


$aArea_area2 = "-1";
if (isset($_POST['id_area'])) {
  $aArea_area2 = $_POST['id_area'];
}
mysql_select_db($database_SAG, $SAG);
$query_area2 = sprintf("SELECT *,CONCAT(area.clave_area,' | ',area.des_area) AS lista FROM area WHERE id_area= %s ORDER BY clave_area ASC", GetSQLValueString($aArea_area2, "int"));
$area2 = mysql_query($query_area2, $SAG) or die(mysql_error());
$row_area2 = mysql_fetch_assoc($area2);
$totalRows_area2 = mysql_num_rows($area2);

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
<style type="text/css">

#muestra { width: 300px; }
</style>

</head>

<body>

<!--Inicio: Script Bootstrap -->

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../js/bootstrap.min.js"></script>

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


<!-- Inicio:Librerias en PDF -->



<!-- Fin:Librerias en EXCEL -->


<!--Fin: Script Bootstrap -->  

<!--Menu -->
<?PHP 
$adm_Usuario   = $_COOKIE ["usuario_global"]; 
?>
<?PHP $menu = 1; ?>
<?PHP require_once('../barra01.php'); ?>
<!--Menu -->
 <a href="javascript:imprSelec('muestra')">
 <button type="button" 
         class="btn btn-success">
 <span class="glyphicon glyphicon-print"></span>
 Imprimir
 </button>
</a>
<h3> <center> 
<form action="index.php" method="post" >
  <label for="id_area"> Área: </label>
  <select name="id_area" id="id_area" onchange="this.form.submit()">
    <?php
do {  
?>
    <option value="<?php echo $row_area['id_area']?>"<?php if (!(strcmp($row_area['id_area'], $_POST['id_area']))) {echo "selected=\"selected\"";} ?>><?php echo $row_area['lista']?></option>
    <?php
} while ($row_area = mysql_fetch_assoc($area));
  $rows = mysql_num_rows($area);
  if($rows > 0) {
      mysql_data_seek($area, 0);
	  $row_area = mysql_fetch_assoc($area);
  }
?>
  </select>

</form>
</center>
</h3>

<p>
  <?PHP 

$aArea_area2 = $row_area['id_area'];
if (isset($_POST['id_area'])) {
  $aArea_area2 = $_POST['id_area'];
}
mysql_select_db($database_SAG, $SAG);
$query_area2 = sprintf("SELECT *,CONCAT(area.clave_area,' | ',area.des_area) AS lista FROM area WHERE id_area= %s ORDER BY clave_area ASC", GetSQLValueString($aArea_area2, "int"));
$area2 = mysql_query($query_area2, $SAG) or die(mysql_error());
$row_area2 = mysql_fetch_assoc($area2);
$totalRows_area2 = mysql_num_rows($area2);

mysql_select_db($database_SAG, $SAG);


$nTCol = $totalRows_determinantes; 
$nCol = 0;
$nColCorte = 0;
$nCorte = 0;

?>
</p>
<p>&nbsp;</p>

<?PHP 
//echo "(".$totalRows_det_enc.")". $query_det_enc;
//echo "id_area = ".$_POST['id_area']."<br>" ;
//echo "SQL = ".$query_deter_emple ."<br>" ;

?>

<?PHP 
$nTit1 = 'COLEGIO DE BACHILLERES';

$nTit2 ='( '.$row_dependencia['clave_dependencia'].') '. $row_dependencia['depen_descripcion'];
 
$nTit3 = 'LISTADO DE CONCENTRADO DE BIENES DEL  ( '.$row_area2['clave_area'].') '.$row_area2['des_area'].' SEMESTRE '. $row_periodo['semestre'];
?>  

<div id="muestra" style="width:100%; height:100%;">  
<?php $nPag = 1 ; ?>
<?PHP do {  ?>
<table width='100%' 
       border='0' 
       cellspacing='0' 
       bordercolor='#666666'
 style='
  border-collapse:collapse;
  page-break-before: always;
  table-layout: auto;'>
<caption> 
	<h4>
	<?PHP echo $nTit1;?>
    <br />
	<?PHP echo $nTit2."  Págna :  ".$nPag;?>
    <br />
	<?PHP echo $nTit3;?>
	</h4>
 </caption>
<?php $nPag += 1 ; ?> 
 <tr>
    <td style=" 
    border: 1px solid black;
    border-collapse: collapse; 
    text-align:center">
          <p style=" 
      width: 20px;
      font-size: 8px;  
      text-align: center ">
    Num
    </p>
    </td>
    <td style=" 
    border: 1px solid black;
    border-collapse: collapse; 
    text-align:center">
    <p style=" 
      width: 40px;
      font-size: 9px;  
      text-align: center ">
    Matricula
    </p>
    </td>
    <td style=" 
    border: 1px solid black;
    border-collapse: collapse; 
    text-align:center">
    <p style=" 
      width: 40px;
      font-size: 10px;  
      text-align: center ">    
    RFC
    </p>
    </td>
    <td style=" 
    border: 1px solid black;
    border-collapse: collapse; 
    text-align:center">
    <p style=" 
      width: 150px;
      font-size: 9px;  
      text-align: center ">
    NOMBRE
    </p>
    </td>  

<!-- Fin: Encabezado Determinantes -->      
    <?php 
      $nDete  = 0;
      $aCL_Dete = array();
	  $aID_Dete = array();
      $nTDete = array();
	  $corte  = true;
	  
    ?>
    <?php for ($i = 1; $i <= 20; $i++) { ?>
    <?PHP 
		
    if (!empty($row_det_enc))
	{	  
     array_push($aCL_Dete,
$row_det_enc['clave_determinante']);
     array_push($aID_Dete,
$row_det_enc['id_determinantes']);
     array_push($nTDete,0);
	 array_push($nSDete,0);
?>    
    <td style=" 
    border: 1px solid black;
    border-collapse: collapse; 
    text-align:center" >
    <p style=" 
      width: 30px;
      font-size: 10px;  
      text-align: center ">         
    <?php echo $row_det_enc['clave_determinante']; ?>
    </p>
    </td> 
	<?PHP
    }
    else
	{
	?>	 
    <td style=" 
    border: 1px solid black;
    border-collapse: collapse; 
    text-align:center" >
    <p style=" 
      width: 30px;
      font-size: 10px;  
      text-align: center ">         
    -----
    </p> 
    </td>

    <?PHP 
	}
	?>
	<?PHP $row_det_enc = mysql_fetch_assoc($det_enc); ?>
    
<?php }  ?>
      
<!-- Fin: Encabezado Determinantes -->   
    <td style=" 
    border: 1px solid black;
    border-collapse: collapse; 
    text-align:center" >
    <p style=" 
      width: 30px;
      font-size: 9px;  
      text-align: center ">  
    TOTAL
     </p> 
   
     </td> 
  </tr>  
<?PHP $Num = 0; ?>
<?PHP $Enc2= false; ?>
<?PHP do {  // Empleado ?> 


<? if ($Enc2) { //Encabezado 2?>
<? echo "
</table> 
<table width='100%' 
       border='0' 
       cellspacing='0' 
       bordercolor='#666666'
 style='
  border-collapse:collapse;
  page-break-before: always;
  table-layout: auto;'>
<caption> 
<h4> ".$nTit1."<br />"
.$nTit2."   Págna :  ".$nPag."<br />
".$nTit3."
</h4>
  </caption>
"; ?>
<?php $nPag += 1 ; ?>
 <tr>
    <td style=" 
    border: 1px solid black;
    border-collapse: collapse; 
    text-align:center">
          <p style=" 
      width: 20px;
      font-size: 8px;  
      text-align: center ">
    Num
    </p>
    </td>
    <td style=" 
    border: 1px solid black;
    border-collapse: collapse; 
    text-align:center">
    <p style=" 
      width: 40px;
      font-size: 9px;  
      text-align: center ">
    Matricula
    </p>
    </td>
    <td style=" 
    border: 1px solid black;
    border-collapse: collapse; 
    text-align:center">
    <p style=" 
      width: 40px;
      font-size: 10px;  
      text-align: center ">    
    RFC
    </p>
    </td>
    <td style=" 
    border: 1px solid black;
    border-collapse: collapse; 
    text-align:center">
    <p style=" 
      width: 150px;
      font-size: 9px;  
      text-align: center ">
    NOMBRE
    </p>
    </td>  

<!-- Inicio: Determinantes -->    <?php for ($i = 0; $i <= 19; $i++) { ?>
    <?PHP 
		
    if (!empty($aCL_Dete[$i]))
	{
     array_push($nTDete,0);
	 array_push($nSDete,0);
?>    
    <td style=" 
    border: 1px solid black;
    border-collapse: collapse; 
    text-align:center" >
    <p style=" 
      width: 30px;
      font-size: 9px;  
      text-align: center ">         
    <?php echo $aCL_Dete[$i]; ?>
    </p>
    </td> 
	<?PHP
    }
    else
	{
	?>	 
    <td style=" 
    border: 1px solid black;
    border-collapse: collapse; 
    text-align:center" >
    <p style=" 
      width: 30px;
      font-size: 9px;  
      text-align: center ">         
    -----
    </p> 
    </td>

    <?PHP 
	}
	?>
<?php }  ?>
      
<!-- Fin: Encabezado Determinantes -->   
    <td style=" 
    border: 1px solid black;
    border-collapse: collapse; 
    text-align:center" >
    <p style=" 
      width: 30px;
      font-size: 9px;  
      text-align: center ">  
    TOTAL
     </p> 
   
     </td> 
  </tr>  
<?PHP } // Encabezado 2 ?>


<?php for ($i = 1; $i <= 19; $i++) { ?>
<?PHP 
$Num += 1; 
$Enc2= true;  // Encabezado 2
?>
 <tr style=" height: 30px; 
 <?PHP if (fmod($Num,2) == 0) { ?>
  background-color:#DBFCD6;
   <?PHP } ?>
   "
    >
    
    <td style=" 
    border: 1px solid black;
    border-collapse: collapse; 
    text-align:center">
          <p style=" 
      width: 10px;
      font-size: 10px;  
      text-align: center ">
    <?php echo $Num; ?>
    </p>
    </td>
     <td style=" 
    border: 1px solid black;
    border-collapse: collapse; 
    text-align:center">
    <p style=" 
      width: 45px;
      font-size: 9px;  
      text-align: center ">
    <?php echo $row_emple['tm_matricula']; ?>
    </p>
    </td>
    <td style=" 
    border: 1px solid black;
    border-collapse: collapse; 
    text-align:center">
    <p style=" 
      width: 70px;
      font-size: 9px;  
      text-align: center ">    
    <?php echo $row_emple['tm_rfc']; ?>
    </p>
    </td>
    <td style=" 
    border: 1px solid black;
    border-collapse: collapse; 
    text-align:left ">
    <p style=" 
      width: 150px;
      font-size: 9px;  
      text-align: center ">
    <?php echo $row_emple['tm_nombre']; ?>
    </p>
    </td>
<!-- Inicio: Determinantes --> 
   <?PHP $nTLinea = 0; ?>
   <?php for ($j = 0; $j <= 19; $j++) { ?>
    <?PHP 
		
    if (!empty($aCL_Dete[$j]))
	{

// Consulta Det_emp

$aDet_deter_emple = $aID_Dete[$j];
$aEmp_deter_emple = $row_emple['id_empleado_tm'];

$query_deter_emple = sprintf($query_deter2_emple, GetSQLValueString($aPer_deter_emple, "int"),GetSQLValueString($aDep_deter_emple, "int"),GetSQLValueString($aArea_deter_emple, "int"),GetSQLValueString($aEmp_deter_emple, "int"),GetSQLValueString($aDet_deter_emple, "int"));
$deter_emple = mysql_query($query_deter_emple, $SAG) or die(mysql_error());
$row_deter_emple = mysql_fetch_assoc($deter_emple);
$totalRows_deter_emple = mysql_num_rows($deter_emple);

//	
 $nCan = $row_deter_emple ['total'];	
 $nTDete[$j] += $nCan;
 $nSDete[$j] += $nCan;
 $nTLinea    += $nCan;
?>    
    <td style=" 
    border: 1px solid black;
    border-collapse: collapse; 
    text-align:center" >
    <p style=" 
      width: 30px;
      font-size: 9px;  
      text-align: center ">         
    <?php echo $nCan; ?> 
    
<?php 
//echo "(".$aEmp_deter_emple.")".$aDet_deter_emple; 

// echo $query_deter_emple ; ?>  
    </p>
    </td> 
	<?PHP
    }
    else
	{
	?>	 
    <td style=" 
    border: 1px solid black;
    border-collapse: collapse; 
    text-align:center" >
    <p style=" 
      width: 30px;
      font-size: 9px;  
      text-align: center ">         
    ----
    </p> 
    </td>

    <?PHP 
	}
	?>
<?php }  ?>
      
<!-- Fin:Determinantes -->   
    <td style=" 
    border: 1px solid black;
    border-collapse: collapse; 
    text-align:center" >
    <p style=" 
      width: 30px;
      font-size: 9px;  
      text-align: center ">  
    <?php echo $nTLinea; ?> 
     </p> 
   
     </td> 
    
    
    
    
        
 <?PHP $row_emple = mysql_fetch_assoc($emple); ?> 
 </tr>
<?php  } ?>
<tr style=" height: 10px; 
  background-color: #00FF99;
  ">
    <td style=" 
    border: 1px solid black;
    border-collapse: collapse; 
    text-align:center">
          <p style=" 
      width: 20px;
      font-size: 10px;  
      text-align: center ">&nbsp;</p>
    </td>
     <td style=" 
    border: 1px solid black;
    border-collapse: collapse; 
    text-align:center">
    <p style=" 
      width: 45px;
      font-size: 9px;  
      text-align: center ">&nbsp;</p>
    </td>
    <td style=" 
    border: 1px solid black;
    border-collapse: collapse; 
    text-align:center">
    <p style=" 
      width: 70px;
      font-size: 9px;  
      text-align: center ">&nbsp;</p>
    </td>
    <td style=" 
    border: 1px solid black;
    border-collapse: collapse; 
    text-align:left ">
    <p style=" 
      width: 150px;
      font-size: 10px;  
      text-align: center ">
    SUBTOTAL
    </p>
    </td>
<!-- Inicio: Determinantes --> 
   <?PHP $nTLinea = 0; ?>
   <?php for ($j = 0; $j <= 19; $j++) { ?>
    <?PHP 
		
    if (!empty($aCL_Dete[$j]))
	{	  
?>    
    <td style=" 
    border: 1px solid black;
    border-collapse: collapse; 
    text-align:center" >
    <p style=" 
      width: 30px;
      font-size: 9px;  
      text-align: center ">         
    <?php echo $nSDete[$j]; ?>
    <?php 
	  $nTLinea += $nSDete[$j];
	  $nSDete[$j] = 0;
	?>
    
    </p>
    </td> 
	<?PHP
    }
    else
	{
	?>	 
    <td style=" 
    border: 1px solid black;
    border-collapse: collapse; 
    text-align:center" >
    <p style=" 
      width: 30px;
      font-size: 9px;  
      text-align: center ">         
    ----
    </p> 
    </td>

    <?PHP 
	}
	?>
<?php }  ?>
      
<!-- Fin:Determinantes -->   
    <td style=" 
    border: 1px solid black;
    border-collapse: collapse; 
    text-align:center" >
    <p style=" 
      width: 30px;
      font-size: 9px;  
      text-align: center ">  
    <?php echo $nTLinea; ?> 
     </p> 
   
     </td>         
</tr>  
  

<?php } while (!empty($row_emple)); ?> 
<?PHP
$emple = mysql_query($query_emple, $SAG) or die(mysql_error());
$row_emple = mysql_fetch_assoc($emple);
$totalRows_emple = mysql_num_rows($emple);
?>

<tr style=" height: 10px; 
  background-color: #00CC00;
  ">
    <td style=" 
    border: 1px solid black;
    border-collapse: collapse; 
    text-align:center">
          <p style=" 
      width: 20px;
      font-size: 10px;  
      text-align: center ">&nbsp;</p>
    </td>
     <td style=" 
    border: 1px solid black;
    border-collapse: collapse; 
    text-align:center">
    <p style=" 
      width: 45px;
      font-size: 9px;  
      text-align: center ">&nbsp;</p>
    </td>
    <td style=" 
    border: 1px solid black;
    border-collapse: collapse; 
    text-align:center">
    <p style=" 
      width: 70px;
      font-size: 9px;  
      text-align: center ">&nbsp;</p>
    </td>
    <td style=" 
    border: 1px solid black;
    border-collapse: collapse; 
    text-align:left ">
    <p style=" 
      width: 150px;
      font-size: 10px;  
      text-align: center ">TOTAL</p>
    </td>
<!-- Inicio: Determinantes --> 
   <?PHP $nTLinea = 0; ?>
   <?php for ($j = 0; $j <= 19; $j++) { ?>
    <?PHP 
		
    if (!empty($aCL_Dete[$j]))
	{	  
?>    
    <td style=" 
    border: 1px solid black;
    border-collapse: collapse; 
    text-align:center" >
    <p style=" 
      width: 30px;
      font-size: 9px;  
      text-align: center ">         
    <?php echo $nTDete[$j]; ?>
    <?php 
	  $nTLinea += $nTDete[$j];
	  $nTDete[$j] = 0;
	?>
    
    </p>
    </td> 
	<?PHP
    }
    else
	{
	?>	 
    <td style=" 
    border: 1px solid black;
    border-collapse: collapse; 
    text-align:center" >
    <p style=" 
      width: 30px;
      font-size: 9px;  
      text-align: center ">         
    ----
    </p> 
    </td>

    <?PHP 
	}
	?>
<?php }  ?>
      
<!-- Fin:Determinantes -->   
    <td style=" 
    border: 1px solid black;
    border-collapse: collapse; 
    text-align:center" >
    <p style=" 
      width: 30px;
      font-size: 9px;  
      text-align: center ">  
    <?php echo $nTLinea; ?> 
     </p> 
   
     </td>         
</tr>  


</table>  
<?php } while (!empty($row_det_enc)); ?>  
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


  
  
<bR />
  
     
</div>     
</body>
</html>
<?php
mysql_free_result($determinantes);

mysql_free_result($det_enc);

mysql_free_result($dependencia);

mysql_free_result($periodo);

mysql_free_result($emple);

mysql_free_result($deter_emple);

mysql_free_result($area);

mysql_free_result($area2);

?>
