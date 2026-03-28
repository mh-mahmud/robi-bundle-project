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
		
		<div id="page_bundle_details" class="main_container page_identifier">
			<div class="page_caption">Details Forecast Data</div>
			<div class="page_body table-responsive">
			<!--	<table style="width:auto;">
					<tr>
						<td colspan="10">
							<a class="btn_gray" href="<?php echo $url_prefix; ?>details_forecast_data/print" target="_blank">Print</a>
							<a class="btn_gray" href="<?php echo $url_prefix; ?>details_forecast_data/csv" target="_blank">Export</a>
						</td>
					</tr>
				</table>-->

				
				<br />
				<?php if( !isset($filter_by) || !$filter_by ){$filter_by = 'All Data';} ?>
				<div class="breadcrumb"><?php echo $filter_by; ?></div>
				
				<table class="table table-bordered table-striped">
					<tr>
						<th class="text-center" align="center">Item ID</th>
						<th>Item Name</th>
						<th class="text-center" align="center">GL Code</th>
						<th class="text-center" align="center">Type</th>
						<th class="text-center" align="center">Loop Day(s)</th>
						<th class="text-center" align="center">Quantity</th>
						<th class="text-center" align="center">Unit</th>
						<th class="text-center" align="center">Unit Price</th>
						<th class="text-center" align="center">Price Type</th>
						<th class="text-center" align="center">VAT Applicable?</th>
					</tr>
					<?php foreach($get_record as $k=>$v): ?>
					<tr>
						<td class="text-center" align="center"><?php echo $v->SERVICE_ID; ?></td>
						<td><?php echo ucwords(str_replace('_',' ',$v->SERVICE_NAME)); ?></td>
						<td class="text-center" align="center"><?php echo $v->GL_CODE; ?></td>
						<td class="text-center" align="center"><?php echo $v->TYPE; ?></td>
						<td class="text-center" align="center">
							<?php
							$bundle_type = $this->customcache->bundle_maker($v->BUNDLE_ID,'TYPE');
							$emi_month = $this->customcache->bundle_maker($v->BUNDLE_ID,'EMI_MONTH');
							$loop_days = $v->LOOP_DAYS;

							if($bundle_type == 'emi' && $v->TYPE=='loop'){
								$loop_days = $emi_month * 30;
							}
							echo $loop_days; 
							?>
						</td>
						<td class="text-center" align="center"><?php echo $v->QUANTITY; ?></td>
						<td class="text-center" align="center"><?php echo $v->UNIT; ?></td>
						<td class="text-center" align="center"><?php echo $v->UNIT_PRICE; ?></td>
						<td class="text-center" align="center"><?php echo ucwords(str_replace('_',' ',$v->PRICE_TYPE)); ?></td>
						<td class="text-center" align="center"><?php echo ucwords($v->VAT_APPLICABLE); ?></td>
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