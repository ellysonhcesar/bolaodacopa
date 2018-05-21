<?php
/*********************************************************
 * Author: John Astill
 * Date  : 2nd July 2003 (c)
 * File  : emptytables.php
 * Desc  : Empty the configured tables. The table
 *       : names are taken from system vars.
 ********************************************************/
require "systemvars.php";

  $url = $_POST["URL"];
  $dbname = $_POST["DBASENAME"];
  $username = $_POST["USERNAME"];
  $password = $_POST["PASSWORD"];
  $create = $_POST["CREATEDB"];
  $userDataTblName = $dbaseUserData;
  $predDataTblName = $dbasePredictionData;
  $matchDataTblName = $dbaseMatchData;
  $standingsTblName = $dbaseStandings;

  // Connect to the host.
  $link = mysql_connect($url, $username, $password)
      or die("Could not connect to $url");

  $query = "delete from $dbname.$dbaseUserData where lid='$leagueID'";
  $userresult = mysqli_query($link,$query)
      or die("Query failed: $query");

  $query = "delete from $dbname.$dbasePredictionData where lid='$leagueID'";
  $userresult = mysqli_query($link,$query)
      or die("Query failed: $query");

  $query = "delete from $dbname.$dbaseMatchData where lid='$leagueID'";
  $userresult = mysqli_query($link,$query)
      or die("Query failed: $query");

  $query = "delete from $dbname.$dbaseStandings where lid='$leagueID'";
  $userresult = mysqli_query($link,$query)
      or die("Query failed: $query");

  $query = "delete from $dbname.$dbaseMsgData where lid='$leagueID'";
  $userresult = mysqli_query($link,$query)
      or die("Query failed: $query");

?>
<html>
  <head>
    <title>
      Emptied database tables <?php echo $dbname; ?>
    </title>
    <link rel="stylesheet" href="common.css" type="text/css">
  </head>

  <body class="MAIN">

<table>
<tr>
<td>
  <?php require "adminsetupmenu.php"; ?>
</td>
<td colspan="1" align="LEFT" valign="TOP" class="TBLROW">
<font class="TBLROW">
All the tables except the config table has been emptied.<br>You will need to recreate your admin user to be able to login.
</font>
</td>
</tr>
</table>

  </body>
</html>

