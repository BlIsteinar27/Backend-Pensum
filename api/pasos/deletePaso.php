<?php

require_once('../../util/manejoCore.php');
require_once('../../config/conexion.php');

// Obtener el ID del paso a eliminar
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Verificar que el ID sea válido
if ($id <= 0) {
    die(json_encode(["success" => false, "message" => "ID inválido."]));
}

// Preparar y ejecutar la consulta
$sql = "DELETE FROM pasos WHERE id = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die(json_encode(["success" => false, "message" => "Error en la preparación de la consulta: " . $conn->error]));
}

$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(["success" => true, "message" => "Paso eliminado del pensum exitosamente."]);
    } else {
        echo json_encode(["success" => false, "message" => "No se encontró ningún paso con ese ID."]);
    }
} else {
    error_log("Error al eliminar paso: " . $stmt->error);
    echo json_encode(["success" => false, "message" => "Ocurrió un error al eliminar el paso."]);
}

// Cerrar conexión
$stmt->close();
$conn->close();

?>