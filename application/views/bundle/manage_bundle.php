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
			<div class="page_caption">Manage Bundle</div>
			<div class="page_body table-responsive">
				<!--filter section-->
				<form id="frm_filter" method="post" action="" data-parsley-validate>
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
					
					<table style="width:auto;">
						<tr>
							<td>Subscribers' Base</td>
							<td>Keyword</td>
						</tr>
						<tr>
							<td>
								<select id="subscribers_base" name="SUBSCRIBERS_BASE" class="input_style input_full">
									<option value="">Select One</option>
									<option value="pre_paid">Pre Paid</option>
									<option value="post_paid">Post Paid</option>
								</select>
							</td>
							<td>
	              <input type="text" name="SearchKeyword" class="input_style input_full" />
							</td>
						</tr>
						<tr>
							<td colspan="10">
								<input type="submit" name="filter" class="btn_gray" value="Filter Data" />
								<a class="btn_gray" href="<?php echo $url_prefix; ?>manage_bundle">Refresh</a>
								<a class="btn_gray" href="<?php echo $url_prefix; ?>manage_bundle/print" target="_blank">Print</a>
								<a class="btn_gray" href="<?php echo $url_prefix; ?>manage_bundle/csv" target="_blank">Export</a>
							</td>
						</tr>
					</table>
          
				</form>
				
				<br />
				<?php if( !isset($filter_by) || !$filter_by ){$filter_by = 'All Data';} ?>
				<div class="breadcrumb">Filter By: <?php echo $filter_by; ?></div>
				
				<table class="table table-bordered table-striped">
					<tr>
						<th class="text-center" align="center">Bundle ID</th>
						<th>Subscribers' Base</th>
						<th>Material Code</th>
						<th>Material Name</th>
						<th class="text-center" align="center">MRP (BDT)</th>
						<th class="text-center" align="center">Down Payment (BDT)</th>
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
						<td class="text-center" align="center"><?php echo $this->webspice->tk($v->DOWN_PAYMENT); ?></td>
						<td class="text-center" align="center"><?php echo ucwords(str_replace('_',' ',$v->TYPE)); ?></td>
						<td class="text-center" align="center"><?php echo $v->EMI_MONTH; ?></td>
						<td class="text-center" align="center"><?php if($v->EMI_INTEREST){echo $v->EMI_INTEREST.'%';}; ?></td>
						<td class="text-center" align="center"><?php echo $this->customcache->user_maker($v->CREATED_BY,'USER_NAME'); ?></td>
						<td class="text-center" align="center"><?php echo $this->webspice->formatted_date($v->CREATED_DATE); ?></td>
						<td class="text-center" align="center">
							<?php 
							if( $v->STATUS == 1 ){
								echo '<span class="label label-danger">Not Saved</span>';
							}elseif( $v->STATUS == 2 ){
								echo '<span class="label label-success">Saved</span>';
							}else{
								echo '<span class="label label-danger">Unknown</span>';
							}
							?>
						</td>
						<td class="text-center" align="center">
							<a href="<?php echo $url_prefix; ?>details_bundle/key/<?php echo $this->webspice->encrypt_decrypt($v->BUNDLE_ID,'encrypt'); ?>" class="btn_orange" target="_blank">Details</a>
							
							<?php if( $this->webspice->permission_verify('approve_bundle',true) && $v->STATUS==1 ): ?>
							<a href="<?php echo $url_prefix; ?>manage_bundle/approve/<?php echo $this->webspice->encrypt_decrypt($v->BUNDLE_ID,'encrypt'); ?>" class="btn btn-success btn-sm confirmation">Save</a>
							<?php endif; ?>
							
							<?php if( $this->webspice->permission_verify('approve_bundle',true) && $v->STATUS==1 ): ?>
							<a href="<?php echo $url_prefix; ?>manage_bundle/remove/<?php echo $this->webspice->encrypt_decrypt($v->BUNDLE_ID,'encrypt'); ?>" class="btn btn-danger btn-sm confirmation">Remove</a>
							<?php endif; ?>
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