<?php 
/*********************************************************
 * Author: John Astill
 * Date  : 10th December
 * File  : showmatchresults.php
 * Desc  : Display the results for all the games.
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
<?php echo "Results\n"?>
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
      <td class="LEFTCOL">
        <?php require "loginpanel.php"; ?>
        <?php require "menus.php"; ?>
      </td>
      <td class="CENTERCOL">
        <?php
          // Get a display of the current results.
          GetResults();
        ?>
      </td>
      <td class="RIGHTCOL">
        <!-- Show the Prediction stats for the next match -->
        <?php ShowPredictionStatsForNextMatch(); ?>
        
        <!-- Competition Prize -->
        <?php require "prize.html" ?>
      </td>
    </tr>
  </table>

</body>
</html>


