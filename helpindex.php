<?php 
/*********************************************************
 * Author: John Astill
 * Date  : 19th January 2002
 * File  : helpindex.php
 ********************************************************/
  require "systemvars.php";
  require "configvalues.php";
  require "sortfunctions.php";
  require "security.php";
  require (GetLangFile());

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <title>
      <?php echo $Prediction_League_Help_topic; ?>
    </title>
    <link rel="stylesheet" href="common.css" type="text/css">
  </head>
  <body class="MAIN">
    <?php echo $HeaderRow ?>
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
        <!-- Left column -->
        <td class="LEFTCOL">
          <!-- Show the login panel if required -->
          <?php require "loginpanel.php" ?>
          <!-- Menu -->
          <?php require "menus.php"?>
          <!-- End Menu -->
        </td>
        <!-- Central Column -->
        <td class="CENTERCOL">
          <!-- Central Column -->
          <table class="HELPTB">
          <!-- Creating a new user -->
          <tr>
          <td align="CENTER" class="TBLHEAD">
          <font class="HELPHEAD">
          <a name="NEWUSER">
          Questions and Support
          </font>
          </td>
          </tr>
          <tr>
          <td align="LEFT" class="TBLROW">
          <font class="HELPROW">
		  <br>
For questions or support please text me on Whatsapp +55 47 992086037
<br><br>
Join the whatsapp group <a href="https://chat.whatsapp.com/22HbDQlOHUv842r8cO7T0L">Click Here!</a><br><br>

          </font>
          </td>
          </tr>
		  
          <tr>
          <td align="CENTER" class="TBLHEAD">
          <font class="HELPHEAD">
          <a name="NEWUSER">
          Predictions
          </font>
          </td>
          </tr>
          <tr>
          <td align="LEFT" class="TBLROW">
          <font class="HELPROW">
		  <br>
You can make or change yours prections up tp 30 minutes before the match.
The user's predictions will be avaliable for consultation when the prection time closed.  (30 minutes before the match)
<br><br>
          </font>
          </td>
          </tr>
		  
          <!-- End Creating a new user -->
          <!-- Scoring -->
          <tr>
          <td align="CENTER" class="TBLHEAD">
          <font class="HELPHEAD">
          <a name="SCORING">
          <?php echo $Scoring_txt."\n"; ?>
          </font>
          </td>
          </tr>
          <tr>
          <td align="LEFT" class="TBLROW">
          <font class="HELPROW">
          <?php echo $Scoring_txt_txt."\n"; ?>
          </font>
          </td>
          </tr>
          <!-- End Scoring -->
          </table>
          
        </td>
        <!-- Right Column -->
        <td class="RIGHTCOL" align="RIGHT">
          <!-- Show the Prediction stats for the next match -->
          <?php ShowPredictionStatsForNextMatch(); ?>
          
          <!-- Competition Prize -->
          <?php require "prize.html"?>
        </td>
      </tr>
    </table>
  </body>
</html>

