CREATE 
VIEW `per_dep_det` AS 
SELECT DISTINCT
cedula_resumen.id_dependencia,
cedula_resumen.id_periodo,
cedula_resumen_partidas.id_determinantes,
determinantes.clave_determinante,
determinantes.cambs,
determinantes.cuenta,
determinantes.cuenta2,
determinantes.descripcion,
"cedula" AS destino,
Sum(cedula_resumen_partidas.cantidad) AS total
FROM
cedula_resumen_partidas
INNER JOIN cedula_resumen ON cedula_resumen_partidas.id_cedula_resumen = cedula_resumen.id_cedula_resumen
INNER JOIN determinantes ON cedula_resumen_partidas.id_determinantes = determinantes.id_determinantes

GROUP BY
cedula_resumen.id_dependencia,
cedula_resumen.id_periodo,
cedula_resumen_partidas.id_determinantes

UNION

SELECT DISTINCT
resguardo.id_dependencia,
resguardo.id_periodo,
resguardo_partidas.id_determinantes,
determinantes.clave_determinante,
determinantes.cambs,
determinantes.cuenta,
determinantes.cuenta2,
determinantes.descripcion,
"resguardo" AS destino,
Sum(resguardo_partidas.unidades) AS total
FROM
resguardo_partidas
INNER JOIN resguardo ON resguardo_partidas.id_resguardo = resguardo.id_resguardo
INNER JOIN determinantes ON resguardo_partidas.id_determinantes = determinantes.id_determinantes
GROUP BY
resguardo.id_dependencia,
resguardo.id_periodo,
resguardo_partidas.id_determinantes 

union

SELECT DISTINCT
vale_entrada.id_dependencia,
vale_entrada.id_periodo,
vale_entrada_partidas.id_determinantes,
determinantes.clave_determinante,
determinantes.cambs,
determinantes.cuenta,
determinantes.cuenta2,
determinantes.descripcion,
"vale_entrada" AS destino,
Sum(vale_entrada_partidas.unidades) AS total
FROM
vale_entrada_partidas
INNER JOIN vale_entrada ON vale_entrada_partidas.id_vale_entrada = vale_entrada.id_vale_entrada
INNER JOIN determinantes ON vale_entrada_partidas.id_determinantes = determinantes.id_determinantes
GROUP BY
vale_entrada.id_dependencia,
vale_entrada.id_periodo,
vale_entrada_partidas.id_determinantes

union

SELECT DISTINCT
vale_salida.id_dependencia,
vale_salida.id_periodo,
vale_salida_partidas.id_determinantes,
determinantes.clave_determinante,
determinantes.cambs,
determinantes.cuenta,
determinantes.cuenta2,
determinantes.descripcion,
"vale_salida" AS destino,
Sum(vale_salida_partidas.unidades) AS total
FROM
vale_salida_partidas
INNER JOIN vale_salida ON vale_salida_partidas.id_vale_salida = vale_salida.id_vale_salida
INNER JOIN determinantes ON vale_salida_partidas.id_determinantes = determinantes.id_determinantes
GROUP BY
vale_salida.id_dependencia,
vale_salida.id_periodo,
vale_salida_partidas.id_determinantes ;