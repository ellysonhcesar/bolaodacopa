<?php
/*********************************************************
 * Author: John Astill
 * Date  : 18th December
 * File  : forgotpassword.php
 * Desc  : Send the password to the user.
 ********************************************************/
require "systemvars.php";
require "configvalues.php";
require "sortfunctions.php";
require "security.php";

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
  <title>
    Forgot Password
  </title>
<link rel="stylesheet" href="common.css" type="text/css">
</head>

<body class="MAIN">

<?php echo $HeaderRow ?>
<table class="MAINTB">
  <!-- Main body row -->
  <tr>
    <td valign="top">
          <!-- Show the login panel if required -->
          <?php require "loginpanel.php" ?>
      <?php include "menus.php"?>
    </td>
    <td valign="top">
      <form method="POST" action="sendpassword.php">
        <!-- Show the Users info -->
        <table class="HELPTB">
          <tr>
            <td colspan="2" align="CENTER" class="TBLHEAD">
              <font class="TBLHEAD">
                Password Reminder
              </font>
            </td>
          </tr>
          <tr>
            <td align="CENTER" class="TBLHEAD">
              <font class="TBLHEAD">
                User ID
              </font>
            </td>
            <td class="TBLROW">
              <font class="TBLROW">
                <input type="text" size="20" name="USERID" value="<?php echo $User->userid?>">
              </font>
            </td>
          </tr>
          <tr>
            <td colspan="2" align="LEFT" class="TBLROW">
              <font class="TBLROW">
                Enter your User ID and press the send button. Your password will be emailed to the email address in your profile.
              </font>
            </td>
          </tr>
          <tr>
            <td class="TBLROW" align="CENTER" colspan="2">
              <input type="SUBMIT" name="Send" value="Send">
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



