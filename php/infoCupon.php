<?php
session_start(); // Inicia la sesión

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    // Si no ha iniciado sesión, redirige al usuario de vuelta a la página de inicio de sesión
    header("Location: ../index.html");
    exit;
}
if (isset($_GET['data'])) {
    // Obtener y decodificar el parámetro "data" de la URL como un objeto JSON
    $data = json_decode(urldecode($_GET['data']));

} else {
    // Si no se proporcionó el parámetro "data" en la URL se mostrará un error
    echo "No se encontraron datos.";
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
            <h1 class="navbar-brand">Cupón #<?php echo $data->codigo; ?></h1>
            <a href="cerrarSesion.php" class="btn btn-danger">Cerrar Sesión</a>
        </div>
    </nav>
    <div class="container mt-5" id="main">
        <div class="d-flex justify-content-center align-items-center">
            <div class="col-md-4">
                <div class="container bg-light rounded text-white p-3 pb-4 mt-4 mb-4">
                    <form class="p-3" id="cuponForm">
                        <label id="idCupon" style="display: none;"><?php echo $data->id; ?></label>
                        <div class="bg-white text-black rounded text-center row mt-4">
                            <label id="nombreApellido">Cliente: <?php echo $data->nombreCliente . " " . $data->apellidoCliente  ?></label>
                        </div>
                        <div class="bg-white text-black rounded text-center row mt-4">
                            <label id="DUI">DUI: <?php echo $data->duiCliente  ?></label>
                        </div>
                        <div class="bg-white text-black rounded text-center row mt-4">
                            <label id="empresa">Empresa ofertante: <?php echo $data->nombreEmpresa  ?></label>
                        </div>
                        <div class="bg-white text-black rounded text-center row mt-4">
                            <label id="titulo">Titulo de la oferta: <?php echo $data->tituloOferta  ?></label>
                        </div>
                        <div class="bg-success text-light rounded text-center row mt-4">
                            <label id="precioOfertado">Precio ofertado: $<?php echo $data->precioOfertado  ?></label>
                        </div>
                        <div class="bg-danger text-light rounded text-center row mt-4">
                            <label id="precioNormal">Precio normal: $<?php echo $data->precioNormal  ?></label>
                        </div>
                        <div class="column d-flex justify-content-center align-items-center mt-3">
                            <button type="button" id="volver" class="btn btn-light col-md-5 m-2">Volver</button>
                            <button type="button" id="canjear" class="btn btn-success col-md-5 m-2">Canjear</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
        // Manejar el clic en el botón "Volver"
        $("#volver").on("click", function () {
            // Redirigir al usuario a "dependiente.php"
            window.location.href = "dependiente.php";
        });

        // Manejar el clic en el botón "Canjear"
        $("#canjear").on("click", function () {
            // Obtener el valor del input "id"
            var idCupon = $("#idCupon").text();

            // Crear un objeto con los datos a enviar en formato x-www-form-urlencoded
            var data = {
                id: idCupon
            };

            // Realizar la solicitud POST a la API
            $.ajax({
                url: "http://localhost:8080/dependiente/rest/boletos/" + idCupon,
                method: "POST",
                data: $.param(data),
                success: function (response) {
                    // Si se canjea exitosamente se mostrará un mensaje exitoso.
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: 'Boleto canjeado correctamente',
                    }).then((result) => {
                        // Redirigir al usuario a "dependiente.php" después de cerrar el aviso
                        if (result.isConfirmed || result.isDismissed) {
                            window.location.href = 'dependiente.php';
                        }
                    });
                },
                error: function (error) {
                    Swal.fire({
                            icon: 'error',
                            title: 'Ocurrió un error',
                            text: "Se produjo un error, inténtelo nuevamente.", // Si ocurre un error inesperado.
                            })
                },
                dataType: "text" // Especifica que se espera una respuesta de tipo texto
            });
        });
    });
    </script>
</body>
</html>





