<?php
/** Notifications block **/

if(!class_exists('AQ_testicar_Block')) {
	class AQ_testicar_Block extends AQ_Block {
		
		//set and create block
		function __construct() {
			$block_options = array(
				'name' => 'Testimonials Carousel',
				'size' => 'span6',
			);
			
			//create the block
			parent::__construct('AQ_testicar_Block', $block_options);
		}
		
		function form($instance) {
			
			$defaults = array(
				'title' => '',
				'postnumber' => '',
			);
			$instance = wp_parse_args($instance, $defaults);
			extract($instance);
			
			?>
			
			<p class="description">
				<label for="<?php echo $this->get_field_id('title') ?>">
					Title<br/>
					<?php echo aq_field_input('title', $block_id, $title) ?>
				</label>
			</p>
			<p class="description">
				<label for="<?php echo $this->get_field_id('postnumber') ?>">
					Number Of Testimonials<br/>
					<?php echo aq_field_input('postnumber', $block_id, $postnumber) ?>
				</label>
			</p>
			<?php
			
		}
		
		function block($instance) {
			extract($instance);
			$the_id = "aq-block-" . $number;
			?>
			<div class="span12">
			<?php asalah_testimonials_carousel($the_id,$postnumber,$title); ?>
			</div>
			
			<?php
		}
		
	}
}