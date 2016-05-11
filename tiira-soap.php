<?php

/*
Tool to get data from Tiira-API (SOAP)

*/

// http://www.vankouteren.eu/blog/2009/03/simple-php-soap-example/

require_once "../../tiira-api.php";


$clientParams = Array();
$clientParams['login'] = $httpLogin;
$clientParams['password'] = $httpPassword;

$client = new SoapClient("http://www.tiira.fi/ws/ws/v2/soapserver.php?wsdl", $clientParams);


$params = Array();
$params['sovellusavain'] = $apiKey;
$params['tunnus'] = $username;
$params['varmenne'] = $password;

$params['kunta'] = "";
$params['nimi'] = "";
$params['yhdistys'] = "";

// print_r ($params);

$result = $client->haeTornit($params); // array('iTopN'=>5)

print_r ($result);

echo "\n<br />END";

