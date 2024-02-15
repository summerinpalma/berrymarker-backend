<?php

declare(strict_types=1);

namespace Business;

use Data\MarkerDAO;
use Data\PlantDAO;
use Data\UserDAO;

use Entities\Marker;
use Exceptions\LatitudeNotValidException;
use Exceptions\LongitudeNotValidException;
use Exceptions\MarkerAlreadyExistsException;
use Exceptions\MarkerNotFoundByIdException;
use Exceptions\NoMarkersFoundByUserIdException;
use Exceptions\NoMarkersFoundByPlantIdException;
use Exceptions\NoMarkersFoundByPlantTypeIdException;
use Exceptions\NoMarkersFoundException;
use Exceptions\TestException;

class MarkerService
{

    // GET ALL MARKERS VIA MARKERDAO. 
    public function getMarkersOverview(): array
    {
        $markerDAO = new MarkerDAO();
        $errors = [];
        $markerList = $markerDAO->getAll();
        return ["markers" => $markerList, "errors" => $errors];
    }

    // GET MARKER BY ID. 
    public function getMarkerById(int $markerid): Marker
    {
        $markerDAO = new MarkerDAO();
        $marker = $markerDAO->getById($markerid);
        return $marker;
    }

    // GET MARKERS BY PLANTID. 
    public function getMarkersByPlantId(int $plantid): array
    {
        $markerList = [];
        $errors = [];

        // ERROR NOT LOADING. COMPOSER ERROR?
        try {
            $markerDAO = new MarkerDAO();
            $markerList = $markerDAO->getByPlantId($plantid);
        } catch (TestException $e) {
            array_push($errors, $e->getMessage());
        }

        return ["markers" => $markerList, "errors" => $errors];
    }

    // GET MARKERS BY PLANTTYPEID. 
    public function getMarkersByPlantTypeId(int $planttypeid): array
    {
        $markerList = [];
        $errors = [];

        // ERROR NOT LOADING. COMPOSER ERROR?
        try {
            $markerDAO = new MarkerDAO();
            $markerList = $markerDAO->getByPlantTypeId($planttypeid);
        } catch (TestException $e) {
            array_push($errors, $e->getMessage());
        }

        return ["markers" => $markerList, "errors" => $errors];
    }

    // GET MARKERS BY USERID.
    public function getMarkersByUserId(int $userid): array
    {
        $markerList = [];
        $errors = [];

        try {
            $markerDAO = new MarkerDAO();
            $markerList = $markerDAO->getByUserId($userid);
        } catch (NoMarkersFoundByUserIdException $e) {
            array_push($errors, $e->getMessage());
        }

        return ["markers" => $markerList, "errors" => $errors];
    }

    // CHECK IF MARKER IS FROM USER & REMOVE.
    public function checkMarkerForRightId(int $userId, int $markerId)
    {
        $loggedInUser = $_SESSION['user'];
        $userObject = unserialize($loggedInUser);
        $userId = $userObject->getId();

        $marker = $this->getMarkerById($markerId);

        $succesMessage = [];
        $errors = [];

        if ($marker && $marker->getUser()->getId() === $userId) {
            $this->removeMarker($markerId);
            array_push($succesMessage, "Marker removed succesfully.");
        } else {
            array_push($errors, "You do not have permission to remove this marker.");
        }

        return ['succes' => $succesMessage, 'errors' => $errors];
    }

    // ADD A NEW MARKER. 
    public function addMarker(int $userid, int $plantid, string $longitude, string $latitude)
    {
        $markerDAO = new MarkerDAO();
        $marker = [];
        $errors = [];

        try {
            $this->validateLongitude($longitude);
        } catch (LongitudeNotValidException $e) {
            array_push($errors, $e->getMessage());
        }

        try {
            $this->validateLatitude($latitude);
        } catch (LatitudeNotValidException $e) {
            array_push($errors, $e->getMessage());
        }

        if (empty($errors)) {
            $marker = $markerDAO->createMarker($userid, $plantid, $longitude, $latitude);
        }

        return ["marker" => $marker, "errors" => $errors];
    }

    // UPDATE A MARKER. 
    public function updateMarker(int $markerid, int $userid, int $plantid, string $longitude, string $latitude)
    {
        $userDAO = new UserDAO();
        $plantDAO = new PlantDAO();
        $markerDAO = new MarkerDAO();

        $errors = [];

        $user = $userDAO->getUserById($userid);
        $plant = $plantDAO->getById($plantid);

        try {
            $marker = $markerDAO->getById($markerid);
        } catch (MarkerNotFoundByIdException $e) {
            array_push($errors, $e->getMessage());
        }

        $marker->setUser($user);
        $marker->setPlant($plant);

        try {
            $this->validateLongitude($longitude);
            $marker->setLongitude($longitude);
        } catch (LongitudeNotValidException $e) {
            array_push($errors, $e->getMessage());
        }

        try {
            $this->validateLatitude($latitude);
            $marker->setLatitude($latitude);
        } catch (LatitudeNotValidException $e) {
            array_push($errors, $e->getMessage());
        }

        if (empty($errors)) {
            try {
                $markerDAO->updateMarker($marker);
            } catch (MarkerAlreadyExistsException $e) {
                array_push($errors, $e->getMessage());
            }
        }

        var_dump($errors);

        return ["marker" => $marker, "errors" => $errors];
    }

    public function removeMarker(int $markerid)
    {
        $markerDAO = new MarkerDAO();
        $markerDAO->removeMarker($markerid);
    }

    public function prepareMarkerArrayForMapbox()
    {
        $markerDAO = new MarkerDAO();
        $markersData = $markerDAO->getAll();

        $markersForMapbox = [];
        foreach ($markersData as $marker) {
            // EXTRACT DATA FROM MARKERS.
            $latitude = $marker->getLatitude();
            $longitude = $marker->getLongitude();
            $markerId = $marker->getMarkerId();
            $plantName = $marker->getPlant()->getPlantName();
            $plantType = $marker->getPlant()->getPlantType()->getPlantType();
            $harvestPeriod = $marker->getPlant()->getHarvestPeriod();
            $userId = $marker->getUser()->getId();
            $username = $marker->getUser()->getUsername();

            // CREATE MARKER OBJECT FOR MAPBOX.
            $markerForMapbox = [
                'type' => 'Feature',
                'geometry' => [
                    'type' => 'Point',
                    'coordinates' => [$longitude, $latitude],
                ],
                'properties' => [
                    'markerId' => $markerId,
                    'plantName' => $plantName,
                    'plantType' => $plantType,
                    'harvestPeriod' => $harvestPeriod,
                    'userId' => $userId,
                    'username' => $username,
                    'icon' => "Presentation/assets/images/map-cursor-48.png"
                ],
            ];

            $markersForMapbox[] = $markerForMapbox;
        }

        $markersJSON = json_encode($markersForMapbox);

        return $markersJSON;
    }

    private function validateLongitude(string $longitude)
    {
        // LONGITUDE MUST BE A NUMBER BETWEEN - 180 & 180.
        if (!is_numeric($longitude) || floatval($longitude) < -180 || floatval($longitude) > 180) {
            throw new LongitudeNotValidException();
        }
    }

    private function validateLatitude(string $latitude)
    {
        // LATITUDE MUST BE A NUMBER BETWEEN -90 & 90.
        if (!is_numeric($latitude) || floatval($latitude) < -90 || floatval($latitude) > 90) {
            throw new LatitudeNotValidException();
        }
    }
}
