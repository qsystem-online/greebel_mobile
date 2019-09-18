<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- <link rel="stylesheet" href="<?=base_url()?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css"> -->
<link rel="stylesheet" href="<?=base_url()?>bower_components/datatables.net/datatables.min.css">
<style>
	.additional-schedule{
		background-color: #f5bebe !important;
	}
	/* Style buttons */
.btn {
  background-color: DodgerBlue; /* Blue background */
  border: none; /* Remove borders */
  color: white; /* White text */
  padding: 12px 16px; /* Some padding */
  font-size: 16px; /* Set a font size */
  cursor: pointer; /* Mouse pointer on hover */
}

/* Darker background on mouse-over */
.btn:hover {
  background-color: RoyalBlue;
}
</style>
<section class="content-header">
	<h1><?=$page_name?><small></small></h1>
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
				<div class="col-sm-6">
					<label>Date</label>
					<input type="text" id="date-log" style="margin-left:10px;width:200px">
				</div>
				<div class="col-sm-6" align="right" style="padding-right:0px">
					<span>Search on:</span>
					<span>
                        <select id="selectSearch" name="selectSearch" style="width: 148px;background-color:#e6e6ff;padding:8px;margin-left:6px;margin-bottom:6px">                            
                            <?php
                                foreach($arrSearch as $key => $value){ ?>
                                    <option value=<?=$key?>><?=$value?></option>
                                <?php
                                }
							// <option value="a.fin_id">No.Transaksi</option>
							// <option value="a.fst_customer_name">Customer</option>
                            // <option value="c.fst_salesname">Sales Name</option>
                            ?>
						</select>
					</span>
				</div>
				<table id="tblList" class="table table-bordered table-hover table-striped"></table>
				<button id="btnExport2Excel" class="btn"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Export to Excel</button>
			</div>
			<!-- /.box-body -->
			<div class="box-footer">
			</div>
			<!-- /.box-footer -->		
		</div>
	</div>
</div>

<script type="text/javascript">
	$(function(){	
		$("#date-log").daterangepicker({
			locale: {
				format: 'DD/MM/YYYY'
			}
    	});
		$("#date-log").change(function(event){
			table = $('#tblList').DataTable();

			table.ajax.reload();
		});

		$('#tblList').on('preXhr.dt', function ( e, settings, data ) {
		 	//add aditional data post on ajax call
			 //data.sessionId = "TEST SESSION ID";
			 data.optionSearch = $('#selectSearch').val();
			 data.dateLog = $("#date-log").val();
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
			ajax: "<?=$fetch_list_data_ajax_url?>",
			
		}).on('draw',function(){	
			$(".btn-detail").click(function(event){
				event.preventDefault();
				table = $('#tblList').DataTable();
				
				var tr = $(this).closest('tr');
				var row = table.row( tr );
				if ( row.child.isShown() ) {
					// This row is already open - close it
					row.child.hide();
					tr.removeClass('shown');
				}else {
					// Open this row
					row.child( format(row.data()) ).show();
					tr.addClass('shown');
				}
			});
		
		});
		    
		
		$('#tblList').on("click",".btn-show-picture",function(event){
			event.preventDefault();	
			console.log($(this));
			id = $(this).data("id");
			window.open("<?= base_url() ?>sales/show_log_pic/" + id,"blank","",true);

		});
		$("#btnExport2Excel").click(function(e){
			e.preventDefault();
			window.location = "<?= base_url() ?>sales/record2Excel/?dateLog=" + $("#date-log").val();
			//window.open("<?= base_url() ?>sales/record2Excel/?dateLog=" + $("#date-log").val(),"blank","",true);
		});


	});

	function old_format ( d ) {
		// `d` is the original data object for the row
		console.log(d);
		data = {
			"fst_sales_code": d.fst_sales_code,
			"fst_cust_code":d.fst_cust_code,
			"fdt_date":d.fdt_checkin_date,
			"<?=$this->security->get_csrf_token_name()?>" : "<?=$this->security->get_csrf_hash()?>"
		};

		$.ajax({
			url: "<?= base_url() ?>/sales/fetch_detail_log",
			method: "POST",
			data: data,
			async:false,
			success:function(resp){
				result = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;width:100%">';
				result += '<tr><td>ID</td><td>Date Time</td><td>Location</td><td>Distance</td></tr>';
				$.each(resp,function(index,value){
					result += "<tr>" +
						"<td>" + value.fin_id + "</td>" +
						"<td>" + value.fdt_checkin_datetime + "</td>" +
						"<td>" + value.fst_checkin_location + "</td>" +
						"<td>" + value.fin_distance_meters + "</td>" +
						"<td><a class='btn-show-picture btn btn-sm btn-primary' data-id='"+value.fin_id+"'>Show Picture</a></td>" +
					"</tr>";
				});

				result += '</table>';
				
			}
		});
		return result;						
	}


	function format ( d ) {
		// `d` is the original data object for the row
		console.log(d);
		data = {
			"fst_sales_code": d.fst_sales_code,
			"fst_cust_code":d.fst_cust_code,
			"fdt_date":d.fdt_checkin_date,
			"<?=$this->security->get_csrf_token_name()?>" : "<?=$this->security->get_csrf_hash()?>"
		};

		$.ajax({
			url: "<?= base_url() ?>/sales/get_log_pics/" + d.fin_id,
			method: "GET",
			//data: data,
			async:false,
			success:function(resp){
				result = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;width:100%">';
				//result += '<tr><td>ID</td><td>Date Time</td><td>Location</td><td>Distance</td></tr>';

				$.each(resp.files,function(index,value){
					
					if (index % 3 == 0){
						result += "<tr>";
					} 
					result += "<td><img src='<?=base_url();?>uploads/checkinlog/"+ value + "' style='width:80%'/>" + index +"</td>"
					if (index % 3 == 2){
						result += "</tr>";
					}
					/*
					result += "<tr>" +
						"<td>" + value.fin_id + "</td>" +
						"<td>" + value.fdt_checkin_datetime + "</td>" +
						"<td>" + value.fst_checkin_location + "</td>" +
						"<td>" + value.fin_distance_meters + "</td>" +
						"<td><a class='btn-show-picture btn btn-sm btn-primary' data-id='"+value.fin_id+"'>Show Picture</a></td>" +
					"</tr>";
					*/
				});

				result += '</table>';
				
			}
		});
		return result;						
	}

</script>
<!-- DataTables -->
<script src="<?=base_url()?>bower_components/datatables.net/datatables.min.js"></script>
<!--
<script src="<?=base_url()?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?=base_url()?>bower_components/datatables.net/js/datetime.js"></script>
<script src="<?=base_url()?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
-->
