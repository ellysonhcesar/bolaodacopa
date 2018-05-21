<?php
/*********************************************************
 * Author: John Astill
 * Date  : 10th December
 * File  : deleteuser.php
 * Desc  : Delete the given user from the user table
 *       : and predictions from the prediction table.
 ********************************************************/
require "systemvars.php";
require "configvalues.php";
require "sortfunctions.php";
require "security.php";

$userid = $_GET["userid"];
$username = $_GET["username"];
$admin = $_GET["admin"];

$ip = $_SERVER["REMOTE_ADDR"];
$port = $_SERVER["REMOTE_PORT"];
$referer = $_SERVER["HTTP_REFERER"];

if ($User->loggedIn != TRUE) {
  logMsg("Attempt to make a user admin by someone not logged in. Could be an attempt to break in. IP Address $ip port $port referring page $referer");
  forward("index.php"); 
  exit;   
}

// Make sure the user trying to perform the change is 
// an admin or above.
if (!CheckAdmin($User->usertype)) {
  // Forward to somewhere
  LogMsg("Attempt to mae admin user $userid by User $User->userid with insufficient permissions from $ip:$port $referer.");
  forward("index.php?sid=$SID");
}

/**
 * Determine if the given user exists.
 * @param user the user to look for.
 */
function doesUserExist($userid) {
  global $dbaseUserData, $leagueID;

  $link = OpenConnection();
  if ($link == FALSE) {
    ErrorNotify("Unable to open connection");
    exit;
  }

  $query = "SELECT userid from $dbaseUserData where lid='$leagueID' and userid=\"$userid\"";
  $result = mysqli_query($link,$query)
    or die("Unable to perform query: $query");

  if ($result == FALSE) {
    ErrorNotify("Query Failed : $query");
    CloseConnection($link);
    return TRUE;
  }
  
  // If we get >0 rows, the username already exists.
  $numrows = mysqli_num_rows($result);

  CloseConnection($link);

  if ($numrows == 0) {
    return FALSE;
  }

  return TRUE;
} 

/* Entry Point */
if (FALSE == doesUserExist($userid)) {
  ErrorRedir("User $username does not exist","showusers.php");
}


// Connect to the host.
$link = OpenConnection();

/* Make sure that we have not exceeded the max number of admins. */
$query = "select * from $dbaseUserData where usertype>=\"4\" and lid=\"$leagueID\"";
$result = mysqli_query($link,$query) or die ("Unable to find usertypes: $query<br>".mysql_error());
$count = mysqli_num_rows($result);


$usertype = 1;
if ($admin == "Y") {
  $usertype = 4;
}

if ($usertype == 4 && $count >= $maxAdminUsers) {
  ErrorRedir("The maximum number of admin users has been reached. Modify Max Admin users in config to add another admin","showusers.php?sid=$SID");
  exit;
}

// Delete from the UserData table
$query = "update $dbaseUserData set usertype=\"$usertype\" where lid='$leagueID' and userid=\"$userid\"";
$result = mysqli_query($link,$query)
  or die("Query failed: $query");

// Close the connection to the database
CloseConnection($link);

// Log the action
LogMsg("Made user $username into an admin user from $$ip:$port $referer.");

// Go back to show users page.
forward("showusers.php?sid=$SID");
?>
