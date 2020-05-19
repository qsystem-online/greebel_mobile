<div class="row" style="margin-top:20px">
	<div class="input-group">
		<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
		<input type="text" id="date-log" class="form-control" value="<?=date('01/m/y') .' - ' . date('d/m/y') ?>">
	</div>    
</div>

<div class="row">
	<h2><a href="sales_report/test" target="_blank">Report Summary </a></h2>
	<div class="row">
		<p class="col-md-10"><b>Level :<span id="report-level"></span><span id="report-owner"></span></b></p>            		
	</div>

	<table class="table table-striped">
		<thead>
			<tr>
				<th></th>
				<th>Name</th>
				<th class='text-right'>Total Omset Harian</th>
				<th class='text-right'>Total Omset Bulanan</th>
				<th class='text-center'>Efektifitas</th>
			</tr>
		</thead>
		<tbody id="body-report"></tbody>
	</table>
</div>


<script type="text/javascript">
	$(function(){		
		$("#date-log").daterangepicker({
			minDate: moment().startOf('month').format('DD/MM/YYYY'),
			maxDate:moment().format('DD/MM/YYYY'),
			locale: {
				format: 'DD/MM/YYYY'
			}
		},function(){
			//alert("Get Report");
			getReport("<?=$salesCode?>");
			
		});		
		/*
		$("#date-log").change(function(e){			
			getReport("<?=$salesCode?>");
		});
		*/
		$("#body-report").on("click",".subreport",function(e){
			e.preventDefault();

			salesCode = $(this).data("code");
			getReport(salesCode);
		}) 

		getReport("<?=$salesCode?>");
	});

	function getReport(salesCode){
		var currentLevel = $("#report-level").text();
		currentLevel = currentLevel.toUpperCase();

		var level ="";
		if (currentLevel == ""){
			level ="";
		}else if (currentLevel == "NATIONAL"){
			level ="REGIONAL";
		}else if (currentLevel == "REGIONAL"){
			level ="AREA";
		}else if (currentLevel == "AREA"){
			level ="SALES";
		}else if (currentLevel == "SALES"){
			return;
		}

		App.blockUIOnAjaxRequest();

		$.ajax({
			url:"<?= site_url() ?>report/sales_report/ajxGetSumReport",
			method:"POST",
			data:{
				salesCode:salesCode,
				daterange:$("#date-log").val(),
				level: level,
			}
		}).done(function(resp){				
			if (resp.status == "SUCCESS"){
				$("#body-report").empty();
				var level = resp.data.level.toUpperCase();
				$("#report-level").text(level);
				$("#report-owner").text(" - " + salesCode);

				var details = resp.data.detail;
				var hideCaret = level == "SALES" ? "none" :"unset";
				$.each(details , function(i,v){
					sstr = "<tr class='subreport' data-code='"+v.fst_code+"'>";
					sstr += "<td><i class='fa fa-caret-right' style='display:"+hideCaret+"'></i></td>";
					sstr += "<td>"+v.fst_name+"</td>";
					sstr += "<td class='text-right'>"+ App.money_format(v.ttl_daily_omset) +"</td>";
					sstr += "<td class='text-right'>"+ App.money_format(v.ttl_monthly_omset) +"</td>";
					sstr += "<td class='text-center'>"+ v.ttl_visited + "/" + v.ttl_schedule+"</td>";
					sstr += "</tr>";

					$("#body-report").append(sstr);
				});
			}
		});
	}
</script>