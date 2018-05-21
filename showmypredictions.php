<?php 
/*********************************************************
 * Author: John Astill
 * Date  : 10th December
 * File  : showmypredictions.php
 * Desc  : Display the predictions for the currently logged
 *       : in user. If the cookie does not exist for the
 *       : user,show them a login page.
 ********************************************************/
require "systemvars.php";
require "configvalues.php";
require "sortfunctions.php";
require "security.php";

if ($User->loggedIn != TRUE) {
  $ip = $_SERVER["REMOTE_ADDR"];
  $port = $_SERVER["REMOTE_PORT"];
  $referer = $_SERVER["HTTP_REFERER"];
   logMsg("Attempt to view user predictions by someone not logged in. Could be an attempt to break in. IP Address $ip port $port referring page $referer");
   forward("index.php"); 
   exit;   
}

ClearErrorCode();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo $charset?>">
    <title>
      <?php echo "$My_Predictions_For $User->username\n"?>
    </title>
    <link rel="stylesheet" href="common.css" type="text/css">
  </head>

  <?php echo $HeaderRow ?>
  <body class="MAIN">
    <table class="MAINTB">
      <!-- Display the next game -->
      <tr>
        <td colspan="3" align="center" class="TBLROW">
          <font class="TBLROW">
            <?php echo getNextGame() ?>
          </font>
        </td>
      </tr>
      <tr>
        <td valign="top" class="LEFTCOL">
          <?php require "menus.php"?>
        </td>
        <td valign="top" class="CENTERCOL">
            <?php
              GetUserPredictions($User->userid);
            ?>
        </td>
        <td valign="top" class="RIGHTCOL">
          <!-- Show the Prediction stats for the next match -->
          <?php ShowPredictionStatsForNextMatch(); ?>
          
          <!-- Competition Prize -->
          <?php require "prize.html"?>
        </td>
      </tr>
    </table>
  </body>
</html>


