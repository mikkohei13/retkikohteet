<?php

/*
Tool to get data from Tiira-API (SOAP)

*/

// http://www.vankouteren.eu/blog/2009/03/simple-php-soap-example/

require_once "../../tiira-api.php";


$clientOptions = Array();
$clientOptions['login'] = $httpLogin;
$clientOptions['password'] = $httpPassword;
$clientOptions['trace'] = TRUE;

$client = new SoapClient("http://www.tiira.fi/ws/ws/v2/soapserver.php?wsdl", $clientOptions);

$params = Array();
$params['sovellusavain'] = $apiKey;
$params['tunnus'] = $username;
$params['varmenne'] = $auth;

$params['kunta'] = "";
$params['nimi'] = "";
$params['yhdistys'] = "";

print_r ($params);

try
{
	$result = $client->haeTornit($params); // array('iTopN'=>5)
}
catch (Exception $e)
{
    echo 'Caught exception: ',  $e->getMessage(), "\n";
	echo "REQUEST:\n" . $client->__getLastRequest() . "\n";
	echo "REQUEST HEADERS:\n" . $client->__getLastRequestHeaders() . "\n";
	echo "RESPONSE:\n" . $client->__getLastRequest() . "\n";
	echo "RESPONSE HEADERS:\n" . $client->__getLastResponseHeaders() . "\n";

}

print_r ($result);


echo "\n<br />END";

