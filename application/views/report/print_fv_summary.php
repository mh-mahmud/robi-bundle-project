<?php 
# prepare report data-->
$unique_bundle_id = $this->webspice->unique_multidim_array($get_bundle_item, 'BUNDLE_ID');
$unique_GL_CODE = $this->webspice->unique_multidim_array($get_bundle_item, 'GL_CODE');
			
$url_prefix = $this->webspice->settings()->site_url_prefix;
$site_url = $this->webspice->settings()->site_url;
$domain_name = $this->webspice->settings()->domain_name;
$total_column = count($unique_GL_CODE)+5;
$report_name = 'FV Allocation Summary Report';

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

			<table class="table table-bordered table-striped" border="1" align="center">
				<?php
				echo '<tr>';
					echo '<th style="vertical-align:middle;">Material Name</th>';
					foreach($unique_GL_CODE as $k=>$v){
						if($v==$this->webspice->settings()->gl_device){
							echo '<th align="center" class="text-center">Initial Rev - Hand Set<br />'.$this->webspice->settings()->gl_device.'</th>';
						}else{
							echo '<th align="center" class="text-center">'.$this->customcache->service_maker_by_gl_code($v,'SERVICE_NAME').'<br />'.$this->customcache->service_maker_by_gl_code($v,'GL_CODE').'</th>';
						}
					}
					#echo '<th align="center" class="text-center">Unearned Revenue<br />'.$this->webspice->settings()->gl_unearned_revenue.'</th>';
					echo '<th align="center" class="text-center">Supplementary Duty<br />'.$this->webspice->settings()->gl_sd.'</th>';
					echo '<th align="center" class="text-center">VAT<br />'.$this->webspice->settings()->gl_vat.'</th>';
					echo '<th align="center" class="text-center">Interest Income<br />'.$this->webspice->settings()->gl_interest_income.'</th>';
					echo '<th align="center" class="text-center">Bundle Total</th>';
				echo '</tr>';
				
				$grand_total_service_amount = array();
				$grand_total_unearned_amount = 0;
				$grand_total_sd_amount = 0;
				$grand_total_vat_amount = 0;
				$grand_total_interest_amount = 0;

				# get service info
		    $bundle_service_info = array();
				foreach($unique_GL_CODE as $k1=>$v1){
			    foreach( $get_bundle_item as $itemKey1=>$itemValue1 ){
						if( $itemValue1->GL_CODE == $v1 ){
			    		$bundle_service_info[$itemValue1->BUNDLE_ID][$itemValue1->GL_CODE]['QUANTITY'] = $itemValue1->QUANTITY;
			    		$bundle_service_info[$itemValue1->BUNDLE_ID][$itemValue1->GL_CODE]['UNIT_PRICE'] = $itemValue1->UNIT_PRICE;
			    		$bundle_service_info[$itemValue1->BUNDLE_ID][$itemValue1->GL_CODE]['LOOP_DAYS'] = $itemValue1->LOOP_DAYS;
			    		$bundle_service_info[$itemValue1->BUNDLE_ID][$itemValue1->GL_CODE]['TYPE'] = $itemValue1->TYPE;
			    		$bundle_service_info[$itemValue1->BUNDLE_ID][$itemValue1->GL_CODE]['VAT_APPLICABLE'] = $itemValue1->VAT_APPLICABLE;
			    	}
			    }
				}
		
				# calculate prices based on a specific bundle
				foreach($unique_bundle_id as $bundleKey=>$bundleValue){
			    # get bundle info
			    $bundle_mrp = $this->customcache->bundle_maker($bundleValue,'MRP');
			    $bundle_type = $this->customcache->bundle_maker($bundleValue,'TYPE');
    			$interest_rate = $this->customcache->bundle_maker($bundleValue,'EMI_INTEREST');
    			$emi_month = $this->customcache->bundle_maker($bundleValue,'EMI_MONTH');
    			
					# get bundle actual price
					# get actual price and available service id based on selected bundle
			    $actual_price = 0;
			    $bundle_GL_CODE = array();
			    foreach( $get_bundle_item as $itemKey=>$itemValue ){
			    	if( $itemValue->BUNDLE_ID == $bundleValue ){
				    	$temp_quantity = $itemValue->QUANTITY;
				    	if($bundle_type=='emi' && $itemValue->TYPE=='loop'){
				    		$temp_quantity = $itemValue->QUANTITY * $emi_month;
				    	}
				    	
				    	$actual_price += ($temp_quantity * $itemValue->UNIT_PRICE);
				    	
				    	$bundle_GL_CODE[] = $itemValue->GL_CODE;
				    }
			    }

    			# bundle info for emi bundle (interest and total service value)
    			$emi_service_total = array();
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
							#echo $interest.' - ';
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
	
								$emi_service_total[$vEMIITEM->GL_CODE] = $revenue;
							}
						}
    			}

					echo '<tr>';
						echo '<td>'.$this->customcache->bundle_maker($bundleValue,'MATERIAL_NAME').'</td>';

						$service_interest = 0;
						$remaining_interest = 0;
						$unearned_revenue = 0;
						$service_total_sd = 0;
						$service_total_vat = 0;
						$service_total_price = 0;
						foreach($unique_GL_CODE as $serviceKey=>$serviceValue){
							$service_price = 0;
							# overwrite the calculation in each service, so the value calculated once - no matter how much the service is available
							$service_interest = 0;
							$remaining_interest = 0;
							$temp_sd = 0; 
							$temp_vat = 0;
							$temp_value = 0;
							foreach($get_bundle_sale as $saleKey=>$saleValue){
								$temp_service_total_price = 0;
								
								# if matched bundle id and service id
								if( $saleValue->BUNDLE_ID == $bundleValue && in_array($serviceValue, $bundle_GL_CODE) ){
									$temp_service_info = $bundle_service_info[$saleValue->BUNDLE_ID][$serviceValue];
									$temp_service_price = 0;
									
									# verify bundle type
									if( $bundle_type != 'emi' ){
										$actual_service_price = $temp_service_info['QUANTITY'] * $temp_service_info['UNIT_PRICE'];
										$break_up_price = (($bundle_mrp/$actual_price)*$actual_service_price);
										
										$gross_sale_price = $saleValue->QUANTITY * $break_up_price; # gross sale price
										$temp_service_total_price = $gross_sale_price;
										
										$calculate_day = 0;
										if( $temp_service_info['TYPE'] == 'loop'){
											$per_day_price = $gross_sale_price / $temp_service_info['LOOP_DAYS'];
											# get service end date
											$service_end_date = $this->webspice->addDate($saleValue->INVOICE_DATE, $temp_service_info['LOOP_DAYS']-1, 'days');
											
											# calculate current month duration (service days in selected month)
											#$calculate_day = $this->webspice->calculate_days_between_two_dates($saleValue->INVOICE_DATE, $last_of_month);
											#if( $calculate_day > $temp_service_info['LOOP_DAYS'] ){
												$calculate_day = $this->webspice->calculate_days_between_two_dates($saleValue->INVOICE_DATE, $service_end_date);
											#}
											
											# calculate revenue
											$temp_service_price = ($per_day_price * $calculate_day);
											$service_price += $temp_service_price;
											
											/*
											if( $calculate_day < $temp_service_info['LOOP_DAYS'] ){
												$temp_unearned = $per_day_price * ($temp_service_info['LOOP_DAYS'] - $calculate_day);

												$temp_sd_on_unearned = ($temp_unearned * $this->webspice->settings()->sd)/100;
												$temp_net_unearned_sd = $temp_unearned + $temp_sd_on_unearned; # vat on net value + sd
												$temp_vat_on_unearned = ($temp_net_unearned_sd * $this->webspice->settings()->vat)/100;
												
												$temp_unearned = $temp_unearned - ($temp_sd_on_unearned+$temp_vat_on_unearned);
												$unearned_revenue += $temp_unearned;
											}*/
											# end revenue calculation
											
										}else{
											$temp_service_price = $gross_sale_price;
											$service_price += $gross_sale_price;
										}# end if type=loop
										
									}elseif($bundle_type=='emi'){
										$calculate_day = 0;
										$sale_month = date("Y-m", strtotime($saleValue->INVOICE_DATE));
										$service_end_date = $this->webspice->addDate($saleValue->INVOICE_DATE, $emi_days-1, 'days'); 
										
										$total_service_day = $this->webspice->calculate_days_between_two_dates($saleValue->INVOICE_DATE, $service_end_date);
										$day_from_sale_month = $this->webspice->calculate_days_between_two_dates($saleValue->INVOICE_DATE, $last_of_month);
										#$calculate_day = $day_from_sale_month;
										$calculate_day = $total_service_day;
										
										$temp_service_total_price = $emi_service_total[$serviceValue];
										
										if( $calculate_day ){
											$temp_service_price = $emi_service_total[$serviceValue] / $emi_days; # one day's value
											$temp_service_price = ($temp_service_price * $calculate_day) * $saleValue->QUANTITY;

											if( $temp_service_info['TYPE'] == 'once' ){
												$temp_service_price = $emi_service_total[$serviceValue] * $saleValue->QUANTITY;
											}
											
											$service_price += $temp_service_price;
											
											$temp_interest = $actual_interest / $emi_days; # one day's value
											$temp_interest = ($temp_interest * $calculate_day) * $saleValue->QUANTITY;
											$service_interest += $temp_interest;
											
											# unearned revenue
											/*
											if( $calculate_day < $total_service_day){
												$one_days_value = $emi_service_total[$serviceValue] / $emi_days; # one day's value
												#$temp_day_remaining = $total_service_day - $calculate_day;
												$remaining_interest += ($actual_interest * $saleValue->QUANTITY) - $temp_interest;
												
												if( $temp_service_info['TYPE'] != 'once' ){
													$temp_unearned = ($one_days_value * $temp_day_remaining) * $saleValue->QUANTITY;
													$temp_sd_on_unearned = ($temp_unearned * $this->webspice->settings()->sd)/100;
													$temp_net_unearned_sd = $temp_unearned + $temp_sd_on_unearned; # vat on net value + sd
													
													$temp_vat_on_unearned = ($temp_net_unearned_sd * $this->webspice->settings()->vat)/100;
													$temp_unearned = $temp_unearned - ($temp_sd_on_unearned+$temp_vat_on_unearned);
													
													$unearned_revenue += $temp_unearned;
												}
												
											}*/
											
										}
									} # end if $bundle_type
							
									# SD+VAT calculation
									if($temp_service_price){
										if( $temp_service_info['VAT_APPLICABLE'] == 'yes' ){
											$net_price = $temp_service_price/118.45*100;
											$service_sd = ($net_price * $this->webspice->settings()->sd)/100;
											$temp_net_service_sd = $net_price + $service_sd;
											
											$service_vat = ($temp_net_service_sd * $this->webspice->settings()->vat)/100;
											
											#$calculate_sd = ($temp_service_total_price * $this->webspice->settings()->sd)/100;
											#$temp_sd += $calculate_sd;
											#$temp_net_val_sd = $temp_service_total_price + $calculate_sd;
											#$temp_vat += ($temp_net_val_sd * $this->webspice->settings()->vat)/100;
											
											$temp_sd += $service_sd;
											$temp_vat += $service_vat;
											
											$temp_value += $temp_service_price - ($service_sd+$service_vat);
											
										}else{
											$temp_value += $temp_service_price;
										}
										
									}
								
								}
							}# end sale foreach
					
							if($service_price){
								#$temp_service_total = $service_price - ($temp_sd+$temp_vat);
								$service_total_price += $temp_value;
								$service_total_sd += $temp_sd;
								$service_total_vat += $temp_vat;
								
								if( !isset($grand_total_service_amount[$serviceValue]) ){
									$grand_total_service_amount[$serviceValue] = 0;
								}

								$grand_total_service_amount[$serviceValue] += $temp_value;
								
								echo '<td align="center" class="text-center" style="vertical-align:middle;">'.round($temp_value,2).'</td>';

							}else{
								echo '<td align="center" class="text-center">&nbsp;</td>';
							}
						}
						
						#$unearned_revenue += $remaining_interest;
						$grand_total_unearned_amount += $unearned_revenue;
						$grand_total_sd_amount += $service_total_sd;
						$grand_total_vat_amount += $service_total_vat;
						$grand_total_interest_amount += $service_interest;

						#echo '<td align="center" class="text-center" style="vertical-align:middle;">'.round($unearned_revenue,2).'</td>';
						echo '<td align="center" class="text-center" style="vertical-align:middle;">'.round($service_total_sd,2).'</td>';
						echo '<td align="center" class="text-center" style="vertical-align:middle;">'.round($service_total_vat,2).'</td>';
						echo '<td align="center" class="text-center" style="vertical-align:middle;">'.round($service_interest,2).'</td>';
						
						$bundle_total = $service_total_price + $service_total_sd + $service_total_vat + $unearned_revenue + $service_interest;
						echo '<td align="center" class="text-center" style="font-weight:bold; vertical-align:middle;">'.round($bundle_total,2).'</td>';
					echo '</tr>';
				}
	
				echo '<tr>';
					echo '<th style="vertical-align:middle;">TOTAL</th>';
					foreach($unique_GL_CODE as $k22=>$v22){
						echo '<th align="center" class="text-center">'.round($grand_total_service_amount[$v22],2).'</th>';
					}
					#echo '<th align="center" class="text-center">'.round($grand_total_unearned_amount,2).'</th>';
					echo '<th align="center" class="text-center">'.round($grand_total_sd_amount,2).'</th>';
					echo '<th align="center" class="text-center">'.round($grand_total_vat_amount,2).'</th>';
					echo '<th align="center" class="text-center">'.round($grand_total_interest_amount,2).'</th>';
					echo '<th align="center" class="text-center">&nbsp;</th>';
				echo '</tr>';
				?>
			</table>
			
		</div>
	</body>
</html>