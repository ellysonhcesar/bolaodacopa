<?php
/*********************************************************
 * Author: John Astill (c)
 * Date  : 3rd January 2002
 * File  : deletefixture.php
 *       : Deletes the given fixture from the database.
 *********************************************************/
  require "systemvars.php";
  require "configvalues.php";
  require "sortfunctions.php";
  require "security.php";

  $REMOTE_ADDR = $HTTP_SERVER_VARS['REMOTE_ADDR'];
  $REMOTE_PORT = $HTTP_SERVER_VARS['REMOTE_PORT'];
  $HTTP_REFERER = $HTTP_SERVER_VARS['HTTP_REFERER'];

  if ($User->loggedIn != TRUE) {
    $ip = $_SERVER["REMOTE_ADDR"];
    $port = $_SERVER["REMOTE_PORT"];
    $referer = $_SERVER["HTTP_REFERER"];
  
    logMsg("Attempt to delete a fixture by someone not logged in. Could be an attempt to break in. IP Address $ip port $port referring page $referer");
    forward("index.php"); 
    exit;   
  }

  // Make sure the user trying to perform the delete is 
  // an admin or above.
  if (!CheckAdmin($User->usertype)) {
    // Forward to somewhere
    LogMsg("Attempt to remove fixture by User $User->userid with insufficient permissions from address $REMOTE_ADDR:$REMOTE_PORT. Referrer $HTTP_REFERER");
    ErrorRedir("Only admin can delete fixtures!","index.php?sid=$SID");
  }
  
  LogMsg("Attempt to remove fixture by User $User->userid from $REMOTE_ADDR:$REMOTE_PORT.");
  $matchid = $_GET["matchid"];

  // If the post is a success, go to the adminenterresult page.
  $link = OpenConnection();
  
  // Remove the fixture from the match data.
  $query = "delete from $dbaseMatchData where lid='$leagueID' and matchid=\"$matchid\"";
  $result = mysqli_query($link,$query)
      or die("Query failed removing from Match Data: $query");

  // Log the changes
  $rows = mysql_affected_rows();
  LogMsg("Removed fixture.\nUsed $query.\n$rows affected.");
  
  // Remove the fixture from the users prediction data
  $query = "delete from $dbasePredictionData where lid='$leagueID' and matchid=\"$matchid\"";
  $result = mysqli_query($link,$query)
      or die("Query failed removing from Prediction Data: $query");

  // Log the changes
  $rows = mysql_affected_rows();
  LogMsg("Removed user predictions.\nUsed $query.\n$rows affected.");
  
  // Close the connection with the database.
  CloseConnection($link);

  /* Redirect browser to PHP web site */
  forward("adminenterfixture.php?sid=$SID"); 
?>
