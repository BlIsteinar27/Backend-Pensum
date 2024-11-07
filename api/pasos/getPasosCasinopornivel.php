<?php 

    require_once('../../util/manejoCore.php');
    require_once('../../config/conexion.php');


    // Validar y sanitizar el ID
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    // Consulta para obtener Cursos
    $sql = "SELECT casino.id, niveles.nivel, casino.paso FROM `casino`
INNER JOIN niveles ON casino.idnivel = niveles.id
WHERE idnivel = ?;";
    
    // Preparar la declaración
    if ($stmt = $conn->prepare($sql)) {
        // Vincular parámetros
        $stmt->bind_param("i", $id);
        
        // Ejecutar la consulta
        $stmt->execute();
        
        // Obtener el resultado
        $result = $stmt->get_result();
        
        // Inicializar array para cursos
        $casino = [];
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $casino[] = $row;
            }
        } else {
            // Si no hay resultados, devolver un array vacío
            $casino = [];
        }
        
        // Liberar resultados
        $result->free();
        
        // Devolver resultados como JSON
        echo json_encode($casino, JSON_UNESCAPED_UNICODE);
        
        // Cerrar la declaración
        $stmt->close();
    } else {
        echo json_encode(['error' => 'Error en la consulta']);
    }
} else {
    echo json_encode(['error' => 'ID de nivel no válido']);
}

// Cerrar conexión
$conn->close();


?>