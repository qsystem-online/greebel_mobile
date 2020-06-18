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
	<h1><?=lang("User")?><small><?=lang("form")?></small></h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> <?= lang("Home") ?></a></li>
		<li><a href="#"><?= lang("User") ?></a></li>
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
                            <label for="fst_sales_code" class="col-sm-2 control-label"><?=lang("Sales")?></label>
                            <div class="col-sm-3">
                                <select class="form-control" id="fst_sales_code" placeholder="<?=lang("Sales")?>" name="fst_sales_code" ></select>
                                <div id="fst_sales_code_err" class="text-danger"></div>
                            </div>
                            <label for="fdt_date" class="col-sm-2 control-label"><?=lang("Date")?></label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control datepicker" id="fdt_date" placeholder="<?=lang("Date")?>" name="fdt_date" >
                                <div id="fdt_date" class="text-danger"></div>
                            </div>
                            <button id="btnTrack" class="btn btn-primary btn-sm">Track</button>
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
    var arrWaypoint =[];
    //var directionsService;
    var directionsDisplay;

    var arrLabel = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
	$(function(){

        $.ajax({
            url: '<?=site_url()?>sales/get_sales',
			dataType: 'json',
            success:function(data){
                
				items = [];
				data = data.data;
				$.each(data,function(index,value){
					items.push({
						"id" : value.fst_sales_code,
						"text" : value.fst_sales_name
					});
				});

                $("#fst_sales_code").select2({
                    data: items,
                });

            }
        
        });

        

        $("#btnTrack").click(function(event){
            event.preventDefault();
            var data = {
                fst_sales_code : $("#fst_sales_code").val(),
                fdt_date : $("#fdt_date").val(),
                "<?=$this->security->get_csrf_token_name()?>" : "<?=$this->security->get_csrf_hash()?>"
            }

            $.ajax({
                url:"<?=base_url()?>sales/data_tracking/",
                data: data,
                method:"POST",
                success: function (resp){
                    
                    for (var i = 0; i < arrMarker.length; i++) {
                        arrMarker[i].setMap(null);
                    }
                    arrMarker = [];
                    arrWaypoint =[];
                    arrPart = [];


                    //directionsDisplay.setMap(null);

                    var iPart = 1;
                    $.each(resp,function(i,v){
                        if (v.isOnSchedule){
                            icon = "http://maps.google.com/mapfiles/ms/icons/green-dot.png";
                        }else{
                            icon = "http://maps.google.com/mapfiles/ms/icons/red-dot.png";
                        }

                        myLatLng = {lat: parseFloat(v.fst_lat), lng: parseFloat(v.fst_log)};
                        
                        if(i == 1){
                            map.setCenter({lat:myLatLng.lat, lng:myLatLng.lng});
                        }

                        var marker = new google.maps.Marker({
                            position: myLatLng,
                            map: map,
                            label: arrLabel[i],
                            icon: {                             
                                url: icon
                            },
                            /*
                            label:{
                                text:v.fst_cust_name,
                                //color:"#4074b4",
                                color:"#000000",
                                fontWeight:"bold",
                            },
                            */
                            title: "(" + v.fin_id + ")" + v.fst_cust_name,
                        });    

                        arrMarker.push(marker);
                       
                        arrWaypoint.push({
                            location: myLatLng,
                            stopover: true
                        });
                        
                        
                        if (iPart == 25 || i == resp.length - 1){
                            arrPart.push(arrWaypoint);
                            arrWaypoint = [];
                            iPart = 1;
                        }
                        console.log(i + " vs " + resp.length)
                        iPart++;
                    });
                    

                    var directionsService = new google.maps.DirectionsService;
                    
                    console.log(arrPart);
                    $.each(arrPart,function(i,v){
                        //lastPos = resp.length - 1;
                        //locOrigin = {lat: parseFloat(resp[0].fst_lat), lng: parseFloat(resp[0].fst_log)};
                        //locDest = {lat: parseFloat(resp[lastPos].fst_lat), lng: parseFloat(resp[lastPos].fst_log)};
                        if (i == 0){
                            //return true;
                        }
                        console.log(v);

                        lastPos = v.length - 1;
                        locOrigin = v[0].location;
                        locDest = v[lastPos].location;

                        _request = {
                            origin: locOrigin,
                            destination: locDest,                            
                            waypoints: v,
                            optimizeWaypoints: true,
                            travelMode: google.maps.DirectionsTravelMode.DRIVING
                        };
                        console.log(_request);
                        directionsService.route(_request, function(_response, _status) {
                            if (_status == google.maps.DirectionsStatus.OK) {
                                var directionsDisplay = new google.maps.DirectionsRenderer({
                                    suppressInfoWindows: true,
                                    suppressMarkers: true,
                                    preserveViewport: true 
                                });
                                directionsDisplay.setMap(map);
                                directionsDisplay.setDirections(_response);
                            }

                        });

                    });

                    
                       
                    
                }

            });
        })

        $("#unusage_fst_sales_codea").select2({
			//tokenSeparators: [",", " "],
			ajax: {
				url: '<?=site_url()?>sales/get_sales',
				dataType: 'json',
				delay: 250,
				processResults: function (data){
                    console.log(data);
					items = [];
					data = data.data;
					$.each(data,function(index,value){
						items.push({
							"id" : value.fst_sales_code,
							"text" : value.fst_sales_name
						});
					});
					return {
						results: items
					};
				},
			},
            width: '100%',
		});

    });

    function initMap() {
        var myLatLng = {lat: -6.1842827, lng: 106.6746338};
        var myLatLng2 = {lat: -6.1825369, lng: 106.7749226};

        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 15,
            center: myLatLng
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
        /*
        google.maps.event.addListener(map, "dblclick", function(event) {
            var _currentPoints = event.latLng;
            alert(_currentPoints);
            console.log(_currentPoints);
        });
        */
    }

    //AIzaSyDg_tzNYxrn-u0L5RVIl1C5QiwhQIrWBXI
    //AIzaSyALBylGkXyB-P1boXwMtz7oCV0L8-aHEBA
    //AIzaSyCN8-AYGQU5NGopLLCQaqXmvwty4jHEpC0

</script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAKrB-u5723kMlg7AQue5Jhk3ap3n7DEPI&callback=initMap">   </script>

<!-- Select2 -->
<script src="<?=COMPONENT_URL?>bower_components/select2/dist/js/select2.full.js"></script>