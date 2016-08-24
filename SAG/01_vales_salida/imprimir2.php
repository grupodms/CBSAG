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

$maxRows_Resguardo2 = 10;
$pageNum_Resguardo2 = 0;
if (isset($_GET['pageNum_Resguardo2'])) {
  $pageNum_Resguardo2 = $_GET['pageNum_Resguardo2'];
}
$startRow_Resguardo2 = $pageNum_Resguardo2 * $maxRows_Resguardo2;

mysql_select_db($database_SAG, $SAG);
$query_Resguardo2 = "SELECT * FROM resguardo_partidas";
$query_limit_Resguardo2 = sprintf("%s LIMIT %d, %d", $query_Resguardo2, $startRow_Resguardo2, $maxRows_Resguardo2);
$Resguardo2 = mysql_query($query_limit_Resguardo2, $SAG) or die(mysql_error());
$row_Resguardo2 = mysql_fetch_assoc($Resguardo2);

if (isset($_GET['totalRows_Resguardo2'])) {
  $totalRows_Resguardo2 = $_GET['totalRows_Resguardo2'];
} else {
  $all_Resguardo2 = mysql_query($query_Resguardo2);
  $totalRows_Resguardo2 = mysql_num_rows($all_Resguardo2);
}
$totalPages_Resguardo2 = ceil($totalRows_Resguardo2/$maxRows_Resguardo2)-1;$maxRows_Resguardo2 = 10;
$pageNum_Resguardo2 = 0;
if (isset($_GET['pageNum_Resguardo2'])) {
  $pageNum_Resguardo2 = $_GET['pageNum_Resguardo2'];
}
$startRow_Resguardo2 = $pageNum_Resguardo2 * $maxRows_Resguardo2;

mysql_select_db($database_SAG, $SAG);
$query_Resguardo2 = "SELECT * FROM resguardo_partidas";
$query_limit_Resguardo2 = sprintf("%s LIMIT %d, %d", $query_Resguardo2, $startRow_Resguardo2, $maxRows_Resguardo2);
$Resguardo2 = mysql_query($query_limit_Resguardo2, $SAG) or die(mysql_error());
$row_Resguardo2 = mysql_fetch_assoc($Resguardo2);

if (isset($_GET['totalRows_Resguardo2'])) {
  $totalRows_Resguardo2 = $_GET['totalRows_Resguardo2'];
} else {
  $all_Resguardo2 = mysql_query($query_Resguardo2);
  $totalRows_Resguardo2 = mysql_num_rows($all_Resguardo2);
}
$totalPages_Resguardo2 = ceil($totalRows_Resguardo2/$maxRows_Resguardo2)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<?php do { ?>
  <p><?php echo $row_Resguardo2['clave_determinante']; ?></p>
  <?php } while ($row_Resguardo2 = mysql_fetch_assoc($Resguardo2)); ?>
</body>
</html>
<?php
mysql_free_result($Resguardo2);
?>
