<?php
/*
 * RELEASED AS GNU General Public License v3 (GPL-3)
 * http://www.gnu.org/licenses/quick-guide-gplv3.html
 *
 * Originally written by Tim R. Havens 2015-01-27 please track changes below
 *
 */
?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <title>Driveby</title>
      <link href="/driveby_new/css/jquery-ui.css" rel="stylesheet">
      <style>
      body{
         font: 62.5% "Trebuchet MS", sans-serif;
         margin: 50px;
      }
      .demoHeaders {
         margin-top: 2em;
      }
      #dialog-link {
         padding: .4em 1em .4em 20px;
         text-decoration: none;
         position: relative;
      }
      #dialog-link span.ui-icon {
         margin: 0 5px 0 0;
         position: absolute;
         left: .2em;
         top: 50%;
         margin-top: -8px;
      }
      #icons {
         margin: 0;
         padding: 0;
      }
      #icons li {
         margin: 2px;
         position: relative;
         padding: 4px 0;
         cursor: pointer;
         float: left;
         list-style: none;
      }
      #icons span.ui-icon {
         float: left;
         margin: 0 4px;
      }
      .fakewindowcontain .ui-widget-overlay {
         position: absolute;
      }
      select {
         width: 200px;
      }
      </style>
   </head>
   <body>
      <!-- Accordion -->
      <h2 class="demoHeaders">Driveby - Geotagged Noise Floor Recording</h2>
      <div id="accordion">
         <!-- <h3>Home</h3>
         <div>
            <b>NOTICE:</b> I've noticed that for real time I sometimes have to tail -f a file being used in the NF window.
            <br>
            like tail -f /mnt/nfs/disk1/driveby_data/50Mhz_data.out (para)
            <br>
            or   tail -f /disk1/driveby_data/50Mhz_data.out (tk1)
         </div> -->
         <h3>System Status</h3>
         <div><iframe frameBorder="0" src="/driveby_new/system_status.php" style="width:100%; height:400px"></iframe></div>
         <h3>GPS Status</h3>
         <div><iframe frameBorder="0" src="/driveby_new/gps_radar_off.php" style="width:100%; height:650px"></iframe></div>
         <h3>Active Noise Floor</h3>
         <div><iframe frameBorder="0" src="/driveby_new/nf.php" style="width:100%; height:600px" scrolling="no"></iframe></div>
         <h3>Google Map</h3>
         <!-- MAP is /driveby_new/map.php we need to add controls for it in here too
              We initialize this iframe with a blank page so that we aren't mapping until we really need to.
              this is so that we can save on RAM usage until we really intend to show the map
         -->
         <div>
            <a href="/driveby_new/blank.php" target="mapIframe">MAP (OFF)</a>&nbsp;|&nbsp;
            <a href="/driveby_new/map.php" target="mapIframe">MAP (ALL)</a>&nbsp;|&nbsp;
            <a href="/driveby_new/map.php?freq=44" target="mapIframe">MAP (44)</a>&nbsp;|&nbsp;
            <a href="/driveby_new/map.php?freq=50" target="mapIframe">MAP (50)</a>&nbsp;|&nbsp;
            <a href="/driveby_new/map.php?freq=144" target="mapIframe">MAP (144)</a>&nbsp;|&nbsp;
            <a href="/driveby_new/map.php?freq=222" target="mapIframe">MAP (222)</a>&nbsp;|&nbsp;
            <a href="/driveby_new/map.php?freq=432" target="mapIframe">MAP (432)</a><br><br>
            <iframe frameBorder="0" src="/driveby_new/blank.php" style="width:100%; height:600px" name="mapIframe"></iframe>
         </div>
         <h3>Map Archives</h3>
         <div>
             <iframe frameBorder="0" src="/driveby_new/map_arch.php" style="width:100%; height:600px" scrolling="no"></iframe>
         </div>
         <!-- still working on this, you'll have to edit classes/config.php to suite your setup until then -->
         <!-- <h3>Config</h3>
         <div>
             <iframe frameBorder="0" src="/driveby_new/config_view_editor.php" style="width:100%; height:600px" scrolling="yes"></iframe>
         </div> -->
         <h3>About</h3>
         <div>About</div>
      </div>


      <!-- UI STUFF -->

      <script src="/driveby_new/external/jquery/jquery.js"></script>
      <script src="/driveby_new/js/jquery-ui.js"></script>
      <script>

      $( "#accordion" ).accordion();

      var availableTags = [
         "ActionScript",
         "AppleScript",
         "Asp",
         "BASIC",
         "C",
         "C++",
         "Clojure",
         "COBOL",
         "ColdFusion",
         "Erlang",
         "Fortran",
         "Groovy",
         "Haskell",
         "Java",
         "JavaScript",
         "Lisp",
         "Perl",
         "PHP",
         "Python",
         "Ruby",
         "Scala",
         "Scheme"
      ];
      $( "#autocomplete" ).autocomplete({
         source: availableTags
      });

      $( "#button" ).button();
      $( "#radioset" ).buttonset();
      $( "#tabs" ).tabs();

      $( "#dialog" ).dialog({
         autoOpen: false,
         width: 400,
         buttons: [
            {
               text: "Ok",
               click: function() {
                  $( this ).dialog( "close" );
               }
            },
            {
               text: "Cancel",
               click: function() {
                  $( this ).dialog( "close" );
               }
            }
         ]
      });

      // Link to open the dialog
      $( "#dialog-link" ).click(function( event ) {
         $( "#dialog" ).dialog( "open" );
         event.preventDefault();
      });

      $( "#datepicker" ).datepicker({
         inline: true
      });

      $( "#slider" ).slider({
         range: true,
         values: [ 17, 67 ]
      });

      $( "#progressbar" ).progressbar({
         value: 20
      });

      $( "#spinner" ).spinner();
      $( "#menu" ).menu();
      $( "#tooltip" ).tooltip();
      $( "#selectmenu" ).selectmenu();

      // Hover states on the static widgets
      $( "#dialog-link, #icons li" ).hover(
         function() {
            $( this ).addClass( "ui-state-hover" );
         },
         function() {
            $( this ).removeClass( "ui-state-hover" );
         }
      );
      </script>
   </body>
</html>