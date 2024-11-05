<?php 

    require_once("../../util/manejoCore.php");
    require_once("../../config/conexion.php");

    // Consulta para obtener Pasos de Salsa En linea
$sql ="SELECT salsa_en_linea.id, niveles.nivel, tipo_baile.tipo , salsa_en_linea.paso 
FROM salsa_en_linea
INNER JOIN niveles ON salsa_en_linea.idnivel = niveles.id
INNER JOIN tipo_baile ON salsa_en_linea.idtipo = tipo_baile.id
ORDER BY 
    CASE niveles.nivel
        WHEN 'Básico' THEN 1
        WHEN 'Intermedio' THEN 2
        WHEN 'Avanzado' THEN 3
        ELSE 4 -- Para manejar cualquier otro caso, si es necesario
    END;";

// Inicializar array para Pasos de Salsa En Linea
$salsa = [];

// Verificar la conexión
if ($conn) {
    // Ejecutar la consulta
    if ($result = $conn->query($sql)) {
        // Verificar si hay resultados
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $salsa[] = $row;
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
echo json_encode($salsa, JSON_UNESCAPED_UNICODE);

// Cerrar conexión
$conn->close();


?>