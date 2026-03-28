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
					$service_total = array();
					$sd_total = array();
					$vat_total = array();
					?>
					<?php foreach($get_bundle_item as $k=>$v): ?>
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
									$service_price = $temp_break_price * $saleValue->QUANTITY;
								}
		
								if( date("Y-m-d",strtotime($last_of_month)) < date("Y-m-d", strtotime($saleValue->INVOICE_DATE)) || date("Y-m-d", strtotime($saleValue->INVOICE_DATE)) > date("Y-m-d", strtotime($end_date)) || date("Y-m-d", strtotime($service_end_date)) < date("Y-m-d", strtotime($running_date.'-01')) ){
									$service_price = 0;
								}
								
								if($service_price){
									# SD+VAT calculate
									switch($v->VAT_APPLICABLE){ 
										case 'yes':
										/*
											if( $current_date == $running_date ){
												$temp_service_total = $temp_break_price * $saleValue->QUANTITY;
												$calculate_sd = ($temp_service_total * $this->webspice->settings()->sd)/100;
												$temp_sd += $calculate_sd;
												$temp_net_value_sd = $temp_service_total + $calculate_sd; # vat on net value + sd
												$temp_vat += ($temp_net_value_sd * $this->webspice->settings()->vat)/100;
											}
											
											$service_sd = ($service_price * $this->webspice->settings()->sd)/100;
											$temp_net_service_sd = $service_price + $service_sd; # vat on net value + sd
											$service_vat = ($temp_net_service_sd * $this->webspice->settings()->vat)/100;
											
											$temp_service_price = $service_price - ($service_sd+$service_vat);
											$temp_value += $temp_service_price;
											break;
											*/
											$temp_value += $service_price;
											break;

										case 'no':
											$temp_value += $service_price;
											break;
									}# end switch
								}
								
							}# end foreach get_bundle_sale
		
							if( !isset($service_total[$temp_year][$temp_month]) )	{ $service_total[$temp_year][$temp_month] = 0; }
							if( !isset($sd_total[$temp_year][$temp_month]) )			{ $sd_total[$temp_year][$temp_month] = 0; }
							if( !isset($vat_total[$temp_year][$temp_month]) )			{ $vat_total[$temp_year][$temp_month] = 0; }
							
							if($temp_value){
								#$temp_value = $temp_value - ($temp_sd+$temp_vat);
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
					
					<tr>
						<th style="vertical-align:middle; font-weight:bold;">SD</th>
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
								if( $sd_total[$temp_year][$temp_month] ){ echo round($sd_total[$temp_year][$temp_month],2); } 
								?>
							</th>
							<?php $temp_month++; ?>
						<?php endfor; ?>
					</tr>
					
					<tr>
						<th style="vertical-align:middle; font-weight:bold;">VAT</th>
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
					
					<tr>
						<th style="vertical-align:middle; font-weight:bold;">TOTAL</th>
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
								if( $grand_total ){ echo $this->webspice->tk(round($grand_total, 2)); }
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