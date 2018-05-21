<?php
/*********************************************************
 * Author: John Astill (c)
 * Date  : 3rd January 2002
 * File  : addfixture.php
 *       : DATETIME format YYYY-MM-DD HH:MM:SS
 *********************************************************/
  require "systemvars.php";
  require "configvalues.php";
  require "sortfunctions.php";
  require "security.php";

  // Make sure the user trying to add the fixture is admin
  // an admin or above.
  if (!CheckAdmin($User->usertype)) {
    // Forward to somewhere
    LogMsg("Attempt to add Fixture by User $User->userid with insufficient permissions from $REMOTE_ADDR:$REMOTE_PORT.");
    ErrorRedir("Only admin can do that!","index.php?sid=$SID");
  }

  $date = $_POST["DATE"];
  $time = $_POST["TIME"];
  if ($time == "") {
    $time = "00:00:00";
  }
  $datetime="$date $time";

  // Now allow for timezone offset.
  $datetime = RevTimeZoneOffsetNo24Hour($datetime);

  $hometeam = addslashes($_POST["HOMETEAM"]);
  $awayteam = addslashes($_POST["AWAYTEAM"]);

  if ($hometeam == "") {
    ErrorRedir("The fixture was not correct, please enter a hometeam.","adminenterfixture.php?sid=$SID");
    exit;
  }

  if ($awayteam == "") {
    ErrorRedir("The fixture was not correct, please enter an awayteam.","adminenterfixture.php?sid=$SID");
    exit;
  }

  // If the post is a success, go to the adminenterresult page.
  $link = OpenConnection();
  $query = "insert into $dbaseMatchData (lid,matchdate,hometeam,awayteam) VALUES ('$leagueID','$datetime','$hometeam','$awayteam')";
  $result = mysqli_query($link,$query)
      or die("Query failed: $query");

  // Log the addition
  LogMsg("Added fixture $date $time $hometeam $awayteam.\n$query");

  CloseConnection($link);

  /* Redirect browser to PHP web site */
  header("Location: adminenterfixture.php"); 
  /* Make sure that code below does not get executed when we redirect. */
  exit; 
?>
