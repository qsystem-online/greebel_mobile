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
				<h3 class="box-title"></h3>
				<div class="box-tools">
					
				</div>

			</div>			
			<!-- /.box-header -->
			<div class="box-body">
				<div class="row">
					<div class="col-lg-6">
						<label style="width:100px">Order ID</label>
						<label>:</label>
						<label><?= $order["fst_order_id"]?></label>
					</div>
					<div class="col-lg-6 text-right">
						<label>Order Datetime :</label>
						<label><?= $order["fdt_order_datetime"]?></label>
					</div>					
				</div>			
				<div class="row">
					<div class="col-lg-12">
						<label style="width:100px">Sales</label>
						<label>:</label>
						<label style=""><?= $order["fst_sales_name"]?></label>
					</div>
				</div>

				<div class="row">
					<div class="col-lg-12">
						<label style="width:100px;">Customer</label>
						<label>:</label>
						<label style="text-align:left"> <?= $order["fst_cust_code"] . " - " . $order["fst_cust_name"] ?></label>
					</div>
				</div>

				<div class="row">
					<div class="col-lg-12">
						<label style="width:100px;">Notes</label>
						<label>:</label>
						<label style="text-align:left"> <?= $order["fst_notes"] ?></label>
					</div>
				</div>

				<div class="row">
					<div class="col-lg-12">
					<table id="tblDetails" class="table table-bordered table-hover table-striped"></table>
					</div>
				</div>

				<div class="row">
					<div class="col-lg-12 text-right">
						<label style="font-style: italic;">Sub Total</label>
						<label>:</label>
						<label id="lblDPP" class="text-right" style="width:100px;"></label>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12 text-right">
						<label style="font-style: italic;">PPN</label>
						<label>:</label>
						<label id="lblPPN" class="text-right" style="width:100px;"></label>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12 text-right">
						<label style="font-style: italic;" >Total</label>
						<label>:</label>
						<label id="lblTotal" class="text-right" style="width:100px;"></label>
					</div>
				</div>
				]
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
		
		var details = <?= json_encode($order["details"]); ?>;
		$("#tblDetails").DataTable({
			data:details,
			columns: [
				{ title: "Item",data:"fst_item_name" },
				{ title: "Satuan",data:"fst_satuan" },
				{ title: "Qty",data:"fin_qty",className:"text-right" },
				{ title: "Price",data:"fin_price",className:"text-right",render:$.fn.dataTable.render.number( '\,', '.', 2, '' )},
				{ title: "Total",className:"text-right",
					render : function(data,type,row,meta){
						//return row.fin_qty * row.fin_price;
						//console.log( $.fn.dataTable.render.number(",", ".", 2, ''));
						return $.fn.dataTable.render.number( '\,', '.', 2, '' ).display(row.fin_qty * row.fin_price);
					}
				}
			],
			paging: false,
			searching: false,
    		ordering:  false
		});

		calculateTotal();

		$("#btnTotal").click(function(event){
			event.preventDefault();
			calculateTotal();
		})


	});

	
	function calculateTotal(){
		t = $("#tblDetails").DataTable();
		data = t.data();
		total =0;
		$.each(data , function(i,v){
			total += v.fin_qty * v.fin_price;
		});
		
		//dpp = total / 1.1;
		dpp = total;
		ppn = dpp * 10/100;

		$("#lblDPP").html( $.fn.dataTable.render.number( '\,', '.', 2, '' ).display(dpp));
		$("#lblPPN").html( $.fn.dataTable.render.number( '\,', '.', 2, '' ).display(ppn));
		$("#lblTotal").html( $.fn.dataTable.render.number( '\,', '.', 2, '' ).display(dpp + ppn));
	}
</script>
<!-- DataTables -->
<script src="<?=base_url()?>bower_components/datatables.net/datatables.min.js"></script>
<!--
<script src="<?=base_url()?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?=base_url()?>bower_components/datatables.net/js/datetime.js"></script>
<script src="<?=base_url()?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
-->
