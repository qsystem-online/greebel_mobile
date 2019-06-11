<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Simple Markers</title>
    <script  src="https://code.jquery.com/jquery-3.4.1.slim.min.js"  integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8="  crossorigin="anonymous"></script>
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
  </head>
  <body>
  <div style="width:100%;height:30%;background-color:blue">
      <button id="btnAddMarker">add Marker </button>
	</div>
    <div id="map"></div>
    <script>
      var map;
      $(function(){
        $("#btnAddMarker").click(function(event){
          var myLatLng = {lat: -25.363, lng: 131.044};
          var marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            title: 'Hello World dua !',
            label:'Hello World dua !',
            draggable:true,
          });

          marker.addListener('dragend', function() {
            //map.setZoom(8);
            //map.setCenter(marker.getPosition());
            alert(marker.getPosition());
          });
        });
      });
      function initMap() {
		  //-6.1842827,106.6746338
        //var myLatLng = {lat: -25.363, lng: 131.044};
		    var myLatLng = {lat: -6.1842827, lng: 106.6746338};
        map = new google.maps.Map(document.getElementById('map'), {
          zoom: 10,
          center: myLatLng
        });

        var marker = new google.maps.Marker({
          position: myLatLng,
          map: map,
          title: 'Hello World!'
        });
      }
	  //AIzaSyD0DBaS0703HyrtSZs_kfWv0SBpC_GKVpw
	  //AIzaSyDg_tzNYxrn-u0L5RVIl1C5QiwhQIrWBXI
	  //AIzaSyDX3-nmSX75j2NWCjKT1xOA21izJ9CXBdc
    </script>
	
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDg_tzNYxrn-u0L5RVIl1C5QiwhQIrWBXI&callback=initMap">   </script>
	
  </body>
</html>