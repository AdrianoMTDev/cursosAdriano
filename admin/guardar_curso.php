<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

include '../includes/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];
    $cupo_maximo = intval($_POST['cupo_maximo']);

    if (empty($nombre) || empty($descripcion) || empty($fecha_inicio) || empty($fecha_fin) || $cupo_maximo < 1) {
        header("Location: panel_admin.php?mensaje=campos_incompletos");
        exit;
    }

    if (isset($_POST['id_curso']) && is_numeric($_POST['id_curso'])) {
        $id = intval($_POST['id_curso']);
        $sql = "UPDATE cursos SET nombre = ?, descripcion = ?, fecha_inicio = ?, fecha_fin = ?, cupo_maximo = ? WHERE id_curso = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ssssii", $nombre, $descripcion, $fecha_inicio, $fecha_fin, $cupo_maximo, $id);
    } else {
        $sql = "INSERT INTO cursos (nombre, descripcion, fecha_inicio, fecha_fin, cupo_maximo) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ssssi", $nombre, $descripcion, $fecha_inicio, $fecha_fin, $cupo_maximo);
    }

    if ($stmt->execute()) {
        header("Location: panel_admin.php?mensaje=guardado");
        exit;
    } else {
        header("Location: panel_admin.php?mensaje=error&detalle=" . urlencode($stmt->error));
        exit;
    }

    $stmt->close();
    $conexion->close();
} else {
    header("Location: panel_admin.php?mensaje=no_autorizado");
    exit;
}

