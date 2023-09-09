<?php
session_start();

// Destruye todas las variables de sesión y la sesión en sí
session_unset();
session_destroy();

// Redirecciona al usuario a la página de inicio de sesión
header("Location: ../index.html");
exit();
?>