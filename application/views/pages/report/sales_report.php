<div class="row" style="margin-top:20px">
	<div class="input-group">
		<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
		<input type="text" id="date-log" class="form-control" value="01/05/2020 - 18/05/2020">
	</div>    
</div>

<div class="row">
	<h2><a href="sales_report/test" target="_blank">Report Summary </a></h2>
	<div class="row">
		<p class="col-md-10"><b>Level :<span id="report-level"></span></b></p>            		
	</div>

	<table class="table table-striped">
		<thead>
			<tr>
				<th></th>
				<th>Name</th>
				<th>Total Omset Harian</th>
				<th>Total Omset Bulanan</th>
				<th>Efektifitas</th>
			</tr>
		</thead>
		<tbody id="body-report">
			<tr class="subreport" data-code='DYK'>
				<td ><i class="fa fa-caret-right"></i></td>
				<td>Doyok</td>
				<td>1.000.000</td>
				<td>20.000.000</td>
				<td>5/10</td>
			</tr>		
		</tbody>
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
				var details = resp.data.detail;
				$.each(details , function(i,v){
					sstr = "<tr class='subreport' data-code='"+v.fst_code+"'>";
					sstr += "<td><i class='fa fa-caret-right'></i></td>";
					sstr += "<td>"+v.fst_name+"</td>";
					sstr += "<td>"+v.ttl_daily_omset+"</td>";
					sstr += "<td>"+v.ttl_monthly_omset+"</td>";
					sstr += "<td>"+ v.ttl_visited + "/" + v.ttl_schedule+"</td>";
					sstr += "</tr>";

					$("#body-report").append(sstr);
				});
			}
		});
	}
</script>