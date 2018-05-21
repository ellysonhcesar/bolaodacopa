<?php 
/*********************************************************
 * Author: John Astill
 * Date  : 23rd January 2002 (c)
 * File  : showusers.php
 * Desc  : Display a table with all the user details 
 *       : except the password.
 ********************************************************/
require "systemvars.php";
require "configvalues.php";
require "sortfunctions.php";
require "security.php";

if ($User->loggedIn != TRUE) {
  $ip = $_SERVER["REMOTE_ADDR"];
  $port = $_SERVER["REMOTE_PORT"];
  $referer = $_SERVER["HTTP_REFERER"];

  logMsg("Attempt to view user data by someone not logged in. Could be an attempt to break in. IP Address $ip port $port referring page $referer");
  forward("index.php"); 
  exit;   
}

// If the user is not an admin user then they can't see this page.
if ($User->usertype < 4) {
  // Go back to the prediction index page.
  forward("index.php");
}

/////////////////////////////////////////////////////////
// Show a list of the users.
/////////////////////////////////////////////////////////
function ShowUsers() {
  global $dbaseUserData,$SID,$leagueID;

  $link = OpenConnection();
  if ($link == FALSE) {
    echo "Unable to connect to the dbase";
    return;
  }
  
  $userquery = "SELECT * FROM $dbaseUserData where lid='$leagueID'";
  $userresult = mysqli_query($link,$userquery)
      or die("Query failed: $userquery");

  // Display the username as a header.
?>
  <table class="STANDTB">
  <tr>
  <td class="TBLHEAD" colspan="8" align="center"><font class="TBLHEAD">Users</font></td>
  </tr>
  <tr>
  <td align="center" class="TBLHEAD"><font class="TBLHEAD">User ID</font></td>
  <td align="center" class="TBLHEAD"><font class="TBLHEAD">Admin</font></td>
  <td align="center" class="TBLHEAD"><font class="TBLHEAD">Username</font></td>
  <td align="center" class="TBLHEAD"><font class="TBLHEAD">Email</font></td>
  <td align="center" class="TBLHEAD"><font class="TBLHEAD">Since</font></td>
  <td align="center" class="TBLHEAD"><font class="TBLHEAD">&nbsp;</font></td>
  <td align="center" class="TBLHEAD"><font class="TBLHEAD">&nbsp;</font></td>
  <td align="center" class="TBLHEAD"><font class="TBLHEAD">&nbsp;</font></td>
  </tr>
<?php
  // First loop. Used to get all the users.
  while ($userline = mysqli_fetch_array($userresult, MYSQL_ASSOC)) {
    // For each user display all their predictions.
    // against the actual result.
    $username = $userline["username"];
    $userid = $userline["userid"];
    $usertype = $userline["usertype"];
    $icon = $userline["icon"];
    $email = $userline["email"];
    $since = $userline["since"];

    $isAdmin = "";
    if ($usertype >= 4) {
      $isAdmin = "Yes";
    }
    echo "<tr>\n";
    echo "<td class=\"TBLROW\"><font class=\"TBLROW\">$userid</font></td>\n";
    echo "<td class=\"TBLROW\"><font class=\"TBLROW\">$isAdmin</font></td>\n";
    echo "<td class=\"TBLROW\"><font class=\"TBLROW\">$username</font></td>\n";
    echo "<td class=\"TBLROW\"><font class=\"TBLROW\"><a href=\"mailto:$email\">$email</a></font></td>\n";
    echo "<td class=\"TBLROW\"><font class=\"TBLROW\">$since</font></td>\n";
    echo "<td class=\"TBLROW\"><font class=\"TBLROW\"><a href=\"deleteuser.php?sid=$SID&userid=$userid\" onclick=\"return confirm('Are you sure you want to delete ".addslashes($username)." and all their predictions');\"><small>delete user</small></a></font></td>\n";
    echo "<td class=\"TBLROW\"><font class=\"TBLROW\"><a href=\"changeuserpassword.php?sid=$SID&userid=$userid&username=$username\"><small>change user password</small></a></font></td>\n";
    if ($usertype >= 4) {
      echo "<td class=\"TBLROW\"><font class=\"TBLROW\"><a href=\"modifyuseradmin.php?sid=$SID&admin=Y&userid=$userid&username=$username\"><small>Remove admin privileges from this user</small></a></font></td>\n";
    } else {
      echo "<td class=\"TBLROW\"><font class=\"TBLROW\"><a href=\"modifyuseradmin.php?sid=$SID&admin=N&userid=$userid&username=$username\"><small>Make this user an admin user</small></a></font></td>\n";
    }
    echo "</tr>\n";
  }
  echo "</table>\n";

  CloseConnection($link);
}
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $charset?>">
<title>
<?php echo "Users\n"?>
</title>
<link rel="stylesheet" href="common.css" type="text/css">
</head>

<body class="MAIN">

<?php echo $HeaderRow ?>
<table class="MAINTB">
  <?php if ($ErrorCode != "") { ?>
      <tr>
        <td colspan="3" bgcolor="red" align="center">
          <!-- Error Message Row -->
          <font class="TBLHEAD">
          <?php 
            echo $ErrorCode; 
            ClearErrorCode();
          ?>
          </font>
        </td>
      </tr>
  <?php 
    }
  ?>
<!-- Display the next game -->
<tr>
  <td colspan="3" align="center" class="TBLROW">
    <font class="TBLROW">
      <?php echo getNextGame() ?>
    </font>
  </td>
</tr>
<tr>
<td class="LEFTCOL">
<?php require "menus.php"?>
</td>
<td class="CENTERCOL">
<?php
  ShowUsers();
?>
</td>
<td class="RIGHTCOL">
  <?php require "loginpanel.php"?>

  <!-- Show the Prediction stats for the next match -->
  <?php ShowPredictionStatsForNextMatch(); ?>
  
  <!-- Competition Prize -->
  <?php require "prize.html"?>
</td>
</tr>
</table>

</body>
</html>
