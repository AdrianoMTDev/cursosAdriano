<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}
include '../includes/conexion.php';
include '../includes/navbar.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Cursos Disponibles</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../css/estilos.css" rel="stylesheet" />
    <style>
        .table-container {
            margin-top: 50px;
            background-color: #1c1c1c;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.6);
            color: #fff;
        }
        .table thead th {
            color: #f1c40f;
        }
        .table td, .table th {
            vertical-align: middle;
        }
    </style>
</head>
<body>
<div class="container table-container">
    <h2 class="text-center mb-4">📚 Cursos Disponibles</h2>

    <!-- Botón para ir a mis cursos -->
    <div class="text-end mb-3">
        <a href="mis_cursos.php" class="btn btn-primary">
            📋 Ver mis cursos inscritos
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-dark table-striped table-hover align-middle">
            <thead>
                <tr>
                    <th>Curso</th>
                    <th>Descripción</th>
                    <th>Fechas</th>
                    <th>Cupo</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $resultado = $conexion->query("SELECT * FROM cursos");
            while ($curso = $resultado->fetch_assoc()):
            ?>
                <tr>
                    <td><?= htmlspecialchars($curso['nombre']) ?></td>
                    <td><?= htmlspecialchars($curso['descripcion']) ?></td>
                    <td><?= htmlspecialchars($curso['fecha_inicio']) . ' al ' . htmlspecialchars($curso['fecha_fin']) ?></td>
                    <td><?= htmlspecialchars($curso['cupo_maximo']) ?></td>
                    <td>
                        <form action="../procesos/inscribirse.php" method="post">
                            <input type="hidden" name="id_curso" value="<?= $curso['id_curso'] ?>" />
                            <button type="submit" class="btn btn-success btn-sm">Inscribirse</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>


