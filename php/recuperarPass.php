<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Recuperar contraseña</div>
                    <div class="card-body">
                        <p class="text-center">Ingresa el email de tu cuenta para recibir una nueva contraseña</p>
                        <form id="login-form">
                            <div class="mb-3">
                                <label for="email" class="form-label">Correo electrónico</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Enviar email</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById("login-form").addEventListener("submit", function(event) {
            event.preventDefault();
    
            const email = document.getElementById("email").value;
    
            // Crea una cadena de datos en formato x-www-form-urlencoded
            const formData = `correo=${email}`;
    
            // Realiza una solicitud HTTP POST a la API
            fetch("http://localhost:8080/dependiente/rest/usuarios/newPass/", {
                method: "POST",
                body: formData, 
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                }
            })
            .then(response => {
                if (response.status === 200) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: 'Se envío una nueva contraseña a su dirección de correo electrónico',
                    }).then((result) => {
                        // Redirigir al usuario a "dependiente.php" después de cerrar el aviso
                        if (result.isConfirmed || result.isDismissed) {
                            window.location.href = '../index.html';
                        }
                    });
                } else {
                    // Si la autenticación falla o si hay algún otro error
                    Swal.fire({
                            icon: 'error',
                            title: 'Ocurrió un error',
                            text: "La dirección de email no pertenece a ninguna cuenta.", 
                            });
                }
            })
            .catch(error => {
                Swal.fire({
                            icon: 'error',
                            title: 'Ocurrió un error',
                            text: "Se produjo un error, inténtelo nuevamente.", // Si ocurre un error inesperado.
                            })
            });
        });
    </script>
</body>
</html>




