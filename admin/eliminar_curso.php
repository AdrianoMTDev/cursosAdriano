<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

include '../includes/conexion.php';

$id_curso = $_GET['id'] ?? null;

if ($id_curso) {
    $sql = "DELETE FROM cursos WHERE id_curso = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id_curso);
    $stmt->execute();
}

header("Location: panel_admin.php");
exit;
?>

