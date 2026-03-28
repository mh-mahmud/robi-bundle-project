<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo $this->webspice->settings()->domain_name; ?>: Welcome</title>
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	
	<?php include(APPPATH."views/global.php"); ?>
</head>

<body>
	<div id="wrapper">
		<div><?php include(APPPATH."views/header.php"); ?></div>
		
		<div id="page_manage_role" class="main_container page_identifier">
			<div class="page_caption">Manage Role</div>

			<div class="page_body table-responsive">
				<!--filter section-->
				<form id="frm_filter" method="post" action="" data-parsley-validate>
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
					
					<table style="width:auto;">
						<tr>
							<td>Keyword</td>
							<td>Date From</td>
							<td>Date End</td>
						</tr>
						<tr>
							<td>
	              <input type="text" name="SearchKeyword" class="input_style input_full" />
							</td>
							<td><input type="text" class="date_picker input_style" id="date_from" name="date_from" /></td>
							<td><input type="text" class="date_picker input_style" id="date_end" name="date_end" /></td>
						</tr>
						<tr>
							<td colspan="10">
								<input type="submit" name="filter" class="btn_gray" value="Filter Data" />
								<a class="btn_gray" href="<?php echo $url_prefix; ?>manage_role">Refresh</a>
							</td>
						</tr>
					</table>
          
				</form>
				
				<br />
				<?php if( !isset($filter_by) || !$filter_by ){$filter_by = 'All Data';} ?>
				<div class="breadcrumb">Filter By: <?php echo $filter_by; ?></div>

				<table class="table table-bordered table-striped">
					<tr>
						<th>Role ID</th>
						<th>Role Name</th>
						<th>Permission Name</th>
						<th>Created By</th>
						<th>Created Date</th>
						<th>Updated By</th>
						<th>Updated Date</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
					<?php foreach($get_record as $k=>$v): ?>
					<tr>
						<td><?php echo $v->ROLE_ID; ?></td>
						<td><?php echo $v->ROLE_NAME; ?></td>
						<td><?php echo ucwords(str_replace(',',', ', str_replace('_',' ',$v->PERMISSION_NAME))); ?></td>
						<td><?php echo $this->customcache->user_maker($v->CREATED_BY,'USER_NAME'); ?></td>
						<td><?php echo $this->webspice->formatted_date($v->CREATED_DATE); ?></td>
						<td><?php echo $this->customcache->user_maker($v->UPDATED_BY,'USER_NAME'); ?></td>
						<td><?php echo $this->webspice->formatted_date($v->UPDATED_DATE); ?></td>
						<td><?php echo $this->webspice->static_status($v->STATUS); ?></td>
						<td>
							<?php if( $this->webspice->permission_verify('manage_role',true) && $v->STATUS!=9 ): ?>
							<a href="<?php echo $url_prefix; ?>manage_role/edit/<?php echo $this->webspice->encrypt_decrypt($v->ROLE_ID,'encrypt'); ?>" class="btn_orange">Edit</a>
							<?php endif; ?>
							
							<?php if( $this->webspice->permission_verify('manage_role',true) && $v->STATUS==7 ): ?>
							<a href="<?php echo $url_prefix; ?>manage_role/inactive/<?php echo $this->webspice->encrypt_decrypt($v->ROLE_ID,'encrypt'); ?>" class="btn_orange">Inactive</a>
							<?php endif; ?>
							
							<?php if( $this->webspice->permission_verify('manage_role',true) && $v->STATUS==-7 ): ?>
							<a href="<?php echo $url_prefix; ?>manage_role/active/<?php echo $this->webspice->encrypt_decrypt($v->ROLE_ID,'encrypt'); ?>" class="btn_orange">Active</a>
							<?php endif; ?>
						</td>
					</tr>
					<?php endforeach; ?>
				</table>
			</div><!--end .page_body-->

		</div>
		
		<div id="footer_container"><?php include(APPPATH."views/footer.php"); ?></div>
	</div>
</body>
</html>