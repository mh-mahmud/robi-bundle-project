<?php 
$url_prefix = $this->webspice->settings()->site_url_prefix;
$site_url = $this->webspice->settings()->site_url;
$domain_name = $this->webspice->settings()->domain_name;
$total_column = $month_count + 1;
$report_name = 'Deferred Revenue Recognition Summary JV';
ini_set('MAX_EXECUTION_TIME', 300);

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
		
		<div id="printArea" style="overflow:auto;">
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
			# grand total variable
			$individual_service_total = array();
			$grand_service = array();
			$grand_sd = array();
			$grand_vat = array();
			$grand_interest = array();
			
			$unique_bundle_id = $this->webspice->unique_multidim_array($get_bundle_result, 'BUNDLE_ID');
			
			$get_unique_service_id = $this->db->query("
			SELECT TBL_BUNDLE_ITEM.* 
			FROM TBL_BUNDLE_ITEM 
			WHERE TBL_BUNDLE_ITEM.BUNDLE_ID IN ( ".implode(',',$unique_bundle_id).") 
			AND TBL_BUNDLE_ITEM.TYPE = 'loop'
			AND TBL_BUNDLE_ITEM.SERVICE_ID IN(
				SELECT TBL_BUNDLE_ITEM.SERVICE_ID
				FROM TBL_BUNDLE_ITEM
				GROUP BY TBL_BUNDLE_ITEM.SERVICE_ID
			)
			")->result();
			?>
			
			<?php foreach($unique_bundle_id as $uniqueBundleKey => $uniqueBundleValue): ?>
			
				<?php
		    # get bundle info
		    $bundle_type = $this->customcache->bundle_maker($uniqueBundleValue,'TYPE');
		    $bundle_mrp = $this->customcache->bundle_maker($uniqueBundleValue,'MRP');
				$emi_month = $this->customcache->bundle_maker($uniqueBundleValue,'EMI_MONTH');
				$interest_rate = $this->customcache->bundle_maker($uniqueBundleValue,'EMI_INTEREST');
			
				# get bundle item - only loop item
		  	$sql_bundle_item = "
		  	SELECT TBL_BUNDLE_ITEM.*,
		  	TBL_BUNDLE_SERVICE.SERVICE_NAME, TBL_BUNDLE_SERVICE.PRICE_TYPE, TBL_BUNDLE_SERVICE.UNIT, TBL_BUNDLE_SERVICE.VAT_APPLICABLE
		  	FROM TBL_BUNDLE_ITEM
		  	LEFT JOIN TBL_BUNDLE_SERVICE ON TBL_BUNDLE_SERVICE.SERVICE_ID=TBL_BUNDLE_ITEM.SERVICE_ID
		  	WHERE TBL_BUNDLE_ITEM.BUNDLE_ID = ?
		  	";
		  	$get_bundle_item = $this->db->query($sql_bundle_item, array($uniqueBundleValue))->result();
		  	
		  	# get bundle actual price
		    # note: bundle MRP might be lower than actual price (it is an offer so far)
		    $actual_price = 0;
		    foreach( $get_bundle_item as $actualPriceKey => $actualPriceValue ){
		    	$temp_quantity = $actualPriceValue->QUANTITY;
		    	if($bundle_type=='emi' && $actualPriceValue->TYPE=='loop'){
		    		$temp_quantity = $actualPriceValue->QUANTITY * $emi_month;
		    	}
		    	
		    	$actual_price += ($temp_quantity * $actualPriceValue->UNIT_PRICE);
		    }
	  		
		    # get bundle sale
		    $sql_bundle_sale = "
		    SELECT TBL_BUNDLE_SALE.*
		    FROM TBL_BUNDLE_SALE
		    WHERE TBL_BUNDLE_SALE.BUNDLE_ID = ?
		    AND TBL_BUNDLE_SALE.STATUS = 7
		    ORDER BY TBL_BUNDLE_SALE.INVOICE_DATE
		    ";
		    $get_bundle_sale = $this->db->query($sql_bundle_sale, array($uniqueBundleValue))->result();
				?>
				
				<div class="text-center" style="display:none;"><h3><?php echo ucwords($this->customcache->bundle_maker($uniqueBundleValue,'MATERIAL_NAME')); ?></h3></div>
				
				<!--below script copied from print_fv_deferment and print_fv_deferment_emi-->
				<?php if( $bundle_type != 'emi' ): ?>
				<div style="overflow:auto; display:none;">
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
						$service_total = array();
						$sd_total = array();
						$vat_total = array();
						$grand_interest= array();
						?>
						<?php foreach($get_bundle_item as $k=>$v): ?>
							<?php if($v->TYPE == 'once'){ continue; } ?>
							
						<tr>
							<td style="vertical-align:middle;"><?php echo $v->SERVICE_NAME; ?></td>
							<?php
							$temp_year = $start_year;
							$temp_month = $start_month;
							
							$temp_service_price = ($v->QUANTITY * $v->UNIT_PRICE);
							$temp_break_price = (($bundle_mrp/$actual_price)*$temp_service_price);
							?>
							<?php 
							for($i=$start_month; $i<($start_month+$month_count); $i++){
								if($temp_month > 12){ 
									$temp_month = 1; $temp_year++; 
								}
								
								if( $temp_month < 10 ){
									$temp_month = '0'.(int)$temp_month;
								}
								
								$running_date = $temp_year.'-'.$temp_month;
								
								$first_of_month = $this->webspice->first_of_month($temp_year, $temp_month);
								$last_of_month = $this->webspice->last_of_month($temp_year, $temp_month);
								
								$temp_value = 0;
								$temp_sd = 0;
								$temp_vat = 0;
								$temp_day = 0; # must remove in production
								foreach($get_bundle_sale as $saleKey=>$saleValue){
									$calculate_day = 0;
									$service_price = 0;
									$current_date = date("Y-m", strtotime($saleValue->INVOICE_DATE));
									$service_end_date = $this->webspice->addDate($saleValue->INVOICE_DATE, $v->LOOP_DAYS-1, 'days'); 
			
									if($v->TYPE == 'loop'){
										if( $current_date == $running_date ){
											/*
											say an user buy an item at 17th day of the month
											so, the use will get service from 17th day to last of the month
											- calculate only those days value for this selected duration (month)
											*/
											
											/*
											$calculate_day = $this->webspice->calculate_days_between_two_dates($saleValue->INVOICE_DATE, $last_of_month);
											if( $v->LOOP_DAYS < $calculate_day ){
												$calculate_day = $v->LOOP_DAYS;
											}
									
											if( $last_of_month > $end_date ){
												$calculate_day = $this->webspice->calculate_days_between_two_dates($saleValue->INVOICE_DATE, $end_date);
											}
			
											$service_price = $temp_break_price * $saleValue->QUANTITY;
											$service_price = $service_price / $v->LOOP_DAYS; # one day's value
											$service_price = $service_price * $calculate_day;
											*/
											$service_price = 0;
											
										}else{
											$calculate_day = $this->webspice->calculate_days_between_two_dates($first_of_month, $last_of_month);
			
											if( $service_end_date <= $last_of_month ){
												$calculate_day = $this->webspice->calculate_days_between_two_dates($first_of_month, $service_end_date);
											}
								
											$service_price = $temp_break_price * $saleValue->QUANTITY;
											$service_price = $service_price / $v->LOOP_DAYS; # one day's value

											$service_price = $service_price * $calculate_day;
										}
										
									}elseif($v->TYPE == 'once' && $current_date == $running_date){
										# $service_price = $temp_break_price * $saleValue->QUANTITY;
										$service_price = 0;
									}
			
									if( date("Y-m-d",strtotime($last_of_month)) < date("Y-m-d", strtotime($saleValue->INVOICE_DATE)) || date("Y-m-d", strtotime($saleValue->INVOICE_DATE)) > date("Y-m-d", strtotime($end_date)) || date("Y-m-d", strtotime($service_end_date)) < date("Y-m-d", strtotime($running_date.'-01')) ){
										$service_price = 0;
									}
									
									if($service_price){
										# SD+VAT calculate
										switch($v->VAT_APPLICABLE){ 
											case 'yes':
												if( $current_date == $running_date ){
													$temp_service_total = $temp_break_price * $saleValue->QUANTITY;
													
													$net_price = $temp_service_total/118.45*100;
													$calculate_sd = ($net_price * $this->webspice->settings()->sd)/100;
													$temp_sd += $calculate_sd;
													$temp_net_value_sd = $net_price + $calculate_sd; # vat on net value + sd
													
													$temp_vat += ($temp_net_value_sd * $this->webspice->settings()->vat)/100;
												}
												
												$net_price = $service_price/118.45*100;
												$service_sd = ($net_price * $this->webspice->settings()->sd)/100;
												$temp_net_value_sd = $net_price + $service_sd; # vat on net value + sd
												
												$service_vat = ($temp_net_value_sd * $this->webspice->settings()->vat)/100;
												
												$temp_service_price = $service_price - ($service_sd+$service_vat);
												$temp_value += $temp_service_price;
												break;
												
											case 'no':
												$temp_value += $service_price;
												break;
										}# end switch
									}
									
								}# end foreach get_bundle_sale
								
								if( !isset($individual_service_total[$v->SERVICE_ID][$temp_year][$temp_month]) )	{ $individual_service_total[$v->SERVICE_ID][$temp_year][$temp_month] = 0; }
								if( !isset($service_total[$temp_year][$temp_month]) )	{ $service_total[$temp_year][$temp_month] = 0; }
								if( !isset($sd_total[$temp_year][$temp_month]) )			{ $sd_total[$temp_year][$temp_month] = 0; }
								if( !isset($vat_total[$temp_year][$temp_month]) )			{ $vat_total[$temp_year][$temp_month] = 0; }
								
								if($temp_value){
									#$temp_value = $temp_value - ($temp_sd+$temp_vat);
									$individual_service_total[$v->SERVICE_ID][$temp_year][$temp_month] += $temp_value;
									$service_total[$temp_year][$temp_month] += $temp_value;
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
						
						<!--service -> just for calculation-->
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

							if( !isset($grand_service[$temp_year][$temp_month]) ){ $grand_service[$temp_year][$temp_month] = 0; }
							$grand_service[$temp_year][$temp_month] += $service_total[$temp_year][$temp_month];
							
							$temp_month++;
						}
						?>
						
						<!--SD-->
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
									<?php
									if( !isset($grand_sd[$temp_year][$temp_month]) ){ $grand_sd[$temp_year][$temp_month] = 0; }
									
									$grand_sd[$temp_year][$temp_month] += $sd_total[$temp_year][$temp_month];
									if($sd_total[$temp_year][$temp_month]){echo round($sd_total[$temp_year][$temp_month],2);}
									?>
								</td>
								<?php $temp_month++; ?>
							<?php endfor; ?>
						</tr>
						
						<!--VAT-->
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
									<?php 
									if( !isset($grand_vat[$temp_year][$temp_month]) ){ $grand_vat[$temp_year][$temp_month] = 0; }
									
									$grand_vat[$temp_year][$temp_month] += $vat_total[$temp_year][$temp_month];
									if( $vat_total[$temp_year][$temp_month] ){echo round($vat_total[$temp_year][$temp_month],2);}
									?>
								</td>
								<?php $temp_month++; ?>
							<?php endfor; ?>
						</tr>
						
						<!--Total-->
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
								
								<td style="font-weight:bold;" align="center">
									<?php 
									$grand_total = $service_total[$temp_year][$temp_month] + $sd_total[$temp_year][$temp_month] + $vat_total[$temp_year][$temp_month];
									if($grand_total){echo $this->webspice->tk(round($grand_total, 2));}
									?>
								</td>
								
								<?php $temp_month++; ?>
							<?php endfor; ?>
						</tr>
						
					</table>
				</div>
				
				<?php else: /*for emi*/ ?>
				<div style="overflow:auto; display:none;">
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
							<?php if($v->TYPE == 'once'){ continue; } ?>
							
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
										
										/*
										$calculate_day = $this->webspice->calculate_days_between_two_dates($saleValue->INVOICE_DATE, $last_of_month);
										if( $service_end_date < $last_of_month ){
											$calculate_day = $this->webspice->calculate_days_between_two_dates($saleValue->INVOICE_DATE, $service_end_date);
										}
										*/
										$calculate_day = 0;
			
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
												if( $sale_month == $running_month ){
													$net_price = $service_total[$v->SERVICE_ID]/118.45*100;
													$calculate_sd = ($net_price * $this->webspice->settings()->sd)/100;
													$temp_sd += $calculate_sd;
													$temp_net_value_sd = $net_price + $calculate_sd; # vat on net value + sd
													
													$temp_vat += ($temp_net_value_sd * $this->webspice->settings()->vat)/100;
												}
												
												$net_price = $service_price/118.45*100;
												$service_sd = ($net_price * $this->webspice->settings()->sd)/100;
												$temp_net_value_sd = $net_price + $service_sd; # vat on net value + sd
												
												$service_vat = ($temp_net_value_sd * $this->webspice->settings()->vat)/100;
												
												$temp_service_price = $service_price - ($service_sd+$service_vat);
												$temp_value += $temp_service_price;
												break;
												
											case 'no':
												$temp_value += $service_price;
												break;
										} # end switch
									}
								}# end foreach get_bundle_sale
			
								# if there is no data found for calculation, create an offset for the month with value 0
								if( !isset($individual_service_total[$v->SERVICE_ID][$temp_year][$temp_month]) )	{ $individual_service_total[$v->SERVICE_ID][$temp_year][$temp_month] = 0; }
								if( !isset($service_total_without_vat[$temp_year][$temp_month]) )	{ $service_total_without_vat[$temp_year][$temp_month] = 0; }
								if( !isset($sd_total[$temp_year][$temp_month]) ) { $sd_total[$temp_year][$temp_month] = 0; }
								if( !isset($vat_total[$temp_year][$temp_month]) ) { $vat_total[$temp_year][$temp_month] = 0; }
								if( !isset($interest_total[$temp_year][$temp_month]) ) { $interest_total[$temp_year][$temp_month] = 0; }
							
								$interest_total[$temp_year][$temp_month] = $temp_interest; # interest included services
								if($temp_value){
									$individual_service_total[$v->SERVICE_ID][$temp_year][$temp_month] += $temp_value;
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
						
						<!--service -> just allow for calculation-->
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

							if( !isset($grand_service[$temp_year][$temp_month]) ){ $grand_service[$temp_year][$temp_month] = 0; }
							$grand_service[$temp_year][$temp_month] += $service_total_without_vat[$temp_year][$temp_month]; 

							$temp_month++;
						}
						?>
						
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
									<?php 
									if( !isset($grand_sd[$temp_year][$temp_month]) ){ $grand_sd[$temp_year][$temp_month] = 0; }
									$grand_sd[$temp_year][$temp_month] += $sd_total[$temp_year][$temp_month];
									
									if($sd_total[$temp_year][$temp_month]){echo round($sd_total[$temp_year][$temp_month],2);}
									?>
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
									<?php 
									if( !isset($grand_vat[$temp_year][$temp_month]) ){ $grand_vat[$temp_year][$temp_month] = 0; }
									$grand_vat[$temp_year][$temp_month] += $vat_total[$temp_year][$temp_month];
									
									if($vat_total[$temp_year][$temp_month]){echo round($vat_total[$temp_year][$temp_month],2);}
									?>
									</td>
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
		
									if($grand_total){echo round($grand_total, 2);}
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
									<?php 
									if( !isset($grand_interest[$temp_year][$temp_month]) ){ $grand_interest[$temp_year][$temp_month] = 0; }
									$grand_interest[$temp_year][$temp_month] += $interest_total[$temp_year][$temp_month];
									
									if($interest_total[$temp_year][$temp_month]){echo round($interest_total[$temp_year][$temp_month],2);}
									?>
								</th>
								<?php $temp_month++; ?>
							<?php endfor; ?>
						</tr>
						
						<!--grand total (with interest)-->
						<tr>
							<td style="vertical-align:middle; font-weight:bold;">GRAND TOTAL (BDT)</td>
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
									if($grand_total){echo $this->webspice->tk(round($grand_total, 2));}
									?>
								</td>
								
								<?php $temp_month++; ?>
							<?php endfor; ?>
						</tr>
						
					</table>
				</div>
				<?php endif; ?>

			<?php endforeach; # end unique_bundle_id foreach ?>
			
			<div style="overflow:auto;">
				<!--<div class="text-center"><h3>Grand Total Calculation</h3></div>-->
				<!--grand total-->
				<table class="table table-bordered table-striped" align="center" style="width:auto;">
					<tr>
						<th style="vertical-align:middle;" rowspan="2">GL Code</th>
						<th style="vertical-align:middle;" rowspan="2">Component</th>
						<?php 
						$temp_year = $start_year;
						$temp_month = $start_month;
						?>
						<?php for($i=$start_month; $i<($start_month+$month_count); $i++): ?>
							<?php if($temp_month > 12){ $temp_month = 1; $temp_year++; } ?>
							<th class="text-center" align="center" width="80" colspan="2"><?php echo $this->webspice->month_convert($temp_month); ?><br /><?php echo $temp_year; ?></th>
							<?php $temp_month++; ?>
						<?php endfor; ?>
					</tr>
					
					<tr>
						<td align="center">Dr.</td>
						<td align="center">Cr.</td>
					</tr>
					
					<!--grand total-->	
					<tr>
						<td style="vertical-align:middle; font-weight:bold;">&nbsp;</td>
						<td style="vertical-align:middle; font-weight:bold;">Deferred Revenue (BDT)</td>
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
							<td align="center" style="vertical-align:middle; font-weight:bold;">
								<?php 
								$grand_total_final= 0;
								if(!isset($grand_service[$temp_year][$temp_month])){$grand_service[$temp_year][$temp_month] = 0;}
								if(!isset($grand_sd[$temp_year][$temp_month])){$grand_sd[$temp_year][$temp_month] = 0;}
								if(!isset($grand_interest[$temp_year][$temp_month])){$grand_interest[$temp_year][$temp_month] = 0;}
					
								$grand_total_final = $grand_service[$temp_year][$temp_month] + $grand_sd[$temp_year][$temp_month] + $grand_vat[$temp_year][$temp_month] + $grand_interest[$temp_year][$temp_month];
								if( $grand_total_final ){ echo $this->webspice->tk(round($grand_total_final,2));}
								?>
							</td>
							<td>&nbsp;</td>
							
							<?php $temp_month++; ?>
						<?php endfor; ?>
					</tr>
					
					<!--service-->
					<?php foreach($get_unique_service_id as $serbiceKey=>$serviceValue): ?>
					<tr>
						<td style="vertical-align:middle;"><?php echo $this->customcache->service_maker($serviceValue->SERVICE_ID,'GL_CODE'); ?></td>
						<td style="vertical-align:middle;"><?php echo $this->customcache->service_maker($serviceValue->SERVICE_ID,'SERVICE_NAME'); ?></td>
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
							<td>&nbsp;</td>
							<td align="center">
								<?php
								if( isset($individual_service_total[$serviceValue->SERVICE_ID][$temp_year][$temp_month]) && $individual_service_total[$serviceValue->SERVICE_ID][$temp_year][$temp_month] ){
									echo round($individual_service_total[$serviceValue->SERVICE_ID][$temp_year][$temp_month],2);
								}
								?>
							</td>
							
							<?php $temp_month++; ?>
						<?php endfor; ?>
					</tr>
					<?php endforeach ?>
					
					<!--grand service-->
					<!--
					<tr>
						<td style="vertical-align:middle; font-weight:bold;">Total (BDT)</td>
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
							<td align="center" style="vertical-align:middle; font-weight:bold;">
								<?php if( $grand_service[$temp_year][$temp_month] ){echo $this->webspice->tk(round($grand_service[$temp_year][$temp_month],2));} ?>
								</th>
							<?php $temp_month++; ?>
						<?php endfor; ?>
					</tr>-->
					
					<!--grand sd-->	
					<tr>
						<td style="vertical-align:middle;"><?php echo $this->webspice->settings()->gl_sd; ?></td>
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
							<td>&nbsp;</td>
							<td align="center">0</td>
								
							<?php $temp_month++; ?>
						<?php endfor; ?>
					</tr>
					
					<!--grand vat-->	
					<tr>
						<td style="vertical-align:middle;"><?php echo $this->webspice->settings()->gl_vat; ?></td>
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
							<td>&nbsp;</td>
							<td align="center">0</td>
							
							<?php $temp_month++; ?>
						<?php endfor; ?>
					</tr>
					
					<!--grand interest-->	
					<tr>
						<td style="vertical-align:middle;"><?php echo $this->webspice->settings()->gl_interest_income; ?></td>
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
							<td>&nbsp;</td>
							<td align="center">
								<?php if( $grand_interest[$temp_year][$temp_month] ){ echo round($grand_interest[$temp_year][$temp_month],2);} ?>
							</td>
							
							<?php $temp_month++; ?>
						<?php endfor; ?>
					</tr>
					
					<!--grand total-->	
					<tr>
						<td>&nbsp;</td>
						<td style="vertical-align:middle; font-weight:bold;">Total (BDT)</td>
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
							<td align="center" style="vertical-align:middle; font-weight:bold;">
								<?php 
								$grand_total_final = $grand_service[$temp_year][$temp_month] + $grand_sd[$temp_year][$temp_month] + $grand_vat[$temp_year][$temp_month] + $grand_interest[$temp_year][$temp_month];
								if( $grand_total_final ){ echo $this->webspice->tk(round($grand_total_final,2));}
								?>
							</td>
							<td align="center" style="vertical-align:middle; font-weight:bold;">
								<?php 
								if( $grand_total_final ){ echo $this->webspice->tk(round($grand_total_final,2));}
								?>
							</td>
							
							<?php $temp_month++; ?>
						<?php endfor; ?>
					</tr>
					
				</table>
				
				
			</div>

		</div>
		
	</body>
</html>