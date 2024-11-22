<?php

require_once('../../util/manejoCore.php');
require_once('../../config/conexion.php');

// Obtener el ID del autor desde la URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    // Preparar la consulta SQL para eliminar el autor
    $sql = "DELETE FROM cursos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        die(json_encode(["success" => false, "message" => "Error en la preparación de la consulta: " . $conn->error]));
    }

    // Vincular el parámetro y ejecutar la consulta
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Curso eliminado exitosamente."]);
    } else {
        echo json_encode(["success" => false, "message" => "Ocurrió un error al eliminar el curso: " . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "ID de curso no válido."]);
}

$conn->close();

?>