<?php
session_start();
include '../includes/conexion.php';

function mostrarAlerta($tipo, $mensaje, $destino = '../paginas/registro.php') {
    // Colores personalizados
    $colores = [
        'success' => ['#d4edda', '#155724'],
        'warning' => ['#fff3cd', '#856404'],
        'danger'  => ['#f8d7da', '#721c24']
    ];
    [$fondo, $texto] = $colores[$tipo] ?? ['#d1ecf1', '#0c5460'];

    // Ícono según tipo
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
    <title>Resultado del Registro</title>
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
            animation: aparecer 0.5s ease-in-out;
        }

        @keyframes aparecer {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .btn-volver {
            margin-top: 1rem;
        }

        .emoji {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="alerta-custom">
        <div class="emoji">$icono</div>
        <h4 class="mb-3 fw-bold">Aviso</h4>
        <p>$mensaje</p>
        <a href="$destino" class="btn btn-dark btn-volver">← Volver</a>
    </div>
</body>
</html>
HTML;
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = trim($_POST['nombre']);
    $correo = trim($_POST['correo']);
    $contrasena = $_POST['contrasena'];
    $confirmar_contrasena = $_POST['confirmar_contrasena'];
    $telefono = trim($_POST['telefono']);
    $direccion = trim($_POST['direccion']);
    $ciudad = trim($_POST['ciudad']);
    $pais = trim($_POST['pais']);
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $genero = $_POST['genero'];
    $rol = 'usuario';

    if (empty($nombre) || empty($correo) || empty($contrasena)) {
        mostrarAlerta('warning', 'Todos los campos obligatorios deben ser completados.');
    }

    if ($contrasena !== $confirmar_contrasena) {
        mostrarAlerta('danger', 'Las contraseñas no coinciden.');
    }

    $regex = '/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
    if (!preg_match($regex, $contrasena)) {
        mostrarAlerta('danger', 'La contraseña debe tener al menos 8 caracteres, una letra mayúscula, un número y un carácter especial.');
    }

    $verificar = $conexion->prepare("SELECT id_inscrito FROM inscritos WHERE correo = ?");
    $verificar->bind_param("s", $correo);
    $verificar->execute();
    $verificar->store_result();

    if ($verificar->num_rows > 0) {
        mostrarAlerta('warning', 'Este correo ya está registrado.', '../paginas/login.php');
    }
    $verificar->close();

    $contrasena_segura = password_hash($contrasena, PASSWORD_ARGON2ID);

    $sql = "INSERT INTO inscritos (nombre, correo, contrasena, telefono, direccion, ciudad, pais, fecha_nacimiento, genero, rol)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssssssssss", $nombre, $correo, $contrasena_segura, $telefono, $direccion, $ciudad, $pais, $fecha_nacimiento, $genero, $rol);

    if ($stmt->execute()) {
        mostrarAlerta('success', 'Registro exitoso. Ahora puedes iniciar sesión.', '../paginas/login.php');
    } else {
        mostrarAlerta('danger', 'Error al registrar: ' . $stmt->error);
    }

    $stmt->close();
    $conexion->close();
} else {
    mostrarAlerta('danger', 'Acceso no permitido.');
}
?>








