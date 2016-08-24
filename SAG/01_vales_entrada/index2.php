<?php require_once('../../Connections/SAG.php'); ?>
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
$adm_Usuario    = $_COOKIE ["usuario_global"]; 
$id_periodo     = $_COOKIE ["id_periodo"]; 
$id_dependencia = $_COOKIE ["id_dependencia"];
$id_agrupador   = $_COOKIE ["id_agrupador"]; 

$id_area = "-1";
if (isset($_POST["id_area"])) 
{$id_area = $_POST["id_area"];}
if (isset($_GET["id_area"])) 
{$id_area = $_GET["id_area"];}

$id_consecutivo = "-1";
if (isset($_POST["id_consecutivo"])) 
{$id_consecutivo = $_POST["id_consecutivo"];}
if (isset($_GET["id_consecutivo"])) 
{$id_consecutivo = $_GET["id_consecutivo"];}

$id_dependencia = "-1";
if (isset($_COOKIE ["id_dependencia"])){
$id_dependencia = $_COOKIE ["id_dependencia"];}


$colname_dependenciao = "-1";
if (isset($_COOKIE ["id_dependencia"])) {
  $colname_dependencia = $_COOKIE ["id_dependencia"];
}


$colname_area = "-1";
if (isset($_COOKIE ["id_dependencia"])) {
  $colname_area = $_COOKIE ["id_dependencia"];
}
mysql_select_db($database_SAG, $SAG);
$query_area = sprintf("SELECT *,CONCAT(area.clave_area,' | ',area.des_area) AS lista FROM area WHERE id_dependencia = %s ORDER BY clave_area ASC", GetSQLValueString($colname_area, "int"));
$area = mysql_query($query_area, $SAG) or die(mysql_error());
$row_area = mysql_fetch_assoc($area);
$totalRows_area = mysql_num_rows($area);

$colname_resguardo = "-1";
if (isset($_COOKIE ["id_dependencia"])) {
  $colname_resguardo = $_COOKIE ["id_dependencia"];
}
mysql_select_db($database_SAG, $SAG);
$query_resguardo = sprintf("SELECT * FROM resguardo
WHERE resguardo.id_dependencia = %s and 
      resguardo.id_area        = %s and 
	  resguardo.id_consecutivo = %s", 
GetSQLValueString($colname_resguardo, "int"),
GetSQLValueString($id_area, "int"),
GetSQLValueString($id_consecutivo, "int"));

$resguardo = mysql_query($query_resguardo, $SAG) or die(mysql_error());
$row_resguardo = mysql_fetch_assoc($resguardo);
$totalRows_resguardo = mysql_num_rows($resguardo);

$colname_resguardo_partidas = "-1";
if (isset($row_resguardo['id_resguardo'])) {
  $colname_resguardo_partidas = $row_resguardo['id_resguardo'];
}
mysql_select_db($database_SAG, $SAG);
$query_resguardo_partidas = sprintf("SELECT * FROM resguardo_partidas WHERE id_resguardo = %s", GetSQLValueString($colname_resguardo_partidas, "int"));
$resguardo_partidas = mysql_query($query_resguardo_partidas, $SAG) or die(mysql_error());
$row_resguardo_partidas = mysql_fetch_assoc($resguardo_partidas);
$totalRows_resguardo_partidas = mysql_num_rows($resguardo_partidas);

$colname_tm = "-1";
if (isset($_POST['id_empleado_tm'])) {
  $colname_tm = $_POST['id_empleado_tm'];
}
mysql_select_db($database_SAG, $SAG);
$query_tm = sprintf("SELECT * FROM empleado WHERE id_dependencia = %s", GetSQLValueString($colname_tm, "int"));
$tm = mysql_query($query_tm, $SAG) or die(mysql_error());
$row_tm = mysql_fetch_assoc($tm);
$totalRows_tm = mysql_num_rows($tm);

$colname_tv = "-1";
if (isset($_POST['id_empleado_tv'])) {
  $colname_tv = $_POST["id_empleado_tv"];
}
mysql_select_db($database_SAG, $SAG);
$query_tv = sprintf("SELECT * FROM empleado WHERE id_dependencia = %s", GetSQLValueString($colname_tv, "int"));
$tv = mysql_query($query_tv, $SAG) or die(mysql_error());
$row_tv = mysql_fetch_assoc($tv);
$totalRows_tv = mysql_num_rows($tv);

mysql_select_db($database_SAG, $SAG);
$query_estado_fisico = "SELECT * FROM estado_fisico ORDER BY clave_estado_fisico ASC";
$estado_fisico = mysql_query($query_estado_fisico, $SAG) or die(mysql_error());
$row_estado_fisico = mysql_fetch_assoc($estado_fisico);
$totalRows_estado_fisico = mysql_num_rows($estado_fisico);

$colname_consecutivo = "-1";
if (isset($_POST["id_area"])) {
  $colname_consecutivo = $_POST["id_area"];
}
mysql_select_db($database_SAG, $SAG);
$query_consecutivo = sprintf("SELECT *, CONCAT(consecutivo.clave_conse,' | ',consecutivo.descripcion_consecutivo) AS lista FROM consecutivo WHERE id_dependencia = %s and id_area = %s ORDER BY clave_conse ASC", 
GetSQLValueString($id_dependencia, "int"),
GetSQLValueString($id_area, "int"));
$consecutivo = mysql_query($query_consecutivo, $SAG) or die(mysql_error());
$row_consecutivo = mysql_fetch_assoc($consecutivo);
$totalRows_consecutivo = mysql_num_rows($consecutivo);
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
<style type="text/css">

.datagrid table { 
border-collapse:collapse; text-align: left; 
width:100%; }
 
.datagrid {font: normal 10px/150% Arial, Helvetica, sans-serif; background: #fff; overflow: hidden; }.datagrid table td, .datagrid table th { padding: 3px 10px; }.datagrid table thead th {background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #36752D), color-stop(1, #275420) );background:-moz-linear-gradient( center top, #36752D 5%, #275420 100% );filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#36752D', endColorstr='#275420');background-color:#36752D; color:#FFFFFF; font-size: 11px; font-weight: bold; border-left: 0px solid #36752D; } .datagrid table thead th:first-child { border: none; }.datagrid table tbody td { color: #275420; border-left: 1px solid #C6FFC2;font-size: 10px;font-weight: normal; }.datagrid table tbody .alt td { background: #DFFFDE; color: #275420; }.datagrid table tbody td:first-child { border-left: none; }.datagrid table tbody tr:last-child td { border-bottom: none; }.datagrid table tfoot td div { border-top: 1px solid #36752D;background: #DFFFDE;} .datagrid table tfoot td { padding: 0; font-size: 11px } .datagrid table tfoot td div{ padding: 2px; }.datagrid table tfoot td ul { margin: 0; padding:0; list-style: none; text-align: right; }.datagrid table tfoot  li { display: inline; }.datagrid table tfoot li a { text-decoration: none; display: inline-block;  padding: 2px 8px; margin: 1px;color: #FFFFFF;border: 1px solid #36752D;-webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px; background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #36752D), color-stop(1, #275420) );background:-moz-linear-gradient( center top, #36752D 5%, #275420 100% );filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#36752D', endColorstr='#275420');background-color:#36752D; }.datagrid table tfoot ul.active, .datagrid table tfoot ul a:hover { text-decoration: none;border-color: #275420; color: #FFFFFF; background: none; background-color:#36752D;}div.dhtmlx_window_active, div.dhx_modal_cover_dv { position: fixed !important; }

</style>
<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;border-color:#bbb;border:none;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 20px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-color:#bbb;color:#594F4F;background-color:#E0FFEB;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 20px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-color:#bbb;color:#493F3F;background-color:#9DE0AD;}
.tg .tg-rmb8{background-color:#C2FFD6;vertical-align:top}
.tg .tg-yw4l{vertical-align:top}
</style>
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
    <td ><h1>Consecutivo Resguardo</h1> </td>
  </tr>
</table> 
  <span class="btn-group-xs">
  </p>
  <?PHP // echo $query_area."<BR />"; ?> 
  <?PHP // echo $query_consecutivo."<BR />"; ?>
  <?PHP //echo $query_resguardo."<BR />"; ?>
  </span>
  <form action="index2.php" method="post">  <table width="863" border="0">
    <tr valign="middle">
      <td>Num Reg </td>
      <td colspan="3"><?PHP echo $row_resguardo['id_resguardo']; ?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="middle">
      <td><input type="submit" 
         class="btn btn-success" 
         value="Siguiente >>" /></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><a href="imprimir.php?id_resguardo=<?PHP echo $row_resguardo['id_resguardo'];?>  ">
        <button type="button" class="btn btn-success"> <span class="glyphicon glyphicon-print"></span>&nbsp;Resguardo </button>
      </a>&nbsp;</td>
      <td><a href="editar.php?id_resguardo=<?PHP echo $row_resguardo['id_resguardo'];?>  ">
      
        <button type="button" class="btn btn-success"> <span class="glyphicon glyphicon-pencil"></span>Editar Resgaurdo </button>
      </a></td>
      </tr>
    <tr>
      <td width="31">A.C.</td>
      <td width="23"><label for="id_dependencia"></label>
        <input name="id_dependencia" type="text" class="bg-success" id="id_dependencia" value="<?PHP echo $id_dependencia; ?>" size="5" maxlength="5" readonly="readonly" /></td>
      <td width="30">&nbsp;</td>
      <td width="42">
      <label for="id_area">Area:</label></td>
      <td width="87"><select name="id_area" id="id_area" onchange="this.form.submit()">
        <option value="0"> </option>
        <?php
		
do {  
?>
        <option value="<?php echo $row_area['id_area']?>"<?php if (!(strcmp($row_area['id_area'],
(isset($id_area) ? $id_area : "" )		 
		
		))) {echo "selected=\"selected\"";} ?>><?php echo $row_area['lista']?></option>
        <?php
} while ($row_area = mysql_fetch_assoc($area));
  $rows = mysql_num_rows($area);
  if($rows > 0) {
      mysql_data_seek($area, 0);
	  $row_area = mysql_fetch_assoc($area);
  }
?>
      </select></td>
      <td width="37">&nbsp;</td>
      <td width="183">
      <?PHP      
if (((isset($_POST["id_area"])) && ($_POST["MM_insert"] == "form1")) OR (isset($_GET["id_area"]))) { 
?>
      <label for="id_consecutivo">Consecutivo:</label>
      <?PHP } ?>
      </td>
      <td width="94">
  <?PHP      
if (((isset($_POST["id_area"])) && ($_POST["MM_insert"] == "form1"))OR (isset($_GET["id_area"])))  { 
?>      
        <select name="id_consecutivo" 
              id="id_consecutivo"
             onchange="submit()" >
        <option value="0"> </option>     
          <?php
do {  
?>
          <option value="<?php echo $row_consecutivo['id_consecutivo']?>"<?php if (!(strcmp($row_consecutivo['id_consecutivo'], 
(isset($id_consecutivo) ? $id_consecutivo : "" )
))) {echo "selected=\"selected\"";} ?>><?php echo $row_consecutivo['lista']?></option>
          <?php
} while ($row_consecutivo = mysql_fetch_assoc($consecutivo));
  $rows = mysql_num_rows($consecutivo);
  if($rows > 0) {
      mysql_data_seek($consecutivo, 0);
	  $row_consecutivo = mysql_fetch_assoc($consecutivo);
  }
?>
  </select>
  <?PHP
}
?></td></tr>
</table>

<?PHP      
if ((
    (isset($_POST["id_area"])) && 
    (isset($_POST["id_consecutivo"])) && 
	($_POST["MM_insert"] == "form1")
	)
	OR
	(
	(isset($_GET["id_area"])) && 
    (isset($_GET["id_consecutivo"])) 
	))
	 
{ 

$colname_tm = "-1";
if (isset($row_resguardo['id_empleado_tm'])) {
  $colname_tm = $row_resguardo['id_empleado_tm'];
}
mysql_select_db($database_SAG, $SAG);
$query_tm = sprintf("SELECT * FROM empleado WHERE id_empleado = %s", GetSQLValueString($colname_tm, "int"));
$tm = mysql_query($query_tm, $SAG) or die(mysql_error());
$row_tm = mysql_fetch_assoc($tm);
$totalRows_tm = mysql_num_rows($tm);

$colname_tv = "-1";
if (isset($row_resguardo['id_empleado_tv'])) {
  $colname_tv = $row_resguardo["id_empleado_tv"];
}
mysql_select_db($database_SAG, $SAG);
$query_tv = sprintf("SELECT * FROM empleado WHERE id_empleado = %s", GetSQLValueString($colname_tv, "int"));
$tv = mysql_query($query_tv, $SAG) or die(mysql_error());
$row_tv = mysql_fetch_assoc($tv);
$totalRows_tv = mysql_num_rows($tv);

if ($totalRows_resguardo == 0 )
   {
?>
<a href="nuevo2.php?id_area=<?PHP echo $id_area;?>&amp;id_consecutivo=<?PHP echo $id_consecutivo;?>">
<button type="button" class="btn btn-warning"> <span class="glyphicon glyphicon-file"></span>Nuevo Resgaurdo </button>
      </a>
<?PHP	   
   }
else
{
?>    
<table class="tg" >        
<tr>
      <th class="tg-yw4l" colspan="3">&nbsp; </th>
      <th class="tg-yw4l"> RFC</th>
      <th class="tg-yw4l">CURP</th>
      <th class="tg-yw4l">MATRICULA</th>
      <th class="tg-yw4l">NOMBRE</th>
      <th class="tg-yw4l">PUESTO</th>
</tr>    
<tr >
      <td class="tg-yw4l" colspan="2" >
      RFC&nbsp;1</td>
      <td class="tg-yw4l" >
        <input name="id_empleado_tm" type="text" value="<?PHP echo $row_resguardo['id_empleado_tm']; ?>" size="6" readonly="readonly" />
      </td>
      <td class="tg-rmb8"><?PHP echo $row_tm['rfc']; ?></td>
      <td class="tg-yw4l"><?PHP echo $row_tm['curp']; ?></td>
      <td class="tg-rmb8"><?PHP echo $row_tm['matricula']; ?></td>
      <td class="tg-yw4l"><?PHP echo $row_tm['nombre']; ?></td>
      <td class="tg-rmb8"><?PHP echo $row_tm['puesto']; ?></td>
      </tr>
    <tr >
      <td colspan="2">RFC 2</td>
      <td>
        
          <input name="id_empleado_tv" type="text" value="<?PHP echo $row_resguardo['id_empleado_tv']; ?>" size="6" readonly="readonly" />
        </td>
      <td class="tg-rmb8"><?PHP echo $row_tv['rfc']; ?></td>
      <td><?PHP echo $row_tv['curp']; ?></td>
      <td class="tg-rmb8"><?PHP echo $row_tv['matricula']; ?></td>
      <td><?PHP echo $row_tv['nombre']; ?></td>
      <td class="tg-rmb8"><?PHP echo $row_tv['puesto']; ?></td>
      </tr>
<?PHP      
}

}
?> 



   
  </table>
<a href="determinantes_nuevo.php?id_resguardo=<?PHP echo $row_resguardo['id_resguardo'];?>
&amp;id_area=<?PHP echo $id_area; ?>
&amp;id_consecutivo=<?PHP echo $id_consecutivo; ?>">
    <button type="button" class="btn btn-success btn-xs"> <span class="glyphicon glyphicon-pencil"></span>Nuevo </button>
      </a>  
<div class="datagrid">
<input type="hidden" name="MM_insert" value="form1"/>
<table>
  <thead>
    <tr>
      <th width="168">N</th>
      <th>Num Resg Partida</th>
      <th>Num Resg</th>
      <th>Determi.</th>
      <th width="204">CAMBS</th>
      <th width="133">Descripción</th>
      <th width="222">Unidades</th>
      <th width="53">Estado</th>
      <th width="232">Num Serie</th>
      <th width="248">Ent Val</th>
      <th width="290">Num Inv</th>
      <th width="261">Observaciones</th>
      <th width="69">Acciones</th>
    </tr>
    <?php 
  $nCont = 1;
  $tUnidades =0;
  $ndiv=2;
  do { ?>
  </thead>
  <tbody>
    <tr
  <?PHP if ($nCont % $ndiv == 0) 
        {echo 'class="alt"';}?> 
   >
      <td rowspan="2"><?PHP echo $nCont; ?></td>
      <td><?php echo $row_resguardo_partidas['id_resguardo_partidas']; ?></td>
      <td><?php echo $row_resguardo_partidas['id_resguardo']; ?></td>
      <td><?php echo $row_resguardo_partidas['clave_determinante']; ?></td>
      <td rowspan="2"><?php echo $row_resguardo_partidas['cambs']; ?></td>
      <td rowspan="2"><p style="font-size:9px"><?php echo $row_resguardo_partidas['descripcion']; ?></p></td>
      <td rowspan="2"><?php echo $row_resguardo_partidas['unidades']; ?>
        <p></p></td>
      <td rowspan="2"><label for="id_estado_fisico"></label>
        <select name="id_estado_fisico" id="id_estado_fisico">
          <?php


do {  
?>
          <option value="<?php echo $row_estado_fisico['id_estado_fisico']?>"<?php if (!(strcmp($row_estado_fisico['id_estado_fisico'], $row_resguardo_partidas['id_estado_fisico']))) {echo "selected=\"selected\"";} ?>><?php echo $row_estado_fisico['clave_estado_fisico']?></option>
          <?php
} while ($row_estado_fisico = mysql_fetch_assoc($estado_fisico));
  $rows = mysql_num_rows($estado_fisico);
  if($rows > 0) {
      mysql_data_seek($estado_fisico, 0);
	  $row_estado_fisico = mysql_fetch_assoc($estado_fisico);
  }
?>
        </select></td>
      <td rowspan="2"><?php echo $row_resguardo_partidas['num_serie']; ?><br />
        <?php echo $row_resguardo_partidas['num_seriea']; ?> <br />
        <?php echo $row_resguardo_partidas['num_serieb']; ?></td>
      <td rowspan="2"><?php echo $row_resguardo_partidas['entrada_vale']; ?></td>
      <td rowspan="2"><?php echo $row_resguardo_partidas['numero_inventario']; ?></td>
      <td rowspan="2"><?php echo $row_resguardo_partidas['observaciones']; ?></td>
      <td rowspan="2">&nbsp;</td>
    </tr>
    <tr
  <?PHP if ($nCont % $ndiv == 0) 
        {echo 'class="alt"';}?> 
   >
      <td width="169"><a href="determinantes_editar.php?id_resguardo=<?PHP echo $row_resguardo_partidas['id_resguardo'];?>&amp;id_resguardo_partidas=<?php echo  $row_resguardo_partidas['id_resguardo_partidas']; ?>
&amp;id_area=<?PHP echo $id_area; ?>
&amp;id_consecutivo=<?PHP echo $id_consecutivo; ?>">
        <button type="button" class="btn btn-success btn-xs"> <span class="glyphicon glyphicon-pencil"></span>Editar </button>
      </a></td>
      <td width="100"><a href="determinantes_traspaso.php?id_resguardo=<?PHP echo $row_resguardo_partidas['id_resguardo'];?>&amp;id_resguardo_partidas= <?php echo $row_resguardo_partidas['id_resguardo_partidas']; ?>   ">
        <button type="button" class="btn btn-success btn-xs"> <span class="glyphicon glyphicon-retweet"></span>&nbsp;Tra</button>
      </a></td>
      <td width="42"><?PHP if ($row_resguardo_partidas['unidades'] > 1) { ?>
        <a href="index2.php?id_resguardo=<?PHP /echo $row_resguardo_partidas['id_resguardo'];?>&amp;id_resguardo_partidas= <?php /echo $row_resguardo_partidas['id_resguardo_partidas']; ?>   "> </a><a href="#">
          <button type="button" class="btn btn-success btn-xs"> <span class="glyphicon glyphicon-retweet"></span>&nbsp;Divi</button>
          </a>
        <?PHP } ?><a href="determinantes_eliminar.php?id_resguardo=<?PHP echo $row_Resguardo['id_resguardo'];?>&amp;id_resguardo_partidas= <?php echo $row_resguardo_partidas['id_resguardo_partidas'];?> "
onclick="return confirmar()">
        <button type="button" class="btn btn-danger btn-xs"> <span class="glyphicon glyphicon-trash"></span> Eliminar </button>
      </a></td>
    </tr>
  </tbody>
  <?php
$nCont += 1;
$tUnidades += $row_resguardo_partidas['unidades'];
 } while ($row_resguardo_partidas = mysql_fetch_assoc($resguardo_partidas)); ?>
  <tfoot>
    <tr>
      <div id="paging">
        <td>&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td>&nbsp;</td>
        <td>Total</td>
        <td><?PHP echo $tUnidades; ?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </div>
    </tr>
  </tfoot>
</table>
  </form>

</div>

</blockquote>
</body>
</html>
<?php
mysql_free_result($area);

mysql_free_result($resguardo);

mysql_free_result($resguardo_partidas);

mysql_free_result($tm);

mysql_free_result($tv);

mysql_free_result($estado_fisico);

mysql_free_result($consecutivo);
?>
