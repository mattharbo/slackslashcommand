<?php

/*

REQUIREMENTS

* A custom slash command on a Slack team
* A web server running PHP5 with cURL enabled

*/

# Grab some of the values from the slash command, create vars for post back to Slack
$command = $_POST['command'];
$text = $_POST['text'];
$token = $_POST['token'];
$responseurl=$_POST["response_url"];
$username=$_POST["user_name"];

# Check the token and make sure the request is from our team 
  if($token != 'iuI46C6PFcsuBcBEIcScZ4UZ'){ #replace this with the token from your slash command configuration page
    $msg = "The token for the slash command doesn't match. You are not able to use the service.";
    die($msg);
    echo $msg;
  }

//Initiate cURL.
  $ch = curl_init($responseurl);

  $jsonData = [
      "response_type" => "in_channel",
      "text" => $token,
      'attachments' => [[
        'text' => 'table count here',
        'color' => '#F35A00'  
    ]]//end attachments
  ];
   
  //Encode the array into JSON.
  $jsonDataEncoded = json_encode($jsonData);
   
  //Tell cURL that we want to send a POST request.
  curl_setopt($ch, CURLOPT_POST, 1);
   
  //Attach our encoded JSON string to the POST fields.
  curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
   
  //Set the content type to application/json
  //curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
   
  //Execute the request
  $result = curl_exec($ch);

?>