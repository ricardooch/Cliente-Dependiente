<?php
session_start(); // Inicia la sesión

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    // Si no ha iniciado sesión, redirige al usuario de vuelta a la página de inicio de sesión
    header("Location: ../index.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Dependiente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <h1 class="navbar-brand">Bienvenido, <?php echo $_SESSION['usuario']; ?></h1>
            <div>
            <a href="cerrarSesion.php" class="btn btn-danger">Cerrar Sesión</a>
                <a href="updatePass.php" class="btn btn-primary">Cambiar contraseña</a>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <!-- Formulario de cupón -->
            <div class="col-md-4">
                <div class="bg-dark p-4 rounded">
                    <h2 class="text-center text-light">CANJEAR UN CUPÓN</h2>
                    <div class="container bg-light rounded text-dark p-3 pb-4 mt-4 mb-4">
                        <p class="text-center">Ingrese el código del cupón y el DUI del cliente</p>
                        <hr>
                        <form id="cuponForm">
                            <div class="mb-3">
                                <label for="cupon" class="form-label">Código de cupón</label>
                                <input type="text" class="form-control" id="cupon" required>
                            </div>
                            <div class="mb-3">
                                <label for="dui" class="form-label">DUI</label>
                                <input type="text" class="form-control" id="dui" required>
                            </div>
                            <div class="text-center mt-3 mb-2">
                                <button type="submit" class="btn btn-primary" id="canjearCupon">Canjear cupón</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Manejador de envío del formulario
        $("#cuponForm").submit(function (event) {
            event.preventDefault();

            // Obtener los valores de los campos de entrada
            var codigoCupon = $("#cupon").val();
            var dui = $("#dui").val();

            // Crear un objeto con los datos a enviar en formato x-www-form-urlencoded
            var data = {
                codigo: codigoCupon,
                dui: dui
            };

            // Realizar la solicitud POST a la API
            $.ajax({
                url: "http://localhost:8080/dependiente/rest/boletos/consultar/",
                method: "POST",
                data: $.param(data), // Serializar los datos como application/x-www-form-urlencoded
                success: function (response) {
                    // Codificar la respuesta JSON antes de pasarla como parámetro de URL
                    var encodedResponse = encodeURIComponent(JSON.stringify(response));

                    // Redirigir a la página de destino con el parámetro de URL
                    window.location.href = "infoCupon.php?data=" + encodedResponse;
                },
                error: function (error) {
                    console.error(error);
                    Swal.fire('Error', 'Los datos son inválidos, el cupón ya ha sido canjeado o ha finalizado la oferta.', 'error');
                }
            });
        });
    </script>
</body>
</html>