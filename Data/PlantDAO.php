<?php

declare(strict_types=1);

namespace Data;

use Entities\Plant;
use Entities\PlantType;
use Exceptions\PlantAlreadyExistsException;
use Exceptions\PlantNotFoundByIdException;
use Exceptions\PlantNotFoundByName;
use Exceptions\PlantNotFoundByNameException;
use \PDO;

class PlantDAO
{
    // GET ALL PLANTS FROM TABLE, ALL PLANTS BUT ALSO ALL DATA FROM PLANTTYPES.
    public function getAll(): array
    {
        $sql = "SELECT plant.plantid as plant_id, plant.planttypeid, typename, plantname, harvestperiod FROM plant, planttype WHERE plant.planttypeid = planttype.planttypeid";

        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $resultSet = $dbh->query($sql);
        $overview = array();

        // CREATE NEW INSTANCES FOR EACH PLANT, EACH DIFFERENT PLANTTYPE AND PUSH INTO ARRAY.
        foreach ($resultSet as $row) {
            $plantType = PlantType::create((int)$row["planttypeid"], $row["typename"]);
            $plant = new Plant((int)$row["plant_id"], $row["plantname"], $plantType, $row["harvestperiod"]);
            array_push($overview, $plant);
        }

        $dbh = null;
        return $overview;
    }

    // GET PLANT BY ID.
    public function getById(int $id): Plant
    {
        // SELECT A PLANT FROM DB BY ID.
        $sql = "SELECT plant.plantid as plant_id, plant.planttypeid, typename, plantname, harvestperiod FROM plant, planttype WHERE plant.planttypeid = planttype.planttypeid AND plant.plantid = :id";


        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);

        $stmt = $dbh->prepare($sql);
        $stmt->execute(array(':id' => $id));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (is_null($row)) {
            throw new PlantNotFoundByIdException();
        }

        // CREATE NEW INSTANCE OF THIS PLANT & PLANTTYPE.
        $plantType = PlantType::create((int)$row["planttypeid"], $row["typename"]);
        $plant = new Plant((int)$row["plant_id"], $row["plantname"], $plantType, $row["harvestperiod"]);

        $dbh = null;
        return $plant;
    }

    // ADD PLANT, THIS FUNCTION IS ONLY FOR ADMINISTRATOR USERS. 
    public function create(string $plantname, int $plantTypeId, string $harvestperiod)
    {

        // CHECK IF PLANT ALREADY EXISTS. 
        $existingPlant = $this->getPlantByName($plantname);

        if (!is_null($existingPlant)) {
            throw new PlantAlreadyExistsException();
        }

        // INSERT NEW PLANT IN DATABASE.
        $sql = "INSERT INTO plant(planttypeid, plantname, harvestperiod) VALUES (:plantTypeId, :plantname, :harvestperiod)";
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $stmt = $dbh->prepare($sql);
        $stmt->execute(array(':planttypeid' => $plantTypeId, ':plantname' => $plantname, ':harvestperiod' => $harvestperiod));

        $newPlantId = $dbh->lastInsertId();

        // GET CORRECT PLANTTYPE FROM THE DAO. 
        $plantTypeDAO = new PlantTypeDAO();
        $plantType = $plantTypeDAO->getById($plantTypeId);

        // CREATE NEW INSTANCE FOR THE PLANT. 
        $plant = new Plant((int)$newPlantId, $plantname, $plantType, $harvestperiod);

        return $plant;
    }

    // REMOVE PLANT, THIS FUNCTION IS ONLY FOR ADMINISTRATOR USERS. 
    public function removePlant(int $plantId)
    {
        $sql = "DELETE FROM plant WHERE id = :plantId";
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $stmt = $dbh->prepare($sql);
        $stmt->execute(array(':plantId' => $plantId));
        $dbh = null;
    }

    // UPDATE A PLANT, THIS FUNCTION IS ONLY FOR ADMINISTRATOR USERS. 
    public function updatePlant(Plant $plant)
    {
        $existingPlant = $this->getPlantByName($plant->getPlantName());

        if (!is_null($existingPlant) && ($existingPlant->getPlantId() !== $plant->getPlantId())) {
            throw new PlantAlreadyExistsException();
        }

        $sql = "UPDATE plant SET plantname = :plantname, planttypeid = :planttypeid, harvestperiod = :harvestperiod WHERE plantid = :plantid";
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $stmt = $dbh->prepare($sql);

        $stmt->execute([
            ':plantname' => $plant->getPlantName(),
            ':planttypeid' => $plant->getPlantType()->getId(),
            ':harvestperiod' => $plant->getHarvestPeriod(),
            ':plantid' => $plant->getPlantId()
        ]);

        $dbh = null;
    }

    // GET A PLANT BY PLANTNAME.
    public function getPlantByName(string $plantname): Plant
    {
        $sql = "SELECT plant.plantid as plant_id, plant.planttypeid, planttype, plantname, harvestperiod FROM plant, planttype WHERE plant.planttypeid = planttype.planttypeid AND plantname = :plantname";
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $stmt = $dbh->prepare($sql);


        $stmt->bindParam(':plantname', $plantname, PDO::PARAM_STR);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            throw new PlantNotFoundByNameException();
        } else {
            // CREATE NEW INSTANCE OF THIS PLANT & PLANTTYPE.
            $plantType = PlantType::create((int)$row["plant.planttypeid"], $row["typename"]);
            $plant = new Plant((int)$row["plant_id"], $row["plantname"], $plantType, $row["harvestperiod"]);
            $dbh = null;
            return $plant;
        }
    }
}
