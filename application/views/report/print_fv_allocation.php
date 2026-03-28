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
					<th class="text-center" align="center">Measurement Unit</th>
					<th class="text-center" align="center">Bundle Offer</th>
					<th class="text-center" align="center">Per unit FV Tariff</th>
					<th class="text-center" align="center">FV</th>
					<th class="text-center" align="center">Break up</th>
					<th class="text-center" align="center">Break up %</th>
					<th class="text-center" align="center">Total</th>
				</tr>
				<?php  
				$total_fv = 0;
				$total_break_price = 0;
				$total_break_up_percent = 0;
				$grand_total = 0;
				?>
				<?php foreach($get_bundle_item as $k=>$v): ?>
				<tr>
					<td><?php echo ucwords(str_replace('','',$v->PRICE_TYPE)); ?></td>
					<td><?php echo $v->SERVICE_NAME; ?></td>
					<td class="text-center" align="center"><?php echo ucwords($v->UNIT); ?></td>
					<td class="text-center" align="center"><?php echo $v->QUANTITY; ?></td>
					<td class="text-center" align="center"><?php echo $v->UNIT_PRICE; ?></td>
					<td class="text-center" align="center">
						<?php 
						$temp_price = ($v->QUANTITY * $v->UNIT_PRICE);
						echo $this->webspice->tk(ceil($temp_price)); 
						?>
					</td>
					<td class="text-center" align="center">
						<?php 
						$temp_break_price = round((($bundle_mrp/$actual_price)*$temp_price),2);
						echo $temp_break_price; 
						?>
					</td>
					<td class="text-center" align="center"><?php $break_up_percent = ($temp_break_price/$break_up_total)*100; echo round($break_up_percent,2); ?>%</td>
					<td class="text-center" align="center"><?php $total = $temp_break_price; echo round($total); ?></td>
					<?php  
					$total_fv += $temp_price;
					$total_break_price += $temp_break_price;
					$total_break_up_percent += $break_up_percent;
					$grand_total += $total;
					?>
				</tr>
				<?php endforeach; ?>

				<tr>
					<th>Total</th>
					<th>&nbsp;</th>
					<th class="text-center" align="center">&nbsp;</th>
					<th class="text-center" align="center">&nbsp;</th>
					<th class="text-center" align="center">&nbsp;</th>
					<th class="text-center" align="center"><?php echo $this->webspice->tk(ceil($total_fv)); ?></th>
					<th class="text-center" align="center"><?php echo $this->webspice->tk(round($total_break_price)); ?></th>
					<th class="text-center" align="center"><?php echo round($total_break_up_percent); ?>%</th>
					<th class="text-center" align="center"><?php echo $this->webspice->tk(round($grand_total)); ?></th>
				</tr>
				
			</table>
			
		</div>
	</body>
</html>