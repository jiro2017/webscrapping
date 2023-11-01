<?php
namespace Facebook\WebDriver;
ini_set("display_errors", "1");
require_once 'vendor/autoload.php';
/** Scapping webpages using Selenium based webdriver */
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$serverUrl = 'http://localhost:9515'; //'http://192.168.0.117:4444';
//Chrome
$driver = RemoteWebDriver::create($serverUrl, DesiredCapabilities::chrome());
//get the desired webpage
$query_url = "https://www.amazon.co.uk"; //"https://www.konga.com/search?search=gas+cookers";
// ECHO<<<_INSTRUCTIONS
//     <h1 style="text-align:center">Please solve the captcha (if any) within 30 seconds and wait for 30 seconds</h1>
// _INSTRUCTIONS;
$driver->get($query_url);
sleep(30); //while the code sleeps it solves the captcha test if any one is presented by the website.
$driver->findElement(WebDriverBy::id("twotabsearchtextbox"))->sendKeys("Quantum Mechanics")->submit();
$cards = $driver->findElements(WebDriverBy::cssSelector("div.puis-list-col-right"));
if(count($cards)==0) {
    $cards = $driver->findElements(WebDriverBy::cssSelector("div.s-result-item.s-asin"));
    $small_cards = true;
} else {
    $small_cards =false;
}

$data = array("titles" => array(), "prices" => array());
foreach($cards as $card) {
    global $data;
    if($small_cards) {
        $title = $card -> findElement(WebDriverBy::cssSelector("div.s-title-instructions-style h2 a span"))->getText();
        try {
            $price = $card -> findElement(WebDriverBy::cssSelector("div.s-price-instructions-style div a span"))->getText();
        } catch(\Exception $e) {
            $price = "No Offers";
        }
    } else {
        $title = $card -> findElement(WebDriverBy::cssSelector("div div div h2 a span"))->getText();
        $price_symbol = $card -> findElement(WebDriverBy::cssSelector("span.a-price span.a-price-symbol"))->getText();
        $price_whole = $card -> findElement(WebDriverBy::cssSelector("span.a-price span.a-price-whole"))->getText();
        $price_fraction = $card -> findElement(WebDriverBy::cssSelector("span.a-price span.a-price-fraction"))->getText();
        $price = $price_symbol.$price_whole.".".$price_fraction;
    }
    $data["titles"][]=$title;
    $data["prices"][]=$price;
//     echo <<<_END
//     <h3 style='margin-bottom:0px'>$title</h3>
//     <pstyle='margin-top:0px'>$price</p>
// _END;
}

$spreadsheet = new Spreadsheet();
$activeWorksheet = $spreadsheet->getActiveSheet();
$activeWorksheet->setCellValue("A1", "Title");
$activeWorksheet->setCellValue("B1", "Price");

$title_row_count = 2;
$max_titles = count($data['titles']);
while($title_row_count <= $max_titles) {
    $activeWorksheet = $spreadsheet->getActiveSheet();
    $activeWorksheet->setCellValue("A$title_row_count", $data['titles'][$title_row_count -2]);
    $title_row_count++;
}

$price_row_count = 2;
$max_prices = count($data['prices']);
while($price_row_count <= $max_titles) {
    $activeWorksheet = $spreadsheet->getActiveSheet();
    $activeWorksheet->setCellValue("B$price_row_count", $data['prices'][$price_row_count -2]);
    $price_row_count++;
}

$writer = new Xlsx($spreadsheet);
$writer->save('amazon_products_books.xlsx');
echo <<<_STATUS
    <h1>Data scrapped and saved in Excel file successfully.</h1>
_STATUS;
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