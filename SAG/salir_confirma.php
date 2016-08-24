<?php require_once('../Connections/SAG.php'); ?>
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
$query_dependencia = "SELECT * FROM dependencia ORDER BY depen_descripcion ASC";
$dependencia = mysql_query($query_dependencia, $SAG) or die(mysql_error());
$row_dependencia = mysql_fetch_assoc($dependencia);
$totalRows_dependencia = mysql_num_rows($dependencia);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<title>Menu Principal S.I.I.A.F.I.</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
    #apDiv1 {
	position: absolute;
	width: 134px;
	height: 128px;
	z-index: 1;
	left: 7px;
	top: 94px;
	background-image: url(img/4.png);
}
    </style>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>

<!--Menu -->
<?PHP  
$adm_Usuario   = $_COOKIE ["usuario_global"]; 
$adm_Nombre    = $_COOKIE ["nombre"]; 
$adm_Perfil    = $_COOKIE ["id_perfil"]; 
$adm_NomPerfil = "";
switch ($adm_Perfil)
   {
	 case 1:
	      $adm_NomPerfil = "Administrador";
		  require_once('barra01.php');
		  break;
	 case 2:
	      $adm_NomPerfil = "Usuario";
		  require_once('barra02.php');
		  break;
	default:
	      $adm_NomPerfil = "Usuario";
		  require_once('barra01.php');
		  break;
		  	   
   }

    
?>
<?PHP $menu = 0; ?>
<!--Menu -->

<div >
   <div id="top" class="header">
       <div class="vert-text">
   <div class="panel panel-success">
                        <div class="panel-heading">
                          <table width="200" border="0" align="center" class="alert-success">
                            <tr>
                              <td><img src="img/inv_10.png" width="182" height="156" /></td>
                              <td><img src="img/inv_02.png" width="82" height="111" /></td>
                              <td colspan="2"><img src="img/salir.png" width="256" height="256" /></td>
                              <td><img src="img/inv_05.png" alt="" width="67" height="150" /></td>
                              <td><img src="img/inv_06.png" alt="" width="110" height="95" /></td>
                            </tr>
                            <tr>
 <td>
 <?php Echo "Usuario: ".$adm_Usuario;?>
 </td>
 <td colspan="4"><h1>¿ Seguro que desea salir del sistema?</h1> </td>
 <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td rowspan="2"><img src="img/inv_07.png" width="202" height="187" /></td>
                              <td rowspan="2"><img src="img/inv_08.png" width="144" height="159" /></td>
                              <td colspan="2">&nbsp;
<form name   ="form_dep" 
      method ="post" 
      action ="<?PHP echo $_COOKIE ["id_menu"]; ?>">                              
<?PHP if ($_COOKIE ["id_todos_dependencias"]==1 ){ ?>
	
<input name="id_menu" type="text" class="alert-success" id="id_menu" value="<?PHP echo $_COOKIE ["id_menu"]; ?>" readonly>
	
<select name="id_dependencia" 
              id="id_dependencia">
  <?php
do {  
?>
  <option value="<?php echo $row_dependencia['id_dependencia']?>"<?php if (!(strcmp($row_dependencia['id_dependencia'], $_COOKIE ["id_dependencia"]))) {echo "selected=\"selected\"";} ?>><?php echo $row_dependencia['depen_descripcion']?></option>
  <?php
} while ($row_dependencia = mysql_fetch_assoc($dependencia));
  $rows = mysql_num_rows($dependencia);
  if($rows > 0) {
      mysql_data_seek($dependencia, 0);
	  $row_dependencia = mysql_fetch_assoc($dependencia);
  }
?>
</select>
<input hidden="true" name="a1" type="text" size=20 value="id_dependencia">  
<input hidden="true" name="a3" type="text" size=3  value="1">

<input hidden="true" type="text" 
       name="MM_update" 
       value="form_dep" />
       
<input type="submit" 
       class="btn btn-success" 
       value=" C A M B I A R " 
onclick=
"
SetCookie('__NowTesting__',rot13(this.form.a1.value,this.form.a3.value));
SetCookie(this.form.a1.value,this.form.id_dependencia.value,this.form.a3.value);
"       
/>
<?PHP }?> 
</form>
</td>
                              <td rowspan="2"><img src="img/inv_11.png" width="156" height="167" /></td>
                              <td rowspan="2"><img src="img/inv_12.png" width="188" height="200" /></td>
                            </tr>
                            <tr>
                              <td colspan="2"><span class="btn btn-danger"><H2><a href="salir.php"> SALIR DEL SISTEMA </a></H2></span></td>
                            </tr>
                            <tr>
                              <td>  <a href="../SAG_MANUAL/index.html" target="_blank" class="btn btn-primary btn-lg" role="button">Manual S.I.I.A.F.</a></td>
                              <td>  <a href="http://grupodms.com/prod/00Plantilla/06sb-admin-v2/index.html" target="_blank" class="btn btn-primary btn-lg" role="button">Reportes S.I.I.A.F.</a></td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                            </tr>
                          </table>
                          <p>&nbsp;</p>
                          <p>
                            
                          </p>
                          <p>&nbsp;</p>
     </div>


         </div>



 
</div>
<h4 class="btn-success" >
<p >&nbsp;</p>
<p >&nbsp;</p>
<p >&nbsp;</p>
<p >&nbsp;</p>
</h4>


</body>
</html>
<?php
mysql_free_result($dependencia);
?>
