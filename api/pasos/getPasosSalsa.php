<?php 

    require_once("../../util/manejoCore.php");
    require_once("../../config/conexion.php");

    // Consulta para obtener Pasos de Salsa En linea
$sql ="SELECT 
    pasos.id, 
    cursos.id as idcurso,
    cursos.nombre AS curso, 
    niveles.id as idnivel,
    niveles.nivel, 
    tipo_baile.id as idtipo,
    tipo_baile.tipo, 
    pasos.paso 
FROM 
    pasos
INNER JOIN 
    cursos ON pasos.idcurso = cursos.id
INNER JOIN 
    niveles ON pasos.idnivel = niveles.id
INNER JOIN 
    tipo_baile ON pasos.idtipo = tipo_baile.id
WHERE 
    pasos.idcurso = 1
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