<?php 
/*********************************************************
 * Author: John Astill (c)
 * Date  : 9th December
 * File  : index.php
 ********************************************************/
  require "systemvars.php";
  require "configvalues.php";
  require "sortfunctions.php";
  require "security.php";

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo $charset?>">
    <title>
    <?php echo $PredictionLeagueTitle ?>
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
        <!-- Left column -->
        <td class="LEFTCOL">
          <!-- Show the login panel if required -->
          <?php require "loginpanel.php" ?>

          <!-- Menu -->
          <?php require "menus.php"?>
          <!-- End Menu -->
        </td>
        <!-- Central Column -->
        <td align="LEFT" class="CENTERCOL">
          <!-- Central Column -->
          <?php
            // It looks like the functions cannot access global type data.
            ShowStandingsTable();
          ?>
        </td>
        <!-- Right Column -->
        <td class="RIGHTCOL" align="RIGHT">
          <!-- Show the Prediction stats for the next match -->
          <?php //ShowPredictionStatsForAllMatches(); ?>
          <?php ShowPredictionStatsForNextMatch(); ?>
          
          <!-- Competition Prize -->
          <?php require "prize.html"?>
        </td>
      </tr>
    </table>
  </body>
</html>

