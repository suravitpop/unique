<?php
$themename = "Bostan";
$shortname = "asalah";
define('theme_name', $themename);
define('theme_ver', 1);
include (TEMPLATEPATH . '/framework/wp-pricing-table/index.php');
include (TEMPLATEPATH . '/inc/scripts.php');
include (TEMPLATEPATH . '/inc/shortcodes.php');
include (TEMPLATEPATH . '/inc/social.php');
include (TEMPLATEPATH . '/inc/banner.php');
include (TEMPLATEPATH . '/inc/blog.php');
include (TEMPLATEPATH . '/inc/slider.php');
include (TEMPLATEPATH . '/inc/eslider.php');
include (TEMPLATEPATH . '/inc/lists.php');
include (TEMPLATEPATH . '/inc/vc_extend.php');
include (TEMPLATEPATH . '/inc/shortcodes/shortcode.php');
include (TEMPLATEPATH . '/inc/themes-style.php');
include (TEMPLATEPATH . '/inc/fonticons.php');
include (TEMPLATEPATH . '/framework/bootstrap/function.php');
include (TEMPLATEPATH . '/framework/importer/importer.php');
include (TEMPLATEPATH . '/framework/aqua/aqua-page-builder.php');
include (TEMPLATEPATH . '/framework/twitter/twitteroauth.php');
include (TEMPLATEPATH . '/inc/postsoptions.php');
include (TEMPLATEPATH . '/inc/megamenu.php');
include (TEMPLATEPATH . '/inc/formats/formats.php');
include (TEMPLATEPATH . '/admin/index.php');
include_once('framework/tgm/class-tgm-plugin-activation.php');
//include post types
include (TEMPLATEPATH . '/inc/portfolio.php');
include (TEMPLATEPATH . '/inc/team.php');
include (TEMPLATEPATH . '/inc/testimonials.php');
include (TEMPLATEPATH . '/inc/clients.php');

//include widgets
include (TEMPLATEPATH . '/inc/widgets/video.php');
include (TEMPLATEPATH . '/inc/widgets/soundcloud.php');
include (TEMPLATEPATH . '/inc/widgets/subscribe.php');
include (TEMPLATEPATH . '/inc/widgets/likebox.php');
include (TEMPLATEPATH . '/inc/widgets/googleplusbox.php');
include (TEMPLATEPATH . '/inc/widgets/post_list.php');
include (TEMPLATEPATH . '/inc/widgets/ads.php');
include (TEMPLATEPATH . '/inc/widgets/tweets.php');


if (isset($asalah_data['asalah_tf_username']) && $asalah_data['asalah_tf_username'] && isset($asalah_data['asalah_tf_api']) && $asalah_data['asalah_tf_api']) {

    function add_update_menu() {

        add_theme_page(theme_name . ' Update', theme_name . ' Updates', 'manage_options', 'updating', 'theadminpage');
    }

    $tfuname = $asalah_data['asalah_tf_username'];
    $tfapi = $asalah_data['asalah_tf_api'];
    add_action('admin_menu', 'add_update_menu');

    function theadminpage(){

        global $tfuname, $tfapi;

        include_once(TEMPLATEPATH . '/framework/envato-wordpress-toolkit-library/class-envato-wordpress-theme-upgrader.php');
        $upgrader = new Envato_WordPress_Theme_Upgrader($tfuname, $tfapi);

        if (isset($_POST['upgradingthemever'])) {
            $upgrader->upgrade_theme();
        }
        $currver = $upgrader->check_for_theme_update();
        ?>
        <style>.updatenotice { margin-top: 20px;}</style>
        <?php
        if ($currver->updated_themes_count) {
            ?>
            <div class="updatenotice">New Update Available</div>
            <div>
                <form method="post">
                    <input type="submit" name="upgradingthemever" value="Update Now" />
                </form>
            </div>
            <?php
        } else {
            ?>
            <div class="updatenotice">Congratulations, you are up to date :)</div>
            <?php
        }
    }

}
remove_filter('term_description', 'wpautop');

function theme_setup() {
    add_editor_style();
    load_theme_textdomain('asalah', get_template_directory() . '/languages');

    // Register primary menu.
    register_nav_menu('primarymenu', __('Primary Menu', 'asalah'));
    // Add default posts and comments RSS feed links to <head>.
    add_theme_support('automatic-feed-links');
    add_theme_support('post-thumbnails');
    add_image_size('portfolio', 520, 337, true); //(cropped)
    add_image_size('team', 500, 528, true); //(cropped)

    /* --------
    add post formats
    ------------------------------------------- */
    add_theme_support( 'post-formats', array(
      'image', 'video', 'gallery', 'audio', 'quote', 'link',
    ));

}
add_action('after_setup_theme', 'theme_setup');

// start activating required plugins

add_action('tgmpa_register', 'asalah_register_required_plugins');

/**
 * Register the required plugins for this theme.
 *
 * In this example, we register two plugins - one included with the TGMPA library
 * and one from the .org repo.
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
if ( ! function_exists( 'asalah_register_required_plugins' ) ) :
function asalah_register_required_plugins() {

    /**
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(
        // This is an example of how to include a plugin pre-packaged with a theme
        array(
            'name' => 'Revolution Slider', // The plugin name
            'slug' => 'revslider', // The plugin slug (typically the folder name)
            'source' => TEMPLATEPATH . '/framework/tgm/plugins/revslider.zip', // The plugin source
            'required' => false, // If false, the plugin is only 'recommended' instead of required
            'version' => '5.4.6.3.1', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
            'force_activation' => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url' => '', // If set, overrides default API URL and points to an external URL
        ),
        array(
            'name' => 'WPBakery Page Builder (Visual Composer)', // The plugin name
            'slug' => 'js_composer', // The plugin slug (typically the folder name)
            'source' => TEMPLATEPATH . '/framework/tgm/plugins/js_composer.zip', // The plugin source
            'required' => false, // If false, the plugin is only 'recommended' instead of required
            'version' => '5.4.4', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
            'force_activation' => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url' => '', // If set, overrides default API URL and points to an external URL
        ),
        // This is an example of how to include a plugin from the WordPress Plugin Repository
        array(
            'name' => 'Contact Form 7',
            'slug' => 'contact-form-7',
            'required' => false,
        ),
        // This is an example of how to include a plugin from the WordPress Plugin Repository
        array(
            'name' => 'One Click Demo Import',
            'slug' => 'one-click-demo-import',
            'required' => false,
        ),
    );

    // Change this to your theme text domain, used for internationalising strings
    $theme_text_domain = 'asalah';

    /**
     * Array of configuration settings. Amend each line as needed.
     * If you want the default strings to be available under your own theme domain,
     * leave the strings uncommented.
     * Some of the strings are added into a sprintf, so see the comments at the
     * end of each line for what each argument will be.
     */
    $config = array(
        'domain' => $theme_text_domain, // Text domain - likely want to be the same as your theme.
        'default_path' => '', // Default absolute path to pre-packaged plugins
        'parent_slug' => 'themes.php', // Default parent menu slug
        'menu' => 'install-required-plugins', // Menu slug
        'has_notices' => true, // Show admin notices or not
        'is_automatic' => false, // Automatically activate plugins after installation or not
        'message' => '', // Message to output right before the plugins table
        'strings' => array(
            'page_title' => __('Install Required Plugins', $theme_text_domain),
            'menu_title' => __('Install Plugins', $theme_text_domain),
            'installing' => __('Installing Plugin: %s', $theme_text_domain), // %1$s = plugin name
            'oops' => __('Something went wrong with the plugin API.', $theme_text_domain),
            'notice_can_install_required' => _n_noop('This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', $theme_text_domain), // %1$s = plugin name(s)
            'notice_can_install_recommended' => _n_noop('This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', $theme_text_domain), // %1$s = plugin name(s)
            'notice_cannot_install' => _n_noop('Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', $theme_text_domain), // %1$s = plugin name(s)
            'notice_can_activate_required' => _n_noop('The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', $theme_text_domain), // %1$s = plugin name(s)
            'notice_can_activate_recommended' => _n_noop('The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', $theme_text_domain), // %1$s = plugin name(s)
            'notice_cannot_activate' => _n_noop('Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', $theme_text_domain), // %1$s = plugin name(s)
            'notice_ask_to_update' => _n_noop('The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', $theme_text_domain), // %1$s = plugin name(s)
            'notice_cannot_update' => _n_noop('Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', $theme_text_domain), // %1$s = plugin name(s)
            'install_link' => _n_noop('Begin installing plugin', 'Begin installing plugins', $theme_text_domain),
            'activate_link' => _n_noop('Activate installed plugin', 'Activate installed plugins', $theme_text_domain),
            'return' => __('Return to Required Plugins Installer', $theme_text_domain),
            'plugin_activated' => __('Plugin activated successfully.', $theme_text_domain),
            'complete' => __('All plugins installed and activated successfully. %s', $theme_text_domain), // %1$s = dashboard link
            'nag_type' => 'updated' // Determines admin notice type - can only be 'updated' or 'error'
        )
    );

    tgmpa($plugins, $config);
}
endif;
// end activate required plugins

// asalah options function
if ( ! function_exists( 'asalah_option' ) ) :
function asalah_option($id, $prefix = "") {
    global $asalah_data;

    if (isset($asalah_data[$id])) {
        return $prefix . $asalah_data[$id];
    }
}
endif;

if ( ! function_exists( 'asalah_post_option' ) ) :
function asalah_post_option($id, $postid = '') {

    global $post;

    if ($post && $postid == '') {
        $post_id = $post->ID;
    } else {
        $post_id = $postid;
    }
    $post_meta = get_post_meta($post_id, $id, true);
    if (isset($post_meta)) {
        return $post_meta;
    }
}
endif;

if ( ! function_exists( 'asalah_cross_option' ) ) :
function asalah_cross_option($id, $postid = '') {
    global $post;

    if ($post && $postid == '') {
        $post_id = $post->ID;
    } else {
        $post_id = $postid;
    }

    if (asalah_option($id) && !asalah_post_option($id, $post_id)) {
        $output = asalah_option($id);
    }elseif(asalah_post_option($id, $post_id)) {
        $output = asalah_post_option($id, $post_id);
    }else{
        $output = null;
    }
    return $output;
}
endif;

// function wpa_cpt_tags( $query ) {
//     if ( $query->is_tag() && $query->is_main_query() ) {
//         $query->set( 'post_type', array( 'post', 'project', 'client', 'testimonial', 'team','pricing_packages'  ) );
//     }
// }
// add_action( 'pre_get_posts', 'wpa_cpt_tags' );


/* limit posts per page for portfolio categories */
function set_posts_per_page_for_project_cpt( $query ) {
  global $asalah_data;
  $post_number = 12;
	if (isset($asalah_data['asalah_portfolio_number'])) {
		$post_number = $asalah_data['asalah_portfolio_number'];
	}
  if ( !is_admin()
         && $query->is_main_query()
         && $query->is_tax('tagportfolio')
       ) {
    $query->set( 'posts_per_page', $post_number );
  }
}
add_action( 'pre_get_posts', 'set_posts_per_page_for_project_cpt' );

function asalah_mobile_menu($args = array()) {
    $output = '';

    @extract($args);

    if (( $locations = get_nav_menu_locations() ) && isset($locations[$menu_name])) {
        $menu = wp_get_nav_menu_object($locations[$menu_name]);
        $menu_items = wp_get_nav_menu_items($menu->term_id);
        $output = "<select id='" . $id . "' class='" . $class . "'>";
        $output .= "<option value='' selected='selected'>" . __('Go to...', 'asalah') . "</option>";
        foreach ((array) $menu_items as $key => $menu_item) {
            $title = $menu_item->title;
            $url = $menu_item->url;

            if ($menu_item->menu_item_parent) {
                $title = ' - ' . $title;
            }
            $output .= "<option value='" . $url . "'>" . $title . '</option>';
        }
        $output .= '</select>';
    }
    return $output;
}

function theme_name_wp_title( $title, $sep ) {
    if ( is_feed() ) {
        return $title;
    }

    global $page, $paged;

    // Add the blog name
    $title .= get_bloginfo( 'name', 'display' );

    // Add the blog description for the home/front page.
    $site_description = get_bloginfo( 'description', 'display' );
    if ( $site_description && ( is_home() || is_front_page() ) ) {
        $title .= " ".$sep." ".$site_description;
    }

    // Add a page number if necessary:
    if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
        $title .= " ".$sep." " . sprintf( __( 'Page %s', '_s' ), max( $paged, $page ) );
    }

    return $title;
}
add_filter( 'wp_title', 'theme_name_wp_title', 10, 2 );

function asalah_widgets_init() {
    global $asalah_data;
    register_sidebar(array(
        'name' => __('Blog sidebar', 'asalah'),
        'id' => 'sidebar-blog',
        'description' => __('An optional widget area for your blog page', 'asalah'),
        'before_widget' => '<div id="%1$s" class="widget_container clearfix widget %2$s">',
        'after_widget' => "</div>",
        'before_title' => '<h3 class="page-header"><span class="page_header_title">',
        'after_title' => '</span></h3>',
    ));

    register_sidebar(array(
        'name' => __('Category page sidebar', 'asalah'),
        'id' => 'sidebar-cat',
        'description' => __('An optional widget area for your categories', 'asalah'),
        'before_widget' => '<div id="%1$s" class="widget_container clearfix widget %2$s">',
        'after_widget' => "</div>",
        'before_title' => '<h3 class="page-header"><span class="page_header_title">',
        'after_title' => '</span></h3>',
    ));

    register_sidebar(array(
        'name' => __('Single blog post sidebar', 'asalah'),
        'id' => 'sidebar-single',
        'description' => __('An optional widget area for your blog post page', 'asalah'),
        'before_widget' => '<div id="%1$s" class="widget_container clearfix widget %2$s">',
        'after_widget' => "</div>",
        'before_title' => '<h3 class="page-header"><span class="page_header_title">',
        'after_title' => '</span></h3>',
    ));

    register_sidebar(array(
        'name' => __('Single page post sidebar', 'asalah'),
        'id' => 'sidebar-page',
        'description' => __('An optional widget area for your pages', 'asalah'),
        'before_widget' => '<div id="%1$s" class="widget_container clearfix widget %2$s">',
        'after_widget' => "</div>",
        'before_title' => '<h3 class="page-header"><span class="page_header_title">',
        'after_title' => '</span></h3>',
    ));

    register_sidebar(array(
        'name' => __('Footer Area One', 'asalah'),
        'id' => 'sidebar-1',
        'description' => __('An optional widget area for your site footer', 'asalah'),
        'before_widget' => '<div id="%1$s" class="widget_container clearfix widget %2$s">',
        'after_widget' => "</div>",
        'before_title' => '<h3 class="page-header"><span class="page_header_title">',
        'after_title' => '</span></h3>',
    ));

    register_sidebar(array(
        'name' => __('Footer Area Two', 'asalah'),
        'id' => 'sidebar-2',
        'description' => __('An optional widget area for your site footer', 'asalah'),
        'before_widget' => '<div id="%1$s" class="widget_container clearfix widget %2$s">',
        'after_widget' => "</div>",
        'before_title' => '<h3 class="page-header"><span class="page_header_title">',
        'after_title' => '</span></h3>',
    ));

    register_sidebar(array(
        'name' => __('Footer Area Three', 'asalah'),
        'id' => 'sidebar-3',
        'description' => __('An optional widget area for your site footer', 'asalah'),
        'before_widget' => '<div id="%1$s" class="widget_container clearfix widget %2$s">',
        'after_widget' => "</div>",
        'before_title' => '<h3 class="page-header"><span class="page_header_title">',
        'after_title' => '</span></h3>',
    ));

    register_sidebar(array(
        'name' => __('Footer Area four', 'asalah'),
        'id' => 'sidebar-4',
        'description' => __('An optional widget area for your site footer', 'asalah'),
        'before_widget' => '<div id="%1$s" class="widget_container clearfix widget %2$s">',
        'after_widget' => "</div>",
        'before_title' => '<h3 class="page-header"><span class="page_header_title">',
        'after_title' => '</span></h3>',
    ));

    if (isset($asalah_data['asalah_custom_sidebars'])) {
        $sidebars = $asalah_data['asalah_custom_sidebars'];
        if ($sidebars):

            foreach ($sidebars as $option) {
                $siebar_id = "asalah_custom_sidebar_" . $option['order'];
                register_sidebar(array(
                    'name' => $option['title'],
                    'id' => $siebar_id,
                    'description' => __('Custom Sidebar', 'asalah'),
                    'before_widget' => '<div id="%1$s" class="widget_container clearfix widget %2$s">',
                    'after_widget' => "</div>",
                    'before_title' => '<h3 class="page-header"><span class="page_header_title">',
                    'after_title' => '</span></h3>',
                ));
            }

        endif;
    }

}

add_action('widgets_init', 'asalah_widgets_init');

if (class_exists('OCDI_Plugin')) {
  function asalah_ocdi_import_files() {
  return array(
    array(
      'import_file_name'             => 'Bostan',
      'local_import_file'            => trailingslashit( get_template_directory() ) . 'framework/importer/main/bostan.xml',
      'import_notice'              => __( "Don't forget to install and update all required plugins via (Appearance > Install Plugins) before importing.", 'your-textdomain' ),
    ),
  );
}
add_filter( 'pt-ocdi/import_files', 'asalah_ocdi_import_files' );
//
function ocdi_change_time_of_single_ajax_call() {
	return 15;
}
add_action( 'pt-ocdi/time_for_one_ajax_call', 'ocdi_change_time_of_single_ajax_call' );

// hide plugin notice after Import
add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );

  function asalah_ocdi_after_import() {
    // Import Theme Options
    $theme_options_txt = get_template_directory() . '/framework/importer/main/theme_options.txt'; // theme options data file
    $theme_options_txt = file_get_contents( $theme_options_txt );

    $smof_data = unserialize( base64_decode( $theme_options_txt)  ); //100% safe - ignore theme check nag
    of_save_options($smof_data);

    // Add custom sidebars markup
    $sidebars = array(
        'sidebar_1' => 'Sidebar Menu',
        'sidebar_2' => 'Products Menu',
    );
    update_option( 'sbg_sidebars', $sidebars );

    foreach( $sidebars as $id => $sidebar ) {
        register_sidebar(array(
            'name'=>$sidebar,
            'id' => 'asalah_custom_' . $id,
            'before_widget' => '<div id="%1$s" class="widget_container widget_content widget %2$s clearfix">',
            'after_widget' => "</div>",
            'before_title' => '<h4 class="page-header"><span class="page_header_title">',
            'after_title' => '</span></h4>',
        ));
    }

    // Import demo widgets
    $widgets_json = get_template_directory() . '/framework/importer/main/widget_data.json'; // widgets data file
    $widgets_json = file_get_contents( $widgets_json );
    $widget_data = $widgets_json;
    $import_widgets = asalah_import_widget_data( $widget_data );


    // Import Revslider
    // Import Revslider
    if( class_exists('RevSlider') ) {
        $rev_directory = get_template_directory() . '/framework/importer/main/revsliders/';

        foreach( glob( $rev_directory . '*.zip' ) as $filename ) {
            $filename = basename($filename);
            $rev_files[] = get_template_directory() . '/framework/importer/main/revsliders/' . $filename ;
        }

        if(isset($rev_files)){
            foreach( $rev_files as $rev_file ) {

                    $filepath = $rev_file;

                    $slider = new RevSlider();
                    $slider->importSliderFromPost( true, true, $rev_file );
            }
        }
    }


    // Import Demo Menu Items
    $menus = wp_get_nav_menus();
    $locations = get_theme_mod( 'nav_menu_locations' );
    if($menus) {
        foreach($menus as $menu) {
            if ($menu->name == "Main") {
                $locations['primarymenu'] = $menu->term_id;
            }
        }
    }
    set_theme_mod( 'nav_menu_locations', $locations );


    // Set Front Page
    $homepage = get_page_by_title( 'Home' );
    if($homepage->ID) {
        update_option('show_on_front', 'page');
        update_option('page_on_front', $homepage->ID);
    }

  }
 add_action( 'pt-ocdi/after_import', 'asalah_ocdi_after_import' );

}

function asalah_project_skills_list() {
    global $post;
    $get_meta = get_post_custom($post->ID);
    $skills_items = unserialize($get_meta['asalah_project_skills_item'][0]);
    $score = '';
    $count = '';
    ?>
    <div class="new_content">
        <div class="portfolio_section_title"><h4 class="page-header"><span class="page_header_title"><?php _e("Project Skills", 'asalah'); ?></span></h4></div>
        <div class="portfolio_skills_content">
            <?php
            foreach ($skills_items as $skills) {
                if ($skills['name'] && $skills['score']) {
                    ?>
                    <span class="skill_title meta_title"><?php echo $skills['name']; ?> <?php echo $skills['score']; ?>%</span>
                    <div class="progress progress-striped">
                        <div class="bar" style="width: <?php echo $skills['score']; ?>%;"></div>
                    </div>
                    <?php
                    $score += $skills['score'];
                    ;
                    $count += 1;
                }
            }
            ?>
        </div>
    </div>
    <?php
}

if (!function_exists('asalah_content_nav')) :

    /**
     * Display navigation to next/previous pages when applicable
     */
    function asalah_content_nav() {
        global $wp_query;

        if ($wp_query->max_num_pages > 1) :
            ?>
            <div class="pagination">
                <nav class="content_nav">
                    <div class="prev_page">
                        <?php next_posts_link('OLD POSTS'); ?>
                    </div>
                    <div class="next_page">
                        <?php previous_posts_link('NEW POSTS'); ?>
                    </div>
                </nav>
            </div>
            <?php
        endif;
    }

endif;

if (!function_exists('asalah_comment')) :

    function asalah_comment($comment, $args, $depth) {
        $GLOBALS['comment'] = $comment;
        switch ($comment->comment_type) :
            case 'pingback' :
            case 'trackback' :
                ?>
                <li class="post pingback">
                    <p><?php _e('Pingback: ', 'asalah'); ?> <?php comment_author_link(); ?> (<?php edit_comment_link(__('Edit', 'asalah'), '<span class="edit-link">', '</span>'); ?>)</p>
                    <?php
                    break;
                default :
                    ?>
                <li <?php comment_class("media the_comment"); ?> id="comment-<?php comment_ID(); ?>">
                    <a class="pull-left commenter" href="#">
                        <?php
                        $avatar_size = 80;
                        if ('0' != $comment->comment_parent)
                            $avatar_size = 80;

                        echo get_avatar($comment, $avatar_size);
                        ?>
                    </a>
                    <div class="media-body comment_body">
                        <div class="media-heading clearfix">
                            <h5 class="commenter_name"><?php echo get_comment_author_link(); ?></h5>
                            <div class="comment_info"><a href="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>"><time pubdate datetime="<?php echo get_comment_time('c'); ?>"><?php echo get_comment_date() . ' at ' . get_comment_time(); ?></time></a> - <?php comment_reply_link(array_merge($args, array('reply_text' => __('Reply', 'asalah'), 'depth' => $depth, 'max_depth' => $args['max_depth']))); ?></div>
                        </div>
                        <?php comment_text(); ?>


                        <?php
                        break;
                endswitch;
            }

        endif;

        function asalah_google_maps($src, $width = '100%', $height = 500) {
          if ($src == '') { return false;}
            return '<div class="google-map"><iframe width="' . $width . '" height="' . $height . '" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="' . $src . '&amp;output=embed"></iframe></div>';
        }

        add_filter('widget_text', 'do_shortcode');

        function related_posts_list($post_id) {
            $tags = wp_get_post_tags($post_id);
            if ($tags) {
                $tag_ids = array();
                foreach ($tags as $individual_tag)
                    $tag_ids[] = $individual_tag->term_id;

                $args = array(
                    'tag__in' => $tag_ids,
                    'post__not_in' => array($post_id),
                    'showposts' => 4, // Number of related posts that will be shown.
                    'ignore_sticky_posts' => 1
                );

                $my_query = new wp_query($args);
                while ($my_query->have_posts()) : $my_query->the_post();
                    ?>
                    <li><a href="<?php the_permalink(); ?>"><h6><?php the_title(); ?></h6></a></li>
                    <?php
                endwhile;
            }
        }

        function single_related_posts() {
            global $post;
            $tags = wp_get_post_tags($post->ID);
            if ($tags) {
                $tag_ids = array();
                foreach ($tags as $individual_tag)
                    $tag_ids[] = $individual_tag->term_id;

                $args = array(
                    'orderby' => 'rand',
                    'tag__in' => $tag_ids,
                    'post__not_in' => array($post->ID),
                    'showposts' => 2, // Number of related posts that will be shown.
                    'caller_get_posts' => 1
                );

                $my_query = new wp_query($args);
                if ($my_query->have_posts()) {
                    ?>
                    <div class="row-fluid content_boxes">
                        <div class="single_related_articles span12">
                            <div class="page-header clearfix"><h4><?php _e('Related Articles', 'asalah'); ?></h4></div>
                            <div class="single_related_box row-fluid">
                                <?php
                                while ($my_query->have_posts()) : $my_query->the_post();
                                    $date = get_the_date('', $post->ID);
                                    $time = get_the_time('', $post->ID);
                                    ?>
                                    <div class="span6">
                                        <div class="row-fluid wide_post_list">
                                            <div class="span12 post_list_thumbnail thumbeffect"><a href='<?php the_permalink(); ?>'>
                                                    <div class="dark-background"><div class="hoverplus"><i class="icon-link"></i></div></div>
                                                    <?php asalah_blog_thumb(375, 136, $post->ID); ?></a></div>
                                            <div class="span12 post_list_title">
                                                <a href='<?php the_permalink(); ?>'><h5><?php the_title(); ?></h5></a>
                                                <div class="post_meta">
                                                    <div class="meta_info">
                                                        <span class="meta_text"><?php echo $date; ?> - <?php echo $time; ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                endwhile;
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
        }

        function asalah_post_meta_info() {
            global $post;
            ?>
            <div class="single_post_meta clearfix">
                <span class="meta_element"><i class="icon-time"></i> <?php the_time(get_option('date_format')); ?> - <?php echo get_the_time(); ?></span>

                <?php if (get_the_category_list()): ?>
                    <span class="meta_element"><i class="icon-folder-open"></i> <?php echo get_the_category_list(', '); ?></span>
                <?php endif; ?>

                <?php if (get_the_tag_list()): ?>
                    <span class="meta_element"><?php echo get_the_tag_list('<i class="icon-tags"></i> ', ', '); ?></span>
                <?php endif; ?>

            </div>
            <?php
        }

        function my_new_contactmethods($contactmethods) {
            $contactmethods['twitter'] = __('Twitter', 'asalah');
            $contactmethods['facebook'] = __('Facebook', 'asalah');
            $contactmethods['gplus'] = __('Google Plus', 'asalah');
            $contactmethods['linkedin'] = __('Linkedin', 'asalah');
            return $contactmethods;
        }

        add_filter('user_contactmethods', 'my_new_contactmethods', 10, 1);

        function asalah_bootstrap_pagination($pages = '', $range = 2) {
            $showitems = ($range * 2) + 1;

            global $paged;
            if (empty($paged))
                $paged = 1;
            if ($pages == '') {
                global $wp_query;
                $pages = $wp_query->max_num_pages;
                if (!$pages) {
                    $pages = 1;
                }
            }

            if (1 != $pages) {
                echo "<div class='pagination'><ul>";
                if ($paged > 2 && $paged > $range + 1 && $showitems < $pages)
                    echo "<li><a href='" . get_pagenum_link(1) . "'>&laquo;</a></li>";
                if ($paged > 1 && $showitems < $pages)
                    echo "<li><a href='" . get_pagenum_link($paged - 1) . "'>&lsaquo;</a></li>";

                for ($i = 1; $i <= $pages; $i++) {
                    if (1 != $pages && (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems )) {
                        echo ($paged == $i) ? "<li class='active'><span class='current'>" . $i . "</span></li>" : "<li><a href='" . get_pagenum_link($i) . "' class='inactive' >" . $i . "</a></li>";
                    }
                }

                if ($paged < $pages && $showitems < $pages)
                    echo "<li><a href='" . get_pagenum_link($paged + 1) . "'>&rsaquo;</a></li>";
                if ($paged < $pages - 1 && $paged + $range - 1 < $pages && $showitems < $pages)
                    echo "<li><a href='" . get_pagenum_link($pages) . "'>&raquo;</a></li>";
                echo "</ul></div>\n";
            }
        }

        function asalah_blog_posts($number = '3', $tag_ids = '', $readmore_pharse = '', $cats = '', $order = 'date', $show_meta = 'no', $excerpt = '20') {

            $args = array('post_type' => 'post', 'posts_per_page' => $number);

            if ($tag_ids != '') {
                $tags = explode(',', $tag_ids);
                $tags_array = array();
                if (count($tags) > 0) {
                    foreach ($tags as $tag) {
                        if (!empty($tag)) {
                            $tags_array[] = $tag;
                        }
                    }
                }

                $args['tag_slug__in'] = $tags_array;
            }

            if ($cats != '') {
              $box_cat = get_category_by_slug($cats);
              if ($box_cat) {
                $category = $box_cat->term_id;
                $args['cat'] = $category;
              }
            }

            if ($order != '') {
              $args['orderby'] = $order;
              if ($order == 'name') {
                $args['order'] = 'ASC';
              }
            }
            
            if ($excerpt == '') {
              $excerpt = 20;
            }

            $wp_query = new WP_Query($args);
            ?>
            <?php if ($wp_query) : ?>
                <div class="row-fluid">
                    <div class="span12">
                        <?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
                            <div class="the_blog_post">
                                <div class="post_date_thumbnail">
                                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php asalah_blog_thumb("520", "337") ?></a>
                                </div>
                                <div class="post_details">
                                    <div class="blog_title"><a href="<?php the_permalink(); ?>"><h4><?php the_title(); ?></h4></a></div>
                                    <?php if ($show_meta == 'yes') { ?>
                                    <div class="blog_info_box clearfix">
                                        <?php if (asalah_cross_option('asalah_page_meta_info_date') != 'hide') { ?>
                                        <div class="blog_box_item"><span class="blog_date meta_item"><i class="icon-calendar meta_icon"></i> <?php echo get_the_date(); ?></span></div>
                                        <?php } ?>
                                        <?php if (asalah_cross_option('asalah_page_meta_info_comment') != 'hide') {
                                         if (comments_open()) { ?>
                                        <div class="blog_box_item"><span class="blog_comments meta_item"><i class="icon-comment meta_icon"></i> <?php comments_number(); ?></span></div>
                                        <?php }
                                        } ?>
                                    </div>
                                    <?php } ?>
                                    <div class="blog_title"><?php echo excerpt($excerpt); ?></div>
                                    <div class="read_more_link"><a href="<?php the_permalink(); ?>"><?php if ($readmore_pharse != '') { echo $readmore_pharse; } else { _e("Read more ...", "asalah");} ?></a></div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            <?php endif; ?>
            <?php
        }

if (!function_exists('asalah_meta_info'))  {
  function asalah_meta_info() {
      global $post;
      $id = $post->ID;
?>
    <div class="blog_info_box clearfix">
        <?php if (asalah_cross_option('asalah_post_meta_info_date') != 'hide') { ?>
        <div class="blog_box_item"><span class="blog_date meta_item"><i class="icon-calendar meta_icon"></i> <?php echo get_the_date(); ?></span></div>
        <?php } ?>
        <?php if (asalah_cross_option('asalah_post_meta_info_comment') != 'hide') {
         if (comments_open()) { ?>
        <div class="blog_box_item"><span class="blog_comments meta_item"><i class="icon-comment meta_icon"></i> <?php comments_number(); ?></span></div>
        <?php }
        } ?>
        <?php if (asalah_cross_option('asalah_post_meta_info_category') != 'hide') {
        if (get_the_category_list()): ?>
        <div class="blog_box_item"><span class="blog_category meta_item"><i class="icon-folder-open meta_icon"></i> <?php echo get_the_category_list(', ' ); ?></span></div>
        <?php endif;
        } ?>

    </div>
<?php
  }
}

function asalah_posts_carousel($block_id ="", $posttype='project', $url ="", $number='9', $title="Projects", $desc = "", $max = "4", $cycle ="", $pos = "", $exception = '', $tag_ids = '', $projects_order = '', $autoplay_car = '', $thumb_height = '', $external_link = '') {
?>

	 <?php

	 global $post;
	 	global $asalah_data;
    $title = ($title != '') ? $title : 'Projects';
		if ($exception == '') {
			$args = array('post_type' => $posttype, 'posts_per_page' => $number);
		}else{
			$args = array('post_type' => $posttype, 'posts_per_page' => $number, 'post__not_in' => array($exception));
		}

		if ($tag_ids != '') {
			$args['tagportfolio'] = $tag_ids;
		}

    if ($projects_order != '') {
      $args['orderby'] = $projects_order;
      if ($projects_order == 'title') {
        $args['order'] = 'ASC';
      }
    }

    if (intval($thumb_height) == '') { $thumb_height = "193";}
    $autoplay = (isset($autoplay_car) && ($autoplay_car == 'yes')) ? 'true' : 'false';

		$wp_query = new WP_Query($args);
	?>
	<?php if ( $wp_query ) : ?>
    <div class="row-fluid" id="<?php echo $block_id; ?>">
        <?php if ($pos == "side") : ?>
		<div class="span3">
            <div class="portfolio_section_title"><h3 class="page-header">
			<?php if ($url == ''): ?>
			<span class="page_header_title"><?php echo $title; ?></span>
			<?php else: ?>
			<a href="<?php echo $url; ?>" title="<?php echo $title; ?>"><span class="page_header_title"><?php echo $title; ?></span></a>
			<?php endif; ?>
			<span id="right_car_arrow1<?php echo $block_id;?>" class="cars_arrow_control right_car_arrow"><i class="icon-angle-right"></i></span><span id="left_car_arrow1<?php echo $block_id;?>" class="cars_arrow_control left_car_arrow"><i class="icon-angle-left"></i></span></h3></div>
            <div class="portfolio_section_title">
            <p><?php echo $desc; ?></p>
            </div>
        </div>

        <div class="portfolio_carousel span9">
            <div class="carousel">
                <div class="slides row-fluid list_carousel responsive clearfix">
                <div class="portfolio_cars">
                    <?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
                    <div class="the_portfolio_list_li_div" id="post-<?php echo get_the_ID(); ?>">
                    <div class="portfolio_item">
                    <?php asalah_slideshow(); ?>
                        <div class="portfolio_thumbnail">
									<?php asalah_projects_car_thumb($thumb_height); ?>
									<div class="portfolio_overlay">
                                    </div>
                                    <?php if ($external_link == 'yes' && get_post_meta($post->ID, 'project_url', true) != '') { ?>
                                      <div class="center-bar">
                                          <a class="icon-link-ext" href="<?php echo get_post_meta($post->ID, 'project_url', true); ?>"></a>
                                      </div>
                                    <?php } else { ?> 
                                    <?php if (isset($asalah_data['asalah_portfolio_icon']) && $asalah_data['asalah_portfolio_icon'] == 'url'): ?>
                                    <div class="center-bar">
                                        <a class="icon-link" href="<?php the_permalink(); ?>"></a>
                                    </div>
                                    <?php else: ?>
                                    <div class="center-bar">
                                        <a class="prettyPhotolink icon-search goup" rel="slideshow_<?php echo $post->ID; ?>"></a>
                                    </div>
                                    <?php endif; ?>
                                    <?php } ?>
								</div>
								<div class="portfolio_info">
									<a href="<?php the_permalink(); ?>"><h5><?php the_title(); ?></h5></a>
                            		<span class="portfolio_category"><?php $tags_list = get_the_term_list( $post->ID, 'tagportfolio', '',', ',''); echo $tags_list; ?></span>
								</div>
                    </div>
                    </div>
                    <?php endwhile; ?>
                </div>
                </div>
            </div>
        </div>
		<?php elseif ($pos == "top"): ?>
		<div class="span12">
		<div class="row-fluid">
		<div class="span12">
            <div class="portfolio_section_title"><h3 class="page-header">
			<?php if ($url == ''): ?>
			<span class="page_header_title"><?php echo $title; ?></span>
			<?php else: ?>
			<a href="<?php echo $url; ?>" title="<?php echo $title; ?>"><span class="page_header_title"><?php echo $title; ?></span></a>
			<?php endif; ?>
			<span id="right_car_arrow1<?php echo $block_id;?>" class="cars_arrow_control right_car_arrow"><i class="icon-angle-right"></i></span><span id="left_car_arrow1<?php echo $block_id;?>" class="cars_arrow_control left_car_arrow"><i class="icon-angle-left"></i></span></h3></div>
            <div class="portfolio_section_title">
            <p><?php echo $desc; ?></p>
            </div>
        </div>
		</div>

		<div class="row-fluid">
        <div class="portfolio_carousel span12">
            <div class="carousel">
                <div class="slides row-fluid list_carousel responsive clearfix">
                <div class="portfolio_cars">
                    <?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
                    <div class="the_portfolio_list_li_div" id="post-<?php the_ID(); ?>">
                    <div class="portfolio_item">
                    <?php asalah_slideshow(); ?>
                        <div class="portfolio_thumbnail">
                            <?php asalah_projects_car_thumb($thumb_height); ?>
                                <div class="portfolio_overlay">
                                </div>
                                <?php if ($external_link == 'yes' && get_post_meta($post->ID, 'project_url', true) != '') { ?>
                                  <div class="center-bar">
                                      <a class="icon-link-ext" href="<?php echo get_post_meta($post->ID, 'project_url', true); ?>"></a>
                                  </div>
                                <?php } else { ?> 
                                <?php if (isset($asalah_data['asalah_portfolio_icon']) && $asalah_data['asalah_portfolio_icon'] == 'url'): ?>
                                <div class="center-bar">
                                    <a class="icon-link" href="<?php the_permalink(); ?>"></a>
                                </div>
                                <?php else: ?>
                                <div class="center-bar">
                                    <a class="prettyPhotolink icon-search goup" rel="slideshow_<?php echo $post->ID; ?>"></a>
                                </div>
                                <?php endif; ?>
                                <?php } ?>

                        </div>
                        <div class="portfolio_info">
                            <a href="<?php the_permalink(); ?>"><h5><?php the_title(); ?></h5></a>
                            <span class="portfolio_category"><?php $tags_list = get_the_term_list( $post->ID, 'tagportfolio', '',', ',''); echo $tags_list; ?></span>
                        </div>

                    </div>
                    </div>
                    <?php endwhile; ?>
                </div>
                </div>
            </div>
        </div>
		</div>
		</div>
		<?php elseif ($pos == "hidden"): ?>
        <div class="portfolio_carousel span12">
            <div class="carousel">
                <div class="slides row-fluid list_carousel responsive clearfix">
                <div class="portfolio_cars owl-carousel owl-theme">
                    <?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
                    <div id="post-<?php the_ID(); ?>">
                    <div class="portfolio_item">
                    <?php asalah_slideshow(); ?>
                        <div class="portfolio_thumbnail">
									<?php asalah_projects_car_thumb($thumb_height); ?>
									<div class="portfolio_overlay">
                                    </div>
                                    <?php if ($external_link == 'yes' && get_post_meta($post->ID, 'project_url', true) != '') { ?>
                                      <div class="center-bar">
                                          <a class="icon-link-ext" href="<?php echo get_post_meta($post->ID, 'project_url', true); ?>"></a>
                                      </div>
                                    <?php } else { ?> 
                                    <?php if (isset($asalah_data['asalah_portfolio_icon']) && $asalah_data['asalah_portfolio_icon'] == 'url'): ?>
                                    <div class="center-bar">
                                        <a class="icon-link" href="<?php the_permalink(); ?>"></a>
                                    </div>
                                    <?php else: ?>
                                    <div class="center-bar">
                                        <a class="prettyPhotolink icon-search goup" rel="slideshow_<?php echo $post->ID; ?>"></a>
                                    </div>
                                    <?php endif; ?>
                                    <?php } ?>
								</div>
								<div class="portfolio_info">
									<a href="<?php the_permalink(); ?>"><h5><?php the_title(); ?></h5></a>
                            		<span class="portfolio_category"><?php $tags_list = get_the_term_list( $post->ID, 'tagportfolio', '',', ',''); echo $tags_list; ?></span>
								</div>
                    </div>
                    </div>
                    <?php endwhile; ?>
                </div>
                </div>
            </div>
        </div>
		<?php endif;

     ?>
        <script type="text/javascript" language="javascript">
			jQuery(document).ready(function() {
        if (jQuery('.widgets_nav .portfolio_carousel').length) {
          var carpar = jQuery('.portfolio_carousel').parents('.widgets_nav');
          carpar.addClass('hidden_carousel');
          carpar.show();
          //jQuery('body').append('<style>.widgets_nav .row-fluid::before, .row-fluid::after {display: table;content: "";line-height: 0;}</style>')
        }
				//	Responsive layout, resizing the items

        jQuery('#<?php echo $block_id; ?> .portfolio_cars').carouFredSel({
					responsive: true,
          height: '<?php echo $thumb_height;?>px',
					prev: '#<?php echo $block_id; ?> #left_car_arrow1',
					next: '#<?php echo $block_id; ?> #right_car_arrow1',
					auto: <?php echo $autoplay;?>,
					<?php if ($cycle != '') : ?>
					scroll: {
						items: <?php echo $cycle; ?>,
					},
					<?php endif; ?>
					swipe: {
						onTouch: true,
					},
					items: {
            visible: {
						max: <?php echo $max; ?>,
            min: 1
          }
					},

				});


        jQuery('#<?php echo $block_id; ?> .portfolio_cars').imagesLoaded( function () {
				jQuery('#<?php echo $block_id; ?> .portfolio_cars').carouFredSel({
					responsive: true,
          height: '<?php echo $thumb_height;?>px',
					prev: '#<?php echo $block_id; ?> #left_car_arrow1<?php echo $block_id;?>',
					next: '#<?php echo $block_id; ?> #right_car_arrow1<?php echo $block_id;?>',
					auto: <?php echo $autoplay;?>,
					<?php if ($cycle != '') : ?>
					scroll: {
						items: <?php echo $cycle; ?>,
					},
					<?php endif; ?>
					swipe: {
						onTouch: true,
					},
          items: {
            visible: {
						max: <?php echo $max; ?>,
            min: 1
          }
					}
				});


			}); });
      portfolio_thumb_width();
      jQuery(window).resize(function() {
        portfolio_thumb_width();
    });

    function portfolio_thumb_width() {
      var container_width = jQuery('body .container').width();
      var width = jQuery('body .portfolio_carousel').width() + 30;
      if (container_width > 784) {
      if ( (<?php echo $max; ?> % 2) == 0) {
        var new_width = ((width - (16 * (<?php echo $max;?>)+12)) / <?php echo $max; ?>);
      } else {
    		var new_width = ((width - (16 * (<?php echo $max;?>)+12)) / <?php echo $max; ?>);
      }
  		jQuery('body').append('<style>#<?php echo $block_id; ?> .portfolio_cars .the_portfolio_list_li_div { max-width:'+new_width+'px; width:'+new_width+'px !important;}');
    } else if ((container_width <= 784) && (container_width > 369))  {
      var new_width = (width - 16) / 2;
      jQuery('#<?php echo $block_id; ?> .portfolio_cars .the_portfolio_list_li_div').css('width', new_width);
      jQuery('#<?php echo $block_id; ?> .portfolio_cars .the_portfolio_list_li_div').css('max-width', new_width);
      
    } else if (container_width <= 369) {
      jQuery('#<?php echo $block_id; ?> .portfolio_cars .the_portfolio_list_li_div').css('width', width);
      jQuery('#<?php echo $block_id; ?> .portfolio_cars .the_portfolio_list_li_div').css('max-width', width);
    }
    }
		</script>
    <style>
      #<?php echo $block_id; ?> .portfolio_cars .portfolio_thumbnail
      {
          text-align: center;
          height: <?php echo $thumb_height; ?>px;
          overflow: hidden;
          max-width: 100%;
          border-radius: 4px;
          z-index: 1;
      }


      #<?php echo $block_id; ?> .portfolio_cars .portfolio_thumbnail img
      {
              position: absolute;
          top: -9999px;
          bottom: -9999px;
          left: -9999px;
          right: -9999px;
          margin: auto;
          min-height: <?php echo $thumb_height; ?>px;
          min-width: 100%;
          width: auto;
      }
    </style>
    </div>
	<?php endif; ?>

<?php
}

        function asalah_team_carousel($block_id = "", $url = "", $number = '8', $title = "Team Members", $desc = "", $max = "4", $cycle = "", $team_order = '', $autoplay_car = '') {
            global $post;
            ?>

            <?php
            $number = ($number != '') ? $number : '8';
            $title = ($title != '') ? $title : 'Team Memebers';
            $max = ($max != '') ? $max : '4';
            $args = array('post_type' => 'team', 'posts_per_page' => $number);
            $autoplay_car = ($autoplay_car != '') ? $autoplay_car : '';
            if ($autoplay_car == 'yes') {
              $autoplay = 'true';
            } else {
              $autoplay = 'false';
            }
            if ($team_order != '') {
              $order = $team_order;
              $args['orderby'] = $order;
              if ($order == 'title') {
                $args['order'] = 'ASC';
              }
            }


            $wp_query = new WP_Query($args);
            ?>
    <?php if ($wp_query) : ?>
                <div id="<?php echo $block_id; ?>" class="row-fluid">

                    <div class="span12">
                        <div class="row-fluid">
                            <div class="span12">
                                <div class="portfolio_section_title"><h3 class="page-header">
                                        <?php if ($url == ''): ?>
                                            <span class="page_header_title"><?php echo $title; ?></span>
        <?php else: ?>
                                            <a href="<?php echo $url; ?>" title="<?php echo $title; ?>"><?php echo $title; ?></a>
        <?php endif; ?>
                                        <span class="right_car_arrow3 cars_arrow_control right_car_arrow"><i class="icon-angle-right"></i></span><span class="left_car_arrow3 cars_arrow_control left_car_arrow"><i class="icon-angle-left"></i></span></h3></div>
                                <div class="portfolio_section_title">
                                    <p><?php echo $desc; ?></p>
                                </div>
                            </div>
                        </div>

                        <div class="row-fluid">
                            <div class="team_carousel span12">
                                <div class="carousel">
                                    <div class="slides row-fluid list_carousel responsive clearfix">
                                        <div class="team_cars">
        <?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
                                                            <?php $get_meta = get_post_custom($post->ID); ?>
                                                <div class="the_portfolio_list_li_div" id="post-<?php the_ID(); ?>">
                                                    <div class="team_item portfolio_item">
                                                        <div class="portfolio_thumbnail">
                                                            <?php asalah_blog_thumb("500", "528") ?>
                                                        </div>
                                                        <div class="portfolio_info">
                                                            <h4><?php the_title(); ?></h4>
            <?php if ($get_meta['asalah_team_position'][0] != ''): ?>
                                                                <div class="portfolio_time"><?php echo $get_meta['asalah_team_position'][0]; ?></div>
                                                            <?php endif; ?>


                                                                    <?php if ($get_meta['asalah_team_fb'][0] != '' || $get_meta['asalah_team_tw'][0] != '' || $get_meta['asalah_team_gp'][0] != '' || $get_meta['asalah_team_linked'][0] != '' || $get_meta['asalah_team_pin'][0] != '' || $get_meta['asalah_team_mail'][0] != '') { ?>
                                                                <div class="team_social_bar clearfix">
                                                                    <ul class="team_social_list">
                                                                        <?php if ($get_meta['asalah_team_fb'][0] != '') { ?>
                                                                            <li><a target="_blank" href="<?php echo $get_meta['asalah_team_fb'][0]; ?>"><i class="icon-facebook" title="Facebook"></i></a></li>
                                                                        <?php } ?>
                                                                        <?php if ($get_meta['asalah_team_tw'][0] != '') { ?>
                                                                            <li><a target="_blank" href="<?php echo $get_meta['asalah_team_tw'][0]; ?>"><i class="icon-twitter" title="Twitter"></i></a></li>
                                                                        <?php } ?>
                                                                        <?php if ($get_meta['asalah_team_gp'][0] != '') { ?>
                                                                            <li><a target="_blank" href="<?php echo $get_meta['asalah_team_gp'][0]; ?>"><i class="icon-gplus" title="Google Plus"></i></a></li>
                                                                        <?php } ?>
                                                                        <?php if ($get_meta['asalah_team_linked'][0] != '') { ?>
                                                                            <li><a target="_blank" href="<?php echo $get_meta['asalah_team_linked'][0]; ?>"><i class="icon-linkedin" title="Linkedin"></i></a></li>
                                                                        <?php } ?>
                                                                        <?php if ($get_meta['asalah_team_pin'][0] != '') { ?>
                                                                            <li><a target="_blank" href="<?php echo $get_meta['asalah_team_pin'][0]; ?>"><i class="icon-pinterest" title="Pinterest"></i></a></li>
                                                                        <?php } ?>
                <?php if ($get_meta['asalah_team_mail'][0] != '') { ?>
                                                                            <li><a href="mailto:<?php echo $get_meta['asalah_team_mail'][0]; ?>"><i class="icon-mail" title="Mail"></i></a></li>
                                                                <?php } ?>
                                                                    </ul>
                                                                </div>
            <?php } ?>


                                                        </div>
                                                    </div>
                                                </div>
        <?php endwhile; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script type="text/javascript" language="javascript">
                                jQuery(document).ready(function() {

                        //	Responsive layout, resizing the items
                        jQuery('#<?php echo $block_id; ?> .team_cars').carouFredSel({
                            responsive: true,
                            prev: '#<?php echo $block_id; ?> .left_car_arrow3',
                            next: '#<?php echo $block_id; ?> .right_car_arrow3',
                            auto: <?php echo $autoplay; ?>,
                            <?php if ($cycle != '') : ?>
                                  scroll: {
                                  items: <?php echo $cycle; ?>,
                                  },
                            <?php endif; ?>
                            swipe: {
                            onTouch: true,
                            },
                            items: {
                              visible: {
                                width: 160,
                                min: 1,
                                max: <?php echo $max; ?>
                              }
                            }
                        });

                        jQuery('#<?php echo $block_id; ?> .team_cars').imagesLoaded( function () {
                        jQuery('#<?php echo $block_id; ?> .team_cars').carouFredSel({
                        responsive: true,
                                prev: '#<?php echo $block_id; ?> .left_car_arrow3',
                                next: '#<?php echo $block_id; ?> .right_car_arrow3',
                                auto: <?php echo $autoplay;?>,
        <?php if ($cycle != '') : ?>
                            scroll: {
                            items: <?php echo $cycle; ?>,
                            },
        <?php endif; ?>
                        swipe: {
                        onTouch: true,
                        },
                                items: {
                                visible: {
                                  width: 160,
                                min: 1,
                                        max: <?php echo $max; ?>
                                }
                                }
                        });});
                        });
                        portfolio_thumb_width();
                        jQuery(window).resize(function() {
                          portfolio_thumb_width();
                      });
                  
                      function portfolio_thumb_width() {
                        var width = jQuery('body .team_carousel').width() + 30;
                        if (width > 784) {
                        if ( (<?php echo $max; ?> % 2) == 0) {
                          var new_width = ((width - (16 * (<?php echo $max;?>)+12)) / <?php echo $max; ?>);
                        } else {
                      		var new_width = ((width - (16 * (<?php echo $max;?>)+12)) / <?php echo $max; ?>);
                        }
                    		jQuery('body').append('<style>#<?php echo $block_id; ?> .team_cars .the_portfolio_list_li_div { max-width:'+new_width+'px; width:'+new_width+'px !important;}');
                      } else if ((width <= 784) && (width > 369))  {
                        var new_width = (width - 16) / 2;
                        jQuery('#<?php echo $block_id; ?> .team_cars .the_portfolio_list_li_div').css('width', new_width);
                        jQuery('#<?php echo $block_id; ?> .team_cars .the_portfolio_list_li_div').css('max-width', new_width);
                      } else if (width <= 369) {
                        jQuery('#<?php echo $block_id; ?> .team_cars .the_portfolio_list_li_div').css('width', width);
                        jQuery('#<?php echo $block_id; ?> .team_cars .the_portfolio_list_li_div').css('max-width', width);
                      }
                      }
                  		</script>
                      
                        
                </div>
            <?php endif; ?>

            <?php
        }

        function asalah_testimonials_carousel($block_id = "", $number = '9', $title = "Testimonials") {
            ?>

            <?php
            $wp_query = new WP_Query(array('post_type' => 'testimonial', 'posts_per_page' => $number));
            ?>
                    <?php if ($wp_query) : ?>
                <h3 class="page-header"><span class="page_header_title"><?php echo $title; ?></span><span id="right_car_arrow2" class="cars_arrow_control right_car_arrow"><i class="icon-angle-right"></i></span><span id="left_car_arrow2" class="cars_arrow_control left_car_arrow"><i class="icon-angle-left"></i></span></h3>
                <div class="testimonial_content carousel list_carousel responsive clearfix">
                    <ul class="testy_carousel clearfix">
                            <?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
                            <li class="clearfix testimonials_area">
                                <?php
                                if (has_post_thumbnail(get_the_ID())) {
                                    $image_url = wp_get_attachment_url(get_post_thumbnail_id(get_the_ID()));
                                    ?>
                                    <div class="span4 testimonials_image">
                                      
                                      
                                      <?php the_post_thumbnail(''); ?>
                                      
                                    </div>
            <?php } ?>
                                <div class="span8 testimonials_info">
                                  <div class="testimonial_box ">
                                    <p><?php the_content(); ?></p>
                                  </div>
                                    
                                    <a class="testimonial_url" target="_blank" href="<?php testimonial_url(); ?>">
                                        <div class="tetimonials_namejob clearfix">
                                            <span class="testimonial_name"><?php testimonial_author(); ?></span><span class="testimonial_job"><?php testimonial_job(); ?></span>
                                        </div>
                                    </a>
                                </div>
                            </li>
        <?php endwhile; ?>
                    </ul>
                </div>
                <script type="text/javascript" language="javascript">
                            jQuery(document).ready(function() {

                    //	Responsive layout, resizing the items
                    jQuery('.testy_carousel').carouFredSel({
                    responsive: true,
                            prev: '#left_car_arrow2',
                            next: '#right_car_arrow2',
                            auto: false,
                            scroll: {
                            fx: "cover-fade",
                            },
                            swipe: {
                            onTouch: true,
                            },
                            items: {
                            visible: {
                            min: 1,
                                    max: 1
                            }
                            }
                    });

                    jQuery('.testy_carousel').imagesLoaded( function () {
                    jQuery('.testy_carousel').carouFredSel({
                    responsive: true,
                            prev: '#left_car_arrow2',
                            next: '#right_car_arrow2',
                            auto: false,
                            scroll: {
                            fx: "cover-fade",
                            },
                            swipe: {
                            onTouch: true,
                            },
                            items: {
                            visible: {
                            min: 1,
                                    max: 1
                            }
                            }
                    });});
                    });</script>
            <?php endif; ?>

            <?php
        }


        function asalah_clients_carousel($block_id ="", $number='9', $title='Clients', $order = 'date', $show_number = '6', $autoplay_car = 'no') {
        	global $post;
        	?>

        	 <?php
           $title = ($title != '') ? $title : 'Clients';
           $show_number = ($show_number != '') ? $show_number : '6';
           $number = ($number != '') ? $number : '9';
           $autoplay_car = ($autoplay_car != '') ? $autoplay_car : '';
           if ($autoplay_car == 'yes') {
             $autoplay = 'true';
           } else {
             $autoplay = 'false';
           }
           $args = array('post_type' => 'Client', 'posts_per_page' => $number, 'orderby' => $order);
           if ($order == 'title') {
             $args['order'] = 'ASC';
           }
        		$wp_query = new WP_Query($args);
        	 ?>
        	 <?php if ( $wp_query ) : ?>
        	 		<div id="<?php echo $block_id; ?>">
                    <h3 class="page-header"><span class="page_header_title"><?php echo $title; ?></span><span id="right_car_arrow3" class="cars_arrow_control right_car_arrow"><i class="icon-angle-right"></i></span><span id="left_car_arrow3" class="cars_arrow_control left_car_arrow"><i class="icon-angle-left"></i></span></h3>

                    <div class="clients_content">
                        <div class="clients_box ">
                        	<ul class="clients_list">
                            <?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>

                            <?php $the_client_url = get_post_meta($post->ID, 'client_url', true); ?>

                            <li><a style="display:block" target="_blank" href="<?php echo $the_client_url; ?>" class="post-tooltip tooltip-n" original-title="<?php the_title(); ?>"><div class="client_item clearfix" style="position: relative;"><?php client_logo(); ?></div></a></li>
                            <?php endwhile; ?>
                        	</ul>
                        </div>
                    </div>
                    </div>
                <script type="text/javascript" language="javascript">

        			jQuery(document).ready(function($) {


        			var owl = jQuery("#<?php echo $block_id; ?> .clients_list");

        			   owl.owlCarousel({
        			       items : <?php echo $show_number;?>, //10 items above 1000px browser width
        			       itemsDesktop : [1000,6], //5 items between 1000px and 901px
        			       itemsDesktopSmall : [900,5], // betweem 900px and 601px
        			       itemsTablet: [600,3], //2 items between 600 and 0
        			       itemsMobile : false, // itemsMobile disabled - inherit from itemsTablet option
        			       pagination : false,
        			       scrollPerPage: true,
        			       slideSpeed: 1000,
                     autoPlay: <?php echo $autoplay; ?>,
                     autoplaySpeed: 1000,

        			   });
                  <?php if ($show_number >= $number) { ?>
                   jQuery("#<?php echo $block_id; ?> #right_car_arrow3").hide();
                   jQuery("#<?php echo $block_id; ?> #left_car_arrow3").hide();
                 <?php }?>
        			   // Custom Navigation Events
        			   jQuery("#<?php echo $block_id; ?> #right_car_arrow3").click(function(){
        			     owl.trigger('owl.next');
        			   })
        			   jQuery("#<?php echo $block_id; ?> #left_car_arrow3").click(function(){
        			     owl.trigger('owl.prev');
        			   })
                 
        			});
        		</script>
            <?php endif; ?>
        <?php
        }

        function asalah_posts_list($posttype = 'post', $number = '3', $order = "date", $cat = '') {

            if ($cat != '') {
              $box_cat = get_category_by_slug($cat);
              if ($box_cat) {
                $cat = $box_cat->term_id;
                $args['cat'] = $cat;
              }
            }

            if ($posttype != '') {
              $args['post_type'] = $posttype;
            }

            if ($number != '') {
              $args['posts_per_page'] = $number;
            }

            if ($order != '') {
              $args['orderby'] = $order;
            }

            $wp_query = new WP_Query($args);
            ?>
                <?php if ($wp_query) : ?>

                <div class="post_list itswidget">
        <?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
                        <div class="post_row clearfix">
                            <div class="post_thumbnail"><a class="thumbnail" href="<?php the_permalink(); ?>"><?php asalah_blog_thumb("370", "240") ?></a></div>
                            <div class="post_info">
                                <div class="post_title"><a href="<?php the_permalink(); ?>"><h6><?php the_title(); ?></h6></a></div>
                                <span class="blog_date meta_item"><?php echo get_the_date(); ?></span>

                            </div>
                        </div>
                <?php endwhile; ?>
                </div>
            <?php endif; ?>

            <?php
        }

        function asalah_breadcrumbs($last = "") {
            global $asalah_data;
            if (!is_home() && !$asalah_data['asalah_disable_breadcrumb']) {
                echo '<nav class="breadcrumb">';
                echo '<a href="' . home_url('/') . '">' . __("Home", "asalah") . '</a> <span class="divider">&raquo;</span> ';
                if (is_category()) {
                    the_category(' <span class="divider">&raquo;</span> ');
                } elseif (is_single()) {
                    if (get_post_type() != 'post') {
                        $post_type = get_post_type_object(get_post_type());
                        if (get_post_type() == 'post') {
                            if ($asalah_data['asalah_blog_url']) {
                                echo '<a href="' . $asalah_data['asalah_blog_url'] . '">';
                            }
                            echo $post_type->labels->name;
                            if ($asalah_data['asalah_blog_url']) {
                                echo '</a>';
                            }
                        } elseif (get_post_type() == 'project') {
                            if ($asalah_data['asalah_portfolio_url']) {
                                echo '<a href="' . $asalah_data['asalah_portfolio_url'] . '">';
                            }

                            $project_default = (!empty($asalah_data['asalah_translate_projects'])) ? $asalah_data['asalah_translate_projects'] : $post_type->labels->name ;
                            echo $project_default;
                            if ($asalah_data['asalah_portfolio_url']) {
                                echo '</a>';
                            }
                        } else {
                            echo $post_type->labels->name;
                        }

                        echo ' <span class="divider">&raquo;</span> ';
                        the_title();
                    } else {
                        the_category(' <span class="divider">&raquo;</span> ');
                        echo ' <span class="divider">&raquo;</span> ';
                        the_title();
                    }
                } elseif (is_page()) {
                    echo the_title();
                }
                if ($last != "") {
                    echo " " . $last;
                }
                echo '</nav>';
            }
        }

        function excerpt($limit) {
            $excerpt = explode(' ', get_the_excerpt(), $limit);
            if (count($excerpt) >= $limit) {
                array_pop($excerpt);
                $excerpt = implode(" ", $excerpt) . '...';
            } else {
                $excerpt = implode(" ", $excerpt);
            }
            $excerpt = preg_replace('`\[[^\]]*\]`', '', $excerpt);
            return $excerpt;
        }

        function random_id($length) {
            $characters = '23456789abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ';
            $max = strlen($characters) - 1;
            $string = '';

            for ($i = 0; $i < $length; $i++) {
                $string .= $characters[mt_rand(0, $max)];
            }

            return $string;
        }

        function get_twitter_followers($url) {
            $data = file_get_contents("http://query.yahooapis.com/v1/public/yql?q=SELECT%20*%20from%20html%20where%20url=%22" . $url . "%22%20AND%20xpath=%22//a[@class='js-nav']/strong%22&format=json"); // Opening the Query URL
            $data = json_decode($data); // Decoding the obtained JSON data
            $count = intval($data->query->results->strong[2]); // The count parsed from the JSON
            return $count; // Printing the count
        }

        function asalah_translat($id, $word) {
            global $asalah_data;
            if (!empty($asalah_data[$id])) {
                echo $asalah_data[$id];
            } else {
                _e($word, 'asalah');
            }
        }

        function asalah_twitter_tweets($consumerkey = '', $consumersecret = '', $accesstoken = '', $accesstokensecret = '', $screenname = '', $tweets_count = 2) {

            if (empty($consumerkey) || empty($consumersecret) || empty($accesstokensecret) || empty($accesstoken)) {
                return 'Your twitter application info is not set correctly in option panel, please create please login to twitter developers <a href="https://dev.twitter.com/apps" target="_blank">here</a>, create new application and new access tocken, then go to theme option panel social section and fill the data you got from application';
            } else {
                $twitter = new TwitterOAuth($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);

                $tweets = $twitter->get('statuses/user_timeline', array('screen_name' => $screenname, 'count' => $tweets_count));

                $output = '';

                if (is_array($tweets) && !isset($tweets->errors)) {
                    $i = 0;
                    $lnk_msg = NULL;

                    $output .= "<ul>";
                    foreach ($tweets as $tweet) {
                        $i++;

                        $lnk_page = 'https://twitter.com/#!/' . $screenname;
                        $page_name = $tweet->user->name;

                        $msg = $tweet->text;

                        if (is_array($tweet->entities->urls)) {
                            try {
                                if (array_key_exists('0', $tweet->entities->urls)) {
                                    $lnk_msg = $tweet->entities->urls[0]->url;
                                } else {
                                    $lnk_msg = NULL;
                                }
                            } catch (Exception $e) {
                                $lnk_msg = NULL;
                            }
                        }



                        $lnk_tweet = 'https://twitter.com/#!/' . $screenname . '/status/' . $tweet->id_str;


                        /* Tweet Time */
                        $time = strtotime($tweet->created_at);
                        $delta = abs(time() - $time); /* in seconds */
                        $result = '';
                        if ($delta < 1) {
                            $result = ' just now';
                        } elseif ($delta < 60) {
                            $result = $delta . ' seconds ago';
                        } elseif ($delta < 120) {
                            $result = ' about a minute ago';
                        } elseif ($delta < (45 * 60)) {
                            $result = ' about ' . round(($delta / 60), 0) . ' minutes ago';
                        } elseif ($delta < (2 * 60 * 60)) {
                            $result = ' about an hour ago';
                        } elseif ($delta < (24 * 60 * 60)) {
                            $result = ' about ' . round(($delta / 3600), 0) . ' hours ago';
                        } elseif ($delta < (48 * 60 * 60)) {
                            $result = ' about a day ago';
                        } else {
                            $result = ' about ' . round(($delta / 86400), 0) . ' days ago';
                        }


                        if ($i >= $tweets_count)
                            break;


                        $output .= '<li class="cat-item"><a href="' . $lnk_tweet . '" class="tweet_icon"><i class="icon-twitter"></i></a> <a class="tweet_name" href="' . $lnk_tweet . '">' . $screenname . '</a>';


                        $output .= $msg;

                        $output .= '<span class="tweet_time">' . $result . '</span></li>';
                    } /* foreach */

                    $output .= "</ul>";
                    return $output;
                    if (!empty($output)) {
                        //return; $output;
                    }
                } else {
                    if (isset($tweets->errors)):
                        $output .= '<span class="tweet_error">Message: ' . $tweets->errors[0]->message . ', Please check your Twitter Authentication Data or internet connection.</span>';
                    else:
                        $output .= '<span class="tweet_error">Please check your internet connection.</span>';
                    endif;

                    if (!empty($output)) {
                        return $output;
                    }
                }
            }
        }


        /* start woocommerce functions */

        remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
        remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
        remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
        remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);

        add_action('woocommerce_before_main_content', 'asalah_my_theme_wrapper_start', 10);
        add_action('woocommerce_after_main_content', 'asalah_my_theme_wrapper_end', 10);

        function asalah_my_theme_wrapper_start() {
            global $post;
            if (is_shop()) {
                $id = get_option('woocommerce_shop_page_id');
            } else {
                $id = $post->ID;
            }
            if (get_post_meta($id, 'asalah_custom_title_bg', true)): ?>
            <style>
            .page_title_holder {
                background-image: url('<?php echo get_post_meta($id, 'asalah_custom_title_bg', true);  ?>');
                background-repeat: no-repeat;
            }
            </style>
            <?php endif; ?>
            <div class="page_title_holder  container-fluid">
                    <div class="container">
                            <div class="page_info">
                                    <h1><?php echo get_the_title($id); ?></h1>
                            </div>
                            <div class="page_nav">

                            </div>
                    </div>
            </div>
            <?php
            echo '<section class="main_content"><div class="container single_blog blog_posts new_section">';
        }

        function asalah_my_theme_wrapper_end() {
            echo '</div></div>';
        }

        add_filter( 'woocommerce_page_title', 'asalah_woo_shop_page_title');

        function asalah_woo_shop_page_title( $page_title ) {

        }

        add_theme_support('woocommerce');

        /* Update Notice */

        function my_update_notice() {
          $current_theme_version = get_theme_mod('asalah_theme_version');
          $theme = wp_get_theme();


          if (!isset($current_theme_version) || ($current_theme_version != $theme->get('Version'))) {
            ?>
            <div class="updated is-dismissable notice bostan-update" style="position:relative;">
              <h1><img height="62" width="302" src="https://ahmad.works/bostan/wp-content/uploads/2013/06/logo_large1.png" alt="Bostan" /></h1>
                <h2><?php echo 'You have updated to version '. $theme->get("Version") .', Look what you\'ve got:'; ?></h2>
                <ul>
                  <li>- Include WPBakery Page Builder (Visual Composer) Update v 5.4.4.</li>
                </ul>
                <h2><div class="col-md-2">Have any question?<br>we're always here for help at <a href="https://ahmad.works/envatosupport">A-Support</a> :)</div><div class="col-md-2">Like the theme?<br>give us a high five at <a href="https://ahmad.works/go/tfdownload/">Themeforest</a> ;) </div></h2>
				<a class="notice-dismiss" href="?ignore_bostan_update_message=1"><span class="screen-reader-text">Dismiss this notice</span></a>
            </div>

            <style>
            .col-md-2 {
  width: 49%;
  text-align: center;
  display: inline-block;
}
            .bostan-update h1 {
  font-size: 35px !important;
  font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
  font-weight: 600;
}

.bostan-update ul {
  font-size: 15px;
  line-height: 20px;
  padding-left: 15px;
}

.bostan-update h2 .col-md-2 {
  line-height: 25px;
}
.bostan-update h2 {
  padding: 0;
  margin: 15px 0px;
}

.bostan-update a.notice-dismiss {
  text-decoration: none;
}

.bostan-update a.notice-dismiss:before {
  font-size: 20px;
}

.bostan-update {
  padding: 10px 15px !important;
}
</style>
            <?php
          }


        }
        
        add_action( 'admin_notices', 'my_update_notice' );
        
        add_action('admin_init', 'example_nag_ignore');

        function example_nag_ignore() {

          $theme = wp_get_theme();
                /* If user clicks to ignore the notice, add that to their user meta */
                if ( isset($_GET['ignore_bostan_update_message']) && '1' == $_GET['ignore_bostan_update_message'] ) {

                     $themeversion = $theme->get('Version');
                     set_theme_mod( 'asalah_theme_version', $themeversion );
        	}
        }

        /* License Notice */

        function my_license_notice() {
          $current_license_note = get_theme_mod('asalah_license_notice');

          if (empty($current_license_note)) {
            ?>
            <div class="updated is-dismissable notice" style="position:relative;">
                <h2>Notice:</h2>
                <b>The “Regular License” of Bostan theme gives you the write to use it in one website only, if you want to use the theme for multiple sites, you need to purchase a license for each site. thanks.</b>
                <p><a href="http://themeforest.net/item/bostan-retina-responsive-multipurpose-theme/5030415?ref=ahmadworks&utm_source=panel&utm_medium=license_notice">Purchase Bostan License Now</a> | <a href="?ignore_bostan_license_message=1">Dismiss this notice</a></p>
                <a class="notice-dismiss" href="?ignore_bostan_license_message=1"><span class="screen-reader-text">Dismiss this notice</span></a>
            </div>
            <?php
          }
        }
        add_action( 'admin_notices', 'my_license_notice' );

        add_action('admin_init', 'license_ignore');

        function license_ignore() {

                /* If user clicks to ignore the notice, add that to their user meta */
                if ( isset($_GET['ignore_bostan_license_message']) && '1' == $_GET['ignore_bostan_license_message'] ) {

                     set_theme_mod( 'asalah_license_notice', true );
        	}
        }

        if (!asalah_option('asalah_autoupdate_notice')) {
             if (!class_exists('Envato_WP_Toolkit')) {
             	/* Update Notice */

             	function update_plugin_missing() {

             			?>
             			<div class="error is-dismissable" style="position:relative;">
             					<p>It seems that you don't have Envato Toolkit activated, please install it so that you could be notified automatically of new Bostan updates!</p>
             					<p><b>You could download the plugin <a href="https://github.com/envato/envato-wordpress-toolkit/archive/master.zip">here</a></p>
                       <a class="notice-dismiss" href="?ignore_bostan_autoupdate_message=1"><span class="screen-reader-text">Dismiss this notice</span></a>
             			</div>
             			<?php
             	}
             	add_action( 'admin_notices', 'update_plugin_missing' );

               add_action('admin_init', 'autoupdate_ignore');

               function autoupdate_ignore() {

                       /* If user clicks to ignore the notice, add that to their user meta */
                       if ( isset($_GET['ignore_bostan_autoupdate_message']) && '1' == $_GET['ignore_bostan_autoupdate_message'] ) {

                            set_theme_mod( 'asalah_autoupdate_notice', true );
               	}
               }
             } else {
             function envato_toolkit_credentials_admin_notices() {
             	?>
             	<div class="error" style="position:relative;">
             			<p>It seems that you didn't enter your username and API key at Envato Toolkit plugin used for Bostan auto updates yet!</p>
             			<p><b>Please go to <a href="<?php echo admin_url('?page=envato-wordpress-toolkit');?>">plugin's settings page</a>.
             			</br>if you didn't generate your API key yet, you can get it through (My Settings) page at your Themeforest account and then choose API Keys tab where you can generate a free API key. :)</p>
             	</div>
             	<?php
             }
             	// Use credentials used in toolkit plugin so that we don't have to show our own forms anymore
             $credentials = get_option( 'envato-wordpress-toolkit' );
             if ( empty( $credentials['user_name'] ) || empty( $credentials['api_key'] ) ) {
                 add_action( 'admin_notices', 'envato_toolkit_credentials_admin_notices' );
                 return;
             }

             }
           }

           if (!function_exists('asalah_project_karsa_fix')) {
             function asalah_project_karsa_fix() {
               /* Project Portfolio Option Fix */

               if (!asalah_cross_option('asalah_project_karsa_fix')) {
                 global $asalah_data;
                 if ( (!asalah_cross_option('asalah_project_layout')) && (asalah_cross_option('asalah_post_layout')) ) {
                   $layout = asalah_cross_option('asalah_post_layout');
                   $asalah_data['asalah_project_layout'] = $layout;
                   set_theme_mod('asalah_project_layout', $layout);
                 }

                 if ( (!asalah_cross_option('asalah_project_meta_info')) && (asalah_cross_option('asalah_post_meta_info')) ) {
                   $meta = asalah_cross_option('asalah_post_meta_info');
                   $asalah_data['asalah_project_meta_info'] = $meta;
                   set_theme_mod('asalah_project_meta_info', $meta);
                 }

                 if ( (!asalah_cross_option('asalah_project_share_box')) && (asalah_cross_option('asalah_post_share_box')) ) {
                   $share = asalah_cross_option('asalah_post_share_box');
                   $asalah_data['asalah_project_share_box'] = $share;
                   set_theme_mod( 'asalah_project_share_box', $share );
                 }

                 set_theme_mod( 'asalah_project_karsa_fix', true );
               }
             }
           }

           add_action('admin_init', 'asalah_project_karsa_fix');

         if (!get_theme_mod('asalah_new_post_format')) {
           if (!function_exists('asalah_convert_new_post_format')) {
             function asalah_convert_new_post_format() {
                 $posts_array = get_posts(array('post_type' => array('post', 'project'), 'numberposts' => -1));
                 foreach ( $posts_array as $post ) {
                   $post_id = $post->ID;
                   if ((get_post_meta($post_id, 'asalah_post_type', true)) && (get_post_meta($post_id, 'asalah_post_type', true) != 'none')) {
                     $old_post_type = get_post_meta($post_id, 'asalah_post_type', true);

                     if ($old_post_type == 'featured') {
                       // Set Post Format to Image
                       $post_format_post = 'image';
                       set_post_format($post->ID, $post_format_post );

                     } else if ($old_post_type == 'video') {
                       // Set Post Format to Video
                       $post_format_post = 'video';
                       set_post_format($post->ID, $post_format_post );

                       // Check video url field
                       if (get_post_meta($post_id, 'asalah_video_url', true) != '') {
                         $video_url = get_post_meta($post_id, 'asalah_video_url', true);

                         // Set or update post format video url to post meta
                         if ( ! add_post_meta($post_id, '_format_video_embed', $video_url, true ) ) {
                           update_post_meta($post_id, '_format_video_embed', $video_url );
                        }
                       }
                     } else if ($old_post_type == 'quote') {
                       // Set Post Format to Quote
                       $post_format_post = 'quote';
                       set_post_format($post->ID, $post_format_post );
                       // Check Quote Text field
                       if (get_post_meta($post->ID, 'asalah_quote_text', true) != '') {
                         $quote_text = get_post_meta($post->ID, 'asalah_quote_text', true);

                         // Set or update post format quote text to post meta
                         if ( ! add_post_meta($post_id, '_format_quote_source_content', $quote_text, true ) ) {
                           update_post_meta($post_id, '_format_quote_source_content', $quote_text );
                         }
                       }
                       // Check Quote Author field
                       if (get_post_meta($post->ID, 'asalah_quote_author', true) != '') {
                         $quote_author = get_post_meta($post->ID, 'asalah_quote_author', true);

                         // Set or Update post format quote author to post meta
                         if ( ! add_post_meta($post_id, '_format_quote_source_name', $quote_author, true ) ) {
                           update_post_meta($post_id, '_format_quote_source_name', $quote_author );
                         }
                       }
                     } else if ($old_post_type == 'soundcloud') {
                       // Set Post Format to Audio
                       $post_format_post = 'audio';
                       set_post_format($post->ID, $post_format_post );

                       // Check Audio url field
                       if (get_post_meta($post->ID, 'asalah_soundcloud_url', true) != '') {
                         $audio_url = get_post_meta($post->ID, 'asalah_soundcloud_url', true);

                         // Set or Update Post Format audio url to post meta
                         if ( ! add_post_meta($post_id, '_format_audio_embed', $audio_url, true ) ) {
                           update_post_meta($post_id, '_format_audio_embed', $audio_url );
                         }
                       }
                     } else if ($old_post_type ==  'attached') {
                       // Set Post Format to Gallery
                        $post_format_post = 'gallery';
                        set_post_format($post->ID, $post_format_post );

                     } else if ($old_post_type == 'url') {
                       // Set Post format to Link
                       $post_format_post = 'link';
                       set_post_format($post->ID, $post_format_post );

                       // Check url destination field
                       if (get_post_meta($post->ID, 'asalah_url_destination', true) != '') {
                         $url_destination = get_post_meta($post->ID, 'asalah_url_destination', true);

                         // Set or Update Post Format url destination to post meta
                         if ( ! add_post_meta($post_id, '_format_link_url', $url_destination, true ) ) {
                           update_post_meta($post_id, '_format_link_url', $url_destination );
                         }

                       }

                       // Check URL text field
                       if (get_post_meta($post->ID, 'asalah_url_text', true) != '') {
                         $url_text = get_post_meta($post->ID, 'asalah_url_text', true);

                         // Set or Update Post Format url text to post meta
                         if ( ! add_post_meta($post_id, '_format_link_url_text', $url_text, true ) ) {
                           update_post_meta($post_id, '_format_link_url_text', $url_text );
                         }

                       }
                     }

                   }
  			          }
                  set_theme_mod( 'asalah_new_post_format', true );
                }
              }
              add_action('after_setup_theme', 'asalah_convert_new_post_format', 20);
           }
           add_action('admin_init', 'asalah_import_theme_options');

           function asalah_import_theme_options() {

                   /* If user clicks to ignore the notice, add that to their user meta */
                   if ( isset($_GET['import_theme_options_demo']) && '1' == $_GET['import_theme_options_demo'] ) {

                     // Import Theme Options
                     $theme_options_txt = get_template_directory() . '/framework/importer/main/theme_options.txt'; // theme options data file
                     $theme_options_txt = file_get_contents( $theme_options_txt );

                     $smof_data = unserialize( base64_decode( $theme_options_txt)  ); //100% safe - ignore theme check nag
                     of_save_options($smof_data);
                     wp_redirect(admin_url('themes.php?page=optionsframework'));
            }
           }
			add_action('wp_dashboard_setup', 'remove_wpseo_dashboard_overview' );
			function remove_wpseo_dashboard_overview() {
  			// In some cases, you may need to replace 'side' with 'normal' or 'advanced'.
  			remove_meta_box( 'wpseo-dashboard-overview', 'dashboard', 'side' );
}
        ?>
						