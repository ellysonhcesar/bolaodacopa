<?php
/*********************************************************
 * Author: John Astill (c)
 * Date  : 20th March 2003
 * File  : configvalues.php
 *********************************************************/
  $link = OpenConnection();
  $query = "select * from $dbaseConfigData where lid='$leagueID'";

  $result = mysqli_query($link,$query) 
    or die("Unable to read config data: $query<br>\n".mysql_error());
  if ($result != FALSE) {
    $arr = array();
    while ($line = mysqli_fetch_array($result)) {
      $param = $line["param"];
      $val = $line["value"];
      $arr["$param"] = $val;
    }

    // There is a tight cohesion between the coding and the contents of the config
    // database.
    $hideNoPredictions = $arr["HIDE_0_PREDS"];
    $useMessaging = false;//$arr["USE_MESSAGING"];
    $corrHomeScore = $arr["CORR_HOME_SCORE"];
    $corrAwayScore = $arr["CORR_AWAY_SCORE"];
    $corrMargin = $arr["CORR_MARGIN"];
    $corrResult = $arr["CORR_RESULT"];
    $corrScore = $arr["CORR_SCORE"];
    $PredictionLeagueTitle = $arr["PRED_LEAGUE_TITLE"];
    $defaulticon = $arr["DEF_ICON"];
    $homePage = "";//$arr["HOME_PAGE_URL"];
    $homePageTitle = "";//$arr["HOME_PAGE_TITLE"];
    $allowMultipleUserPerEmail = $arr["MULT_USERS"];
    $timezoneOffset = $arr["TZ_OFFSET"];
    $reverseUserPredictions = $arr["REV_USER_PREDS"];
    $usersPerPage = $arr["USERS_PER_PAGE"];
    if ($usersPerPage < 1) {
      $usersPerPage = 10;
    }
    $maxAdminUsers = $arr["MAX_ADMIN_USERS"];
    //$isauto = $arr["ISAUTO"];
    $NumMultFixts = $arr["NUMMULTFIXTS"];
    $ViewUserPredictions = $arr["VIEWUSERPREDS"];
    $Use24Hr = $arr["USE24HR"];
    $UploadIcons = $arr["UPLOADICONS"];
    $MaxIconFileSize = $arr["ICONSIZE"];
    $PasswordEncryption = $arr["PASSWORDENCRYPT"];
    $LockedGame = $arr["LOCKEDGAME"];
	$HoursToShow = 0.5;
	
	
  }

  CloseConnection($link);
?>
