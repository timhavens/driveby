<?php
/*
 * RELEASED AS GNU General Public License v3 (GPL-3)
 * http://www.gnu.org/licenses/quick-guide-gplv3.html
 *
 * Originally written by Tim R. Havens 2015-01-27 please track changes below
 *
 */
/*
  NOTE: https://developers.google.com/maps/documentation/javascript/tutorial

  rm /disk1/driveby_data/*.out
  php /home/ubuntu/driveby/test.php > /disk1/driveby_data/gps_data.out&
  rtl_power -d 0 -f 50000000:50300000:300k -i 3 -g 5 -w blackman -F 7 -c 20% /disk1/driveby_data/50mhz_data.out&
  rtl_power -d 1 -f 154700000:154900000:300k -i 3 -g 5 -w blackman -F 7 -c 20% /disk1/driveby_data/154mhz_data.out&
  rtl_power -d 2 -f 222000000:222300000:300k -i 3 -g 5 -w blackman -F 7 -c 20% /disk1/driveby_data/222mhz_data.out&
  rtl_power -d 3 -f 432000000:432300000:300k -i 3 -g 5 -w blackman -F 7 -c 20% /disk1/driveby_data/432mhz_data.out&
  tail -f /disk1/driveby_data/*.out
 */
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
   <head>
      <meta charset="UTF-8">
      <title>Driveby = Drive Test RF Noise Floor Monitoring</title>
   </head>
   <body style="font-family:Arial;background-color:grey;">
      <table style="width:100%; height:100%;">
         <tr style="width:100%; height:500px;">
            <td style="width:50%; height:100%;background-color:white;"><iframe frameBorder="0" src="/driveby/system_status.php" style="width:100%; height:250px"></iframe></td>
            <td style="width:50%; height:100%;"><iframe frameBorder="0" src="/driveby/gps.php" style="width:100%; height:250px"></iframe></td>
         </tr>
         <tr colspan=2 style="width:100%; height:500px;">
            <td style="width:50%; height:100%;"><iframe frameBorder="0" src="/driveby/control.php" style="width:100%; height:500px"></iframe></td>
            <td style="width:50%; height:100%;"><iframe frameBorder="0" src="/driveby/nf.php" style="width:100%; height:500px"></iframe></td>
         </tr>
      </table>
   </body>
</html>
