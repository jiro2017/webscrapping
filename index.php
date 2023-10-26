<?php
require_once 'vendor/autoload.php';
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
$serverUrl = 'http://localhost:9515';
// Chrome
$driver = RemoteWebDriver::create($serverUrl, DesiredCapabilities::chrome());
$driver->get("https://www.google.com");