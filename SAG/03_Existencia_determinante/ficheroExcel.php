<?php
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: filename = determinantes.xls");
header("Pragma: no-cache");
header("Expires: 0");
echo $_POST['datos_a_enviar'];
?>
<?php
//  WORD
// header('Content-type: application/vnd.ms-word');
// header("Content-Disposition: attachment; filename=archivo.doc");
// header("Pragma: no-cache");
// header("Expires: 0");
// echo $_POST['datos_a_enviar'];
?>
