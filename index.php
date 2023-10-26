<?php
require_once 'vendor/autoload.php';
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
$serverUrl = 'http://localhost:9515'; //'http://192.168.0.117:4444';
// Chrome
$driver = RemoteWebDriver::create($serverUrl, DesiredCapabilities::chrome());
//get the desired webpage
$driver->get("https://www.konga.com/search?search=gas+cookers");

//quit the browsing session
// $driver->quit();