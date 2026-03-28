<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo $this->webspice->settings()->domain_name; ?>: Create Service</title>
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	
	<?php include(APPPATH."views/global.php"); ?>
</head>

<body>
	<div id="wrapper">
		<div><?php include(APPPATH."views/header.php"); ?></div>
		
		<div id="page_create_service" class="main_container page_identifier">
			<div class="page_caption">Create Service</div>
			<div class="page_body">
				
				<div class="left_section">
					<fieldset class="divider"><legend>Please enter service information</legend></fieldset>
				
					<div class="stitle">* Mandatory Field</div>
					
					<form id="frm_create_option" method="post" action="" data-parsley-validate>
						<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
						<input type="hidden" name="key" value="<?php if( isset($edit['SERVICE_ID']) && $edit['SERVICE_ID'] ){echo $this->webspice->encrypt_decrypt($edit['SERVICE_ID'], 'encrypt');} ?>" />
		            
						<table width="100%">
							<tr>
								<td>
									<div class="form_label">Service Name*</div>
									<div>
										<input type="text"  class="input_full input_style" id="service_name" name="service_name" value="<?php echo set_value('service_name',$edit['SERVICE_NAME']); ?>"  required />
										<span class="fred"><?php echo form_error('service_name'); ?></span>
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<div class="form_label">Unit*</div>
									<div>
										<select id="unit" name="unit" class="input_m input_style row_1" required>
										  <option value="">Select One</option>
											<?php if( set_value('unit', $edit['UNIT']) ): ?>
											<?php echo str_replace('value="'.set_value('unit', $edit['UNIT']).'"','value="'.set_value('unit', $edit['UNIT']).'" selected="selected"', $this->customcache->get_unit('option_name')); ?>
											<?php else: ?>
											<?php echo $this->customcache->get_unit('option_name'); ?>
											<?php endif; ?>
										</select>
	            			<span class="fred"><?php echo form_error('unit'); ?></span> 
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<div class="form_label">Unit Price*</div>
									<div>
										<input type="text"  class="input_m input_style" id="unit_price" name="unit_price" value="<?php echo set_value('unit_price',$edit['UNIT_PRICE']); ?>"  required />
										<span class="fred"><?php echo form_error('unit_price'); ?></span>
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<div class="form_label">Price Type*</div>
									<div>
										<select id="price_type" name="price_type" class="input_m input_style row_1" required>
										  <option value="">Select One</option>
										  <option value="NC" <?php set_select('price_type','NC'); if( $edit['PRICE_TYPE']=='NC' ){echo 'selected="selected"';} ?>>NC</option>
										  <option value="average" <?php set_select('price_type','average'); if( $edit['PRICE_TYPE']=='average' ){echo 'selected="selected"';} ?>>Average Price</option>
										  <option value="market_value" <?php set_select('price_type','market_value'); if( $edit['PRICE_TYPE']=='market_value' ){echo 'selected="selected"';} ?>>Market Value</option>
										  <option value="purchase_price" <?php set_select('price_type','purchase_price'); if( $edit['PRICE_TYPE']=='purchase_price' ){echo 'selected="selected"';} ?>>Purchase Price</option>
										</select>
	            			<span class="fred"><?php echo form_error('price_type'); ?></span> 
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<div class="form_label">GL Code*</div>
									<div>
										<input type="text"  class="input_m input_style" id="gl_code" name="gl_code" value="<?php echo set_value('gl_code',$edit['GL_CODE']); ?>"  required />
										<span class="fred"><?php echo form_error('gl_code'); ?></span>
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<div class="form_label">VAT Applicable?*</div>
									<div>
										<select id="vat_applicable" name="vat_applicable" class="input_m input_style row_1" required>
										  <option value="">Select One</option>
										  <option value="yes" <?php set_select('vat_applicable','yes'); if( $edit['VAT_APPLICABLE']=='yes' ){echo 'selected="selected"';} ?>>Yes</option>
										  <option value="no" <?php set_select('vat_applicable','no'); if( $edit['VAT_APPLICABLE']=='no' ){echo 'selected="selected"';} ?>>No</option>
										</select>
	            			<span class="fred"><?php echo form_error('vat_applicable'); ?></span> 
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<div><input type="submit" class="btn_gray" value="Submit Data" /></div>
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