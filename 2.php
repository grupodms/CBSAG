<html>
   <head>
<script type="text/javascript" src="js/cokies.js"></script>

      
   </head>
   
   <body>
<h3>CREAR COOKIES </h3>   
<form name="setCookie">
<table border=0 cellpadding=3 cellspacing=3>
<tr>
  <td>Nombre Cookie :&nbsp;
</td>
  <td><input name=t1 type=text size=20 value="PruebaCookie">
</td></tr>
<tr>
<td>Valor Cookie :&nbsp;
</td><td><input name=t2 type=text size=20 value="ValorCookie">
</td></tr>
<tr>
<td>Tiempo Expira :&nbsp;
</td><td><input name=t3 type=text size=3 value="1"> un día
</td></tr>
<tr><td></td><td><input name=b1 type=button value="Crear Cookie"
onClick="SetCookie('__NowTesting__',rot13(this.form.t1.value,this.form.t3.value));
SetCookie(this.form.t1.value,this.form.t2.value,this.form.t3.value);">
</td></tr></table>
</form>
   <h3>LEER VALORES COOKIES </h3>
<form name="getCookie">
<table border=0 cellpadding=3 cellspacing=3>
<tr>
  <td>Nombre Cookie :</td><td><input name="a1" type="text" size="20" value="usuario_global">
</td></tr>
<tr><td><input name="w1" type="button" value="Leer Valor Cookie"
onClick="this.form.a2.value=ReadCookie(this.form.a1.value)">&nbsp;
</td><td><input name="a2" type="text" size="20" value="">
</td></tr>

<tr>
  <td>Nombre Cookie :</td><td><input name="b1" type="text" size="20" value="id_dependencia">
</td></tr>
<tr><td><input name="w2" type="button" value="Leer Valor Cookie"
onClick="this.form.b2.value=ReadCookie(this.form.b1.value)">&nbsp;
</td><td><input name="b2" type="text" size="20" value="">
</td></tr>

<tr>
  <td>Nombre Cookie :</td><td><input name="c1" type="text" size="20" value="id_periodo">
</td></tr>
<tr><td><input name="w3" type="button" value="Leer Valor Cookie"
onClick="this.form.c2.value=ReadCookie(this.form.c1.value)">&nbsp;
</td><td><input name="c2" type="text" size="20" value="">
</td></tr>

<tr>
  <td>Nombre Cookie :</td><td><input name="d1" type="text" size="20" value="id_agrupador">
</td></tr>
<tr><td><input name="w4" type="button" value="Leer Valor Cookie"
onClick="this.form.d2.value=ReadCookie(this.form.d1.value)">&nbsp;
</td><td><input name="d2" type="text" size="20" value="">
</td></tr>

<tr>
  <td>Nombre Cookie :</td><td><input name="e1" type="text" size="20" value="id_menu">
</td></tr>
<tr><td><input name="w5" type="button" value="Leer Valor Cookie"
onClick="this.form.e2.value=ReadCookie(this.form.e1.value)">&nbsp;
</td><td><input name="e2" type="text" size="20" value="">
</td></tr>



<tr>
  <td>Nombre Cookie :</td><td><input name="g1" type="text" size="25" value="id_todos_dependencias">
</td></tr>
<tr><td><input name="w6" type="button" value="Leer Valor Cookie"
onClick="this.form.g2.value=ReadCookie(this.form.g1.value)">&nbsp;
</td><td><input name="g2" type="text" size="20" value="">
</td></tr>


<tr>
  <td>Nombre Cookie :</td><td><input name="f1" type="text" size="20" value="PruebaCookie">
</td></tr>
<tr><td><input name="w7" type="button" value="Leer Valor Cookie"
onClick="this.form.f2.value=ReadCookie(this.form.f1.value)">&nbsp;
</td><td><input name="f2" type="text" size="20" value="">
</td></tr>

</table>
</form>
<h3>BORRAR COOKIES </h3>   
<form name="borrar">
<table width="186" border=0 cellpadding=3 cellspacing=3>
<tr>
  <td align="center"><input name=b1 type=button value="Borrar Cookie "
onClick="deleteAllCookies()">&nbsp;</td></tr>
</table>
</form>

<h3>TABLAS ONLINE </h3>  
<p><a href="http://tablestyler.com/" target="new">http://tablestyler.com/</a>
</p>
<p><a href="http://www.tablesgenerator.com/" target="new">http://www.tablesgenerator.com/</a></p>
<p>&nbsp;</p>
</body>
</html>