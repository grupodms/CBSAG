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

if ((isset($_GET['id_determinantes'])) && ($_GET['id_determinantes'] != "")) {
  $deleteSQL = sprintf("DELETE FROM determinantes WHERE id_determinantes=%s",
                       GetSQLValueString($_GET['id_determinantes'], "int"));

  mysql_select_db($database_SAG, $SAG);
  $Result1 = mysql_query($deleteSQL, $SAG) or die(mysql_error());

  $deleteGoTo = "index2.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

$colname_Determinante = "-1";
if (isset($_GET['id_determinantes'])) {
  $colname_Determinante = $_GET['id_determinantes'];
}
mysql_select_db($database_SAG, $SAG);
$query_Determinante = sprintf("SELECT * FROM determinantes WHERE id_determinantes = %s", GetSQLValueString($colname_Determinante, "int"));
$Determinante = mysql_query($query_Determinante, $SAG) or die(mysql_error());
$row_Determinante = mysql_fetch_assoc($Determinante);
$totalRows_Determinante = mysql_num_rows($Determinante);

$colname_E_Asem = "-1";
if (isset($_GET['idasem'])) {
  $colname_E_Asem = $_GET['idasem'];
}
mysql_select_db($database_Canainpa, $Canainpa);
$query_E_Asem = sprintf("SELECT * FROM areas WHERE id_areas = %s", GetSQLValueString($colname_E_Asem, "int"));
$E_Asem = mysql_query($query_E_Asem, $Canainpa);# or die(mysql_error());
$row_E_Asem = mysql_fetch_assoc($E_Asem);
$totalRows_E_Asem = mysql_num_rows($E_Asem);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
</body>
</html>
<?php
mysql_free_result($Determinante);

mysql_free_result($E_Asem);
?>
