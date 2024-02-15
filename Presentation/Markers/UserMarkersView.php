<?php

declare(strict_types=1);

namespace Presentation\Markers;

use Data\URLConfig;

// IMPORT URL CONSTANTS.
// COMPOSER FIX? 
require_once("Data/URLConfig.php");

class UserMarkersView
{
    public function showAllMarkers($markers, $plants, $plantTypes, $errors = null, $succes = null)
    {
        require_once("Presentation/header.php");

?>
    <h2>Manage your Markers</h2>
        <?php if ($errors) { ?>
            <h2>Oops, please try again.</h2>
            <ul>
                <?php foreach ($errors as $error) { ?>
                    <li><?php echo $error; ?></li>
                <?php } ?>
            </ul>
        <?php } ?>
        <?php if ($succes) { ?>
            <h2>Succes!</h2>
            <ul>
                <?php foreach ($succes as $succes) { ?>
                    <li><?php echo $succes; ?></li>
                <?php } ?>
            </ul>
        <?php } ?>

        <div class="table-wrapper">
            <table class="fl-table">
                <thead>
                    <tr>
                        <th>Plant</th>
                        <th>Planttype</th>
                        <th>Harvest Time</th>
                        <th>Longitude</th>
                        <th>Latitude</th>
                        <th>Delete</th>
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
                        <td class="last-child">
                        <div class="flex-container">
                            <a class="delete-icon-link" href="<?php echo PHP_SELF_URL . "?action=remove&id=" . $marker->getMarkerId(); ?>">
                            <svg xmlns=" http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#324960" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="15" y1="9" x2="9" y2="15"></line>
                                <line x1="9" y1="9" x2="15" y2="15"></line>
                                </svg>
                            </a>
                </div>
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