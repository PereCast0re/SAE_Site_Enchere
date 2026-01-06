<?php
header('Content-Type: application/json');

$name = $_GET['name'] ;
if (!$name) { echo json_encode([]); exit; }

$apiKey = "CYMbK9GilbPPoAmvjbtM/A==GOKwN2uEcMpxW2Br"; 
$url = "https://api.api-ninjas.com/v1/celebrity?name=" . urlencode($name);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ["X-Api-Key: $apiKey"]);
$response = curl_exec($ch);
curl_close($ch);

echo $response;
