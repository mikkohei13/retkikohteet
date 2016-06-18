<?php
header('Content-Type: text/html; charset=utf-8');

/*
Tool to get data from Tiira-API (SOAP)
Based on: http://www.vankouteren.eu/blog/2009/03/simple-php-soap-example/

Running this gets the latest data from the Tiira-API and saves it as a JSON file.
.../retkikohteet/tiira-soap.php?secret=SECRETKEY

*/

//require_once "../../retkikohteet-secret.php"; // development
require_once "../../retkikohteet-secret.php"; // production

if ($_GET['secret'] != $localSecret)
{
	exit("secret parameter needed");
}

$masterTowers = Array();

$clientOptions = Array();
$clientOptions['login'] = $httpLogin;
$clientOptions['password'] = $httpPassword;
$clientOptions['trace'] = TRUE; // records last request etc.

$client = new SoapClient($soapUrl, $clientOptions);

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

//print_r ($result); exit("Debug end"); // debug

saveTowersAsJSON($result);
//echoTowersAsTSV($result); // debug

echo "\n<br />END";


function saveTowersAsJSON($data)
{
	global $masterTowers; // data goes here

	$towersArr = $data->tornit->torni;

	foreach ($towersArr as $key => $tower)
	{
		// Numeric id's could cause unintended sorting
		$id = sha1($tower->paikka_id);

		// Skip dismantled towers
		if (strpos($tower->nimi, "purettu"))
		{
			continue;
		}
		elseif (strpos($tower->nimi, "lintutorni"))
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
		$masterTowers[$id]['name'] = handleName($tower->nimi);
		$masterTowers[$id]['society'] = $tower->yhdistys;
		$masterTowers[$id]['lat'] = substr($tower->n_wgs84, 0, 8);
		$masterTowers[$id]['lon'] = substr($tower->e_wgs84, 0, 8);
		$masterTowers[$id]['type'] = $type;
	}

	writeFile();
}

function handleName($name)
{
	if (strpos($name, "Mulkku") !== FALSE)
	{
		$name = str_replace("Mulkku", "Muikku", $name);
	}
	elseif (strpos($name, "Nyyn") !== FALSE)
	{
		$name = str_replace("Nyyn", "Nyn", $name);
	}
	elseif (strpos($name, "Saanatunturin") !== FALSE)
	{
		$name = str_replace("Saanatunturin", "Saanatunturi,", $name);
	}

	return $name;
}

function echoTowersAsTSV($data)
{
	$towersArr = $data->tornit->torni;
	foreach ($towersArr as $key => $tower)
	{
		echo 
			$tower->kunta . " " .
			$tower->nimi . "\t" .
			substr($tower->n_wgs84, 0, 8) . "\t" .
			substr($tower->e_wgs84, 0, 8) . "\t" .
			"wgs84" . "\n"
		;
	}
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




