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
		
		<div id="page_create_option" class="main_container page_identifier">
			<div class="page_caption">Create Option</div>
			<div class="page_body">
				
				<div class="left_section">
					<fieldset class="divider"><legend>Please enter user information</legend></fieldset>
				
					<div class="stitle">* Mandatory Field</div>
					
					<form id="frm_create_option" method="post" action="" data-parsley-validate>
						<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
						<input type="hidden" name="key" value="<?php if( isset($edit['OPTION_ID']) && $edit['OPTION_ID'] ){echo $this->webspice->encrypt_decrypt($edit['OPTION_ID'], 'encrypt');} ?>" />
		            
						<table width="100%">
							<tr>
								<td>
									<div class="form_label">Group Name*</div>
									<div>
		               <select name="group_name" class="input_full input_style" required>
				              <option value="">Select One</option>
				              <option value="unit_name" <?php echo set_select('group_name', 'unit_name'); if( !set_value('group_name') && $edit['GROUP_NAME']=='unit_name' ){echo 'selected="selected"';} ?>>Unit Name</option>
				              <option value="SD (%)" <?php echo set_select('group_name', 'SD (%)'); if( !set_value('group_name') && $edit['GROUP_NAME']=='SD (%)' ){echo 'selected="selected"';} ?>>SD (%)</option>
				              <option value="VAT (%)" <?php echo set_select('group_name', 'VAT (%)'); if( !set_value('group_name') && $edit['GROUP_NAME']=='VAT (%)' ){echo 'selected="selected"';} ?>>VAT (%)</option>
	             			</select>
	            			<span class="fred"><?php echo form_error('group_name'); ?></span> 
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<div class="form_label">Option Value*</div>
									<div>
										<input type="text"  class="input_full input_style" id="option_value" name="option_value" value="<?php echo set_value('option_value',$edit['OPTION_VALUE']); ?>"  required />
										<span class="fred"><?php echo form_error('option_value'); ?></span>
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