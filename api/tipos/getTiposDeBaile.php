<?php 

require_once('../../util/manejoCore.php');
require_once('../../config/conexion.php');

// Consulta para obtener Tipos de baile 
$sql ="SELECT * FROM `tipo_baile`";

// Inicializar array para Tipos de baile
$tipos = [];

// Verificar la conexión
if ($conn) {
    // Ejecutar la consulta
    if ($result = $conn->query($sql)) {
        // Verificar si hay resultados
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $tipos[] = $row;
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
echo json_encode($tipos, JSON_UNESCAPED_UNICODE);

// Cerrar conexión
$conn->close();

?>