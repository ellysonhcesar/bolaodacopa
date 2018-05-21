<?php
/*********************************************************
 * Author: John Astill (c) 2003
 * Date  : 20 February 2003
 * File  : deletemsgs.php
 ********************************************************/
require "systemvars.php";
require "configvalues.php";
require "sortfunctions.php";
require "security.php";

if ($User->loggedIn != TRUE) {
  $ip = $_SERVER["REMOTE_ADDR"];
  $port = $_SERVER["REMOTE_PORT"];
  $referer = $_SERVER["HTTP_REFERER"];

  logMsg("Attempt to delete user messages by someone not logged in. Could be an attempt to break in. IP Address $ip port $port referring page $referer");
  forward("index.php"); 
  exit;   
}


$tgtuser = "";
if (array_key_exists("TGTUSER",$_POST)) {
  $tgtuser = $_POST["TGTUSER"];
}

$subject = "";
if (array_key_exists("SUBJECT",$_POST)) {
  $subject = $_POST["SUBJECT"];
}

$message = "";
if (array_key_exists("MESSAGE",$_POST)) {
  $message = $_POST["MESSAGE"];
}

$srcuser = $User->userid;


// loop through the POST data
$count = 0;
$val = "";
$wherelist= "";
while (list($a,$b) = each($_POST)) {
  if ($a != "DELETE") {
    if ($wherelist == "") {
      $wherelist = "msgid = $a";
    } else {
      $wherelist .= " or msgid = $a";
    }
  }
}

if ($wherelist != "") {
  $link = OpenConnection();
  $query = "update $dbaseMsgData set status=\"deleted\" where lid='$leagueID' and $wherelist";

  $link = OpenConnection();
  mysqli_query($link,$query) or die("unable to insert message : $query");
  CloseConnection($link);
}

forward("showmymessages.php?sid=$SID");
?>
