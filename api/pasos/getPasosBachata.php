<?php 

require_once("../../util/manejoCore.php");
require_once("../../config/conexion.php");

    // Consulta para obtener Pasos de Bachata
$sql ="SELECT bachata.id, niveles.nivel, tipo_baile.tipo , bachata.paso 
FROM bachata
INNER JOIN niveles ON bachata.idnivel = niveles.id
INNER JOIN tipo_baile ON bachata.idtipo = tipo_baile.id
ORDER BY 
    CASE niveles.nivel
        WHEN 'Básico' THEN 1
        WHEN 'Intermedio' THEN 2
        WHEN 'Avanzado' THEN 3
        ELSE 4 -- Para manejar cualquier otro caso, si es necesario
    END;";

// Inicializar array para Pasos de Bachata
$bachata = [];

// Verificar la conexión
if ($conn) {
    // Ejecutar la consulta
    if ($result = $conn->query($sql)) {
        // Verificar si hay resultados
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $bachata[] = $row;
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
echo json_encode($bachata, JSON_UNESCAPED_UNICODE);

// Cerrar conexión
$conn->close();


?>