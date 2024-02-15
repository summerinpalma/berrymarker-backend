<?php

declare(strict_types=1);

namespace Business;

use Data\PlantDAO;
use Data\PlantTypeDAO;
use Entities\Plant;

class PlantService
{

    // GET ALL PLANTS VIA PLANTDAO.
    public function getPlantsOverview(): array
    {
        $plantDAO = new PlantDAO();
        $list = $plantDAO->getAll();
        return $list;
    }

    // GET PLANT BY NAME.
    public function getPlantByName(string $plantName): Plant
    {
        $plantDAO = new PlantDAO();
        $plant = $plantDAO->getPlantByName((trim($plantName)));
        return $plant;
    }

    // GET PLANT BY ID.
    public function getPlantById(int $plantid): Plant
    {
        $plantDAO = new PlantDAO();
        $plant = $plantDAO->getById($plantid);
        return $plant;
    }

    // ADD A NEW PLANT.
    public function addNewPlant(int $plantTypeId, string $plantName, string $harvestPeriod): Plant
    {
        $plantDAO = new PlantDAO();
        $plant = $plantDAO->create($plantName, $plantTypeId, $harvestPeriod);
        return $plant;
    }

    // REMOVE A PLANT.
    public function removePlant(int $plantId)
    {
        $plantDAO = new PlantDAO();
        $plantDAO->removePlant($plantId);
    }

    // UPDATE A PLANT. 
    public function updatePlant(int $plantId, int $plantTypeId, string $plantName, string $harvestPeriod): Plant
    {
        $plantTypeDAO = new PlantTypeDAO();
        $plantDAO = new PlantDAO();

        $plantType = $plantTypeDAO->getById($plantTypeId);
        $plant = $plantDAO->getById($plantId);

        $plant->setPlantName($plantName);
        $plant->setPlantType($plantType);
        $plant->setHarvestPeriod($harvestPeriod);

        $plantDAO->updatePlant($plant);

        return $plant;
        
    }
}
