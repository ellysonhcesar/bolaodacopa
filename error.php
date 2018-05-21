<?php 
/*********************************************************
 * Author: John Astill
 * Date  : 23rd January 2002
 * File  : error.php
 * Desc  : Error handling functions
 ********************************************************/

/*******************************************************
 * Email the error notification to the administrator
 * @param errorString a string indicating the error.
 *******************************************************/
function ErrorNotify($errorString) {
  global $ErrorCode;

  $ErrorCode = $errorString;
  
  @mail($adminEmailAddr, "$PredictionLeagueTitle Error",$errorString,"From: $adminEmailAddr");
}

/*******************************************************
 * Email the error notification to the administrator
 * @param errorString a string indicating the error.
 *******************************************************/
function ErrorRedir($errorString, $url) {
  global $ErrorCode, $HTTP_REFERER, $HTTP_HOST;

  $ErrorCode = $errorString;
  
  if (false == $_SESSION['ErrorCode'] = $ErrorCode) {
    echo "Could not register ErrorCode: $ErrorCode";
    exit;
  }
  if (FALSE == headers_sent()) {
    /* Redirect browser to PHP web site */
    header("Location: $url"); 
    exit; 
  } else {
    $errorString = "HTTP Error headers already sent from $HTTP_REFERER on $HTTP_HOST".$errorString;
    @mail($adminEmailAddr, "$PredictionLeagueTitle Error",$errorString,"From: $adminEmailAddr");
  }
}

/*******************************************************
 * Email the error notification to the administrator
 * @param errorString a string indicating the error.
 *******************************************************/
function ClearErrorCode() {
  global $ErrorCode;
  $ErrorCode = "";
}
