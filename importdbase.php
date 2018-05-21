<?php
/*********************************************************
 * Author: John Astill (c)
 * Date  : 14th March 2003
 * File  : importdbase.php
 * Desc  : import the data from the given database.
 ********************************************************/
/* This is a utility for upgrading the database from a version 0.4X 
   to version 1.0X 
   The table names in the two databases MUST be different.

   o Install version 1.0 files in a new directory on the same server as
     the 0.4X install.
   o Make sure the dbase tablenames in the 1.0 systemvars.php file
     are not the same as the tables in 0.4X SystemVars.php file.
     If you used default table names, then this is true.
   o Complete the install and configuration of the 1.0 release.
   o Run this utility to copy the relevant entries across the tables.
   
   * Copy the userdata across, using a default auto-increment to 
     set the userids.
   * Copy the matchdata across setting the appropriate matchids.
   * Copy the prediction data across swapping the username for userid
     and the match info for matchids.
   * Generate the standings table from the new information.

   */

   require "systemvars.php";
   require "encryptionclass.php";

  // Old table information
  $url = $_POST["URL"];
  $username = $_POST["USERNAME"];
  $password = $_POST["PASSWORD"];
  $olddbname = $_POST["DBASENAME"];
  $usertbl = $_POST["USERDATATBL"];
  $matchtbl = $_POST["MATCHDATATBL"];
  $predtbl = $_POST["PREDDATATBL"];

   // Old dbase
   $link1 = mysql_connect($url,$username,$password) or die("Unable to connect to dbase on $localhost with $username and $password\n".mysql_error());
   $success = mysql_select_db($olddbname,$link1) or die("Unable to select database $olddbname\n".mysql_error());

   if ($success == FALSE) {
     
   }
   
   // New dbase
   $link2 = OpenConnection();

   $lid = $leagueID;
   
   // Copy the user information across
   $q47 = "select * from $olddbname.$usertbl";
   $result = mysqli_query($link,$q47, $link1) or die ("Unable to perform the query ': $q47'\n".mysql_error());
   while ($u47 = mysqli_fetch_array($result)) {
     $username = $u47["username"];
     $email = $u47["email"];
     $icon = $u47["icon"];
     $usertype = $u47["usertype"];
     $since = $u47["since"];
     // Encrypt the password if password encryption is enabled
     $encr = new Encryption($username."10");
     $password = $encr->Encrypt();

     $q10 = "insert into $dbaseName.$dbaseUserData (lid,username,password,email,icon,usertype,since,lang) values ($lid,\"$username\",\"$password\",\"$email\",\"$icon\",\"$usertype\",\"$since\",\"english\")";
     mysqli_query($link,$q10,$link2) or die ("Unable to copy userdata across: $q10\n".mysql_error());
   }

   // Copy the match information
   $q47 = "select * from $olddbname.$matchtbl";
   $result = mysqli_query($link,$q47,$link1) or die("Unable to: $q47\n".mysql_error());
   while ($m47 = mysqli_fetch_array($result)) {
     $matchdate = $m47["matchdate"];
     $hometeam = $m47["hometeam"];
     $awayteam = $m47["awayteam"];
     $homescore = $m47["homescore"];
     $awayscore = $m47["awayscore"];

     $q10 = "insert into $dbaseName.$dbaseMatchData (lid,matchdate,hometeam,awayteam,homescore,awayscore) values ($lid,\"$matchdate\",\"$hometeam\",\"$awayteam\",\"$homescore\",\"$awayscore\")";
     mysqli_query($link,$q10,$link2) or die ("Unable to copy matchdata across: $q10\n".mysql_error());
   }

   // Copy the prediction data
   $q47 = "select * from $olddbname.$predtbl";
   $result = mysqli_query($link,$q47,$link1) or die("Unble to: $q47\n".mysql_error());
   while ($p47 = mysqli_fetch_array($result)) {
     $md = $p47["matchdate"];
     $ht = $p47["hometeam"];
     $at = $p47["awayteam"];
     $hs = $p47["homescore"];
     $as = $p47["awayscore"];
     $un = $p47["username"];

     $qmid = "select matchid from $dbaseName.$dbaseMatchData where matchdate=\"$md\" and hometeam=\"$ht\" and awayteam=\"$at\"";
     $midresult = mysqli_query($link,$qmid,$link2) or die ("Unable to read the match ids: $qmid\n".mysql_error());
     $cnt = mysqli_num_rows($midresult);
     if ($cnt != 1) {
       echo "Incorrect result rows $cnt<br>$qmid<br>";
     }
     $row = mysqli_fetch_array($midresult);
     $mid = $row["matchid"];

     $qpid = "select userid from $dbaseName.$dbaseUserData where username=\"$un\"";
     $pidresult = mysqli_query($link,$qpid,$link2) or die ("Unable to read the player ids: $qpid\n".mysql_error());
     $row = mysqli_fetch_array($pidresult);
     $pid = $row["userid"];

     $q10 = "insert into $dbaseName.$dbasePredictionData (lid,userid,matchid,homescore,awayscore) values (\"$lid\",\"$pid\",\"$mid\",\"$hs\",\"$as\")";
     mysqli_query($link,$q10,$link2) or die ("Unable to copy predictiondata across: $q10\n".mysql_error());

   }
   
   CloseConnection($link1);
   CloseConnection($link2);

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <title>
      Import
    </title>
    <link rel="stylesheet" href="common.css" type="text/css">
  </head>

  <body class="MAIN">
    <table>
      <tr>
        <td class="TBLHEAD" colspan="4" align="CENTER">
          <font class="TBLHEAD">
            Import data from a version 0.43 - 0.49 database
          </font>
        </td>
      </tr>
      <tr>
        <td class="LEFTCOL">
          <font class="TBLHEAD">
            <?php require "adminsetupmenu.php"; ?>
          </font>
        </td>
        <td class="CENTERCOL" colspan="3" align="CENTER">
          <font class="TBLROW">
The content of the tables have been copied. Do not run this script a second time as it will create duplicate data!!!!!
          </font>
        </td>
      </tr>
    </table>
  </body>
</html>

