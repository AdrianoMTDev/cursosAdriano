<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

include '../includes/conexion.php';
include '../includes/navbar.php';

// Si viene con ID, cargamos datos para edición
$curso = [
    'nombre' => '',
    'descripcion' => '',
    'fecha_inicio' => '',
    'fecha_fin' => '',
    'cupo_maximo' => ''
];

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conexion->prepare("SELECT * FROM cursos WHERE id_curso = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    if ($resultado->num_rows === 1) {
        $curso = $resultado->fetch_assoc();
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= isset($id) ? 'Editar Curso' : 'Agregar Curso' ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap y estilos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../css/estilos.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
</head>
<body>

<div class="container my-5">
    <div class="card">
        <h2 class="mb-4 text-white">
            <?= isset($id) ? '✏️ Editar Curso' : '➕ Agregar Nuevo Curso' ?>
        </h2>
        <form action="guardar_curso.php" method="post">
            <?php if (isset($id)): ?>
                <input type="hidden" name="id_curso" value="<?= htmlspecialchars($id) ?>">
            <?php endif; ?>
            <div class="mb-3 text-start">
                <label for="nombre" class="form-label">Nombre del Curso</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required value="<?= htmlspecialchars($curso['nombre']) ?>" />
            </div>
            <div class="mb-3 text-start">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required><?= htmlspecialchars($curso['descripcion']) ?></textarea>
            </div>
            <div class="mb-3 text-start">
                <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required value="<?= htmlspecialchars($curso['fecha_inicio']) ?>" />
            </div>
            <div class="mb-3 text-start">
                <label for="fecha_fin" class="form-label">Fecha de Finalización</label>
                <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" required value="<?= htmlspecialchars($curso['fecha_fin']) ?>" />
            </div>
            <div class="mb-4 text-start">
                <label for="cupo_maximo" class="form-label">Cupo Máximo</label>
                <input type="number" class="form-control" id="cupo_maximo" name="cupo_maximo" min="1" required value="<?= htmlspecialchars($curso['cupo_maximo']) ?>" />
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-success">
                    <?= isset($id) ? 'Actualizar Curso' : 'Guardar Curso' ?>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>



