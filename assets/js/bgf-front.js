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
							html += '<li class="'+grp_class+' public is-admin is-member group-has-avatar">';
								html += '<div class="item-avatar">';
									html += '<a href="'+permalink+'">';
										html += '<img src="'+thumbnail+'" class="avatar group-2-avatar avatar-50 photo" alt="Group logo of '+title+'" title="'+title+'" width="50" height="50">';
									html += '</a>';
								html += '</div>';
								html += '<div class="item">';
									html += '<div class="item-title"><a href="'+permalink+'">'+title+'</a></div>';
									html += '<div class="item-meta"><span class="activity">'+last_active+'</span></div>';
									html += '<div class="item-desc"><p>'+desc+'</p></div>';
								html += '</div>';
								html += '<div class="action"><div class="meta">'+status+' Group / '+member_str+'</div></div>';
								html += '<div class="clear"></div>';
							html += '</li>';
						}
						jQuery( '#groups-list' ).html( html );
						jQuery( '#group-dir-count-top, #group-dir-count-bottom' ).html( 'Viewing 1 - '+groups_count+' of '+groups_count+' groups' );
					}
					console.log( response );
				},
				"JSON"
			);
		}
	});
});