<?php

/*
Tool to get data from Tiira-API (SOAP)

*/

// http://www.vankouteren.eu/blog/2009/03/simple-php-soap-example/

require_once "../../tiira-api.php";
if ($_GET['secret'] != $localSecret)
{
	exit("secret parameter needed");
}

$masterTowers = Array();

$clientOptions = Array();
$clientOptions['login'] = $httpLogin;
$clientOptions['password'] = $httpPassword;
$clientOptions['trace'] = TRUE;

$client = new SoapClient("http://testi.tiira.fi/ws/ws/v2/soapserver.php?wsdl", $clientOptions);

$params = Array();
$params['sovellusavain'] = $apiKey;
$params['tunnus'] = $username;
$params['varmenne'] = $auth;

$params['kunta'] = "";
$params['nimi'] = "";
$params['yhdistys'] = "";

// print_r ($params);

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

//print_r ($result); // debug

saveTowersAsJSON($result);


echo "\n<br />END";


function saveTowersAsJSON($data)
{
	global $masterTowers; // data goes here

	// Numeric id's could cause unintended sorting
	$towersArr = $data->tornit->torni;

	foreach ($towersArr as $key => $tower)
	{
		$id = sha1($tower->paikka_id);

		if (strpos($tower->nimi, "lintutorni"))
		{
			$type = "lintutorni";
		}
		elseif (strpos($tower->nimi, "näkötorni") || strpos($tower->nimi, "näköalatorni"))
		{
			$type = "näkötorni";
		}
		elseif (strpos($tower->nimi, "vesitorni"))
		{
			$type = "vesitorni";
		}
		elseif (strpos($tower->nimi, "lava"))
		{
			$type = "lava";
		}
		else
		{
			$type = "tuntematon";
		}

		$masterTowers[$id]['muni'] = $tower->kunta;
		$masterTowers[$id]['name'] = $tower->nimi;
		$masterTowers[$id]['society'] = $tower->yhdistys;
		$masterTowers[$id]['lat'] = substr($tower->n_wgs84, 0, 8);
		$masterTowers[$id]['lon'] = substr($tower->e_wgs84, 0, 8);
		$masterTowers[$id]['type'] = $type;
	}

	writeFile(); // debug
}

function writeFile()
{
	global $masterTowers; // data to be written
	global $localSecret; // to hide the full json file

	$json = json_encode($masterTowers);

	if ($json === FALSE)
	{
		echo "JSON encoding failed!";
	}

	$filename = ("data-" . $localSecret . "/towers-autogenerated.json");
	file_put_contents($filename, $json);

	header('Content-Type: text/html; charset=utf-8');
//	print_r (masterTowers); // debug
	echo "Data written to $filename";
}




