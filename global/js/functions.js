//<!--
var url_prefix = '/bundle/'; /*should be start and end with / (slash)*/
$(document).ready(function(){
	init();
});



init = function(){
	common_functions();
	
	if( $("#header_container").length ){
		header_footer();
	}
	
	var page = $('#wrapper').find('.page_identifier').attr('id');
	switch(page){
		case 'page_index': page_index(); break;
		case 'page_create_bundle': page_create_bundle(); break;
		case 'page_create_bundle_forecast': page_create_bundle_forecast(); break;
	}
	
	$("input[type=submit]").click(function(){
		$('.chzn-select,#nic_editor').hide();
	});
};


common_functions = function(){
	/*action confirmation*/
	$('.confirmation').live('click', function(){
		if(confirm('Do you really want to perform this action?')){
			return true;
		}else{
			return false;	
		}
	});
	
	/*chosen select box*/
	if(typeof chosen == 'function'){
		$('.chzn-select').chosen();
	}
	
	/*date picker*/
	$('.date_time_picker_24').datetimepicker({
		format:'Y-m-d H:i:s',
		 allowTimes:[
		  '00:00', '00:30', '01:00', '01:30',
		  '02:00', '02:30', '03:00', '03:30',
		  '04:00', '04:30', '05:00', '05:30',
		  '06:00', '06:30', '07:00', '07:30',
		  '08:00', '08:30', '09:00', '09:30',
		  '10:00', '10:30', '11:00', '11:30',
		  '12:00', '12:30', '13:00', '13:30',
		  '14:00', '14:30', '15:00', '15:30',
		  '16:00', '16:30', '17:00', '17:30',
		  '18:00', '18:30', '19:00', '19:30',
		  '20:00', '20:30', '21:00', '21:30',
		  '22:00', '22:30', '23:00', '23:30'
 		]
	});
	
	$('.date_picker').datetimepicker({timepicker:false,format:'Y-m-d'});
	$('.month_picker').datetimepicker({timepicker:false,format:'Y-m'});
	
	/*meassge show and hide after few milli-second*/
	if( $("#message_board").length ){
		$('#message_board').delay(9000).hide('slow');	
	}
	
	$('.refresh').live('click', function(){
		location.href = location.href;
	});
	
	$('.spin').hover(function(){
		$(this).animateRotate(360, 300);
	},function(){
		$(this).animateRotate(-360, 300);	
	});
	
	/*drop-down box -> for small screen*/
	$('.list_for_small_screen').change(function(){
		var get_title = $(this).val();
		if(get_title){
			location.href = get_title;
		}
	});
	
	/*custom place holder for input box*/
	$('.placeholder .caption').each(function(){
		var pre_obj = $(this).prev();
		var pos = pre_obj.position();
		$(this).css('top', (pos.top+4) );
		$(this).css('padding-top', pre_obj.css('padding-top'));
		$(this).css('padding-right', pre_obj.css('padding-right'));
		$(this).css('padding-bottom', pre_obj.css('padding-bottom'));
		$(this).css('padding-left', pre_obj.css('padding-left'));
	});

};

header_footer = function(){

};

page_index = function(){

};

page_create_bundle = function(){
	$('#type').change(function(){
		if( $(this).val()=='emi' ){
			$('.col_loop_day input').val('0');
			$('.col_loop_day').hide('slow');
		}else{
			$('.col_loop_day input').val('');
			$('.col_loop_day').show('slow');
		}
	});
	
	$('#frm_create_option').submit(function(){
		var row_1 = 0,row_2 = 0,row_3 = 0,row_4 = 0,row_5 = 0,row_6 = 0,row_7 = 0;
		
		$('.row_1').each(function(){
			if( $(this).val() ){ row_1++; }
		});
		
		$('.row_2').each(function(){
			if( $(this).val() ){ row_2++; }
		});
		
		$('.row_3').each(function(){
			if( $(this).val() ){ row_3++; }
		});
		
		$('.row_4').each(function(){
			if( $(this).val() ){ row_4++; }
		});
		
		$('.row_5').each(function(){
			if( $(this).val() ){ row_5++; }
		});
		
		$('.row_6').each(function(){
			if( $(this).val() ){ row_6++; }
		});
		
		$('.row_7').each(function(){
			if( $(this).val() ){ row_7++; }
		});
	
		var col_count = 4;
		if( $('#type').val()=='emi' ){ 
			col_count = 3;
			row_1 = row_1 - 1;
			row_2 = row_2 - 1;
			row_3 = row_3 - 1;
			row_4 = row_4 - 1;
			row_5 = row_5 - 1;
			row_6 = row_6 - 1;
			row_7 = row_7 - 1;
		}
		
		// verify at least one row filled		
		if( row_1 < col_count && row_2 < col_count && row_3 < col_count && row_4 < col_count && row_5 < col_count && row_6 < col_count && row_7 < col_count ){
			alert('Please fill-up at least one row for bundle item.');
			return false;
		}
		
		if( duplicate_chack('.bundle_item') ){
			alert('You are not allowed to select duplicate item name.');
			return false;
		}
		
		if( $('#type_1').val()=='loop' && ($('#type').val()!='emi' && parseInt($('#days_1').val()) < 1) ){ alert('Please complete row #1 by valid loop days.'); return false; }
		if( $('#type_2').val()=='loop' && ($('#type').val()!='emi' && parseInt($('#days_2').val()) < 1) ){ alert('Please complete row #2 by valid loop days.'); return false; }
		if( $('#type_3').val()=='loop' && ($('#type').val()!='emi' && parseInt($('#days_3').val()) < 1) ){ alert('Please complete row #3 by valid loop days.'); return false; }
		if( $('#type_4').val()=='loop' && ($('#type').val()!='emi' && parseInt($('#days_4').val()) < 1) ){ alert('Please complete row #4 by valid loop days.'); return false; }
		if( $('#type_5').val()=='loop' && ($('#type').val()!='emi' && parseInt($('#days_5').val()) < 1) ){ alert('Please complete row #5 by valid loop days.'); return false; }
		if( $('#type_6').val()=='loop' && ($('#type').val()!='emi' && parseInt($('#days_6').val()) < 1) ){ alert('Please complete row #6 by valid loop days.'); return false; }
		if( $('#type_7').val()=='loop' && ($('#type').val()!='emi' && parseInt($('#days_7').val()) < 1) ){ alert('Please complete row #7 by valid loop days.'); return false; }
		
		if( $('#quantity_1').val() && parseInt($('#quantity_1').val()) < 1 ){ alert('Please complete row #1 by valid quantity.'); return false; }
		if( $('#quantity_2').val() && parseInt($('#quantity_2').val()) < 1 ){ alert('Please complete row #2 by valid quantity.'); return false; }
		if( $('#quantity_3').val() && parseInt($('#quantity_3').val()) < 1 ){ alert('Please complete row #3 by valid quantity.'); return false; }
		if( $('#quantity_4').val() && parseInt($('#quantity_4').val()) < 1 ){ alert('Please complete row #4 by valid quantity.'); return false; }
		if( $('#quantity_5').val() && parseInt($('#quantity_5').val()) < 1 ){ alert('Please complete row #5 by valid quantity.'); return false; }
		if( $('#quantity_6').val() && parseInt($('#quantity_6').val()) < 1 ){ alert('Please complete row #6 by valid quantity.'); return false; }
		if( $('#quantity_7').val() && parseInt($('#quantity_7').val()) < 1 ){ alert('Please complete row #7 by valid quantity.'); return false; }
		
		if( row_1 && row_1 < col_count ){ alert('Please complete row #1 for bundle item'); return false; }
		if( row_2 && row_2 < col_count ){ alert('Please complete row #2 for bundle item'); return false; }
		if( row_3 && row_3 < col_count ){ alert('Please complete row #3 for bundle item'); return false; }
		if( row_4 && row_4 < col_count ){ alert('Please complete row #4 for bundle item'); return false; }
		if( row_5 && row_5 < col_count ){ alert('Please complete row #5 for bundle item'); return false; }
		if( row_6 && row_6 < col_count ){ alert('Please complete row #6 for bundle item'); return false; }
		if( row_7 && row_7 < col_count ){ alert('Please complete row #7 for bundle item'); return false; }

	});
};

page_create_bundle_forecast = function(){
	$('#type').change(function(){
		if( $(this).val()=='emi' ){
			$('.col_loop_day input').val('0');
			$('.col_loop_day').hide('slow');
		}else{
			$('.col_loop_day input').val('');
			$('.col_loop_day').show('slow');
		}
	});
	
	$('#frm_create_option').submit(function(){
		var row_1 = 0,row_2 = 0,row_3 = 0,row_4 = 0,row_5 = 0,row_6 = 0,row_7 = 0;
		
		$('.row_1').each(function(){
			if( $(this).val() ){ row_1++; }
		});
		
		$('.row_2').each(function(){
			if( $(this).val() ){ row_2++; }
		});
		
		$('.row_3').each(function(){
			if( $(this).val() ){ row_3++; }
		});
		
		$('.row_4').each(function(){
			if( $(this).val() ){ row_4++; }
		});
		
		$('.row_5').each(function(){
			if( $(this).val() ){ row_5++; }
		});
		
		$('.row_6').each(function(){
			if( $(this).val() ){ row_6++; }
		});
		
		$('.row_7').each(function(){
			if( $(this).val() ){ row_7++; }
		});
	
		var col_count = 4;
		if( $('#type').val()=='emi' ){ 
			col_count = 3;
			row_1 = row_1 - 1;
			row_2 = row_2 - 1;
			row_3 = row_3 - 1;
			row_4 = row_4 - 1;
			row_5 = row_5 - 1;
			row_6 = row_6 - 1;
			row_7 = row_7 - 1;
		}
		
		// verify at least one row filled		
		if( row_1 < col_count && row_2 < col_count && row_3 < col_count && row_4 < col_count && row_5 < col_count && row_6 < col_count && row_7 < col_count ){
			alert('Please fill-up at least one row for bundle item.');
			return false;
		}
		
		if( duplicate_chack('.bundle_item') ){
			alert('You are not allowed to select duplicate item name.');
			return false;
		}
		
		if( $('#type_1').val()=='loop' && ($('#type').val()!='emi' && parseInt($('#days_1').val()) < 1) ){ alert('Please complete row #1 by valid loop days.'); return false; }
		if( $('#type_2').val()=='loop' && ($('#type').val()!='emi' && parseInt($('#days_2').val()) < 1) ){ alert('Please complete row #2 by valid loop days.'); return false; }
		if( $('#type_3').val()=='loop' && ($('#type').val()!='emi' && parseInt($('#days_3').val()) < 1) ){ alert('Please complete row #3 by valid loop days.'); return false; }
		if( $('#type_4').val()=='loop' && ($('#type').val()!='emi' && parseInt($('#days_4').val()) < 1) ){ alert('Please complete row #4 by valid loop days.'); return false; }
		if( $('#type_5').val()=='loop' && ($('#type').val()!='emi' && parseInt($('#days_5').val()) < 1) ){ alert('Please complete row #5 by valid loop days.'); return false; }
		if( $('#type_6').val()=='loop' && ($('#type').val()!='emi' && parseInt($('#days_6').val()) < 1) ){ alert('Please complete row #6 by valid loop days.'); return false; }
		if( $('#type_7').val()=='loop' && ($('#type').val()!='emi' && parseInt($('#days_7').val()) < 1) ){ alert('Please complete row #7 by valid loop days.'); return false; }
		
		if( $('#quantity_1').val() && parseInt($('#quantity_1').val()) < 1 ){ alert('Please complete row #1 by valid quantity.'); return false; }
		if( $('#quantity_2').val() && parseInt($('#quantity_2').val()) < 1 ){ alert('Please complete row #2 by valid quantity.'); return false; }
		if( $('#quantity_3').val() && parseInt($('#quantity_3').val()) < 1 ){ alert('Please complete row #3 by valid quantity.'); return false; }
		if( $('#quantity_4').val() && parseInt($('#quantity_4').val()) < 1 ){ alert('Please complete row #4 by valid quantity.'); return false; }
		if( $('#quantity_5').val() && parseInt($('#quantity_5').val()) < 1 ){ alert('Please complete row #5 by valid quantity.'); return false; }
		if( $('#quantity_6').val() && parseInt($('#quantity_6').val()) < 1 ){ alert('Please complete row #6 by valid quantity.'); return false; }
		if( $('#quantity_7').val() && parseInt($('#quantity_7').val()) < 1 ){ alert('Please complete row #7 by valid quantity.'); return false; }
		
		if( row_1 && row_1 < col_count ){ alert('Please complete row #1 for bundle item'); return false; }
		if( row_2 && row_2 < col_count ){ alert('Please complete row #2 for bundle item'); return false; }
		if( row_3 && row_3 < col_count ){ alert('Please complete row #3 for bundle item'); return false; }
		if( row_4 && row_4 < col_count ){ alert('Please complete row #4 for bundle item'); return false; }
		if( row_5 && row_5 < col_count ){ alert('Please complete row #5 for bundle item'); return false; }
		if( row_6 && row_6 < col_count ){ alert('Please complete row #6 for bundle item'); return false; }
		if( row_7 && row_7 < col_count ){ alert('Please complete row #7 for bundle item'); return false; }

	});
};

function duplicate_chack(class_name) {
  var selects = $(class_name);
  var values = [];
  for(i=0;i<selects.length;i++) {
    var select = selects[i];
    if(values.indexOf(select.value)>-1) {
    	return true; break;
    }else{
    	if(select.value){
    		values.push(select.value);
    	}
    }
  }
  
  return false;
}

//check the parameter value is number or not
IsNumeric = function(num){
	var ValidChars = "0123456789";
	var IsNumber = true;
	var Char;
	
	for(i = 0; i < num.length && IsNumber == true; i++) { 
		Char = num.charAt(i); 
		if( ValidChars.indexOf(Char) == -1){
			IsNumber = false;
		}
	}
	return IsNumber;
};

IsFloat = function(num){
	var ValidChars = "0123456789.";
	var IsNumber = true;
	var Char;
	
	for(i = 0; i < num.length && IsNumber == true; i++) { 
		Char = num.charAt(i); 
		if( ValidChars.indexOf(Char) == -1){
			IsNumber = false;
		}
	}
	
	if( IsNumber && !isNaN ( parseFloat ( num )) ) {
		return true;
	}
	
	return false;
};

//check email address is valid or not
checkemail = function(val){
	//return (val.indexOf(".") > 2) && (val.indexOf("@") > 0);
	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	var address = val;
	if(reg.test(address) == false) {
	  return false;
	}

	return true;
};

//-->