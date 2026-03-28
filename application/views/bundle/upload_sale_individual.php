<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo $this->webspice->settings()->domain_name; ?>: Upload Sale Individual</title>
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	
	<?php include(APPPATH."views/global.php"); ?>
</head>

<body>
	<div id="wrapper">
		<div><?php include(APPPATH."views/header.php"); ?></div>
		
		<div id="page_upload_sale_individual" class="main_container page_identifier">
			<div class="page_caption">Upload Sale Individual</div>
			<div class="page_body">
				
				<fieldset class="divider"><legend>Please enter service information</legend></fieldset>
			
				<div class="stitle">* Mandatory Field</div>
				
				<form id="frm_upload_sale_individual" method="post" action="" data-parsley-validate>
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
					 
					<div class="left_section">
						<table width="100%">
							<tr>
								<td>
									<div class="form_label">Bundle Name*</div>
									<div>
										<select id="bundle_id" name="bundle_id" class="input_m input_style row_1" required>
										  <option value="">Select One</option>
											<?php echo $this->customcache->get_bundle(); ?>
										</select>
	            			<span class="fred"><?php echo form_error('bundle_id'); ?></span> 
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<div class="form_label">Invoice Date*</div>
									<div>
										<input type="text"  class="input_m input_style date_picker" readonly="readonly" id="invoice_date" name="invoice_date" value="<?php echo set_value('invoice_date'); ?>"  required />
										<span class="fred"><?php echo form_error('invoice_date'); ?></span>
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<div class="form_label">Sold to Party*</div>
									<div>
										<input type="text"  class="input_m input_style" id="sold_to_party" name="sold_to_party" value="<?php echo set_value('sold_to_party'); ?>"  required />
										<span class="fred"><?php echo form_error('sold_to_party'); ?></span>
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<div class="form_label">Invoice No.*</div>
									<div>
										<input type="text"  class="input_m input_style" id="invoice_no" name="invoice_no" value="<?php echo set_value('invoice_no'); ?>"  required />
										<span class="fred"><?php echo form_error('invoice_no'); ?></span>
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<div><input type="submit" class="btn_gray" value="Submit Data" /></div>
								</td>
							</tr>
						</table>
					</div>
					
					<div class="right_section">
						<table width="100%">
							<tr>
								<td>
									<div class="form_label">Description*</div>
									<div>
										<input type="text"  class="input_m input_style" id="description" name="description" value="<?php echo set_value('description'); ?>"  required />
										<span class="fred"><?php echo form_error('description'); ?></span>
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<div class="form_label">Quantity*</div>
									<div>
										<input type="text"  class="input_m input_style" id="quantity" name="quantity" value="<?php echo set_value('quantity'); ?>" data-parsley-type="digits" required />
										<span class="fred"><?php echo form_error('quantity'); ?></span>
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<div class="form_label">Gross Value*</div>
									<div>
										<input type="text"  class="input_m input_style" id="gross_value" name="gross_value" value="<?php echo set_value('gross_value'); ?>" data-parsley-type="number" required />
										<span class="fred"><?php echo form_error('gross_value'); ?></span>
									</div>
								</td>
							</tr>
						</table>
					</div>
					<div class="float_clear_full">&nbsp;</div>
					
				</form>

			</div>
		</div>
		
		<div id="footer_container"><?php include(APPPATH."views/footer.php"); ?></div>
		
	</div>
</body>
</html>