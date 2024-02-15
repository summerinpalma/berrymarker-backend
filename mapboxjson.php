<?php

declare(strict_types=1);

namespace Business; 

// COMPOSER AUTOLOAD. 
require_once('vendor/autoload.php');

use Business\MarkerService;

$markerService = new MarkerService;

$markerData = $markerService->prepareMarkerArrayForMapbox();

header('Content-Type: application/json');

echo $markerData;

?>
