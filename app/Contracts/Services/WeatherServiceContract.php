<?php

namespace Weather\Contracts\Services;

interface WeatherServiceContract 
{
    /**
     * Get city weather, firstly check redis key exits or not, if not invoke getCityWeatherFromThirdParty method
     *
     * @param string $cityName
     * @param integer $cnt
     * @return void
     */
    public function getCityWeather(string $cityName, int $cnt=7);

    /**
     * Get city weather by city name from openweathermap.org
     *
     * @param string $cityName
     * @param integer $cnt
     * @return void
     */
    public function getCityWeatherFromThirdParty(string $cityName, int $cnt=7);

    /**
     * Process weather data and return json to frontend, store data in database for cache at least a half hour
     *
     * @param array $weatherData
     * @return void
     */
    public function processData(array $weatherData);
}