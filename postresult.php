<?php
/*********************************************************
 * Author: John Astill
 * Date  : 31st December
 * File  : postresult.php
 * Desc  : Post a new result
 ********************************************************/
  require "systemvars.php";
  require "configvalues.php";
  require "sortfunctions.php";
  require "security.php";

  if ($User->loggedIn != TRUE) {
    $ip = $_SERVER["REMOTE_ADDR"];
    $port = $_SERVER["REMOTE_PORT"];
    $referer = $_SERVER["HTTP_REFERER"];
  
    logMsg("Attempt to post result by someone not logged in. Could be an attempt to break in. IP Address $ip port $port referring page $referer");
    forward("index.php"); 
    exit;   
  }

  $mid = $_POST["MID"];
  $homescore = $_POST["HOMESCORE"];
  $awayscore = $_POST["AWAYSCORE"];
  if (!CheckAdmin($User->usertype)) {
    LogMsg("User $User->username tried to post a result for match $mid $homescore v $awayscore");
    forward("index.php");
    exit;
  }
  
  // If the post is a success, go to the adminenterresult page.

  $link = OpenConnection();

  $query = "update $dbaseMatchData SET homescore=\"$homescore\", awayscore=\"$awayscore\" where matchid = '$mid' and lid='$leagueID'";
  $result = mysqli_query($link,$query)
      or die("Query failed: $query");

  CloseConnection($link);

  // Update the standings table.
  UpdateStandingsTable();

  /* Redirect browser to PHP web site */
  header("Location: adminenterresult.php?SID=$SID"); 
  exit; 
?>
