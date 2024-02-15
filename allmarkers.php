<?php 

declare(strict_types=1);

use Business\MarkerService;
use Business\PlantService;
use Business\PlantTypeService;
use Presentation\Markers\AllMarkersView;

// COMPOSER AUTOLOAD.
require_once('vendor/autoload.php');

session_start();

// IF THE USER SESSION COOKIE IS NOT SET REDIRECT & EXIT.
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

// LOAD THE ALLMARKERSVIEW AND GET PLANTLIST.
$allMarkersView = new AllMarkersView;
$markerService = new MarkerService;

$plantService = new PlantService;
$plants = $plantService->getPlantsOverview();

$plantTypeService = new PlantTypeService;
$plantTypes = $plantTypeService->getPlantTypeOverview();

if (isset($_POST["btnSortByProduce"])) {
    if ($_POST["selFruitname"] !== 'none') {
        $plantID = (int) $_POST["selFruitname"];
        $result = $markerService->getMarkersByPlantId((int)$_POST["selFruitname"]);
        $markers = $result['markers'];
        $errors = $result['errors'];
    }
}

    if (isset($_POST["btnSortByPlantType"])) {
        if ($_POST["selPlantType"] !== 'none') {
            $plantID = (int) $_POST["selPlantType"];
            $result = $markerService->getMarkersByPlantTypeId((int)$_POST["selPlantType"]);
            $markers = $result['markers'];
            $errors = $result['errors'];
        }
   
}

if (!isset($_POST["btnSortByProduce"]) && !isset($_POST["btnSortByPlantType"])) {
    $result = $markerService->getMarkersOverview();
    $markers = $result['markers'];
    $errors = $result['errors'];
}

$allMarkersView->showAllMarkers($markers, $plants, $plantTypes, $errors);

?>