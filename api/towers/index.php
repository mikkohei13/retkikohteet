<?php

// Class that returns nearest towers as JSON

$towers = new TowersAPI();

class TowersAPI {

	var $lat;
	var $lon;
	var $towersArray;

	function __construct()
	{
		$this->lat = $_GET['lat'];
		$this->lon = $_GET['lon'];

		$this->dataSecurity();

		$towersJSON = file_get_contents("../../towers-autogenerated.json");
		$this->towersArray = json_decode($towersJSON, TRUE);

		$this->preFilterTowers();
		$this->calculateDistancesToTowers();
		$this->filterToNearest(15);

//		print_r ($this->towersArray); // debug

		$this->sendData($this->towersArray);
	}

	// Purpose of this to speed things up by not sending all the towers to Haversine calculation
	public function preFilterTowers()
	{
		$thresholdDegrees = 1; // >=1 seems to be good value for sparsely towered ares in Finland, resulting in about 10 towers

		foreach ($this->towersArray as $id => $tower)
		{
			if (
				$tower['lat'] > ($this->lat + $thresholdDegrees) ||
				$tower['lat'] < ($this->lat - $thresholdDegrees) ||
				$tower['lon'] > ($this->lon + $thresholdDegrees) ||
				$tower['lon'] < ($this->lon - $thresholdDegrees)
			)
			{
				unset($this->towersArray[$id]);
			}

		}
	}

	public function calculateDistancesToTowers()
	{
		foreach ($this->towersArray as $id => $tower)
		{
			$distance = $this->haversine($this->lat, $this->lon, $tower['lat'], $tower['lon']);
			$this->towersArray[$id]['distance'] = $distance;
		}
	}

	public function filterToNearest($limit = 10)
	{
		uasort($this->towersArray, function($a, $b) {
    		return $a['distance'] - $b['distance'];
		});

		$this->towersArray = array_slice($this->towersArray, 0, $limit, TRUE);
	}

	/**
	 * Calculates the great-circle distance between two points, with
	 * the Haversine formula.
	 * martinstoeckli / http://stackoverflow.com/posts/14751773/revisions
	 * @param float $latitudeFrom Latitude of start point in [deg decimal]
	 * @param float $longitudeFrom Longitude of start point in [deg decimal]
	 * @param float $latitudeTo Latitude of target point in [deg decimal]
	 * @param float $longitudeTo Longitude of target point in [deg decimal]
	 * @param float $earthRadius Mean earth radius in [m]
	 * @return float Distance between points in [m] (same as earthRadius)
	 */
	public function haversine($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
	{
	  // convert from degrees to radians
	  $latFrom = deg2rad($latitudeFrom);
	  $lonFrom = deg2rad($longitudeFrom);
	  $latTo = deg2rad($latitudeTo);
	  $lonTo = deg2rad($longitudeTo);

	  $latDelta = $latTo - $latFrom;
	  $lonDelta = $lonTo - $lonFrom;

	  $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) + cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
	  $distance = $angle * $earthRadius;
	  $distance = round($distance, 0);
	  return $distance;
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
