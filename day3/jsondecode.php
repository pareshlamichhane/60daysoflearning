<?php
$json = '{"name":"Paresh","balance":1349,"city":"Bharatpur"}';
$data = json_decode($json, true);
echo "Name: " . $data["name"] . ", Balance: " . $data["balance"];
?>