<?php
namespace Facebook\WebDriver;
require_once 'vendor/autoload.php';
/** Scapping webpages using Selenium based webdriver */
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;

$serverUrl = 'http://localhost:9515'; //'http://192.168.0.117:4444';
//Chrome
$driver = RemoteWebDriver::create($serverUrl, DesiredCapabilities::chrome());
//get the desired webpage
$query_url = "https://www.amazon.co.uk"; //"https://www.konga.com/search?search=gas+cookers";
ECHO<<<_INSTRUCTIONS
    <h1 style="text-align:center">Please solve the captcha (if any) within 30 seconds and wait for 30 seconds</h1>
_INSTRUCTIONS;
$driver->get($query_url);
sleep(30); //while the code sleeps it solves the captcha test if any one is presented by the website.
$driver->findElement(WebDriverBy::id("twotabsearchtextbox"))->sendKeys("Gas Stoves")->submit();
$cards = $driver->findElements(WebDriverBy::cssSelector("div.puis-list-col-right"));
foreach($cards as $card) {
    $title = $card -> findElement(WebDriverBy::cssSelector("div div div h2 a span"))->getText();
    $price = $card -> findElement(WebDriverBy::cssSelector("div.puisg-col-inner div div.puisg-row span.a-color-base"))->getText();
    echo <<<_END
    <h3 style='margin-bottom:0px'>$title</h3>
    <pstyle='margin-top:0px'>$price</p>
_END;
}
//quit the browsing session
//$driver->quit();

/** Scrapping webpages using Guzzle **/
// $httpClient = new \GuzzleHttp\Client(['cookies'=>false]);
// $response = $httpClient->get('https://www.amazon.com/s?k=gas+stove&crid=3S0IM7D9RAPY1&sprefix=gas+stov%2Caps%2C384&ref=nb_sb_noss_2');
// echo $response->getBody(); //return;
// $htmlString = (string) $response->getBody();
// // echo $htmlString; return;
// //add this line to suppress any warnings
// libxml_use_internal_errors(true);
// $doc = new DOMDocument();
// $doc->loadHTML($htmlString);
// $xpath = new DOMXPath($doc);

// $products = $xpath->evaluate('//div[@class="puisg-row"]');
// // var_dump($products); return;
// foreach($products as $product) {
//     $product_name = $product->evaluate("//div[@class='puis-list-col-right']//div//div//div//h2//a//span']")->textContent.PHP_EOL;
//     echo $product_name;
// }