<!DOCTYPE html>
<html>
	<head>		
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Android Report</title>
		<!-- Tell the browser to be responsive to screen width -->
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<!-- Bootstrap 3.3.7 -->
		<link rel="stylesheet" href="<?=COMPONENT_URL?>bower_components/bootstrap/dist/css/bootstrap.min.css">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="<?=COMPONENT_URL?>bower_components/font-awesome/css/font-awesome.min.css">
		
		<!-- jQuery 3 -->
		<script src="<?=COMPONENT_URL?>bower_components/jquery/dist/jquery.min.js"></script>				
		<!-- CONFIG JS -->
		<script src="<?=base_url()?>assets/system/js/config.js"></script>
		<!-- APP JS -->
		<script src="<?=base_url()?>assets/system/js/app.js"></script>		
	</head>
	<script type="text/javascript">
		var SECURITY_NAME = "<?=$this->security->get_csrf_token_name()?>";
		var SECURITY_VALUE = "<?=$this->security->get_csrf_hash()?>";	
		var SITE_URL = "<?=site_url()?>";
	</script>
	
	<body>

		<div class="container">
			{PAGE_CONTENT}  
		</div>		

		<!-- Bootstrap 3.3.7 -->
		<script src="<?=COMPONENT_URL?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
		<!-- FastClick -->
		<script src="<?=COMPONENT_URL?>bower_components/fastclick/lib/fastclick.js"></script>
		<!-- BlockUI -->
		<script src="<?=COMPONENT_URL?>bower_components/jquery.blockUI.js"></script>			
	</body>
</html>
