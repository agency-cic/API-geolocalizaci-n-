<?php
require '../config/cnxpdo_countries.php'; // Conexión a la base de datos

function getStatesByCountry($country_id) {
    global $conexionBD;
    try {
        // Validación del country_id como entero
        $country_id = filter_var($country_id, FILTER_VALIDATE_INT);
        if (!$country_id) {
            echo json_encode(['error' => 'ID de país no válido']);
            return;
        }

        $query = "SELECT * FROM states WHERE country_id = :country_id";
        $stmt = $conexionBD->prepare($query);
        $stmt->bindValue(':country_id', $country_id, PDO::PARAM_INT);  // Usando bindValue en lugar de bindParam
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_OBJ);

        if ($result) {
            echo json_encode(['rta' => $result]);
        } else {
            echo json_encode(['error' => 'No se encontraron estados para el país seleccionado.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Error al obtener los estados: ' . $e->getMessage()]);
}
}