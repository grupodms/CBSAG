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

$colname_Resguardo = "-1";
if (isset($_GET['id_dependencia'])) {
  $colname_Resguardo = $_GET['id_dependencia'];
}
mysql_select_db($database_SAG, $SAG);
$query_Resguardo = sprintf("SELECT resguardo.id_resguardo, resguardo.id_periodo, resguardo.id_dependencia, resguardo.id_area, resguardo.id_consecutivo, resguardo.id_empleado_tm, resguardo.id_empleado_tv, resguardo.fecha, resguardo_partidas.id_resguardo, resguardo_partidas.id_resguardo_partidas, resguardo_partidas.id_determinantes, resguardo_partidas.clave_determinante, resguardo_partidas.descripcion, resguardo_partidas.cambs, resguardo_partidas.unidades, resguardo_partidas.id_estado_fisico, resguardo_partidas.num_serie, resguardo_partidas.entrada_vale, resguardo_partidas.numero_inventario, resguardo_partidas.observaciones, resguardo_partidas.num_seriea, resguardo_partidas.alta, resguardo_partidas.baja, dependencia.clave_dependencia, dependencia.depen_descripcion, area.clave_area, area.des_area, consecutivo.clave_conse, consecutivo.descripcion_consecutivo FROM resguardo INNER JOIN resguardo_partidas ON resguardo.id_resguardo = resguardo_partidas.id_resguardo INNER JOIN dependencia ON resguardo.id_dependencia = dependencia.id_dependencia INNER JOIN area ON area.id_dependencia = dependencia.id_dependencia INNER JOIN consecutivo ON  resguardo.id_consecutivo = consecutivo.id_consecutivo WHERE resguardo.id_dependencia = %s", GetSQLValueString($colname_Resguardo, "int"));
$Resguardo = mysql_query($query_Resguardo, $SAG) or die(mysql_error());
$row_Resguardo = mysql_fetch_assoc($Resguardo);
$totalRows_Resguardo = mysql_num_rows($Resguardo);

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
  <h1> Resumen.</h1> 
  
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
if (isset($_POST["campo"] )) {$campo  =$_POST["campo"];}  else {$campo="no_socio";}


$des_campo = '';
if($campo=='no_socio')           {$des_campo ='No de Socio';}  
if($campo=='razon_social_socio') {$des_campo ='Razón Social';}  
if($campo=='rfc_socio')          {$des_campo ='RFC';}  
if($campo=='servicios')          {$des_campo ='Sevicios';} 




if ((isset($_POST["boton_buscar"]))) 
   {
	echo '<div class="alert alert-success" role="alert">';   
    echo "     Buscar: ".$buscar;
    echo "<br> Campo : ".$des_campo;
   }
else
   {
	echo '<div class="alert alert-info" role="alert">';      
    echo "     Buscar: Mostrar Todo";
    echo "<br> Campo : Ninguno      ";
	$buscar="";
	$campo="no_socio";
   }
   echo "<br> </div>";   
?>
<form action="../ASEM/index.php" method="post" name="formclave" 
      class="navbar-form navbar-left" role="search" >
  <div class="form-group">

    <input type="text" 
           name="buscar" 
           value="<?PHP echo $buscar; ?>"
           placeholder="Buscar">
&nbsp; por que campo:
	<SELECT NAME="campo"  class="form-control"> 
            <OPTION
               <?PHP if($campo=='no_socio') {echo 'selected="selected"';} ?>  
               VALUE="no_socio">Num. Socio</OPTION> 
            <OPTION  
               <?PHP if($campo=='razon_social_socio') {echo 'selected="selected"';} ?> 
               VALUE="razon_social_socio">Razon Social</OPTION> 
            <OPTION 
               <?PHP if($campo=='rfc_socio') {echo 'selected="selected"';} ?> 
               VALUE="rfc_socio">R.F.C.</OPTION> 
             <OPTION 
               <?PHP if($campo=='servicios') {echo 'selected="selected"';} ?> 
               VALUE="servicios">Servicios</OPTION> 
    </SELECT>
        <button  name="boton_buscar" type="submit" 
                 class="btn btn-success">Buscar </button>
        <button  name="boton_totodo" type="submit" 
                 class="btn btn-primary">Mostrar Todo</button>
        <a href="nuevo.php">
  	             <button type="button" class="btn btn-success">
                         <span class="glyphicon glyphicon-pencil"></span>Nuevo
  	             </button>
        </a>
				 
				 
	  </div>  
</form>
&nbsp;&nbsp;




  <table width="100%" border="0" align="center" class="table table-hover">
    
    <tr class="info">
      <td>id</td>
      <td>Dep</td>
      <td>Clave</td>
      <td>Descripcion</td>
      <td>Unidades</td>
      
      
     
    </tr>
<?php $nTot = 0; ?>
<?php do { ?>
<?php $nTot = $nTot+ $row_Resguardo['unidades']; ?>
    <tr>
      <td><?php echo $row_Resguardo['id_resguardo_partidas']; ?></td>
      <td><?php echo $row_Resguardo['id_dependencia']; ?></td>
      <td><?php echo $row_Resguardo['clave_determinante']; ?></td>
      <td><?php echo $row_Resguardo['descripcion']; ?></td>
      <td><?php echo $row_Resguardo['unidades']; ?></td>
  
    </tr>

  <?php } while ($row_Resguardo = mysql_fetch_assoc($Resguardo)); ?>
      <tr class="info">
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>Total</td>
      <td><?PHP echo $nTot ?></td>
      
      

    </tr>	
  </table>

</body>
</html>
<?php
mysql_free_result($Resguardo);

mysql_free_result($V_ASEM);
?>
