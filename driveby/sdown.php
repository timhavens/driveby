<?php
/*
 * RELEASED AS GNU General Public License v3 (GPL-3)
 * http://www.gnu.org/licenses/quick-guide-gplv3.html
 *
 * Originally written by Tim R. Havens 2015-01-27 please track changes below
 *
 */

   if(isset($_REQUEST['submit']) and $_REQUEST['submit'] == 'shutdown') {
      $cmd = 'sudo -u root /usr/bin/shut_down';
      passthru($cmd);
   }

?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="UTF-8">
      <title>Driveby - System Status</title>
   </head>
   <body style="font-family:Arial;background-color:white;">
      <form action="/driveby_new/sdown.php" method="post" target="tsd_iframe">
         <button type="submit" value="shutdown" name="submit">Shutdown <?=php_uname('n')?></button>
      </form>
   </body>
</html>