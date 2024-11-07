<?php 

    require_once('../../util/manejoCore.php');
    require_once('../../config/conexion.php');


    // Validar y sanitizar el ID
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    // Consulta para obtener Cursos
    $sql = "SELECT bachata.id, niveles.nivel, tipo_baile.tipo, bachata.paso FROM `bachata`
INNER JOIN niveles ON bachata.idnivel = niveles.id
INNER JOIN tipo_baile ON bachata.idtipo = tipo_baile.id
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
        $bachata = [];
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $bachata[] = $row;
            }
        } else {
            // Si no hay resultados, devolver un array vacío
            $bachata = [];
        }
        
        // Liberar resultados
        $result->free();
        
        // Devolver resultados como JSON
        echo json_encode($bachata, JSON_UNESCAPED_UNICODE);
        
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