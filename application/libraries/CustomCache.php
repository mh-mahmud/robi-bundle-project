<?php
class CustomCache{
	
	# starts session
	function CustomCache(){
		if(!isset($_SESSION)){
			session_start();
		}
	}

	# get user information by user id
	function user_maker($user_id, $output_filed){
		# $output_filed - get db field name

		$CI =&get_instance();
		$cache_name = 'user_maker';
		
		# to delete cache use: $this->cache->remove_group('group_name');
		$CI->load->library('cache');
		
		$html = null;
		
		if( !$html = $CI->cache->get($cache_name, 'user') ){
			$html = array();
			
			$CI->load->database();
			$get_record = $CI->db->query("SELECT * FROM TBL_BUNDLE_USER ORDER BY USER_ID DESC");
			$get_record = $get_record->result();
			
			foreach( $get_record as $k=>$v ){
				$html[] = $v->USER_ID.'|'.$v->ROLE_ID.'|'.$v->USER_NAME.'|'.$v->USER_EMAIL.'|'.$v->USER_PHONE.'|'.$v->CREATED_DATE.'|'.
									$v->UPDATED_DATE.'|'.$v->STATUS;
			}

			$CI->cache->save($cache_name, $html, 'user', 604800);		
		}
		
		if( !$html ){ $html = array(); }
		
		foreach($html as $k=>$v){
			$Value = explode('|', $v);
			if( $Value[0]==$user_id ){
				switch($output_filed){
					case 'USER_ID': return $Value[0]; break;
					case 'ROLE_ID': return $Value[1]; break;
					case 'USER_NAME': return $Value[2]; break;
					case 'USER_EMAIL': return $Value[3]; break;
					case 'USER_PHONE': return $Value[4]; break;
					case 'USER_CREATED_DATE': return $Value[5]; break;
					case 'USER_UPDATED_DATE': return $Value[6]; break;
					case 'STATUS': return $Value[7]; break;
				}
				
			}

		}

		return false;
	}
	
	# get bundle information by bundle id
	function bundle_maker($key, $output_filed, $by_field = 'BUNDLE_ID'){
		# $output_filed - get db field name
		# key must be BUNDLE_ID
		# if $by_field=='MATERIAL_CODE' then $key can be MATERIAL_CODE

		$CI =&get_instance();
		$group_name = 'bundle';
		$cache_name = 'bundle_maker';
		
		# to delete cache use: $this->cache->remove_group('group_name');
		$CI->load->library('cache');
		
		$html = null;
		
		if( !$html = $CI->cache->get($cache_name, $group_name) ){
			$html = array();
			$CI->load->database();
			$get_record = $CI->db->query("SELECT * FROM TBL_BUNDLE ORDER BY BUNDLE_ID DESC");
			$get_record = $get_record->result();
			
			foreach( $get_record as $k=>$v ){
				$html[] = $v->BUNDLE_ID.'|'.$v->SUBSCRIBERS_BASE.'|'.$v->MATERIAL_CODE.'|'.$v->MATERIAL_NAME.'|'.
				$v->MRP.'|'.$v->DOWN_PAYMENT.'|'.$v->TYPE.'|'.$v->EMI_MONTH.'|'.$v->EMI_INTEREST.'|'.$v->CREATED_BY.'|'.$v->CREATED_DATE.'|'.$v->UPDATED_BY.'|'.
				$v->UPDATED_DATE.'|'.$v->STATUS;
			}

			$CI->cache->save($cache_name, $html, $group_name, 604800);		
		}
		
		if( !$html ){ $html = array(); }
	
		foreach($html as $k=>$v){
			$Value = explode('|', $v);
			$key_field = $Value[0]; # default $by_field;
			if( $by_field=='MATERIAL_CODE' ){ $key_field = $Value[2]; }
			
			if( $key_field == $key ){
				switch($output_filed){
					case 'BUNDLE_ID': return $Value[0]; break;
					case 'SUBSCRIBERS_BASE': return $Value[1]; break;
					case 'MATERIAL_CODE': return $Value[2]; break;
					case 'MATERIAL_NAME': return $Value[3]; break;
					case 'MRP': return $Value[4]; break;
					case 'DOWN_PAYMENT': return $Value[5]; break;
					case 'TYPE': return $Value[6]; break;
					case 'EMI_MONTH': return $Value[7]; break;
					case 'EMI_INTEREST': return $Value[8]; break;
					case 'CREATED_BY': return $Value[9]; break;
					case 'CREATED_DATE': return $Value[10]; break;
					case 'UPDATED_BY': return $Value[11]; break;
					case 'UPDATED_DATE': return $Value[12]; break;
					case 'STATUS': return $Value[13]; break;
				}
				
			}

		}

		return false;
	}
	
	# get service information by service id
	function service_maker($key, $output_filed){
		# $output_filed - get db field name
		# key must be SERVICE_ID

		$CI =&get_instance();
		$group_name = 'service';
		$cache_name = 'service_maker';
		
		# to delete cache use: $this->cache->remove_group('group_name');
		$CI->load->library('cache');
		
		$html = null;
		
		if( !$html = $CI->cache->get($cache_name, $group_name) ){
			$html = array();
			$CI->load->database();
			$get_record = $CI->db->query("SELECT * FROM TBL_BUNDLE_SERVICE WHERE STATUS=7 ORDER BY SERVICE_ID DESC");
			$get_record = $get_record->result();
			
			foreach( $get_record as $k=>$v ){
				$html[] = $v->SERVICE_ID.'|'.$v->SERVICE_NAME.'|'.$v->UNIT.'|'.$v->UNIT_PRICE.'|'.
				$v->PRICE_TYPE.'|'.$v->GL_CODE.'|'.$v->VAT_APPLICABLE.'|'.$v->CREATED_BY.'|'.$v->CREATED_DATE.'|'.$v->UPDATED_BY.'|'.$v->UPDATED_DATE.'|'.
				$v->STATUS;
			}

			$CI->cache->save($cache_name, $html, $group_name, 604800);		
		}
		
		if( !$html ){ $html = array(); }
	
		foreach($html as $k=>$v){
			$Value = explode('|', $v);
			$key_field = $Value[0]; # default

			if( $key_field == $key ){
				switch($output_filed){
					case 'SERVICE_ID': return $Value[0]; break;
					case 'SERVICE_NAME': return $Value[1]; break;
					case 'UNIT': return $Value[2]; break;
					case 'UNIT_PRICE': return $Value[3]; break;
					case 'PRICE_TYPE': return $Value[4]; break;
					case 'GL_CODE': return $Value[5]; break;
					case 'VAT_APPLICABLE': return $Value[6]; break;
					case 'CREATED_BY': return $Value[7]; break;
					case 'CREATED_DATE': return $Value[8]; break;
					case 'UPDATED_BY': return $Value[9]; break;
					case 'UPDATED_DATE': return $Value[10]; break;
					case 'STATUS': return $Value[11]; break;
				}
				
			}

		}

		return false;
	}
	
	# get service information by service id
	function service_maker_by_gl_code($key, $output_filed){
		# $output_filed - get db field name
		# key must be GL_CODE

		$CI =&get_instance();
		$group_name = 'service';
		$cache_name = 'service_maker';
		
		# to delete cache use: $this->cache->remove_group('group_name');
		$CI->load->library('cache');
		
		$html = null;
		
		if( !$html = $CI->cache->get($cache_name, $group_name) ){
			$html = array();
			$CI->load->database();
			$get_record = $CI->db->query("SELECT * FROM TBL_BUNDLE_SERVICE WHERE STATUS=7 ORDER BY SERVICE_ID DESC");
			$get_record = $get_record->result();
			
			foreach( $get_record as $k=>$v ){
				$html[] = $v->SERVICE_ID.'|'.$v->SERVICE_NAME.'|'.$v->UNIT.'|'.$v->UNIT_PRICE.'|'.
				$v->PRICE_TYPE.'|'.$v->GL_CODE.'|'.$v->VAT_APPLICABLE.'|'.$v->CREATED_BY.'|'.$v->CREATED_DATE.'|'.$v->UPDATED_BY.'|'.$v->UPDATED_DATE.'|'.
				$v->STATUS;
			}

			$CI->cache->save($cache_name, $html, $group_name, 604800);		
		}
		
		if( !$html ){ $html = array(); }
	
		foreach($html as $k=>$v){
			$Value = explode('|', $v);
			$key_field = $Value[5]; # default

			if( $key_field == $key ){
				switch($output_filed){
					case 'SERVICE_ID': return $Value[0]; break;
					case 'SERVICE_NAME': return $Value[1]; break;
					case 'UNIT': return $Value[2]; break;
					case 'UNIT_PRICE': return $Value[3]; break;
					case 'PRICE_TYPE': return $Value[4]; break;
					case 'GL_CODE': return $Value[5]; break;
					case 'VAT_APPLICABLE': return $Value[6]; break;
					case 'CREATED_BY': return $Value[7]; break;
					case 'CREATED_DATE': return $Value[8]; break;
					case 'UPDATED_BY': return $Value[9]; break;
					case 'UPDATED_DATE': return $Value[10]; break;
					case 'STATUS': return $Value[11]; break;
				}
				
			}

		}

		return false;
	}
	
	# get bundle information by bundle name from database
	function bundle_maker_by_name($key, $output_filed){
		# $output_filed - get db field name

		$CI =&get_instance();
		$group_name = 'bundle';
		$cache_name = 'bundle_maker_by_name';
		
		# to delete cache use: $this->cache->remove_group('group_name');
		$CI->load->library('cache');
		
		$html = null;
		
		if( !$html = $CI->cache->get($cache_name, $group_name) ){
			$html = array();
			$CI->load->database();
			$get_record = $CI->db->query("SELECT * FROM TBL_BUNDLE WHERE STATUS=2 ORDER BY BUNDLE_ID DESC");
			$get_record = $get_record->result();
			
			foreach( $get_record as $k=>$v ){
				$html[] = $v->BUNDLE_ID.'|'.$v->BUNDLE_NAME.'|'.$v->GL_CODE.'|'.$v->TYPE.'|'.$v->EMI_MONTH.'|'.$v->CREATED_BY.'|'.$v->CREATED_DATE.'|'.$v->UPDATED_BY.'|'.$v->UPDATED_DATE.'|'.$v->STATUS;
			}

			$CI->cache->save($cache_name, $html, $group_name, 604800);		
		}
		
		if( !$html ){ $html = array(); }
	
		foreach($html as $k=>$v){
			$Value = explode('|', $v);
			if( strtolower(trim($Value[1]))==strtolower(trim($key)) ){
				switch($output_filed){
					case 'BUNDLE_ID': return $Value[0]; break;
					case 'BUNDLE_NAME': return $Value[1]; break;
					case 'GL_CODE': return $Value[2]; break;
					case 'TYPE': return $Value[3]; break;
					case 'EMI_MONTH': return $Value[4]; break;
					case 'CREATED_BY': return $Value[5]; break;
					case 'CREATED_DATE': return $Value[6]; break;
					case 'UPDATED_BY': return $Value[7]; break;
					case 'UPDATED_DATE': return $Value[8]; break;
					case 'STATUS': return $Value[9]; break;
				}
				
			}

		}

		return false;
	}
	
	# get user role
	function get_user_role($type='option'){
		# type = option/option_mix/list
		$CI =&get_instance();
		$cache_name = 'user_role_option';
		
		# to delete cache use: $this->cache->remove_group('group_name');
		$CI->load->library('cache');
		$type == 'option_mix' ? $cache_name = 'user_role_option_mix' : $cache_name = $cache_name;
		$type == 'list' ? $cache_name = 'user_role_list' : $cache_name = $cache_name;
		
		if( !$data['html'] = $CI->cache->get($cache_name, 'user') ){
			$data['html'] = null;
			
			$CI->load->database();
			$get_record = $CI->db->query("SELECT * FROM TBL_BUNDLE_ROLE WHERE STATUS=7 ORDER BY ROLE_NAME");
			$get_record = $get_record->result();
		
			foreach( $get_record as $k=>$v ){
				switch($type){
					case 'option':
						$data['html'] .= '<option value="'.$v->ROLE_ID.'">'.ucwords($v->ROLE_NAME).'</option>';
						break;
					case 'option_mix':
						$data['html'] .= '<option value="'.$v->ROLE_ID.'|'.$v->ROLE_NAME.'">'.ucwords($v->ROLE_NAME).'</option>';
						break;
					case 'list':
						$data['html'] .= '<li class="list_item" data-id="'.$v->ROLE_ID.'">'.ucwords($v->ROLE_NAME).'</li>';
						break;
				}
			}
			
			$CI->cache->save($cache_name, $data['html'], 'user', 604800);		
		}
		return $data['html'];
	}
	
	# get unit name
	function get_unit($type='option'){
		# type = option/option_mix/list
		$CI =&get_instance();
		$temp_cache_name = 'unit';
		$group_name = 'option';
		
		# to delete cache use: $this->cache->remove_group('group_name');
		$CI->load->library('cache');
		switch($type){
			case 'option': $cache_name = $temp_cache_name.'_option'; break;
			case 'option_mix': $cache_name = $temp_cache_name.'_option_mix'; break;
			case 'option_name': $cache_name = $temp_cache_name.'_option_name'; break;
			case 'list': $cache_name = $temp_cache_name.'_list'; break;
			default: $cache_name = $temp_cache_name.'_option'; break;
		}
		
		if( !$data['html'] = $CI->cache->get($cache_name, $group_name) ){
			$data['html'] = null;
			
			$CI->load->database();
			$get_record = $CI->db->query("SELECT * FROM TBL_BUNDLE_OPTION WHERE STATUS=7 AND GROUP_NAME='unit_name' ORDER BY GROUP_NAME");
			$get_record = $get_record->result();

			foreach( $get_record as $k=>$v ){
				switch($type){
					case 'option':
						$data['html'] .= '<option value="'.$v->OPTION_ID.'">'.ucwords($v->OPTION_VALUE).'</option>';
						break;
					case 'option_mix':
						$data['html'] .= '<option value="'.$v->OPTION_ID.'|'.$v->ROLE_NAME.'">'.ucwords($v->OPTION_VALUE).'</option>';
						break;
					case 'option_name':
						$data['html'] .= '<option value="'.$v->OPTION_VALUE.'">'.ucwords($v->OPTION_VALUE).'</option>';
						break;
					case 'list':
						$data['html'] .= '<li class="list_item" data-id="'.$v->OPTION_ID.'">'.ucwords($v->OPTION_VALUE).'</li>';
						break;
				}
			}

			$CI->cache->save($cache_name, $data['html'], $group_name, 604800);		
		}
		
		return $data['html'];
	}
	
	# get bundle item
	function get_bundle($type='option'){
		# type = option/option_mix/list
		$CI =&get_instance();
		$temp_cache_name = 'bundle';
		$group_name = 'bundle';
		
		# to delete cache use: $this->cache->remove_group('group_name');
		$CI->load->library('cache');
		switch($type){
			case 'option': $cache_name = $temp_cache_name.'_option'; break;
			case 'option_mix': $cache_name = $temp_cache_name.'_option_mix'; break;
			case 'option_name': $cache_name = $temp_cache_name.'_option_name'; break;
			case 'list': $cache_name = $temp_cache_name.'_list'; break;
			default: $cache_name = $temp_cache_name.'_option'; break;
		}
		
		if( !$data['html'] = $CI->cache->get($cache_name, $group_name) ){
			$data['html'] = null;
			
			$CI->load->database();
			$get_record = $CI->db->query("SELECT * FROM TBL_BUNDLE WHERE STATUS=2 ORDER BY MATERIAL_NAME");
			$get_record = $get_record->result();

			foreach( $get_record as $k=>$v ){
				switch($type){
					case 'option':
						$data['html'] .= '<option value="'.$v->BUNDLE_ID.'">'.ucwords($v->MATERIAL_NAME).'</option>';
						break;
					case 'option_mix':
						$data['html'] .= '<option value="'.$v->BUNDLE_ID.'|'.$v->MATERIAL_NAME.'">'.ucwords($v->MATERIAL_NAME).'</option>';
						break;
					case 'option_name':
						$data['html'] .= '<option value="'.$v->MATERIAL_NAME.'">'.ucwords($v->MATERIAL_NAME).'</option>';
						break;
					case 'list':
						$data['html'] .= '<li class="list_item" data-id="'.$v->BUNDLE_ID.'">'.ucwords($v->MATERIAL_NAME).'</li>';
						break;
				}
			}

			$CI->cache->save($cache_name, $data['html'], $group_name, 604800);		
		}
		
		return $data['html'];
	}
	
	# get bundle item
	function get_bundle_item($type='option'){
		# type = option/option_mix/list
		$CI =&get_instance();
		$temp_cache_name = 'bundle_item';
		$group_name = 'service';
		
		# to delete cache use: $this->cache->remove_group('group_name');
		$CI->load->library('cache');
		switch($type){
			case 'option': $cache_name = $temp_cache_name.'_option'; break;
			case 'option_mix': $cache_name = $temp_cache_name.'_option_mix'; break;
			case 'list': $cache_name = $temp_cache_name.'_list'; break;
			default: $cache_name = $temp_cache_name.'_option'; break;
		}
		
		if( !$data['html'] = $CI->cache->get($cache_name, $group_name) ){
			$data['html'] = null;
			
			$CI->load->database();
			$get_record = $CI->db->query("
			SELECT TBL_BUNDLE_SERVICE.*
			FROM TBL_BUNDLE_SERVICE
			WHERE TBL_BUNDLE_SERVICE.STATUS=7 
			ORDER BY TBL_BUNDLE_SERVICE.SERVICE_NAME
			");
			$get_record = $get_record->result();
		
			foreach( $get_record as $k=>$v ){
				switch($type){
					case 'option':
						$data['html'] .= '<option value="'.$v->SERVICE_ID.'">'.ucwords($v->SERVICE_NAME).' ('.$v->UNIT.')</option>';
						break;
					case 'option_mix':
						$data['html'] .= '<option value="'.$v->SERVICE_ID.'|'.$v->SERVICE_NAME.'">'.ucwords($v->SERVICE_NAME).'</option>';
						break;
					case 'list':
						$data['html'] .= '<li class="list_item" data-id="'.$v->SERVICE_ID.'">'.ucwords($v->SERVICE_NAME).'</li>';
						break;
				}
			}

			$CI->cache->save($cache_name, $data['html'], $group_name, 604800);		
		}
		
		return $data['html'];
	}

}