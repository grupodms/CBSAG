<?php
session_start();
session_destroy();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SALIR</title>
    <!-- Core CSS - Include with every page -->
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <!-- Add custom CSS here -->
    <link href="css/stylish-portfolio.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- SB Admin CSS - Include with every page -->
    <link href="css/sb-admin.css" rel="stylesheet">

<meta http-equiv="refresh" content="10; url=http://cbsag.net/" />
    
</head>

<body>
<div class="col-md-4 col-md-offset-4">
  <div class="login-panel panel panel-default">
    <div class="panel-heading">
      <div class="alert alert-danger">
        <center>
          <br />
          <h1 class="panel-title"> Has Cerrado Sesion </h1>
        </center>
      </div>
    </div>
    <div class="panel-body">
      <center>
        <p><img src="img/logo_CB_2.png" alt="..." width="213" height="285"  class="media-heading" />

        </p>
        <p>&nbsp;  <?PHP
  ob_start(); 
  header("refresh: 5; url =http://cbsag.net/"); 
  echo 'Espere un momento y será redireccionado...'; 
  ob_end_flush(); 
?>       
        </p>
        <p><a href="../index.html">Pagina Principal </a></p>
      </center>
      <fieldset>
        <div class="form-group"></div>
      </fieldset>
    </div>
  </div>
</div>

</body>
</html>
</body>
</html>


