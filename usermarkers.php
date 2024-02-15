<?php

declare(strict_types=1);

use Business\MarkerService;
use Business\UserService;
use Business\PlantService;
use Business\PlantTypeService;
use Presentation\Markers\UserMarkersView;

// COMPOSER AUTOLOAD.
require_once('vendor/autoload.php');

session_start();

// IF THE USER SESSION COOKIE IS NOT SET REDIRECT & EXIT.
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

// LOAD THE VIEW AND SERVICES. 
$userMarkersView = new UserMarkersView;
$markerService = new MarkerService;

$plantService = new PlantService;
$plants = $plantService->getPlantsOverview();

$plantTypeService = new PlantTypeService;
$plantTypes = $plantTypeService->getPlantTypeOverview();

// GET USERID FROM SESSION.
$sessionData = unserialize($_SESSION["user"]);
$userid = $sessionData->getId();

// RESET ERRORS & SUCCES. 
$succes = [];
$errors = [];

if (isset($_GET["action"]) && $_GET["action"] === "remove" && isset($_GET["id"])) {
    $result = $markerService->checkMarkerForRightId($userid, (int) $_GET["id"]);
    $succes = $result['succes'];
    $errors = $result['errors'];
}

// RENDER MAPVIEW. 
$result = $markerService->getMarkersByUserId($userid);
$markers = $result['markers'];
$errors = $result['errors'];

$userMarkersView->showAllMarkers($markers, $plants, $plantTypes,$errors, $succes);

?>
