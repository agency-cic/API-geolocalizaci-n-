<?php
// Middleware para cabeceras CORS y manejo de tipos de solicitudes
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET, POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require '../config/cnxpdo_countries.php'; // Conexión a la base de datos

$method = $_SERVER['REQUEST_METHOD'];
$resource = $_GET['resource'] ?? null;  // Cambiado para usar el parámetro 'resource'

// Mostrar todos los errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

@include 'countries/countries.php';
@include 'states/states.php';
@include 'cities/cities.php';

switch ($method) {
    case 'GET':
        if ($resource === 'countries') {
            getCountries();
        } elseif ($resource === 'states' && isset($_GET['country_id'])) {
            getStatesByCountry($_GET['country_id']);
        } elseif ($resource === 'cities' && isset($_GET['state_id'])) {
            getCitiesByState($_GET['state_id']);
        } else {
            echo json_encode(["error" => "Recurso no encontrado"]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(["error" => "Método no permitido"]);
        break;
}