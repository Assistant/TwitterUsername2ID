<?php
if(!isset($_POST['input'])) {
  http_response_code(400); 
  exit;
}
$API_URL = 'https://api.twitter.com/2/users/by/username/';
$username = preg_replace("/[^a-zA-Z0-9_]/", "", $_POST['input']);

include './credentials.php';
include './utils.php';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "$API_URL$username");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Bearer $bearer_token"));
$result = json_decode(curl_exec($ch));
curl_close($ch);

if(property_path_exists($result, 'data->id')){
  echo($result->data->id);
} elseif (property_path_exists($result, 'error->title')) {
  http_response_code(400); 
  exit;
} else {
  http_response_code(500);
  exit;
}
?>