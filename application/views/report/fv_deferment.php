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
		
		<div id="page_fv_deferment" class="main_container page_identifier">
			<div class="page_caption">Revenue Deferment Report</div>
			<div class="page_body">
				
				<div class="left_section">
					<fieldset class="divider"><legend>Please fill-up the parameter(s)</legend></fieldset>
				
					<div class="stitle">* Mandatory Field</div>
					
					<form id="frm_filter" method="post" action="" target="_blank" data-parsley-validate>
						<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
		            
						<table width="100%">
							<tr>
								<td>
									<div class="form_label">Bundle Name*</div>
									<div>
		               <select name="BUNDLE_ID" class="input_full input_style" required>
				              <option value="">Select One</option>
				              <?php echo $this->customcache->get_bundle(); ?>
	             			</select>
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<div class="form_label">Strat Date (from)*</div>
									<div>
		               <input type="text" name="start_date" class="input_m input_style date_picker" readonly="readonly" required />
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<div class="form_label">End Date (to)*</div>
									<div>
		               <input type="text" name="end_date" class="input_m input_style date_picker" readonly="readonly" required />
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<div>
										<input type="submit" name="view" class="btn_gray" value="View" />
										<input type="submit" name="print" class="btn_gray" value="Print" />
										<input type="submit" name="export" class="btn_gray" value="Export" />
									</div>
								</td>
							</tr>
						</table>
					</form>
				</div>
				
				<div class="right_section">
					
				</div>
				<div class="float_clear_full">&nbsp;</div>
				
				
			</div>

		</div>
		
		<div id="footer_container"><?php include(APPPATH."views/footer.php"); ?></div>
		
	</div>
</body>
</html>