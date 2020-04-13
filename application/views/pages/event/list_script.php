<script type="text/javascript">
    function getEventDate(row){
        return dateTimeFormat(row.fdt_event_start) + " - " + dateTimeFormat(row.fdt_event_end);
    }
    function getSchool(row){
        return row.fst_cust_name;
    }
    function getAction(row){
		var action = "<a class='btn btn-edit-row' href='event/edit/" + row.fin_event_id + "' title='edit' ><i class='fa fa-pencil' aria-hidden='true'></i></a> &nbsp;";
		action += "<a class='btn-add-budget' title='budget'><i class='fa fa-list-alt' aria-hidden='true'></i></a>";
		return action;
    }
    
    $(function(){
		/*
        $('#tblList').on('click','.btn-edit-row',function(e){
			e.preventDefault();
			alert("Edit");
		});
		*/
    });
</script>