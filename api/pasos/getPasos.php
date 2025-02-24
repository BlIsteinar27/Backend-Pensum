<?php

require_once('../../util/manejoCore.php');
require_once('../../config/conexion.php');

function obtenerPasos($conn) {
    $sql = "SELECT pasos.id, pasos.idcurso, cursos.nombre as curso, pasos.idnivel, niveles.nivel AS nivel, pasos.idtipo, tipo_baile.tipo AS tipo, pasos.paso FROM pasos
            INNER JOIN cursos on pasos.idcurso = cursos.id
            INNER JOIN niveles on pasos.idnivel = niveles.id
            INNER JOIN tipo_baile on pasos.idtipo = tipo_baile.id;";

    $pasos = [];

    if ($result = $conn->query($sql)) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $pasos[] = $row;
            }
        }
        $result->free();
    } else {
        throw new Exception('Error en la consulta: ' . $conn->error);
    }
    return $pasos;
}

try {
    if ($conn) {
        $pasos = obtenerPasos($conn);
        echo json_encode($pasos, JSON_UNESCAPED_UNICODE);
    } else {
        throw new Exception('Error en la conexión a la base de datos');
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
} finally {
    $conn->close();
}

?>
