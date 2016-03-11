<?php

$sampledata = "[Amount][Type][Description]";

echo "Sample data = ".$sampledata;

echo "<br>";

$lastPos = 0;

// Find all First Brackets
$needle1 = "[";
$positions1 = array();
// Find all second Brackets
$needle2 = "]";
$positions2 = array();



// Array with all results with all first Brackets
while (($lastPos = strpos($sampledata, $needle1, $lastPos))!== false) {
    $positions1[] = $lastPos;
    $lastPos = $lastPos + strlen($needle1);
}

// Array with all results with all second Brackets
while (($lastPos = strpos($sampledata, $needle2, $lastPos))!== false) {
    $positions2[] = $lastPos;
    $lastPos = $lastPos + strlen($needle2);
}

if (count($positions1)==count($positions2)) {
	echo substr ($sampledata, $positions1[0]+1, $positions2[0]-1);
	echo "<br>";
	echo substr ($sampledata, $positions1[1]+1, ($positions2[1]-1)-$positions1[1]);
	echo "<br>";
	echo substr ($sampledata, $positions1[2]+1, ($positions2[2]-1)-$positions1[2]);
	echo "<br>";
}else{
	echo ":face_with_head_bandage: Please request with brackets";
}




?>