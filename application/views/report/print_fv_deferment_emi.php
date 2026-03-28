<?php 
$url_prefix = $this->webspice->settings()->site_url_prefix;
$site_url = $this->webspice->settings()->site_url;
$domain_name = $this->webspice->settings()->domain_name;
$total_column = $month_count + 1;
$report_name = 'Revenue Deferment Report';

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

			<div style="overflow:auto;">
				<table class="table table-bordered table-striped" align="center" style="width:auto;">
					<tr>
						<th style="vertical-align:middle;">Component</th>
						<?php 
						$temp_year = $start_year;
						$temp_month = $start_month;
						?>
						<?php for($i=$start_month; $i<($start_month+$month_count); $i++): ?>
							<?php if($temp_month > 12){ $temp_month = 1; $temp_year++; } ?>
							<th class="text-center" align="center"><?php echo $this->webspice->month_convert($temp_month); ?><br /><?php echo $temp_year; ?></th>
							<?php $temp_month++; ?>
						<?php endfor; ?>
					</tr>
					
					<?php
					$emi_days = $emi_month * 30; # EMI month(s) converted into days
					$payment = $bundle_mrp * $emi_month;
					$rate_per_month = round($interest_rate / 12, 4);
					$rate_per_month = $rate_per_month /100;
					$present_value_factor = 100; # %
					
					# calculate interest
					$actual_interest = 0;	
					for($i=1; $i<=$emi_month; $i++){
						$present_value_factor = $present_value_factor / (1+$rate_per_month);
						$present_value_factor = round($present_value_factor,2);
						$pv_amount = $bundle_mrp * $present_value_factor;
						$pv_amount = $pv_amount / 100;
						
						$interest = $bundle_mrp - $pv_amount;
						$actual_interest += $interest;
						#echo $interest.' - ';
					}
					
					# calculate service total accordinf to EMI month(s)
					$service_total = array();
					foreach($get_bundle_item as $k1=>$v1){
						$quantity = $v1->QUANTITY;
						if($v1->TYPE=='loop'){
							$quantity = $v1->QUANTITY * $emi_month;
						}
						$value = $quantity * $v1->UNIT_PRICE;
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
						
						$service_total[$v1->SERVICE_ID] = $revenue;
					}
					#dd($service_total,'c');
					
					$service_total_without_vat = array();
					$sd_total = array();
					$vat_total = array();
					$interest_total = array();
					?>
					<?php foreach($get_bundle_item as $k=>$v): ?>
					<tr>
						<td style="vertical-align:middle;"><?php echo $v->SERVICE_NAME; ?></td>
						<?php 
						$temp_year = $start_year;
						$temp_month = $start_month;
		
						for($i=$start_month; $i<($start_month+$month_count); $i++){
							if($temp_month > 12){ 
								$temp_month = 1; $temp_year++; 
							}
							
							if( $temp_month < 10 ){
								$temp_month = '0'.(int)$temp_month;
							}
							
							# according to loop
							$running_month = $temp_year.'-'.$temp_month;
							$first_of_month = $this->webspice->first_of_month($temp_year, $temp_month);
							$last_of_month = $this->webspice->last_of_month($temp_year, $temp_month);
							
							$temp_value = 0;
							$temp_sd = 0;
							$temp_vat = 0;
							$temp_interest = 0;
							foreach($get_bundle_sale as $saleKey=>$saleValue){
								$calculate_day = 0;
								$service_price = 0;
								$sale_month = date("Y-m", strtotime($saleValue->INVOICE_DATE));
								$service_end_date = $this->webspice->addDate($saleValue->INVOICE_DATE, $emi_days-1, 'days'); 
								
								if( $sale_month == $running_month ){
									/*
									say an user buy an item at 17th day of the month
									so, the user will get service from 17th day to last of the month
									- calculate only those days value for this selected duration (month)
									*/
									$calculate_day = $this->webspice->calculate_days_between_two_dates($saleValue->INVOICE_DATE, $last_of_month);
									if( $service_end_date < $last_of_month ){
										$calculate_day = $this->webspice->calculate_days_between_two_dates($saleValue->INVOICE_DATE, $service_end_date);
									}
		
								}elseif( $running_month.'-01' > $saleValue->INVOICE_DATE && $first_of_month < $service_end_date ){
									$calculate_day = $this->webspice->calculate_days_between_two_dates($first_of_month, $last_of_month);
		
									if( $service_end_date < $last_of_month ){
										$calculate_day = $this->webspice->calculate_days_between_two_dates($first_of_month, $service_end_date);
									}
								}
								
								if( $calculate_day ){
									$service_price = $service_total[$v->SERVICE_ID] / $emi_days; # one day's value
									$service_interest = $actual_interest / $emi_days; # one day's value
		
									$service_price = ($service_price * $calculate_day) * $saleValue->QUANTITY;
									
									if( $v->TYPE == 'once' && $sale_month == $running_month ){
										$service_price = $service_total[$v->SERVICE_ID] * $saleValue->QUANTITY;
									}elseif( $v->TYPE == 'once' && $sale_month != $running_month ){
										$service_price = 0;
									}
									
									$temp_interest += ($service_interest * $calculate_day) * $saleValue->QUANTITY;
		
									switch($v->VAT_APPLICABLE){
										case 'yes':
										/*
											if( $sale_month == $running_month ){
												$calculate_sd = ($service_total[$v->SERVICE_ID] * $this->webspice->settings()->sd)/100;
												$temp_sd += $calculate_sd;
												$temp_net_value_sd = $service_total[$v->SERVICE_ID] + $calculate_sd; # vat on net value + sd
												
												$temp_vat += ($temp_net_value_sd * $this->webspice->settings()->vat)/100;
											}
											
											$service_sd = ($service_price * $this->webspice->settings()->sd)/100;
											$temp_net_value_sd = $service_price + $service_sd; # vat on net value + sd
											$service_vat = ($temp_net_value_sd * $this->webspice->settings()->vat)/100;
											
											$temp_service_price = $service_price - ($service_sd+$service_vat);
											$temp_value += $temp_service_price;
											break;
											*/
											$temp_value += $service_price;
											break;
											
										case 'no':
											$temp_value += $service_price;
											break;
									} # end switch
								}
							}# end foreach get_bundle_sale
		
							# if there is no data found for calculation, create an offset for the month with value 0
							if( !isset($service_total_without_vat[$temp_year][$temp_month]) )	{ $service_total_without_vat[$temp_year][$temp_month] = 0; }
							if( !isset($sd_total[$temp_year][$temp_month]) ) { $sd_total[$temp_year][$temp_month] = 0; }
							if( !isset($vat_total[$temp_year][$temp_month]) ) { $vat_total[$temp_year][$temp_month] = 0; }
							if( !isset($interest_total[$temp_year][$temp_month]) ) { $interest_total[$temp_year][$temp_month] = 0; }
						
							$interest_total[$temp_year][$temp_month] = $temp_interest; # interest included services
							if($temp_value){
								$service_total_without_vat[$temp_year][$temp_month] += $temp_value;
								$sd_total[$temp_year][$temp_month] += $temp_sd;
								$vat_total[$temp_year][$temp_month] += $temp_vat;
								
								echo '<td align="center">'.round($temp_value,2).'</td>';
							}else{
								echo '<td>&nbsp;</td>';
							}
		
							$temp_month++;
						}
						?>
					</tr>
					<?php endforeach; ?>
					
					<!--sd total-->
					<tr>
						<td style="vertical-align:middle;">SD</td>
						<?php 
						$temp_year = $start_year;
						$temp_month = $start_month;
						?>
						<?php for($i=$start_month; $i<($start_month+$month_count); $i++): ?>
							<?php 
							if($temp_month > 12){ 
								$temp_month = 1; $temp_year++; 
							} 
							if( $temp_month < 10 ){
								$temp_month = '0'.(int)$temp_month;
							}
							?>
							<td align="center">
								<?php if( $sd_total[$temp_year][$temp_month] ){ echo round($sd_total[$temp_year][$temp_month],2);} ?>
							</th>
							<?php $temp_month++; ?>
						<?php endfor; ?>
					</tr>
					
					<!--vat total-->
					<tr>
						<td style="vertical-align:middle;">VAT</td>
						<?php 
						$temp_year = $start_year;
						$temp_month = $start_month;
						?>
						<?php for($i=$start_month; $i<($start_month+$month_count); $i++): ?>
							<?php 
							if($temp_month > 12){ 
								$temp_month = 1; $temp_year++; 
							} 
							if( $temp_month < 10 ){
								$temp_month = '0'.(int)$temp_month;
							}
							?>
							<td align="center">
								<?php if( $vat_total[$temp_year][$temp_month] ){ echo round($vat_total[$temp_year][$temp_month],2);} ?>
							</th>
							<?php $temp_month++; ?>
						<?php endfor; ?>
					</tr>
					
					<!--grand total (without interest)-->
					<tr>
						<td style="vertical-align:middle; font-weight:bold;">TOTAL (BDT)</td>
						<?php 
						$temp_year = $start_year;
						$temp_month = $start_month;
						?>
						<?php for($i=$start_month; $i<($start_month+$month_count); $i++): ?>
							<?php 
							if($temp_month > 12){ 
								$temp_month = 1; $temp_year++; 
							} 
							if( $temp_month < 10 ){
								$temp_month = '0'.(int)$temp_month;
							}
							?>
							
							<td style="font-weight:bold; vertical-align:middle;" align="center">
								<?php 
								$grand_total = $service_total_without_vat[$temp_year][$temp_month] + $sd_total[$temp_year][$temp_month] + $vat_total[$temp_year][$temp_month];
								if( $grand_total ){ echo $this->webspice->tk(round($grand_total, 2)); }
								?>
							</td>
							
							<?php $temp_month++; ?>
						<?php endfor; ?>
					</tr>
					
					<!--interest total-->
					<tr>
						<td style="vertical-align:middle;">Interest</td>
						<?php 
						$temp_year = $start_year;
						$temp_month = $start_month;
						?>
						<?php for($i=$start_month; $i<($start_month+$month_count); $i++): ?>
							<?php 
							if($temp_month > 12){ 
								$temp_month = 1; $temp_year++; 
							} 
							if( $temp_month < 10 ){
								$temp_month = '0'.(int)$temp_month;
							}
							?>
							<td align="center">
								<?php if( $interest_total[$temp_year][$temp_month] ){ echo round($interest_total[$temp_year][$temp_month],2);} ?>
								</th>
							<?php $temp_month++; ?>
						<?php endfor; ?>
					</tr>
					
					<!--grand total (with interest)-->
					<tr>
						<th style="vertical-align:middle; font-weight:bold;">GRAND TOTAL (BDT)</th>
						<?php 
						$temp_year = $start_year;
						$temp_month = $start_month;
						?>
						<?php for($i=$start_month; $i<($start_month+$month_count); $i++): ?>
							<?php 
							if($temp_month > 12){ 
								$temp_month = 1; $temp_year++; 
							} 
							if( $temp_month < 10 ){
								$temp_month = '0'.(int)$temp_month;
							}
							?>
							
							<td style="font-weight:bold; vertical-align:middle;" align="center">
								<?php 
								$grand_total = $service_total_without_vat[$temp_year][$temp_month] + $sd_total[$temp_year][$temp_month] + $vat_total[$temp_year][$temp_month] + $interest_total[$temp_year][$temp_month];
								if( $grand_total ){ echo $this->webspice->tk(round($grand_total, 2)); }
								?>
							</td>
							
							<?php $temp_month++; ?>
						<?php endfor; ?>
					</tr>
					
				</table>
			</div>
		
		</div><!--end print area-->
			
	</body>
</html>