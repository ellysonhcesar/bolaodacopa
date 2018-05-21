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
  $deldbase = $_POST["DELDBASE"];

  // Connect to the host.
  $link = mysql_connect($url, $username, $password)
      or die("Could not connect to $url");

  if ($deldbase == "deldb") {
    $query = "drop database $dbname";
    $userresult = mysqli_query($link,$query)
        or die("Query failed: $query<br>\n".mysql_error());
  } else {
    $query = "drop table $dbname.$dbaseUserData";
    $userresult = mysqli_query($link,$query)
      or die("Query failed: $query<br>\n".mysql_error());

    $query = "drop table $dbname.$dbasePredictionData";
    $userresult = mysqli_query($link,$query)
      or die("Query failed: $query<br>\n".mysql_error());

    $query = "drop table $dbname.$dbaseMatchData";
    $userresult = mysqli_query($link,$query)
      or die("Query failed: $query<br>\n".mysql_error());

    $query = "drop table $dbname.$dbaseConfigData";
    $userresult = mysqli_query($link,$query)
      or die("Query failed: $query<br>\n".mysql_error());

    $query = "drop table $dbname.$dbaseMsgData";
    $userresult = mysqli_query($link,$query)
      or die("Query failed: $query<br>\n".mysql_error());

    $query = "drop table $dbname.$dbaseStandings";
    $userresult = mysqli_query($link,$query)
      or die("Query failed: $query<br>\n".mysql_error());
  }

?>
<html>
  <head>
    <title>
      Deleted database and tables <?php echo $dbname; ?>
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
<?php if ($deldbase == "deldb") { ?>
The database <?php echo $dbname?> has now been deleted along with all tables.
<?php } else { ?>
The prediction football tables in database <?php echo $dbname?> has now been deleted.
<?php } ?> 
</font>
</td>
</tr>
</table>

  </body>
</html>

