<?php
/**
 * Created by PhpStorm.
 * User: APersinger
 * Date: 06/01/15
 * Time: 11:09 AM
 *
 * This is all I want to test...to list all of a users' droplets
 * curl -X GET "https://api.digitalocean.com/v2/droplets" \
 *  -H "Authorization: Bearer $TOKEN"
 *
 */

$headers = array();
/*
$headers[] = 'X-Apple-Tz: 0';
$headers[] = 'X-Apple-Store-Front: 143444,12';
$headers[] = 'Accept-Encoding: gzip, deflate';
$headers[] = 'Accept-Language: en-US,en;q=0.5';
$headers[] = 'Cache-Control: no-cache';
$headers[] = 'Host: www.example.com';
$headers[] = 'Referer: http://www.example.com/index.php'; //Your referrer address
$headers[] = 'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:28.0) Gecko/20100101 Firefox/28.0';
$headers[] = 'X-MicrosoftAjax: Delta=true';
*/

//WORKS

$headers[] = "Authorization: Bearer a4e499fda53d88a02982bfa00333dc9bd811e5010bf0d4771e3006e62b4bcda9";
$headers[] = 'Content-Type: application/json';
$url_to_exec = "https://api.digitalocean.com/v2/droplets";

$ch = curl_init();
curl_setopt_array($ch, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => $url_to_exec,
    CURLOPT_HTTPHEADER => $headers
));
$result = curl_exec($ch);
curl_close($ch);



echo $result;
