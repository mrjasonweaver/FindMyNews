<?php
$path = (isset($_POST['path'])) ? $_POST['path'] : $_GET['path'];
$url = $path;
 
// Open the Curl session
$session = curl_init($url);
 
// If it's a POST, put the POST data in the body
if (isset($_POST['path'])) {
	$postvars = '';
	while ($element = current($_POST)) {
		$postvars .= urlencode(key($_POST)).'='.urlencode($element).'&';
		next($_POST);
	}
	curl_setopt ($session, CURLOPT_POST, true);
	curl_setopt ($session, CURLOPT_POSTFIELDS, $postvars);
}
 
// Don't return HTTP headers. Do return the contents of the call
curl_setopt($session, CURLOPT_HEADER, false);
curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
 
// Make the call
$xml = curl_exec($session);
 
// does the service return XML or JSON? Set the Content-Type appropriately
$headerType = (isset($_POST['type'])) ? $_POST['type'] : $_GET['type'];
// 'text/xml' or 'application/json'
$headerType = ($headerType) ? $headerType : 'text/xml';//default
header("Content-Type: " . $headerType);
 
echo $xml;
curl_close($session);
?>
