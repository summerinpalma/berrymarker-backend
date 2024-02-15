<?php

declare(strict_types=1);

namespace Data;

use Entities\Plant;
use Entities\User;
use Entities\PlantType;

use Entities\Marker;
use Data\PlantDAO;
use Data\UserDAO;
use Exceptions\MarkerAlreadyExistsException;
use Exceptions\MarkerNotFoundByIdException;
use Exceptions\NoMarkersFoundByPlantIdException;
use Exceptions\NoMarkersFoundByPlantTypeIdException;
use Exceptions\NoMarkersFoundByUserIdException;
use Exceptions\NoMarkersFoundException;
use Exceptions\TestException;
use \PDO;

class MarkerDAO
{
    // GET ALL MARKERS FROM TABLE, // PLANTS, TYPES, USERS. 
    public function getAll(): array
    {
        $sql = "SELECT markerid, plantid, userid, longitude, latitude FROM marker";

        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $resultSet = $dbh->query($sql);
        $overview = array();

        if (is_null($resultSet)) {
            throw new NoMarkersFoundException();
        }

        $plantDAO = new PlantDAO();
        $userDAO = new UserDAO();

        // CREATE NEW INSTANCES FOR EACH MARKER, PLANT, PLANTTYPE & USER.
        foreach ($resultSet as $row) {

            $user = $userDAO->getUserById($row["userid"]);
            $user->resetSensitiveData();
            $plant = $plantDAO->getById($row["plantid"]);
            $marker = Marker::create($row["markerid"], $plant, $user, $row["longitude"], $row["latitude"]);

            array_push($overview, $marker);
        }

        $dbh = null;
        return $overview;
    }

    public function getById(int $id): Marker
    {
        // SELECT A MARKER FROM DB BY ID.
        $sql = "SELECT markerid, plantid, userid, longitude, latitude FROM marker WHERE markerid = :id";

        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);

        $stmt = $dbh->prepare($sql);
        $stmt->execute(array(':id' => $id));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (is_null($row)) {
            throw new MarkerNotFoundByIdException();
        }

        // CREATE NEW INSTANCES.
        $plantDAO = new PlantDAO();
        $userDAO = new UserDAO();

        $user = $userDAO->getUserById($row["userid"]);
        $user->resetSensitiveData();
        $plant = $plantDAO->getById($row["plantid"]);
        $marker = Marker::create($row["markerid"], $plant, $user, $row["longitude"], $row["latitude"]);

        $dbh = null;
        return $marker;
    }

    public function getByUserId(int $id): array
    {
        // SELECT A MARKER FROM DB BY ID.
        $sql = "SELECT markerid, plantid, userid, longitude, latitude FROM marker WHERE userid = :id";

        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);

        $stmt = $dbh->prepare($sql);
        $stmt->execute(array(':id' => $id));
        
        $overview = [];
        
        // CREATE NEW INSTANCES FOR EACH MARKER, PLANT, PLANTTYPE & USER.
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $plantDAO = new PlantDAO();
            $userDAO = new UserDAO();
            $user = $userDAO->getUserById($row["userid"]);
            $user->resetSensitiveData();
            $plant = $plantDAO->getById($row["plantid"]);
            $marker = Marker::create($row["markerid"], $plant, $user, $row["longitude"], $row["latitude"]);

            array_push($overview, $marker);
        }

        if (empty($overview)) {
            throw new NoMarkersFoundByUserIdException();
        }

        $dbh = null;
        return $overview;
    }

    public function getByPlantId(int $id): array
    {
        // SELECT A MARKER FROM DB BY ID.
        $sql = "SELECT markerid, plantid, userid, longitude, latitude FROM marker WHERE plantid = :id";

        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);

        $stmt = $dbh->prepare($sql);
        $stmt->execute(array(':id' => $id));

        $overview = [];

        // CREATE NEW INSTANCES FOR EACH MARKER, PLANT, PLANTTYPE & USER.
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $plantDAO = new PlantDAO();
            $userDAO = new UserDAO();

            $user = $userDAO->getUserById($row["userid"]);
            $user->resetSensitiveData();
            $plant = $plantDAO->getById($row["plantid"]);
            $marker = Marker::create($row["markerid"], $plant, $user, $row["longitude"], $row["latitude"]);

            array_push($overview, $marker);
        }

        if (empty($overview)) {
            throw new TestException();
        }

        $dbh = null;
        return $overview;
    }

    public function getByPlantTypeId(int $id): array
    {
        // SELECT A MARKER FROM DB BY ID.
        $sql = "SELECT m.markerid, m.plantid, m.userid, m.longitude, m.latitude FROM marker m JOIN plant p ON m.plantid = p.plantid WHERE p.planttypeid = :id;";

        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);

        $stmt = $dbh->prepare($sql);
        $stmt->execute(array(':id' => $id));

        $overview = [];

        // CREATE NEW INSTANCES FOR EACH MARKER, PLANT, PLANTTYPE & USER.
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $plantDAO = new PlantDAO();
            $userDAO = new UserDAO();

            $user = $userDAO->getUserById($row["userid"]);
            $user->resetSensitiveData();
            $plant = $plantDAO->getById($row["plantid"]);
            $marker = Marker::create($row["markerid"], $plant, $user, $row["longitude"], $row["latitude"]);

            array_push($overview, $marker);
        }

        if (empty($overview)) {
            throw new TestException();
        }

        $dbh = null;
        return $overview;
    }

    // ADD MARKER, THIS FUNCTION IS FOR EVERY USER. 
    public function createMarker(int $userid, int $plantid, string $longitude, string $latitude): Marker
    {
        // DECIDE FOR CHECK IF MARKER ALREADY EXISTS ON LOCATION - CHECK FOR LNG & LAT AND PLANTID. 
        // OKAY - IGNORE FOR NOW. 

        // GET CORRECT PLANT, USER FROM THE DAO.
        $plantDAO = new PlantDAO();
        $plant = $plantDAO->getById($plantid);

        $userDAO = new UserDAO();
        $user = $userDAO->getUserById($userid);
        $user->resetSensitiveData();

        // LNG & LAT VALIDATION.
        $marker = new Marker(1, $plant, $user, 'longitude', 'latitude');
        $marker->setLongitude($longitude);
        $marker->setLatitude($latitude);

        // INSERT NEW MARKER IN DATABASE.
        $sql = "INSERT INTO marker(plantid, userid, longitude, latitude) VALUES (:plantid, :userid, :longitude, :latitude)";
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $stmt = $dbh->prepare($sql);
        $stmt->execute(array(':plantid' => $plantid, ':userid' => $userid, ':longitude' => $longitude, ':latitude' => $latitude));

        $newMarkerId = $dbh->lastInsertId();

        // GET CORRECT PLANT, USER FROM THE DAO.
        $plantDAO = new PlantDAO();
        $plant = $plantDAO->getById($plantid);

        $userDAO = new UserDAO();
        $user = $userDAO->getUserById($userid);
        $user->resetSensitiveData();

        // CREATE NEW INSTANCE OF THE MARKER.
        $marker = new Marker((int)$newMarkerId, $plant, $user, $longitude, $latitude);

        return $marker;
    }

    public function removeMarker(int $markerid)
    {
        $sql = "DELETE FROM marker WHERE markerid = :markerid";
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $stmt = $dbh->prepare($sql);
        $stmt->execute(array(':markerid' => $markerid));
        $dbh = null;
    }

    // UPDATE A MARKER. 
    public function updateMarker(Marker $marker)
    {
        $existingMarker = $this->getById($marker->getMarkerId());

        // CHECK FOR CONFLICTING MARKERS.
        if (!is_null($existingMarker) && ($existingMarker->getMarkerId() !== $marker->getMarkerId())) {
            throw new MarkerAlreadyExistsException();
        }

        $sql = "UPDATE marker SET plantid = :plantid, longitude = :longitude, latitude = :latitude WHERE markerid = :markerid";
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $stmt = $dbh->prepare($sql);

        $stmt->execute([
            ':plantid' => $marker->getPlant()->getPlantId(),
            ':longitude' => $marker->getLongitude(),
            ':latitude' => $marker->getLatitude(),
            ':markerid' => $marker->getMarkerId()
        ]);

        $dbh = null;
    }
}
