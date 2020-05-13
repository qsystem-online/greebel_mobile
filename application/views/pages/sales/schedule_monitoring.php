<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link rel="stylesheet" href="<?=COMPONENT_URL?>bower_components/datatables.net/datatables.min.css">
<link rel="stylesheet" href="<?=COMPONENT_URL?>bower_components/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

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
</style>

<section class="content-header">
	<h1><?=lang("Schedule")?><small><?=lang("monitoring")?></small></h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> <?= lang("Home") ?></a></li>
		<li><a href="#"><?= lang("Sales") ?></a></li>
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
			<!-- end box header -->
			
			<div class="box-body">
				<input type="hidden" name = "<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>">				
				<form class="form-horizontal">
					<div class='form-group'>
                    	<label for="fin_user_id" class="col-sm-2 control-label">Date</label>
						<div class="col-sm-3">
							<input type="TEXT" id="scheduleCalendar" class="form-control datepicker"></input>
						</div>
						<label for="fst_status" class="col-sm-2 control-label">Status</label>
						<div class="col-sm-3">
							<select id="fst_status" class="form-control">
                                <option value='ALL'>ALL</option>
                                <option value='VISITED'>Visited</option>
                                <option value='UNVISITED'>Unvisited</option>
							</select>
						</div>
                        <div class="col-sm-2 text-right">
							<a id="btnShowData" href="#" class="btn btn-primary">Show Data</a>
						</div>
					</div>					
				</form>
					
				<table id="tblSchedule" style="width:100%"></table>	
			</div>
			<!-- end box-body -->
			<div class="box-footer">
				
			</div>
			<!-- end box-footer -->			
		
		</div>
	</div>
</section>

<script type="text/javascript">
	
	$(function(){
        $("#scheduleCalendar").daterangepicker({
			locale: {
				format: 'DD-MM-YYYY'
			}
        });
        
        /*
		$("#date-log").change(function(event){
			table = $('#tblList').DataTable();

			table.ajax.reload();
        });
        */


		$('#tblSchedule').on('preXhr.dt', function ( e, settings, data ) {
		 	//add aditional data post on ajax call
			 //data.sessionId = "TEST SESSION ID";
			 data.optionSearch = $('#selectSearch').val();
			 data.dateLog = $("#date-log").val();
		}).DataTable({
			columns:[
				{"title" : "id","width": "20%","data":"fin_rec_id","sortable":false,visible:false},
				{"title" : "Customer Code","width": "20%","data":"fst_cust_code","sortable":true},
				{"title" : "Customer Name","width": "40%","data":"fst_cust_name","sortable":true},
				{"title" : "Date","width": "20%","data":"fdt_schedule_date","sortable":true},
                {"title" : "Sales","width": "30%","data":"fst_sales_code_name","sortable":true},
                {"title" : "Status","width": "10%","data":"fbl_visited","sortable":true},                				
			],			
			processing: false,
			serverSide: false,
		}).on('draw',function(){	
		
		});
            
        
        $("#btnShowData").click(function(e){
            e.preventDefault();
            var dataPost = {
                [SECURITY_NAME]:SECURITY_VALUE,
                "fstDateRange": $("#scheduleCalendar").val(),
                "fstStatus":$("#fst_status").val(),
            };

            var t = $('#tblSchedule').DataTable();
            blockUIOnAjaxRequest();
            $.ajax({
                url:"<?=site_url()?>sales/ajxScheduleMonitoringData",
                method:"POST",
                data:dataPost,
            }).done(function(resp){
                if (resp.status == "SUCCESS"){
                    t.clear();
                    records = resp.data;
                    $.each(records, function(i,record){
                        var dataRow = {
                            fin_rec_id:record.fin_rec_id,
                            fst_cust_code:record.fst_cust_code,
                            fst_cust_name:record.fst_cust_name,
							fdt_schedule_date:record.fdt_schedule_date,
                            fst_sales_code_name:record.fst_sales_code + " - " + record.fst_sales_name,
                            fbl_visited:record.fbl_visited
                        };
                        t.row.add(dataRow);
                    });
                    t.draw(false);
                }
            });
        });
	});

	
	function init_form(fin_user_id){
		
	}

</script>
<!-- DataTables -->
<script src="<?=COMPONENT_URL?>bower_components/datatables.net/datatables.min.js"></script>
<!-- Select2 -->
<script src="<?=COMPONENT_URL?>bower_components/select2/dist/js/select2.full.js"></script>