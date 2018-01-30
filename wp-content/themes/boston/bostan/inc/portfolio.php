<?php
add_action('init', 'portfolio_init');
/* SECTION - project_custom_init */
function portfolio_init()
{
    $labels = array(
    'name' => _x('Projects', 'post type general name', 'asalah'),
    'singular_name' => _x('Project', 'post type singular name', 'asalah'),
    'add_new' => _x('Add New', 'project', 'asalah'),
    'add_new_item' => __('Add New Project', 'asalah'),
    'edit_item' => __('Edit Project', 'asalah'),
    'new_item' => __('New Project', 'asalah'),
    'view_item' => __('View Project', 'asalah'),
    'search_items' => __('Search Projects', 'asalah'),
    'not_found' =>  __('No projects found', 'asalah'),
    'not_found_in_trash' => __('No projects found in Trash', 'asalah'),
    'parent_item_colon' => '',
    'menu_name' => 'Portfolio'
	);
	// Some arguments and in the last line 'supports', we say to WordPress what features are supported on the Project post type
  $portfolio_slug = "project";
    if ( function_exists( 'asalah_option' ) ) :
        if (asalah_option('asalah_portfolio_slug') != "") {
            $portfolio_slug = asalah_option('asalah_portfolio_slug');
        }
    endif;
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
		'supports' => array('title','editor','author','thumbnail','excerpt','comments','post-formats'),
    'rewrite' => array(
            'slug' => $portfolio_slug
        )
	);
	// We call this function to register the custom post type
	register_post_type('project',$args);

	$labels = array(
    'name' => _x( 'Tags', 'taxonomy general name', 'asalah' ),
    'singular_name' => _x( 'Tag', 'taxonomy singular name', 'asalah' ),
    'search_items' =>  __( 'Search Types', 'asalah' ),
    'all_items' => __( 'All Tags', 'asalah' ),
    'parent_item' => __( 'Parent Tag', 'asalah' ),
    'parent_item_colon' => __( 'Parent Tag:', 'asalah' ),
    'edit_item' => __( 'Edit Tags', 'asalah' ),
    'update_item' => __( 'Update Tag', 'asalah' ),
    'add_new_item' => __( 'Add New Tag', 'asalah' ),
    'new_item_name' => __( 'New Tag Name', 'asalah' ),
	);
	// Register Custom Taxonomy
	register_taxonomy('tagportfolio',array('project'), array(
		'hierarchical' => true, // define whether to use a system like tags or categories
		'labels' => $labels,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'tag-portfolio' ),
	));
}

/*--- Custom Messages - project_updated_messages ---*/
add_filter('post_updated_messages', 'project_updated_messages');
function project_updated_messages( $messages ) {
  global $post, $post_ID;
  $messages['project'] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => sprintf( __('Project updated. <a href="%s">View project</a>'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.', 'asalah'),
    3 => __('Custom field deleted.', 'asalah'),
    4 => __('Project updated.', 'asalah'),
    /* translators: %s: date and time of the revision */
    5 => isset($_GET['revision']) ? sprintf( __('Project restored to revision from %s', 'asalah'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Project published. <a href="%s">View project</a>'), esc_url( get_permalink($post_ID) ) ),
    7 => __('Project saved.', 'asalah'),
    8 => sprintf( __('Project submitted. <a target="_blank" href="%s">Preview project</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('Project scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview project</a>'),
      // translators: Publish box date format, see http://php.net/date
      date_i18n( __( 'M j, Y @ G:i', 'asalah' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('Project draft updated. <a target="_blank" href="%s">Preview project</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );
  return $messages;
}
/*--- #end SECTION - project_updated_messages ---*/


/*--- Demo URL meta box ---*/
add_action('admin_init','portfolio_meta_init');
function portfolio_meta_init()
{
    // add a meta box for WordPress 'project' type
    add_meta_box('portfolio_meta', 'Project Infos', 'portfolio_meta_setup', 'project', 'side', 'low');
    // add a callback function to save any data a user enters in
    add_action('save_post','portfolio_meta_save');
}
function portfolio_meta_setup()
{
    global $post;
    ?>
        <div class="portfolio_meta_control">
            <label>URL</label>
            <p>
                <input type="text" name="project_url" value="<?php echo get_post_meta($post->ID,'project_url',TRUE); ?>" style="width: 100%;" />
            </p>
            <label>Text (leave blank for default)</label>
            <p>
                <input type="text" name="asalah_preview_button_text" value="<?php echo get_post_meta($post->ID,'asalah_preview_button_text',TRUE); ?>" style="width: 100%;" />
            </p>
        </div>
    <?php
    // create for validation
    echo '<input type="hidden" name="meta_noncename" value="' . wp_create_nonce(__FILE__) . '" />';
}
function portfolio_meta_save($post_id)
{
    // check nonce
    if (!isset($_POST['meta_noncename']) || !wp_verify_nonce($_POST['meta_noncename'], __FILE__)) {
    return $post_id;
    }
    // check capabilities
    if ('post' == $_POST['post_type']) {
    if (!current_user_can('edit_post', $post_id)) {
    return $post_id;
    }
    } elseif (!current_user_can('edit_page', $post_id)) {
    return $post_id;
    }
    // exit on autosave
    if (defined('DOING_AUTOSAVE') == DOING_AUTOSAVE) {
    return $post_id;
    }
    if(isset($_POST['project_url']))
    {
        update_post_meta($post_id, 'project_url', $_POST['project_url']);
    } else
    {
        delete_post_meta($post_id, 'project_url');
    }
    if(isset($_POST['asalah_preview_button_text']))
    {
        update_post_meta($post_id, 'asalah_preview_button_text', $_POST['asalah_preview_button_text']);
    } else
    {
        delete_post_meta($post_id, 'asalah_preview_button_text');
    }
}
/*--- #end  Demo URL meta box ---*/

function project_url() {
	global $post;
	$url = get_post_meta($post->ID, 'project_url', true);
  $text = 'Live Preview →';
  if (get_post_meta($post->ID, 'project_url_text', true) != '') {
    $text = get_post_meta($post->ID, 'project_url_text', true);
  }
	if ($url) {
		?>
		<a href="<?php echo $url; ?>" target="_blank"><?php echo $text; ?></a>
        <?php
	}
}

function asalah_portfolio_tag() {
    global $post;
    $terms = get_the_terms( $post->ID, 'tagportfolio' );
    if ( $terms && ! is_wp_error( $terms ) ) :
        $links = array();
        foreach ( $terms as $term )
        {
            $links[] = "portfoliotagfilter-".$term->name;
        }
        $links = str_replace(' ', '-', $links);
        $tax = join( " ", $links );
    else :
        $tax = '';
    endif;
    echo strtolower($tax);
}

function asalah_portfolio_tag_list() {
    $terms = get_terms("tagportfolio");
    $count = count($terms);
    global $wp_query;


    echo '<ul id="filters" class="option-set nav" data-option-key="filter">';
    echo '<li class="active"><a href="#filter" data-option-value=".showallposts" data-postsperpage="'.$wp_query->post_count.'" data-cycle="1">';
    $project_show = (!empty($asalah_data['asalah_translate_showall'])) ? $asalah_data['asalah_translate_showall'] : 'Show all' ;
    echo $project_show;
    echo '</a></li>';
        if ( $count > 0 )
        {
            foreach ( $terms as $term ) {
                $termname = strtolower($term->name);
                $termname = str_replace(' ', '-', $termname);
				$termname =  "portfoliotagfilter-".$termname;
				echo '<li><a href="#filter" data-termpostcount="'.$term->count.'" data-tag="'.$term->name.'" data-posttype="project" data-taglink="'.get_term_link($term).'" data-postsperpage="'.$wp_query->post_count.'" data-totalpages="'.$wp_query->max_num_pages.'" data-cycle="1" data-loopfile="project-content.php" data-pageid="" data-option-value=".'.$termname.'">'.$term->name.'</a></li>';
            }
        }
    echo "</ul>";
}
?>