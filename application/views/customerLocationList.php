<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- <link rel="stylesheet" href="<?=base_url()?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css"> -->
<link rel="stylesheet" href="<?=base_url()?>bower_components/datatables.net/datatables.min.css">
<style>
#map {
	height: 500px;
}
</style>
<section class="content-header">
	<h1><?=$page_name?><small>List</small></h1>
	<ol class="breadcrumb">
		<?php 
			foreach($breadcrumbs as $breadcrumb){
				if ($breadcrumb["link"] == NULL){
					echo "<li class='active'>".$breadcrumb["title"]."</li>";
				}else{
					echo "<li><a href='".$breadcrumb["link"]."'>".$breadcrumb["icon"].$breadcrumb["title"]."</a></li>";
				}
				
			} 
		?>
	</ol>
</section>

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-info">
				<div class="box-header with-border">
				<h3 class="box-title"><?=$list_name?></h3>
				<div class="box-tools">
					
				</div>

			</div>			
			<!-- /.box-header -->
			<div class="box-body">
				<div align="right">
					<span>Search on:</span>
					<span>
                        <select id="selectSearch" name="selectSearch" style="width: 148px;background-color:#e6e6ff;padding:8px;margin-left:6px;margin-bottom:6px">                            
                            <?php foreach($arrSearch as $key => $value){ ?>
								<option value=<?=$key?>><?=$value?></option>
                            <?php } ?>
						</select>
					</span>
				</div>
				<table id="tblList" class="table table-bordered table-hover table-striped"></table>
			</div>
			<!-- /.box-body -->
			<div class="box-footer">
			</div>
			<!-- /.box-footer -->		
		</div>
	</div>
</div>

<div id="mapModal" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">        
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  	<div id="map"> </div>
      </div>
    </div>
  </div>
</div>



<script type="text/javascript">
	var map;
	var marker;
	$(function(){	
		

		$('#tblList').on('preXhr.dt', function ( e, settings, data ) {
		 	//add aditional data post on ajax call
			 //data.sessionId = "TEST SESSION ID";
			 data.optionSearch = $('#selectSearch').val();
		}).DataTable({
			columns:[
                <?php
                    foreach($columns as $col){?>
                        {"title" : "<?=$col['title']?>","width": "<?=$col['width']?>","data":"<?=$col['data']?>"
                            <?php if(isset($col['render'])){?>
                                ,"render":<?php echo $col['render'] ?>
                            <?php } ?>
                            <?php if(isset($col['sortable'])){
                                if ($col['sortable']){ ?>
                                    ,"sortable": true
                                <?php }else
                                {?>
                                    ,"sortable": false
                                <?php }
                                
                            } ?>
                            <?php if(isset($col['className'])){?>
                                ,"className":"<?=$col['className']?>"
                            <?php } ?>
                        },
                    <?php }
                ?>
			],
			dataSrc:"data",
			processing: true,
			serverSide: true,
			ajax: "<?=$fetch_list_data_ajax_url?>"
		}).on('draw',function(){
			$('.btn-delete').confirmation({
				//rootSelector: '[data-toggle=confirmation]',
				rootSelector: '.btn-delete',
				// other options
			});	

			$(".btn-delete").click(function(event){
				var trRow = $(this).parents('tr');
				table = $('#tblList').DataTable();	
				var row = table.row( trRow );
				data = row.data();

				$.ajax({
					url:"<?= base_url() ?>customer/delete_location/"  + data.fst_cust_code ,
					success:function(resp){
						if (resp.status == "SUCCESS"){
							trRow.remove();
						}
					}
				})
			});

			$(".btn-map").click(function(event){
				event.preventDefault();
				var trRow = $(this).parents('tr');
				table = $('#tblList').DataTable();	
				var row = table.row( trRow );
				data = row.data();

				arrLocation = data.fst_cust_location.split(',');
				markerLocation = {lat: parseFloat(arrLocation[0]), lng: parseFloat(arrLocation[1])};
				console.log(markerLocation);
				addMarker(markerLocation);
				$('#mapModal').modal('show');
			});
		});
	});

	function addMarker(location){
		//myLatLng = {lat: parseFloat(v.fst_lat), lng: parseFloat(v.fst_log)};
		try{
			//marker.setMap(null);
		}catch(err){

		}
		marker.setPosition(location);
		
		map.setCenter(location);    
	}

	function initMap() {
        var myLatLng = {lat: -6.1842827, lng: 106.6746338};
		

        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 10,
            center: myLatLng
        });

		marker = new google.maps.Marker({
			position: myLatLng,
			map: map,
			label: 'A',
			title: 'customer'
		});

	}
	
</script>
<!-- DataTables -->
<script src="<?=base_url()?>bower_components/datatables.net/datatables.min.js"></script>
<!--
<script src="<?=base_url()?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?=base_url()?>bower_components/datatables.net/js/datetime.js"></script>
<script src="<?=base_url()?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
-->

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCN8-AYGQU5NGopLLCQaqXmvwty4jHEpC0&callback=initMap"></script>
