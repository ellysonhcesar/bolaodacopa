<?php 
/*********************************************************
 * Author: John Astill
 * Date  : 10th December 2001 (c)
 * File  : showuserpredictions.php
 * Desc  : Display the predictions for the currently logged
 *       : in user. If the cookie does not exist, check
 *       : the GET parameters. If no user can be found
 *       : prompt for one.
 *       : If the user is found, then display their data.
 ********************************************************/
require "systemvars.php";
require "configvalues.php";
require "sortfunctions.php";
require "security.php";
?>

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
<?php require "loginpanel.php"?>
<?php require "menus.php"?>
</td>
<td class="CENTERCOL">
<table class="STANDTB">
<?php
  /*******************************************************
  * Check the user id and password from the cookie.
  *******************************************************/
  $user = $_GET["user"];
  ShowUserPredictions($user);
?>
</table>
</td>
<td class="RIGHTCOL">
  <!-- Show the Prediction stats for the next match -->
  <?php ShowPredictionStatsForNextMatch(); ?>
  
  <!-- Competition Prize -->
  <?php require "prize.html"?>
</td>
</tr>
</table>

</body>
</html>
