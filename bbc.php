<?php

// TODO: [AH] add error handling
// TODO: [AH] have an expert review this code
class BBC
{
    public function getWeather()
    {
        $html = file_get_contents('http://www.bbc.com/');

        $dom = new DOMDocument();
        $dom->loadHTML($html);
        $xpath = new DOMXpath($dom);

        $maxtemps = $xpath->query("//*[@id='weather_forecast']/dl/dd/p[@class='temp max']/span[@class='value']");
        $mintemps = $xpath->query("//*[@id='weather_forecast']/dl/dd/p[@class='temp min']/span[@class='value']");

        $result = [];

        $this->addToResult($result, $maxtemps, "max");
        $this->addToResult($result, $mintemps, "min");

        return $result;
    }

    private function addToResult(&$result, $temps, $key)
    {
        foreach ($temps as $temp) {
            $dayNode = $temp->parentNode->parentNode->previousSibling->previousSibling;
            $day = trim($dayNode->nodeValue);
            $result[$day][$key] = trim($temp->nodeValue);
        }
    }
}

$bbcClient = new BBC();
$weather = $bbcClient->getWeather();

var_dump($weather);
