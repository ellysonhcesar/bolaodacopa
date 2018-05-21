<?php
/*********************************************************
 * Author: John Astill (c) 
 * Date  : 7th Feb 2003
 * File  : createmsg.php
 * Desc  : Form for creating a msg
 ********************************************************/
require "systemvars.php";
require "configvalues.php";
require "sortfunctions.php";
require "security.php";
require (GetLangFile());

if ($User->loggedIn != TRUE) {
  $ip = $_SERVER["REMOTE_ADDR"];
  $port = $_SERVER["REMOTE_PORT"];
  $referer = $_SERVER["HTTP_REFERER"];

  logMsg("Attempt to create a message by someone not logged in. Could be an attempt to break in. IP Address $ip port $port referring page $referer");
  forward("index.php"); 
  exit;   
}

$error = $ErrorCode;
ClearErrorCode();

$tgtuserid = $_GET["userid"];

$subject = "";
if (array_key_exists("subj",$_GET)) {
  $subject = $_GET["subj"];
}

function getUsername($userid) {
  global $dbaseUserData, $leagueID;

  $username = "Unknown";
  
  $link = OpenConnection();
  $query = "select username from $dbaseUserData where lid='$leagueID' and userid=\"$userid\" limit 1";
  $result = mysqli_query($link,$query) or die("Unable to get username : $query");
  $arr = mysqli_fetch_array($result);
  $username = $arr[0];

  CloseConnection($link);
  
  return $username;
}
$tgtusername = getUsername($tgtuserid);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>
  <?php echo $Create_Msg; ?>
</title>
<link rel="stylesheet" href="common.css" type="text/css">
</head>

<body class="MAIN">

<table width="800">
<tr>
<td colspan="3" align="center">
<!-- Header Row -->
<?php echo $HeaderRow ?>
</td>
</tr>

<?php if ($error != "") { ?>
<tr>
<td colspan="3" bgcolor="red" align="center">
<!-- Error Message Row -->
<font class="TBLHEAD">
<?php 
  echo $error; 
?>
</font>
</td>
</tr>
<?php 
  }
?>

<tr>
<td valign="top">
<?php require "menus.php"?>
</td>
<td valign="top">
<!-- Show the Users info -->
<form method="POST" action="sendmsg.php">
<table width="500">

<tr>
<td colspan="2" align="CENTER" class="TBLHEAD">
<font class="TBLHEAD">
<?php echo $New_Message."\n"; ?>
</font>
</td>
</tr>
<tr>
<td align="LEFT" class="TBLHEAD">
<font class="TBLHEAD">
<?php echo $User_Name."\n"; ?>
</font>
</td>
<td class="TBLROW">
<font class="TBLROW">
<?php echo $tgtusername?>
<input type="hidden" name="TGTUSER" value="<?php echo $tgtuserid?>">
</font>
</td>
</tr>
<tr>
<td align="LEFT" class="TBLHEAD">
<font class="TBLHEAD">
<?php echo $Subject_txt; ?>
</font>
</td>
<td class="TBLROW">
<font class="TBLROW">
<input type="text" size="30" name="SUBJECT" value="<?php echo $subject; ?>">
</font>
</td>
</tr>
<tr>
<td valign="TOP" align="LEFT" class="TBLHEAD">
<font class="TBLHEAD">
<?php echo $Message_txt."\n"; ?>
</font>
</td>
<td class="TBLROW">
<font class="TBLROW">
<textarea name="MESSAGE" rows="20" cols="30"></textarea>
</font>
</td>
</tr>
<tr>
<td colspan="2" align="CENTER">
<font class="TBLROW">
<input type="SUBMIT" name="CREATE" value="<?php echo $Send_Msg_Button; ?>">
</td>
</tr>
</table>
</form>
</td>

<!-- Right Column -->
<td class="RIGHTCOL" align="RIGHT">
  <!-- Show the Prediction stats for the next match -->
  <?php ShowPredictionStatsForNextMatch(); ?>
  
  <!-- Competition Prize -->
  <?php include "prize.html"?>
</td>

</tr>
</table>

</body>
</html>


