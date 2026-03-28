<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo $this->webspice->settings()->domain_name; ?>: Bundle</title>
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	
	<?php include(APPPATH."views/global.php"); ?>
</head>

<body>
	<div id="wrapper">
		<div><?php include(APPPATH."views/header.php"); ?></div>
		<div id="page_manage_option" class="main_container page_identifier">
			<div class="page_caption">View Forecast Data</div>
			<div class="page_body table-responsive">
				<table class="table table-bordered table-striped">
					<tr>
						<th class="text-center" align="center">Bundle ID</th>
						<th>Subscribers' Base</th>
						<th>Material Code</th>
						<th>Material Name</th>
						<th class="text-center" align="center">MRP (BDT)</th>
						<!--<th class="text-center" align="center">Down Payment (BDT)</th>-->
						<th class="text-center" align="center">Type</th>
						<th class="text-center" align="center">Emi (Month)</th>
						<th class="text-center" align="center">Emi Interest</th>
						<th class="text-center" align="center">Created By</th>
						<th class="text-center" align="center">Created Date</th>
						<!--<th class="text-center" align="center">Approved By</th>
						<th class="text-center" align="center">Approved Date</th>-->
						<th class="text-center" align="center">Status</th>
						<th class="text-center" align="center">Action</th>
					</tr>
					<?php foreach($get_record as $k=>$v): ?>
					<tr>
						<td class="text-center" align="center"><?php echo $v->BUNDLE_ID; ?></td>
						<td><?php echo ucwords(str_replace('_',' ',$v->SUBSCRIBERS_BASE)); ?></td>
						<td><?php echo $v->MATERIAL_CODE; ?></td>
						<td><?php echo ucwords(str_replace('_',' ',$v->MATERIAL_NAME)); ?></td>
						<td class="text-center" align="center"><?php echo $this->webspice->tk($v->MRP); ?></td>
						<!--<td class="text-center" align="center"><?php echo $this->webspice->tk($v->DOWN_PAYMENT); ?></td>-->
						<td class="text-center" align="center"><?php echo ucwords(str_replace('_',' ',$v->TYPE)); ?></td>
						<td class="text-center" align="center"><?php echo $v->EMI_MONTH; ?></td>
						<td class="text-center" align="center"><?php if($v->EMI_INTEREST){echo $v->EMI_INTEREST.'%';}; ?></td>
						<td class="text-center" align="center"><?php echo $this->customcache->user_maker($v->CREATED_BY,'USER_NAME'); ?></td>
						<td class="text-center" align="center"><?php echo $this->webspice->formatted_date($v->CREATED_DATE); ?></td>
						<td class="text-center" align="center">
							<?php 
							if( $v->STATUS == 1 ){
								echo '<span class="label label-danger">Saved</span>';	
							}elseif( $v->STATUS == 2 ){
								echo '<span class="label label-success">Saved</span>';	
							}else{
								echo '<span class="label label-danger">Unknown</span>';	
							}
							?>
						</td>
						<td class="text-center" align="center">
							<a href="<?php echo $url_prefix; ?>details_forecast_data/key/<?php echo $this->webspice->encrypt_decrypt($v->BUNDLE_ID,'encrypt'); ?>" class="btn_orange" target="_blank">Details</a>
						</td>
					</tr>
					<?php endforeach; ?>
				</table>
				
				<div id="pagination"><?php echo $pager; ?><div class="float_clear_full">&nbsp;</div></div>
				
			</div><!--end .page_body-->

		</div>
		
		<div id="footer_container"><?php include(APPPATH."views/footer.php"); ?></div>
	</div>
</body>
</html>