<?php
/*
 * RELEASED AS GNU General Public License v3 (GPL-3)
 * http://www.gnu.org/licenses/quick-guide-gplv3.html
 *
 * Originally written by Tim R. Havens 2015-01-27 please track changes below
 *
 */
?>
<!DOCTYPE HTML>
<html>
   <head>
      <style>
         body {
            margin: 0px;
            padding: 0px;
         }
      </style>
   </head>
   <body>
      <table>
         <tr>
            <td>
               <canvas id="oneCanvas" width="120" height="120"></canvas>
               <script>
                  var canvas = document.getElementById('oneCanvas');
                  var context = canvas.getContext('2d');

                  var elem = document.getElementById('oneCanvas')
                  elem.addEventListener('click', function(event) {
                     parent.document.getElementById('contentFrame').src = "/driveby/system_status.php";
                  }, false);

                  context.beginPath();
                  context.rect(10, 10, 100, 100); // FROM-L, FROM-T, Horz-Width, Vert-Height
                  context.fillStyle = 'gray';
                  context.fill();
                  context.lineWidth = 7;
                  context.strokeStyle = 'black';
                  context.stroke();

                  var x = canvas.width / 2;
                  var y = canvas.height / 2;

                  context.font = '14pt Calibri';
                  context.textAlign = 'center';
                  context.fillStyle = 'white';
                  context.fillText('Home', x, y);
               </script>
            </td>
         </tr>
         <tr>
            <td>
               <canvas id="twoCanvas" width="120" height="120"></canvas>
               <script>
                  var canvas = document.getElementById('twoCanvas');
                  var context = canvas.getContext('2d');

                  var elem = document.getElementById('twoCanvas')
                  elem.addEventListener('click', function(event) {
                     parent.document.getElementById('contentFrame').src = "/driveby/gps.php";
                  }, false);

                  context.beginPath();
                  context.rect(10, 10, 100, 100); // FROM-L, FROM-T, Horz-Width, Vert-Height
                  context.fillStyle = 'green';
                  context.fill();
                  context.lineWidth = 7;
                  context.strokeStyle = 'black';
                  context.stroke();

                  var x = canvas.width / 2;
                  var y = canvas.height / 2;

                  context.font = '14pt Calibri';
                  context.textAlign = 'center';
                  context.fillStyle = 'white';
                  context.fillText('GPS', x, y);
               </script>
            </td>
         </tr>
         <tr>
            <td>
               <canvas id="threeCanvas" width="120" height=120"></canvas>
               <script>
                  var canvas = document.getElementById('threeCanvas');
                  var context = canvas.getContext('2d');

                  var elem = document.getElementById('threeCanvas')
                  elem.addEventListener('click', function(event) {
                     parent.document.getElementById('contentFrame').src = "/driveby/gps_radar.php";
                  }, false);

                  context.beginPath();
                  context.rect(10, 10, 100, 100); // FROM-L, FROM-T, Horz-Width, Vert-Height
                  context.fillStyle = 'yellow';
                  context.fill();
                  context.lineWidth = 7;
                  context.strokeStyle = 'black';
                  context.stroke();

                  var x = canvas.width / 2;
                  var y = canvas.height / 2;

                  context.font = '14pt Calibri';
                  context.textAlign = 'center';
                  context.fillStyle = 'black';
                  context.fillText('GPS STAT', x, y);
               </script>
            </td>
         </tr>
         <tr>
            <td>
               <canvas id="fourCanvas" width="120" height="120"></canvas>
               <script>
                  var canvas = document.getElementById('fourCanvas');
                  var context = canvas.getContext('2d');

                  var elem = document.getElementById('fourCanvas')
                  elem.addEventListener('click', function(event) {
                     parent.document.getElementById('contentFrame').src = "/driveby/control.php";
                  }, false);

                  context.beginPath();
                  context.rect(10, 10, 100, 100); // FROM-L, FROM-T, Horz-Width, Vert-Height
                  context.fillStyle = 'orange';
                  context.fill();
                  context.lineWidth = 7;
                  context.strokeStyle = 'black';
                  context.stroke();

                  var x = canvas.width / 2;
                  var y = canvas.height / 2;

                  context.font = '14pt Calibri';
                  context.textAlign = 'center';
                  context.fillStyle = 'white';
                  context.fillText('RF', x, y);
               </script>
            </td>
         </tr>
         <tr>
            <td>
               <canvas id="fiveCanvas" width="120" height="120"></canvas>
               <script>
                  var canvas = document.getElementById('fiveCanvas');
                  var context = canvas.getContext('2d');

                  var elem = document.getElementById('fiveCanvas')
                  elem.addEventListener('click', function(event) {
                     parent.document.getElementById('contentFrame').src = "/driveby/system_status.php";
                  }, false);

                  context.beginPath();
                  context.rect(10, 10, 100, 100); // FROM-L, FROM-T, Horz-Width, Vert-Height
                  context.fillStyle = 'red';
                  context.fill();
                  context.lineWidth = 7;
                  context.strokeStyle = 'black';
                  context.stroke();

                  var x = canvas.width / 2;
                  var y = canvas.height / 2;

                  context.font = '14pt Calibri';
                  context.textAlign = 'center';
                  context.fillStyle = 'white';
                  context.fillText('System', x, y);
               </script>
            </td>
         </tr>
         <tr>
            <td>
               <canvas id="sixCanvas" width="120" height="120"></canvas>
               <script>
                  var canvas = document.getElementById('sixCanvas');
                  var context = canvas.getContext('2d');

                  var elem = document.getElementById('sixCanvas')
                  elem.addEventListener('click', function(event) {
                     parent.document.getElementById('contentFrame').src = "/driveby/nf.php";
                  }, false);

                  context.beginPath();
                  context.rect(10, 10, 100, 100); // FROM-L, FROM-T, Horz-Width, Vert-Height
                  context.fillStyle = 'blue';
                  context.fill();
                  context.lineWidth = 7;
                  context.strokeStyle = 'black';
                  context.stroke();

                  var x = canvas.width / 2;
                  var y = canvas.height / 2;

                  context.font = '14pt Calibri';
                  context.textAlign = 'center';
                  context.fillStyle = 'white';
                  context.fillText('NFloor', x, y);
               </script>
            </td>
         </tr>
      </table>
   </body>
</html>

