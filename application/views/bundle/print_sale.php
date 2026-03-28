<?php 
$url_prefix = $this->webspice->settings()->site_url_prefix;
$site_url = $this->webspice->settings()->site_url;
$domain_name = $this->webspice->settings()->domain_name;
$total_column = 9;
$report_name = 'Bundle Sale Report';

# don't edit the below area (csv)
if( $this->uri->segment(2)=='csv' ){
	$file_name = strtolower(str_replace(array(' '),'_',$report_name)).'_'.date('Y_m_d_h_i').'.xls';
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=".$file_name);
	header("Pragma: no-cache");
	header("Expires: 0");
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $report_name; ?></title>

		<style type="text/css">
			#printArea { width:1024px; margin:auto; }
			body, table {font-family:tahoma; font-size:13px;}
			table td { padding:8px; }
		</style>
		
		<?php if( $this->uri->segment(2)=='print'): ?>
		<script type="text/javascript" src="<?php echo $url_prefix; ?>global/js/jquery-1.8.0.min.js"></script>
		
    <!-- Bootstrap -->
		<link rel="stylesheet" href="<?php echo $url_prefix; ?>global/bootstrap_3_2/css/bootstrap.min.css">
		<link rel="stylesheet" href="<?php echo $url_prefix; ?>global/bootstrap_3_2/css/bootstrap-theme.min.css">
		<script src="<?php echo $url_prefix; ?>global/bootstrap_3_2/js/bootstrap.min.js"></script>
    
		<!-- print plugin -->
		<script src="<?php echo $url_prefix; ?>global/js/jquery.jqprint.js"></script>
		
		<script type="text/javascript">
			$(document).ready(function(){
				$('#printArea').jqprint();
				$('#print_icon').click(function(){
					$('#printArea').jqprint();
				});
			});
		</script>
		<?php endif; ?>
  </head>
  
  <body>
		<!--<a id="print_icon" href="#">Print</a>-->
		
		<div id="printArea">
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td align="center" colspan="<?php echo $total_column; ?>">
						<div style="font-size:150%;"><?php echo $domain_name; ?></div>
					</td>
				</tr>
			</table>
			
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr style="border-top:1px solid #ccc;">
					<td colspan="<?php echo $total_column; ?>" align="center" style="font-size:17px; font-weight:bold; color:red; text-align:center; padding:0px;"><?php echo $report_name; ?></td>
				</tr>
				<tr>
					<td colspan="<?php echo $total_column; ?>" align="center" style="text-align:center; padding:0px;">Report Date: <?php echo date("d F, Y"); ?>&nbsp;|&nbsp;<?php echo $filter_by; ?></td>
				</tr>
				<tr><td>&nbsp;</td></tr>
			</table>
			
			<table class="table" width="100%" border="1" cellpadding="0" cellspacing="0">
				<tr>
					<th class="text-center" align="center">Bundle ID</th>
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
					<td class="text-center" align="center"><?php echo $v->BUNDLE_ID; ?></td>
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
		</div>
	</body>
</html>