<?php

declare(strict_types=1);

namespace Exceptions;

use Exception;

class UserIdInvalidException extends Exception
{
    public function __construct($message = "User ID is not a number.", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

class UserNameSpecialCharactersException extends Exception
{
    public function __construct($message = "Username can not contain special characters.", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

class UserNameTooShortException extends Exception
{
    public function __construct($message = "Username should be longer than 5 characters.", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

class EmailInvalidException extends Exception
{
    public function __construct($message = "Not a valid e-mail address.", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

class PasswordInvalidFormatException extends Exception
{
    public function __construct($message = "Password requirements not met.", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

class RoleInvalidFormatException extends Exception
{
    public function __construct($message = "Trying to set invalid role.", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

class UserEmailAlreadyTakenException extends Exception
{
    public function __construct($message = "E-mail address already taken.", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

class UserNameAlreadyTakenException extends Exception
{
    public function __construct($message = "Username already taken.", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

class InCorrectPasswordException extends Exception
{
    public function __construct($message = "Password was not correct.", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

class UserNotFoundException extends Exception
{
    public function __construct($message = "Password was not correct.", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

class PlantAlreadyExistsException extends Exception
{
    public function __construct($message = "Plantname already exists.", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

class PlantNotFoundByNameException extends Exception
{
    public function __construct($message = "Plant has not been found (NAME).", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

class PlantNotFoundByIdException extends Exception
{
    public function __construct($message = "Plant has not been found (ID).", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

class MarkerNotFoundByIdException extends Exception
{
    public function __construct($message = "Marker has not been found (ID).", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}


class NoMarkersFoundException extends Exception
{
    public function __construct($message = "Markers have not been found.", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

class NoMarkersFoundByUserIdException extends Exception
{
    public function __construct($message = "Markers have not been found.", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
class NoMarkersFoundByPlantIdException extends Exception
{
    public function __construct($message = "No markers with this Plant.", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
class NoMarkersFoundByPlantTypeIdException extends Exception
{
    public function __construct($message = "No markers with this Planttype.", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
class MarkerAlreadyExistsException extends Exception
{
    public function __construct($message = "Marker already exists.", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
class LongitudeNotValidException extends Exception
{
    public function __construct($message = "Longitude must be a value between -180 and 180.", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
class LatitudeNotValidException extends Exception
{
    public function __construct($message = "Latitude must be a value between -90 and 90.", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

class TestException extends Exception
{
    public function __construct($message = "This is a test exception.", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
?>