<?php 
add_action('init', 'team_init');  
/* SECTION - project_custom_init */  
function team_init()  
{  
    $labels = array(  
    'name' => _x('Team Members', 'post type general name', 'asalah'),  
    'singular_name' => _x('Team Member', 'post type singular name', 'asalah'),  
    'add_new' => _x('Add New', 'project', 'asalah'),  
    'add_new_item' => __('Add New Project', 'asalah'),  
    'edit_item' => __('Edit Member', 'asalah'),  
    'new_item' => __('New Member', 'asalah'),  
    'view_item' => __('View Member', 'asalah'),  
    'search_items' => __('Search Members', 'asalah'),  
    'not_found' =>  __('No members found', 'asalah'),  
    'not_found_in_trash' => __('No members found in Trash', 'asalah'),  
    'parent_item_colon' => '',  
    'menu_name' => 'Team Members'  
	);  
	// Some arguments and in the last line 'supports', we say to WordPress what features are supported on the member post type  
	$args = array(  
		'labels' => $labels,  
		'public' => true,  
		'publicly_queryable' => true,  
		'show_ui' => true,  
		'show_in_menu' => true,  
		'query_var' => true,  
		'rewrite' => true,  
		'capability_type' => 'post',  
		'has_archive' => true,  
		'hierarchical' => false,  
		'menu_position' => null,  
		'supports' => array('title','editor','thumbnail')  
	);  
	// We call this function to register the custom post type  
	register_post_type('team',$args);   
}  

/*--- Custom Messages - project_updated_messages ---*/  
add_filter('post_updated_messages', 'team_updated_messages');  
function team_updated_messages( $messages ) {  
  global $post, $post_ID;  
  $messages['team'] = array(  
    0 => '', // Unused. Messages start at index 1.  
    1 => sprintf( __('Member updated. <a href="%s">View member</a>', 'asalah'), esc_url( get_permalink($post_ID) ) ),  
    2 => __('Custom field updated.', 'asalah'),  
    3 => __('Custom field deleted.', 'asalah'),  
    4 => __('Member updated.', 'asalah'),  
    /* translators: %s: date and time of the revision */  
    5 => isset($_GET['revision']) ? sprintf( __('Member restored to revision from %s', 'asalah'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,  
    6 => sprintf( __('Member published. <a href="%s">View member</a>', 'asalah'), esc_url( get_permalink($post_ID) ) ),  
    7 => __('Member saved.', 'asalah'),  
    8 => sprintf( __('Member submitted. <a target="_blank" href="%s">Preview member</a>', 'asalah'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),  
    9 => sprintf( __('Member scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview member</a>', 'asalah'),  
      // translators: Publish box date format, see http://php.net/date  
      date_i18n( __( 'M j, Y @ G:i' , 'asalah'), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),  
    10 => sprintf( __('Member draft updated. <a target="_blank" href="%s">Preview member</a>', 'asalah'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),  
  );  
  return $messages;  
}
?>