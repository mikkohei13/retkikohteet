<?php


/*
Parses data from Garmin navigator file:
20.17920, 59.96930, "Lemland, Herröskatan"
20.60189, 60.02766, "Föglö, Hastersboda"
20.53805, 60.08624, "Föglö, Jyddö"

File source: http://rslh.info/index.php?option=com_content&view=article&id=48&Itemid=60

*/

$filename = "rawdata/tornit.csv";

$dataString = file_get_contents($filename);

$dataRows = explode("\n", $dataString);

foreach ($dataRows as $key => $row) {
	handleTower($row);
}

function handleTower($row)
{
	$cells = explode(",", $row);

	$lon = trim($cells[0]);
	$lat = trim($cells[1]);

	$muni = trim($cells[2]);
	@$tower = trim($cells[3]); // suppressed errors from missing comma between muni and tower

	$tempMuni = trim($muni, "\"");
	$tempTower = trim($tower, "\"");
	$tempLocation = $tempMuni . " " . $tempTower;
	$firstWhitespace = strpos($tempLocation, " ");
	$muni = substr($tempLocation, 0, $firstWhitespace);
	$tower = substr($tempLocation, $firstWhitespace);

	// create an id based on name
	$id = sha1(($muni . $tower));

	saveTower($id, $lat, $lon, $muni, $tower);
}

function saveTower($id, $lat, $lon, $muni, $tower)
{
	echo "$id / $lat / $lon / $muni / $tower <br />\n";
}



