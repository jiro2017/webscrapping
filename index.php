<?php

// echo $_SERVER['HTTP_USER_AGENT'];
// return;
$url = "https://www.jiropages.com";
$handler = curl_init($url);
$headers = array(
    "Content-Language: en",
    "User-Agent : Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:109.0) Gecko/20100101 Firefox/118.0"
);
curl_setopt($handler, CURLOPT_HEADER, 0);
curl_setopt($handler, CURLOPT_HTTPHEADER, $headers);
curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($handler, CURLOPT_PROXY, "102.68.128.214"); 
// curl_setopt($handler, CURLOPT_PROXYPORT, "8080"); 
// curl_setopt($handler, CURLOPT_PROXY, CURLPROXY_HTTP);

$result = curl_exec($handler);
curl_close($handler);

echo $result;