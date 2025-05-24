<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit;
}

include '../includes/conexion.php';
include '../includes/navbar.php';

$id_usuario = $_SESSION['usuario']['id_inscrito'];

$query = "
    SELECT c.nombre, c.descripcion, c.fecha_inicio, c.fecha_fin
    FROM inscripciones i
    JOIN cursos c ON i.id_curso = c.id_curso
    WHERE i.id_inscrito = ?
";

$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Cursos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-white">
<div class="container py-5">
    <h2 class="text-center mb-4">📋 Mis Cursos Inscritos</h2>
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover table-dark">
            <thead>
                <tr>
                    <th>Curso</th>
                    <th>Descripción</th>
                    <th>Fecha de Inicio</th>
                    <th>Fecha de Fin</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($curso = $resultado->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($curso['nombre']) ?></td>
                    <td><?= htmlspecialchars($curso['descripcion']) ?></td>
                    <td><?= htmlspecialchars($curso['fecha_inicio']) ?></td>
                    <td><?= htmlspecialchars($curso['fecha_fin']) ?></td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
