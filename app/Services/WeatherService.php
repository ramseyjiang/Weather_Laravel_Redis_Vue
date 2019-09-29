<?php
namespace Weather\Services;

use Weather\Contracts\Services\WeatherServiceContract;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Response;

class WeatherService implements WeatherServiceContract
{
    /**
     * Get city weather, firstly check redis key exits or not, if not invoke getCityWeatherFromThirdParty method
     *
     * @param string $cityName
     * @param integer $cnt
     * @return void
     */
    public function getCityWeather(string $cityName, int $cnt=40)
    {
        if($cityWeather = Redis::get($cityName)) {
            return [
                'status' => Response::HTTP_OK,
                'data' => json_decode($cityWeather)
            ];
        } else {
            return $this->getCityWeatherFromThirdParty($cityName, $cnt);
        }
    }

    /**
     * Get city weather by city name from openweathermap.org
     *
     * @param string $cityName
     * @return void
     */
    public function getCityWeatherFromThirdParty(string $cityName, int $cnt=40)
    {
        $client = new Client();
        $url = config('weather.host') . '?q=' . $cityName . '&cnt=' . $cnt . config('weather.fix_params') . config('weather.key');
        
        try {
            $response = $client->get($url);
            return [
                'status' => $response->getStatusCode(),
                'data' => $this->processData(json_decode($response->getBody()->getContents(), true)),
            ];
        } catch (ClientException $e) {
            //When the input city does not exist, it will use this.
            $errorContent = json_decode($e->getResponse()->getBody()->getContents(), true);
            return [
                'status' => $e->getResponse()->getStatusCode(), //404
                'message' => $errorContent['message'],
            ];
        } 
    }

    /**
     * Process weather data and return json to frontend, store data in database for cache at least a half hour
     * The return data will have 7 columns, these can be used to table columns if it needs in the future.
     * City, Country, Weather, Date, Temp, Wind, Clouds, Pressure
     * For example:
     * Auckland, NZ, Rain, 2019-09-27, 12.5°С to 13.6°С, 7.55m/s, 55%, 1015.89hpa
     *
     * @param array $weatherData
     * @return void
     */
    public function processData(array $weatherData)
    {
        $cityWeather = array();
        $cityWeather['city'] =  $weatherData['city']['name'];
        $cityWeather['country'] =  $weatherData['city']['country'];
        foreach($weatherData['list'] as $key => $dayWeather){
            if(date('H', $dayWeather['dt'])>=21){
                $cityWeather['list'][$key]['weather'] = $dayWeather['weather'][0]['main'];
                $cityWeather['list'][$key]['date'] = date('d/m/Y', $dayWeather['dt']);
                $cityWeather['list'][$key]['temp'] = $dayWeather['main']['temp_min'] . ' to ' . $dayWeather['main']['temp_max'] . '°С';
                $cityWeather['list'][$key]['wind'] = $dayWeather['wind']['speed'] . 'm/s';
                $cityWeather['list'][$key]['clouds'] = $dayWeather['clouds']['all'] . '%';
                $cityWeather['list'][$key]['pressure'] = $dayWeather['main']['pressure'] . 'hpa';
            }
        }

        $cityWeather['list'] = array_values($cityWeather['list']);//convert keys from 0 to 4
        Redis::set(strtolower($weatherData['city']['name']), json_encode($cityWeather), 'EX', config('database.redis.default.expire'));
        
        return $cityWeather;
    }
}