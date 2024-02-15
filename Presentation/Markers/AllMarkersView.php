<?php

declare(strict_types=1);

namespace Presentation\Markers;

use Data\URLConfig;

// IMPORT URL CONSTANTS.
// COMPOSER FIX? 
require_once("Data/URLConfig.php");

class AllMarkersView
{
    public function showAllMarkers($markers, $plants, $plantTypes, $errors = null)
    {
        require_once("Presentation/header.php");

?>
        <h2>All Markers</h2>
        <?php if ($errors) { ?>
            <h2>Oops, please try again.</h2>
            <ul>
                <?php foreach ($errors as $error) { ?>
                    <li><?php echo $error; ?></li>
                <?php } ?>
            </ul>
        <?php } ?>
        <form id="sortbyplantname" action="<?php echo PHP_SELF_URL; ?>" method="POST">
            <label for="fruitname" id="fruitnamelabel">Produce name:</label>
            <select name="selFruitname" aria-labelledby="fruitname-label">
                <option value="none">Filter None</option>
                <?php foreach ($plants as $plant) {  ?>
                    <option value="<?php echo $plant->getPlantId(); ?>">
                        <?php echo $plant->getPlantName(); ?>
                    </option>
                <?php } ?>
            </select>
            <input type="submit" value="Sort by Produce" name="btnSortByProduce">
        </form>
        <form id="sortbyplanttype" action="<?php echo PHP_SELF_URL; ?>" method="POST">
            <label for="planttype" id="planttypelabel">Plant Type:</label>
            <select name="selPlantType" aria-labelledby="planttype-label">
                <option value="none">Filter None</option>
                <?php foreach ($plantTypes as $plantType) {  ?>
                    <option value="<?php echo $plantType->getId(); ?>">
                        <?php echo $plantType->getPlantType(); ?>
                    </option>
                <?php } ?>
            </select>
            <input type="submit" value="Sort by Plant Type" name="btnSortByPlantType">
            <input type="submit" value="Reset filters" name="btnResetFilters">
            <div class="table-wrapper">
                <table class="fl-table">
                    <thead>
                        <tr>
                            <th>Plant</th>
                            <th>Planttype</th>
                            <th>Harvest Time</th>
                            <th>Longitude</th>
                            <th>Latitude</th>
                            <th>Added by</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($markers as $marker) { ?>
                            <tr>
                                <td>
                                    <?php echo $marker->getPlant()->getPlantName(); ?>
                                </td>
                                <td>
                                    <?php echo $marker->getPlant()->getPlantType()->getPlantType(); ?>
                                </td>
                                <td>
                                    <?php echo $marker->getPlant()->getHarvestPeriod(); ?>
                                </td>
                                <td>
                                    <?php echo $marker->getLongitude(); ?>
                                </td>
                                <td>
                                    <?php echo $marker->getLatitude(); ?>
                                </td>
                                <td>
                                    <?php echo $marker->getUser()->getUsername(); ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

    <?php
        require_once("Presentation/footer.php");
    }
}
    ?>