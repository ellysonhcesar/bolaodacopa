<?php 
/*********************************************************
 * Author: John Astill (c)
 * Date  : 17th August 2002
 * File  : viewlog.php
 * Desc  : View the log file. This has security included
 *       : to ensure that only admin and above can view
 *       : the log. The security of the logfile requires
 *       : that the logfile is Read/Write only by the server
 *       : process.
 ********************************************************/
require "systemvars.php";
require "configvalues.php";
require "sortfunctions.php";
require "security.php";

// If the user is not an admin user then they can't see this page.
if (!CheckAdmin($User->usertype)) {
  // Go back to the prediction index page.
  forward("index.php?sid=$SID");
}
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $charset?>">
<title>
Logfile viewer <?php echo "$logfile"?>
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
  if ($logfile == "") {
    echo "Logfile is not configured.\n";
  } else {
    echo "<table>\n";
    echo "<tr>\n";
    echo "<td width='400' align=\"left\">\n";
    echo "<pre>\n";
    include "$logfile";
    echo "</pre>\n";
    echo "</td>\n";
    echo "</tr>\n";
    echo "</table>\n";
  }
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
