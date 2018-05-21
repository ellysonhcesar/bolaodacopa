<?php
/*********************************************************
 * Author: John Astill (c)
 * Date  : 20th March 2003
 * File  : userselecticon.php
 *********************************************************/
  require "systemvars.php";
  require "configvalues.php";
  require "sortfunctions.php";
  require "security.php";
  require (GetLangFile());
?>
<html>
<head>
<title>
<?php echo $Profile_Icon_Selection; ?>
</title>
<link rel="stylesheet" href="common.css" type="text/css">
</head>

<body class="MAIN">
  <table class="MAINTB" border="0">
    <!-- Top banner, will include news -->
    <tr>
      <td colspan="4" align="center">
        <?php echo $HeaderRow ?>
      </td>
    </tr>
    <!-- Display the next game -->
    <tr>
      <td colspan="4" align="center" class="TBLROW">
        <font class="TBLROW">
          <?php echo getNextGame() ?>
        </font>
      </td>
    </tr>
    <tr>
      <!-- Left column -->
      <td class="LEFTCOL">
        <!-- Menu -->
        <?php require "menus.php"?>
        <!-- End Menu -->
      </td>
      <!-- Central Column -->
      <td class="CENTERCOL">
        <table class="CENTER">
          <tr>
            <td align="CENTER" class="TBLHEAD" colspan="4">
              <font class="TBLHEAD">
                <?php echo $Click_on_the_Icon."\n"; ?>
              </font>
            </td>
          </tr>
<?php
  $dirname = "icons";
  $dir = @opendir($dirname);
  if ($dir == FALSE) {
    // Oh no, no files.
    $error = "Installation problem, unable to open directory $dirname";
    echo($error);
  }

  $count = 0;
  while (($file = readdir($dir)) != FALSE) {
    if (TRUE == is_dir($file)) {
      continue;
    }

    if (($count%4) == 0) {
      echo "<tr>\n";
    }
    $count++;
?>
            <td align="CENTER" class="TBLROW">
              <font class="TBLROW">
<?php
                $fullname = $dirname."/".$file;
                echo "<a href=\"selecticon.php?sid=$SID&icon=$file\">";
                echo "<img border=\"0\" src=\"$fullname\">";
                echo "</a>";
?>
              </font>
            </td>
<?php
    if (($count%4) == 0) {
      echo "</tr>\n";
    }
  }
  closedir($dir);
?>
        </table>

      </td>
      <!-- Right Column -->
      <td class="RIGHTCOL" align="RIGHT">
        <!-- Show the Prediction stats for the next match -->
        <?php ShowPredictionStatsForNextMatch(); ?>
        
        <!-- Competition Prize -->
        <?php require "prize.html" ?>
      </td>
    </tr>
  </table>
</body>
</html>
