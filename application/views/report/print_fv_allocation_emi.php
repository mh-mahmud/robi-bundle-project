<?php 
$url_prefix = $this->webspice->settings()->site_url_prefix;
$site_url = $this->webspice->settings()->site_url;
$domain_name = $this->webspice->settings()->domain_name;
$total_column = 9;
$report_name = 'FV Allocation Report';

# don't edit the below area (csv)
if( $action_type=='csv' ){
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
		
		
		<script type="text/javascript" src="<?php echo $url_prefix; ?>global/js/jquery-1.8.0.min.js"></script>
		
    <!-- Bootstrap -->
		<link rel="stylesheet" href="<?php echo $url_prefix; ?>global/bootstrap_3_2/css/bootstrap.min.css">
		<link rel="stylesheet" href="<?php echo $url_prefix; ?>global/bootstrap_3_2/css/bootstrap-theme.min.css">
		<script src="<?php echo $url_prefix; ?>global/bootstrap_3_2/js/bootstrap.min.js"></script>
    
    <?php if( $action_type=='print'): ?>
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
			
			<div style="font-weight:bold; text-align:center;">Breakdown</div>
			<table class="table" width="100%" border="1" cellpadding="0" cellspacing="0">
				<tr>
					<th>Justification</th>
					<th>Bundle Components</th>
					<th class="text-center" align="center">Offer</th>
					<th class="text-center" align="center">Measurement Unit</th>
					<th class="text-center" align="center">Rate</th>
					<th class="text-center" align="center">Value</th>
					<th class="text-center" align="center">FV allocation</th>
				</tr>
				<?php  
				$total_value = 0;
				$total_fv_allocation = 0;
				?>
				<?php foreach($get_bundle_item as $k=>$v): ?>
				<tr>
					<td><?php echo ucwords(str_replace('','',$v->PRICE_TYPE)); ?></td>
					<td><?php echo $v->SERVICE_NAME; ?></td>
					<td class="text-center" align="center">
						<?php 
						$emi_month = $this->customcache->bundle_maker($v->BUNDLE_ID,'EMI_MONTH');
						$quantity = $v->QUANTITY;
						if($v->TYPE=='loop'){
							$quantity = $v->QUANTITY * $emi_month;
						}
						echo $quantity; 
						?>
					</td>
					<td class="text-center" align="center"><?php echo ucwords($v->UNIT); ?></td>
					<td class="text-center" align="center"><?php echo $v->UNIT_PRICE; ?></td>
					<td class="text-center" align="center">
						<?php
						$value = $quantity * $v->UNIT_PRICE;
						echo round($value,2);
						?>
					</td>
					<td class="text-center" align="center">
						<?php 
						$fv_allocation = ($value / $actual_price) * 100;
						echo round($fv_allocation,2).'%'; 
						?>
					</td>
					<?php  
					$total_value += $value;
					$total_fv_allocation += $fv_allocation;
					?>
				</tr>
				<?php endforeach; ?>

				<tr>
					<th>Total</th>
					<th>&nbsp;</th>
					<th class="text-center" align="center">&nbsp;</th>
					<th class="text-center" align="center">&nbsp;</th>
					<th class="text-center" align="center">&nbsp;</th>
					<th class="text-center" align="center"><?php echo $this->webspice->tk(round($total_value,2)); ?></th>
					<th class="text-center" align="center"><?php echo round($total_fv_allocation); ?>%</th>
				</tr>
				
			</table>
			
		</div>
	</body>
</html>