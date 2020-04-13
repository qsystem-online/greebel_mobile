<section class="content-header">
	<h1><?=lang("Configuration")?><small><?=lang("form")?></small></h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> <?= lang("Home") ?></a></li>
		<li><a href="#"><?= lang("Config") ?></a></li>
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
			
			<!-- form start -->
            <form id="frmUser" class="form-horizontal" action="<?=site_url()?>user/add" method="POST" enctype="multipart/form-data">				
				<div class="box-body">
					<input type="hidden" name = "<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>">

                    <div class='form-group'>
                        <label for="fin_user_id" class="col-sm-12"><?=lang("Change Pass Admin")?></label>
						<div class="col-sm-12">
							<input type="text" class="form-control" id="fst_curr_pass_admin" placeholder="<?=lang("Current Password")?>" name="fst_curr_pass_admin" value="">
							<div id="fst_curr_pass_admin" class="text-danger"></div>
						</div>
                    </div>
                    <div class='form-group'>    
						<div class="col-sm-12">
							<input type="text" class="form-control" id="fst_new_pass" placeholder="<?=lang("New Password")?>" name="fst_new_pass" value="">
							<div id="fst_new_pass_err" class="text-danger"></div>
						</div>                        
					</div>
                    
                    <div class='form-group'>    
						<div class="col-sm-12">
							<input type="text" class="form-control" id="fst_confirm_new_pass" placeholder="<?=lang("Confirm New Password")?>" name="fst_confirm_new_pass" value="">
							<div id="fst_confirm_new_pass_err" class="text-danger"></div>
						</div>                        
					</div>
                    <div class='form-group'>    
						<div class="col-sm-12 text-right">
							<input type="button" class="btn btn-primary" id="btn-update-pass" value="Update Password">
							
						</div>                        
					</div>


					
				</div>
				<!-- end box-body -->
				<div class="box-footer">
					
				</div>
				<!-- end box-footer -->			
			</form>
		</div>
	</div>
</section>