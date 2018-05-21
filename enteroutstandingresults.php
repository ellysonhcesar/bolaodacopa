<?php
/*********************************************************
 * Author: John Astill
 * Date  : July 28 2003 (c)
 * File  : enteroutstandingresults.php
 * Desc  : Post a number of results
 ********************************************************/
  require "systemvars.php";
  require "configvalues.php";
  require "sortfunctions.php";
  require "security.php";

  if ($User->loggedIn != TRUE) {
    $ip = $_SERVER["REMOTE_ADDR"];
    $port = $_SERVER["REMOTE_PORT"];
    $referer = $_SERVER["HTTP_REFERER"];
  
    logMsg("Attempt to enter outstanding results by someone not logged in. Could be an attempt to break in. IP Address $ip port $port referring page $referer");
    forward("index.php"); 
    exit;   
  }

  // Make sure that the user is allowed to come here
  if (!CheckAdmin($User->usertype)) {
    // Forward to somewhere
    LogMsg("Attempt to enter outstanding results by User $User->userid with insufficient permissions from $REMOTE_ADDR:$REMOTE_PORT.");
    forward("index.php");
    exit;
  }

  $count = $_POST["COUNT"];

  $link = OpenConnection();

  // Loop through all the results.
  for ($i=0; $i < $count; $i++) {
    $mid = $_POST["MID$i"];
    $gf = $_POST["GF$i"];
    $ga = $_POST["GA$i"];

    if ($mid == "" or $ga == "" or $gf == "" ) {
      continue;
    } else {

      $query = "update $dbaseMatchData SET homescore='$gf', awayscore='$ga' where lid='$leagueID' and matchid='$mid'";
      $result = mysqli_query($link,$query)
        or die("Query failed: $query<br>".mysql_error());
    }
  }

  CloseConnection($link);

  // Update the standings table.
  UpdateStandingsTable();

  header("Location: adminenteroutstandingresults.php?sid=$SID"); 
?>
