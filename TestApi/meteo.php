<?php
require_once 'OpenWeather.php';
$weather = new OpenWeather('d8cdd224c32d83ebafc2f77d1f919e9b');
$forecast=$weather->getForecast('Paris,fr');
$today = $weather->getToday('Paris,fr');
var_dump($forecast);
?>
<div class="container">
    <ul>
        <li> <?=$today['description']?> <?=$today['temp']?></li>
        <?php foreach ($forecast as $day):?>
        <li> <?=$day['date']->format('d/m/y')?> <?=$day['description']?> <?=$day['temp']?></li>
        <?php endforeach;?>
    </ul>


</div>
