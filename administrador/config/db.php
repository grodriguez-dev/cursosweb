<?php 
 $host = 'localhost';
 $bd = 'sitio';
 $usuario_bd = 'sitio';
 $clave_bd = 'sitio';

 try {
    $conexion = new PDO("mysql:host=$host;dbname=$bd", $usuario_bd, $clave_bd);
 } catch (Exception $ex) {
    echo $ex->getMessage();
 }