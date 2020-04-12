<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- <link rel="stylesheet" href="<?=COMPONENT_URL?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css"> -->
<link rel="stylesheet" href="<?=COMPONENT_URL?>bower_components/datatables.net/datatables.min.css">
<link rel="stylesheet" href="<?=COMPONENT_URL?>bower_components/select2/dist/css/select2.min.css">


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
				<div align="right" style="margin-bottom:20px">
					<button class="btn btn-primary" id="btn-new">Add New</button>
				</div>
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
<?php
	echo $pickup_location_modal;
?>

<div id="formModal" class="modal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header"> 
				<h4 class="modal-title">Location</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal">
				<div class="form-group">
						<label for="fst_cust_code" class="control-label col-md-4">Customer :</label>
						<div class="col-md-8">
							<select id="fst_cust_code" class="form-control" style="width:100%"></select>
						</div>
					</div>
					<div class="form-group">
						<label for="fst_cust_location" class="control-label col-md-4">Location :</label>
						<div class="col-md-8">
							<input type='TEXT' id="fst_cust_location" class="form-control" />							
							<a href='#' id="pickupFromMap">Pickup from map</a>
						</div>
						
					</div>
					<div class="form-group">
						<label for="fin_view_zoom_level" class="control-label col-md-4">Show Zoom Level :</label>
						<div class="col-md-8">
							<input type='TEXT' id="fin_view_zoom_level" class="form-control" value="5" />							
						</div>
					</div>
					<div class="form-group">
						<label for="fin_radius_meters" class="control-label col-md-4">Radius (meters) :</label>
						<div class="col-md-8">
							<input type='TEXT' id="fin_radius_meters" class="form-control" value="100" />							
						</div>
					</div>
					
				</form>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary" id="btn-save-record">Save</button>
				<button class="btn" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		var mdlForm = {			
			openForm : function(){
				$("#formModal").modal("show");
				App.fixedSelect2();
			},
			clearForm:function(){
				$("#fst_cust_code").empty();
				$("#fst_cust_location").val("0,0");
				$("#fin_view_zoom_level").val(5);
				$("#fin_radius_meters").val(100);
				selectedCustomer = null;
			},
			closeForm:function(){
				$("#formModal").modal("hide");
			}
		};

		var selectedCustomer;
		$(function(){
			$("#fst_cust_code").select2({
				ajax: {
					url: '<?=site_url()?>customer/ajxCustHaveNoLocation',
					dataType: 'json',
					delay:250,
					processResults: function (resp) {
						if (resp.status == "SUCCESS"){
							var custList = $.map(resp.data,function(cust){
								return {
									id:cust.fst_cust_code,
									text:cust.fst_cust_name
								};
							});

							return {
								results: custList
							};
						}
						
					}					
				}
			}).on("select2:select",function(e){
				var data = e.params.data;
				selectedCustomer = data;
			});
			App.fixedSelect2();

			$("#pickupFromMap").click(function(e){
				e.preventDefault();
				var location;
				var zoomLevel;

				if ($("#fst_cust_location").val() != ""){
					location = {lat: parseFloat($("#fst_cust_location").val().split(',')[0]), lng: parseFloat($("#fst_cust_location").val().split(',')[1])};    
				}
				if ($("#fin_view_zoom_level").val() != ""){
					zoomLevel = parseInt($("#fin_view_zoom_level").val());
				}
				
				App.log(location);
				PickupLocation.show(function(location,zoomLevel){
					//alert (" Latitude : " + location.lat() + " , Longitude :" + location.lng());
					$("#fst_cust_location").val(location.lat()+","+location.lng());
					$("#fin_view_zoom_level").val(zoomLevel);
					//alert(location.toString());
				},location,zoomLevel);
			});

			$("#btn-save-record").click(function(e){
				if (selectedCustomer != null){
					var dataPost = {
						[SECURITY_NAME]:SECURITY_VALUE,
						fst_cust_code :selectedCustomer.id,
						fst_cust_location:$("#fst_cust_location").val(),
						fin_view_zoom_level:$("#fin_view_zoom_level").val(),
						fin_radius_meters:$("#fin_radius_meters").val()
					}

					$.ajax({
						url:"<?=site_url()?>customer/ajxUpdateLocation",
						data:dataPost,
						method:"POST",
					}).done(function(resp){
						if (resp.status == "SUCCESS"){
							table = $('#tblList').DataTable();
							if (activeRow == null){
								//New Record;
								dataRow = {
									fst_cust_code:selectedCustomer.id,
									fst_cust_name:selectedCustomer.text,
									fst_cust_location: $("#fst_cust_location").val(),
									fin_view_zoom_level: $("#fin_view_zoom_level").val(),
									fin_radius_meters:$("#fin_radius_meters").val(),					
								}
								table.row.add(dataRow);
							}else{
								//Update Record;
								
								var dataRow = table.row(activeRow).data();
								dataRow.fst_cust_location = $("#fst_cust_location").val();
								dataRow.fin_view_zoom_level = $("#fin_view_zoom_level").val();
								dataRow.fin_radius_meters = $("#fin_radius_meters").val();						
							}
							table.draw(false);
							$("#fst_cust_code").prop("disabled",false);
							activeRow = null;
							mdlForm.clearForm();
							mdlForm.closeForm();
						}
					});
				}
			});
		});	
	</script>
</div>



<script type="text/javascript">
	var map;
	var marker;
	var activeRow;

	$(function(){	
		$("#btn-new").click(function(e){
			mdlForm.clearForm();
			mdlForm.openForm();
			$("#fst_cust_code").prop("disabled",false);
		});

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

			$(".btn-edit").click(function(e){
				e.preventDefault();
				table = $('#tblList').DataTable();
				activeRow = $(this).parents('tr');				
				var dataRow = table.row(activeRow).data();				
				$("#fst_cust_code").empty();
				App.addOptionIfNotExist("<option value='"+ dataRow.fst_cust_code +"'>"+dataRow.fst_cust_name +"</option>","fst_cust_code");
				$("#fst_cust_code").prop("disabled",true);
				$("#fst_cust_location").val(dataRow.fst_cust_location);
				$("#fin_view_zoom_level").val(dataRow.fin_view_zoom_level);
				$("#fin_radius_meters").val(dataRow.fin_radius_meters);	
				mdlForm.openForm();

				$("#fst_cust_code").trigger({
					type: 'select2:select',
					params:{
						data:{
							id:dataRow.fst_cust_code,
							text:dataRow.fst_cust_name
						}
					}
				});
			});

			$(".btn-map").click(function(event){
				initMap();
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
<script src="<?=COMPONENT_URL?>bower_components/datatables.net/datatables.min.js"></script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCN8-AYGQU5NGopLLCQaqXmvwty4jHEpC0"></script>

<!-- Select2 -->
<script src="<?=COMPONENT_URL?>bower_components/select2/dist/js/select2.full.js"></script>