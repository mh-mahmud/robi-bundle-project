<div id="header_container">
	<div class="header_bg">
		<div class="my_container">
			<div class="left_part">
				<div class="caption fsecond">Bundle Products Revenue Calculation Tool</div>
			</div>
			
			<div class="right_part">
				<ul>
					<?php if( $this->webspice->get_user_id() ): ?>
					<li class="mnu"><a href="<?php echo $url_prefix; ?>logout">&nbsp;Logout</a></li>
					<li class="mnu"><a href="<?php echo $url_prefix; ?>user_guide" target="_blank">User Guide | </a></li>
					<?php else: ?>
					<li class="mnu"><a href="<?php echo $url_prefix; ?>login">Login</a></li>
					<?php endif; ?>
					<li class="float_clear_full">&nbsp;</li>
				</ul>
				
			</div>
			<div class="float_clear_full">&nbsp;</div>
		</div>
	</div><!--end .header_bg-->
	
	<div class="my_container" style="position:relative; z-index:9000; border:1px solid red; height:auto;">
		<div class="menu_panel">
			<ul class="sf-menu sf-arrows">
				<li class="br_7_left"><a href="<?php echo $url_prefix; ?>">Home</a></li>
				
					<?php
					# get distinct group name
					$get_permission_group = $this->db->query("
					SELECT GROUP_NAME 
					FROM TBL_BUNDLE_PERMISSION
					WHERE STATUS=1
					AND GROUP_NAME != 'dashboard' 
					GROUP BY GROUP_NAME 
					ORDER BY GROUP_NAME
					")->result();

					foreach($get_permission_group as $gk=>$gv){
						$get_permission = $this->db->query("
						SELECT * 
						FROM TBL_BUNDLE_PERMISSION 
						WHERE STATUS=1 
						AND GROUP_NAME='".$gv->GROUP_NAME."' 
						ORDER BY MENU_NAME
						")->result();
					
						# find out that; at least one permission has or not according to the group name
						$is_permitted = false;
						foreach($get_permission as $pk=>$pv){
							if( $this->webspice->permission_verify($pv->PERMISSION_NAME, true) ){
								$is_permitted = true; 
								break;
							}
						}
	
						# create main menu
						if( $is_permitted ){
							echo '<li>';
								echo '<a href="#" class="sf-with-ul">'.ucwords(str_replace("_"," ",$gv->GROUP_NAME)).'</a>';
								echo '<ul>';
								
							# generate sub menu
							$menu_name = null;
							foreach($get_permission as $pk1=>$pv1){
								if( $this->webspice->permission_verify($pv1->PERMISSION_NAME, true) && $pv1->MENU_NAME != $menu_name ){
									$menu_name = $pv1->MENU_NAME;
									
									echo '<li><a href="'.$url_prefix.$pv1->ROUTE_NAME.'">'.str_replace(array('Jv','Fv'),array('JV','FV'),ucwords(str_replace('_',' ',$pv1->MENU_NAME))).'</a></li>';
								}
							}
							
							# end main menu and sub menu
							echo '</ul></li>';
						}
	
					}
					?>
				
				<?php if( $this->webspice->get_user_id() ): ?>
				<li>
					<a href="#" class="sf-with-ul">My Account</a>
					<ul>
						<li><a href="<?php echo $url_prefix; ?>change_password/<?php echo $this->webspice->encrypt_decrypt( $this->webspice->get_user('USER_ID').'|'.date("Y-m-d"),'encrypt' ); ?>">Change Password</a></li>
					</ul>
				</li>
				<?php endif; ?>
				
			</ul>
			<div class="float_clear_full">&nbsp;</div>
		</div><!--end .menu_panel-->
		
		<?php if( $this->webspice->message_board(null, 'get') ): ?>
			<div id="message_board">
				<?php echo $this->webspice->message_board(null,'get_and_destroy'); ?>
			</div>
		<?php endif; ?>
		
	</div>
		
</div>