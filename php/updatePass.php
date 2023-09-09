<?php
session_start(); // Inicia la sesión

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    // Si no ha iniciado sesión, redirige al usuario de vuelta a la página de inicio de sesión
    header("Location: ../index.html");
    exit;
}
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Dependiente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <h1 class="navbar-brand">Bienvenido, <?php echo $_SESSION['usuario']; ?> - Cambiar contraseña</h1>
            <div>
                <a href="cerrarSesion.php" class="btn btn-danger">Cerrar Sesión</a>
                <a href="dependiente.php" class="btn btn-primary">Volver</a>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <!-- Formulario de cupón -->
            <div class="col-md-4">
                <div class="bg-dark p-4 rounded">
                    <h2 class="text-center text-light">CAMBIAR CONTRASEÑA</h2>
                    <div class="container bg-light rounded text-dark p-3 pb-4 mt-4 mb-4">
                        <p class="text-center">Ingrese los datos requeridos</p>
                        <hr>
                        <form id="cuponForm">
                            <div class="mb-3">
                                <label for="cupon" class="form-label">Contraseña actual</label>
                                <input type="password" class="form-control" id="actual" required>
                            </div>
                            <div class="mb-3">
                                <label for="cupon" class="form-label">Nueva contraseña</label>
                                <input type="password" class="form-control" id="nueva" required>
                            </div>
                            <div class="mb-3">
                                <label for="cupon" class="form-label">Repetir nueva contraseña</label>
                                <input type="password" class="form-control" id="repetirNueva" required>
                            </div>
                            <div class="text-center mt-3 mb-2">
                                <button type="submit" class="btn btn-primary" id="canjearCupon">Cambiar contraseña</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Datos del cupón -->
            <div class="col-md-8">
                <div id="respuesta"></div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            $("#canjearCupon").click(function (event) {
                event.preventDefault(); // Evita la recarga de la página por defecto

                // Obtener los valores de los campos
                var actualPassword = $("#actual").val();
                var nuevaPassword = $("#nueva").val();
                var repetirNuevaPassword = $("#repetirNueva").val();

                // Realizar la validación
                if (nuevaPassword !== repetirNuevaPassword) {
                    Swal.fire('Error', 'Las nuevas contraseñas no son iguales.', 'error');
                } else {
                    // Si las contraseñas coinciden, enviar la solicitud POST
                    // Crear un objeto con los datos a enviar en formato x-www-form-urlencoded
                    var data = new URLSearchParams();
                    data.append("anterior", actualPassword);
                    data.append("correo", '<?php echo $_SESSION['correo']; ?>');
                    data.append("password", nuevaPassword);

                    // Realizar la solicitud POST con el encabezado adecuado
                    fetch("http://localhost:8080/dependiente/rest/usuarios/updatePass", {
                        method: "POST",
                        body: data,
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded"
                        }
                    })
                    .then(response => {
                        if (response.status === 200) {
                            // La solicitud fue exitosa
                            Swal.fire({
                                icon: 'success',
                                title: 'Éxito',
                                text: "¡La contraseña se cambió exitosamente!",
                            }).then(() => {
                                // Redirige a dependiente.php
                                window.location.href = 'dependiente.php';
                            });
                        } else if (response.status === 401) {
                            // Error de contraseña incorrecta
                            Swal.fire({
                            icon: 'error',
                            title: 'Ocurrió un error',
                            text: "La contraseña actual ingresada no es correcta", // Muestra el mensaje de éxito o cualquier otra respuesta del servidor
                            })
                        } else {
                            Swal.fire({
                            icon: 'error',
                            title: 'Ocurrió un error',
                            text: "Se produjo un error, inténtelo nuevamente.", // Muestra el mensaje de éxito o cualquier otra respuesta del servidor
                            })
                        }
                    })
                }
            });
        });
    </script>
</body>