<?php
require '../config/cnxpdo_countries.php'; // Conexión a la base de datos

function getCitiesByState($state_id) {
    global $conexionBD;
    try {
        $query = "SELECT * FROM cities WHERE state_id = :state_id";
        $stmt = $conexionBD->prepare($query);
        $stmt->bindParam(':state_id', $state_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);

        if ($result) {
            echo json_encode(['rta' => $result]);
        } else {
            echo json_encode(['error' => 'No se encontraron ciudades para el estado seleccionado.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Error al obtener las ciudades: ' . $e->getMessage()]);
}
}
