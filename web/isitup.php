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
$lastPos = 0;
$needle1 = "[";
$needle2 = "]";
$positions1 = array();
$positions2 = array();

# Check the token and make sure the request is from our team 
  if($token != 'iuI46C6PFcsuBcBEIcScZ4UZ'){ #replace this with the token from your slash command configuration page
    
    $msg = "The token for the slash command doesn't match. You are not able to use the service.";
    die($msg);
    echo $msg;

  }else{

    // Array with all results with all first Brackets
    while (($lastPos = strpos($text, $needle1, $lastPos))!== false) {
      $positions1[] = $lastPos;
      $lastPos = $lastPos + strlen($needle1);
    }

    // Array with all results with all second Brackets
    while (($lastPos = strpos($text, $needle2, $lastPos))!== false) {
      $positions2[] = $lastPos;
      $lastPos = $lastPos + strlen($needle2);
    }

    if (count($positions1)==count($positions2)) {
    
      // echo substr ($text, $positions1[0]+1, $positions2[0]-1);
      // echo "<br>";
      // echo substr ($text, $positions1[1]+1, ($positions2[1]-1)-$positions1[1]);
      // echo "<br>";
      // echo substr ($text, $positions1[2]+1, ($positions2[2]-1)-$positions1[2]);
      // echo "<br>";

      $jsonData = [
            "response_type" => "in_channel",//if you want to set this message to private
            "text" => substr ($text, $positions1[0]+1, $positions2[0]-1)." has been added to your expenses !!",
            'attachments' => [[
              'text' => 'table count here',
              'color' => '#F35A00'  
          ]]//end attachments
      ];
      
      //Initiate cURL.
      $ch = curl_init($responseurl);

      //Encode the array into JSON.
      $jsonDataEncoded = json_encode($jsonData);
         
      //Tell cURL that we want to send a POST request.
      curl_setopt($ch, CURLOPT_POST, 1);
         
      //Attach our encoded JSON string to the POST fields.
       curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
         
      //Set the content type to application/json
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
         
      //Execute the request
      $result = curl_exec($ch);

      //DB File creation

      #1 if file not existing then create it

      $fp = fopen('./'.$token.'.json', 'w');
      fwrite($fp, $jsonDataEncoded);
      fclose($fp);

      #2 if file existing then update it

  }else{
    echo ":face_with_head_bandage: Please request with brackets";
  }

}//End token validation
?>