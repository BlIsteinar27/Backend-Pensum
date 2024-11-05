<?php 

require_once('../../config/conexion.php');
require_once('../../util/manejoCore.php');

// Consulta para obtener Niveles 
$sql ="SELECT niveles.id, niveles.nivel FROM `niveles`;";

// Inicializar array para niveles
$niveles = [];

// Verificar la conexión
if ($conn) {
    // Ejecutar la consulta
    if ($result = $conn->query($sql)) {
        // Verificar si hay resultados
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $niveles[] = $row;
            }
        }
        // Liberar resultados
        $result->free();
    } else {
        echo json_encode(['error' => 'Error en la consulta: ' . $conn->error]);
    }
} else {
    echo json_encode(['error' => 'Error en la conexión a la base de datos']);
}

// Devolver resultados como JSON
echo json_encode($niveles, JSON_UNESCAPED_UNICODE);

// Cerrar conexión
$conn->close();


?>