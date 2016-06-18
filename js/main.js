
// Based on code by Ian Devlin
// http://html5doctor.com/finding-your-position-with-geolocation/

document.addEventListener("DOMContentLoaded", determineLocation);

function determineLocation(event)
{
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
      handlePosition, 
      displayError,
      {
        enableHighAccuracy: true,
        timeout: 60000, // ms
        maximumAge: 30000 // ms
      }
    );
    $( "#error-container" ).html( "<div>Sijaintiasi haetaan...</div>" );  
  }
  else {
    $( "#error-container" ).html( "<div>Selaimesi ei valitettavasti tue paikannusta.</div>" );
    console.log("navigator.geolocation not supported");

    logData.error = "not supported";
//    logger();

  }

  function handlePosition(position) {
    if (position.coords.accuracy > 500)
    {
      var accuracyRounded = math.round((position.coords.accuracy / 1000));
      $( "#message-container" ).html( "<div>Tarkkaa sijaintiasi ei saatu selville, joten etäisyydet torneihin eivät ole tarkkoja. Jos käytät tietokonetta, kokeile mielummin älypuhelimella jossa on GPS! <span class='additional'>(virhesäde " + accuracyRounded + " m)</span></div>" );

      logData.error = "inaccurate";
    }

    logData.accuracy = position.coords.accuracy;
    logData.altitude = position.coords.altitude;
    logData.altitudeAccuracy = position.coords.altitudeAccuracy;
    logData.latitude = position.coords.latitude;
    logData.longitude = position.coords.longitude;

    $.getJSON(
      (rootUrl + "api/?data=towers&lat=" + position.coords.latitude + "&lon=" + position.coords.longitude),
      updatePage
    );

    console.log(position);
  }

  // This is the meat
  function updatePage(towersJSON)
  {
      console.log(towersJSON);
      console.log("Success!");
      $( "#error-container" ).html("");

      // Update list
      var towerHTML;
      var distance;
      var maplink;
      for(var towerID in towersJSON)
      {
           console.log(towerID);

           distance = Math.round(towersJSON[towerID].distance / 1000);

           towerHTML = towersJSON[towerID].muni + ", " + towersJSON[towerID].name + " " + distance + " km";
           maplink = "<a href='https://www.google.fi/maps/dir/" + logData.latitude + "," + logData.longitude + "/" + towersJSON[towerID].lat + "," + towersJSON[towerID].lon + "/'>reitti</a>";

           console.log(towersJSON[towerID].muni);
           console.log(towersJSON[towerID].tower);
           console.log(towersJSON[towerID].distance);

          $("#towers").append("<li>" + towerHTML + " " + maplink + "</li>");

      }


//      $( "#main-container" ).load( "allspecies.php?grid=" + towersJSON.N + ":" + towersJSON.E );

//      logData.N = towersJSON.N;
//      logData.E = towersJSON.E;
      logData.error = "success";
//      logger();
  }

  function displayError(error) {
    var errors = { 
      1: 'Olet kieltänyt paikannustiedon käytön selaimessa tai käyttöjärjestelmässä. Salli se ja yritä uudelleen.',
      2: 'Sijaintia ei pystytty hakemaan. Siirry paikkaan, josta on esteettömämpi näkymä taivaalle.',
      3: 'Sijainnin hakeminen kesti liian kauan. Tarkista että puhelimesi paikannustoiminto on päällä.'
    };
    console.log(errors[error.code]);
    $( "#error-container" ).html("<div>" + errors[error.code] + "</div>");

    logData.error = "error " + error.code;
//    logger();
  }

  /*
      1: 'Permission denied',
      2: 'Position unavailable',
      3: 'Request timeout'
  */
}

function logger()
{
  logData.userAgent = navigator.userAgent;
  logData.innerHeight = window.innerHeight;
  logData.innerWidth = window.innerWidth;

//  console.log(navigator);
//  console.log(window);

/*
  $.post( "logger.php", logData, function( loggerResponse ) {
    console.log(loggerResponse);
  });
*/
}

// Help link
$( "#helplink" ).click(function() {

  $( "#help-container" ).slideToggle( 200, function() {
    console.log("Help slided open");
  });


});
