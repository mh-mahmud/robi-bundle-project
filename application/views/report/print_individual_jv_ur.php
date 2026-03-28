<?php 
$url_prefix = $this->webspice->settings()->site_url_prefix;
$site_url = $this->webspice->settings()->site_url;
$domain_name = $this->webspice->settings()->domain_name;
$total_column = 4;
$report_name = 'Individual JV for Revenue Deferment';

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
			
			<?php
			$unique_bundle_id = $this->webspice->unique_multidim_array($get_sale, 'BUNDLE_ID');
			$bundle_mrp_arr = array();
			$bundle_type_arr = array();
			$bundle_interest_rate = array();
			$bundle_emi_month = array();
			$bundle_service_id = array();
			$bundle_actual_price = array();
			$emi_service_total = array();
			$bundle_actual_interest = array();
			foreach($unique_bundle_id as $bundleKey=>$bundleValue){
		    # get bundle info
		    $bundle_mrp = $this->customcache->bundle_maker($bundleValue,'MRP');
		    $bundle_type = $this->customcache->bundle_maker($bundleValue,'TYPE');
  			$interest_rate = $this->customcache->bundle_maker($bundleValue,'EMI_INTEREST');
  			$emi_month = $this->customcache->bundle_maker($bundleValue,'EMI_MONTH');
  			
		    $bundle_mrp_arr[$bundleValue] = $bundle_mrp;
		    $bundle_type_arr[$bundleValue] = $bundle_type;
  			$bundle_interest_rate[$bundleValue] = $interest_rate;
  			$bundle_emi_month[$bundleValue] = $emi_month;
	
				# get bundle actual price
				# get actual price and available service id based on selected bundle
		    $actual_price = 0;
		    foreach( $get_bundle_item as $itemKey=>$itemValue ){
		    	if( $itemValue->BUNDLE_ID == $bundleValue ){
			    	$temp_quantity = $itemValue->QUANTITY;
			    	if($bundle_type=='emi' && $itemValue->TYPE=='loop'){
			    		$temp_quantity = $itemValue->QUANTITY * $emi_month;
			    	}
			    	$actual_price += ($temp_quantity * $itemValue->UNIT_PRICE);
			    	
			    	$bundle_service_id[$bundleValue][] = $itemValue->SERVICE_ID;
			    }
		    }
		    $bundle_actual_price[$bundleValue] = $actual_price;

  			# bundle info for emi bundle (interest and total service value)
  			$actual_interest = 0;
  			if($bundle_type=='emi'){
					$emi_days = $emi_month * 30; # EMI month(s) converted into days
					$payment = $bundle_mrp * $emi_month;
					$rate_per_month = round($interest_rate / 12, 4);
					$rate_per_month = $rate_per_month /100;
					$present_value_factor = 100; # %
	
					# calculate interest
					for($i=1; $i<=$emi_month; $i++){
						$present_value_factor = $present_value_factor / (1+$rate_per_month);
						$present_value_factor = round($present_value_factor,2);
						$pv_amount = $bundle_mrp * $present_value_factor;
						$pv_amount = $pv_amount / 100;
						
						$interest = $bundle_mrp - $pv_amount;
						$actual_interest += $interest;
					}
					
					# calculate service total according to EMI month(s)
					foreach($get_bundle_item as $kEMIITEM=>$vEMIITEM){
						if( $vEMIITEM->BUNDLE_ID == $bundleValue ){
							$quantity = $vEMIITEM->QUANTITY;
							if($vEMIITEM->TYPE=='loop'){
								$quantity = $vEMIITEM->QUANTITY * $emi_month;
							}
							
							$value = $quantity * $vEMIITEM->UNIT_PRICE;
							$fv_allocation = ($value / $actual_price) * 100;
							$fv_allocation = round($fv_allocation,2);

							$present_value_factor = 100; # %
							$revenue = 0;
							for($i=1; $i<=$emi_month; $i++){
								$present_value_factor = $present_value_factor / (1+$rate_per_month);
								$present_value_factor = round($present_value_factor,2);
								$pv_amount = $bundle_mrp * $present_value_factor;
								$pv_amount = $pv_amount / 100;
							
								$temp_revenue = $pv_amount * $fv_allocation;
								$temp_revenue = $temp_revenue / 100;
								$revenue += $temp_revenue;
							}

							$emi_service_total[$bundleValue][$vEMIITEM->SERVICE_ID] = $revenue;
						}
					}
  			}
  			$bundle_actual_interest[$bundleValue] = $actual_interest;
  		}
  		

			$unearned_revenue = array();
			$grand_total_revenue = 0;
			foreach($get_service as $ks=>$vs){
				$unearned_value = 0;
				$service_interest = 0;
				$remaining_interest = 0;
				
				foreach($get_sale as $k=>$v){
					$bundle_id = $v->BUNDLE_ID;
					$bundle_type = $bundle_type_arr[$bundle_id];
					
					$sale_month = date("Y-m", strtotime($v->INVOICE_DATE));
					if( $sale_month != $report_month ){
						continue;
					}
					
					# verify that; the service is available or not into selected bundle
					if( in_array($vs->SERVICE_ID, $bundle_service_id[$bundle_id]) ){
						
						if( $bundle_type != 'emi' ){
							if($vs->TYPE == 'loop'){
								$calculate_day = $this->webspice->calculate_days_between_two_dates($v->INVOICE_DATE, $last_of_month);
								$temp_service_price = ($vs->QUANTITY * $vs->UNIT_PRICE);
								$temp_break_price = (($bundle_mrp_arr[$bundle_id]/$bundle_actual_price[$bundle_id])*$temp_service_price);
								$one_day_value = ($temp_break_price * $v->QUANTITY) / $vs->LOOP_DAYS;
								$remaining_days = 0;
								if($calculate_day < $vs->LOOP_DAYS){
									$remaining_days = $vs->LOOP_DAYS - $calculate_day;
									$unearned_value += $one_day_value * $remaining_days;
								}
							}
							
						}elseif( $bundle_type == 'emi' ){
							$emi_days = $bundle_emi_month[$bundle_id] * 30; # EMI month(s) converted into days

							$service_end_date = $this->webspice->addDate($v->INVOICE_DATE, $emi_days-1, 'days');
							$calculate_day = $this->webspice->calculate_days_between_two_dates($v->INVOICE_DATE, $last_of_month);
							$calculate_day_actual = $this->webspice->calculate_days_between_two_dates($v->INVOICE_DATE, $service_end_date);
							if($calculate_day < $calculate_day_actual){
								$remaining_days = $calculate_day_actual - $calculate_day;
								
								$one_day_value = $emi_service_total[$bundle_id][$vs->SERVICE_ID] / $emi_days; # one day's value
								#$one_day_value = ($one_day_value * $calculate_day) * $v->QUANTITY;
								
								$temp_interest = $bundle_actual_interest[$bundle_id] / $emi_days; # one day's value
								$temp_interest = ($temp_interest * $calculate_day) * $v->QUANTITY;
								$service_interest += $temp_interest;

								$remaining_interest += ($bundle_actual_interest[$bundle_id] * $v->QUANTITY) - $temp_interest;
								
								if( $vs->TYPE != 'once' ){
									$unearned_value += $one_day_value * $remaining_days;
								}
							
								
								
							}
						}
						
					} # end in_array
					
				} # end get_sale loop
				
				if( $vs->VAT_APPLICABLE=='yes' ){
					$net_price = $unearned_value/118.45*100;
					$temp_sd = ($net_price * $this->webspice->settings()->sd)/100;
					$temp_net_value_sd = $net_price + $temp_sd; # vat on net value + sd
					
					$temp_vat = ($temp_net_value_sd * $this->webspice->settings()->vat)/100;
					$unearned_value = $unearned_value - ($temp_sd+$temp_vat);
				}
				
				$unearned_revenue[$vs->SERVICE_ID] = $unearned_value;
				$grand_total_revenue += $unearned_value;
			}
			
			$grand_total_revenue += $remaining_interest;
			#dd($unearned_revenue);
			?>
			
			<table class="table" border="1" cellpadding="0" cellspacing="0" style="width:auto;" align="center">
				<tr bgcolor="#ddd">
					<th>GL Code</th>
					<th>Descriptions</th>
					<th class="text-center" align="center">Dr.</th>
					<th class="text-center" align="center">Cr.</th>
				</tr>
				
				<?php foreach($get_service as $ks1=>$vs1): ?>
				<tr>
					<td><?php echo $vs1->GL_CODE; ?></td>
					<td><?php echo $vs1->SERVICE_NAME; ?></td>
					<td class="text-center" align="center"><?php echo round($unearned_revenue[$vs1->SERVICE_ID],2); ?></td>
					<td class="text-center" align="center">&nbsp;</td>
				</tr>
				<?php endforeach; ?>
				
				<!--sd-->
				<tr>
					<td><?php echo $this->webspice->settings()->gl_sd; ?></td>
					<td>SD</td>
					<td class="text-center" align="center">0</td>
					<td class="text-center" align="center">&nbsp;</td>
				</tr>
				
				<!--vat-->
				<tr>
					<td><?php echo $this->webspice->settings()->gl_vat; ?></td>
					<td>VAT</td>
					<td class="text-center" align="center">0</td>
					<td class="text-center" align="center">&nbsp;</td>
				</tr>
				
				<!--interest-->
				<tr>
					<td><?php echo $this->webspice->settings()->gl_interest_income; ?></td>
					<td>Interest Income</td>
					<td class="text-center" align="center"><?php echo round($remaining_interest,2); ?></td>
					<td class="text-center" align="center">&nbsp;</td>
				</tr>
				
				<?php if($grand_total_revenue): ?>
				<tr>
					<td style="font-weight:bold;"><?php echo $this->webspice->settings()->gl_unearned_revenue; ?></td>
					<td style="font-weight:bold;">Unearned Revenue</td>
					<td style="font-weight:bold;" class="text-center" align="center">&nbsp;</td>
					<td style="font-weight:bold;" class="text-center" align="center"><?php echo round($grand_total_revenue,2); ?></td>
				</tr>
				<?php endif; ?>
				
				<?php if($grand_total_revenue): ?>
				<tr>
					<td style="font-weight:bold;">Total</td>
					<td>&nbsp;</td>
					<td class="text-center" align="center" style="font-weight:bold;"><?php echo $this->webspice->tk($grand_total_revenue); ?></td>
					<td class="text-center" align="center" style="font-weight:bold;"><?php echo $this->webspice->tk($grand_total_revenue); ?></td>
				</tr>
				<?php endif; ?>
				
			</table>
			
		</div>
	</body>
</html>