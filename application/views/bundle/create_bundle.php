<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo $this->webspice->settings()->domain_name; ?>: Create Option</title>
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	
	<?php include(APPPATH."views/global.php"); ?>
</head>

<body>
	<div id="wrapper">
		<div><?php include(APPPATH."views/header.php"); ?></div>
		
		<div id="page_create_bundle" class="main_container page_identifier">
			<div class="page_caption">Create Bundle</div>
			<div class="page_body">
				
				<div>
					
					<div class="stitle">* Mandatory Field</div>
					
					<form id="frm_create_option" method="post" style="overflow:hidden;" action="" data-parsley-validate>
						<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
		        
		        <div class="left_section">
							<table width="100%">
								<tr>
									<td>
										<div class="form_label">Subscribers' Base*</div>
										<div>
			               <select id="subscribers_base" name="subscribers_base" class="input_s input_style" required>
					              <option value="">Select One</option>
					              <option value="post_paid" <?php echo set_select('subscribers_base','post_paid'); ?>>Post Paid</option>
					              <option value="pre_paid" <?php echo set_select('subscribers_base','pre_paid'); ?>>Pre Paid</option>
		             			</select>
		            			<span class="fred"><?php echo form_error('subscribers_base'); ?></span> 
										</div>
									</td>
								</tr>
								<tr>
									<td>
										<div class="form_label">Material Code*</div>
										<div>
											<input type="text" class="input_full input_style" id="material_code" name="material_code" value="<?php echo set_value('material_code'); ?>" required />
											<span class="fred"><?php echo form_error('material_code'); ?></span>
										</div>
									</td>
								</tr>
								<tr>
									<td>
										<div class="form_label">Material Name*</div>
										<div>
											<input type="text" class="input_full input_style" id="material_name" name="material_name" value="<?php echo set_value('material_name'); ?>" required />
											<span class="fred"><?php echo form_error('material_name'); ?></span>
										</div>
									</td>
								</tr>
								<tr>
									<td>
										<div class="form_label">MRP (BDT)*</div>
										<div>
											<input type="text" class="input_s input_style" id="mrp" name="mrp" value="<?php echo set_value('mrp'); ?>" required data-parsley-type="digits" />
											<span class="fred"><?php echo form_error('mrp'); ?></span>
										</div>
									</td>
								</tr>
								<tr>
									<td>
										<div class="form_label">Down Payment (BDT)* <span class="stitle">only for EMI</span></div>
										<div>
											<input type="text" class="input_s input_style" id="down_payment" name="down_payment" value="<?php echo set_value('down_payment'); ?>" required data-parsley-type="digits" />
											<span class="fred"><?php echo form_error('down_payment'); ?></span>
										</div>
									</td>
								</tr>
							</table>
						</div>
						
						<div class="right_section">
							<table width="100%">
								<tr>
									<td>
										<div class="form_label">Type*</div>
										<div>
			               <select id="type" name="type" class="input_s input_style" required>
					              <option value="">Select One</option>
					              <option value="in_cash" <?php echo set_select('type','in_cash'); ?>>In Cash</option>
					              <option value="emi" <?php echo set_select('type','emi'); ?>>EMI</option>
					              <option value="credit_card" <?php echo set_select('type','credit_card'); ?>>Credit Card</option>
		             			</select>
		            			<span class="fred"><?php echo form_error('type'); ?></span> 
										</div>
									</td>
								</tr>
								<tr>
									<td>
										<div class="form_label">EMI Month(s) <span class="stitle">(only for type = EMI)</span></div>
										<div>
											<input type="text" class="input_s input_style" id="emi_month" name="emi_month" value="<?php echo set_value('emi_month'); ?>" data-parsley-type="digits"  />
											<span class="fred"><?php echo form_error('emi_month'); ?></span>
										</div>
									</td>
								</tr>
								<tr>
									<td>
										<div class="form_label">Interest Rate (%) <span class="stitle">(only for type = EMI)</span></div>
										<div>
											<input type="text" class="input_s input_style" id="emi_interest" name="emi_interest" value="<?php echo set_value('emi_interest'); ?>" data-parsley-type="number"  />
											<span class="fred"><?php echo form_error('emi_interest'); ?></span>
										</div>
									</td>
								</tr>
								<tr>
									<td>
										<span class="stitle" style="color:darkgreen">NOTE: If the bundle id under EMI then the MRP and Service Quantity might be entered as Monthly basis otherwise the MRP and Service Quantity might be entered as total.</span>
									</td>
								</tr>
							</table>
						</div>
						<div class="float_clear_full">&nbsp;</div>
						
						<br />
						<table class="table table-bordered">
							<tr>
								<th>Bundle Item</th>
								<th>Type</th>
								<th class="col_loop_day">Loop Day(s)</th>
								<th>Quantity</th>
							</tr>
							
							<!--row 1-->
							<tr>
								<td>
									<div>
		               <select id="bundle_item_1" name="bundle_item_1" class="input_full input_style row_1 bundle_item">
				              <option value="">Select One</option>
											<?php if( set_value('bundle_item_1') ): ?>
											<?php echo str_replace('value="'.set_value('bundle_item_1').'"','value="'.set_value('bundle_item_1').'" selected="selected"', $this->customcache->get_bundle_item()); ?>
											<?php else: ?>
											<?php echo $this->customcache->get_bundle_item(); ?>
											<?php endif; ?>
	             			</select>
	            			<span class="fred"><?php echo form_error('bundle_item_1'); ?></span> 
									</div>
								</td>
								<td>
									<div>
		               <select id="type_1" name="type_1" class="input_full input_style row_1">
				              <option value="">Select One</option>
				              <option value="once" <?php echo set_select('type_1','once'); ?>>Once</option>
				              <option value="loop" <?php echo set_select('type_1','loop'); ?>>Loop</option>
	             			</select>
	            			<span class="fred"><?php echo form_error('type_1'); ?></span> 
									</div>
								</td>
								<td class="col_loop_day">
									<div>
										<input type="text"  class="input_full input_style row_1" id="days_1" name="days_1" value="<?php echo set_value('days_1'); ?>" data-parsley-type="digits" />
	            			<span class="fred"><?php echo form_error('days_1'); ?></span> 
									</div>
								</td>
								<td>
									<div>
										<input type="text"  class="input_full input_style row_1" id="quantity_1" name="quantity_1" value="<?php echo set_value('quantity_1'); ?>" data-parsley-type="digits" />
	            			<span class="fred"><?php echo form_error('quantity_1'); ?></span> 
									</div>
								</td>
							</tr>
							
							<!--row 2-->
							<tr>
								<td>
									<div>
		               <select id="bundle_item_2" name="bundle_item_2" class="input_full input_style row_2 bundle_item">
				              <option value="">Select One</option>
											<?php if( set_value('bundle_item_2') ): ?>
											<?php echo str_replace('value="'.set_value('bundle_item_2').'"','value="'.set_value('bundle_item_2').'" selected="selected"', $this->customcache->get_bundle_item()); ?>
											<?php else: ?>
											<?php echo $this->customcache->get_bundle_item(); ?>
											<?php endif; ?>
	             			</select>
	            			<span class="fred"><?php echo form_error('bundle_item_2'); ?></span> 
									</div>
								</td>
								<td>
									<div>
		               <select id="type_2" name="type_2" class="input_full input_style row_2">
				              <option value="">Select One</option>
				              <option value="once" <?php echo set_select('type_2','once'); ?>>Once</option>
				              <option value="loop" <?php echo set_select('type_2','loop'); ?>>Loop</option>
	             			</select>
	            			<span class="fred"><?php echo form_error('type_2'); ?></span> 
									</div>
								</td>
								<td class="col_loop_day">
									<div>
										<input type="text"  class="input_full input_style row_2" id="days_2" name="days_2" value="<?php echo set_value('days_2'); ?>" data-parsley-type="digits" />
	            			<span class="fred"><?php echo form_error('days_2'); ?></span> 
									</div>
								</td>
								<td>
									<div>
										<input type="text"  class="input_full input_style row_2" id="quantity_2" name="quantity_2" value="<?php echo set_value('quantity_2'); ?>" data-parsley-type="digits" />
	            			<span class="fred"><?php echo form_error('quantity_2'); ?></span> 
									</div>
								</td>
							</tr>
							
							<!--row 3-->
							<tr>
								<td>
									<div>
		               <select id="bundle_item_3" name="bundle_item_3" class="input_full input_style row_3 bundle_item">
				              <option value="">Select One</option>
											<?php if( set_value('bundle_item_3') ): ?>
											<?php echo str_replace('value="'.set_value('bundle_item_3').'"','value="'.set_value('bundle_item_3').'" selected="selected"', $this->customcache->get_bundle_item()); ?>
											<?php else: ?>
											<?php echo $this->customcache->get_bundle_item(); ?>
											<?php endif; ?>
	             			</select>
	            			<span class="fred"><?php echo form_error('bundle_item_3'); ?></span> 
									</div>
								</td>
								<td>
									<div>
		               <select id="type_3" name="type_3" class="input_full input_style row_3">
				              <option value="">Select One</option>
				              <option value="once" <?php echo set_select('type_3','once'); ?>>Once</option>
				              <option value="loop" <?php echo set_select('type_3','loop'); ?>>Loop</option>
	             			</select>
	            			<span class="fred"><?php echo form_error('type_3'); ?></span> 
									</div>
								</td>
								<td class="col_loop_day">
									<div>
										<input type="text"  class="input_full input_style row_3" id="days_3" name="days_3" value="<?php echo set_value('days_3'); ?>" data-parsley-type="digits" />
	            			<span class="fred"><?php echo form_error('days_3'); ?></span> 
									</div>
								</td>
								<td>
									<div>
										<input type="text"  class="input_full input_style row_3" id="quantity_3" name="quantity_3" value="<?php echo set_value('quantity_3'); ?>" data-parsley-type="digits" />
	            			<span class="fred"><?php echo form_error('quantity_3'); ?></span> 
									</div>
								</td>
							</tr>
							
							<!--row 4-->
							<tr>
								<td>
									<div>
		               <select id="bundle_item_4" name="bundle_item_4" class="input_full input_style row_4 bundle_item">
				              <option value="">Select One</option>
											<?php if( set_value('bundle_item_4') ): ?>
											<?php echo str_replace('value="'.set_value('bundle_item_4').'"','value="'.set_value('bundle_item_4').'" selected="selected"', $this->customcache->get_bundle_item()); ?>
											<?php else: ?>
											<?php echo $this->customcache->get_bundle_item(); ?>
											<?php endif; ?>
	             			</select>
	            			<span class="fred"><?php echo form_error('bundle_item_4'); ?></span> 
									</div>
								</td>
								<td>
									<div>
		               <select id="type_4" name="type_4" class="input_full input_style row_4">
				              <option value="">Select One</option>
				              <option value="once" <?php echo set_select('type_4','once'); ?>>Once</option>
				              <option value="loop" <?php echo set_select('type_4','loop'); ?>>Loop</option>
	             			</select>
	            			<span class="fred"><?php echo form_error('type_4'); ?></span> 
									</div>
								</td>
								<td class="col_loop_day">
									<div>
										<input type="text"  class="input_full input_style row_4" id="days_4" name="days_4" value="<?php echo set_value('days_4'); ?>" data-parsley-type="digits" />
	            			<span class="fred"><?php echo form_error('days_4'); ?></span> 
									</div>
								</td>
								<td>
									<div>
										<input type="text"  class="input_full input_style row_4" id="quantity_4" name="quantity_4" value="<?php echo set_value('quantity_4'); ?>" data-parsley-type="digits" />
	            			<span class="fred"><?php echo form_error('quantity_4'); ?></span> 
									</div>
								</td>
							</tr>
							
							<!--row 5-->
							<tr>
								<td>
									<div>
		               <select id="bundle_item_5" name="bundle_item_5" class="input_full input_style row_5 bundle_item">
				              <option value="">Select One</option>
											<?php if( set_value('bundle_item_5') ): ?>
											<?php echo str_replace('value="'.set_value('bundle_item_5').'"','value="'.set_value('bundle_item_5').'" selected="selected"', $this->customcache->get_bundle_item()); ?>
											<?php else: ?>
											<?php echo $this->customcache->get_bundle_item(); ?>
											<?php endif; ?>
	             			</select>
	            			<span class="fred"><?php echo form_error('bundle_item_5'); ?></span> 
									</div>
								</td>
								<td>
									<div>
		               <select id="type_5" name="type_5" class="input_full input_style row_5">
				              <option value="">Select One</option>
				              <option value="once" <?php echo set_select('type_5','once'); ?>>Once</option>
				              <option value="loop" <?php echo set_select('type_5','loop'); ?>>Loop</option>
	             			</select>
	            			<span class="fred"><?php echo form_error('type_5'); ?></span> 
									</div>
								</td>
								<td class="col_loop_day">
									<div>
										<input type="text"  class="input_full input_style row_5" id="days_5" name="days_5" value="<?php echo set_value('days_5'); ?>" data-parsley-type="digits" />
	            			<span class="fred"><?php echo form_error('days_5'); ?></span> 
									</div>
								</td>
								<td>
									<div>
										<input type="text"  class="input_full input_style row_5" id="quantity_5" name="quantity_5" value="<?php echo set_value('quantity_5'); ?>" data-parsley-type="digits" />
	            			<span class="fred"><?php echo form_error('quantity_5'); ?></span> 
									</div>
								</td>
							</tr>
							
							<!--row 6-->
							<tr>
								<td>
									<div>
		               <select id="bundle_item_6" name="bundle_item_6" class="input_full input_style row_6 bundle_item">
				              <option value="">Select One</option>
											<?php if( set_value('bundle_item_6') ): ?>
											<?php echo str_replace('value="'.set_value('bundle_item_6').'"','value="'.set_value('bundle_item_6').'" selected="selected"', $this->customcache->get_bundle_item()); ?>
											<?php else: ?>
											<?php echo $this->customcache->get_bundle_item(); ?>
											<?php endif; ?>
	             			</select>
	            			<span class="fred"><?php echo form_error('bundle_item_6'); ?></span> 
									</div>
								</td>
								<td>
									<div>
		               <select id="type_6" name="type_6" class="input_full input_style row_6">
				              <option value="">Select One</option>
				              <option value="once" <?php echo set_select('type_6','once'); ?>>Once</option>
				              <option value="loop" <?php echo set_select('type_6','loop'); ?>>Loop</option>
	             			</select>
	            			<span class="fred"><?php echo form_error('type_6'); ?></span> 
									</div>
								</td>
								<td class="col_loop_day">
									<div>
										<input type="text"  class="input_full input_style row_6" id="days_6" name="days_6" value="<?php echo set_value('days_6'); ?>" data-parsley-type="digits" />
	            			<span class="fred"><?php echo form_error('days_6'); ?></span> 
									</div>
								</td>
								<td>
									<div>
										<input type="text"  class="input_full input_style row_6" id="quantity_6" name="quantity_6" value="<?php echo set_value('quantity_6'); ?>" data-parsley-type="digits" />
	            			<span class="fred"><?php echo form_error('quantity_6'); ?></span> 
									</div>
								</td>
							</tr>
							
							<!--row 7-->
							<tr>
								<td>
									<div>
		               <select id="bundle_item_7" name="bundle_item_7" class="input_full input_style row_7 bundle_item">
				              <option value="">Select One</option>
											<?php if( set_value('bundle_item_7') ): ?>
											<?php echo str_replace('value="'.set_value('bundle_item_7').'"','value="'.set_value('bundle_item_7').'" selected="selected"', $this->customcache->get_bundle_item()); ?>
											<?php else: ?>
											<?php echo $this->customcache->get_bundle_item(); ?>
											<?php endif; ?>
	             			</select>
	            			<span class="fred"><?php echo form_error('bundle_item_7'); ?></span> 
									</div>
								</td>
								<td>
									<div>
		               <select id="type_7" name="type_7" class="input_full input_style row_7">
				              <option value="">Select One</option>
				              <option value="once" <?php echo set_select('type_7','once'); ?>>Once</option>
				              <option value="loop" <?php echo set_select('type_7','loop'); ?>>Loop</option>
	             			</select>
	            			<span class="fred"><?php echo form_error('type_7'); ?></span> 
									</div>
								</td>
								<td class="col_loop_day">
									<div>
										<input type="text"  class="input_full input_style row_7" id="days_7" name="days_7" value="<?php echo set_value('days_7'); ?>" data-parsley-type="digits" />
	            			<span class="fred"><?php echo form_error('days_7'); ?></span> 
									</div>
								</td>
								<td>
									<div>
										<input type="text"  class="input_full input_style row_7" id="quantity_7" name="quantity_7" value="<?php echo set_value('quantity_7'); ?>" data-parsley-type="digits" />
	            			<span class="fred"><?php echo form_error('quantity_7'); ?></span> 
									</div>
								</td>
							</tr>
						</table>
						
						<table>
							<tr>
								<td>
									<div><input type="submit" class="btn_gray" value="Submit Data" /></div>
								</td>
							</tr>
						</table>
					</form>
				</div>
				<div class="float_clear_full">&nbsp;</div>
				
				
			</div>

		</div>
		
		<div id="footer_container"><?php include(APPPATH."views/footer.php"); ?></div>
		
	</div>
</body>
</html>