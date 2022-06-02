<?php

class OpenWeather
{
    private $apiKey;


    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;

    }
    public function callApi($endpoint)
    {

        $curl = curl_init("https://api.openweathermap.org/data/2.5/{$endpoint}&appid={$this->apiKey}&units=metric&lang=fr");
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CAINFO => dirname(__DIR__) . DIRECTORY_SEPARATOR . 'cert.cer',
            CURLOPT_TIMEOUT => 1
        ]);
        $data = curl_exec($curl);
        if ($data === false || curl_getinfo($curl, CURLINFO_HTTP_CODE) !== 200) {
            return null;

        }
        return json_decode($data, true);

    }

    public function getToday($city):array{
        $data = $this->callApi("weather?q={$city}");
        return [
        'temp' => $data['main']['temp'],
        'description' => $data['weather'][0]['description'],
        'date' => new DateTime()
        ];
}

    public function getForecast($city)
    {
        $data = $this->callApi("forecast/daily?q={$city}");
        foreach ($data['list'] as $day) {
            $result = [
                'temp' => $day['temp']['day'],
                'description' => $day['weather'][0]['description'],
                'date' => new DateTime('@' . $day['dt'])
            ];
        }
        return $result;
    }


}