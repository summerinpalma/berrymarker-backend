<?php

declare(strict_types=1);

namespace Entities;

use Entities\PlantType;

class Plant
{
    private int $plantid;
    private string $plantname;
    private PlantType $plantType;
    private string $harvestPeriod;


    public function __construct(int $plantid = null, string $plantname = null, PlantType $plantType = null, string $harvestPeriod = null)
    {
        $this->plantid = $plantid;
        $this->plantname = $plantname;
        $this->plantType = $plantType;
        $this->harvestPeriod = $harvestPeriod;
    }

    public function getPlantId(): int
    {
        return $this->plantid;
    }

    public function getPlantName(): string
    {
        return $this->plantname;
    }

    public function getPlantType(): PlantType
    {
        return $this->plantType;
    }

    public function getHarvestPeriod(): string
    {
        return $this->harvestPeriod;
    }

    public function setPlantName(string $plantname)
    {
        $this->plantname = $plantname;
    }

    public function setPlantType(PlantType $plantType)
    {
        $this->plantType = $plantType;
    }

    public function setHarvestPeriod(string $harvestPeriod)
    {
        $this->harvestPeriod = $harvestPeriod;
    }
}
