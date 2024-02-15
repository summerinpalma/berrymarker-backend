<?php 
    declare(strict_types = 1);

    namespace Business;

    use Data\PlantTypeDAO;

    class PlantTypeService {

        // SHOW ALL PLANTTYPES.
        public function getPlantTypeOverview() : array {
            $plantTypeDAO = new PlantTypeDAO();
            $overview = $plantTypeDAO->getAll();

            return $overview;
        }
    }
?>