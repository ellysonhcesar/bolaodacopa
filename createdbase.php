<?php
/*********************************************************
 * Author: John Astill
 * Date  : 10th December
 * File  : createdbase.php
 * Desc  : Create the required database and tables for
 *       : the prediction league. This script interacts
 *       : with the given database to create the correct
 *       : structure of tables for the prediction league.
 *       : If the tables are created successfully, the 
 *       : created structure of database and tables is 
 *       : displayed.
 ********************************************************/
require "systemvars.php";

  $url = $_POST["URL"];
  $dbname = $_POST["DBASENAME"];
  $username = $_POST["USERNAME"];
  $password = $_POST["PASSWORD"];
  $create = $_POST["CREATEDB"];
  $createtables = $_POST["CREATETABLES"];
  $userDataTblName = $dbaseUserData;
  $predDataTblName = $dbasePredictionData;
  $matchDataTblName = $dbaseMatchData;
  $standingsTblName = $dbaseStandings;

  // Connect to the host.
  $link = mysqli_connect($url, $username, $password)
      or die("Could not connect to $url $username $password");

  // Only create the database if requested to.
  if ($create == "TRUE") {
    // Create the database
    $db = mysqli_query($link,"create database $dbname");
    if ($db == FALSE) {
      echo "Unable to create database $dbname. Make sure $dbname does not already exist\n";
      exit;
    }
  }

  $link = mysqli_connect($url, $username, $password, $dbname)
      or die("Could not connect to $url $username $password");
  
  
  if ($createtables == "TRUE") {
    $query = "create table $dbname.$dbaseUserData (lid int not null , userid int not null auto_increment, username varchar($userlen) not null , password varchar($passlen), email varchar($emaillen), icon varchar($fnamelen), lang varchar(32), usertype smallint, dflths smallint default 0, dfltas smallint default 0, since DATE, auto enum('Y','N') default 'N', primary key (lid,userid));";
    $userresult = mysqli_query($link,$query)
        or die("Query failed: $query<br>\n".mysql_error());

  $query = "create table $dbname.$dbasePredictionData (lid int not null , userid int not null, matchid int not null ,predtime timestamp, homescore smallint unsigned, awayscore smallint unsigned, isauto enum('Y','N') default 'N', primary key(lid, userid, matchid))";
    $userresult = mysqli_query($link,$query)
      or die("Query failed: $query<br>\n".mysql_error());

    $query = "create table $dbname.$dbaseMatchData (lid int not null, matchid int not null auto_increment, matchdate DATETIME not null, hometeam varchar($teamlen) not null, awayteam varchar($teamlen) not null, homescore smallint unsigned, awayscore smallint unsigned, primary key(lid,matchid));";
    $userresult = mysqli_query($link,$query)
      or die("Query failed: $query<br>\n".mysql_error());

    $query = "create table $dbname.$dbaseStandings (lid int not null, userid int not null, position smallint not null, pld int unsigned, won int unsigned, drawn int unsigned, lost int unsigned, gfor smallint unsigned, gagainst smallint unsigned, diff smallint, points int unsigned, primary key(lid,userid));";
    $userresult = mysqli_query($link,$query)
      or die("Query failed: $query<br>\n".mysql_error());

    $query = "create table $dbname.$dbaseConfigData (lid int not null, grp int not null, param varchar(32) not null, value varchar(90) not null, descr text not null, ro enum('Y','N') default 'N', primary key(lid,param));";
    $userresult = mysqli_query($link,$query)
      or die("Query failed: $query<br>\n".mysql_error());

    $query = "create table $dbname.$dbaseMsgData (lid int not null, msgid int not null auto_increment, threadid int, prevmsg int, sender int not null, receiver int not null, subject varchar(255), body text, status enum(\"new\",\"read\",\"deleted\"), msgtime timestamp, primary key(lid,msgid));";
    $userresult = mysqli_query($link,$query)
      or die("Query failed: $query<br>\n".mysql_error());
  }

  PopulateConfigTable();
?>
<html>
  <head>
    <title>
      Created Database <?php echo $dbname; ?>
    </title>
    <link rel="stylesheet" href="common.css" type="text/css">
  </head>

  <body class="MAIN">
    <table>
      <tr>
        <td class="TBLHEAD" colspan="4" align="CENTER">
          <font class="TBLHEAD">
            Database and Table Administration
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
          <font class="TBLHEAD">
<table width="400">
<tr>
<td colspan="2" align="CENTER" class="TBLHEAD">
<font class="TBLHEAD">
<b>
Database <?php echo $dbname ?>
</b>
</font>
</td>
</tr>
<tr>
<td align="CENTER" class="TBLHEAD">
<font class="TBLHEAD">
Table
</font>
</td>
<td align="CENTER" class="TBLHEAD">
<font class="TBLHEAD">
Attributes
</font>
</td>
</tr>
<?php
  
  // List the table names.
  $tbl_list = mysqli_query($link,"SHOW TABLES FROM $dbname");
  
  $i = 0;
  
   while ($i = mysqli_fetch_row($tbl_list)) {
    echo "<tr><td valign=\"TOP\" class=\"TBLROW\"><font class=\"TBLROW\">";
	  //$tb_names[$i] = $i[0];
      //echo $tb_names[$i];
	  echo $i[0];

      // List the field names.
     // $fields = mysql_list_fields($dbname, $i[0], $link);
      //$columns = mysql_num_fields($fields);
	  
	  $fields = mysqli_query($link,"SHOW COLUMNS FROM $i[0]");
	  $x = 0;
	  
      echo "</font></td>";
      echo "<td class=\"TBLROW\"><font class=\"TBLROW\">";
     while ($x = mysqli_fetch_row($fields)) {
	 // for ($j = 0; $j < $columns; $j++) {
       //   echo mysql_field_name($fields, $j) . "<br>\n";
	   echo $x[0] . "<br>\n";
      }
      
      $i++;
    echo "</font></td></tr>";
  }
?>
</table>

          </font>
        </td>
      </tr>
    </table>

  </body>
</html>

