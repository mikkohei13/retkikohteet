<?php

// http://www.vankouteren.eu/blog/2009/03/simple-php-soap-example/

$client = new SoapClient("http://www.tiira.fi/ws/ws/v2/soapserver.php?wsdl");
$result = $client->haeTornit(); // array('iTopN'=>5)

print_r ($result);

echo "\n<br />END";

