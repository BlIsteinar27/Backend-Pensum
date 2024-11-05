<?php 

    require_once("../../util/manejoCore.php");
    require_once("../../config/conexion.php");

    // Consulta para obtener Pasos de Casino
$sql ="SELECT casino.id, niveles.nivel, casino.paso 
FROM `casino`
INNER JOIN niveles ON casino.idnivel = niveles.id
ORDER BY 
    CASE niveles.nivel
        WHEN 'Básico' THEN 1
        WHEN 'Intermedio' THEN 2
        WHEN 'Avanzado' THEN 3
        ELSE 4 -- Para manejar cualquier otro caso, si es necesario
    END;";

// Inicializar array para Pasos de casino
$casino = [];

// Verificar la conexión
if ($conn) {
    // Ejecutar la consulta
    if ($result = $conn->query($sql)) {
        // Verificar si hay resultados
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $casino[] = $row;
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
echo json_encode($casino, JSON_UNESCAPED_UNICODE);

// Cerrar conexión
$conn->close();


?>