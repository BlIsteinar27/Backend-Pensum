<?php 
  
// Conexión a la base de datos
require_once('../../util/manejoCore.php');
require_once('../../config/conexion.php');

$idcurso    = htmlspecialchars(trim($_POST['idcurso']));
$idnivel   = htmlspecialchars(trim($_POST['idnivel']));
$idtipo  = htmlspecialchars(trim($_POST['idtipo']));
$paso     = htmlspecialchars(trim($_POST['paso']));

// Eliminar apóstrofes
$paso     = str_replace("'", "", $paso);

// Decodificar entidades HTML
$idcurso    = html_entity_decode($idcurso);
$idnivel   = html_entity_decode($idnivel);
$idtipo  = html_entity_decode($idtipo);
$paso     = html_entity_decode($paso);

// Preparar y ejecutar la consulta
$sql = "INSERT INTO pasos (idcurso, idnivel, idtipo, paso) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die(json_encode(["success" => false, "message" => "Error en la preparación de la consulta: " . $conn->error]));
}

$stmt->bind_param("iiis", $idcurso, $idnivel, $idtipo, $paso);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Nuevo paso agregado exitosamente."]);
} else {
    error_log("Error al agregar paso: " . $stmt->error);
    echo json_encode(["success" => false, "message" => "Ocurrió un error al agregar el paso."]);
}

// Cerrar conexión
$stmt->close();
$conn->close();


?>