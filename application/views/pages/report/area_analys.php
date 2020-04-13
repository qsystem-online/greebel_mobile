<style>
  #map {
    
    height: 500px;
  }
  
</style>
<div>
	<select id="fst_provinsi">
  		<?php
			foreach($listProvinsi as $provinsi){
				echo "<option value='$provinsi->fst_kode'>$provinsi->fst_nama</option>";
			}
		?>
	</select>  
	<button id="btnPickupLocation">Show</button>
</div>

<?php
	echo $pickup_location_modal;
?>

<script type="text/javascript">
	$(function(){
		$("#btnPickupLocation").click(function(e){
			e.preventDefault();
			queryLocation();
			/*
			PickupLocation.show(function(location){
				App.log(location.toString());
			});
			*/
		});
		initMap();
	});
</script>
<div id="map"></div>
<script>
	var map;
	var arrMarker = [];

	function initMap() {	
		var myLatLng = {lat: -1.363, lng: 120.044}; //Indonesia Center		
		map = new google.maps.Map(document.getElementById('map'), {
			center: {lat: -1.397, lng: 120.644},
			zoom: 5
		});

		google.maps.event.addListener(map, 'zoom_changed', function() {
			var zoom = map.getZoom();
			$.each(arrMarker,function(i,marker){
				if (marker.viewZoomLevel <= zoom){
					marker.setVisible(true);
					if (!marker.isSchool){
						marker.radius.setVisible(true);
					}
					
				}else{
					marker.setVisible(false);
					marker.radius.setVisible(false);
				}
			});			
		});
		
	}

	function queryLocation(){
		var fstKodeProvinsi = $("#fst_provinsi").val();
		
		$.ajax({
			url:"<?=site_url()?>/report/area_analys/ajxQueryLocation/" + fstKodeProvinsi,
			method:"GET",
		}).done(function(resp){

			if (resp.status == "SUCCESS"){

				$.each(arrMarker,function(i,marker){
					marker.setMap(null);
					marker.radius.setMap(null);
				});

				arrMarker = [];		


				listLocation = resp.data;
				var iconStore = "<?=site_url()?>/assets/system/images/store-icon.png";
				var iconSchool = "<?=site_url()?>/assets/system/images/school-icon.png";

				$.each(listLocation,function(i,location){
					var marker = new google.maps.Marker({
						position: {
							lat: parseFloat(location.fst_cust_location.split(",")[0]),
							lng: parseFloat(location.fst_cust_location.split(",")[1]),
						},
						map: map,
						visible:true,
						viewZoomLevel:location.fin_view_zoom_level,
						isSchool:location.fin_price_group_id == 4 ? true : false,
						icon:{
							url: location.fin_price_group_id == 4 ? iconSchool : iconStore,
						},
						radius: new google.maps.Circle({
							strokeColor: '#FF0000',
							strokeOpacity: 0.5,
							strokeWeight: 1,
							fillColor: '#FF0000',
							fillOpacity: 0.20,
							map: map,
							center: {
								lat:parseFloat(location.fst_cust_location.split(",")[0]),
								lng:parseFloat(location.fst_cust_location.split(",")[1]),
							},
							radius: parseInt(location.fin_radius_meters), //1 km radius base on meter
							visible:true,
						}),
						
						title: location.fst_cust_name
					});
					arrMarker.push(marker);
				});

			}
		});
	}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyALBylGkXyB-P1boXwMtz7oCV0L8-aHEBA"></script>