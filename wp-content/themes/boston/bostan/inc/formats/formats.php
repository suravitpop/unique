<?php

function asalah_format_scripts() {

	/* --------
	add theme styles
	------------------------------------------- */
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/inc/formats/formatstyle.css', array(), '1' );

	/* --------
	include format scripts
	------------------------------------------- */
	wp_enqueue_script( 'asalah-test', get_template_directory_uri() . '/inc/formats/formatscript.js', array( 'jquery' ), '1', true );

	/* --------
	add sortable library for gallery
	------------------------------------------- */
	global $pagenow;
	if (in_array($pagenow, array('post.php', 'post-new.php'))) {
		wp_enqueue_script('jquery-ui-sortable');
	}

	$post_formats = get_theme_support('post-formats');
	if (in_array('gallery', $post_formats[0])) {
		add_action('save_post', 'asalah_format_gallery_save_post');
	}
	if (in_array('video', $post_formats[0])) {
		add_action('save_post', 'asalah_format_video_save_post');
	}
	if (in_array('audio', $post_formats[0])) {
		add_action('save_post', 'asalah_format_audio_save_post');
	}
	if (in_array('quote', $post_formats[0])) {
		add_action('save_post', 'asalah_format_quote_save_post');
	}
	if (in_array('link', $post_formats[0])) {
		add_action('save_post', 'asalah_format_link_save_post');
	}

}
add_action( 'admin_init', 'asalah_format_scripts' );

function asalah_format_gallery_save_post( $post_id ) {
	if (!defined('XMLRPC_REQUEST')) {
		$keys = array(
			'_format_gallery_shortcode',
			'_format_gallery_type'
		);
		foreach ($keys as $key) {
			if (isset($_POST[$key])) {
				update_post_meta($post_id, $key, $_POST[$key]);
			}
		}
	}
}
function asalah_format_video_save_post($post_id) {
	if (!defined('XMLRPC_REQUEST') && isset($_POST['_format_video_embed'])) {
		update_post_meta($post_id, '_format_video_embed', $_POST['_format_video_embed']);
	}
}
// action added in asalah_admin_init()

function asalah_format_audio_save_post($post_id) {
	if (!defined('XMLRPC_REQUEST') && isset($_POST['_format_audio_embed'])) {
		update_post_meta($post_id, '_format_audio_embed', $_POST['_format_audio_embed']);
	}
}

function asalah_format_quote_save_post($post_id) {
	if (!defined('XMLRPC_REQUEST') && isset($_POST['_format_quote_source_content'])) {
		update_post_meta($post_id, '_format_quote_source_content', $_POST['_format_quote_source_content']);
	}
	if (!defined('XMLRPC_REQUEST') && isset($_POST['_format_quote_source_url'])) {
		update_post_meta($post_id, '_format_quote_source_url', $_POST['_format_quote_source_url']);
	}
	if (!defined('XMLRPC_REQUEST') && isset($_POST['_format_quote_source_name'])) {
		update_post_meta($post_id, '_format_quote_source_name', $_POST['_format_quote_source_name']);
	}
}

function asalah_format_link_save_post($post_id) {
	if (!defined('XMLRPC_REQUEST') && isset($_POST['_format_link_url'])) {
		update_post_meta($post_id, '_format_link_url', $_POST['_format_link_url']);
	}
	if (!defined('XMLRPC_REQUEST') && isset($_POST['_format_link_url_text'])) {
		update_post_meta($post_id, '_format_link_url_text', $_POST['_format_link_url_text']);
	}
}

add_action('save_post', 'save_asalah_formats');

function save_asalah_formats() {
    global $post;

    if ( isset($post) ) : // check if post is exists

    /* Verify the nonce before proceeding. */
    // if ( !isset( $_POST['page_blog_template_options'] ) || !wp_verify_nonce( $_POST['page_blog_template_options'], basename( __FILE__ ) ) )
    //     return $post->ID;

    /* Get the post type object. */
    $post_type = get_post_type_object( $post->post_type );

    /* Check if the current user has permission to edit the post. */
    if ( !current_user_can( $post_type->cap->edit_post, $post->ID ) )
        return $post->ID;

    $custom_meta_fields = array(
        '',
    );

    foreach ($custom_meta_fields as $custom_meta_field) {

        if (isset($_POST[$custom_meta_field])):
            update_post_meta($post->ID, $custom_meta_field, htmlspecialchars(stripslashes($_POST[$custom_meta_field])));
        else:
            if (isset($post->ID) && isset($custom_meta_field) && $custom_meta_field != '') {
                delete_post_meta($post->ID, $custom_meta_field);
            }
        endif;
    }

    endif; // end if check if post is exists
}

// //require get_template_directory() . '/inc/formats/formats.php';
// function asalah_formats_metaboxes() {
//     $global_types = array('post','page', 'project', 'product');
//     $types = array('post', 'page');
//
//     // add meta box for commons options in posts and pages
//
//     add_meta_box("gallery_options", sprintf(__('%s - Post Gallery.', 'asalah'), theme_name), "asalah_gallery_box", "post", "normal", "core");
// }
// add_action("admin_init", "asalah_formats_metaboxes");

function asalah_format_boxes_area($post_type) {
	if (post_type_supports($post_type, 'post-formats') && current_theme_supports('post-formats')) {
		add_action('edit_form_after_title', 'asalah_format_meta_boxes');
	}
}
add_action('edit_form_after_title', 'asalah_format_meta_boxes');


function asalah_format_meta_boxes() {
	$post_formats = get_theme_support('post-formats');
	if (!empty($post_formats[0]) && is_array($post_formats[0])) {
		global $post;
		$current_post_format = get_post_format(get_the_id());

		// support the possibility of people having hacked in custom
		// post-formats or that this theme doesn't natively support
		// the post-format in the current post - a tab will be added
		// for this format but the default WP post UI will be shown ~sp
		if (!empty($current_post_format) && !in_array($current_post_format, $post_formats[0])) {
			array_push($post_formats[0], get_post_format_string($current_post_format));
		}
		array_unshift($post_formats[0], 'standard');
		$post_formats = $post_formats[0];

		$formats = array(
			'link',
			'quote',
			'video',
			'gallery',
			'audio',
			'status',
		);

		foreach ($formats as $format) {
			if (in_array($format, $post_formats)) {
				get_template_part( '/inc/formats/boxes/format', $format );
			}
		}
	}
}

function asalah_post_gallery_type() {
	$post = get_post();
	$value = get_post_meta(get_the_id(), '_format_gallery_type', true);
	switch ($value) {
		case 'shortcode':
		case 'attached-images':
			$value = $value;
		break;
		default:
			$value = 'shortcode';
	}
	return $value;
}

function asalah_post_has_gallery($post_id) {
	if (empty($post_id)) {
		global $post;
		$post_id = $post->ID;
	}
	if (asalah_post_gallery_type() == 'shortcode') {
		$shortcode = get_post_meta($post_id, '_format_gallery_shortcode', true);
		return (bool) !empty($shortcode);
	}
	else {
		$images = get_posts(array(
			'post_type' => 'attachment',
			'post_mime_type' => 'image',
			'post_status' => null,
			'post_parent' => $post_id,
			'order' => 'ASC',
			'orderby' => 'menu_order ID',
		));
		return (bool) $images->post_count;
	}
}

function asalah_gallery_menu_order() {
	if (!empty($_POST['order']) && is_array($_POST['order'])) {
		$i = 0;
		foreach ($_POST['order'] as $post_id) {
			$post_id = intval($post_id);
			if ($post_id) {
				wp_update_post(array(
					'ID' => $post_id,
					'menu_order' => $i
				));
				++$i;
			}
		}
		header('Content-type: text/javascript');
		echo json_encode(array(
			'result' => 'success'
		));
		die();
	}
}
add_action('wp_ajax_asalah_gallery_menu_order', 'asalah_gallery_menu_order');
