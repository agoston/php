<?php
$html = file_get_contents('http://www.bbc.com/');
$dom = new DOMDocument();
$dom->loadHTML($html);
$div = $dom->getElementById('weather');

$content = $dom->saveHTML($div);
print($content);