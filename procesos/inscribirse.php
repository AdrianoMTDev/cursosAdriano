<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit;
}

include '../includes/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_curso'])) {
    $id_curso = intval($_POST['id_curso']);
    $id_usuario = $_SESSION['usuario']['id_inscrito'];

    // Verificar si ya está inscrito
    $verificar = $conexion->prepare("SELECT * FROM inscripciones WHERE id_inscrito = ? AND id_curso = ?");
    $verificar->bind_param("ii", $id_usuario, $id_curso);
    $verificar->execute();
    $resultado = $verificar->get_result();

    if ($resultado->num_rows > 0) {
        $mensaje = "⚠️ Ya estás inscrito en este curso.";
        $clase = "warning";
    } else {
        // Verificar cupo disponible
        $ver_cupo = $conexion->prepare("SELECT cupo_maximo FROM cursos WHERE id_curso = ?");
        $ver_cupo->bind_param("i", $id_curso);
        $ver_cupo->execute();
        $res_cupo = $ver_cupo->get_result();
        $curso = $res_cupo->fetch_assoc();

        if ($curso['cupo_maximo'] > 0) {
            // Insertar inscripción
            $insertar = $conexion->prepare("INSERT INTO inscripciones (id_inscrito, id_curso) VALUES (?, ?)");
            $insertar->bind_param("ii", $id_usuario, $id_curso);

            if ($insertar->execute()) {
                // Disminuir el cupo
                $actualizar = $conexion->prepare("UPDATE cursos SET cupo_maximo = cupo_maximo - 1 WHERE id_curso = ?");
                $actualizar->bind_param("i", $id_curso);
                $actualizar->execute();

                $mensaje = "✅ ¡Inscripción exitosa!";
                $clase = "success";
            } else {
                $mensaje = "❌ Error al inscribirse.";
                $clase = "danger";
            }
        } else {
            $mensaje = "🚫 No hay cupos disponibles.";
            $clase = "danger";
        }
    }
} else {
    $mensaje = "⚠️ Solicitud inválida.";
    $clase = "danger";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inscripción a Curso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-white">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="alert alert-<?= $clase ?> bg-light text-dark text-center p-4 rounded shadow-lg">
                <h4><?= $mensaje ?></h4>
                <a href="../paginas/cursos.php" class="btn btn-outline-dark mt-3">← Volver a los cursos</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>



