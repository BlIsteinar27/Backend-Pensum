<?php

require_once('../../util/manejocore.php');
require_once('../../config/conexion.php');

// Obtener el ID del paso desde la URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Obtener los datos JSON de la solicitud
$data = json_decode(file_get_contents("php://input"));

// Validar los datos
if (isset($data->idcurso) && isset($data->idnivel) && isset($data->idtipo) && isset($data->paso)) {
    $idcurso = intval($data->idcurso); // Asegurarse que sea un entero
    $idnivel = intval($data->idnivel); // Asegurarse que sea un entero
    $idtipo = intval($data->idtipo); // Asegurarse que sea un entero
    $paso = $data->paso; // Asumiendo que paso puede ser una cadena

    // Preparar la consulta SQL para actualizar el paso
    $sql = "UPDATE pasos SET idcurso = ?, idnivel = ?, idtipo = ?, paso = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        die(json_encode(["success" => false, "message" => "Error en la preparación de la consulta: " . $conn->error]));
    }

    // Asegúrate de que el número de parámetros coincida con los placeholders
    $stmt->bind_param("iiisi", $idcurso, $idnivel, $idtipo, $paso, $id);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Paso actualizado exitosamente."]);
    } else {
        echo json_encode(["success" => false, "message" => "Ocurrió un error al actualizar el paso: " . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Datos incompletos."]);
}

$conn->close();
?>