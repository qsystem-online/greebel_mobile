<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<link rel="stylesheet" href="<?=COMPONENT_URL?>bower_components/datatables.net/datatables.min.css">
<link rel="stylesheet" href="<?=COMPONENT_URL?>bower_components/bootstrap-toggle/css/bootstrap-toggle.min.css">

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
			</div> <!-- /.box-header -->
			
			<div class="box-body">
				<!--
				<div align="right">
					<span>Search on:</span>
					<span>
						<select id="selectSearch" name="selectSearch" style="width: 148px;background-color:#e6e6ff;padding:8px;margin-left:6px;margin-bottom:6px">                            
							<php
								foreach($arrSearch as $key => $value){ ?>
									<option value=<=$key?>><=$value?></option>
								<php
								}							
							?>
						</select>
					</span>
				</div>
				-->
				<table id="tblList" class="table table-bordered table-hover table-striped table-condensed">
					<thead>
						<tr>
							<th style="width:20%">App ID</th>
							<th style="width:50%">Sales</th>
							<th style="width:20%">Insert Datetime</th>
							<th style="width:10%;text-align:center">Active</th>
							<!-- <th>version</th> -->
						</tr>
					</thead>
					<tbody>
							<?php 
								$list = $this->appid_model->getList();
								foreach($list as $appId){
									$isActive = $appId->fst_active == 'A' ? 'checked' : '';

									$sstr =  "<tr data-id='$appId->fin_rec_id'>
										<td>$appId->fst_appid</td>
										<td>$appId->fst_sales_name</td>
										<td>$appId->fdt_insert_datetime</td>
										<td style='text-align:center'><input class='fst_active' type='checkbox' $isActive data-toggle='toggle' data-size='mini'></td>
									</tr>";
									echo $sstr;
								}
							?>
					</tbody>
				</table>
			</div> <!-- /.box-body -->
			
			<div class="box-footer">
			</div> <!-- /.box-footer -->	
				
		</div>
	</div>
</div>

<script type="text/javascript">
	$(function(){
		$("#tblList").dataTable({paging:false});
		$(".fst_active").change(function(e){
			
			var id = $(this).parents("tr").data("id");
			var checked = $(this).prop("checked") ? 1 : 0;
			var data = {
				fin_rec_id:id,
				checked:checked,
				[SECURITY_NAME]:SECURITY_VALUE,
			}

			App.blockUIOnAjaxRequest();
			$.ajax({
				url:"<?=site_url()?>appid/ajx_update_status",
				data:data,
				method:"POST",
			}).done(function(resp){

			})
		});
	});
</script>

<!-- DataTables -->
<script src="<?=COMPONENT_URL?>bower_components/datatables.net/datatables.min.js"></script>
<!-- Bootstrap toggle switch -->
<script src="<?=COMPONENT_URL?>bower_components/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>