// JavaScript Document
jQuery(function(){
	
	});
function setVal(id)
{
	if(id == 'bpgts_group_type_search_field_3') {
		
		if(jQuery('#'+id).is(':checked'))
		{
			jQuery('#bpgts_group_type_search_field_1').val(1);
			jQuery('#bpgts_group_type_search_field_1').prop('checked', true);
			
			jQuery('#bpgts_group_type_search_field_2').val(1);
			jQuery('#bpgts_group_type_search_field_2').prop('checked', true);
			
			jQuery('#bpgts_group_type_search_field_3').val(1);
			jQuery('#bpgts_group_type_search_field_3').prop('checked', true);
		}
	}
	else
	{
		if(jQuery('#bpgts_group_type_search_field_1').is(':checked') && jQuery('#bpgts_group_type_search_field_2').is(':checked'))
		{			
			/*jQuery('#bpgts_group_type_search_field_1').val(0);
			jQuery('#bpgts_group_type_search_field_1').prop('checked', false);
			
			jQuery('#bpgts_group_type_search_field_2').val(0);
			jQuery('#bpgts_group_type_search_field_2').prop('checked', false);*/
			
			jQuery('#bpgts_group_type_search_field_3').val(1);
			jQuery('#bpgts_group_type_search_field_3').prop('checked', true);
		}
		else
		if(jQuery('#'+id).is(':checked'))
		{
			jQuery('#'+id).val(1);
			jQuery('#'+id).prop('checked', true);
			
			jQuery('#bpgts_group_type_search_field_3').val(0);
			jQuery('#bpgts_group_type_search_field_3').prop('checked', false);
		}
		else
		{
			jQuery('#'+id).val(0);
			jQuery('#'+id).prop('checked', false);
			jQuery('#bpgts_group_type_search_field_3').val(0);
			jQuery('#bpgts_group_type_search_field_3').prop('checked', false);
		}
	}
}
			