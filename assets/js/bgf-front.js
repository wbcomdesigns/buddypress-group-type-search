jQuery(document).ready(function(){
	jQuery(document).on('click', '#bgf-groups-search', function(){
		
		var search_txt = jQuery( '#bgf-groups-search-txt' ).val();
		var group_type = jQuery( '#group-type' ).val();
		if( search_txt == '' && group_type == '' ) {
			jQuery( '.bgf-input-error' ).fadeIn('slow').delay(10000);
			jQuery( '.bgf-input-error' ).fadeOut('slow');
		} else {
			jQuery('.ajax-loader').show();
			jQuery.post(
				ajaxurl,
				{
					'action' : 'bgf_search_groups',
					'search_txt' : search_txt,
					'group_type' : group_type
				},
				function( response ) {
					jQuery('.ajax-loader').hide();
					var html = '';
					if( response['found'] == 'no' ) {
						var msg = response['msg'];
						html = '<p class="groups-not-found">'+msg+'</p>';
						jQuery( '#groups-dir-list' ).html( html );
					} else if( response['found'] == 'yes' ) {
						var groups = response['groups'];
						var groups_count = groups.length;
						var grp_class = '';
						var li_html = '';

						jQuery( '#group-dir-count-top, #group-dir-count-bottom' ).html(  );

						
						html += '<div id="pag-top" class="pagination">';
						html += '<div class="pag-count" id="group-dir-count-top">';
						html += 'Viewing 1 - '+groups_count+' of '+groups_count+' groups';
						html += '</div>';
						html += '<div class="pagination-links" id="group-dir-pag-top">';
						html += '</div>';
						html += '</div>';


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
							if( i % 2 == 0 ){
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
						html += 'Viewing 1 - '+groups_count+' of '+groups_count+' groups';
						html += '</div>';
						html += '<div class="pagination-links" id="group-dir-pag-bottom">';
						html += '</div>';
						html += '</div>';

						jQuery( '#groups-dir-list' ).html( html );
					}
					console.log( response );
				},
				"JSON"
			);
		}
	});
});