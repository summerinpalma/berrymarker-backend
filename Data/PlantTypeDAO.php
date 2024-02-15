<?php

declare(strict_types=1);

namespace Data;

use Entities\PlantType;
use Data\DbConfig;
use \PDO;

class PlantTypeDAO
{
    // GET ALL PLANTTYPES FROM DATABASE.
    public function getAll(): array
    {
        $sql = "SELECT planttypeid, typename FROM planttype";
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);

        $resultSet = $dbh->query($sql);
        $overview = [];

        foreach ($resultSet as $row) {
            $plantType = PlantType::create((int)$row["planttypeid"], $row["typename"]);
            array_push($overview, $plantType);
        }

        $dbh = null;

        return $overview;
    }

    // GET A PLANTTYPE BY ID.
    public function getById(int $id): PlantType
    {
        $sql = "SELECT planttypeid, typename FROM planttype WHERE id = :id";
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);

        $stmt = $dbh->prepare($sql);
        $stmt->execute(array(':id' => $id));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $plantType = PlantType::create((int)$row["planttypeid"], $row["typename"]);
        $dbh = null;

        return $plantType;
    }
}
