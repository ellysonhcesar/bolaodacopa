<?php 
/*********************************************************
 * Author: John Astill
 * Date  : 30th Jan 2003
 * File  : viewallmessages.php
 * Desc  : Show all the messages for the admin.
 ********************************************************/
require "systemvars.php";
require "configvalues.php";
require "sortfunctions.php";
require "security.php";

// Make sure that the user has admin priveleges.
if (!CheckAdmin($User->usertype)) {
  forward("index.php?sid=$SID");
}

ClearErrorCode();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo $charset?>">
    <title>
      <?php echo "View All Messages\n"?>
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
              ShowAllMessages();
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


