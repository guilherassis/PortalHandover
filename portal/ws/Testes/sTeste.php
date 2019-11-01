<?php

require_once("lib/nusoap.php");
$server = new soap_server;
$server->register('teste');
        function teste($name) {
                return $name;
        }

$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ?
$HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);

?>