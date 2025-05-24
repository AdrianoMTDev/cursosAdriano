<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

include '../includes/conexion.php';
include '../includes/navbar.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ver Inscripciones</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap y estilos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../css/estilos.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
</head>
<body>

<div class="container my-5">
    <div class="admin-panel">
        <h2><i class="bi bi-people-fill me-2"></i>Inscripciones Registradas</h2>

        <div class="table-responsive mt-4">
            <table class="table table-dark-custom table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Nombre del Estudiante</th>
                        <th>Correo</th>
                        <th>Curso</th>
                        <th>Fecha de Inscripción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT i.nombre, i.correo, c.nombre AS curso, ins.fecha_inscripcion
                            FROM inscripciones ins
                            JOIN inscritos i ON ins.id_inscrito = i.id_inscrito
                            JOIN cursos c ON ins.id_curso = c.id_curso
                            ORDER BY ins.fecha_inscripcion DESC";
                    $resultado = $conexion->query($sql);
                    while ($row = $resultado->fetch_assoc()):
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($row['nombre']) ?></td>
                        <td><?= htmlspecialchars($row['correo']) ?></td>
                        <td><?= htmlspecialchars($row['curso']) ?></td>
                        <td><?= htmlspecialchars($row['fecha_inscripcion']) ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


