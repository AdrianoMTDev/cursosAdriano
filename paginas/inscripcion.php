<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}
include '../includes/conexion.php';
include '../includes/navbar.php';

$id_curso = $_GET['id'];
$id_inscrito = $_SESSION['usuario']['id_inscrito'];

// Verificamos si ya está inscrito
$verificacion = $conexion->prepare("SELECT * FROM inscripciones WHERE id_inscrito = ? AND id_curso = ?");
$verificacion->bind_param("ii", $id_inscrito, $id_curso);
$verificacion->execute();
$res = $verificacion->get_result();

if ($res->num_rows > 0) {
    echo "<div class='alert alert-warning text-center'>Ya estás inscrito en este curso.</div>";
} else {
    $inscribir = $conexion->prepare("INSERT INTO inscripciones (id_inscrito, id_curso) VALUES (?, ?)");
    $inscribir->bind_param("ii", $id_inscrito, $id_curso);
    if ($inscribir->execute()) {
        echo "<div class='alert alert-success text-center'>Inscripción exitosa.</div>";
    } else {
        echo "<div class='alert alert-danger text-center'>Ocurrió un error.</div>";
    }
}
?>
<div class="text-center mt-4">
    <a href="cursos.php" class="btn btn-secondary">Volver a Cursos</a>
</div>
