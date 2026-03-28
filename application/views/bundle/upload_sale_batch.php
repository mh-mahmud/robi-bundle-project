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
		
		<div id="page_upload_sale_batch" class="main_container page_identifier">
			<div class="page_caption">Upload Sale Batch</div>
			<div class="page_body">
				
				<!--file upload error-->
				<?php if( isset($error) && $error ): ?>
				<div class="message_board"><?php echo $error; ?></div>
				<?php endif; ?>
					
				<div class="left_section">
					<fieldset class="divider"><legend>Please enter user information</legend></fieldset>
				
					<div class="stitle">* Mandatory Field</div>
					
					<form id="frm_upload_sale_batch" method="post" action="" enctype="multipart/form-data" data-parsley-validate>
						<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
		            
						<table width="100%">
							<tr>
								<td>
									<div class="form_label">Upload File*</div>
									<div>
										<input type="file" class="" id="sap_file" name="sap_file" accept=".csv|.xls" required />
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
					<fieldset class="divider"><legend>Please download the formatted file</legend></fieldset>
					<a href="<?php echo $this->webspice->get_path('custom'); ?>upload_sale_batch_format.xls">Download</a>
				</div>
				<div class="float_clear_full">&nbsp;</div>
				
				
			</div>

		</div>
		
		<div id="footer_container"><?php include(APPPATH."views/footer.php"); ?></div>
		
	</div>
</body>
</html>