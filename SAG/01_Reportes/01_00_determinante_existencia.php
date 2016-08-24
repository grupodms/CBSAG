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
$query_Periodo = "SELECT * FROM periodo WHERE activo_fijo = 1 ORDER BY id_periodo DESC";
$Periodo = mysql_query($query_Periodo, $SAG) or die(mysql_error());
$row_Periodo = mysql_fetch_assoc($Periodo);
$totalRows_Periodo = mysql_num_rows($Periodo);
mysql_select_db($database_SAG, $SAG);

if ((isset($_POST["buscar"])) &&  
    (isset($_POST["campo"]))  &&
	(isset($_POST["periodo"]))  &&
	(isset($_POST["boton_buscar"])))
{
$buscar  =$_POST["buscar"];
$campo   =$_POST["campo"];
$periodo =$_POST["periodo"];

$query_Periodo2 = "SELECT * FROM periodo 
                            WHERE activo_fijo = 1 and  
							      periodo.id_periodo = ".$periodo."
						    ORDER BY id_periodo DESC";
$Periodo2 = mysql_query($query_Periodo2, $SAG) or die(mysql_error());
$row_Periodo2 = mysql_fetch_assoc($Periodo2);
$periodo_des = $row_Periodo2['semestre'];

$query_Reg_Deter = "
SELECT
activo_fijo_partidas.id_determinantes,
determinantes.clave_determinante,
determinantes.descripcion,
determinantes.cambs,
determinantes.cuenta,
determinantes.cuenta2,
if (determinantes.comodato = 1,'X','') AS comodato,
if (determinantes.donacion = 1,'X','') AS donacion,
Sum(activo_fijo_partidas.cantidad) AS cantidad,
activo_fijo.id_periodo,
periodo.semestre,
CONCAT(periodo.semestre,determinantes.clave_determinante) as orden_grupo
FROM
activo_fijo_partidas
INNER JOIN determinantes ON activo_fijo_partidas.id_determinantes = determinantes.id_determinantes
INNER JOIN activo_fijo ON activo_fijo.id_activo_fijo = activo_fijo_partidas.id_activo_fijo
INNER JOIN periodo ON activo_fijo.id_periodo = periodo.id_periodo
           Where periodo.id_periodo = ".$periodo." and
		   ".$campo." LIKE '%".$buscar."%' 
GROUP BY
orden_grupo
ORDER BY
orden_grupo ASC	  
		  
		  
		  ";

}
else
{
$periodo     = $row_Periodo['id_periodo'];
$periodo_des = $row_Periodo['semestre'];
	
$query_Reg_Deter = "
SELECT
activo_fijo_partidas.id_determinantes,
determinantes.clave_determinante,
determinantes.descripcion,
determinantes.cambs,
determinantes.cuenta,
determinantes.cuenta2,
if (determinantes.comodato = 1,'X','') AS comodato,
if (determinantes.donacion = 1,'X','') AS donacion,
Sum(activo_fijo_partidas.cantidad) AS cantidad,
activo_fijo.id_periodo,
periodo.semestre,
CONCAT(periodo.semestre,determinantes.clave_determinante) as orden_grupo
FROM
activo_fijo_partidas
INNER JOIN determinantes ON activo_fijo_partidas.id_determinantes = determinantes.id_determinantes
INNER JOIN activo_fijo ON activo_fijo.id_activo_fijo = activo_fijo_partidas.id_activo_fijo
INNER JOIN periodo ON activo_fijo.id_periodo = periodo.id_periodo
      Where periodo.id_periodo = ".$periodo." 
GROUP BY
orden_grupo
ORDER BY
orden_grupo ASC

	 
	 ";
}


$Reg_Deter = mysql_query($query_Reg_Deter, $SAG) or die(mysql_error());
$row_Reg_Deter = mysql_fetch_assoc($Reg_Deter);
$totalRows_Reg_Deter = mysql_num_rows($Reg_Deter);

// 
// Registro Periodos
//





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
  
  <table width="100%" border="0">
  <tr>
    <td width="60%"><h1>Determinantes Existencias</h1> </td>
    <td><img src="../img/excel.gif" width="85" height="85" /></td>
    <td><img src="../img/pdf.gif" width="85" height="85" /></td>
  </tr>
</table>

  </p>
</blockquote>
<?php
function dias($fecha_i,$fecha_f)
{
	$dias	= (strtotime($fecha_i)-strtotime($fecha_f))/86400;
	//$dias =   abs($dias); 
	$dias = floor($dias);
	$dias++;
	return $dias;
}
$hoy = date("Y-m-d");

function estado_texto ($dias)
{
	$estado = "";
	if     ($dias <= 30)  
	       {$estado = "Vigente";}
	elseif (($dias >= 31) && ($dias <= 60))
	       {$estado = "Condicionado";}
	elseif ($dias >= 61)  
           {$estado = "Sin Servicio";}
	else
	  	   {$estado = " ";}
	return $estado;    
}           

function estado_color ($dias)
{
	$estado = "";
	if     ($dias <= 30) 
	       {$estado = "alert-success";}
	elseif (($dias >= 31) && ($dias <= 60))
	       {$estado = "alert-warning";}
	elseif ($dias >= 61)  
           {$estado = "alert-danger";}
	else
	  	   {$estado = " ";}
           	
	return $estado;    
}


?>

<?PHP


if (isset($_POST["buscar"])) {$buscar =$_POST["buscar"];} else {$buscar="";}
if (isset($_POST["campo"] )) {$campo  =$_POST["campo"];}  else {$campo="clave_determinante";}


$des_campo = '';
if($campo=='clave_determinante')    {$des_campo ='clave determinante';}  
if($campo=='descripcion')           {$des_campo ='descripcion';}  
if($campo=='cuenta')                {$des_campo ='Cuenta';}  
if($campo=='cuenta2')               {$des_campo ='Cuenta2';} 




if ((isset($_POST["boton_buscar"]))) 
   {
	echo '<div class="alert alert-success" role="alert">';   
    echo "     Buscar :".$buscar;
    echo "<br> Campo  :".$des_campo;
	echo "<br> Perido :".$periodo_des;
   }
else
   {
	echo '<div class="alert alert-info" role="alert">';      
    echo "     Buscar : Mostrar Todo";
    echo "<br> Campo  : Ninguno      ";
    echo "<br> Perido : ".$periodo_des;
	
	$buscar="";
	$campo="descripcion";
   }
   echo "<br> </div>";   
?>
<form action="01_00_determinante_existencia.php" method="post" name="formclave" 
      class="navbar-form navbar-left" role="search" >
  <div class="form-group">

    <input type="text" 
           name="buscar" 
          
           placeholder="Buscar">
&nbsp; por que campo:
	<SELECT NAME="campo"  class="form-control"> 
            <OPTION  
               <?PHP if($campo=='descripcion') {echo 'selected="selected"';} ?> 
               VALUE="descripcion">Descripcion</OPTION> 
            <OPTION
               <?PHP if($campo=='clave_determinante') {echo 'selected="selected"';} ?>  
               VALUE="clave_determinante">Clave determinante</OPTION> 
            <OPTION 
               <?PHP if($campo=='cambs') {echo 'selected="selected"';} ?> 
               VALUE="cambs">cambs</OPTION> 
             <OPTION 
               <?PHP if($campo=='cuenta2') {echo 'selected="selected"';} ?> 
               VALUE="servicios">cuenta2</OPTION> 
</SELECT>

<SELECT NAME="periodo"  class="form-control">
  <?php
do {  
?>
  <option value="<?php echo $row_Periodo['id_periodo']?>"><?php echo $row_Periodo['semestre']?></option>
  <?php
} while ($row_Periodo = mysql_fetch_assoc($Periodo));
  $rows = mysql_num_rows($Periodo);
  if($rows > 0) {
      mysql_data_seek($Periodo, 0);
	  $row_Periodo = mysql_fetch_assoc($Periodo);
  }
?>

</SELECT>         
        <button  name="boton_buscar" type="submit" 
                 class="btn btn-success">Buscar </button>
        <button  name="boton_totodo" type="submit" 
                 class="btn btn-primary">Mostrar Todo</button>
        
				 
				 
  </div>  
</form>





	
<table width="100%" border="0" align="center" class="table table-hover">

  <tr class="info">
    <td>Clave</td>
    <td>Descripción</td>
    <td>camba </td>
    <td>cuenta</td>
    <td>cuenta2</td>
    <td>comodato</td>
    <td>donacion</td>
    <td>cantidad</td>
    <td>Semestre</td>
    <td colspan="2" align="center">Acciones</td>
  </tr>
  <?php do { ?>
  <tr>
   <td width="10%"><?php echo $row_Reg_Deter['clave_determinante']; ?></td>
   <td><?php echo $row_Reg_Deter['descripcion']; ?></td>
   <td><?php echo $row_Reg_Deter['cambs']; ?></td>
   <td><?php echo $row_Reg_Deter['cuenta']; ?></td>
   <td><?php echo $row_Reg_Deter['cuenta2']; ?></td>
   <td><?php echo $row_Reg_Deter['comodato']; ?></td>
   <td><?php echo $row_Reg_Deter['donacion']; ?></td>
   <td><?php echo $row_Reg_Deter['cantidad']; ?></td>
   <td><?php echo $row_Reg_Deter['semestre']; ?></td>   
   <td><a href="01_01_detalle_determinante.php?id_determinantes=<?PHP echo $row_Reg_Deter['id_determinantes'];?>  ">
  <button type="button" class="btn btn-success">
    <span class="glyphicon glyphicon-pencil"></span>Detalle Determinante  </button>
</a></td>
      <td>&nbsp;
      
      </td>
    </tr>
    <?php } while ($row_Reg_Deter = mysql_fetch_assoc($Reg_Deter)); ?>
</table>


</body>
</html>
<?php
mysql_free_result($Periodo);

mysql_free_result($Reg_Deter);

mysql_free_result($V_ASEM);
?>
