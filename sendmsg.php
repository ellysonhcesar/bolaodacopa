<?php
/*********************************************************
 * Author: John Astill (c) 2003
 * Date  : 20 February 2003
 * File  : sendmsg.php
 ********************************************************/
require "systemvars.php";
require "configvalues.php";
require "sortfunctions.php";
require "security.php";

if ($User->loggedIn != TRUE) {
  $ip = $_SERVER["REMOTE_ADDR"];
  $port = $_SERVER["REMOTE_PORT"];
  $referer = $_SERVER["HTTP_REFERER"];
  
  logMsg("Attempt to send a message by someone not logged in. Could be an attempt to break in. IP Address $ip port $port referring page $referer");
  forward("index.php"); 
  exit;   
}

$tgtuser = $_POST["TGTUSER"];
$subject = $_POST["SUBJECT"];
$message = $_POST["MESSAGE"];
$srcuser = $User->userid;

$link = OpenConnection();
$query = "insert into $dbaseMsgData (lid,sender,receiver,subject,body,status) values ($leagueID,\"$srcuser\",\"$tgtuser\",\"$subject\",\"$message\",\"new\")";
mysqli_query($link,$query) or die("unable to insert message : $query<br>.".mysql_error());

$query = "select * from $dbaseUserData where userid='$tgtuser' and lid='$leagueID'";
$res = mysqli_query($link,$query) or die("unable to get user details : $query<br>.".mysql_error());
$line = mysqli_fetch_array($res);

$email = $line["email"];
$uname = $line["username"];

CloseConnection($link);

// Email the recipient to let them know they have received a new message.
require (GetLangFile());
@mail("contatopedroandrade@gmail.com",$New_Message_Subject,$New_Message_Body) or logMsg("Unable to send mail to $email: $New_Message_Body");

forward("index.php?sid=$SID");
?>
