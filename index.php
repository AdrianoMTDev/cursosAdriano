<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'includes/conexion.php';
include 'includes/navbar.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Inicio - Sistema de Cursos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="css/estilos.css" rel="stylesheet" />
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card">
                    <div class="brand-title">📘 Sistema de Gestión de Cursos</div>
                    <h1 class="mt-3">Bienvenido</h1>
                    <p class="mb-4">Organiza, gestiona y potencia tus aprendizajes con nuestra plataforma profesional.</p>
                    <div class="d-grid gap-3 d-md-flex justify-content-md-center">
                        <a href="paginas/login.php" class="btn btn-primary">Iniciar Sesión</a>
                        <a href="paginas/registro.php" class="btn btn-success">Registrarse</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>




