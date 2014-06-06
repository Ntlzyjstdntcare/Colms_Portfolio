<?php
//This hides any harmless notices that may get sent to the JavaScript with the XML
error_reporting(E_ALL ^ E_NOTICE);

//This code stores the value of the string entered by the user into the search bar, in a variable.
//AJAX has retrieved it from the webpage and sent it to this script.
$tag = $_GET["tag"];

//Here we concatenate the entered search term onto the base URL of Flickr feeds, and store the resulting
//string in a variable
$feedUrl = 'http://api.flickr.com/services/feeds/photos_public.gne?tags='.$tag;

//We grab the XML file at the above URL and store it in a variable
$xml = simplexml_load_file($feedUrl);

//We echo the XML file to our JavaScript file, where it will be parsed and displayed on the webpage
header('Content-Type: text/xml');
echo $xml->asXML();

?>