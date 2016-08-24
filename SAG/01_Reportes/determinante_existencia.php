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
$query_Reg_Deter = "
SELECT
activo_fijo_partidas.id_determinantes,
determinantes.clave_determinante,
determinantes.descripcion,
determinantes.cambs,
determinantes.cuenta,
determinantes.cuenta2,
if (determinantes.comodato = 1,'X','') as comodato,
if (determinantes.donacion = 1,'X','') as donacion,
Sum(activo_fijo_partidas.cantidad) AS cantidad
FROM
activo_fijo_partidas
INNER JOIN determinantes ON activo_fijo_partidas.id_determinantes = determinantes.id_determinantes
GROUP BY
activo_fijo_partidas.id_determinantes
ORDER BY
determinantes.clave_determinante ASC
 ";
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
  <h1>Determinantes Existencias</h1> 
  
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
if($campo=='clave_determinante')    {$des_campo ='Clave determinante';}  
if($campo=='descripcion')           {$des_campo ='Descripcion';}  
if($campo=='cuenta')                {$des_campo ='Cuenta';}  
if($campo=='cuenta2')               {$des_campo ='Cuenta2';} 




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
          
           placeholder="Buscar">
&nbsp; por que campo:
	<SELECT NAME="campo"  class="form-control"> 
            <OPTION
               <?PHP if($campo=='clave_determinante') {echo 'selected="selected"';} ?>  
               VALUE="no_socio">Clave determinante</OPTION> 
            <OPTION  
               <?PHP if($campo=='descripcion') {echo 'selected="selected"';} ?> 
               VALUE="razon_social_socio">Descripcion</OPTION> 
            <OPTION 
               <?PHP if($campo=='cuenta') {echo 'selected="selected"';} ?> 
               VALUE="rfc_socio">cuenta</OPTION> 
             <OPTION 
               <?PHP if($campo=='cuenta2') {echo 'selected="selected"';} ?> 
               VALUE="servicios">cuenta2</OPTION> 
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
    <td colspan="2" align="center">Acciones</td>
  </tr>
  <?php do { ?>
  <tr>
   <td><?php echo $row_Reg_Deter['clave_determinante']; ?></td>
   <td><?php echo $row_Reg_Deter['descripcion']; ?></td>
   <td><?php echo $row_Reg_Deter['cambs']; ?></td>
   <td><?php echo $row_Reg_Deter['cuenta']; ?></td>
   <td><?php echo $row_Reg_Deter['cuenta2']; ?></td>
   <td><?php echo $row_Reg_Deter['comodato']; ?></td>
   <td><?php echo $row_Reg_Deter['donacion']; ?></td>
   <td><?php echo $row_Reg_Deter['cantidad']; ?></td>
   <td><a href="detalle_determinante.php?id_empleado=<?PHP echo $row_Reg_Deter['id_determinante'];?>  ">
  <button type="button" class="btn btn-success">
    <span class="glyphicon glyphicon-pencil"></span>Detalle Determinante  </button>
</a></td>
      <td>
      &nbsp;
      </td>
    </tr>
    <?php } while ($row_Reg_Deter = mysql_fetch_assoc($Reg_Deter)); ?>
</table>


</body>
</html>
<?php
mysql_free_result($Reg_Deter);

mysql_free_result($V_ASEM);
?>
