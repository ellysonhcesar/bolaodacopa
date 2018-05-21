<?php 
/*********************************************************
 * Author: John Astill (c)
 * Date  : 30th Jan 2003
 * File  : sessiondata.php
 * Desc  : Data that is required during a logged in 
 *       : session. Matters not if the session uses 
 *       : cookies or PHP sessions.
 ********************************************************/

/*************************************************************
** Store User data in session information
** needs to be global
*************************************************************/
$User = new User;

$SID="";

if (array_key_exists("sid",$_GET)) {
  $SID = $_GET["sid"];
}

// For some servers it is necessary to update the session file
// directory.
if ($sessionFileDir != "") {
  session_save_path($sessionFileDir);
}

if ($SID == "") {
  session_start();
  $SID = session_id();
} else {
  session_start($SID);
}


if (array_key_exists("User",$_SESSION)) {
  $User = $_SESSION["User"];
}

// These are needed to suppress warnings in the language files.
$userid = $User->userid;
$username = $User->username;
$email = "";
$password = "";

$ErrorCode = "";
if (array_key_exists("ErrorCode",$_SESSION)) {
  $ErrorCode = $_SESSION["ErrorCode"];
}
$_SESSION["ErrorCode"] = "";

//session_unregister("ErrorCode");
//unset("ErrorCode") ;

/*************************************************************
** Store User data in session information
** needs to be global
*************************************************************/
function RegisterUser() {
  global $User;
  if (false == $_SESSION['User'] = $User) {
    die("Can't register User");
  }
}

/*************************************************************
** Delete User data in session information
** needs to be global
*************************************************************/
function UnregisterUser() {
  $_SESSION["USER"] = "";
  session_unset("User");
}

?>
