<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bundle_controller extends CI_Controller {
	function __construct(){
		parent::__construct();
	}
	
	/*
	>> Error log should be added prefix Error:
	
	>> status
	1=Pending | 2=Approved | 3=Resolved | 4=Forwarded  | 5=Deployed  | 6=New  | 7=Active  | 
	8=Initiated  | 9=On Progress  | 10=Delivered  | -2=Declined | -3=Canceled | 
	-5=Taking out | -6=Renewed/Replaced | -7=Inactive
	*/
	
	
	function create_bundle($data=null){
		$url_prefix = $this->webspice->settings()->site_url_prefix;
		$this->webspice->user_verify($url_prefix.'login', $url_prefix.'create_bundle');
		$this->webspice->permission_verify('create_bundle,manage_bundle');
		
		if( !isset($data['edit']) ){
			$data['edit'] = array(
			'BUNDLE_ID'=>null
			);
		}
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('subscribers_base','subscribers_base','required|trim|xss_clean');
		$this->form_validation->set_rules('material_code','material_code','required|trim|xss_clean');
		$this->form_validation->set_rules('material_name','material_name','required|trim|xss_clean');
		
		$this->form_validation->set_rules('mrp','mrp','required|is_numeric|trim|xss_clean');
		$this->form_validation->set_rules('down_payment','down_payment','required|is_numeric|trim|xss_clean');
		$this->form_validation->set_rules('type','type','required|trim|xss_clean');
		$this->form_validation->set_rules('emi_month','emi_month','is_numeric|trim|xss_clean');
		$this->form_validation->set_rules('emi_interest','emi_interest','is_numeric|trim|xss_clean');
		
		# row 1
		$this->form_validation->set_rules('bundle_item_1','bundle_item_1','trim|xss_clean');
		$this->form_validation->set_rules('type_1','type_1','trim|xss_clean');
		$this->form_validation->set_rules('days_1','days_1','trim|is_numeric|xss_clean');
		$this->form_validation->set_rules('quantity_1','quantity_1','trim|is_numeric|xss_clean');
		
		# row 2
		$this->form_validation->set_rules('bundle_item_2','bundle_item_2','trim|xss_clean');
		$this->form_validation->set_rules('type_2','type_2','trim|xss_clean');
		$this->form_validation->set_rules('days_2','days_2','trim|is_numeric|xss_clean');
		$this->form_validation->set_rules('quantity_2','quantity_2','trim|is_numeric|xss_clean');
		
		# row 3
		$this->form_validation->set_rules('bundle_item_3','bundle_item_3','trim|xss_clean');
		$this->form_validation->set_rules('type_3','type_3','trim|xss_clean');
		$this->form_validation->set_rules('days_3','days_3','trim|is_numeric|xss_clean');
		$this->form_validation->set_rules('quantity_3','quantity_3','trim|is_numeric|xss_clean');
		
		# row 4
		$this->form_validation->set_rules('bundle_item_4','bundle_item_4','trim|xss_clean');
		$this->form_validation->set_rules('type_4','type_4','trim|xss_clean');
		$this->form_validation->set_rules('days_4','days_4','trim|is_numeric|xss_clean');
		$this->form_validation->set_rules('quantity_4','quantity_4','trim|is_numeric|xss_clean');
		
		# row 5
		$this->form_validation->set_rules('bundle_item_5','bundle_item_5','trim|xss_clean');
		$this->form_validation->set_rules('type_5','type_5','trim|xss_clean');
		$this->form_validation->set_rules('days_5','days_5','trim|is_numeric|xss_clean');
		$this->form_validation->set_rules('quantity_5','quantity_5','trim|is_numeric|xss_clean');
		
		# row 6
		$this->form_validation->set_rules('bundle_item_6','bundle_item_6','trim|xss_clean');
		$this->form_validation->set_rules('type_6','type_6','trim|xss_clean');
		$this->form_validation->set_rules('days_6','days_6','trim|is_numeric|xss_clean');
		$this->form_validation->set_rules('quantity_6','quantity_6','trim|is_numeric|xss_clean');
		
		# row 7
		$this->form_validation->set_rules('bundle_item_7','bundle_item_7','trim|xss_clean');
		$this->form_validation->set_rules('type_7','type_7','trim|xss_clean');
		$this->form_validation->set_rules('days_7','days_7','trim|is_numeric|xss_clean');
		$this->form_validation->set_rules('quantity_7','quantity_7','trim|is_numeric|xss_clean');


		if( !$this->form_validation->run() ){ 
			$this->load->view('bundle/create_bundle', $data);
			return FALSE;
		}
		
		# get input post
		$input = $this->webspice->get_input('key');

		#duplicate test
		$this->webspice->db_field_duplicate_test("SELECT * FROM TBL_BUNDLE WHERE MATERIAL_CODE=?", array($input->material_code), 'You are not allowed to enter duplicate material code', 'BUNDLE_ID', $input->key, $data, 'bundle/create_bundle');
		
		# remove cache
		$this->webspice->remove_cache('bundle');
		
		# insert data

		$this->db->trans_off();
		$this->db->trans_begin();
		
		$new_squence = $this->webspice->getLastInserted('TBL_BUNDLE','BUNDLE_ID');
		$sql_bundle_main = "
		INSERT INTO TBL_BUNDLE(
		BUNDLE_ID,SUBSCRIBERS_BASE,MATERIAL_CODE,MATERIAL_NAME,
		MRP,DOWN_PAYMENT,TYPE,EMI_MONTH,EMI_INTEREST, CREATED_BY,CREATED_DATE,STATUS)
		VALUES(SQ_BUNDLE.NEXTVAL,'".$input->subscribers_base."','".$input->material_code."','".$input->material_name.
		"',".(int)$input->mrp.",".(int)$input->down_payment.",'".$input->type."',".(int)$input->emi_month.",".(float)$input->emi_interest.",".$this->webspice->get_user_id().",TO_DATE('".$this->webspice->now()."','yyyy-mm-dd hh:mi:ss'),1)";
		
		$this->db->query($sql_bundle_main);

		$bundle_id = $this->webspice->getLastInserted('TBL_BUNDLE','BUNDLE_ID');
		$new_squence = $this->webspice->getLastInserted('TBL_BUNDLE_ITEM','ID');
		# prepare bundle item
		$temp_value = array();
		if( $input->bundle_item_1 && $input->type_1 && $input->quantity_1 ){
			$temp_value[] = "(".($new_squence+1).",".$bundle_id.",".$input->bundle_item_1.",'".$input->type_1."',".(int)$input->days_1.",".(int)$input->quantity_1.",".$this->customcache->service_maker($input->bundle_item_1,'UNIT_PRICE').",7)";
		}
		if( $input->bundle_item_2 && $input->type_2 && $input->quantity_2 ){
			$temp_value[] = "(".($new_squence+2).",".$bundle_id.",".$input->bundle_item_2.",'".$input->type_2."',".(int)$input->days_2.",".(int)$input->quantity_2.",".$this->customcache->service_maker($input->bundle_item_2,'UNIT_PRICE').",7)";
		}
		if( $input->bundle_item_3 && $input->type_3 && $input->quantity_3 ){
			$temp_value[] = "(".($new_squence+3).",".$bundle_id.",".$input->bundle_item_3.",'".$input->type_3."',".(int)$input->days_3.",".(int)$input->quantity_3.",".$this->customcache->service_maker($input->bundle_item_3,'UNIT_PRICE').",7)";
		}
		if( $input->bundle_item_4 && $input->type_4 && $input->quantity_4 ){
			$temp_value[] = "(".($new_squence+4).",".$bundle_id.",".$input->bundle_item_4.",'".$input->type_4."',".(int)$input->days_4.",".(int)$input->quantity_4.",".$this->customcache->service_maker($input->bundle_item_4,'UNIT_PRICE').",7)";
		}
		if( $input->bundle_item_5 && $input->type_5 && $input->quantity_5 ){
			$temp_value[] = "(".($new_squence+5).",".$bundle_id.",".$input->bundle_item_5.",'".$input->type_5."',".(int)$input->days_5.",".(int)$input->quantity_5.",".$this->customcache->service_maker($input->bundle_item_5,'UNIT_PRICE').",7)";
		}
		if( $input->bundle_item_6 && $input->type_6 && $input->quantity_6 ){
			$temp_value[] = "(".($new_squence+6).",".$bundle_id.",".$input->bundle_item_6.",'".$input->type_6."',".(int)$input->days_6.",".(int)$input->quantity_6.",".$this->customcache->service_maker($input->bundle_item_6,'UNIT_PRICE').",7)";
		}
		if( $input->bundle_item_7 && $input->type_7 && $input->quantity_7 ){
			$temp_value[] = "(".($new_squence+7).",".$bundle_id.",".$input->bundle_item_7.",'".$input->type_7."',".(int)$input->days_7.",".(int)$input->quantity_7.",".$this->customcache->service_maker($input->bundle_item_7,'UNIT_PRICE').",7)";
		}
		
		if( !$temp_value ){
			$this->db->trans_rollback();
			$this->webspice->message_board('We could not execute your request. Please try again with correct information.');
			$this->webspice->force_redirect($url_prefix);
			return false;
		}
		$new_squence = $this->webspice->getLastInserted('TBL_BUNDLE_ITEM','ID');
		if($temp_value){
			foreach($temp_value as $keyIndex=>$queryValues){
				$sql_bundle_item = "INSERT INTO TBL_BUNDLE_ITEM(ID,BUNDLE_ID,SERVICE_ID,TYPE,LOOP_DAYS,QUANTITY,UNIT_PRICE,STATUS)
				VALUES ".$queryValues."
				";
				$this->db->query($sql_bundle_item);
			}	
		}

		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$this->webspice->message_board('We could not execute your request. Please try again or report to authority.');
			$this->webspice->force_redirect($url_prefix);
			return false;
			
		}else{
			$this->db->trans_commit();
		}
		$this->db->trans_off();

		$this->webspice->message_board('Record has been inserted successfully.');
		if( $this->webspice->permission_verify('manage_bundle', true) ){
			$this->webspice->force_redirect($url_prefix.'manage_bundle');
		}

		$this->webspice->force_redirect($url_prefix);
	}
	
	function manage_bundle(){
		$url_prefix = $this->webspice->settings()->site_url_prefix;
		
		$this->webspice->user_verify($url_prefix.'login', $url_prefix.'manage_bundle');
		$this->webspice->permission_verify('manage_bundle,approve_bundle');

		$this->load->database();
    $orderby = null;
    $groupby = null;
    $where = ' WHERE ROWNUM <= 50';
    $page_index = 0;
    $no_of_record = 30;
    $limit = null;
    $filter_by = 'Last Created';
    $data['pager'] = null;
    $criteria = $this->uri->segment(2);
    $key = $this->uri->segment(3);
    if ($criteria == 'page') {
    	$page_index = (int)$key; 
    	$page_index < 0 ? $page_index=0 : $page_index=$page_index;
    }

		$initialSQL = "
		SELECT VIEW_BUNDLE.*
		FROM VIEW_BUNDLE
		";
    
   	# filtering records
    if( $this->input->post('filter') ){
			$result = $this->webspice->filter_generator(
			$TableName = 'VIEW_BUNDLE', 
			$InputField = array('SUBSCRIBERS_BASE'), 
			$Keyword = array('MATERIAL_CODE','MATERIAL_NAME','TYPE','MRP'),
			$AdditionalWhere = null,
			$DateBetween = array()
			);

			$result['where'] ? $where = $result['where'] : $where=$where;
			$result['filter'] ? $filter_by = $result['filter'] : $filter_by=$filter_by;
   	}

    # action area
    switch ($criteria) {
      case 'print':
      case 'csv':
        if( !isset($_SESSION['sql_bundle']) || !$_SESSION['sql_bundle'] ){
					$_SESSION['sql_bundle'] = $initialSQL . $where . $orderby;
					$_SESSION['filter_by'] = $filter_by;
    		}
    		
    		$record = $this->db->query( $_SESSION['sql_bundle'] );										 		
				$data['get_record'] = $record->result();
				$data['filter_by'] = $_SESSION['filter_by'];

				$this->load->view('bundle/print_bundle',$data);
				return false;
        break;
          
 			case 'approve':
      		$this->webspice->action_executer($TableName='TBL_BUNDLE', $KeyField='BUNDLE_ID', $key, $RedirectURL='manage_bundle', $PermissionName='manage_bundle', $StatusCheck=1, $ChangeStatus=2, $RemoveCache='bundle', $Log='approve_bundle');
					return false;	
          break;

			case 'remove':
					# delete permanently bundle and bundle item related information
					$this->db->trans_off();
					$this->db->trans_begin();
					
					$key = $this->webspice->encrypt_decrypt($key, 'decrypt');
					
					$delete_sql = "DELETE FROM TBL_BUNDLE WHERE BUNDLE_ID = ? AND ROWNUM = 1";
					$this->db->query($delete_sql, $key);
					
					$delete_sql = "DELETE FROM TBL_BUNDLE_ITEM WHERE BUNDLE_ID = ? ";
					$this->db->query($delete_sql, $key);
					
					if ($this->db->trans_status() === FALSE){
						$this->db->trans_rollback();
						$this->webspice->message_board('We could not execute your request. Please try again or report to authority.');
						$this->webspice->force_redirect($url_prefix);
						return FALSE;
						
					}else{
						$this->db->trans_commit();
					}
					$this->db->trans_off();
					
					# remove cache
					$this->webspice->remove_cache('bundle');
					
					$this->webspice->force_redirect($url_prefix.'manage_bundle');
					return false;
			    break;         
    }
    
    # default
    $sql = $initialSQL . $where . $groupby . $orderby . $limit;

    # only for pager
/*    if( $criteria == 'page' ){
    	if( !isset($_SESSION['sql_bundle']) || !$_SESSION['sql_bundle'] ){
    		$sql = substr($sql, 0, strpos($sql,'LIMIT'));
    	}else{
    		$sql = substr($_SESSION['sql_bundle'], 0, strpos($_SESSION['sql_bundle'],'LIMIT'));
    	}
    	
    	$limit = sprintf("LIMIT %d, %d", $page_index, $no_of_record);		# this is to avoid SQL Injection
    	$sql = $sql . $limit;
    }*/
    
		# load all records
/*		if( !$this->input->post('filter') ){
			$count_data = $this->db->query( substr($sql,0,strpos($sql,'LIMIT')) );
			$count_data = $count_data->result();
			$data['pager'] = $this->webspice->pager( count($count_data), $no_of_record, $page_index, $url_prefix.'manage_bundle/page/', 10 );
		}*/
    
    $_SESSION['sql_bundle'] = $sql;
    $_SESSION['filter_by'] = $filter_by;
    $result = $this->db->query($sql)->result();
  	
		$data['get_record'] = $result;
		$data['filter_by'] = $filter_by;

		$this->load->view('bundle/manage_bundle', $data);
	}
	
	function details_bundle(){
		$url_prefix = $this->webspice->settings()->site_url_prefix;
		
		$this->webspice->user_verify($url_prefix.'login', $url_prefix.'manage_bundle');
		$this->webspice->permission_verify('manage_bundle,approve_bundle');

		$this->load->database();
    $orderby = null;
    $groupby = null;
    $where = ' WHERE ROWNUM <= 50';
    $page_index = 0;
    $no_of_record = 20;
    $limit = null;
    $filter_by = 'Last Created';
    $data['pager'] = null;
    $criteria = $this->uri->segment(2);
    $key = $this->webspice->encrypt_decrypt($this->uri->segment(3),'decrypt');
    if ($criteria == 'page') {
    	$page_index = (int)$key; 
    	$page_index < 0 ? $page_index=0 : $page_index=$page_index;
    }

		$initialSQL = "
		SELECT TBL_BUNDLE_ITEM.*,
		TBL_BUNDLE.SUBSCRIBERS_BASE, TBL_BUNDLE.MATERIAL_CODE, TBL_BUNDLE.MATERIAL_NAME, TBL_BUNDLE.TYPE as BUNDLE_TYPE, 
		TBL_BUNDLE.CREATED_BY as BUNDLE_CREATED_BY, TBL_BUNDLE.CREATED_DATE as BUNDLE_CREATED_DATE, 
		TBL_BUNDLE.UPDATED_BY as BUNDLE_UPDATED_BY, TBL_BUNDLE.UPDATED_DATE as BUNDLE_UPDATED_DATE,
		TBL_BUNDLE_SERVICE.*
		FROM TBL_BUNDLE_ITEM
		LEFT JOIN TBL_BUNDLE ON TBL_BUNDLE.BUNDLE_ID=TBL_BUNDLE_ITEM.BUNDLE_ID
		LEFT JOIN TBL_BUNDLE_SERVICE ON TBL_BUNDLE_SERVICE.SERVICE_ID=TBL_BUNDLE_ITEM.SERVICE_ID
		";
		
		$where = 'WHERE TBL_BUNDLE_ITEM.BUNDLE_ID='.$key;

    # action area
    switch ($criteria) {
      case 'print':
      case 'csv':
        if( !isset($_SESSION['sql_bundle_details']) || !$_SESSION['sql_bundle_details'] ){
					$_SESSION['sql_bundle_details'] = $initialSQL . $where . $orderby;
					$_SESSION['filter_by'] = $filter_by;
    		}
    		
    		$record = $this->db->query( $_SESSION['sql_bundle_details'] );										 		
				$data['get_record'] = $record->result();
				$data['filter_by'] = $_SESSION['filter_by'];
			
				$this->load->view('bundle/print_bundle_details',$data);
				return false;
        break;
    }
    
    # default
    $sql = $initialSQL . $where . $groupby . $orderby . $limit;
   
    $result = $this->db->query($sql)->result();

		$data['get_record'] = $result;
		if( $data['get_record'] ){
			$bundle_info = $data['get_record'][0];
			$filter_by = 'Subscribers Base: '.ucwords(str_replace('_',' ',$bundle_info->SUBSCRIBERS_BASE)).' &raquo; Material Code: '.$bundle_info->MATERIAL_CODE.' &raquo; Material Name: '.ucwords(str_replace('_',' ',$bundle_info->MATERIAL_NAME)).' &raquo; Type: '.ucwords(str_replace('_',' ',$bundle_info->BUNDLE_TYPE));
			$filter_by .= '<br />Created By: '.$this->customcache->user_maker($bundle_info->BUNDLE_CREATED_BY,'USER_NAME').' &raquo; Created Date: '.$this->webspice->formatted_date($bundle_info->BUNDLE_CREATED_DATE);
			$filter_by .= ' &raquo; Approved By: '.$this->customcache->user_maker($bundle_info->BUNDLE_UPDATED_BY,'USER_NAME').' &raquo; Approved Date: '.$this->webspice->formatted_date($bundle_info->BUNDLE_UPDATED_DATE);
		}
		
    $_SESSION['sql_bundle_details'] = $sql;
    $_SESSION['filter_by'] = $filter_by;
    $data['filter_by'] = $filter_by;

		$this->load->view('bundle/bundle_details', $data);
	}
	
	function create_bundle_forecast($data=null){
		$url_prefix = $this->webspice->settings()->site_url_prefix;

		$this->webspice->user_verify($url_prefix.'login', $url_prefix.'create_bundle_forecast');
		$this->webspice->permission_verify('create_bundle_forecast,manage_bundle_forecast');
		
		if( !isset($data['edit']) ){
			$data['edit'] = array(
			'BUNDLE_ID'=>null
			);
		}
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('subscribers_base','subscribers_base','required|trim|xss_clean');
		$this->form_validation->set_rules('material_code','material_code','required|trim|xss_clean');
		$this->form_validation->set_rules('material_name','material_name','required|trim|xss_clean');
		
		$this->form_validation->set_rules('mrp','mrp','required|is_numeric|trim|xss_clean');
		$this->form_validation->set_rules('type','type','required|trim|xss_clean');
		$this->form_validation->set_rules('emi_month','emi_month','is_numeric|trim|xss_clean');
		$this->form_validation->set_rules('emi_interest','emi_interest','is_numeric|trim|xss_clean');
		
		$this->form_validation->set_rules('sale_date','sale_date','required|trim|xss_clean');
		$this->form_validation->set_rules('sale_quantity','sale_quantity','required|is_numeric|trim|xss_clean');
		
		# row 1
		$this->form_validation->set_rules('bundle_item_1','bundle_item_1','trim|xss_clean');
		$this->form_validation->set_rules('type_1','type_1','trim|xss_clean');
		$this->form_validation->set_rules('days_1','days_1','trim|is_numeric|xss_clean');
		$this->form_validation->set_rules('quantity_1','quantity_1','trim|is_numeric|xss_clean');
		
		# row 2
		$this->form_validation->set_rules('bundle_item_2','bundle_item_2','trim|xss_clean');
		$this->form_validation->set_rules('type_2','type_2','trim|xss_clean');
		$this->form_validation->set_rules('days_2','days_2','trim|is_numeric|xss_clean');
		$this->form_validation->set_rules('quantity_2','quantity_2','trim|is_numeric|xss_clean');
		
		# row 3
		$this->form_validation->set_rules('bundle_item_3','bundle_item_3','trim|xss_clean');
		$this->form_validation->set_rules('type_3','type_3','trim|xss_clean');
		$this->form_validation->set_rules('days_3','days_3','trim|is_numeric|xss_clean');
		$this->form_validation->set_rules('quantity_3','quantity_3','trim|is_numeric|xss_clean');
		
		# row 4
		$this->form_validation->set_rules('bundle_item_4','bundle_item_4','trim|xss_clean');
		$this->form_validation->set_rules('type_4','type_4','trim|xss_clean');
		$this->form_validation->set_rules('days_4','days_4','trim|is_numeric|xss_clean');
		$this->form_validation->set_rules('quantity_4','quantity_4','trim|is_numeric|xss_clean');
		
		# row 5
		$this->form_validation->set_rules('bundle_item_5','bundle_item_5','trim|xss_clean');
		$this->form_validation->set_rules('type_5','type_5','trim|xss_clean');
		$this->form_validation->set_rules('days_5','days_5','trim|is_numeric|xss_clean');
		$this->form_validation->set_rules('quantity_5','quantity_5','trim|is_numeric|xss_clean');
		
		# row 6
		$this->form_validation->set_rules('bundle_item_6','bundle_item_6','trim|xss_clean');
		$this->form_validation->set_rules('type_6','type_6','trim|xss_clean');
		$this->form_validation->set_rules('days_6','days_6','trim|is_numeric|xss_clean');
		$this->form_validation->set_rules('quantity_6','quantity_6','trim|is_numeric|xss_clean');
		
		# row 7
		$this->form_validation->set_rules('bundle_item_7','bundle_item_7','trim|xss_clean');
		$this->form_validation->set_rules('type_7','type_7','trim|xss_clean');
		$this->form_validation->set_rules('days_7','days_7','trim|is_numeric|xss_clean');
		$this->form_validation->set_rules('quantity_7','quantity_7','trim|is_numeric|xss_clean');


		if( !$this->form_validation->run() ){ 
			$this->load->view('bundle/create_bundle_forecast', $data);
			return FALSE;
		}
		
		# get input post
		$input = $this->webspice->get_input('key');

		#duplicate test
		$this->webspice->db_field_duplicate_test("
		SELECT * FROM TBL_BUNDLE_FORECAST WHERE MATERIAL_CODE=? OR (SUBSCRIBERS_BASE=? AND MATERIAL_NAME=?)", 
		array($input->material_code, $input->subscribers_base, $input->material_name), 
		'You are not allowed to enter duplicate material code or material name', 'BUNDLE_ID', $input->key, $data, 'bundle/create_bundle_forecast');
		
		# remove cache
		
		# insert data
		$this->db->trans_off();
		$this->db->trans_begin();
		
		# remove previous forcast data
		$this->db->query("DELETE FROM TBL_BUNDLE_FORECAST");
		$this->db->query("DELETE FROM TBL_BUNDLE_ITEM_FORECAST");
		
		$new_squence = $this->webspice->getLastInserted('TBL_BUNDLE_FORECAST','BUNDLE_ID');
		$sql_bundle_main = "
		INSERT INTO TBL_BUNDLE_FORECAST(
		BUNDLE_ID,SUBSCRIBERS_BASE,MATERIAL_CODE,MATERIAL_NAME,
		MRP,TYPE,EMI_MONTH,EMI_INTEREST,SALE_DATE,SALE_QUANTITY,CREATED_BY,CREATED_DATE,STATUS)
		VALUES('".($new_squence+1)."','".$input->subscribers_base."','".$input->material_code."','".$input->material_name.
		"',".(int)$input->mrp.",'".$input->type."',".(int)$input->emi_month.",".(float)$input->emi_interest.
		",TO_DATE('".$input->sale_date."','yyyy-mm-dd hh:mi:ss'),".(int)$input->sale_quantity.",".$this->webspice->get_user_id().",TO_DATE('".$this->webspice->now()."','yyyy-mm-dd hh:mi:ss'),7)";
		
		$this->db->query($sql_bundle_main);
		
		
		#$bundle_id = $this->db->insert_id();
		$bundle_id = $this->webspice->getLastInserted('TBL_BUNDLE_FORECAST','BUNDLE_ID');
		$new_squence = $this->webspice->getLastInserted('TBL_BUNDLE_ITEM_FORECAST','ID');
		# prepare bundle item
		$temp_value = array();
		if( $input->bundle_item_1 && $input->type_1 && $input->quantity_1 ){
			$temp_value[] = "(".($new_squence+1).",".$bundle_id.",".$input->bundle_item_1.",'".$input->type_1."',".(int)$input->days_1.",".(int)$input->quantity_1.",".(float)$this->customcache->service_maker($input->bundle_item_1,'UNIT_PRICE').",7)";
		}
		if( $input->bundle_item_2 && $input->type_2 && $input->quantity_2 ){
			$temp_value[] = "(".($new_squence+2).",".$bundle_id.",".$input->bundle_item_2.",'".$input->type_2."',".(int)$input->days_2.",".(int)$input->quantity_2.",".(float)$this->customcache->service_maker($input->bundle_item_2,'UNIT_PRICE').",7)";
		}
		if( $input->bundle_item_3 && $input->type_3 && $input->quantity_3 ){
			$temp_value[] = "(".($new_squence+3).",".$bundle_id.",".$input->bundle_item_3.",'".$input->type_3."',".(int)$input->days_3.",".(int)$input->quantity_3.",".(float)$this->customcache->service_maker($input->bundle_item_3,'UNIT_PRICE').",7)";
		}
		if( $input->bundle_item_4 && $input->type_4 && $input->quantity_4 ){
			$temp_value[] = "(".($new_squence+4).",".$bundle_id.",".$input->bundle_item_4.",'".$input->type_4."',".(int)$input->days_4.",".(int)$input->quantity_4.",".(float)$this->customcache->service_maker($input->bundle_item_4,'UNIT_PRICE').",7)";
		}
		if( $input->bundle_item_5 && $input->type_5 && $input->quantity_5 ){
			$temp_value[] = "(".($new_squence+5).",".$bundle_id.",".$input->bundle_item_5.",'".$input->type_5."',".(int)$input->days_5.",".(int)$input->quantity_5.",".(float)$this->customcache->service_maker($input->bundle_item_5,'UNIT_PRICE').",7)";
		}
		if( $input->bundle_item_6 && $input->type_6 && $input->quantity_6 ){
			$temp_value[] = "(".($new_squence+6).",".$bundle_id.",".$input->bundle_item_6.",'".$input->type_6."',".(int)$input->days_6.",".(int)$input->quantity_6.",".(float)$this->customcache->service_maker($input->bundle_item_6,'UNIT_PRICE').",7)";
		}
		if( $input->bundle_item_7 && $input->type_7 && $input->quantity_7 ){
			$temp_value[] = "(".($new_squence+7).",".$bundle_id.",".$input->bundle_item_7.",'".$input->type_7."',".(int)$input->days_7.",".(int)$input->quantity_7.",".(float)$this->customcache->service_maker($input->bundle_item_7,'UNIT_PRICE').",7)";
		}
		
		if( !$temp_value ){
			$this->db->trans_rollback();
			$this->webspice->message_board('We could not execute your request. Please try again with correct information.');
			$this->webspice->force_redirect($url_prefix);
			return false;
		}

		
		$sql_bundle_item = "
		INSERT INTO TBL_BUNDLE_ITEM_FORECAST(ID,BUNDLE_ID,SERVICE_ID,TYPE,LOOP_DAYS,QUANTITY,UNIT_PRICE,STATUS)
		VALUES ".implode(',', $temp_value)."
		";
		//dd($sql_bundle_item);
		$this->db->query($sql_bundle_item);
	
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$this->webspice->message_board('We could not execute your request. Please try again or report to authority.');
			$this->webspice->force_redirect($url_prefix);
			return false;
			
		}else{
			$this->db->trans_commit();
		}
		$this->db->trans_off();

		$this->webspice->message_board('Record has been inserted successfully.');
		$this->webspice->force_redirect($url_prefix);
	}
	
	function view_forecast_data(){
		$url_prefix = $this->webspice->settings()->site_url_prefix;
		
		$this->webspice->user_verify($url_prefix.'login', $url_prefix.'view_forecast_data');
		$this->webspice->permission_verify('view_forecast_data');

		$this->load->database();
    $orderby = null;
    $groupby = null;
    $where = null;
    $page_index = 0;
    $no_of_record = 30;
    $limit = null;
    $filter_by = 'Last Created';
    $data['pager'] = null;
    $criteria = $this->uri->segment(2);
    $key = $this->uri->segment(3);
    if ($criteria == 'page') {
    	$page_index = (int)$key; 
    	$page_index < 0 ? $page_index=0 : $page_index=$page_index;
    }

		$initialSQL = "
		SELECT TBL_BUNDLE_FORECAST.*
		FROM TBL_BUNDLE_FORECAST
		";

    # default
    $sql = $initialSQL . $where . $groupby . $orderby . $limit;

    # only for pager
/*    if( $criteria == 'page' ){
    	if( !isset($_SESSION['sql_bundle']) || !$_SESSION['sql_bundle'] ){
    		$sql = substr($sql, 0, strpos($sql,'LIMIT'));
    	}else{
    		$sql = substr($_SESSION['sql_bundle'], 0, strpos($_SESSION['sql_bundle'],'LIMIT'));
    	}
    	
    	$limit = sprintf("LIMIT %d, %d", $page_index, $no_of_record);		# this is to avoid SQL Injection
    	$sql = $sql . $limit;
    }
    
		# load all records
		if( !$this->input->post('filter') ){
			$count_data = $this->db->query( substr($sql,0,strpos($sql,'LIMIT')) );
			$count_data = $count_data->result();
			$data['pager'] = $this->webspice->pager( count($count_data), $no_of_record, $page_index, $url_prefix.'view_forecast_data/page/', 10 );
		}
*/
    $_SESSION['sql_bundle'] = $sql;
    $_SESSION['filter_by'] = $filter_by;
    $result = $this->db->query($sql)->result();
  	
		$data['get_record'] = $result;
		$data['filter_by'] = $filter_by;

		$this->load->view('bundle/view_forecast_data', $data);
	}
	
	function details_forecast_data(){
		$url_prefix = $this->webspice->settings()->site_url_prefix;
		
		$this->webspice->user_verify($url_prefix.'login', $url_prefix.'view_forecast_data');
		$this->webspice->permission_verify('view_forecast_data');

		$this->load->database();
    $orderby = null;
    $groupby = null;
    $where = null;
    $page_index = 0;
    $no_of_record = 20;
    $limit = null;
    $filter_by = 'Last Created';
    $data['pager'] = null;
    $criteria = $this->uri->segment(2);
    $key = $this->webspice->encrypt_decrypt($this->uri->segment(3),'decrypt');
    if ($criteria == 'page') {
    	$page_index = (int)$key; 
    	$page_index < 0 ? $page_index=0 : $page_index=$page_index;
    }

		$initialSQL = "
		SELECT TBL_BUNDLE_ITEM_FORECAST.*,
		TBL_BUNDLE_FORECAST.SUBSCRIBERS_BASE, TBL_BUNDLE_FORECAST.MATERIAL_CODE, TBL_BUNDLE_FORECAST.MATERIAL_NAME, TBL_BUNDLE_FORECAST.TYPE as BUNDLE_TYPE, 
		TBL_BUNDLE_FORECAST.CREATED_BY as BUNDLE_CREATED_BY, TBL_BUNDLE_FORECAST.CREATED_DATE as BUNDLE_CREATED_DATE, 
		TBL_BUNDLE_FORECAST.UPDATED_BY as BUNDLE_UPDATED_BY, TBL_BUNDLE_FORECAST.UPDATED_DATE as BUNDLE_UPDATED_DATE,
		TBL_BUNDLE_SERVICE.*
		FROM TBL_BUNDLE_ITEM_FORECAST
		LEFT JOIN TBL_BUNDLE_FORECAST ON TBL_BUNDLE_FORECAST.BUNDLE_ID=TBL_BUNDLE_ITEM_FORECAST.BUNDLE_ID
		LEFT JOIN TBL_BUNDLE_SERVICE ON TBL_BUNDLE_SERVICE.SERVICE_ID=TBL_BUNDLE_ITEM_FORECAST.SERVICE_ID
		";
		
		$where = 'WHERE TBL_BUNDLE_ITEM_FORECAST.BUNDLE_ID='.$key;

    # default
    $sql = $initialSQL . $where . $groupby . $orderby . $limit;

    $result = $this->db->query($sql)->result();

		$data['get_record'] = $result;
		if( $data['get_record'] ){
			$bundle_info = $data['get_record'][0];
			$filter_by = 'Subscribers Base: '.ucwords(str_replace('_',' ',$bundle_info->SUBSCRIBERS_BASE)).' &raquo; Material Code: '.$bundle_info->MATERIAL_CODE.' &raquo; Material Name: '.ucwords(str_replace('_',' ',$bundle_info->MATERIAL_NAME)).' &raquo; Type: '.ucwords(str_replace('_',' ',$bundle_info->BUNDLE_TYPE));
			$filter_by .= '<br />Created By: '.$this->customcache->user_maker($bundle_info->BUNDLE_CREATED_BY,'USER_NAME').' &raquo; Created Date: '.$this->webspice->formatted_date($bundle_info->BUNDLE_CREATED_DATE);
		}
		
    $_SESSION['sql_bundle_details'] = $sql;
    $_SESSION['filter_by'] = $filter_by;
    $data['filter_by'] = $filter_by;

		$this->load->view('bundle/details_forecast_data', $data);
	}
	
	function print_bundle_forecast(){
		$url_prefix = $this->webspice->settings()->site_url_prefix;
		echo '
		<script>
	  var win = window.open("'.$url_prefix.'bundle_forecast/print", "_blank");
	  win.focus();
	  </script>
	  ';
	  
	  $data['title'] = 'Thank you.';
	  $data['body'] = 'Forecast report has been made.';
	  $this->load->view('view_message', $data);
	}
	function bundle_forecast(){
		$url_prefix = $this->webspice->settings()->site_url_prefix;
		$data = null;
		
		# get bundle information
		$get_bundle = "
		SELECT TBL_BUNDLE_FORECAST.*
		FROM TBL_BUNDLE_FORECAST
		WHERE TBL_BUNDLE_FORECAST.STATUS = 7
		";
		$get_bundle_result = $this->db->query($get_bundle)->result();
		
		# get bundle information
		$get_bundle_item = "
  	SELECT TBL_BUNDLE_ITEM_FORECAST.*,
  	TBL_BUNDLE_SERVICE.SERVICE_NAME, TBL_BUNDLE_SERVICE.PRICE_TYPE, TBL_BUNDLE_SERVICE.UNIT, TBL_BUNDLE_SERVICE.VAT_APPLICABLE
  	FROM TBL_BUNDLE_ITEM_FORECAST
  	LEFT JOIN TBL_BUNDLE_SERVICE ON TBL_BUNDLE_SERVICE.SERVICE_ID=TBL_BUNDLE_ITEM_FORECAST.SERVICE_ID
		";
		$get_bundle_item_result = $this->db->query($get_bundle_item)->result();
		
		# data verification
		if( !$get_bundle_result || !$get_bundle_item_result ){
			$this->webspice->message_board('There is no forecast data found! Please create one.');
			$this->webspice->force_redirect($url_prefix.'create_bundle_forecast');
			return false;
		}
		
		 # get bundle info
		$data['bundle_type'] = $get_bundle_result[0]->TYPE;
		$data['emi_month'] = $get_bundle_result[0]->EMI_MONTH;
		$data['interest_rate'] = $get_bundle_result[0]->EMI_INTEREST;
    $data['bundle_mrp'] = $get_bundle_result[0]->MRP;
    
    # note: bundle MRP might be lower than actual price (it is an offer so far)
    $actual_price = 0;
    foreach( $get_bundle_item_result as $k=>$v ){
    	$temp_quantity = $v->QUANTITY;
    	
    	if($data['bundle_type'] == 'emi' && $v->TYPE=='loop'){
    		$temp_quantity = $v->QUANTITY * $data['emi_month'];
    	}
    	
    	$actual_price += ($temp_quantity * $v->UNIT_PRICE);
    }
    
    # get breakup total and max loop days
    $break_up_total = 0;
    $max_loop_days = 0;
    foreach( $get_bundle_item_result as $k1=>$v1 ){
    	if($v1->LOOP_DAYS > $max_loop_days){ $max_loop_days = $v1->LOOP_DAYS; }
    	
    	$temp_price = ($v1->QUANTITY * $v1->UNIT_PRICE);
    	$temp_break_up_value = (($data['bundle_mrp']/$actual_price)*$temp_price);
    	$break_up_total += $temp_break_up_value;
    }
    
    # get service duration
    if( $data['bundle_type'] == 'emi' ){
    	$max_loop_days = $data['emi_month'] * 30;
    }
    
    $data['start_date'] = $get_bundle_result[0]->SALE_DATE;
    $data['end_date'] = $this->webspice->addDate($data['start_date'], $max_loop_days, $type='days');

    $data['start_year'] = date("Y", strtotime($data['start_date']));
    $data['start_month'] = date("m", strtotime($data['start_date']));
    $data['month_count'] = $this->webspice->calculate_months_between_two_dates($data['start_date'], $data['end_date']);
    if( $data['month_count'] < 1 ){
			$this->webspice->message_board('Forecast data is invalid. Please re-create the data.');
			$this->webspice->force_redirect($url_prefix.'create_bundle_forecast');
			return false;
    }
    
    $data['actual_price'] = $actual_price;
    $data['break_up_total'] = $break_up_total;
		
		$data['get_bundle'] = $get_bundle_result;
		$data['get_bundle_item'] = $get_bundle_item_result;
		
  	if( $this->uri->segment(2)=='print' ){
  		$data['action_type'] = 'print';
  		
  	}elseif( $this->uri->segment(2) == 'export' ){
  		$data['action_type'] = 'csv';
  	}
  	
  	$data['filter_by'] = 'Bundle Name: '.$get_bundle_result[0]->MATERIAL_NAME.' &raquo; MRP: '.$get_bundle_result[0]->MRP.' &raquo; Type: '.ucwords(str_replace('_',' ',$get_bundle_result[0]->TYPE)).' &raquo; Quantity: '.$get_bundle_result[0]->SALE_QUANTITY.' &raquo; Projection Date: '.date("Y-m-d",strtotime($get_bundle_result[0]->SALE_DATE));
  	if( $data['bundle_type'] == 'emi' ){
  		$data['filter_by'] .= ' &raquo; EMI Month: '.$get_bundle_result[0]->EMI_MONTH.' &raquo; Interest Rate: '.$get_bundle_result[0]->EMI_INTEREST;
  	}
  	
		$this->load->view('report/print_bundle_forecast', $data);
	}

	function upload_sale_batch($data=null){

		$url_prefix = $this->webspice->settings()->site_url_prefix;
		$data_batch = 50; # how much row(s) inserted once
		ini_set('MAX_EXECUTION_TIME', 300);
		
		$this->webspice->user_verify($url_prefix.'login', $url_prefix.'upload_sale_batch');
		$this->webspice->permission_verify('upload_sale_batch');
		
		if( !$_FILES || !$_FILES['sap_file']['tmp_name'] ){
			$this->load->view('bundle/upload_sale_batch', $data);
			return FALSE;
		}

		# verify file type
		if( $_FILES['sap_file']['tmp_name'] ){
			$this->webspice->check_file_type(array('csv','xls'), 'sap_file', $data, 'bundle/upload_sale_batch');   
		}
		
		# verify duplicate file
		$get_bundle_file_sql = "SELECT * FROM TBL_BUNDLE_SALE_FILE WHERE FILE_NAME = ?";
		$get_bundle_file = $this->db->query($get_bundle_file_sql, array($_FILES['sap_file']['name']))->result();
		if($get_bundle_file){
			$this->webspice->message_board('This file uploaded once. Please upload the correct file.');
			$this->webspice->force_redirect($url_prefix.'upload_sale_batch');
			return FALSE;
		}

		# verify file type and read accordingly
		$get_data = array();
		if( $_FILES['sap_file']['type'] == 'application/vnd.ms-excel' || $_FILES['sap_file']['type'] == 'application/octet-stream' ){
			$get_data = $this->webspice->excel_reader($_FILES['sap_file']['tmp_name'], 0, array('Invoice Dt','Sold to Party','Cust.Name','Material','Material Description','Invoice No','Sales Off.Descrp','Qty','Gross Value'));
			dd($get_data);
		}elseif( $_FILES['sap_file']['type'] == 'text/csv' || $_FILES['sap_file']['type'] == 'text/comma-separated-values' ){
			
			$get_csv_data = $this->webspice->csv_reader($file_input_name='sap_file', array('Invoice Dt','Sold to Party','Cust.Name','Material','Material Description','Invoice No','Sales Off.Descrp','Qty','Gross Value'));
				
			if( !is_array($get_csv_data) ){
				$this->webspice->message_board($get_csv_data.' Please try again.');
				$this->webspice->force_redirect($url_prefix.'upload_sale_batch');
				return FALSE;
			}
		
			# excel reader column offset starts from 1, that is way this has been started from 1
			# because all operations has been done using above offset serial
			$get_data = array();
			foreach($get_csv_data as $key => $value){
				$new_array = array();
				foreach($value as $key1=>$value1){
					$new_array[$key1+1] = trim($value1);
				}
			  $get_data[$key] = $new_array;
			}
			
		}else{
			echo 'File Invalid!';
			exit;
		}
		
		if( !is_array($get_data) ){
			$this->webspice->message_board($get_data.' Please try again.');
			$this->webspice->force_redirect($url_prefix.'upload_sale_batch');
			return FALSE;
		}
		

		# verify data
		$data_error = null;
		foreach($get_data as $k=>$v){
			$data_list = $v;
/*			$Invoice_Dt = $data_list[1];
			$Sold_to_Party = $data_list[2];
			$Cust_Name = $data_list[3];
			$Material = $data_list[4];
			$Material_Description = $data_list[5];
			$Invoice_No = $data_list[6];
			$Sales_Off_Descrp = $data_list[7];
			$Qty = $data_list[8];
			$Gross_Value = $data_list[9];*/
			$Invoice_Dt = str_replace(array("'",'"',','), array('','',''), $this->webspice->clean_input($data_list[1]));
			$Sold_to_Party = str_replace(array("'",'"',','), array('','',''), $this->webspice->clean_input($data_list[2]));
			$Cust_Name = str_replace(array("'",'"',','), array('','',''), $this->webspice->clean_input($data_list[3]));
			$Material = str_replace(array("'",'"',','), array('','',''), $this->webspice->clean_input($data_list[4]));
			$Material_Description = str_replace(array("'",'"',','), array('','',''), $this->webspice->clean_input($data_list[5]));
			$Invoice_No = str_replace(array("'",'"',','), array('','',''), $this->webspice->clean_input($data_list[6]));
			$Sales_Off_Descrp = str_replace(array("'",'"',','), array('','',''), $this->webspice->clean_input($data_list[7]));
			$Qty = str_replace(array("'",'"',','), array('','',''), $this->webspice->clean_input($data_list[8]));
			$Gross_Value = str_replace(array("'",'"',','), array('','',''), $this->webspice->clean_input($data_list[9]));
		
			# must have column value - column offset started from 1
			if( !isset($Invoice_Dt) || !isset($Sold_to_Party) || !isset($Cust_Name) || !isset($Material) || !isset($Material_Description) || !isset($Invoice_No) || !isset($Sales_Off_Descrp) || !isset($Qty) || !isset($Gross_Value) ){
				$data_error .= 'Row #'.$k.' is incomplete.<br />';
			}

			# verify bundle name from database
			if( isset($Material) && !$this->customcache->bundle_maker($Material,'BUNDLE_ID','MATERIAL_CODE') ){
				$data_error .= 'Material Code "'.$Material.'" at Row #'.$k.' is invalid.<br />';
			}
			
			# verify quantity
			/*
			if( isset($Qty) && (int)$Qty < 1 ){
				$data_error .= 'Quantity "'.$Qty.'" at Row #'.$k.' is invalid.<br />';
			}*/
			
			if( isset($Qty) && !is_numeric($Qty) ){
				$data_error .= 'Quantity "'.$Qty.'" at Row #'.$k.' is invalid.<br />';
			}
			
			# verify gross value
			/*
			if( isset($Gross_Value) && (double)$Gross_Value < 1 ){
				$data_error .= 'Gross Value "'.$Gross_Value.'" at Row #'.$k.' is invalid.<br />';
			}*/
			if( isset($Gross_Value) && !is_numeric($Gross_Value) ){
				$data_error .= 'Gross Value "'.$Gross_Value.'" at Row #'.$k.' is invalid.<br />';
			}
			
			# verify date
			 if( isset($Invoice_Dt) && !$this->webspice->isDate($Invoice_Dt,'day', 'month', 'year') ){ 
			 	$data_error .= 'Date "'.$Invoice_Dt.'" at Row #'.$k.' is invalid.<br />'; } }
		
		if($data_error){
			$data['error'] = $data_error.'<span class="fred fbold">Please update the file and try again.</span>';
			$this->load->view('bundle/upload_sale_batch', $data);
			return FALSE;
		}

		# insert data
		$this->db->trans_off();
		$this->db->trans_begin();
		
		$data_section = 0;
		$data_count = 1; # row offset started from 2
		$new_squence = $this->webspice->getLastInserted('TBL_BUNDLE_SALE','SALE_ID');
		$data_query = array();
		while( count($get_data) > $data_section ){
			$data_query = array(); # make it empty
			
			for($i=1; $i<=$data_batch; $i++){
				$data_count++;
				if( isset($get_data[$data_count]) ){
					$data_sheet = $get_data[$data_count];
					$Invoice_Dt = str_replace(array("'",'"',','), array('','',''), $this->webspice->clean_input($data_sheet[1]));
					$Sold_to_Party = str_replace(array("'",'"',','), array('','',''), $this->webspice->clean_input($data_sheet[2]));
					$Cust_Name = str_replace(array("'",'"',','), array('','',''), $this->webspice->clean_input($data_sheet[3]));
					$Material = str_replace(array("'",'"',','), array('','',''), $this->webspice->clean_input($data_sheet[4]));
					$Material_Description = str_replace(array("'",'"',','), array('','',''), $this->webspice->clean_input($data_sheet[5]));
					$Invoice_No = str_replace(array("'",'"',','), array('','',''), $this->webspice->clean_input($data_sheet[6]));
					$Sales_Off_Descrp = str_replace(array("'",'"',','), array('','',''), $this->webspice->clean_input($data_sheet[7]));
					$Qty = str_replace(array("'",'"',','), array('','',''), $this->webspice->clean_input($data_sheet[8]));
					$Gross_Value = str_replace(array("'",'"',','), array('','',''), $this->webspice->clean_input($data_sheet[9]));

					$channel_name = $this->bundle_channel_maker($Sold_to_Party);
					$data_query[] = "(".($new_squence+1).",".$this->customcache->bundle_maker($Material,'BUNDLE_ID','MATERIAL_CODE').",TO_DATE('".date("Y-m-d",strtotime($Invoice_Dt))."','yyyy-mm-dd hh:mi:ss'),'".$Sold_to_Party."','".$channel_name."','".$Cust_Name."','".$Material."','".$Invoice_No."','".$Material_Description."',".(double)str_replace(',','',$Qty).",".(double)str_replace(',','',$Gross_Value).",".$this->webspice->get_user_id().",TO_DATE('".$this->webspice->now()."','yyyy-mm-dd hh:mi:ss'),7)";
				}
			}

			if($data_query){
				foreach($data_query as $keyIndex=>$queryValues){
					$this->db->query("
					INSERT INTO TBL_BUNDLE_SALE
					(SALE_ID,BUNDLE_ID,INVOICE_DATE,SOLD_TO_PARTY,CHANNEL,CUST_NAME,MATERIAL_CODE,INVOICE_NO,DESCRIPTION,QUANTITY,GROSS_VALUE,CREATED_BY,CREATED_DATE,STATUS) 
					VALUES ".$queryValues);
				}
			}
			
			$data_section += $data_batch;
		}
		
		# insert file name to stop duplicate upload
		$new_squence = $this->webspice->getLastInserted('TBL_BUNDLE_SALE_FILE','ID');
		$this->db->query("INSERT INTO TBL_BUNDLE_SALE_FILE(ID,FILE_NAME, UPLOAD_BY, UPLOAD_DATE) VALUES(?,?,?,TO_DATE(?,'yyyy-mm-dd hh:mi:ss'))", array($new_squence+1,$_FILES['sap_file']['name'], $this->webspice->get_user_id(), $this->webspice->now()));

		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$this->webspice->message_board('We could not execute your request. Please try again or report to authority.');
			$this->webspice->force_redirect($url_prefix);
			return false;
			
		}else{
			$this->db->trans_commit();
		}
		$this->db->trans_off();

		$this->webspice->message_board('Record has been inserted successfully.');
		if( $this->webspice->permission_verify('manage_sale', true) ){
			$this->webspice->force_redirect($url_prefix.'manage_sale');
		}

		$this->webspice->force_redirect($url_prefix);
	}

	function upload_sale_individual($data=null){
		$url_prefix = $this->webspice->settings()->site_url_prefix;

		$this->webspice->user_verify($url_prefix.'login', $url_prefix.'upload_sale_individual');
		$this->webspice->permission_verify('upload_sale_individual');
		
		if( !isset($data['edit']) ){
			$data['edit'] = array(
			'SALE_ID'=>null
			);
		}
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('bundle_id','bundle_id','required|trim|xss_clean');
		$this->form_validation->set_rules('invoice_date','invoice_date','required|trim|xss_clean');
		$this->form_validation->set_rules('sold_to_party','sold_to_party','required|trim|xss_clean');
		$this->form_validation->set_rules('invoice_no','invoice_no','required|trim|xss_clean');
		$this->form_validation->set_rules('description','description','required|trim|xss_clean');
		$this->form_validation->set_rules('quantity','quantity','required|trim|xss_clean');
		$this->form_validation->set_rules('gross_value','gross_value','required|trim|xss_clean');

		if( !$this->form_validation->run() ){ 
			$this->load->view('bundle/upload_sale_individual', $data);
			return FALSE;
		}
		
		# get input post
		$input = $this->webspice->get_input();
		$input->channel = $this->bundle_channel_maker($input->sold_to_party);
		$input->material_code = $this->customcache->bundle_maker($input->bundle_id, 'MATERIAL_CODE');

		# insert data
		$new_squence = $this->webspice->getLastInserted('TBL_BUNDLE_SALE','SALE_ID');
		$sql = "
		INSERT INTO TBL_BUNDLE_SALE
		(SALE_ID, BUNDLE_ID, INVOICE_DATE, SOLD_TO_PARTY, CHANNEL, MATERIAL_CODE, INVOICE_NO, DESCRIPTION, QUANTITY, GROSS_VALUE, 
		CREATED_BY, CREATED_DATE, STATUS)
		VALUES
		(?, ?, TO_DATE(?,'yyyy-mm-dd hh:mi:ss'), ?, ?, ?, ?, ?, ?, ?, ?, TO_DATE(?,'yyyy-mm-dd hh:mi:ss'), 7)";
		$result=$this->db->query($sql, 
		array($new_squence+1,$input->bundle_id, $input->invoice_date, $input->sold_to_party, $input->channel, $input->material_code,
		$input->invoice_no, $input->description, (int)$input->quantity, (float)$input->gross_value, 
		$this->webspice->get_user_id(), $this->webspice->now()));
		
		if( !$result ){
			$this->webspice->message_board('We could not execute your request. Please tray again later or report to authority.');
			$this->webspice->force_redirect($url_prefix);
			return false;
		}
		
		$this->webspice->message_board('Your requested data has been inserted.');
		if( $this->webspice->permission_verify('manage_sale', true) ){
			$this->webspice->force_redirect($url_prefix.'manage_sale');
			return false;
		}
		$this->webspice->force_redirect($url_prefix);
	}
	
	function manage_sale(){
		$url_prefix = $this->webspice->settings()->site_url_prefix;
		
		$this->webspice->user_verify($url_prefix.'login', $url_prefix.'manage_sale');
		$this->webspice->permission_verify('manage_sale');

		$this->load->database();
    $orderby = null;
    $groupby = null;
    $where = ' WHERE ROWNUM <= 50';
    $page_index = 0;
    $no_of_record = 50;
    $limit = null;
    $filter_by = 'Last Created';
    $data['pager'] = null;
    $criteria = $this->uri->segment(2);
    $key = $this->uri->segment(3);
    if ($criteria == 'page') {
    	$page_index = (int)$key; 
    	$page_index < 0 ? $page_index=0 : $page_index=$page_index;
    }

		$initialSQL = "
		SELECT TBL_BUNDLE_SALE.*,
		TBL_BUNDLE.SUBSCRIBERS_BASE
		FROM TBL_BUNDLE_SALE
		LEFT JOIN TBL_BUNDLE ON TBL_BUNDLE.BUNDLE_ID=TBL_BUNDLE_SALE.BUNDLE_ID
		";
    
   	# filtering records
    if( $this->input->post('filter') ){

			$result = $this->webspice->filter_generator(
				$TableName = 'TBL_BUNDLE_SALE', 
				$InputField = array('TBL_BUNDLE.SUBSCRIBERS_BASE','CHANNEL'), 
				$Keyword = array(),
				$AdditionalWhere = null,
				$DateBetween = array('INVOICE_DATE','date_from','date_end')
			);

			$result['where'] ? $where = $result['where'] : $where=$where;
			$result['filter'] ? $filter_by = $result['filter'] : $filter_by=$filter_by;

   	}

    # action area
    switch ($criteria) {
      case 'print':
      case 'csv':
        if( !isset($_SESSION['sql_sale']) || !$_SESSION['sql_sale'] ){
					$_SESSION['sql_sale'] = $initialSQL . $where . $orderby;
					$_SESSION['filter_by'] = $filter_by;
    		}
    		
    		$record = $this->db->query( $_SESSION['sql_sale'] );										 		
				$data['get_record'] = $record->result();
				$data['filter_by'] = $_SESSION['filter_by'];
			
				$this->load->view('bundle/print_sale',$data);
				return false;
        break;
    }
    
    # default

    $sql = $initialSQL . $where . $groupby . $orderby . $limit;
    //dd($sql);
  
    # only for pager
/*    if( $criteria == 'page' ){
    	if( !isset($_SESSION['sql_sale']) || !$_SESSION['sql_sale'] ){
				$sql = substr($sql, 0, strpos($sql,'LIMIT'));
    	}else{
				$sql = substr($_SESSION['sql_sale'], 0, strpos($_SESSION['sql_sale'],'LIMIT'));
			}
		
    	$limit = sprintf("LIMIT %d, %d", $page_index, $no_of_record);		# this is to avoid SQL Injection
    	$sql = $sql . $limit;
    }*/
    
		# load all records
/*		if( !$this->input->post('filter') ){
			$count_data = $this->db->query( substr($sql,0,strpos($sql,'LIMIT')) );
			$count_data = $count_data->result();
			$data['pager'] = $this->webspice->pager( count($count_data), $no_of_record, $page_index, $url_prefix.'manage_sale/page/', 10 );
		}*/
    
    $_SESSION['sql_sale'] = $sql;
    $_SESSION['filter_by'] = $filter_by;
    $result = $this->db->query($sql)->result();
  	
		$data['get_record'] = $result;
		$data['filter_by'] = $filter_by;

		$this->load->view('bundle/manage_sale', $data);
	}

	
	function fv_allocation(){
		$url_prefix = $this->webspice->settings()->site_url_prefix;
		$data = null;
	
		$this->webspice->user_verify($url_prefix.'login', $url_prefix.'fv_allocation');
		$this->webspice->permission_verify('fv_allocation');

		$this->load->database();

		if( !$_POST ){
			$this->load->view('report/fv_allocation', $data);
			return false;
		}

    # get input post
    $input = $this->webspice->get_input();
		
		 # get bundle info
		$bundle_type = $this->customcache->bundle_maker($input->BUNDLE_ID,'TYPE');
		$emi_month = $this->customcache->bundle_maker($input->BUNDLE_ID,'EMI_MONTH');
    $data['bundle_mrp'] = $this->customcache->bundle_maker($input->BUNDLE_ID,'MRP');
		
		# get bundle item(s)
  	$sql_bundle_item = "
  	SELECT TBL_BUNDLE_ITEM.*,
  	TBL_BUNDLE_SERVICE.SERVICE_NAME, TBL_BUNDLE_SERVICE.PRICE_TYPE, TBL_BUNDLE_SERVICE.UNIT, TBL_BUNDLE_SERVICE.VAT_APPLICABLE
  	FROM TBL_BUNDLE_ITEM
  	LEFT JOIN TBL_BUNDLE_SERVICE ON TBL_BUNDLE_SERVICE.SERVICE_ID=TBL_BUNDLE_ITEM.SERVICE_ID
  	WHERE TBL_BUNDLE_ITEM.BUNDLE_ID=?
  	";
  	$data['get_bundle_item'] = $this->db->query($sql_bundle_item, array($input->BUNDLE_ID))->result();
    if( !$data['get_bundle_item'] ){
    	$this->webspice->message_board('Bundle information could not found!');
    	$this->load->view('report/fv_allocation', $data);
    	return false;
    }

    # note: bundle MRP might be lower than actual price (it is an offer so far)
    $actual_price = 0;
    foreach( $data['get_bundle_item'] as $k=>$v ){
    	$temp_quantity = $v->QUANTITY;
    	if($bundle_type=='emi' && $v->TYPE=='loop'){
    		$temp_quantity = $v->QUANTITY * $emi_month;
    	}
    	$actual_price += ($temp_quantity * $v->UNIT_PRICE);
    }
    
    # get breakup total
    $break_up_total = 0;
    foreach( $data['get_bundle_item'] as $k1=>$v1 ){
    	$temp_price = ($v1->QUANTITY * $v1->UNIT_PRICE);
    	$temp_break_up_value = (($data['bundle_mrp']/$actual_price)*$temp_price);
    	$break_up_total += $temp_break_up_value;
    }
    
    $data['actual_price'] = $actual_price;
    $data['break_up_total'] = $break_up_total;

    $data['filter_by'] = 'Bundle Name: '.$this->customcache->bundle_maker($input->BUNDLE_ID,'MATERIAL_NAME').' &raquo; Type: '.ucwords(str_replace('_',' ',$bundle_type));

		$data['action_type'] = 'view';
  	if( $this->input->post('print') ){
  		$data['action_type'] = 'print';
  		
  	}elseif( $this->input->post('export') ){
  		$data['action_type'] = 'csv';
  	}
  	
  	if( $bundle_type =='emi' ){
			$value = $this->load->view('report/print_fv_allocation_emi', $data, true);
  		
  	}elseif( $bundle_type !='emi' ){
  		$data['filter_by'] .= ' &raquo; MRP: '.$data['bundle_mrp'];
  		$value = $this->load->view('report/print_fv_allocation', $data, true);
  	}

		echo $value;
		exit;
	}
	
	function fv_deferment(){
		/*
		- deferment has no SD and VAT
		- no device will deferred
		*/
		$url_prefix = $this->webspice->settings()->site_url_prefix;
		$data = null;

		$this->webspice->user_verify($url_prefix.'login', $url_prefix.'fv_deferment');
		$this->webspice->permission_verify('fv_deferment');

		$this->load->database();

		if( !$_POST ){
			$this->load->view('report/fv_deferment', $data);
			return false;
		}

    # get input post
    $input = $this->webspice->get_input();

    # get bundle sale
    $sql_bundle_sale = "
    SELECT TBL_BUNDLE_SALE.*
    FROM TBL_BUNDLE_SALE
    WHERE TBL_BUNDLE_SALE.BUNDLE_ID = ?
    AND TBL_BUNDLE_SALE.STATUS = 7
    ORDER BY TBL_BUNDLE_SALE.INVOICE_DATE
    ";
    $data['get_bundle_sale'] = $this->db->query($sql_bundle_sale, array($input->BUNDLE_ID))->result();
    if( !$data['get_bundle_sale'] ){
    	$this->webspice->message_board('There is no sale date found!');
    	$this->load->view('report/fv_deferment', $data);
    	return false;
    }

		# get bundle item(s) - without device GL
  	$sql_bundle_item = "
  	SELECT TBL_BUNDLE_ITEM.*,
  	TBL_BUNDLE_SERVICE.SERVICE_NAME, TBL_BUNDLE_SERVICE.PRICE_TYPE, TBL_BUNDLE_SERVICE.UNIT, TBL_BUNDLE_SERVICE.VAT_APPLICABLE
  	FROM TBL_BUNDLE_ITEM
  	LEFT JOIN TBL_BUNDLE_SERVICE ON TBL_BUNDLE_SERVICE.SERVICE_ID=TBL_BUNDLE_ITEM.SERVICE_ID
  	WHERE TBL_BUNDLE_ITEM.BUNDLE_ID=?
  	AND TBL_BUNDLE_SERVICE.GL_CODE != ?
  	";
  	$data['get_bundle_item'] = $this->db->query($sql_bundle_item, array($input->BUNDLE_ID, $this->webspice->settings()->gl_device))->result();
    if( !$data['get_bundle_item'] ){
    	$this->webspice->message_board('Bundle information could not found!');
    	$this->load->view('report/fv_deferment', $data);
    	return false;
    }
 
    # get bundle info
    $bundle_type = $this->customcache->bundle_maker($input->BUNDLE_ID,'TYPE');
    $data['bundle_mrp'] = $this->customcache->bundle_maker($input->BUNDLE_ID,'MRP');
		$data['emi_month'] = $this->customcache->bundle_maker($input->BUNDLE_ID,'EMI_MONTH');
		$data['interest_rate'] = $this->customcache->bundle_maker($input->BUNDLE_ID,'EMI_INTEREST');

    # get maximum loop days (month) from bundle item list and calculate actual bundle price
    # note: bundle MRP might be lower than actual price (it is an offer so far)
    $actual_price = 0;
    foreach( $data['get_bundle_item'] as $k=>$v ){
    	$temp_quantity = $v->QUANTITY;
    	if($bundle_type=='emi' && $v->TYPE=='loop'){
    		$temp_quantity = $v->QUANTITY * $data['emi_month'];
    	}
    	
    	$actual_price += ($temp_quantity * $v->UNIT_PRICE);
    }
    
    # find the last sale date to findout loop month according to date range
    #$last_sale_offset = count($data['get_bundle_sale'])-1;
    #$last_sale_date = $data['get_bundle_sale'][$last_sale_offset]->INVOICE_DATE;

  	# calculate date range
    $data['start_date'] = $input->start_date;
    $data['end_date'] = $input->end_date;

    $data['start_year'] = date("Y", strtotime($data['start_date']));
    $data['start_month'] = date("m", strtotime($data['start_date']));
    $data['month_count'] = $this->webspice->calculate_months_between_two_dates($data['start_date'], $data['end_date']);
    if( $data['month_count'] < 1 ){
    	$this->webspice->message_board('Date range is invalid!');
    	$this->load->view('report/fv_deferment', $data);
    	return false;
    }

    $data['actual_price'] = $actual_price;
    #$data['last_loop_date'] = $last_loop_date;

    $data['filter_by'] = 'Bundle Name: '.$this->customcache->bundle_maker($input->BUNDLE_ID,'MATERIAL_NAME').' &raquo; Type: '.ucwords(str_replace('_',' ',$bundle_type)).' &raquo; MRP: BDT '.$data['bundle_mrp'];
		if( $bundle_type == 'emi' ){
			$data['filter_by'] .= ' &raquo; Interest Rate: '.$data['interest_rate'].' &raquo; Period: '.$data['emi_month'].' Month(s)';
		}
		$data['filter_by'] .= ' &raquo; Date Range: '.$data['start_date'].' to '.$data['end_date'];
		
		$data['action_type'] = 'view';
  	if( $this->input->post('print') ){
  		$data['action_type'] = 'print';
  	}elseif( $this->input->post('export') ){
  		$data['action_type'] = 'csv';
  	}
  	
  	if( $bundle_type =='emi' ){
			$value = $this->load->view('report/print_fv_deferment_emi', $data, true);
  		
  	}elseif( $bundle_type !='emi' ){
  		$value = $this->load->view('report/print_fv_deferment', $data, true);
  	}

		echo $value;
	}
	
	function fv_deferment_summary(){
		$url_prefix = $this->webspice->settings()->site_url_prefix;
		$data = null;

		$this->webspice->user_verify($url_prefix.'login', $url_prefix.'fv_deferment_summary');
		$this->webspice->permission_verify('fv_deferment_summary');

		$this->load->database();

		if( !$_POST ){
			$this->load->view('report/fv_deferment_summary', $data);
			return false;
		}

    # get input post
    $input = $this->webspice->get_input();
    
    # get all Bundle
    $get_bundle = "
    SELECT TBL_BUNDLE.*
    FROM TBL_BUNDLE
    WHERE TBL_BUNDLE.STATUS = 2
   	";
   	$data['get_bundle_result'] = $this->db->query($get_bundle)->result();
   	if( !$data['get_bundle_result'] ){
   		echo 'There is no bundle found!';
   		exit;
   	}

  	# calculate date range
    $data['start_date'] = $input->start_date;
    $data['end_date'] = $input->end_date;

    $data['start_year'] = date("Y", strtotime($data['start_date']));
    $data['start_month'] = date("m", strtotime($data['start_date']));
    $data['month_count'] = $this->webspice->calculate_months_between_two_dates($data['start_date'], $data['end_date']);
    if( $data['month_count'] < 1 ){
    	echo 'Date range is invalid!';
    	exit;
    }

		$data['filter_by'] = ' &raquo; Date Range: '.$data['start_date'].' to '.$data['end_date'];
		
		$data['action_type'] = 'view';
  	if( $this->input->post('print') ){
  		$data['action_type'] = 'print';
  	}elseif( $this->input->post('export') ){
  		$data['action_type'] = 'csv';
  	}
  	

		$value = $this->load->view('report/print_fv_deferment_summary', $data, true);
		echo $value;
	}
	
	function fv_summary(){
		$url_prefix = $this->webspice->settings()->site_url_prefix;
		$data = null;

		$this->webspice->user_verify($url_prefix.'login', $url_prefix.'fv_summary');
		$this->webspice->permission_verify('fv_summary');

		$this->load->database();

		if( !$_POST ){
			$this->load->view('report/fv_summary', $data);
			return false;
		}

    # get input post
    $input = $this->webspice->get_input();

    # get bundle sale
    $sql_bundle_sale = "
    SELECT TBL_BUNDLE_SALE.*
    FROM TBL_BUNDLE_SALE
    WHERE TBL_BUNDLE_SALE.INVOICE_DATE LIKE '%".$input->report_month."%'
    AND TBL_BUNDLE_SALE.STATUS = 7
    ORDER BY TBL_BUNDLE_SALE.INVOICE_DATE
    ";
    $data['get_bundle_sale'] = $this->db->query($sql_bundle_sale)->result();
    if( !$data['get_bundle_sale'] ){
    	$this->webspice->message_board('There is no sale date found!');
    	$this->load->view('report/fv_summary', $data);
    	return false;
    }

		# get bundle item(s)
  	$sql_bundle_item = "
  	SELECT TBL_BUNDLE_ITEM.*,
  	TBL_BUNDLE_SERVICE.SERVICE_NAME, TBL_BUNDLE_SERVICE.PRICE_TYPE, TBL_BUNDLE_SERVICE.UNIT, TBL_BUNDLE_SERVICE.VAT_APPLICABLE, TBL_BUNDLE_SERVICE.GL_CODE
  	FROM TBL_BUNDLE_ITEM
  	LEFT JOIN TBL_BUNDLE_SERVICE ON TBL_BUNDLE_SERVICE.SERVICE_ID=TBL_BUNDLE_ITEM.SERVICE_ID
  	WHERE TBL_BUNDLE_ITEM.BUNDLE_ID IN(
	    SELECT TBL_BUNDLE_SALE.BUNDLE_ID
	    FROM TBL_BUNDLE_SALE
	    WHERE TBL_BUNDLE_SALE.INVOICE_DATE LIKE '%".$input->report_month."%'
	    AND TBL_BUNDLE_SALE.STATUS = 7
  	)
  	GROUP BY TBL_BUNDLE_ITEM.BUNDLE_ID, TBL_BUNDLE_ITEM.SERVICE_ID
  	";
  	$data['get_bundle_item'] = $this->db->query($sql_bundle_item)->result();
    if( !$data['get_bundle_item'] ){
    	$this->webspice->message_board('Bundle information could not found!');
    	$this->load->view('report/fv_summary', $data);
    	return false;
    }

		$data['filter_by'] = ' &raquo; Data Month: '. $this->webspice->month_convert(date("m",strtotime($input->report_month.'-01'))).', '.date("Y",strtotime($input->report_month.'-01'));
		
		$data['last_of_month'] = $this->webspice->first_of_month(date("Y",strtotime($input->report_month.'-01')), date("m",strtotime($input->report_month.'-01')));
		$data['last_of_month'] = $this->webspice->last_of_month(date("Y",strtotime($input->report_month.'-01')), date("m",strtotime($input->report_month.'-01')));
		

  	if( $this->input->post('view') ){
  		$data['action_type'] = 'view';
  		$value = $this->load->view('report/print_fv_summary', $data, true);
  		echo $value;
  		exit;
  		
  	}elseif( $this->input->post('print') ){
  		$data['action_type'] = 'print';
  		$value = $this->load->view('report/print_fv_summary', $data, true);
  		echo $value;
  		exit;
  		
  	}elseif( $this->input->post('export') ){
  		$data['action_type'] = 'csv';
  		$value = $this->load->view('report/print_fv_summary', $data, true);
  		echo $value;
  		exit;
  	}
		
		$this->load->view('report/fv_summary', $data);
	}
	
	function individual_jv(){
		$url_prefix = $this->webspice->settings()->site_url_prefix;
		
		$this->webspice->user_verify($url_prefix.'login', $url_prefix.'individual_jv');
		$this->webspice->permission_verify('individual_jv');

		if( !$_POST ){
			$this->load->view('report/individual_jv');
			return false;
		}
		
		# get post
		$input = $this->webspice->get_input();
		$report_month = $input->report_date;
		$data['report_month'] = $report_month;
		
		# get sale data according to given sale month
		$sql = "
		SELECT TBL_BUNDLE_SALE.*,
		TBL_BUNDLE.MRP
		FROM TBL_BUNDLE_SALE
		LEFT JOIN TBL_BUNDLE ON TBL_BUNDLE.BUNDLE_ID = TBL_BUNDLE_SALE.BUNDLE_ID
		WHERE TBL_BUNDLE_SALE.BUNDLE_ID = ?
		AND TBL_BUNDLE_SALE.STATUS = 7
		AND TBL_BUNDLE_SALE.INVOICE_DATE LIKE '%".$report_month."%'
		";
		$data['get_sale'] = $this->db->query($sql, array($input->bundle_id))->result();
		
		if( !$data['get_sale'] ){
			echo 'There is no sale happened according to your given month!';
			exit;
		}
		
		# get unique service id according to bundle id (by sale data)
		# get unique bundle id according to given sale month
		$sql = "
		SELECT TBL_BUNDLE_ITEM.*,
		TBL_BUNDLE_SERVICE.SERVICE_NAME, TBL_BUNDLE_SERVICE.GL_CODE, TBL_BUNDLE_SERVICE.VAT_APPLICABLE
		FROM TBL_BUNDLE_ITEM 
		LEFT JOIN TBL_BUNDLE_SERVICE ON TBL_BUNDLE_SERVICE.SERVICE_ID = TBL_BUNDLE_ITEM.SERVICE_ID
		WHERE TBL_BUNDLE_ITEM.BUNDLE_ID = ?
		GROUP BY TBL_BUNDLE_ITEM.SERVICE_ID
		";
		$data['get_service'] = $this->db->query($sql, array($input->bundle_id))->result();
		
		if( !$data['get_service'] ){
			echo 'There is no service found!';
			exit;
		}
		
		# get bundle item according to bundle id (given sale month)
		$sql = "
		SELECT TBL_BUNDLE_ITEM.*
		FROM TBL_BUNDLE_ITEM
		WHERE TBL_BUNDLE_ITEM.BUNDLE_ID = ?
		";
		$data['get_bundle_item'] = $this->db->query($sql, array($input->bundle_id))->result();
		
		$data['first_of_month'] = $this->webspice->first_of_month(date("Y",strtotime($report_month.'-01')), date("m",strtotime($report_month.'-01')));
		$data['last_of_month'] = $this->webspice->last_of_month(date("Y",strtotime($report_month.'-01')), date("m",strtotime($report_month.'-01')));
		
		$data['action_type'] = 'view';
  	if( $this->input->post('print') ){
  		$data['action_type'] = 'print';
  		
  	}elseif( $this->input->post('export') ){
  		$data['action_type'] = 'csv';
  	}
		
		$data['filter_by'] = 'Filter By: '.$this->webspice->month_convert( date('m',strtotime($report_month.'-15')) ).', '.date('Y',strtotime($report_month.'-15')).' &raquo; Bundle Name: '.$this->customcache->bundle_maker($input->bundle_id,'MATERIAL_NAME');
		
		if( $this->input->post('report_type')=='earned' ){
			$this->load->view('report/print_individual_jv', $data);
			
		}elseif( $this->input->post('report_type')=='unearned' ){
			$this->load->view('report/print_individual_jv_ur', $data);
		}
	}
	
	function summary_jv(){
		$url_prefix = $this->webspice->settings()->site_url_prefix;
		
		$this->webspice->user_verify($url_prefix.'login', $url_prefix.'summary_jv');
		$this->webspice->permission_verify('summary_jv');

		if( !$_POST ){
			$this->load->view('report/summary_jv');
			return false;
		}
		
		# get post
		$input = $this->webspice->get_input();
		$report_month = $input->report_date;
		$data['report_month'] = $report_month;
		
		# get sale data according to given sale month
		$sql = "
		SELECT TBL_BUNDLE_SALE.*,
		TBL_BUNDLE.MRP
		FROM TBL_BUNDLE_SALE
		LEFT JOIN TBL_BUNDLE ON TBL_BUNDLE.BUNDLE_ID = TBL_BUNDLE_SALE.BUNDLE_ID
		WHERE TBL_BUNDLE_SALE.STATUS = 7
		AND TBL_BUNDLE_SALE.INVOICE_DATE LIKE '%".$report_month."%'
		";
		$data['get_sale'] = $this->db->query($sql)->result();
		
		if( !$data['get_sale'] ){
			echo 'There is no sale happened according to your given month!';
			exit;
		}
		
		# get unique service id according to bundle id (by sale data)
		# get unique bundle id according to given sale month
		$sql = "
		SELECT TBL_BUNDLE_ITEM.*,
		TBL_BUNDLE_SERVICE.SERVICE_NAME, TBL_BUNDLE_SERVICE.GL_CODE, TBL_BUNDLE_SERVICE.VAT_APPLICABLE
		FROM TBL_BUNDLE_ITEM 
		LEFT JOIN TBL_BUNDLE_SERVICE ON TBL_BUNDLE_SERVICE.SERVICE_ID = TBL_BUNDLE_ITEM.SERVICE_ID
		GROUP BY TBL_BUNDLE_ITEM.SERVICE_ID
		";
		$data['get_service'] = $this->db->query($sql)->result();
		
		if( !$data['get_service'] ){
			echo 'There is no service found!';
			exit;
		}
		
		# get bundle item (given sale month)
		$sql = "
		SELECT TBL_BUNDLE_ITEM.*
		FROM TBL_BUNDLE_ITEM
		";
		$data['get_bundle_item'] = $this->db->query($sql)->result();
		
		$data['first_of_month'] = $this->webspice->first_of_month(date("Y",strtotime($report_month.'-01')), date("m",strtotime($report_month.'-01')));
		$data['last_of_month'] = $this->webspice->last_of_month(date("Y",strtotime($report_month.'-01')), date("m",strtotime($report_month.'-01')));
		
		$data['action_type'] = 'view';
  	if( $this->input->post('print') ){
  		$data['action_type'] = 'print';
  		
  	}elseif( $this->input->post('export') ){
  		$data['action_type'] = 'csv';
  	}
		
		$data['filter_by'] = 'Filter By: '.$this->webspice->month_convert( date('m',strtotime($report_month.'-15')) ).', '.date('Y',strtotime($report_month.'-15'));
		
		if( $this->input->post('report_type')=='earned' ){
			$this->load->view('report/print_summary_jv', $data);
			
		}elseif( $this->input->post('report_type')=='unearned' ){
			$this->load->view('report/print_summary_jv_ur', $data);
		}
	}
	
	function recognition_jv(){
		$url_prefix = $this->webspice->settings()->site_url_prefix;
		$data = null;

		$this->webspice->user_verify($url_prefix.'login', $url_prefix.'recognition_jv');
		$this->webspice->permission_verify('recognition_jv');

		$this->load->database();

		if( !$_POST ){
			$this->load->view('report/recognition_jv', $data);
			return false;
		}

    # get input post
    $input = $this->webspice->get_input();
    
    # get all Bundle
    $get_bundle = "
    SELECT TBL_BUNDLE.*
    FROM TBL_BUNDLE
    WHERE TBL_BUNDLE.STATUS = 2
   	";
   	$data['get_bundle_result'] = $this->db->query($get_bundle)->result();
   	if( !$data['get_bundle_result'] ){
   		echo 'There is no bundle found!';
   		exit;
   	}

  	# calculate date range
    $data['start_date'] = $this->webspice->first_of_month(date("Y",strtotime($input->report_date.'-01')), date("m",strtotime($input->report_date.'-01')));
    $data['end_date'] = $this->webspice->last_of_month(date("Y",strtotime($input->report_date.'-01')), date("m",strtotime($input->report_date.'-01')));

    $data['start_year'] = date("Y", strtotime($data['start_date']));
    $data['start_month'] = date("m", strtotime($data['start_date']));
    $data['month_count'] = $this->webspice->calculate_months_between_two_dates($data['start_date'], $data['end_date']);
    if( $data['month_count'] < 1 ){
    	echo 'Date range is invalid!';
    	exit;
    }

		$data['filter_by'] = ' &raquo; Date Range: '.$data['start_date'].' to '.$data['end_date'];
		
		$data['action_type'] = 'view';
  	if( $this->input->post('print') ){
  		$data['action_type'] = 'print';
  	}elseif( $this->input->post('export') ){
  		$data['action_type'] = 'csv';
  	}

		$value = $this->load->view('report/print_recognition_jv', $data, true);
		echo $value;
	}
	

	function bundle_channel_maker($sold_to_party_code){
		$code = substr($sold_to_party_code, 0, 4);
		
		if( (int)$sold_to_party_code >= 10000 && (int)$sold_to_party_code <= 50000 ){
			return 'RSP';	
			
		}elseif( $code == '8000' ){
			return 'SME/Corporate';
			
		}else{
			return 'WIC/CCC';
		}
		
	}
	
	# call confirmation for redirect another url with message
	function confirmation($message){
		$_SESSION['confirmation'] = $message;
		$this->webspice->force_redirect($this->webspice->settings()->site_url_prefix.'confirmation');
	}
	
	function show_confirmation(){
		if( !isset($_SESSION['confirmation']) ){
			$_SESSION['confirmation'] = array();	
		}
		$data = $_SESSION['confirmation'];
		$this->load->view('view_message',$data);
	}
	
}

/* End of file */
/* Location: ./application/controllers/ */