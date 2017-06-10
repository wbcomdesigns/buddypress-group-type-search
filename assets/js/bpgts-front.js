jQuery(document).ready(function() {

	jQuery(document).on('click', '#bpgts-groups-search', function() {
		var page_no = 1;
		jQuery('#bpgts-group-page-no').val(page_no);
		bpgts_getGroups();
	});

	jQuery(document).on('keypress', '#bpgts-groups-search-txt', function(e) {
        if(e.which == 13) { //Enter key pressed
            jQuery('#bpgts-groups-search').trigger('click');//Trigger search button click event
        }
    });

});

function bpgts_goto_page(page_no)
{
	jQuery('#bpgts-group-page-no').val(page_no);
	bpgts_getGroups();
}

function bpgts_getGroups()
{
		var search_txt = jQuery( '#bpgts-groups-search-txt' ).val();
		var group_type = jQuery('#bpgts-group-type').find(":selected").val();
		var groups_order_by = jQuery( '#groups-order-by' ).val();
		var group_page_no = jQuery( '#bpgts-group-page-no' ).val();
		var group_per_page = jQuery( '#bpgts-group-per-page' ).val();
		if( search_txt == '' && group_type == '' ) {
			jQuery( '.bpgts-input-error' ).fadeIn('slow').delay(10000);
			jQuery( '.bpgts-input-error' ).fadeOut('slow');
		} else {
			jQuery('.ajax-loader').show();
			jQuery.post(
				ajaxurl,
				{
					'action' : 'bgf_search_groups',
					'search_txt' : search_txt,
					'group_type' : group_type,
					'groups_order_by' : groups_order_by,
					'group_page_no' : group_page_no,
					'group_per_page' : group_per_page
				},
				function( response ) {					
					jQuery('.ajax-loader').hide();
					var html = '';
					if( response['found'] == 'no' ) {
						var msg = response['msg'];
						html = '<p class="groups-not-found">'+msg+'</p>';
						jQuery( '#groups-dir-list' ).html( html );
					} 
					else if( response['found'] == 'yes' ) 
					{
						var groups = response['groups'];
						var groups_count = groups.length;
						var total = response['total'];						
						var grp_class = '';
						var li_html = '';
						
						html += '<div id="pag-bottom" class="pagination">';
						html += '<div class="pag-count" id="group-dir-count-bottom">';
						if(groups_count < group_per_page )
							html += 'Viewing ' + ((group_page_no - 1) * group_per_page + 1) + ' - '+ total +' of '+total+' groups';
						else
							html += 'Viewing ' + ((group_page_no - 1) * group_per_page + 1) + ' - ' + (group_page_no * groups_count) +' of '+ total +' groups';
						html += '</div>';
						html += '<div class="pagination-links" id="group-dir-pag-bottom">';

						if(Math.ceil(total/group_per_page) > 1) {
							var active = '';
							html += '<ul class="bpgts-group-paging">';
							
							if(group_page_no > 1) {
								html += "<li class='prev page-numbers' onClick='bpgts_goto_page(" + (parseInt(group_page_no) - 1) + ")'>"+ '← ' + "</li>";
								html += '<li>&nbsp</li>';
							}
							
							for(i=1; i<=Math.ceil(total/group_per_page); i++) {
								if(group_page_no == i) active = 'bpgts_group_page_no_class'; else active = '';
								html += "<li class='" + active + "' id='group-page-" + i + "' onClick='bpgts_goto_page(" + i + ")'>" + i + "</li>";
							}
							if(group_page_no < i-1) {
								html += "<li class='next page-numbers' onClick='bpgts_goto_page(" + (parseInt(group_page_no) + 1) + ")'>"+ '→' + "</li>";								
							}
							
							html += '</ul>';
						}

						html += '</div>';
						html += '</div>';
						
						jQuery( '#group-dir-count-top, #group-dir-count-bottom' ).html();
						
						for( i in groups ) {
							var id = groups[i]['id'];
							var title = groups[i]['title'];
							var desc = groups[i]['description'];
							var status = groups[i]['status'];
							var member_str = groups[i]['member_str'];
							var permalink = groups[i]['permalink'];
							var thumbnail = groups[i]['thumbnail'];last_active
							var last_active = groups[i]['last_active'];
							++i;
							if( i % 2 == 0 ) {
								grp_class = 'even';
							} else {
								grp_class = 'odd';
							}
							//Create Groups Loop HTML
							li_html += '<li class="'+grp_class+' public is-admin is-member group-has-avatar">';
								li_html += '<div class="item-avatar">';
									li_html += '<a href="'+permalink+'">';
										li_html += '<img src="'+thumbnail+'" class="avatar group-2-avatar avatar-50 photo" alt="Group logo of '+title+'" title="'+title+'" width="50" height="50">';
									li_html += '</a>';
								li_html += '</div>';
								li_html += '<div class="item">';
									li_html += '<div class="item-title"><a href="'+permalink+'">'+title+'</a></div>';
									li_html += '<div class="item-meta"><span class="activity">'+last_active+'</span></div>';
									li_html += '<div class="item-desc"><p>'+desc+'</p></div>';
								li_html += '</div>';
								li_html += '<div class="action"><div class="meta">'+status+' Group / '+member_str+'</div></div>';
								li_html += '<div class="clear"></div>';

							li_html += '</li>';
						}

						var ul_html = '<ul id="groups-list" class="item-list" aria-live="assertive" aria-atomic="true" aria-relevant="all">'+li_html+'</ul>';

						html += ul_html;

						html += '<div id="pag-bottom" class="pagination">';
						html += '<div class="pag-count" id="group-dir-count-bottom">';
						if(groups_count < group_per_page )
							html += 'Viewing ' + ((group_page_no - 1) * group_per_page + 1) + ' - '+ total +' of '+total+' groups';
						else
							html += 'Viewing ' + ((group_page_no - 1) * group_per_page + 1) + ' - ' + (group_page_no * groups_count) +' of '+ total +' groups';
						html += '</div>';
						html += '<div class="pagination-links" id="group-dir-pag-bottom">';

						if(Math.ceil(total/group_per_page) > 1) {
							var active = '';
							html += '<ul class="bpgts-group-paging">';
							
							if(group_page_no > 1) {
								html += "<li class='prev page-numbers' onClick='bpgts_goto_page(" + (parseInt(group_page_no) - 1) + ")'>"+ '← ' + "</li>";
								html += '<li>&nbsp</li>';
							}
							
							for(i=1; i<=Math.ceil(total/group_per_page); i++) {
								if(group_page_no == i) active = 'bpgts_group_page_no_class'; else active = '';
								html += "<li class='" + active + "' id='group-page-" + i + "' onClick='bpgts_goto_page(" + i + ")'>" + i + "</li>";
							}
							if(group_page_no < i-1) {
								html += "<li class='next page-numbers' onClick='bpgts_goto_page(" + (parseInt(group_page_no) + 1) + ")'>"+ '→' + "</li>";								
							}
							
							html += '</ul>';
						}

						html += '</div>';
						html += '</div>';
						
						jQuery( '#groups-dir-list' ).html( html );
						
					}
					console.log( response );
				},
				"JSON"
			);
		}
}
