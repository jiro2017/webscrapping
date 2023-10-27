<?php
require_once 'vendor/autoload.php';
/** Scapping webpages using Selenium based webdriver */
// use Facebook\WebDriver\Remote\RemoteWebDriver;
// use Facebook\WebDriver\Remote\DesiredCapabilities;
// $serverUrl = 'http://localhost:9515'; //'http://192.168.0.117:4444';
// Chrome
// $driver = RemoteWebDriver::create($serverUrl, DesiredCapabilities::chrome());
// //get the desired webpage
// $driver->get("https://www.konga.com/search?search=gas+cookers");

//quit the browsing session
// $driver->quit();

/** Scrapping webpages using Guzzle **/
$httpClient = new \GuzzleHttp\Client();
$response = $httpClient->get('https://www.amazon.com/s?k=gas+stove&crid=3S0IM7D9RAPY1&sprefix=gas+stov%2Caps%2C384&ref=nb_sb_noss_2');
// echo $response->getBody(); return;
$htmlString = (string) $response->getBody();
echo $htmlString; return;
//add this line to suppress any warnings
libxml_use_internal_errors(true);
$doc = new DOMDocument();
$doc->loadHTML($htmlString);
$xpath = new DOMXPath($doc);