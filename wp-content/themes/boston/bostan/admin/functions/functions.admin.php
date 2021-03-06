<?php
/**
 * SMOF Admin
 *
 * @package     WordPress
 * @subpackage  SMOF
 * @since       1.4.0
 * @author      Syamil MJ
 */


/**
 * Head Hook
 *
 * @since 1.0.0
 */
function of_head() { do_action( 'of_head' ); }

/**
 * Add default options upon activation else DB does not exist
 *
 * DEPRECATED, Class_options_machine now does this on load to ensure all values are set
 *
 * @since 1.0.0
 */
function of_option_setup()
{
	global $of_options, $options_machine;
	$options_machine = new Options_Machine($of_options);

	if (!of_get_options())
	{
		of_save_options($options_machine->Defaults);
	}
}

/**
 * Change activation message
 *
 * @since 1.0.0
 */
function optionsframework_admin_message() {

	//Tweaked the message on theme activate
	?>
    <script type="text/javascript">
    jQuery(function(){

        var message = '<div class="ratenotice"><h1>Welcome To Bostan</h1><h2>if you know how much time and effort we spent to make this work, and will spend to improve it and offer support to you, you would give us 5 stars</h2><img class="starsrating" src="<?php echo get_template_directory_uri()?>/admin/staratings.png" /><a class="ratinglink" href="http://themeforest.net/downloads" target="_blank">Click Here To Rate</a></div><p>This theme comes with an <a href="<?php echo admin_url('admin.php?page=optionsframework'); ?>">options panel</a> to configure settings. This theme also supports widgets, please visit the <a href="<?php echo admin_url('widgets.php'); ?>">widgets settings page</a> to configure them.</p>';
    	jQuery('.themes-php #message2').html(message);

    });
    </script>
    <?php

}

/**
 * Get header classes
 *
 * @since 1.0.0
 */
function of_get_header_classes_array()
{
	global $of_options;

	foreach ($of_options as $value)
	{
		if ($value['type'] == 'heading')
			$hooks[] = str_replace(' ','',strtolower($value['name']));
	}

	return $hooks;
}

/**
 * Get options from the database and process them with the load filter hook.
 *
 * @author Jonah Dahlquist
 * @since 1.4.0
 * @return array
 */
function of_get_options($key = null, $asalah_data = null) {
	global $smof_data;

	do_action('of_get_options_before', array(
		'key'=>$key, 'data'=>$asalah_data
	));
	if ($key != null) { // Get one specific value
		$asalah_data = get_theme_mod($key, $asalah_data);
	} else { // Get all values
		$asalah_data = get_theme_mods();
	}
	$asalah_data = apply_filters('of_options_after_load', $asalah_data);
	if ($key == null) {
		$smof_data = $asalah_data;
	} else {
		$smof_data[$key] = $asalah_data;
	}
	do_action('of_option_setup_before', array(
		'key'=>$key, 'data'=>$asalah_data
	));
	return $asalah_data;

}

/**
 * Save options to the database after processing them
 *
 * @param $asalah_data Options array to save
 * @author Jonah Dahlquist
 * @since 1.4.0
 * @uses update_option()
 * @return void
 */

function of_save_options($asalah_data, $key = null) {
	global $smof_data;
    if (empty($asalah_data))
        return;
    do_action('of_save_options_before', array(
		'key'=>$key, 'data'=>$asalah_data
	));
	$asalah_data = apply_filters('of_options_before_save', $asalah_data);
	if ($key != null) { // Update one specific value
		if ($key == BACKUPS) {
			unset($asalah_data['smof_init']); // Don't want to change this.
		}
		set_theme_mod($key, $asalah_data);
	} else { // Update all values in $asalah_data
		foreach ( $asalah_data as $k=>$v ) {
			if (!isset($smof_data[$k]) || $smof_data[$k] != $v) { // Only write to the DB when we need to
				set_theme_mod($k, $v);
			} else if (is_array($v)) {
				foreach ($v as $key=>$val) {
					if ($key != $k && $v[$key] == $val) {
						set_theme_mod($k, $v);
						break;
					}
				}
			}
	  	}
	}
    do_action('of_save_options_after', array(
		'key'=>$key, 'data'=>$asalah_data
	));

}


/**
 * For use in themes
 *
 * @since forever
 */



$asalah_data = of_get_options();
if (!isset($smof_details))
	$smof_details = array();