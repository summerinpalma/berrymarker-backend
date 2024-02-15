<?php

declare(strict_types=1);

use Business\MarkerService;
use Business\PlantService;
use Presentation\Mapview\Mapview;
use Business\PlantTypeService;

// COMPOSER AUTOLOAD. 
require_once('vendor/autoload.php');

session_start();

// IF THE USER SESSION COOKIE IS NOT SET REDIRECT & EXIT.
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

// LOAD THE MAPVIEW AND GET PLANTLIST.
$mapview = new Mapview;
$plantTypeService = new PlantTypeService();
$plantTypes = $plantTypeService->getPlantTypeOverview();
$plantService = new PlantService();
$plants = $plantService->getPlantsOverview();
$errors = [];

if (isset($_POST["btnAddMarker"])) {
    $markerService = new MarkerService();
    
    // TOP LAYER VALIDATION FOR EMPTY FIELDS.
    $plantID = $_POST["selFruitname"] ?? '' ?: array_push($errors, "Please select a produce.");
    $latitude = $_POST["latitude"] ?? '' ?: array_push($errors, "Latitude is required.");
    $longitude = $_POST["longitude"] ?? '' ?: array_push($errors, "Longitude is required.");

    // ADD MARKER IF NO ERRORS.
    if (empty($errors)) {
    $userData = unserialize($_SESSION["user"]);
    $userID = $userData->getId();
    $result = $markerService->addMarker($userID,(int)$plantID,$longitude, $latitude);
    $marker = $result['marker'];
    $errors = $result['errors'];

    }   
}

   // SHOW MAPVIEW WITH ERRORS.
   $mapview->showMapview($plants, $errors);

?>
