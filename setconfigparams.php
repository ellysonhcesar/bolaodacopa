<?php
/*********************************************************
 * Author: John Astill (c)
 * Date  : 20th March 2003
 * File  : setconfigparams.php
 *********************************************************/
require "systemvars.php";
require "configvalues.php";
require "security.php";
require "sortfunctions.php";

// By now the admin user should be logged in.
if ($User->loggedIn == FALSE) {
  echo "Only an Admin User can perform this function";
  exit;
}
if (!CheckAdmin($User->usertype)) {
  echo "Only an Admin User can perform this function";
  exit;
}

function SetParam($param, $val) {
  global $link, $dbaseConfigData, $leagueID;

  $query = "update $dbaseConfigData set value=\"$val\" where param=\"$param\" and lid='$leagueID'";

  $result = mysqli_query($link,$query);
}
  
$referer = "adminconfigleague.php?sid=$SID";
if (array_key_exists("Default",$_POST)) {
  if ($_POST["Default"] == "Default") {
    PopulateConfigTable();
  }
} else {

  $link = OpenConnection();

  while(list($param,$val) = each($_POST)) {

    if ($param == "REFERER") {
      $referer = $val;
    }
    if ($param == "Change" || $param == "Default") {
      continue;
    }
    SetParam($param, $val);
  }

  CloseConnection($link);
}
forward($referer);
?>
