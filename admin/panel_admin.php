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
    <meta charset="UTF-8" />
    <title>Panel de Administración</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Bootstrap y estilos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../css/estilos.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
</head>
<body>

<div class="container my-5">
    <div class="admin-panel">
        <h2><i class="bi bi-gear-fill me-2"></i>Panel de Administración</h2>

        <!-- Alertas de estado -->
        <?php if (isset($_GET['mensaje'])): ?>
            <?php if ($_GET['mensaje'] === 'guardado'): ?>
                <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>Curso guardado correctamente.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            <?php elseif ($_GET['mensaje'] === 'campos_incompletos'): ?>
                <div class="alert alert-warning alert-dismissible fade show mt-4" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>Completa todos los campos del formulario.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            <?php elseif ($_GET['mensaje'] === 'error'): ?>
                <div class="alert alert-danger alert-dismissible fade show mt-4" role="alert">
                    <i class="bi bi-x-circle-fill me-2"></i>Ocurrió un error al guardar el curso.
                    <?php if (isset($_GET['detalle'])): ?>
                        <div class="mt-1"><small><?= htmlspecialchars($_GET['detalle']) ?></small></div>
                    <?php endif; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            <?php elseif ($_GET['mensaje'] === 'no_autorizado'): ?>
                <div class="alert alert-danger alert-dismissible fade show mt-4" role="alert">
                    <i class="bi bi-shield-exclamation me-2"></i>Acceso no autorizado.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <!-- Botones principales -->
        <div class="d-flex justify-content-between align-items-center mb-4 mt-3">
            <div>
                <a href="ver_inscripciones.php" class="btn btn-outline-info me-2">
                    <i class="bi bi-card-list"></i> Ver Inscripciones
                </a>
                <a href="editar_curso.php" class="btn btn-outline-success">
                    <i class="bi bi-plus-square"></i> Agregar Curso
                </a>
            </div>
        </div>

        <!-- Tabla de cursos -->
        <div class="table-responsive">
            <table class="table table-dark-custom table-bordered table-hover rounded">
                <thead class="table-dark">
                    <tr>
                        <th>Curso</th>
                        <th>Descripción</th>
                        <th>Fechas</th>
                        <th>Cupo</th>
                        <th>Acciones</th>
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
                        <td><?= htmlspecialchars($curso['fecha_inicio']) ?> al <?= htmlspecialchars($curso['fecha_fin']) ?></td>
                        <td><?= htmlspecialchars($curso['cupo_maximo']) ?></td>
                        <td>
                            <a href="editar_curso.php?id=<?= $curso['id_curso'] ?>" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil-square"></i> Editar
                            </a>
                            <a href="eliminar_curso.php?id=<?= $curso['id_curso'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este curso?')">
                                <i class="bi bi-trash3-fill"></i> Eliminar
                            </a>
                        </td>
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


