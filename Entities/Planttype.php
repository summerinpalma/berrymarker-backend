<?php

declare(strict_types=1);

namespace Entities;

class PlantType
{

    private static $idMap = [];
    private int $id;
    private string $typename;

    private function __construct(int $id = null, string $typename = null)
    {
        $this->id = $id;
        $this->typename = $typename;
    }

    // ENSURE THAT ONLY ONE INSTANCE WITH A CERTAIN ID EXISTS.
    public static function create(int $id, string $typeName)
    {
        if (!isset(self::$idMap[$id])) {
            self::$idMap[$id] = new PlantType($id, $typeName);
        }
        return self::$idMap[$id];
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getPlantType(): string
    {
        return $this->typename;
    }

    public function setPlantType(string $typename)
    {
        $this->typename = $typename;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }
}
