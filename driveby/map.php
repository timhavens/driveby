<?php
   /*
    * RELEASED AS GNU General Public License v3 (GPL-3)
    * http://www.gnu.org/licenses/quick-guide-gplv3.html
    *
    * Originally written by Tim R. Havens 2015-01-27 please track changes below
    *
    */
   include_once ('classes/Config.class.inc');
   $config = new Config();
   $localhost = $config->conf->http_gui_host;
   $remotehost = $config->conf->http_gui_remote;

   $rtl_0_mhz = $config->conf->rtl[0]->mhz;
   $rtl_1_mhz = $config->conf->rtl[1]->mhz;
   $rtl_2_mhz = $config->conf->rtl[2]->mhz;
   $rtl_3_mhz = $config->conf->rtl[3]->mhz;
   $rtl_4_mhz = $config->conf->rtl[4]->mhz;

   $rtl_0_mhz = $config->conf->rtl[0]->mhz;
   $rtl_1_mhz = $config->conf->rtl[1]->mhz;
   $rtl_2_mhz = $config->conf->rtl[2]->mhz;
   $rtl_3_mhz = $config->conf->rtl[3]->mhz;
   $rtl_4_mhz = $config->conf->rtl[4]->mhz;

   $rtl_mhz_arr = array(0 => $rtl_0_mhz, 1 => $rtl_1_mhz, 2 => $rtl_2_mhz, 3 => $rtl_3_mhz, 4 => $rtl_4_mhz);
   $freq_rtl_arr = array($rtl_0_mhz => 0, $rtl_1_mhz => 1, $rtl_2_mhz => 2, $rtl_3_mhz => 3, $rtl_4_mhz => 4);

   $ts = 0;
   $rv_ts = 0;
   $freq = "";
   $center = true;
   if(isset($_REQUEST['nocenter'])) {
       $center = false;
   }
   if(isset($_REQUEST['ts'])) {
      $ts = $_REQUEST['ts'];
   }
   if(isset($_REQUEST['RV_TS']) and $_REQUEST['RV_TS'] != "") {
      $rv_ts = $_REQUEST['RV_TS'];
   }
   if(isset($_REQUEST['freq']) and $_REQUEST['freq'] != "") {
      $freq = $_REQUEST['freq'];
      $rtl_device = $freq_rtl_arr[$freq];

      if(!isset($freq_rtl_arr[$freq])) {
         echo "FREQ ($freq) RTL: ($rtl_device)\n\n";
         die("ERROR: No such FREQ");
      }
   }

/*
==> gps_data.out <==
3,1418501491,2014-12-13 20:11:31,37.859523333 -90.590053333,837.6,0.165,195.17,0
 */

   $live_sat_arr = array('lat'=>37.85952333,'long'=>-90.59005333);
   $fc_arr = array();

   if(file_exists('/disk1/driveby_data/gps_data.out')) {
      $fc_arr = array_reverse(array_slice(file('/disk1/driveby_data/gps_data.out'),-1));

      foreach($fc_arr as $ls_row) {
         $lsr = trim($ls_row);
         $ls_arr = explode(",",$lsr);
         $lat_long_arr = explode(" ",$ls_arr[3]);
         $live_sat_arr["lat"] = doubleval($lat_long_arr[0]);
         $live_sat_arr["long"] = doubleval($lat_long_arr[1]);
         break;
      }
   }
?>
<!DOCTYPE html>
<html>
  <head>
   <meta charset="utf-8">
   <title><?=$freq?> Heatmaps</title>
   <style>
      html, body, #map-canvas {
        height: 100%;
        margin: 0px;
        padding: 0px
      }
      #panel {
        position: absolute;
        top: 5px;
        left: 50%;
        margin-left: -180px;
        z-index: 5;
        background-color: #fff;
        padding: 5px;
        border: 1px solid #999;
      }
   </style>
   <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=visualization"></script>
   <script type="text/javascript">
      var map, pointarray, heatmap;
      var noiseFloorData = [];
      var latLongPointsObjArr = {}; // latLongPointsObjArr['37.123']['-100.3040']++;
      //
      //                            if(latLongPointsObjArr['37.123']['-100.3040']>=3) {
      //                               continue; // don't att this to the noiseFloorData[]
      //                            } http://stackoverflow.com/questions/4329092/multi-dimensional-associative-arrays-in-javascript
      //
      // https://developers.google.com/maps/documentation/javascript/heatmaplayer
      var xmlhttp = new XMLHttpRequest();
      var url = "/driveby/map_data_json.php?freq=<?=$freq?>";
      var last_time = <?=$ts?>;

      function getMapDataJson() {
         var xhr = new XMLHttpRequest();
         <?php
            if(!$rv_ts) {
               echo "var thisurl = url+'&ts='+last_time;\n"; //+'&freq=$freq'
            } else {
               echo "var thisurl = url+'&RV_TS=$rv_ts';\n"; // &freq=$freq'
            }
         ?>
         xhr.open('GET', thisurl, true);
         xhr.onload = function() {
            setNoiseFloorData(this.responseText);
         };
         xhr.send();
         <?php
            if(!$rv_ts) {
               echo "setTimeout(getMapDataJson,2500); // run this again every 10 seconds\n";
            }
         ?>
      }

      function initialize() {
         // MapTypeId.ROADMAP displays the default road map view. This is the default map type.
         // MapTypeId.SATELLITE displays Google Earth satellite images
         // MapTypeId.HYBRID displays a mixture of normal and satellite views
         // MapTypeId.TERRAIN displays a physical map based on terrain information.
        var mapOptions = {
          zoom: 16,
          center: new google.maps.LatLng(<?=$live_sat_arr["lat"]?>, <?=$live_sat_arr["long"]?>),
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

        var pointArray = new google.maps.MVCArray(noiseFloorData);

        heatmap = new google.maps.visualization.HeatmapLayer({
          data: pointArray
        });

        heatmap.set('maxIntensity',45);
        heatmap.setMap(map);
        //changeGradient();
        changeRadius();
        changeOpacity();
        changeDissipating();

      }

      function toggleHeatmap() {
        heatmap.setMap(heatmap.getMap() ? null : map);
      }

      function setNoiseFloorData(nfData) {
         var tmpNFData = JSON.parse(nfData);
         var arrayLength = tmpNFData.length;
         // lat, long, weight
         for (var i = 0; i < arrayLength; i++) {
            var lat = tmpNFData[i]['lat'];
            var lon = tmpNFData[i]['long'];
            var weight = tmpNFData[i]['weight'];
            if(tmpNFData[i]['timestamp'] > last_time) { last_time = tmpNFData[i]['timestamp']; }
            // we really only want to have 3-5 samples from a small radius of one lat/long position.
            // if we are stationary for say 15 minutes this overflow of data is just skewing our map.
            // we might want to implement a method to check if we're within say 10-20 ft of one of our
            // other logged readings, and if so NOT PUSH the new reading in HERE. ??? Just a thought.
            // this data gets pretty big pretty fast.
            if (typeof latLongPointsObjArr[lat.toString()] === 'undefined') {
               latLongPointsObjArr[lat.toString()] = {};
               if (typeof latLongPointsObjArr[lat.toString()][lon.toString()] === 'undefined') {
                  latLongPointsObjArr[lat][lon] = 1;
               }
            } else {
               latLongPointsObjArr[lat][lon]++;
            }
            if(latLongPointsObjArr[lat][lon] >= 30) {
                continue; // don't add this to the noiseFloorData[]
            }
            //   $live_sat_arr = array('lat'=>37.85952333,'long'=>-90.59005333);
            //if(Math.round((lat+0.00001)*100)/100 === 37.859 && Math.round((Math.abs(lon)+0.00001)*10)/10===Math.abs(-90.59)){
            //    continue;
            //}
            noiseFloorData.push({location: new google.maps.LatLng(lat, lon), weight: weight});
         }
         var pointArray = new google.maps.MVCArray(noiseFloorData);

         heatmap = new google.maps.visualization.HeatmapLayer({
            data: pointArray
         });

         heatmap.setMap(map);
      }

      function changeGradient() {
        var gradient = [
          'rgba(0, 255, 255, 0)',
          'rgba(0, 255, 255, 1)',
          'rgba(0, 191, 255, 1)',
          'rgba(0, 127, 255, 1)',
          'rgba(0, 63, 255, 1)',
          'rgba(0, 0, 255, 1)',
          'rgba(0, 0, 223, 1)',
          'rgba(0, 0, 191, 1)',
          'rgba(0, 0, 159, 1)',
          'rgba(0, 0, 127, 1)',
          'rgba(63, 0, 91, 1)',
          'rgba(127, 0, 63, 1)',
          'rgba(191, 0, 31, 1)',
          'rgba(255, 0, 0, 1)'
        ];
        heatmap.set('gradient', heatmap.get('gradient') ? null : gradient);
      }

      function changeDissipating() {
        heatmap.set('dissipating', heatmap.get('dissipating') ? null : true);
      }

      function changeRadius() {
        heatmap.set('radius', heatmap.get('radius') ? null : 15);
      }

      function changeOpacity() {
        heatmap.set('opacity', heatmap.get('opacity') ? null : 0.4);
      }

      function sleep(milliseconds) {
        var start = new Date().getTime();
        for (var i = 0; i < 1e7; i++) {
          if ((new Date().getTime() - start) > milliseconds){
            break;
          }
        }
      }

      // MAP CENTER UPDATES
      function mapSetCenter(lljson) {
         var LLData = JSON.parse(lljson);
         map.setCenter({lat: LLData["lat"], lng: LLData["long"]});
      }

      var llurl = "/driveby/gps_lat_long_table_json.php";

      function getMapCenterJson() {
         var xhr = new XMLHttpRequest();

         xhr.open('GET', llurl, true);
         xhr.onload = function() {
            mapSetCenter(this.responseText);
         };
         xhr.send();
         <?php if($center) { ?>
         setTimeout(getMapCenterJson,2000); // run this again every 10 seconds\n";
         <?php } ?>
      }
      // END MAP CENTER UPDATES

      getMapDataJson();
      <?php if($center) { ?>
      getMapCenterJson();
      <?php } ?>
      sleep(2000);
      google.maps.event.addDomListener(window, 'load', initialize);
    </script>
  </head>

  <body>
    <div id="map-canvas"></div>
  </body>
</html>
