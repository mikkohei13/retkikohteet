<?php

// Class that returns nearest towers as JSON

$towers = new TowersAPI();

class TowersAPI {

	var $lat;
	var $lon;

	function __construct()
	{
		$this->lat = $_GET['lat'];
		$this->lon = $_GET['lon'];

		$this->dataSecurity();
	}

	public function dataSecurity()
	{
		if (! is_numeric($this->lat) || ! is_numeric($this->lon))
		{
			$data['error'] = "Coordinates given are not numeric";
			$this->sendData($data);
			exit();
		}
	}

	public function sendData($data)
	{
		$json = json_encode($data);
		header('Content-Type: application/json');
		echo $json;
	}


}
