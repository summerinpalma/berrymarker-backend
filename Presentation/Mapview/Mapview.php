<?php

declare(strict_types=1);

namespace Presentation\Mapview;

use Data\URLConfig;

// IMPORT URL CONSTANTS.
// COMPOSER FIX? 
require_once("Data/URLConfig.php");

class Mapview
{
    public function showMapview($plants, $errors = null)
    {
        require_once("Presentation/headermapview.php");
?>
<h2>"Go on, zoom like your accuracy depends on it, because it does!"</h2>
<div class="map-container" id="map-container"></div>
    <div id="addmarker" class="addmarker">
    <?php if ($errors) { ?>
            <h2>Oops, please try again.</h2>
            <ul>
                <?php foreach ($errors as $error) { ?>
                    <li><?php echo $error; ?></li>
                <?php } ?>
            </ul>
    <?php } ?>
        <form id="addmarkerform" action="<?php echo PHP_SELF_URL; ?>" method="POST">
            <label for="fruitname" id="fruitnamelabel">Produce name:</label>
            <select name="selFruitname" aria-labelledby="fruitname-label">
            <option value="">Pick a produce</option>
                <?php foreach ($plants as $plant) {  ?>
                    <option value="<?php echo $plant->getPlantId(); ?>">
                        <?php echo $plant->getPlantName(); ?>    
                    </option>
                <?php } ?>
            </select>
            <label for="longitude" id="longitude-label">Longitude:</label>
            <input type="text" name="longitude" id="txtLongitude" aria-labelledby="longitude-label">
            <label for="latitude" id="latitude-label">Latitude:</label>
            <input type="text" name="latitude" id="txtLatitude" aria-labelledby="latitude-label">
            <input type="submit" value="Add my marker!" name="btnAddMarker">
        </form>
    </div>
    
<script src="Presentation/js/map.js?v=3"></script>

<?php
        require_once("Presentation/footer.php");
    }
}
?>
