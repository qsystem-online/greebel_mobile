<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link rel="stylesheet" href="<?=COMPONENT_URL?>bower_components/select2/dist/css/select2.min.css">

<style type="text/css">
	.border-0{
		border: 0px;
	}
	td{
		padding: 2px; !important 		
	}

	.nav-tabs-custom>.nav-tabs>li.active>a{
		font-weight:bold;
		border-left-color: #3c8dbc;
		border-right-color: #3c8dbc;
		border-style:fixed;
	}
	.nav-tabs-custom>.nav-tabs{
		border-bottom-color: #3c8dbc;        
		border-bottom-style:fixed;
	}
	
	  /* Always set the map height explicitly to define the size of the div
	   * element that contains the map. */
	  #map {
		height: 500px;
	  }
	  /* Optional: Makes the sample page fill the window. */
	  html, body {
		height: 100%;
		margin: 0;
		padding: 0;
	  }
	
</style>

<section class="content-header">
	<h1><?=lang("User")?><small><?=lang("maps")?></small></h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> <?= lang("Home") ?></a></li>
		<li><a href="#"><?= lang("Customer") ?></a></li>
		<li class="active title"><?=$title?></li>
	</ol>
</section>

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title title"><?=$title?></h3>
				</div>
			
				<div class="box-body">
					<form class="form-horizontal">
						<div class='form-group'>
							<label for="fst_customer_code" class="col-sm-2 control-label"><?=lang("Customer")?></label>
							<div class="col-sm-10">
								<select class="form-control" id="fst_customer_code" placeholder="<?=lang("Customer")?>" name="fst_customer_code[]"  multiple="multiple"></select>
								<div id="fst_customer_code_err" class="text-danger"></div>
							</div>
						</div>
					</form>
				</div>			            
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div id="map"></div>
		</div>
	</div>
</section>

<script type="text/javascript">
	var map;
	var arrMarker = [];
	//var directionsService;
	var directionsDisplay;

	var arrLabel = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
	$(function(){
		$("#fst_customer_code").select2({
			minimumInputLength: 3,
			ajax:{
				url:"<?=site_url()?>customer/ajxCustList",
				dataType: 'json',
				delay:250,
				processResults: function (resp) {
					console.log(resp.data);
					var customerList =[];

					$.each(resp.data,function(i,value){
						customerList.push({
							"id" : value.fst_cust_code,
							"text" : value.fst_cust_name,
							"loc_lat" : value.fst_lat,
							"loc_log" : value.fst_log
						});
					});				
					return {
						results: customerList
					};
				}
				
			}
			//data: items,
		}).on("change",function(e){
			$selectedData = $('#fst_customer_code').select2("data");
			for (var i = 0; i < arrMarker.length; i++) {
				arrMarker[i].setMap(null);
			}
			arrMarker = [];

			$.each($selectedData,function(i,v){
				console.log(v);
				if (v.loc_lat == "0" && v.loc_loc == "0"){
					//alert("0,0");
					return true;
					//continue;
				}
				myLatLng = {lat: parseFloat(v.loc_lat), lng: parseFloat(v.loc_log)};
				console.log(myLatLng);
				var marker = new google.maps.Marker({
					position: myLatLng,
					map: map,
					//label: arrLabel[i],                            
					label:{
						text:v.text,
						//color:"#4074b4",
						color:"#000000",
						fontWeight:"bold",
					},                            
					title: v.text
				});
				
				arrMarker.push(marker);

			});
		});

		/*
		$.ajax({
			url: '<=site_url()?>customer/get_customer',
			dataType: 'json',
			success:function(data){                
				items = [];
				data = data.data;
				$.each(data,function(index,value){
					items.push({
						"id" : value.fst_cust_code,
						"text" : value.fst_cust_name,
						"loc_lat" : value.fst_lat,
						"loc_log" : value.fst_log
					});
				});

				$("#fst_customer_code").select2({
					//data: items,
				}).on("change",function(e){
					$selectedData = $('#fst_customer_code').select2("data");
					for (var i = 0; i < arrMarker.length; i++) {
						arrMarker[i].setMap(null);
					}
					arrMarker = [];

					$.each($selectedData,function(i,v){
						console.log(v);
						if (v.loc_lat == "0" && v.loc_loc == "0"){
							//alert("0,0");
							return true;
							//continue;
						}
						myLatLng = {lat: parseFloat(v.loc_lat), lng: parseFloat(v.loc_log)};
						console.log(myLatLng);
						var marker = new google.maps.Marker({
							position: myLatLng,
							map: map,
							//label: arrLabel[i],                            
							label:{
								text:v.text,
								//color:"#4074b4",
								color:"#000000",
								fontWeight:"bold",
							},                            
							title: v.text
						});
						
						arrMarker.push(marker);

					});
				});
			}        
		});
		*/

	});

	function initMap() {
		var myLatLng = {lat: -6.1842827, lng: 106.6746338};
		var myLatLng2 = {lat: -6.1825369, lng: 106.7749226};
		var monas = {lat: -6.175348605248423, lng: 106.8272454485018};

		map = new google.maps.Map(document.getElementById('map'), {
			zoom: 10,
			center: monas
		});

		directionsDisplay = new google.maps.DirectionsRenderer({
			suppressInfoWindows: true,
			suppressMarkers: true
		});
		
	   
		
		/*
		var marker = new google.maps.Marker({
			position: myLatLng,
			map: map,
			title: 'Hello World!'
		});
		var marker = new google.maps.Marker({
			position: myLatLng2,
			map: map,
			title: 'Hello World!'
		});
		*/

		google.maps.event.addListener(map, "dblclick", function(event) {
			var _currentPoints = event.latLng;
			alert(_currentPoints);
			console.log(_currentPoints);
		});

	}

	//AIzaSyDg_tzNYxrn-u0L5RVIl1C5QiwhQIrWBXI
	//AIzaSyALBylGkXyB-P1boXwMtz7oCV0L8-aHEBA
	//AIzaSyCN8-AYGQU5NGopLLCQaqXmvwty4jHEpC0

</script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCN8-AYGQU5NGopLLCQaqXmvwty4jHEpC0&callback=initMap">   </script>

<!-- Select2 -->
<script src="<?=COMPONENT_URL?>bower_components/select2/dist/js/select2.full.js"></script>