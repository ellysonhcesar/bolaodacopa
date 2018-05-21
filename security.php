<?php 
/*********************************************************
 * Author: John Astill (c)
 * Date  : 9th December
 * File  : security.php
 * Desc  : usertypes:
 *       :     1 - Normal User
 *       :     2 - Priveleged User
 *       :     4 - Admin User
 *       :     8 - Root User
 *
 ********************************************************/

  require "encryptionclass.php";
  
  function login($username, $pwd) {
    global $SID;
    $location = "showmypredictions.php?sid=$SID"; 
    loginwithtarget($username,$pwd,$location);
  }
  
  function loginwithtarget($username, $pwd, $location) {
    global $User, $SID;

    // If the user login has timed out, forward to the
    // index.
    if (CheckUserLogin($username, $pwd) == FALSE) {
      /* Redirect browser to Prediction Index web site */
      ErrorRedir("Username or password invalid","index.php"); 
      /* Make sure that code below does not get executed when we redirect. */
      exit; 
    }

    RegisterUser($User);

    /* Redirect browser to user predictions web site */
    header("Location: $location"); 
    /* Make sure that code below does not get executed when we redirect. */
    exit; 
  }

 /********************************************************
  * Check if the given user has admin priveleges.
  * @param perms the users current permissions.
  *******************************************************/
  function CheckAdmin($perms) {
    global $dbaseUserData;

    $NormalUser = 1;
    $PrivelegedUser = 2;
    $AdminUser = 4;
    $RootUser = 8;
    
    return $perms >= $AdminUser;
  }

 /********************************************************
  * Check if the given user is logged in.
  * @param user the user to check.
  * @param pwd the password of the user to check.
  *******************************************************/
  function CheckUserLogin($username, $pwd) {
    // Needs global include SystemVars.php
    global $dbaseUserData, $User,$leagueID;

    // if encryption enabled encrypt the password

    $encr = new Encryption($pwd);
    $pwd = $encr->Encrypt($pwd);
	
	
    // Default the login to false.
    $User = new User;
    $User->loggedIn = FALSE;
    $User->usertype = 1;

    $link = OpenConnection();
    if ($link == FALSE) {
      return FALSE;
    }

    //$userquery = "SELECT * FROM $dbaseUserData where username = \"$username\" and lid='$leagueID'";
    $userquery = "SELECT userid,email,icon,usertype,since,lang,dflths,dfltas,lang,auto,name,password FROM $dbaseUserData where username = ? and lid='$leagueID'";

    $stmt = mysqli_prepare($link,$userquery);
    mysqli_stmt_bind_param($stmt,"s", $username);
    mysqli_stmt_execute($stmt);

   $stmt->bind_result($userid,$email,$icon,$usertype,$since,$lang,$dflths,$dfltas,$lang,$auto,$name,$password);	
   $stmt->fetch();   
   
	if ($pwd == $password) {		  		
		$User->userid =  $userid;
		$User->username = stripslashes($username);
		$User->emailaddr = $email;
		$User->icon = $icon;
		$User->usertype = $usertype;
		$User->createdate = $since;
		$User->lang = $lang;
		$User->dflths = $dflths;
		$User->dfltas = $dfltas;
		$User->lang = $lang;
		$User->auto = $auto;
		$User->loggedIn = TRUE;
		$User->name = $name;
		$User->pwd = $password;
	return TRUE;
	}

    CloseConnection($link);
    return FALSE;
  }
?>
