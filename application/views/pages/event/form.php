<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link rel="stylesheet" href="<?=COMPONENT_URL?>bower_components/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="<?=COMPONENT_URL?>bower_components/datatables.net/datatables.min.css">
<link rel="stylesheet" href="<?=COMPONENT_URL?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

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
	<h1><?=lang("Event")?><small><?=lang("form")?></small></h1>
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
				<div class="btn-group btn-group-sm  pull-right">					
					<a id="btnNew" class="btn btn-primary" href="#" title="<?=lang("Tambah Baru")?>"><i class="fa fa-plus" aria-hidden="true"></i></a>
					<a id="btnSubmitAjax" class="btn btn-primary" href="#" title="<?=lang("Simpan")?>"><i class="fa fa-floppy-o" aria-hidden="true"></i></a>					
					<a id="btnDelete" class="btn btn-primary" href="#" title="<?=lang("Hapus")?>" style="display:<?= $mode == "ADD" ? "none" : "inline-block" ?>"><i class="fa fa-trash" aria-hidden="true"></i></a>
					<a id="btnClose" class="btn btn-primary" href="#" title="<?=lang("Daftar Transaksi")?>"><i class="fa fa-list" aria-hidden="true"></i></a>												
				</div>
			</div>
			<!-- end box header -->
			
				
			<div class="box-body">
			<ul class="nav nav-tabs">
				<li class="active"><a data-toggle="tab" href="#form">Form</a></li>
				<li><a data-toggle="tab" href="#budget">Budget</a></li>
			</ul>
			<div class="tab-content">
				<div id="form" class="tab-pane fade in active">
					<!-- form start -->
					<form id="frmMaster" class="form-horizontal" style="margin-top:20px">
						<input type="hidden" name="fin_event_id" id="fin_event_id" value="<?=$finEventId?>"/>
						<div class='form-group'>
							<label for="fst_event_name" class="col-sm-2 control-label"><?=lang("Event")?> *</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="fst_event_name" placeholder="Event Name" name="fst_event_name" value="" />
								<div id="fst_event_name_err" class="text-danger"></div>
							</div>
						</div>
						<div class='form-group'>
							<label for="fst_kategori_lomba" class="col-sm-2 control-label"><?=lang("Kategori Lomba")?> *</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="fst_kategori_lomba" placeholder="Kategori Lomba" name="fst_kategori_lomba" value="" />
								<div id="fst_kategori_lomba_err" class="text-danger"></div>
							</div>
						</div>

						<div class="form-group">
							<label for="fdt_event_start" class="col-sm-2 control-label"><?=lang("Start")?> *</label>
							<div class="col-sm-4">
								<input type="text" class="datetimepicker form-control" id="fdt_event_start" placeholder="<?=lang("Start Date")?>" name="fdt_event_start" value=""/>
								<div id="fdt_event_start_err" class="text-danger"></div>
							</div>
							<label for="fdt_event_end" class="col-sm-2 control-label"><?=lang("End")?> *</label>
							<div class="col-sm-4">
								<input type="text" class="datetimepicker form-control" id="fdt_event_end" placeholder="<?=lang("End")?>" name="fdt_event_end" value=""/>
								<div id="fdt_event_end_err" class="text-danger"></div>
							</div>
						</div>
						<div class="form-group">
							<label for="fin_jml_peserta" class="col-sm-2 control-label"><?=lang("Peserta")?> *</label>
							<div class="col-sm-4">
								<input type="text" class="form-control text-right" id="fin_jml_peserta" placeholder="<?=lang("Total Peserta")?>" name="fin_jml_peserta" value="0"/>
								<div id="fin_jml_peserta_err" class="text-danger"></div>
							</div>
							<label for="fin_total_guru" class="col-sm-2 control-label"><?=lang("Guru")?> *</label>
							<div class="col-sm-4">
								<input type="text" class="form-control text-right" id="fin_total_guru" placeholder="<?=lang("Total Guru")?>" name="fin_total_guru" value="0"/>
								<div id="fin_total_guru_err" class="text-danger"></div>
							</div>
						</div>
						
						<div class="form-group">
							<label for="fin_piala" class="col-sm-2 control-label"><?=lang("Piala")?> *</label>
							<div class="col-sm-4">
								<input type="text" class="form-control text-right" id="fin_piala" placeholder="<?=lang("Total Piala")?>" name="fin_piala" value="0"/>
								<div id="fin_piala_err" class="text-danger"></div>
							</div>
							<label for="fin_goodybag" class="col-sm-2 control-label"><?=lang("Goodybag")?> *</label>
							<div class="col-sm-4">
								<input type="text" class="form-control text-right" id="fin_goodybag" placeholder="<?=lang("Total Goodybag")?>" name="fin_goodybag" value="0"/>
								<div id="fin_goodybag_err" class="text-danger"></div>
							</div>
						</div>
						<div class="form-group">
							<label for="fst_event_info" class="col-sm-2 control-label"><?=lang("Info")?> *</label>
							<div class="col-sm-10">
								<textarea  class="form-control" id="fst_event_info" name="fst_event_info" style="resize:none" rows="5"></textarea>
								<div id="fst_event_info_err" class="text-danger"></div>
							</div>
						</div>


						<div class="form-group" style="margin-top:40px">
							<div class="col-sm-10 col-sm-offset-2">
								<span><b>Saya yang bertandatangan dibawah ini :</b></span>
							</div>
						</div>

						<div class="form-group">
							<label for="fst_cust_code" class="col-sm-2 control-label"><?=lang("Sekolah Peserta")?> *</label>
							<div class="col-sm-10">
								<select id="fst_cust_code" name="fst_cust_code" class='form-control' style="width:100%"></select>
								<div id="fst_cust_code_err" class="text-danger"></div>
							</div>
						</div>
						
						<div class="form-group">
							<label for="fst_perwakilan_sekolah" class="col-sm-2 control-label"><?=lang("Nama")?> *</label>
							<div class="col-sm-10">
								<input type="text" id="fst_perwakilan_sekolah" name="fst_perwakilan_sekolah" class='form-control' />
								<div id="fst_perwakilan_sekolah_err" class="text-danger"></div>
							</div>
						</div>
						<div class="form-group">
							<label for="fst_jabatan_perwakilan" class="col-sm-2 control-label"><?=lang("Jabatan")?> *</label>
							<div class="col-sm-10">
								<input type="text" id="fst_jabatan_perwakilan" name="fst_jabatan_perwakilan" class='form-control' />
								<div id="fst_jabatan_perwakilan_err" class="text-danger"></div>
							</div>
						</div>
						
						<div class="form-group">		
							<label for="fbl_open_booth" class="col-sm-10 col-sm-offset-2"><input type="checkbox" id="fbl_open_booth" name="fbl_open_booth" value="1" /> <?=lang("Open booth")?></label>
						</div>
					</form>
				</div>
				<div id="budget" class="tab-pane fade in">
					<div id="form" class="tab-pane fade in">
						<!-- form start -->
						<form id="frmBudget" class="form-inline" style="margin-top:20px;width:100%">
							<div class='form-group' style="width:90%">
								<select style="width:40%" class="form-control" id="fst_item_code"></select>
								<select style="width:30%" class="form-control" id="fst_group" placeholder="Group">
									<option value='Piala Juara'>Piala Juara</option>
									<option value='Hadiah Murid'>Hadiah Murid</option>
									<option value='Hadiah Guru'>Hadiah Guru</option>
									<option value='Hadiah Games'>Hadiah Games</option>
									<option value='Biaya Lain2'>Biaya Lain2</option>
								</select>
								<input style="width:8%" type="number" class="form-control text-right number" id="fdb_qty" placeholder="Qty" value="1" />								
								<input style="width:20%" type="text" class="form-control text-right money" id="fdc_price" placeholder="Price" value="" />
								
							</div>
							<div class='form-group' style="width:9.7%">
								<button  style="float:right" class="btn btn-primary" id="btn-add-item">Add</button>
								<div style="clear:both"></div>
							</div>
						</form>
					</div>
					
					<div style="margin-top:20px">
						<table id="tblBudget" class="table table-bordered table-hover table-striped dataTable no-footer" style="width:100%;margin-top:20px"></table>
					</div>

				</div>
			</div>
				
				
				
			</div>
			<!-- end box-body -->
			<div class="box-footer">
			</div>
			<!-- end box-footer -->			
			
		</div>
	</div>
</section>

<script type="text/javascript">
	var selectedCustomer;
	var selectedItem;
	var selectedBudget = null;
	var tBudget;
	arrSchool=[];
	arrItem=[];

	<?php foreach($listSchool as $school){ ?>
		arrSchool.push({
			id:"<?=$school->fst_cust_code?>",
			text:"<?=$school->fst_cust_name?>",
			contact:"<?=$school->fst_contact?>",
			address:"<?= str_replace("\r\n"," ",trim($school->fst_cust_address))?>",
			phone:"<?=$school->fst_cust_phone?>",			
		});
	<?php } ?>
	
	<?php foreach($listLogistic as $item){ ?>
		arrItem.push({
			id:"<?=$item->fst_item_code?>",
			text:"<?=$item->fst_item_name?>",
			price:"<?=$item->fin_selling_price?>",			
			satuan:"<?=$item->fst_satuan?>",			
		});
	<?php } ?>


	$(function(){
		if ($("#fin_event_id").val() != 0){
			initForm();
		}

		$("#btnSubmitAjax").click(function(e){
			e.preventDefault();
			submitAjax();
		});

		$("#fst_cust_code").select2({
			data:arrSchool,
			placeholder: "Select a school",
		}).on("select2:select",function(e){
			selectedCustomer = e.params.data;
		});
		$("#fst_cust_code").val('').trigger('change');


		$("#fst_item_code").select2({
			data:arrItem,
			placeholder: "Select a item",
		}).on("select2:select",function(e){
			selectedItem  = e.params.data;
			$("#fdc_price").val(selectedItem.price);
		});
		$("#fst_item_code").val('').trigger('change');
		
		
		$("#btn-add-item").click(function(e){
			e.preventDefault();
			var dataRow = {
				fin_pde_id:0,
				fst_item_code:selectedItem.id,
				fst_item_name:selectedItem.text,
				fst_satuan:selectedItem.satuan,
				fst_group:$("#fst_group").val(),
				fdb_qty:$("#fdb_qty").val(),
				fdc_price:$("#fdc_price").val(),
			};
			if (selectedBudget == null){
				tBudget.row.add(dataRow).draw(false);
				
			}else{
				var currData = tBudget.row(selectedBudget).data();
				dataRow.fin_pde_id = currData.fin_pde_id;
				//delete dataRow.fin_event_id;
				tBudget.row(selectedBudget).data(dataRow).draw(false);
				selectedBudget = null;
			}


			
		});
		
		App.fixedSelect2();

	});
</script>

<script type="text/javascript">
	function submitAjax(){
		var dataForm = $("#frmMaster").serializeArray();
		dataForm.push({
			name:SECURITY_NAME,
			value:SECURITY_VALUE
		});
		

		var detail = new Array();
		$.each(tBudget.data(),function(i,v){
			detail.push(v);
		});
		dataForm.push({
			name:"detail",
			value: JSON.stringify(detail)
		});
				
		
		$.ajax({
			url:"<?=site_url()?>event/ajx_save",
			method:"POST",
			data:dataForm,
		}).done(function(resp){
			if (resp.status == "SUCCESS"){
				alert("Data Saved !");
				//location.replace("https://www.w3schools.com");
				window.location.href = "<?=site_url()?>event";
			}
		});
	}

	function initForm(){
		var dataPost ={
			[SECURITY_NAME]:SECURITY_VALUE,
			fin_event_id:$("#fin_event_id").val()
		};

		$.ajax({
			url:"<?=site_url()?>event/ajxFetchData",
			data:dataPost,
			method:"POST",
		}).done(function(resp){
			if(resp.status == "SUCCESS"){
				var dataEvent = resp.event;
				App.autoFillForm(dataEvent);
				$("#fdt_event_start").val(dateTimeFormat(dataEvent.fdt_event_start));
				$("#fdt_event_end").val(dateTimeFormat(dataEvent.fdt_event_end));

				selectedCustomer = $.grep(arrSchool, function(school, i ) {
					return school.id == dataEvent.fst_cust_code;
				});
				$("#fst_cust_code").val(dataEvent.fst_cust_code).trigger("change");
				$("#fst_cust_code").trigger({
					type: 'select2:select',
					params: {data: selectedCustomer}
				});

				detailList = resp.budget;
				$.each(detailList , function(i,budget){
					var dataD = {
						fin_pde_id:budget.fin_pde_id,
						fst_item_code:budget.fst_item_code,
						fst_item_name:budget.fst_item_name,
						fst_satuan:budget.fst_satuan,
						fst_group:budget.fst_group,
						fdb_qty:budget.fdb_qty,
						fdc_price:budget.fdc_price,
					};

					tBudget.row.add(dataD);
				});
				tBudget.draw(false);
			}
		});
	}
</script>

<script type="text/javascript">
	$(function(){
		tBudget = $("#tblBudget").DataTable({
			columns:[
				{'title' : 'ID', 'width':'5%', 'data':'fin_pde_id'},
				{'title' : 'Item', 'width':'30%',data:"fst_item_code",
					render: function(data,type,row){
						return row.fst_item_name;
					}
				},
				{'title' : 'Satuan', 'width':'10%', data:"fst_satuan"},
				{'title' : 'Group', 'width':'15%',data:"fst_group"},
				{'title' : 'Qty', 'width':'5%',data:"fdb_qty",className:"text-right"},
				{'title' : 'Price', 'width':'15%',data:"fdc_price",className:"text-right",
					render:function(data,type,row){
						return App.money_format(row.fdc_price)
					}
				},
				{'title' : 'Total', 'width':'15%',
					render:function(data,type,row){
						return App.money_format(row.fdb_qty * row.fdc_price);
					}
				},
				{'title' : 'Action', 'width':'5%',
					render:function(data,type,row){
						var action = "<a class='btn-edit-budget' title='budget'><i class='fa fa-pencil' aria-hidden='true'></i></a>";
						action += "<a class='btn-delete-budget' title='budget'><i class='fa fa-trash' aria-hidden='true'></i></a>";
						return action;
					} 
				},
			],
			processing: false,
			serverSide: false,
			searching: false,
			paging:   false,
			ordering: false,
			info:     false
		}).on("click",".btn-delete-budget",function(e){
			e.preventDefault();
			alert("Delete");
		}).on("click",".btn-edit-budget",function(e){
			e.preventDefault();
			selectedBudget =  $(this).parents('tr');			
			var budget = tBudget.row(selectedBudget).data();

			$("#fst_item_code").val(budget.fst_item_code).trigger("change");
			selectedItem = arrItem.find(function(item){
				return item.id == budget.fst_item_code;
			});
			$("#fst_group").val(budget.fst_group);
			$("#fdb_qty").val(budget.fdb_qty);
			$("#fdc_price").val(budget.fdc_price);			
			
		});
	});
	
</script>



<!-- Select2 -->
<script src="<?=COMPONENT_URL?>bower_components/select2/dist/js/select2.full.js"></script>
<!-- DataTables -->
<script src="<?=COMPONENT_URL?>bower_components/datatables.net/datatables.min.js"></script>