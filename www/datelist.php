<?php
error_reporting(E_ERROR | E_PARSE);
require_once "nusoap/nusoap.php";

function getProd($rdate) {
    $dates = array
    (
        '0'=> "2014-07-29 05:14:54",
        '1'=> "2014-08-03 01:44:03",
        '2'=> "2014-08-16 16:25:07",
        '3'=> "2014-09-29 02:00:15",
        '4'=> "2014-09-25 18:33:45" 
    );
   
    $place = "";
  
    function find_closest_date($array, $date)
    {
           $places = array
        (
            '0'=> "Yverdon",
            '1'=> "Neuchâtel",
            '2'=> "Yverdon",
            '3'=> "Neuchâtel",
            '4'=> "Yverdon" 
        );
  
        foreach($array as $day)
        {
                $interval[] = abs(strtotime($date) - strtotime($day));
        }
        asort($interval);
        $closest = key($interval);
        $place = $places[$closest];
        return [$array[$closest], $place];
    }
  
    $closest_date = find_closest_date($dates, $rdate);
    return $closest_date[0] . "," . $closest_date[1];
}

$server = new soap_server();
$server->configureWSDL("datelist", "urn:datelist");
 
$server->register("getProd",
    array("date" => "xsd:string"),
    array("return" => "xsd:string"),
    "urn:datelist",
    "urn:datelist#getProd",
    "rpc",
    "encoded",
    "Get closest date");
 
$server->service($HTTP_RAW_POST_DATA);
