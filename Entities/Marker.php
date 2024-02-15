<?php

declare(strict_types=1);

namespace Entities;

use Entities\Plant;
use Entities\User;
use Exceptions\LatitudeNotValidException;
use Exceptions\LongitudeNotValidException;

class Marker
{
    private static $idMap = [];
    private int $markerid;
    private Plant $plant;
    private User $user;
    private string $longitude;
    private string $latitude;

    public function __construct(?int $markerid, ?Plant $plant = null, ?User $user, ?string $longitude, ?string $latitude)
    {
        $this->markerid = $markerid;
        $this->plant = $plant;
        $this->user = $user;
        $this->longitude = $longitude;
        $this->latitude = $latitude;
    }

    // ENSURE THAT ONLY ONE INSTANCE WITH A CERTAIN ID EXISTS.
    public static function create(int $markerid, Plant $plant, User $user, string $longitude, string $latitude)
    {
        if (!isset(self::$idMap[$markerid])) {
            self::$idMap[$markerid] = new Marker($markerid, $plant, $user, $longitude, $latitude);
        }
        return self::$idMap[$markerid];
    }

    public function getMarkerId(): int
    {
        return $this->markerid;
    }

    public function getPlant(): Plant
    {
        return $this->plant;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getLongitude(): string
    {
        return $this->longitude;
    }

    public function getLatitude(): string
    {
        return $this->latitude;
    }

    public function setPlant(Plant $plant)
    {
        $this->plant = $plant;
    }

    public function setUser(User $user)
    {
        $this->user = $user;
    }

    public function setLongitude(string $longitude)
    {
            $this->longitude = $longitude;   
    }

    public function setLatitude(string $latitude)
    {
            $this->latitude = $latitude; 
    }
}
