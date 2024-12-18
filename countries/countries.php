<?php
require '../config/cnxpdo_countries.php'; // Conexión a la base de datos

function getCountries() {
    global $conexionBD;
    try {
        $query = "SELECT * FROM countries";
        $stmt = $conexionBD->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);

        if ($result) {
            echo json_encode(['rta' => $result]);
        } else {
            echo json_encode(['error' => 'No se encontraron países.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Error al obtener los países: ' . $e->getMessage()]);
}
}
