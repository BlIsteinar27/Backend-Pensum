<?php 

require_once('../../util/manejoCore.php');
require_once('../../config/conexion.php');

// Consulta para obtener Niveles 
$sql ="SELECT pasos.id, pasos.idcurso, cursos.nombre as curso, pasos.idnivel, niveles.nivel AS nivel, pasos.idtipo, tipo_baile.tipo AS tipo, pasos.paso FROM pasos
INNER JOIN cursos on pasos.idcurso = cursos.id
INNER JOIN niveles on pasos.idnivel = niveles.id
INNER JOIN tipo_baile on pasos.idtipo = tipo_baile.id;";

// Inicializar array para niveles
$pasos = [];

// Verificar la conexión
if ($conn) {
    // Ejecutar la consulta
    if ($result = $conn->query($sql)) {
        // Verificar si hay resultados
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $pasos[] = $row;
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
echo json_encode($pasos, JSON_UNESCAPED_UNICODE);

// Cerrar conexión
$conn->close();


?>