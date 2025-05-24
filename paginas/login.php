<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Iniciar Sesión - Sistema de Cursos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Tu estilo personalizado debe ir después de Bootstrap -->
    <link href="../css/estilos.css" rel="stylesheet" />
</head>
<body>
<?php include '../includes/navbar.php'; ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card">
                <h2 class="mb-4 text-white">🔐 Iniciar Sesión</h2>
                <form action="../procesos/procesar_login.php" method="post">
                    <div class="mb-3 text-start">
                        <label for="correo" class="form-label">Correo electrónico</label>
                        <input type="email" class="form-control" id="correo" name="correo" required />
                    </div>
                    <div class="mb-4 text-start">
                        <label for="contrasena" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="contrasena" name="contrasena" required />
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Ingresar</button>
                    </div>
                </form>
                <p class="mt-4 mb-0 text-white-50">¿No tienes una cuenta?
                    <a href="registro.php" class="text-decoration-none text-info">Regístrate aquí</a>.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


