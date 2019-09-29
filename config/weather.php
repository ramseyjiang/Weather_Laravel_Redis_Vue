<?php

return [
    'host' => env('WEATHER_HOST', 'http://api.openweathermap.org/data/2.5/forecast'),
    'key' => env('WEATHER_KEY'),
    'fix_params' => '&units=Metric&mode=json&appid='
];