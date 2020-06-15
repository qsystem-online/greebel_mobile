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
	<h1><?=lang("User")?><small><?=lang("form")?></small></h1>
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
						<div class="col-sm-2">
							<input type="TEXT" id="scheduleCalendar" class="form-control datepicker"></input>
						</div>
						<label for="fst_sales" class="col-sm-2 control-label">Sales</label>
						<div class="col-sm-6">
							<select id="fst_sales" class="form-control">
								<option value='ALL'>ALL</option>
								<?php
									foreach($arrSales as $sales){
										echo "<option value='$sales->fst_sales_code' selected>$sales->fst_sales_name</option>";
									}
								?>
							</select>
						</div>
					</div>

					<div class='form-group'>
                    	<label for="fin_user_id" class="col-sm-2 control-label">Customer</label>
						<div class="col-sm-10">
							<select id="fst_customer" class="form-control"></select>
						</div>
					</div>
					<div class='form-group'>
                    	<div class="col-sm-12 text-right">
							<a id="btnAddSchedule" href="#" class="btn btn-primary">Save Ajax</a>
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
	var customer;
	var sales;
	$(function(){
		$("#scheduleCalendar").change(function(e){
			refreshTable();
		});

		$("#fst_sales").select2();
		$("#fst_sales").val("ALL").trigger("change.select2");
		$('#fst_sales').on('select2:select', function (e) {
			var data = e.params.data;
			sales = data;		
			$.ajax({
				url:"<?=site_url()?>sales/ajxGetCustomer/" + data.id,
				method:"GET",
			}).done(function(resp){
				arrCustomer = resp.arrCustomer;
				$("#fst_customer").empty();
				$.each(arrCustomer,function(i,customer){
					App.addOptionIfNotExist("<option value='"+customer.fst_cust_code+"'>"+customer.fst_cust_name +"</option>","fst_customer");
				});
				$("#fst_customer").val(null).trigger("change.select2");
			});
			refreshTable();			
		});


		$("#fst_customer").select2();
		
		$("#fst_customer").on("select2:select",function(e){
			var data = e.params.data;
			customer = data;

		});

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
				{"title" : "Sales","width": "30%","data":"fst_sales_code","sortable":true},
				{"title" : "Action","width": "10%","sortable":false,className:"text-center",
					render:function(data,type,row){
						return "<a href='#' class='btn-delete'><i class='fa fa-trash'></i></a>"

					}
				},
			],			
			processing: true,
			serverSide: false,
		}).on('draw',function(){	
		
		}).on('click','.btn-delete',function(e){
			e.preventDefault();
			var t = $('#tblSchedule').DataTable();			
			row = $(this).parents("tr");
			data = t.row(row).data();
			App.log(data);
			//{fin_rec_id: "1", fst_cust_code: "_FNACE006", fst_cust_name: "ACEN", fst_sales_code: "_FNFOR1"}
			$.ajax({
				url:"<?=site_url()?>sales/ajxSchedule_delete/" + data.fin_rec_id,
				method:"GET"
			}).done(function(resp){
				if (resp.message !=""){
					alert(resp.message);
				}
				if (resp.status =="SUCCESS"){
					t.row(row).remove().draw();
				}
			})
			
		});



		$('#btnAddSchedule').click(function(e){
			e.preventDefault();
			dataPost = {
				[SECURITY_NAME]:SECURITY_VALUE,
				fdt_schedule_date:$("#scheduleCalendar").val(),
				fst_cust_code:customer.id,
			};

			$.ajax({
				url:"<?=site_url()?>sales/ajxSchedule_add",
				data:dataPost,
				method:"POST",

			}).done(function(resp){
				if (resp.message != ""){
					alert(resp.message);
				}
				if (resp.status == "SUCCESS"){
					dataRow = {
						fin_rec_id:resp.insertId,
						fst_cust_code:customer.id,
						fst_cust_name:customer.text,
						fst_sales_code:sales.id,
					}
					t = $('#tblSchedule').DataTable();
					t.row.add(dataRow).draw(false);
					$("#fst_customer option[value='"+dataPost.fst_cust_code+"']").remove();
					$("#fst_customer").select2();
					App.fixedSelect2();
				}
			});			
		});

		App.fixedSelect2();
		
		
	});

	function refreshTable(){
		App.log(sales);		
		$.ajax({
			url:"<?=site_url()?>sales/ajxSchedule_list/" +  $("#scheduleCalendar").val()+"/"+  $("#fst_sales").val(),
			method:"GET",
		}).done(function(resp){
			if (resp.status = "SUCCESS"){
				listSchedule = resp.data;
				t = $('#tblSchedule').DataTable();
				t.clear();
				customer = null;
				$.each(listSchedule,function(i,schedule){						
					var dataRow = {
						fin_rec_id:schedule.fin_rec_id,
						fst_cust_code:schedule.fst_cust_code,
						fst_cust_name:schedule.fst_cust_name,
						fst_sales_code:schedule.fst_sales_code
					}
					t.row.add(dataRow);
					$("#fst_customer option[value='"+schedule.fst_cust_code+"']").remove();
				});
				$("#fst_customer").select2();
				App.fixedSelect2();
				t.draw(false);	
			}
		});
	}
	
	function init_form(fin_user_id){
		
	}

</script>
<!-- DataTables -->
<script src="<?=COMPONENT_URL?>bower_components/datatables.net/datatables.min.js"></script>
<!-- Select2 -->
<script src="<?=COMPONENT_URL?>bower_components/select2/dist/js/select2.full.js"></script>