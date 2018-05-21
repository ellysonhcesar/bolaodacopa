<?php
/*********************************************************
 * Author: John Astill
 * Date  : 10th December
 * File  : createuser.php
 * Desc  : Create the required tables entries for a new user.
 ********************************************************/
require "systemvars.php";
require "configvalues.php";
require "sortfunctions.php";
require "security.php";

$username = $_POST["USERID"];
$password = $_POST["PWD1"];
$email = $_POST["EMAIL"];
$icon = $_POST["ICON"];
$asAdmin = $_POST["ASADMIN"];
$name = $_POST["NAME"];


require (GetLangFile());

/**
 * Determine if the given email exists.
 * @param email the email to look for.
 */
function doesEmailExist($email) {
  global $dbaseUserData, $leagueID;

  $link = OpenConnection();
  if ($link == FALSE) {
    ErrorNotify("Unable to open connection");
    exit;
  }

  $query = "SELECT email from $dbaseUserData where lid='$leagueID' and email=?";
  
  $stmt = mysqli_prepare($link,$query);
  mysqli_stmt_bind_param($stmt,"s", $email);
  mysqli_stmt_execute($stmt);
  
  $stmt->bind_result($emailchk);	
  $stmt->fetch();   
  
  

  CloseConnection($link);

  if ($emailchk != "") {
    return TRUE;
  }

  return FALSE;
} 

/**********************************************************
 * Determine if the given user exists.
 * @param user the user to look for.
 *********************************************************/
function doesUserExist($user) {
  global $dbaseUserData, $leagueID;

  $link = OpenConnection();
  if ($link == FALSE) {
    ErrorNotify("Unable to open connection");
    exit;
  }

  $query = "SELECT username from $dbaseUserData where lid='$leagueID' and username=?";

  $stmt = mysqli_prepare($link,$query);
  mysqli_stmt_bind_param($stmt,"s", $user);
  mysqli_stmt_execute($stmt);
  

  $stmt->bind_result($username);	
  $stmt->fetch();   

//  $result = $stmt->get_result();	
//  $erro = mysqli_fetch_array($result, MYSQL_ASSOC);

  //if ($erro["username"] != "") {
  
	  if ($username != "") {
    return TRUE;
  }
 
  return FALSE;
} 

/*****************************************************
 * Entry Point 
 *****************************************************/
if (TRUE == doesUserExist($username)) {
  ErrorRedir($Username_already_exists,"createnewuser.php");
}

/*
 * The admin can configure the system to allow more than one user per password. 
 */
if ($allowMultipleUserPerEmail == "FALSE") {
  if (TRUE == doesEmailExist($email)) {
    ErrorRedir($One_user_per_email,"createnewuser.php");
  }
}

// Make sure there is a username
if ($username == "") {
  ErrorRedir($Username_required,"createnewuser.php");
}

// Make sure there is a password
if ($password == "") {
  ErrorRedir($Password_required,"createnewuser.php");
}

// Encrypt the password if password encryption is enabled
$encr = new Encryption($password);
$encryptpass = $encr->Encrypt();
$password = $encr->pwd;

// Connect to the host.
$link = OpenConnection();

$todaysDate = date("Y-m-d");
$query = "INSERT INTO $dbaseUserData (lid,username,name,password,email,icon,usertype,since) values ('$leagueID',?,?,?,?,?,'1','$todaysDate')";
//$result = mysqli_query($link,$query)
//  or die("Query failed: $query");

    $stmt = mysqli_prepare($link,$query);
    mysqli_stmt_bind_param($stmt,"sssss", $username, $name, $encryptpass, $email, $icon);
    mysqli_stmt_execute($stmt);

CloseConnection($link);

// Email the administrator the new user
$text = "New User created.\nUser = $username\nPassword = $password\nEmail = $email\nIcon = $icon\nSent to $adminEmailAddr\nVersion = ".VERSION;
@mail($adminEmailAddr, "New User",$text,"From: $name");
//@mail($email,$Email_Subject_txt,$Email_Answer_txt,"From: $adminEmailAddr");

// Add the new user to the standings table.
UpdateStandingsTable();

if ($asAdmin == "TRUE") {
  forward("showusers.php?sid=$SID");
} else {
  // Now that the user has been created, log them in.
  login($username,$password);
}
?>
