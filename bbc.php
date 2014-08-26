<?php
class WeatherInfo {
    public $day;
    public $min;
    public $max;
}


class BBC
{
    public function getWeather()
    {
        $html = file_get_contents('http://www.bbc.com/');

        $dom = new DOMDocument();
        $dom->loadHTML($html);
        $xpath = new DOMXpath($dom);

        $days = $xpath->query("//*[@id='weather_forecast']/dl/dt");
        $maxtemps = $xpath->query("//*[@id='weather_forecast']/dl/dd[*]/p[@class='temp min']/span[@class='value']");
        $mintemps = $xpath->query("//*[@id='weather_forecast']/dl/dd[*]/p[@class='temp max']/span[@class='value']");

        $result = array();

        for ($i = 0; $i < $days->length; $i++) {
            $weatherInfo = new WeatherInfo();
            $weatherInfo->day = trim($days->item($i)->nodeValue);
            $weatherInfo->min = trim($mintemps->item($i)->nodeValue);
            $weatherInfo->max = trim($maxtemps->item($i)->nodeValue);
            $result[] = $weatherInfo;
        }

        return $result;
    }
}

$bbcClient = new BBC();
$weather = $bbcClient->getWeather();

var_dump($weather);
