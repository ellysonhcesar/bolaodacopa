<?php 
/*********************************************************
 * Author: John Astill
 * Date  : 31st December
 * File  : changepassword.php
 * Desc  : Change the users given password.
 ********************************************************/
require "systemvars.php";
require "configvalues.php";
require "sortfunctions.php";
require "security.php";

 $user = $_POST["USERID"];
 $password = $_POST["PWD1"];
  $oldpassword = $_POST["OLDPWD"];

  
 $ip = $_SERVER["REMOTE_ADDR"];
 $port = $_SERVER["REMOTE_PORT"];
 $referer = $_SERVER["HTTP_REFERER"];
 
 logMsg("Password is being changed for user [$user] from ip address ".$ip." port ".$port);
 
 // Make sure that the page has not been spoofed and that a user is logged in.
 if ($User->loggedIn != TRUE) {
   logMsg("Attempt to change password by someone not logged in. Could be an attempt to break in. IP Address $ip port $port referring page $referer");
   forward("index.php"); 
   exit;   
 }
  
 $encrold = new Encryption($oldpassword);
 $encryptpassold = $encrold->Encrypt();  
 
 if ($encryptpassold != ($User->pwd)) {
	 ErrorRedir("Old Password Invalid","showmyprofile.php?sid=".$SID);
 }
  
 // Encrypt the password if password encryption is enabled
 $encr = new Encryption($password);
 $encryptpass = $encr->Encrypt();

 $link = OpenConnection();

 $query = "UPDATE $dbaseUserData set password=? where userid=\"$user\" and lid='$leagueID'";
 
  $stmt = mysqli_prepare($link,$query);
  mysqli_stmt_bind_param($stmt,"s", $encryptpass);
  mysqli_stmt_execute($stmt);
$User->pwd = $encryptpass;
$HTTP_SESSION_VARS["User"] = $User;
 CloseConnection($link);

 
   // The password has changed, update the stats info in the session
   // data and forward to the Index.
   header("Location: index.php?sid=$SID"); 
   /* Make sure that code below does not get executed when we redirect. */
   exit; 
 
?>
