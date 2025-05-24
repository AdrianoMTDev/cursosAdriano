<?php
session_start();
include '../includes/conexion.php';

function mostrarAlerta($tipo, $mensaje, $destino = '../paginas/login.php') {
    $colores = [
        'success' => ['#d4edda', '#155724'],
        'warning' => ['#fff3cd', '#856404'],
        'danger'  => ['#f8d7da', '#721c24']
    ];
    [$fondo, $texto] = $colores[$tipo] ?? ['#d1ecf1', '#0c5460'];

    $iconos = [
        'success' => '✅',
        'warning' => '⚠️',
        'danger'  => '❌'
    ];
    $icono = $iconos[$tipo] ?? '🔔';

    echo <<<HTML
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultado del Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #0e1a2b;
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
            justify-content: center;
            align-items: center;
        }

        .alerta-custom {
            background-color: $fondo;
            color: $texto;
            padding: 2.5rem;
            border-radius: 1rem;
            max-width: 500px;
            width: 100%;
            box-shadow: 0 0 30px rgba(0,0,0,0.5);
            text-align: center;
            animation: aparecer 0.4s ease-in-out;
        }

        @keyframes aparecer {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .emoji {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .btn-volver {
            margin-top: 1rem;
        }
    </style>
</head>
<body>
    <div class="alerta-custom">
        <div class="emoji">$icono</div>
        <h4 class="mb-3 fw-bold">Acceso</h4>
        <p>$mensaje</p>
        <a href="$destino" class="btn btn-dark btn-volver">← Volver</a>
    </div>
</body>
</html>
HTML;
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $correo = trim($_POST['correo']);
    $contrasena = $_POST['contrasena'];

    $sql = "SELECT id_inscrito, nombre, correo, contrasena, rol FROM inscritos WHERE correo = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($usuario = $resultado->fetch_assoc()) {
        if (password_verify($contrasena, $usuario['contrasena'])) {
            $_SESSION['usuario'] = [
                'id_inscrito' => $usuario['id_inscrito'],
                'nombre' => $usuario['nombre'],
                'correo' => $usuario['correo'],
                'rol' => $usuario['rol']
            ];

            // Redirección según el rol
            if ($usuario['rol'] === 'admin') {
                header("Location: ../admin/panel_admin.php");
            } else {
                header("Location: ../paginas/cursos.php");
            }
            exit;
        } else {
            mostrarAlerta('danger', 'Correo o contraseña incorrectos.');
        }
    } else {
        mostrarAlerta('danger', 'Correo o contraseña incorrectos.');
    }

    $stmt->close();
    $conexion->close();
} else {
    mostrarAlerta('danger', 'Acceso no permitido.');
}
?>




