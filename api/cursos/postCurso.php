<?php 
  

require_once('../../util/manejoCore.php');
require_once('../../config/conexion.php');

$nombre  = $_POST['nombre'];


// Eliminar apóstrofes
$nombre = str_replace("'", "", $nombre);

// Decodificar entidades HTML
$nombre  = html_entity_decode($nombre);



// Preparar y ejecutar la consulta
$sql = "INSERT INTO cursos (nombre) VALUES (?)";
$stmt = $conn->prepare($sql);


if ($stmt === false) {
    die(json_encode(["success" => false, "message" => "Error en la preparación de la consulta: " . $conn->error]));
    }
    
$stmt->bind_param("s",$nombre);
    
if ($stmt->execute()) {
        echo json_encode(["success" => false, "message" => "Nuevo curso agregado exitosamente."]);
    } else {
         error_log("Error al agregar curso: " . $stmt->error);
        echo json_encode(["success" => false, "message" => "Ocurrió un error al agregar curso."]);
     }
           
// Cerrar conexión
$stmt->close();
$conn->close();


?>