<?php 
/*********************************************************
 * Author: John Astill
 * Date  : 25th Feb 2003 (c)
 * File  : updatemypredictions.php
 * Desc  : Allow the user to update the predictions.
 ********************************************************/
require "systemvars.php";
require "configvalues.php";
require "sortfunctions.php";
require "security.php";

$numrows = $_POST["NUMROWS"];
$userid = $User->userid;

if ($User->loggedIn == FALSE) {
  $ip = $_SERVER["REMOTE_ADDR"];
  $port = $_SERVER["REMOTE_PORT"];
  $referer = $_SERVER["HTTP_REFERER"];
  
  LogMsg("Attempt by user not logged in to make predictions. This could be a spoofed page. IP Address $ip port $port referring page "); 
  forward("index.php");
  exit;
}

$link = OpenConnection();

for ($i=0; $i<$numrows; $i++) {
  // Make sure the user is not trying to cheat in predicting late.
  $key = "MATCHDATE$i";
  if (array_key_exists($key, $_POST) == false) {
    continue;
  }
  
  $date = $_POST[$key];
  if (CompareDatetime(date("Y-m-d H:i:s",strtotime($date)-$HoursToShow*60*60)) < 0) {
    continue;
  }

  $matchid = $_POST["MATCHID$i"];
  $gfor = $_POST["GFOR$i"];
  $gagainst = $_POST["GAGAINST$i"];

  if (FALSE == is_numeric($gfor)) {
    continue;
  }

  if (FALSE == is_numeric($gagainst)) {
    continue;
  }

  //$query = "REPLACE INTO $dbasePredictionData SET userid=\"$userid\", matchid=\"$matchid\", homescore=\"$gfor\", awayscore=\"$gagainst\",lid='$leagueID'";
  $query = "REPLACE INTO $dbasePredictionData SET userid=\"$userid\", matchid=\"$matchid\", homescore=?, awayscore=?,lid='$leagueID'";
  
  $stmt = mysqli_prepare($link,$query);
  mysqli_stmt_bind_param($stmt,"ss", $gfor, $gagainst);
  mysqli_stmt_execute($stmt);
}

CloseConnection($link);

forward("showmypredictions.php?sid=".$SID);
?>

