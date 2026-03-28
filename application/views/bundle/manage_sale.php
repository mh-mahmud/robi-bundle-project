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
		
		<div id="page_manage_sale_batch" class="main_container page_identifier">
			<div class="page_caption">Manage Sale Batch</div>
			<div class="page_body table-responsive">
				<!--filter section-->
				<form id="frm_filter" method="post" action="" data-parsley-validate>
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
					
					<table style="width:auto;">
						<tr>
							<td>Subscribers' Base</td>
							<td>Channel</td>
						</tr>
						<tr>
							<td>
               	<select id="subscribers_base" name="SUBSCRIBERS_BASE" class="input_full input_style">
		              <option value="">Select One</option>
		              <option value="post_paid">Post Paid</option>
		              <option value="pre_paid">Pre Paid</option>
           			</select>
							</td>
							<td>
	             	<select id="channel" name="CHANNEL" class="input_full input_style">
		              <option value="">Select One</option>
		              <option value="RSP">RSP</option>
		              <option value="WIC/CCC">WIC/CCC</option>
		              <option value="SME/Corporate">SME/Corporate</option>
	         			</select>
	         		</td>
						</tr>
						<tr>
							<td>Date From</td>
							<td>Date To</td>
						</tr>
						<tr>
							<td><input type="text" class="date_picker input_style" id="date_from" name="date_from" /></td>
							<td><input type="text" class="date_picker input_style" id="date_end" name="date_end" /></td>
						</tr>
						<tr>
							<td colspan="2">
								<input type="submit" name="filter" class="btn_gray" value="Filter Data" />
								<a class="btn_gray" href="<?php echo $url_prefix; ?>manage_sale">Refresh</a>
								<a class="btn_gray" href="<?php echo $url_prefix; ?>manage_sale/print" target="_blank">Print</a>
								<a class="btn_gray" href="<?php echo $url_prefix; ?>manage_sale/csv" target="_blank">Export</a>
							</td>
						</tr>
					</table>
          
				</form>
				
				<br />
				<?php if( !isset($filter_by) || !$filter_by ){$filter_by = 'All Data';} ?>
				<div class="breadcrumb">Filter By: <?php echo $filter_by; ?></div>
				
				<table class="table table-bordered table-striped">
					<tr>
						<th class="text-center" align="center">Subscribers' Base</th>
						<th>Material Code</th>
						<th>Material Name</th>
						<th>Invocie No.</th>
						<th>Invocie Date</th>
						<th>Channel</th>
						<th class="text-center" align="center">Quantity</th>
						<th class="text-center" align="center">Gross Value</th>
						<th class="text-center" align="center">Uploaded By</th>
						<th class="text-center" align="center">Uploaded Date</th>
					</tr>
					<?php foreach($get_record as $k=>$v): ?>
					<tr>
						<td class="text-center" align="center"><?php echo ucwords(str_replace('_',' ',$v->SUBSCRIBERS_BASE)); ?></td>
						<td><?php echo $v->MATERIAL_CODE; ?></td>
						<td><?php echo $this->customcache->bundle_maker($v->BUNDLE_ID,'MATERIAL_NAME'); ?></td>
						<td><?php echo $v->INVOICE_NO; ?></td>
						<td><?php echo $this->webspice->formatted_date($v->INVOICE_DATE); ?></td>
						<td><?php echo $v->CHANNEL; ?></td>
						<td class="text-center" align="center"><?php echo $v->QUANTITY; ?></td>
						<td class="text-center" align="center"><?php echo $this->webspice->tk($v->GROSS_VALUE); ?></td>
						<td class="text-center" align="center"><?php echo $this->customcache->user_maker($v->CREATED_BY,'USER_NAME'); ?></td>
						<td class="text-center" align="center"><?php echo $this->webspice->formatted_date($v->CREATED_DATE); ?></td>
						
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