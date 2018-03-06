<?php 
add_action('init', 'pricing_init');  
/* SECTION - project_custom_init */  
function pricing_init()  
{  
    $labels = array(
        'name' => _x( 'Pricing Packages','', 'asalah' ),
        'singular_name' => _x( 'Pricing Package','', 'asalah' ),
        'add_new' => _x( 'Add New','', 'asalah' ),
        'add_new_item' => _x( 'Add New Pricing Package','', 'asalah' ),
        'edit_item' => _x( 'Edit Pricing Package','', 'asalah' ),
        'new_item' => _x( 'New Pricing Package','', 'asalah' ),
        'view_item' => _x( 'View Pricing Package','', 'asalah' ),
        'search_items' => _x( 'Search Pricing Packages','', 'asalah' ),
        'not_found' => _x( 'No Pricing Packages found','', 'asalah' ),
        'not_found_in_trash' => _x( 'No Pricing Packages found in Trash','', 'asalah' ),
        'parent_item_colon' => _x( 'Parent Pricing Package:','', 'asalah' ),
        'menu_name' => _x( 'Pricing Packages','', 'asalah' ),'',
    );
 
    $args = array(
        'labels' => $labels,
        'hierarchical' => false,
        'description' => 'Pricing Packages',
        'supports' => array( 'title', 'editor' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );
	// We call this function to register the custom post type  
	register_post_type('pricing_packages',$args);  
	
}  


add_action( 'add_meta_boxes', 'wppt_pricing_packages_meta_boxes' );
 
function wppt_pricing_packages_meta_boxes() {
 
    add_meta_box( "pricing-package-info", "Pricing Package Info", 'wppt_generate_pricing_package_info', "pricing_packages", "normal", "high" );
    add_meta_box( "pricing-features-info", "Pricing Features", 'wppt_generate_pricing_features_info', "pricing_packages", "normal", "high" );
 
}

function wppt_generate_pricing_package_info() {
    global $post;
 
    $package_price = get_post_meta( $post->ID, "_package_price", true );
    $package_buy_link = get_post_meta( $post->ID, "_package_buy_link", true );
 
    $html = '<input type="hidden" name="pricing_package_box_nonce" value="' . wp_create_nonce( basename( __FILE__ ) ) . '" />';
 
    $html .= '<table class="form-table">';
 
    $html .= '<tr>';
    $html .= '  <th><label for="Price">Package Price *</label></th>';
    $html .= '  <td>';
    $html .= '      <input name="package_price" id="package_price" type="text" value="' . $package_price . '" />';
    $html .= '  </td>';
    $html .= '</tr>';
 
    $html .= '<tr>';
    $html .= '  <th><label for="Buy Now">Buy Now Link *</label></th>';
    $html .= '  <td>';
    $html .= '      <input name="package_buy_link" id="package_buy_link" type="text" value="' . $package_buy_link . '" />';
    $html .= '  </td>';
    $html .= '</tr>';
 
    $html .= '</tr>';
    $html .= '</table>';
 
    echo $html;
}

function wppt_generate_pricing_features_info() {
 
    global $post;
 
    $package_features = get_post_meta( $post->ID, "_package_features", true );
    $package_features = ( $package_features == '' ) ? array() : json_decode( $package_features );
    $html .= '<table class="form-table">';
 
    $html .= '<tr><th><label for="Price">Add Package Features</label></th>';
    $html .= '  <td>';
    $html .= '      <input name="package_feature" id="package_feature" type="text"  />';
    $html .= '      <input type="button" id="add_features" value="Add Features" />';
    $html .= '  </td></tr>';
 
    $html .= '<tr><td>';
    $html .= '    <ul id="package_features_box" name="package_features_box" >';
    foreach ($package_features as $package_feature) {
        $html .= '<li><input type="hidden" name="package_features[]" value="' . $package_feature . '" />' . $package_feature . '';
        $html .= '<a href="javascript:void(0);">Delete</a></li>';
    }
    $html .= '</ul></td></tr>';
 
    $html .= '</table>';
 
    echo $html;
}

add_action( 'save_post', 'wppt_save_pricing_packages' );
 
function wppt_save_pricing_packages( $post_id ) {
 
    if ( ! wp_verify_nonce( $_POST['pricing_package_box_nonce'], basename( __FILE__ ) ) ) {
        return $post_id;
    }
 
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return $post_id;
    }
 
    if ( 'pricing_packages' == $_POST['post_type'] && current_user_can( 'edit_post', $post_id ) ) {
        $package_price = ( isset( $_POST['package_price'] ) ? $_POST['package_price'] : '' );
        $package_buy_link = ( isset( $_POST['package_buy_link'] ) ? $_POST['package_buy_link'] : '' );
 
        $package_features = ( isset( $_POST['package_features'] ) ? $_POST['package_features'] : array() );
        $package_features = json_encode( $package_features );
 
        update_post_meta( $post_id, "_package_price", $package_price );
        update_post_meta( $post_id, "_package_buy_link", $package_buy_link );
        update_post_meta( $post_id, "_package_features", $package_features );
    }
    else {
        return $post_id;
    }
}

add_action( 'add_meta_boxes', 'wppt_pricing_tables_meta_boxes' );
 
function wppt_pricing_tables_meta_boxes() {
 
    add_meta_box( "pricing-table-info", "Pricing Table Info", 'wppt_generate_pricing_table_info', "pricing_tables", "normal", "high" );
}
 
function wppt_generate_pricing_table_info() {
    global $post;
 
    $table_packages = get_post_meta( $post->ID, "_table_packages", true );
    $table_packages = ( $table_packages == '' ) ? array() : json_decode( $table_packages );
 
    $query = new WP_Query( array(
        'post_type' => 'pricing_packages',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'orderby' => 'post_date',
        'order' => 'ASC'
    ) );
 
    $html = '<input type="hidden" name="pricing_table_box_nonce" value="' . wp_create_nonce( basename( __FILE__ ) ) . '" />';
 
    $html .= '<table class="form-table">';
    $html .= '<tr><th>Package Status</th>';
    $html .= '    <td>Package Name</td></tr>';
 
    while ( $query->have_posts() ) : $query->the_post();
        $checked_status = ( in_array( $query->post->ID, $table_packages ) ) ? "checked" : "";
 
        $html .= '<tr><th><input type="checkbox" name="pricing_table_packages[]" ' . $checked_status . ' value="' . $query->post->ID . '" /></th>';
        $html .= '    <td>' . $query->post->post_title . '</td></tr>';
 
    endwhile;
 
    $html .= '</table>';
 
    echo $html;
}

function wppt_pricing_admin_scripts() {
 
    wp_register_script( 'pricing-admin', get_template_directory_uri() . '/js/pricing_admin.js', array( 'jquery' ) );
    wp_enqueue_script( 'pricing-admin' );
}
 
add_action( 'admin_enqueue_scripts', 'wppt_pricing_admin_scripts' );

add_filter( 'manage_edit-pricing_tables_columns', 'wppt_edit_pricing_tables_columns' );
 
function wppt_edit_pricing_tables_columns( $columns ) {
 
    $columns = array(
        'cb' => '<input type="checkbox" />',
        'ID' => __( 'Pricing Table ID' , 'asalah'),
        'title' => __( 'Pricing Table Name' , 'asalah'),
        'date' => __( 'Date' , 'asalah')
    );
 
    return $columns;
}

add_action( 'manage_pricing_tables_posts_custom_column', 'wppt_manage_pricing_tables_columns', 10, 2 );
 
function wppt_manage_pricing_tables_columns( $column, $post_id ) {
    global $post;
 
    switch ( $column ) {
 
        case 'ID' :
 
            $pricing_id = $post_id;
 
            if ( empty( $pricing_id ) )
                echo __( 'Unknown' , 'asalah');
 
            else
                printf( $pricing_id );
 
            break;
 
        default :
            break;
    }
}
 
add_filter( 'manage_edit-pricing_tables_sortable_columns', 'wppt_pricing_tables_sortable_columns' );
 
function wppt_pricing_tables_sortable_columns( $columns ) {
 
    $columns['ID'] = 'ID';
 
    return $columns;
}
?>