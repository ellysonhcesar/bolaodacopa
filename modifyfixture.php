<?php
/*********************************************************
 * Author: John Astill (c) 2002
 * Date  : 3rd January 2002
 * File  : modifyfixture.php
 *       : Modifies the given fixture in the database.
 *       : Makes sure both the Match table and Prediction
 *       : table are updated.
 *********************************************************/
  require "systemvars.php";
  require "configvalues.php";
  require "sortfunctions.php";
  require "security.php";

  if ($User->loggedIn != TRUE) {
    $ip = $_SERVER["REMOTE_ADDR"];
    $port = $_SERVER["REMOTE_PORT"];
    $referer = $_SERVER["HTTP_REFERER"];
  
    logMsg("Attempt to modify a fixture by someone not logged in. Could be an attempt to break in. IP Address $ip port $port referring page $referer");
    forward("index.php"); 
    exit;   
  }

  // Security check, probably not necessary.
  if (!CheckAdmin($User->usertype)) {
    LogMsg("User $User->userid tried to modify fixtures without correct authority.\n");
    ErrorRedir("Only admin can do that!","index.php?sid=$SID");
  }

  $date = $_POST["DATE"];
  $time = $_POST["TIME"];
  if ($time == "") {
    $time = "00:00:00";
  }
  $datetime="$date $time";

  // Now allow for timezone offset.
  $datetime = RevTimeZoneOffset($datetime);

  $hometeam = $_POST["HOMETEAM"];
  $awayteam = $_POST["AWAYTEAM"];

  if ($hometeam == "") {
    ErrorRedir("The fixture was not correct, please enter a hometeam.","adminenterfixture.php?sid=$SID");
    exit;
  }

  if ($awayteam == "") {
    ErrorRedir("The fixture was not correct, please enter an awayteam.","adminenterfixture.php?sid=$SID");
    exit;
  }

  $matchid = $_POST["MATCHID"];

  // If the post is a success, go to the adminenterresult page.
  $link = OpenConnection();
  
  // change the fixture in the match data.
  $query = "update $dbaseMatchData set matchdate=\"$datetime\", hometeam=\"$hometeam\", awayteam=\"$awayteam\" where matchid=\"$matchid\" and lid='$leagueID'";
  $result = mysqli_query($link,$query)
      or die("Query failed changing the Match Data: $query");

  // Log the changes
  $rows = mysql_affected_rows();
  LogMsg("Modified fixture.\nUsed $query.\n$rows affected.");
  
  // Close the connection with the database.
  CloseConnection($link);

  /* Redirect browser to PHP web site */
  forward("adminenterfixture.php?sid=$SID"); 
?>
