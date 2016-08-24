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

$aIDRes_resguardo = "-1";
if (isset($_GET['id_resguardo'])) {
  $aIDRes_resguardo = $_GET['id_resguardo'];
}
mysql_select_db($database_SAG, $SAG);
$query_resguardo = sprintf("SELECT resguardo.id_resguardo, 	resguardo.fecha, 	resguardo.id_periodo, 	periodo.semestre, 	periodo.periodo_fecha, 	resguardo.id_dependencia, 	dependencia.clave_dependencia, 	dependencia.depen_descripcion, 	resguardo.id_area, 	area.clave_area, 	area.des_area, 	resguardo.id_consecutivo, 	consecutivo.clave_conse, 	consecutivo.descripcion_consecutivo, 	resguardo.id_empleado_tm, 	empleado_tm.matricula AS tm_matricula, 	empleado_tm.rfc AS tm_rfc, 	empleado_tm.curp AS tm_curp, 	empleado_tm.nombre AS tm_nombre, 	empleado_tm.puesto AS tm_puesto, 	empleado_tm.adcripcion AS tm_adcripcion, 	resguardo.id_empleado_tv, 	empleado_tv.matricula AS tv_matricula, 	empleado_tv.rfc AS tv_rfc, 	empleado_tv.curp AS tv_curp, 	empleado_tv.nombre AS tv_nombre, 	empleado_tv.puesto AS tv_puesto, 	empleado_tv.adcripcion AS tv_adcripcion FROM resguardo INNER JOIN area ON resguardo.id_area = area.id_area INNER JOIN dependencia ON resguardo.id_dependencia = dependencia.id_dependencia INNER JOIN periodo ON resguardo.id_periodo = periodo.id_periodo INNER JOIN consecutivo ON resguardo.id_consecutivo = consecutivo.id_consecutivo INNER JOIN empleado AS empleado_tm ON resguardo.id_empleado_tm = empleado_tm.id_empleado INNER JOIN empleado AS empleado_tv ON resguardo.id_empleado_tv = empleado_tv.id_empleado WHERE resguardo.id_resguardo = %s", GetSQLValueString($aIDRes_resguardo, "int"));
$resguardo = mysql_query($query_resguardo, $SAG) or die(mysql_error());
$row_resguardo = mysql_fetch_assoc($resguardo);
$totalRows_resguardo = mysql_num_rows($resguardo);

$aIDResPar_resguardo_partidas = "-1";
if (isset($_GET['id_resguardo'])) {
  $aIDResPar_resguardo_partidas = $_GET['id_resguardo'];
}
mysql_select_db($database_SAG, $SAG);
$query_resguardo_partidas = sprintf("SELECT resguardo_partidas.id_resguardo_partidas, 	resguardo_partidas.id_resguardo, 	resguardo_partidas.id_determinantes, 	resguardo_partidas.clave_determinante, 	resguardo_partidas.descripcion, 	resguardo_partidas.cambs, 	resguardo_partidas.unidades, 	resguardo_partidas.id_estado_fisico, 	resguardo_partidas.num_serie, resguardo_partidas.num_seriea, resguardo_partidas.num_serieb,	resguardo_partidas.entrada_vale, 	resguardo_partidas.numero_inventario, 	resguardo_partidas.observaciones, 	resguardo_partidas.num_seriea, 	resguardo_partidas.alta, 	resguardo_partidas.baja, 	estado_fisico.clave_estado_fisico FROM resguardo_partidas INNER JOIN estado_fisico ON resguardo_partidas.id_estado_fisico = estado_fisico.id_estado_fisico WHERE id_resguardo =  %s ORDER BY resguardo_partidas.clave_determinante ASC", GetSQLValueString($aIDResPar_resguardo_partidas, "int"));
$resguardo_partidas = mysql_query($query_resguardo_partidas, $SAG) or die(mysql_error());
$row_resguardo_partidas = mysql_fetch_assoc($resguardo_partidas);
$totalRows_resguardo_partidas = mysql_num_rows($resguardo_partidas);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 RTransitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<!--Inicio: resguardo Paltilla -->

<html xmlns:v="urn:schemas-microsoft-com:vml"
xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:w="urn:schemas-microsoft-com:office:word"
xmlns:m="http://schemas.microsoft.com/office/2004/12/omml"
xmlns="http://www.w3.org/TR/REC-html40">

<!--Fin: resguardo Plantilla-->

<head>

<!--Inicio:  Bootstrap -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="../css/bootstrap.min.css" rel="stylesheet">
<title>resguardos</title>
<!--Fin: Script Bootstrap --> 
<!--Inicio: resguardo Paltilla -->
<meta http-equiv=Content-Type content="text/html; charset=windows-1252">
<meta name=ProgId content=Word.Document>
<meta name=Generator content="Microsoft Word 14">
<meta name=Originator content="Microsoft Word 14">
<link rel=File-List href="resguardo_archivos/filelist.xml">
<!--[if gte mso 9]><xml>
 <o:DocumentProperties>
  <o:Author>MAlberto-G</o:Author>
  <o:Template>Normal</o:Template>
  <o:LastAuthor>MAlberto-G</o:LastAuthor>
  <o:Revision>3</o:Revision>
  <o:TotalTime>309</o:TotalTime>
  <o:LastPrinted>2016-04-19T23:58:00Z</o:LastPrinted>
  <o:Created>2016-04-20T00:07:00Z</o:Created>
  <o:LastSaved>2016-04-20T00:09:00Z</o:LastSaved>
  <o:Pages>1</o:Pages>
  <o:Words>252</o:Words>
  <o:Characters>1392</o:Characters>
  <o:Lines>11</o:Lines>
  <o:Paragraphs>3</o:Paragraphs>
  <o:CharactersWithSpaces>1641</o:CharactersWithSpaces>
  <o:Version>14.00</o:Version>
 </o:DocumentProperties>
 <o:OfficeDocumentSettings>
  <o:AllowPNG/>
 </o:OfficeDocumentSettings>
</xml><![endif]-->
<link rel=themeData href="resguardo_archivos/themedata.thmx">
<link rel=colorSchemeMapping href="resguardo_archivos/colorschememapping.xml">
<!--[if gte mso 9]><xml>
 <w:WordDocument>
  <w:Zoom>110</w:Zoom>
  <w:SpellingState>Clean</w:SpellingState>
  <w:GrammarState>Clean</w:GrammarState>
  <w:TrackMoves>false</w:TrackMoves>
  <w:TrackFormatting/>
  <w:HyphenationZone>21</w:HyphenationZone>
  <w:PunctuationKerning/>
  <w:ValidateAgainstSchemas/>
  <w:SaveIfXMLInvalid>false</w:SaveIfXMLInvalid>
  <w:IgnoreMixedContent>false</w:IgnoreMixedContent>
  <w:AlwaysShowPlaceholderText>false</w:AlwaysShowPlaceholderText>
  <w:DoNotPromoteQF/>
  <w:LidThemeOther>ES-MX</w:LidThemeOther>
  <w:LidThemeAsian>X-NONE</w:LidThemeAsian>
  <w:LidThemeComplexScript>X-NONE</w:LidThemeComplexScript>
  <w:Compatibility>
   <w:BreakWrappedTables/>
   <w:SnapToGridInCell/>
   <w:WrapTextWithPunct/>
   <w:UseAsianBreakRules/>
   <w:DontGrowAutofit/>
   <w:SplitPgBreakAndParaMark/>
   <w:EnableOpenTypeKerning/>
   <w:DontFlipMirrorIndents/>
   <w:OverrideTableStyleHps/>
  </w:Compatibility>
  <w:BrowserLevel>MicrosoftInternetExplorer4</w:BrowserLevel>
  <m:mathPr>
   <m:mathFont m:val="Cambria Math"/>
   <m:brkBin m:val="before"/>
   <m:brkBinSub m:val="&#45;-"/>
   <m:smallFrac m:val="off"/>
   <m:dispDef/>
   <m:lMargin m:val="0"/>
   <m:rMargin m:val="0"/>
   <m:defJc m:val="centerGroup"/>
   <m:wrapIndent m:val="1440"/>
   <m:intLim m:val="subSup"/>
   <m:naryLim m:val="undOvr"/>
  </m:mathPr></w:WordDocument>
</xml><![endif]--><!--[if gte mso 9]><xml>
 <w:LatentStyles DefLockedState="false" DefUnhideWhenUsed="true"
  DefSemiHidden="true" DefQFormat="false" DefPriority="99"
  LatentStyleCount="267">
  <w:LsdException Locked="false" Priority="0" SemiHidden="false"
   UnhideWhenUsed="false" QFormat="true" Name="Normal"/>
  <w:LsdException Locked="false" Priority="9" SemiHidden="false"
   UnhideWhenUsed="false" QFormat="true" Name="heading 1"/>
  <w:LsdException Locked="false" Priority="9" QFormat="true" Name="heading 2"/>
  <w:LsdException Locked="false" Priority="9" QFormat="true" Name="heading 3"/>
  <w:LsdException Locked="false" Priority="9" QFormat="true" Name="heading 4"/>
  <w:LsdException Locked="false" Priority="9" QFormat="true" Name="heading 5"/>
  <w:LsdException Locked="false" Priority="9" QFormat="true" Name="heading 6"/>
  <w:LsdException Locked="false" Priority="9" QFormat="true" Name="heading 7"/>
  <w:LsdException Locked="false" Priority="9" QFormat="true" Name="heading 8"/>
  <w:LsdException Locked="false" Priority="9" QFormat="true" Name="heading 9"/>
  <w:LsdException Locked="false" Priority="39" Name="toc 1"/>
  <w:LsdException Locked="false" Priority="39" Name="toc 2"/>
  <w:LsdException Locked="false" Priority="39" Name="toc 3"/>
  <w:LsdException Locked="false" Priority="39" Name="toc 4"/>
  <w:LsdException Locked="false" Priority="39" Name="toc 5"/>
  <w:LsdException Locked="false" Priority="39" Name="toc 6"/>
  <w:LsdException Locked="false" Priority="39" Name="toc 7"/>
  <w:LsdException Locked="false" Priority="39" Name="toc 8"/>
  <w:LsdException Locked="false" Priority="39" Name="toc 9"/>
  <w:LsdException Locked="false" Priority="35" QFormat="true" Name="caption"/>
  <w:LsdException Locked="false" Priority="10" SemiHidden="false"
   UnhideWhenUsed="false" QFormat="true" Name="Title"/>
  <w:LsdException Locked="false" Priority="1" Name="Default Paragraph Font"/>
  <w:LsdException Locked="false" Priority="11" SemiHidden="false"
   UnhideWhenUsed="false" QFormat="true" Name="Subtitle"/>
  <w:LsdException Locked="false" Priority="22" SemiHidden="false"
   UnhideWhenUsed="false" QFormat="true" Name="Strong"/>
  <w:LsdException Locked="false" Priority="20" SemiHidden="false"
   UnhideWhenUsed="false" QFormat="true" Name="Emphasis"/>
  <w:LsdException Locked="false" Priority="59" SemiHidden="false"
   UnhideWhenUsed="false" Name="Table Grid"/>
  <w:LsdException Locked="false" UnhideWhenUsed="false" Name="Placeholder Text"/>
  <w:LsdException Locked="false" Priority="1" SemiHidden="false"
   UnhideWhenUsed="false" QFormat="true" Name="No Spacing"/>
  <w:LsdException Locked="false" Priority="60" SemiHidden="false"
   UnhideWhenUsed="false" Name="Light Shading"/>
  <w:LsdException Locked="false" Priority="61" SemiHidden="false"
   UnhideWhenUsed="false" Name="Light List"/>
  <w:LsdException Locked="false" Priority="62" SemiHidden="false"
   UnhideWhenUsed="false" Name="Light Grid"/>
  <w:LsdException Locked="false" Priority="63" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Shading 1"/>
  <w:LsdException Locked="false" Priority="64" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Shading 2"/>
  <w:LsdException Locked="false" Priority="65" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium List 1"/>
  <w:LsdException Locked="false" Priority="66" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium List 2"/>
  <w:LsdException Locked="false" Priority="67" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Grid 1"/>
  <w:LsdException Locked="false" Priority="68" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Grid 2"/>
  <w:LsdException Locked="false" Priority="69" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Grid 3"/>
  <w:LsdException Locked="false" Priority="70" SemiHidden="false"
   UnhideWhenUsed="false" Name="Dark List"/>
  <w:LsdException Locked="false" Priority="71" SemiHidden="false"
   UnhideWhenUsed="false" Name="Colorful Shading"/>
  <w:LsdException Locked="false" Priority="72" SemiHidden="false"
   UnhideWhenUsed="false" Name="Colorful List"/>
  <w:LsdException Locked="false" Priority="73" SemiHidden="false"
   UnhideWhenUsed="false" Name="Colorful Grid"/>
  <w:LsdException Locked="false" Priority="60" SemiHidden="false"
   UnhideWhenUsed="false" Name="Light Shading Accent 1"/>
  <w:LsdException Locked="false" Priority="61" SemiHidden="false"
   UnhideWhenUsed="false" Name="Light List Accent 1"/>
  <w:LsdException Locked="false" Priority="62" SemiHidden="false"
   UnhideWhenUsed="false" Name="Light Grid Accent 1"/>
  <w:LsdException Locked="false" Priority="63" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Shading 1 Accent 1"/>
  <w:LsdException Locked="false" Priority="64" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Shading 2 Accent 1"/>
  <w:LsdException Locked="false" Priority="65" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium List 1 Accent 1"/>
  <w:LsdException Locked="false" UnhideWhenUsed="false" Name="Revision"/>
  <w:LsdException Locked="false" Priority="34" SemiHidden="false"
   UnhideWhenUsed="false" QFormat="true" Name="List Paragraph"/>
  <w:LsdException Locked="false" Priority="29" SemiHidden="false"
   UnhideWhenUsed="false" QFormat="true" Name="Quote"/>
  <w:LsdException Locked="false" Priority="30" SemiHidden="false"
   UnhideWhenUsed="false" QFormat="true" Name="Intense Quote"/>
  <w:LsdException Locked="false" Priority="66" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium List 2 Accent 1"/>
  <w:LsdException Locked="false" Priority="67" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Grid 1 Accent 1"/>
  <w:LsdException Locked="false" Priority="68" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Grid 2 Accent 1"/>
  <w:LsdException Locked="false" Priority="69" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Grid 3 Accent 1"/>
  <w:LsdException Locked="false" Priority="70" SemiHidden="false"
   UnhideWhenUsed="false" Name="Dark List Accent 1"/>
  <w:LsdException Locked="false" Priority="71" SemiHidden="false"
   UnhideWhenUsed="false" Name="Colorful Shading Accent 1"/>
  <w:LsdException Locked="false" Priority="72" SemiHidden="false"
   UnhideWhenUsed="false" Name="Colorful List Accent 1"/>
  <w:LsdException Locked="false" Priority="73" SemiHidden="false"
   UnhideWhenUsed="false" Name="Colorful Grid Accent 1"/>
  <w:LsdException Locked="false" Priority="60" SemiHidden="false"
   UnhideWhenUsed="false" Name="Light Shading Accent 2"/>
  <w:LsdException Locked="false" Priority="61" SemiHidden="false"
   UnhideWhenUsed="false" Name="Light List Accent 2"/>
  <w:LsdException Locked="false" Priority="62" SemiHidden="false"
   UnhideWhenUsed="false" Name="Light Grid Accent 2"/>
  <w:LsdException Locked="false" Priority="63" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Shading 1 Accent 2"/>
  <w:LsdException Locked="false" Priority="64" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Shading 2 Accent 2"/>
  <w:LsdException Locked="false" Priority="65" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium List 1 Accent 2"/>
  <w:LsdException Locked="false" Priority="66" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium List 2 Accent 2"/>
  <w:LsdException Locked="false" Priority="67" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Grid 1 Accent 2"/>
  <w:LsdException Locked="false" Priority="68" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Grid 2 Accent 2"/>
  <w:LsdException Locked="false" Priority="69" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Grid 3 Accent 2"/>
  <w:LsdException Locked="false" Priority="70" SemiHidden="false"
   UnhideWhenUsed="false" Name="Dark List Accent 2"/>
  <w:LsdException Locked="false" Priority="71" SemiHidden="false"
   UnhideWhenUsed="false" Name="Colorful Shading Accent 2"/>
  <w:LsdException Locked="false" Priority="72" SemiHidden="false"
   UnhideWhenUsed="false" Name="Colorful List Accent 2"/>
  <w:LsdException Locked="false" Priority="73" SemiHidden="false"
   UnhideWhenUsed="false" Name="Colorful Grid Accent 2"/>
  <w:LsdException Locked="false" Priority="60" SemiHidden="false"
   UnhideWhenUsed="false" Name="Light Shading Accent 3"/>
  <w:LsdException Locked="false" Priority="61" SemiHidden="false"
   UnhideWhenUsed="false" Name="Light List Accent 3"/>
  <w:LsdException Locked="false" Priority="62" SemiHidden="false"
   UnhideWhenUsed="false" Name="Light Grid Accent 3"/>
  <w:LsdException Locked="false" Priority="63" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Shading 1 Accent 3"/>
  <w:LsdException Locked="false" Priority="64" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Shading 2 Accent 3"/>
  <w:LsdException Locked="false" Priority="65" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium List 1 Accent 3"/>
  <w:LsdException Locked="false" Priority="66" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium List 2 Accent 3"/>
  <w:LsdException Locked="false" Priority="67" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Grid 1 Accent 3"/>
  <w:LsdException Locked="false" Priority="68" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Grid 2 Accent 3"/>
  <w:LsdException Locked="false" Priority="69" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Grid 3 Accent 3"/>
  <w:LsdException Locked="false" Priority="70" SemiHidden="false"
   UnhideWhenUsed="false" Name="Dark List Accent 3"/>
  <w:LsdException Locked="false" Priority="71" SemiHidden="false"
   UnhideWhenUsed="false" Name="Colorful Shading Accent 3"/>
  <w:LsdException Locked="false" Priority="72" SemiHidden="false"
   UnhideWhenUsed="false" Name="Colorful List Accent 3"/>
  <w:LsdException Locked="false" Priority="73" SemiHidden="false"
   UnhideWhenUsed="false" Name="Colorful Grid Accent 3"/>
  <w:LsdException Locked="false" Priority="60" SemiHidden="false"
   UnhideWhenUsed="false" Name="Light Shading Accent 4"/>
  <w:LsdException Locked="false" Priority="61" SemiHidden="false"
   UnhideWhenUsed="false" Name="Light List Accent 4"/>
  <w:LsdException Locked="false" Priority="62" SemiHidden="false"
   UnhideWhenUsed="false" Name="Light Grid Accent 4"/>
  <w:LsdException Locked="false" Priority="63" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Shading 1 Accent 4"/>
  <w:LsdException Locked="false" Priority="64" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Shading 2 Accent 4"/>
  <w:LsdException Locked="false" Priority="65" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium List 1 Accent 4"/>
  <w:LsdException Locked="false" Priority="66" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium List 2 Accent 4"/>
  <w:LsdException Locked="false" Priority="67" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Grid 1 Accent 4"/>
  <w:LsdException Locked="false" Priority="68" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Grid 2 Accent 4"/>
  <w:LsdException Locked="false" Priority="69" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Grid 3 Accent 4"/>
  <w:LsdException Locked="false" Priority="70" SemiHidden="false"
   UnhideWhenUsed="false" Name="Dark List Accent 4"/>
  <w:LsdException Locked="false" Priority="71" SemiHidden="false"
   UnhideWhenUsed="false" Name="Colorful Shading Accent 4"/>
  <w:LsdException Locked="false" Priority="72" SemiHidden="false"
   UnhideWhenUsed="false" Name="Colorful List Accent 4"/>
  <w:LsdException Locked="false" Priority="73" SemiHidden="false"
   UnhideWhenUsed="false" Name="Colorful Grid Accent 4"/>
  <w:LsdException Locked="false" Priority="60" SemiHidden="false"
   UnhideWhenUsed="false" Name="Light Shading Accent 5"/>
  <w:LsdException Locked="false" Priority="61" SemiHidden="false"
   UnhideWhenUsed="false" Name="Light List Accent 5"/>
  <w:LsdException Locked="false" Priority="62" SemiHidden="false"
   UnhideWhenUsed="false" Name="Light Grid Accent 5"/>
  <w:LsdException Locked="false" Priority="63" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Shading 1 Accent 5"/>
  <w:LsdException Locked="false" Priority="64" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Shading 2 Accent 5"/>
  <w:LsdException Locked="false" Priority="65" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium List 1 Accent 5"/>
  <w:LsdException Locked="false" Priority="66" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium List 2 Accent 5"/>
  <w:LsdException Locked="false" Priority="67" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Grid 1 Accent 5"/>
  <w:LsdException Locked="false" Priority="68" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Grid 2 Accent 5"/>
  <w:LsdException Locked="false" Priority="69" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Grid 3 Accent 5"/>
  <w:LsdException Locked="false" Priority="70" SemiHidden="false"
   UnhideWhenUsed="false" Name="Dark List Accent 5"/>
  <w:LsdException Locked="false" Priority="71" SemiHidden="false"
   UnhideWhenUsed="false" Name="Colorful Shading Accent 5"/>
  <w:LsdException Locked="false" Priority="72" SemiHidden="false"
   UnhideWhenUsed="false" Name="Colorful List Accent 5"/>
  <w:LsdException Locked="false" Priority="73" SemiHidden="false"
   UnhideWhenUsed="false" Name="Colorful Grid Accent 5"/>
  <w:LsdException Locked="false" Priority="60" SemiHidden="false"
   UnhideWhenUsed="false" Name="Light Shading Accent 6"/>
  <w:LsdException Locked="false" Priority="61" SemiHidden="false"
   UnhideWhenUsed="false" Name="Light List Accent 6"/>
  <w:LsdException Locked="false" Priority="62" SemiHidden="false"
   UnhideWhenUsed="false" Name="Light Grid Accent 6"/>
  <w:LsdException Locked="false" Priority="63" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Shading 1 Accent 6"/>
  <w:LsdException Locked="false" Priority="64" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Shading 2 Accent 6"/>
  <w:LsdException Locked="false" Priority="65" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium List 1 Accent 6"/>
  <w:LsdException Locked="false" Priority="66" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium List 2 Accent 6"/>
  <w:LsdException Locked="false" Priority="67" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Grid 1 Accent 6"/>
  <w:LsdException Locked="false" Priority="68" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Grid 2 Accent 6"/>
  <w:LsdException Locked="false" Priority="69" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Grid 3 Accent 6"/>
  <w:LsdException Locked="false" Priority="70" SemiHidden="false"
   UnhideWhenUsed="false" Name="Dark List Accent 6"/>
  <w:LsdException Locked="false" Priority="71" SemiHidden="false"
   UnhideWhenUsed="false" Name="Colorful Shading Accent 6"/>
  <w:LsdException Locked="false" Priority="72" SemiHidden="false"
   UnhideWhenUsed="false" Name="Colorful List Accent 6"/>
  <w:LsdException Locked="false" Priority="73" SemiHidden="false"
   UnhideWhenUsed="false" Name="Colorful Grid Accent 6"/>
  <w:LsdException Locked="false" Priority="19" SemiHidden="false"
   UnhideWhenUsed="false" QFormat="true" Name="Subtle Emphasis"/>
  <w:LsdException Locked="false" Priority="21" SemiHidden="false"
   UnhideWhenUsed="false" QFormat="true" Name="Intense Emphasis"/>
  <w:LsdException Locked="false" Priority="31" SemiHidden="false"
   UnhideWhenUsed="false" QFormat="true" Name="Subtle Reference"/>
  <w:LsdException Locked="false" Priority="32" SemiHidden="false"
   UnhideWhenUsed="false" QFormat="true" Name="Intense Reference"/>
  <w:LsdException Locked="false" Priority="33" SemiHidden="false"
   UnhideWhenUsed="false" QFormat="true" Name="Book Title"/>
  <w:LsdException Locked="false" Priority="37" Name="Bibliography"/>
  <w:LsdException Locked="false" Priority="39" QFormat="true" Name="TOC Heading"/>
 </w:LatentStyles>
</xml><![endif]-->
<style>
<!--
 /* Font Definitions */
 @font-face
	{font-family:Calibri;
	panose-1:2 15 5 2 2 2 4 3 2 4;
	mso-font-charset:0;
	mso-generic-font-family:swiss;
	mso-font-pitch:variable;
	mso-font-signature:-536870145 1073786111 1 0 415 0;}
@font-face
	{font-family:Tahoma;
	panose-1:2 11 6 4 3 5 4 4 2 4;
	mso-font-charset:0;
	mso-generic-font-family:swiss;
	mso-font-pitch:variable;
	mso-font-signature:-520081665 -1073717157 41 0 66047 0;}
 /* Style Definitions */
 p.MsoNormal, li.MsoNormal, div.MsoNormal
	{mso-style-unhide:no;
	mso-style-qformat:yes;
	mso-style-parent:"";
	margin-top:0cm;
	margin-right:0cm;
	margin-bottom:10.0pt;
	margin-left:0cm;
	line-height:115%;
	mso-pagination:widow-orphan;
	font-size:11.0pt;
	font-family:"Calibri","sans-serif";
	mso-ascii-font-family:Calibri;
	mso-ascii-theme-font:minor-latin;
	mso-fareast-font-family:Calibri;
	mso-fareast-theme-font:minor-latin;
	mso-hansi-font-family:Calibri;
	mso-hansi-theme-font:minor-latin;
	mso-bidi-font-family:"Times New Roman";
	mso-bidi-theme-font:minor-bidi;
	mso-fareast-language:EN-US;}
p.MsoAcetate, li.MsoAcetate, div.MsoAcetate
	{mso-style-noshow:yes;
	mso-style-priority:99;
	mso-style-link:"Texto de globo Car";
	margin:0cm;
	margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	font-size:8.0pt;
	font-family:"Tahoma","sans-serif";
	mso-fareast-font-family:Calibri;
	mso-fareast-theme-font:minor-latin;
	mso-fareast-language:EN-US;}
span.TextodegloboCar
	{mso-style-name:"Texto de globo Car";
	mso-style-noshow:yes;
	mso-style-priority:99;
	mso-style-unhide:no;
	mso-style-locked:yes;
	mso-style-link:"Texto de globo";
	mso-ansi-font-size:8.0pt;
	mso-bidi-font-size:8.0pt;
	font-family:"Tahoma","sans-serif";
	mso-ascii-font-family:Tahoma;
	mso-hansi-font-family:Tahoma;
	mso-bidi-font-family:Tahoma;}
.MsoChpDefault
	{mso-style-type:export-only;
	mso-default-props:yes;
	font-size:10.0pt;
	mso-ansi-font-size:10.0pt;
	mso-bidi-font-size:10.0pt;
	font-family:"Calibri","sans-serif";
	mso-ascii-font-family:Calibri;
	mso-ascii-theme-font:minor-latin;
	mso-fareast-font-family:Calibri;
	mso-fareast-theme-font:minor-latin;
	mso-hansi-font-family:Calibri;
	mso-hansi-theme-font:minor-latin;
	mso-bidi-font-family:"Times New Roman";
	mso-bidi-theme-font:minor-bidi;
	mso-fareast-language:EN-US;}
@page WordSection1
	{size:792.0pt 612.0pt;
	mso-page-orientation:landscape;
	margin:21.3pt 36.0pt 36.0pt 36.0pt;
	mso-header-margin:35.4pt;
	mso-footer-margin:35.4pt;
	mso-paper-source:0;}
div.WordSection1
	{page:WordSection1;}
-->
</style>
<style type="text/css" media="print"> 
div.page {  
writing-mode: tb-rl; 
height: 80%; 
margin: 10% 0%; 
} 
</style> 


<!--[if gte mso 10]>
<style>
 /* Style Definitions */
 table.MsoNormalTable
	{mso-style-name:"Tabla normal";
	mso-tstyle-rowband-size:0;
	mso-tstyle-colband-size:0;
	mso-style-noshow:yes;
	mso-style-priority:99;
	mso-style-parent:"";
	mso-padding-alt:0cm 5.4pt 0cm 5.4pt;
	mso-para-margin:0cm;
	mso-para-margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	font-size:10.0pt;
	font-family:"Calibri","sans-serif";
	mso-ascii-font-family:Calibri;
	mso-ascii-theme-font:minor-latin;
	mso-hansi-font-family:Calibri;
	mso-hansi-theme-font:minor-latin;
	mso-fareast-language:EN-US;}
table.MsoTableGrid
	{mso-style-name:"Tabla con cuadrícula";
	mso-tstyle-rowband-size:0;
	mso-tstyle-colband-size:0;
	mso-style-priority:59;
	mso-style-unhide:no;
	border:solid windowtext 1.0pt;
	mso-border-alt:solid windowtext .5pt;
	mso-padding-alt:0cm 5.4pt 0cm 5.4pt;
	mso-border-insideh:.5pt solid windowtext;
	mso-border-insidev:.5pt solid windowtext;
	mso-para-margin:0cm;
	mso-para-margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	font-size:11.0pt;
	font-family:"Calibri","sans-serif";
	mso-ascii-font-family:Calibri;
	mso-ascii-theme-font:minor-latin;
	mso-hansi-font-family:Calibri;
	mso-hansi-theme-font:minor-latin;
	mso-fareast-language:EN-US;}
</style>
<![endif]--><!--[if gte mso 9]><xml>
 <o:shapedefaults v:ext="edit" spidmax="1026"/>
</xml><![endif]--><!--[if gte mso 9]><xml>
 <o:shapelayout v:ext="edit">
  <o:idmap v:ext="edit" data="1"/>
 </o:shapelayout></xml><![endif]-->
 
 
<!--Fin: resguardo Plantilla-->
</head>

<body lang=ES-MX style='tab-interval:35.4pt'>
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


<!--Inicio: Impresion id = muestra --> 
<script type="text/javascript">
function imprSelec(muestra)
{var ficha=document.getElementById(muestra);var ventimp=window.open(' ','popimpr');ventimp.document.write(ficha.innerHTML);ventimp.document.close();ventimp.print();ventimp.close();}
</script>
<!--Fin: Impresion id = muestra --> 


<!--Menu -->

<?PHP $menu = 1; ?>
<?PHP 
if (isset($menu))
   {
	if ($menu==0) 
		{$com = '';}
	else
		{$com = '../';}
	#echo "Menu = ".$com;
   }
   else
   {
	 $com = '';
   }
?>
<?PHP require_once('../barra01.php'); ?>
<!--Menu -->

<!--Inicio:  Bootstrap -->
<blockquote>
  <p>
    <?php
$hoy = date("Y-m-d");
$dia = substr($row_resguardo['periodo_fecha'],8,2);
$mes = substr($row_resguardo['periodo_fecha'],5,2);
$aa  = substr($row_resguardo['periodo_fecha'],0,4);
$num_part = 1;
$sub_hoja = 1;

$pageNum_resguardo_partidas = 1;
$totalPages_resguardo_partidas = 1;

$Pag  = $pageNum_resguardo_partidas+1;
$TPag = $totalPages_resguardo_partidas+1; 
?>


<?PHP 
$num_deter = "";
if (isset($_POST['num_deter'])) {
  $num_deter = $_POST['num_deter']; ;
}


?>
  
  <table width="104%" border="0">
  <tr>
    <form action="imprimir_todo.php?id_resguardo=<?PHP echo $row_resguardo['id_resguardo']; ?>" method="post" name="imp">
    <td width="61%">Número Determinantes por Hoja</td>
    <td width="17%"><input name="num_deter" 
             type="text" 
             id="num_deter" 
             value="<?PHP echo $num_deter; ?>" size="5" /></td>
    <td width="22%"><input type="submit" 
         class="bg bg-success" u
         value="Actualizar" /></td>
    </form>
      <a href="javascript:imprSelec('muestra')"><img src="../img/impresora.png" width="50" height="50" /></a>    </tr>
  </table> 
  </p>
  <p><!--Inicio: resguardo Paltilla --></p></blockquote>
<div id="muestra" class="pager">
  <div class=WordSection1>
    
  <table class=MsoTableGrid border=1 cellspacing=0 cellpadding=0
 style='border-collapse:collapse;border:none;mso-border-alt:solid windowtext .5pt;
 mso-yfti-tbllook:1184;mso-padding-alt:0cm 5.4pt 0cm 5.4pt'>
 <tr style='mso-yfti-irow:0;mso-yfti-firstrow:yes;height:12.9pt'>
  <td colspan="3" rowspan=2 style='width:56.95pt;border:none;padding:0cm 5.4pt 0cm 5.4pt;
  height:12.9pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
  text-align:center;line-height:normal'><span style='font-size:8.0pt'><img src="../img/logo_CB_2.png" width="50" height="50" /><o:p></o:p></span></p>  </td>
  <td colspan=10 rowspan=2 valign=top style='width:586.35pt;
  border:none;border-right:solid windowtext 1.0pt;mso-border-right-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:12.9pt'>
    <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
  text-align:center;line-height:normal'><b style='mso-bidi-font-weight:normal'><span
  style='font-size:12.0pt;mso-bidi-font-size:11.0pt'>Sistema Integral de
      Inventarios de Activo Fijo<o:p></o:p></span></b></p>
    <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
  text-align:center;line-height:normal'><b style='mso-bidi-font-weight:normal'><span
  style='font-size:12.0pt;mso-bidi-font-size:11.0pt'>RESGUARDO DE ACTIVO FIJO</span></b></p>  </td>
  <td colspan=3 valign=top style='width:83.95pt;border:solid windowtext 1.0pt;
  border-left:none;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;background:#D6E3BC;mso-background-themecolor:accent3;
  mso-background-themetint:102;padding:0cm 5.4pt 0cm 5.4pt;height:12.9pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
  text-align:center;line-height:normal'><b style='mso-bidi-font-weight:normal'><span
  style='font-size:9.0pt;mso-bidi-font-size:8.0pt'>resguardo<span
  style='mso-spacerun:yes'>  </span>No.<o:p></o:p></span></b></p>  </td>
  <![if !supportMisalignedRows]>
  <td style='height:12.9pt;border:none' width=8 height=17></td>
  <![endif]>
 </tr>
 <tr style='mso-yfti-irow:1;height:14.25pt'>
  <td colspan=3 style='width:83.95pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:14.25pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
  text-align:center;line-height:normal'><span style='font-size:8.0pt'><?php echo $row_resguardo['clave_conse']; ?>
    <o:p>   </o:p></span></p>  </td>
  <![if !supportMisalignedRows]>
  <td style='height:14.25pt;border:none' width=8 height=19></td>
  <![endif]>
 </tr>
 <tr style='mso-yfti-irow:2;height:11.0pt;mso-row-margin-right:158.8pt'>
  <td colspan=4 rowspan=4 valign=top style='width:209.25pt;
  border-top:none;border-left:none;border-bottom:none;
  border-right:solid windowtext 1.0pt;mso-border-bottom-alt:none;
  mso-border-right-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;
  height:11.0pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'><span style='font-size:6.0pt;mso-bidi-font-size:6.0pt'>
  COLEGIO DE BACHILLERES <br/>
  SECRETARÍA ADMINISTRATIVA <br/>
  DIRECCIÓN&nbsp;DE&nbsp;SERVICIOS&nbsp;ADMINISTRATIVOS&nbsp;Y&nbsp;BIENES <br/>
  SUBDIRECCIÓN DE BIENES Y SERVICIOS<br/>
  DEPARTAMENTO DE ALMACÉN E INVENTARIO
  </span></p>  </td>
  <td width=153 rowspan=2 style='width:76.2pt;border:solid windowtext 1.0pt;
  border-left:none;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;background:#D6E3BC;mso-background-themecolor:accent3;
  mso-background-themetint:102;padding:0cm 5.4pt 0cm 5.4pt;height:11.0pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
  text-align:center;line-height:normal'><b style='mso-bidi-font-weight:normal'><span
  style='font-size:8.0pt'>DEPENDENCIA<o:p></o:p></span></b></p>  </td>
  <td colspan=6 rowspan=2 style='width:283.0pt;border:solid windowtext 1.0pt;
  border-left:none;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:11.0pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'><span style='font-size:7.0pt'>
  <o:p>(<?php echo $row_resguardo['clave_dependencia']; ?>)&nbsp; <?php echo $row_resguardo['depen_descripcion']; ?> </o:p></span></p>  </td>
  <td style='mso-cell-special:placeholder;border:none;padding:0cm 0cm 0cm 0cm' colspan=4><p class='MsoNormal'></td>
  <![if !supportMisalignedRows]>
  <td style='height:11.0pt;border:none' width=2 height=15></td>
  <![endif]>
 </tr>
 <tr style='mso-yfti-irow:3;height:3.5pt'>
   <td width=166 rowspan=3 valign=top style='width:74.85pt;border:none;
  border-right:solid windowtext 1.0pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-left-alt:solid windowtext .5pt;mso-border-right-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:3.5pt'>
     <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:
  justify;line-height:normal'><span style='font-size:7.0pt'><o:p>&nbsp;</o:p></span></p>   </td>
  <td colspan=3 valign=top style='width:83.95pt;border-top:solid windowtext 1.0pt;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;background:#D6E3BC;mso-background-themecolor:
  accent3;mso-background-themetint:102;padding:0cm 5.4pt 0cm 5.4pt;height:3.5pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
  text-align:center;line-height:normal'><b style='mso-bidi-font-weight:normal'><span
  style='font-size:9.0pt;mso-bidi-font-size:7.0pt'>FECHA<o:p></o:p></span></b></p>  </td>
  <![if !supportMisalignedRows]>
  <td style='height:3.5pt;border:none' width=2 height=5></td>
  <![endif]>
 </tr>
 <tr style='mso-yfti-irow:4;height:7.4pt'>
   <td width=153 rowspan=2 style='width:76.2pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;background:#D6E3BC;mso-background-themecolor:
  accent3;mso-background-themetint:102;padding:0cm 5.4pt 0cm 5.4pt;height:13.4pt'>
     <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
  text-align:center;line-height:normal'><b style='mso-bidi-font-weight:normal'><span
  style='font-size:8.0pt'>SUBDEPENDENCIA<o:p></o:p></span></b></p>   </td>
  <td colspan=6 rowspan=2 style='width:283.0pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:7.4pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'><span style='font-size:7.0pt'><o:p>(<?php echo $row_resguardo['clave_area']; ?>)&nbsp; <?php echo $row_resguardo['des_area']; ?>&nbsp;<?php echo $row_resguardo['descripcion_consecutivo']; ?> </o:p></span></p> <BR />
   </td>
  <td width=113 style='width:1.0cm;border-top:none;border-left:none;border-bottom:
  solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;mso-border-top-alt:
  solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:13.4pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
  text-align:center;line-height:normal'><span style='font-size:6.0pt;
  font-family:"Arial","sans-serif"'>DÍA<o:p></o:p></span></p>  </td>
  <td width=113 style='width:1.0cm;border:solid windowtext 1.0pt;border-left:
  none;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:13.4pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
  text-align:center;line-height:normal'><span style='font-size:6.0pt;
  font-family:"Arial","sans-serif"'>MES<o:p></o:p></span></p>  </td>
  <td width=109 style='width:27.25pt;border:solid windowtext 1.0pt;border-left:
  none;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:13.4pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
  text-align:center;line-height:normal'><span style='font-size:6.0pt;
  font-family:"Arial","sans-serif"'>AÑO<o:p></o:p></span></p>  </td>
  <![if !supportMisalignedRows]>
  <td style='height:13.4pt;border:none' width=2 height=18></td>
  <![endif]>
 </tr>
 <tr style='mso-yfti-irow:5;height:5.05pt'>
   <td width=113 valign=top style='width:1.0cm;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:5.05pt'>
     <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
  text-align:center;line-height:normal'><span style='font-size:7.0pt'>
<?php 
$dia = substr($row_resguardo['periodo_fecha'],8,2);
echo $dia; ?>	 <o:p></o:p></span></p>   </td>
  <td width=113 valign=top style='width:1.0cm;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:5.05pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
  text-align:center;line-height:normal'><span style='font-size:7.0pt'><?php echo $mes; ?><o:p></o:p></span></p>  </td>
  <td width=109 valign=top style='width:27.25pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:5.05pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
  text-align:center;line-height:normal'><span style='font-size:7.0pt'><?php echo $aa; ?><o:p></o:p></span></p>  </td>
  <![if !supportMisalignedRows]>
  <td style='height:5.05pt;border:none' width=2 height=20></td>
  <![endif]>
 </tr>
</table>

<table>
 <tr style='mso-yfti-irow:7;height:13.1pt'>

  <td width=9 style='width:2.5pt;
  border-top:solid windowtext 1.0pt;
  border-left:solid windowtext 1.0pt;
  border-bottom:solid windowtext 1.0pt;
  border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;
  mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;
  background:#D6E3BC;
  mso-background-themecolor:accent3;
  mso-background-themetint:102;
  padding:0cm 3.4pt 0cm 3.4pt;
  height:13.1pt'>
  
  <p class=MsoNormal 
     align=center 
     style='margin-bottom:0cm;
     margin-bottom:.0001pt;
     text-align:center;
     line-height:normal'>
<b style='mso-bidi-font-weight:normal'>
<span style="font-size: 6.0pt; 
      font-family:&quot;Arial&quot;, &quot;sans-serif&quot;">Num</span></b></p>  </td>

  <td width=310 style='width:50.85pt;border-top:solid windowtext 1.0pt;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;background:#D6E3BC;mso-background-themecolor:
  accent3;mso-background-themetint:102;padding:0cm 5.4pt 0cm 5.4pt;height:13.1pt'><span class="MsoNormal" style="margin-bottom:0cm;margin-bottom:.0001pt;
  text-align:center;line-height:normal"><b style='mso-bidi-font-weight:normal'><span style="font-size:6.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">DETERMINANTE</span></b></span></td>
  
  
  <td colspan="5" style='
  width:250.85pt;
  border-top:solid windowtext 1.0pt;
  border-left:none;
  border-bottom:solid windowtext 1.0pt;
  border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;
  mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;
  background:#D6E3BC;
  mso-background-themecolor:
  accent3;
  mso-background-themetint:102;
  padding:0cm 5.4pt 0cm 5.4pt;height:13.1pt'>
  <span class="MsoNormal" style="margin-bottom:0cm;margin-bottom:.0001pt;
  text-align:center;line-height:normal"><b style='mso-bidi-font-weight:normal'><span style="font-size:6.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">
    <o:p></o:p>
    </span></b></span>
    <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
  text-align:center;line-height:normal'><b style='mso-bidi-font-weight:normal'><span
  style='font-size:6.0pt;font-family:"Arial","sans-serif"'>BIENES DE ACTIVO
      FIJO<o:p></o:p></span></b></p>  </td>
  <td width=20 style='width:20.65pt;border-top:solid windowtext 1.0pt;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;background:#D6E3BC;mso-background-themecolor:
  accent3;mso-background-themetint:102;padding:0cm 5.4pt 0cm 5.4pt;height:13.1pt'>
    <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
  text-align:center;line-height:normal'><span class="MsoNormal" style="margin-bottom:0cm;margin-bottom:.0001pt;
  text-align:center;line-height:normal"><b style='mso-bidi-font-weight:normal'><span
  style='font-size:6.0pt;font-family:"Arial","sans-serif"'>E_F
            <o:p></o:p>
    </span></b></span></p>  </td>
  <td width=156 style='width:1.0cm;border-top:solid windowtext 1.0pt;border-left:solid windowtext 1.0pt;border-bottom:
  solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;mso-border-top-alt:
  solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;background:#D6E3BC;mso-background-themecolor:accent3;
  mso-background-themetint:102;padding:0cm 5.4pt 0cm 5.4pt;height:13.1pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
  text-align:center;line-height:normal'><b style='mso-bidi-font-weight:normal'><span
  style='font-size:6.0pt;font-family:"Arial","sans-serif"'><o:p></o:p></span></b><span class="MsoNormal" style="margin-bottom:0cm;margin-bottom:.0001pt;
  text-align:center;line-height:normal"><b style='mso-bidi-font-weight:normal'><span
  style='font-size:6.0pt;font-family:"Arial","sans-serif"'>UNIDADES
          <o:p></o:p>
  </span></b></span></p>  </td>
  <td colspan=3 style='width:77.95pt;border-top:solid windowtext 1.0pt;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;background:#D6E3BC;mso-background-themecolor:
  accent3;mso-background-themetint:102;padding:0cm 5.4pt 0cm 5.4pt;height:13.1pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
  text-align:center;line-height:normal'><b style='mso-bidi-font-weight:normal'><span
  style='font-size:6.0pt;font-family:"Arial","sans-serif"'>NUMERO DE SERIE<o:p></o:p></span></b></p>  </td>
  <td colspan=5 style='width:254.05pt;border-top:solid windowtext 1.0pt;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;background:#D6E3BC;mso-background-themecolor:
  accent3;mso-background-themetint:102;padding:0cm 5.4pt 0cm 5.4pt;height:13.1pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
  text-align:center;line-height:normal'><b style='mso-bidi-font-weight:normal'><span
  style='font-size:6.0pt;font-family:"Arial","sans-serif"'>OBSERVACIONES<o:p></o:p></span></b></p>  </td>
  <![if !supportMisalignedRows]>
  <td style='height:13.1pt;border:none' width=1 height=17></td>
  <![endif]>
 </tr>

 <tr style='mso-yfti-irow:8'>
   <td width=96 valign=top style='
  width:2.55pt;
  border-top:none;
  border-left:solid windowtext 1.0pt;
  border-bottom:solid windowtext 1.0pt;
  border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;
  mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt'><p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'><span style='font-size:7.0pt;font-family:"Arial","sans-serif"'> <span class="MsoNormal" style="margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal"><?PHP echo $num_part; ?></span>
     <o:p></o:p>
   </span></p></td>
   <td width=310 valign=top style='width:50.85pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'><span class="MsoNormal" style="margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal"><span style="font-size:7.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">
     <o:p><?php echo $row_resguardo_partidas['clave_determinante']; ?> &nbsp;<br/>
       <?php echo $row_resguardo_partidas['cambs']; ?></o:p>
   </span></span></td>
   <td colspan="5" valign=top style='width:70.85pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'><p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'><span style='font-size:7.0pt;font-family:"Arial","sans-serif"'>
     <o:p><?php echo $row_resguardo_partidas['descripcion']; ?></o:p>
   </span></p></td>
   <td width=20 valign=top style='width:20.65pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'><p class=MsoNormal align=right style='margin-bottom:0cm;margin-bottom:.0001pt;
  text-align:right;line-height:normal'><span style="font-size:7.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;"><?php echo $row_resguardo_partidas['clave_estado_fisico']; ?></span></p></td>
   <td width=156 valign=top style='width:1.0cm;border-top:none;border-left:none;
       border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
       mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
       mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'><p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
  text-align:center;line-height:normal'> <span style='font-size:7.0pt;font-family:"Arial","sans-serif"'> <?php echo $row_resguardo_partidas['unidades']; ?>&nbsp; </span></p></td>
   <td colspan=3 valign=top style='width:77.95pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'><p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'><span style='font-size:6.0pt;font-family:"Arial","sans-serif"'>
     <o:p><?php echo $row_resguardo_partidas['num_serie']; ?><br />
       <?php echo $row_resguardo_partidas['num_seriea']; ?><br />
       <?php echo $row_resguardo_partidas['num_serieb']; ?>&nbsp;</o:p>
   </span></p></td>
   <td colspan=5 valign=top style='width:254.05pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'><p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'><span style='font-size:7.0pt;font-family:"Arial","sans-serif"'>
     <o:p><?php echo $row_resguardo_partidas['observaciones']; ?>&nbsp;</o:p>
   </span></p></td>
   <![if !supportMisalignedRows]>
   <td style='border:none' width=1><p class='MsoNormal'></td>
   <![endif]>
 </tr>

<tr style='mso-yfti-irow:9;height:10.4pt'>
  <td colspan=8 style='width:250.25pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:10.4pt'>
  <p class=MsoNormal align=right style='margin-bottom:0cm;margin-bottom:.0001pt;
  text-align:right;line-height:normal'><span style='font-size:6.0pt;font-family:
  "Arial","sans-serif"'>SUBTOTAL DE UNIDADES POR HOJA<o:p></o:p></span></p>  </td>
  <td width=109 style='width:49.65pt;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:10.4pt'>
  <p class=MsoNormal align=right style='margin-bottom:0cm;margin-bottom:.0001pt;
  text-align:right;line-height:normal'><span style='font-size:6.0pt;font-family:
  "Arial","sans-serif"'><?PHP echo $sub_hoja; ?><o:p></o:p></span></p>  </td>
  <td colspan=2 rowspan=2 style='width:42.5pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:10.4pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'><span style='font-size:6.0pt;font-family:"Arial","sans-serif"'>PAGINAS
  <o:p></o:p></span></p>  </td>
  <td width=113 rowspan=2 style='width:21.25pt;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:10.4pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'><span style='font-size:6.0pt;font-family:"Arial","sans-serif"'>
<?PHP 
$Pag  = $pageNum_resguardo_partidas+1;
$TPag = $totalPages_resguardo_partidas+1; 
?>  
<?PHP echo $Pag; ?>/<?PHP echo $TPag; ?><o:p></o:p></span></p>  </td>
  <td colspan=6 rowspan=2 style='width:296.6pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:10.4pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:
  justify;line-height:normal'><span style='font-size:6.0pt;font-family:"Arial","sans-serif"'>Se
  debe informar al departamento de almacén e inventarios, mediante un oficio o
  memorándum sobre la devolución, transferencia física o baja de cualquier
  activo fijo, que justifique su movimiento. Y será responsabilidad directa del
  resguardatario de los bienes, los movimientos que no se sujeten a esta
  disposición.<o:p></o:p></span></p>  </td>
  <![if !supportMisalignedRows]>
  <td style='height:10.4pt;border:none' width=1 height=14></td>
  <![endif]>
 </tr>
 <tr style='mso-yfti-irow:10;mso-yfti-lastrow:yes;height:6.35pt'>
  <td colspan=8 style='width:250.25pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:6.35pt'>
  <p class=MsoNormal align=right style='margin-bottom:0cm;margin-bottom:.0001pt;
  text-align:right;line-height:normal'><span style='font-size:6.0pt;font-family:
  "Arial","sans-serif"'>TOTAL DE UNIDADES POR CONSECUTIVO<o:p></o:p></span></p>  </td>
  <td width=109 style='width:49.65pt;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:6.35pt'>
  <p class=MsoNormal align=right style='margin-bottom:0cm;margin-bottom:.0001pt;
  text-align:right;line-height:normal'><span style='font-size:6.0pt;font-family:
  "Arial","sans-serif"'>Total de unidades<o:p></o:p></span></p>  </td>
  <![if !supportMisalignedRows]>
  <td style='height:6.35pt;border:none' width=1 height=8></td>
  <![endif]>
 </tr>
</table>

<p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:
justify'><span style='font-size:7.0pt;mso-bidi-font-size:7.0pt;line-height:
115%;font-family:"Arial","sans-serif"'>E_F <span style='mso-tab-count:2'>                        </span><b
style='mso-bidi-font-weight:normal'>(A)</b> En Servicio<span style='mso-tab-count:
1'>     </span> <span style='mso-tab-count:2'>                              </span>(B)
Deteriorado <span style='mso-tab-count:3'>                                   </span>(C)
Inservible<span style='mso-tab-count:3'>                              </span>
(D) Desuso “no se usa, pero en buenas condiciones.
</span></p>

<table class=MsoTableGrid border=1 cellspacing=0 cellpadding=0
 style='border-collapse:collapse;border:none;mso-border-alt:solid windowtext .5pt;
 mso-yfti-tbllook:1184;mso-padding-alt:0cm 5.4pt 0cm 5.4pt'>
 <tr style='mso-yfti-irow:0;mso-yfti-firstrow:yes;height:8.3pt'>
  <td width=971 colspan=7 style='width:728.35pt;border:solid windowtext 1.0pt;
  mso-border-alt:solid windowtext .5pt;background:#D6E3BC;mso-background-themecolor:
  accent3;mso-background-themetint:102;padding:0cm 5.4pt 0cm 5.4pt;height:8.3pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
  text-align:center;line-height:normal'><b style='mso-bidi-font-weight:normal'><span
  style='font-size:7.0pt;font-family:"Arial","sans-serif"'>RESPONSABLE DEL RESGUARDO<o:p></o:p></span></b></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:1;height:14.9pt'>
  <td width=85 style='width:63.8pt;border:solid windowtext 1.0pt;border-top:
  none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:14.9pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
  text-align:center;line-height:normal'><b style='mso-bidi-font-weight:normal'><span
  style='font-size:7.0pt;font-family:"Arial","sans-serif"'>MATRICULA<o:p></o:p></span></b></p>
  </td>
  <td width=76 style='width:2.0cm;border-top:none;border-left:none;border-bottom:
  solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;mso-border-top-alt:
  solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:14.9pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
  text-align:center;line-height:normal'><b style='mso-bidi-font-weight:normal'><span
  style='font-size:7.0pt;font-family:"Arial","sans-serif"'>RFC<o:p></o:p></span></b></p>
  </td>
  <td width=95 style='width:70.9pt;border-top:none;border-left:none;border-bottom:
  solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;mso-border-top-alt:
  solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:14.9pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
  text-align:center;line-height:normal'><b style='mso-bidi-font-weight:normal'><span
  style='font-size:7.0pt;font-family:"Arial","sans-serif"'>CURP<o:p></o:p></span></b></p>
  </td>
  <td width=189 style='width:5.0cm;border-top:none;border-left:none;border-bottom:
  solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;mso-border-top-alt:
  solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:14.9pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
  text-align:center;line-height:normal'><b style='mso-bidi-font-weight:normal'><span
  style='font-size:7.0pt;font-family:"Arial","sans-serif"'>NOMBRE<o:p></o:p></span></b></p>
  </td>
  <td width=151 style='width:4.0cm;border-top:none;border-left:none;border-bottom:
  solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;mso-border-top-alt:
  solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:14.9pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
  text-align:center;line-height:normal'><b style='mso-bidi-font-weight:normal'><span
  style='font-size:7.0pt;font-family:"Arial","sans-serif"'>PUESTO<o:p></o:p></span></b></p>
  </td>
  <td width=123 style='width:92.1pt;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:14.9pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
  text-align:center;line-height:normal'><b style='mso-bidi-font-weight:normal'><span
  style='font-size:7.0pt;font-family:"Arial","sans-serif"'>FECHA<o:p></o:p></span></b></p>
  </td>
  <td width=253 style='width:189.7pt;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:14.9pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
  text-align:center;line-height:normal'><b style='mso-bidi-font-weight:normal'><span
  style='font-size:7.0pt;font-family:"Arial","sans-serif"'>FIRMA<o:p></o:p></span></b></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:2;height:13.0pt'>
  <td width=85 style='width:63.8pt;border:solid windowtext 1.0pt;border-top:
  none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:13.0pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'><span style='font-size:6.0pt;font-family:"Arial","sans-serif"'><o:p><?php echo $row_resguardo['tm_matricula']; ?>
      </o:p>
  </span></p>
  </td>
  <td width=76 style='width:2.0cm;border-top:none;border-left:none;border-bottom:
  solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;mso-border-top-alt:
  solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:13.0pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'><span style='font-size:6.0pt;font-family:"Arial","sans-serif"'>
  <o:p><?php echo $row_resguardo['tm_rfc']; ?></o:p></span></p>
  </td>
  <td width=95 style='width:70.9pt;border-top:none;border-left:none;border-bottom:
  solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;mso-border-top-alt:
  solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:13.0pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'><span style='font-size:6.0pt;font-family:"Arial","sans-serif"'><o:p><?php echo $row_resguardo['tm_curp']; ?>
      </o:p>
  </span></p>
  </td>
  <td width=189 style='width:5.0cm;border-top:none;border-left:none;border-bottom:
  solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;mso-border-top-alt:
  solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:13.0pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'><span style='font-size:6.0pt;font-family:"Arial","sans-serif"'>
  <o:p><?php echo $row_resguardo['tm_nombre']; ?></o:p></span></p>
  </td>
  <td width=151 style='width:4.0cm;border-top:none;border-left:none;border-bottom:
  solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;mso-border-top-alt:
  solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:13.0pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'><span style='font-size:6.0pt;font-family:"Arial","sans-serif"'><o:p><?php echo $row_resguardo['tm_puesto']; ?>
      </o:p>
  </span></p>
  </td>
  <td width=123 style='width:92.1pt;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:13.0pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'><span style='font-size:6.0pt;font-family:"Arial","sans-serif"'><o:p>&nbsp;</o:p></span></p>
  </td>
  <td width=253 style='width:189.7pt;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:13.0pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'><span style='font-size:6.0pt;font-family:"Arial","sans-serif"'><o:p>&nbsp;</o:p></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:3;mso-yfti-lastrow:yes;height:13.95pt'>
  <td width=85 style='width:63.8pt;border:solid windowtext 1.0pt;border-top:
  none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:13.95pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'><span style='font-size:6.0pt;font-family:"Arial","sans-serif"'>
  <o:p><?php echo $row_resguardo['tv_matricula']; ?></o:p></span></p>
  </td>
  <td width=76 style='width:2.0cm;border-top:none;border-left:none;border-bottom:
  solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;mso-border-top-alt:
  solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:13.95pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'><span style='font-size:6.0pt;font-family:"Arial","sans-serif"'>
  <o:p><?php echo $row_resguardo['tv_rfc']; ?></o:p></span></p>
  </td>
  <td width=95 style='width:70.9pt;border-top:none;border-left:none;border-bottom:
  solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;mso-border-top-alt:
  solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:13.95pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'><span style='font-size:6.0pt;font-family:"Arial","sans-serif"'>
  <o:p><?php echo $row_resguardo['tv_curp']; ?></o:p></span></p>
  </td>
  <td width=189 style='width:5.0cm;border-top:none;border-left:none;border-bottom:
  solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;mso-border-top-alt:
  solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:13.95pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'><span style='font-size:6.0pt;font-family:"Arial","sans-serif"'>
  <o:p><?php echo $row_resguardo['tv_nombre']; ?></o:p></span></p>
  </td>
  <td width=151 style='width:4.0cm;border-top:none;border-left:none;border-bottom:
  solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;mso-border-top-alt:
  solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:13.95pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'><span style='font-size:6.0pt;font-family:"Arial","sans-serif"'><o:p><?php echo $row_resguardo['tv_puesto']; ?></o:p></span></p>
    </td>
  <td width=123 style='width:92.1pt;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:13.95pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'><span style='font-size:6.0pt;font-family:"Arial","sans-serif"'><o:p>&nbsp;</o:p></span></p>
  </td>
  <td width=253 style='width:189.7pt;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:13.95pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'><span style='font-size:6.0pt;font-family:"Arial","sans-serif"'><o:p>&nbsp;</o:p></span></p>
  </td>
 </tr>
</table>

<p class=MsoNormal style='margin-right:-2.95pt;line-height:normal'><span
style='font-size:6.0pt;font-family:"Arial","sans-serif"'>La responsabilidad de
los bienes registrados bajo su resguardo estará sujeta a los Art. 114 Fracción I
de la ley Federal de Presupuesto y Responsabilidad Hacendaria; Art. 224 de su
reglamento y Art. 134 Frac. VI de la ley federal de trabajo; Art. 8 Frac. I de
la Ley Federal de Responsabilidades Administrativas de los Servidores Públicos;
Art. 4 de la ley General de Bienes Nacionales y Art. 23 a 28 de la Ley General
de Contabilidad. Normas Generales para el registro y afectación, disposición
final y baja de bienes muebles de la Administración Pública Federal Central.<o:p></o:p></span></p>

</div>






<!--Fin: resguardo Plantilla-->
</div>

</body>
<?pmysql_free_result($resguardo);do);
?>
<?php
mysql_free_result($resguardo);
mysql_free_result($resguardo_partidas);
?>

