<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo $this->webspice->settings()->domain_name; ?>: Welcome</title>
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	
	<?php include("global.php"); ?>
</head>

<body>
	<div id="wrapper">
		<div id="header_container"><?php include("header.php"); ?></div>
		
		<div id="page_index" class="main_container page_identifier">
			<div class="page_caption">Welcome</div>
			<div class="page_body">
				<h4 class="text-success">Welcome to Bundle Products Revenue Calculation Tool</h4>
				<?php if($sale_summery_result): ?>
				<br />
				<h4>Bundle Sale Summary (BDT) - <?php echo $this->webspice->month_convert(date("m")).', '.date("Y"); ?></h4>
				<div class="table-responsive" style="overflow:auto;">
					<table class="table table-bordered table-striped">
						<tr>
							<th>Material Name</th>
							<th>&nbsp;</th>
							<?php
							for($j=1; $j <= date("d",strtotime($last_of_month)); $j++ ){
								echo '<th style="text-align:center;">Day '.$j.'</th>';
							}
							?>
							<th class="text-center" align="center">Total</th>
						</tr>
						<?php
						$get_unique_bundle_id = $this->webspice->unique_multidim_array($sale_summery_result, 'BUNDLE_ID');
						foreach($get_unique_bundle_id as $k=>$v){
							echo '<tr>';
							echo '<td>'.$this->customcache->bundle_maker($v,'MATERIAL_NAME').'</td>';
							echo '<td style="vertical-align:middle;"><table><tr><td>Qty.</td></tr><tr><td>Value</td></tr></table></td>';
							
							$total_quantity = 0;
							$total_value = 0;
							for($i=1; $i <= date("d",strtotime($last_of_month)); $i++ ){
								$value = null;
								$quantity = null;
								foreach($sale_summery_result as $k1=>$v1){
									if( $v1->BUNDLE_ID==$v && date("Y-m-d",strtotime($v1->INVOICE_DATE)) == date("Y-m-d", strtotime(date("Y-m-".$i))) ){
										$value = $v1->SUM_GROSS_VALUE;
										$quantity = $v1->SUM_QUANTITY;
										$total_quantity += $v1->SUM_QUANTITY;
										$total_value += $v1->SUM_GROSS_VALUE;
									}
								}
								
								echo '<td style="text-align:center; vertical-align:middle;">'.$quantity.'<br />'.$value.'</td>';
							}
							echo '<td style="text-align:center; vertical-align:middle;"><strong>'.$total_quantity.'<br />'.$this->webspice->tk($total_value).'</strong></td>';
							echo '</tr>';
						}
						?>
					</table>
				</div>
				<?php endif; ?>
				
				
				
				<?php if($sale_summery_result_gross_value): ?>
				<br />
				<h4>Bundle Sale Summary Gross Value (BDT) - <?php echo $this->webspice->month_convert(date("m")).', '.date("Y"); ?></h4>
				<div class="table-responsive" style="overflow:auto;">
					<table class="table table-bordered table-striped">
						<tr>
							<th>&nbsp;</th>
							<?php
							for($j=1; $j <= date("d",strtotime($last_of_month)); $j++ ){
								echo '<th style="text-align:center;">Day '.$j.'</th>';
							}
							?>
							<th class="text-center" align="center">Total</th>
						</tr>
						
						<?php
						$total_quantity = 0;
						echo '<tr>';
						echo '<td>Qty.</td>';
						for($i=1; $i <= date("d",strtotime($last_of_month)); $i++ ){
							$quantity = null;
							foreach($sale_summery_result_gross_value as $k1=>$v1){
								if( date("Y-m-d",strtotime($v1->INVOICE_DATE)) == date("Y-m-d", strtotime(date("Y-m-".$i))) ){
									$value = $v1->SUM_GROSS_QUANTITY;
									$total_quantity += $v1->SUM_GROSS_QUANTITY;
								}
							}
							
							echo '<td style="text-align:center; vertical-align:middle;">'.$value.'</td>';
						}
						echo '<td class="text-center" align="center"><strong>'.$total_quantity.'</strong></td>';
						echo '</tr>';
						
						$total_value = 0;
						echo '<tr>';
						echo '<td>Value</td>';
						for($i=1; $i <= date("d",strtotime($last_of_month)); $i++ ){
							$value = 0;
							foreach($sale_summery_result_gross_value as $k1=>$v1){
								if( date("Y-m-d",strtotime($v1->INVOICE_DATE)) == date("Y-m-d", strtotime(date("Y-m-".$i))) ){
									$value = $v1->SUM_GROSS_VALUE;
									$total_value += $v1->SUM_GROSS_VALUE;
								}
							}
							
							echo '<td style="text-align:center; vertical-align:middle;">'.$value.'</td>';
						}
						echo '<td class="text-center" align="center"><strong>'.$this->webspice->tk($total_value).'</strong></td>';
						echo '</tr>';
						?>
					</table>
				</div>
				
				<br /><br />
				<h4>Trend Analysis - <?php echo $this->webspice->month_convert(date("m")).', '.date("Y"); ?></h4>
        <div id="chart2" style="overflow:auto; min-height:250px;"></div>
				<?php endif; ?>
			</div><!--end .page_body-->

		</div>
		
		<div id="footer_container"><?php include("footer.php"); ?></div>
	</div>
	
<style type="text/css">
	.page_body { padding-bottom:50px !important; }
	.jqplot-target { overflow:visible !important; }
	.jqplot-axis { bottom:-8px !important; }
	.jqplot-xaxis-tick { z-index:10000; line-height:20px; }
</style>

<?php if($sale_summery_result_gross_value): ?>
  <script class="code" type="text/javascript">
  	$(document).ready(function(){
  		var ticks = [
							<?php
							for($j=1; $j <= date("d",strtotime($last_of_month)); $j++ ){
								echo $j.',';
							}
?>
			];
			var s1=[
							<?php
							for($j=1; $j <= date("d",strtotime($last_of_month)); $j++ ){
								$value = 0;
								foreach($sale_summery_result_gross_value as $k3=>$v3){
									if( date("Y-m-d",strtotime($v3->INVOICE_DATE)) == date("Y-m-d", strtotime(date("Y-m-".$j))) ){
										$value = $v3->SUM_GROSS_VALUE;
									}
								}
								echo $value.',';
							}
?>
			];
				
        plot2 = $.jqplot('chart2', [s1], {
            seriesDefaults: {
                renderer:$.jqplot.BarRenderer,
                pointLabels: { show: true }
            },
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: ticks
                }
            }
        });
    });</script>

<script type="text/javascript">
	$(document).ready(function(){
		$('.jqplot-xaxis-tick').append('<br /><span style="font-size:9px;">Day</span>');
	});
</script>
    
    <?php endif; ?>
</body>
</html>