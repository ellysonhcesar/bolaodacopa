<?php 
/*********************************************************
 * Author: John Astill
 * Date  : 10th December
 * File  : loginpanel.php
 * Desc  : Display the login panel if an user is not 
 *       : logged in.
 ********************************************************/
require (GetLangFile());

if ($User == 0 || $User->loggedIn == FALSE) {
?>
  <!-- Login panel -->
  <form method="POST" action="login.php">
    <table class="LOGINTB">
      <tr>
        <td align="center" colspan="2" class="LOGINHD">
          <font class="LOGINHD">
            <?php echo $Login_txt."\n"; ?>
          </font>
        </td>
      </tr>
      <tr>
        <td colspan="1" class="LOGINRW">
          <font class="LOGINRW">
            <?php echo $Username_txt."\n"; ?>
          </font>
        </td>
        <td colspan="1" class="LOGINRW">
          <font class="LOGINRW">
            <input type="text" size="8" name="LOGIN">
          </font>
        </td>
      </tr>
      <tr>
        <td colspan="1" class="LOGINRW">
          <font class="LOGINRW">
            <?php echo $Password_txt."\n"; ?>
          </font>
        </td>
        <td colspan="1" class="LOGINRW">
          <font class="LOGINRW">
            <input type="password" size="8" name="PWD">
          </font>
        </td>
      </tr>
      <tr>
        <td align="center" colspan="2" class="LOGINRW">
          <font class="LOGINRW">
            <input type="submit" name="logon" value="<?php echo $Logon; ?>">
          </font>
        </td>
      </tr>
<?php
// Only display this if the game is not locked.
if ($LockedGame != "TRUE") {
?>
      <tr>
        <td colspan="2" class="LOGINRW">
          <font class="LOGINRW">
            <a href="createnewuser.php?sid="><?php echo $New_User; ?></a>
          </font>
        </td>
      </tr>
<?php
}
?>
    
    </table>
  </form>
<?php 
} 
?>
