<?php
session_start(); // Inicia la sesión

// Recupera los datos de la URL
$datosCodificados = $_GET['datos'];

// Decodifica los datos codificados
$datosJSON = urldecode($datosCodificados);

// Convierte la cadena JSON en un objeto PHP
$datos = json_decode($datosJSON);

// Accede a las variables email y nombreApellido del objeto
$correo = $datos->email;
$nombreApellido = $datos->nombreApellido;

// Establece las variables de sesión
$_SESSION['usuario'] = $nombreApellido;
$_SESSION['correo'] = $correo;

header("Location: dependiente.php");
exit;
?>