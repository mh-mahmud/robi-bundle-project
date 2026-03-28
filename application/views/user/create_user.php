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
		<div id="page_create_user" class="main_container page_identifier">
			<div class="page_caption">Create User</div>
			<div class="page_body">
				<div class="left_section">
					<fieldset class="divider"><legend>Please enter user information</legend></fieldset>
					<div class="stitle">* Mandatory Field</div>
					<form id="frm_create_user" method="post" action="" data-parsley-validate>
						<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
						<input type="hidden" name="user_id" value="<?php if( isset($edit['USER_ID']) && $edit['USER_ID'] ){echo $this->webspice->encrypt_decrypt($edit['USER_ID'], 'encrypt');} ?>" />
						<table width="100%">
							<tr>
								<td>
									<div class="form_label">User Name*</div>
									<div>
										<input type="text"  class="input_full input_style" id="register_name" name="register_name" value="<?php echo set_value('register_name',$edit['USER_NAME']); ?>"  required />
										<span class="fred"><?php echo form_error('register_name'); ?></span>
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<div class="form_label">User Email</div>
									<div>
										<input type="email" class="input_full input_style" id="register_email" name="register_email" value="<?php echo set_value('register_email',$edit['USER_EMAIL']); ?>"  required />
										<span class="fred"><?php echo form_error('register_email'); ?></span>
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<div class="form_label">User Phone*</div>
									<div>
										<input type="text" class="input_full input_style" id="register_phone" name="register_phone" value="<?php echo set_value('register_phone',$edit['USER_PHONE']); ?>"  required />
										<span class="fred"><?php echo form_error('register_phone'); ?></span>
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<div class="form_label">User Role*</div>
									<div>
		               <select name="user_role" class="input_full input_style" required>
				              <option value="">Select One</option>
				              <?php if( set_value('user_role', $edit['ROLE_ID']) ): ?>
				              <?php echo str_replace('value="'.set_value('user_role', $edit['ROLE_ID']).'"','value="'.set_value('user_role', $edit['ROLE_ID']).'" selected="selected"', $this->customcache->get_user_role()); ?>
				              <?php else: ?>
				              <?php echo $this->customcache->get_user_role(); ?>
				              <?php endif; ?>
	             			</select>
	            			<span class="fred"><?php echo form_error('user_role'); ?></span> 
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