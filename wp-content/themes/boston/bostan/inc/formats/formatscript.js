jQuery( document ).ready(function() {

	jQuery('.asalah_format_field').insertAfter(jQuery('#titlediv'));

    jQuery('#post-formats-select input').each(function() {
        if(jQuery(this).is(':checked')) {
            boxClass = '.asalah_format_field_' + jQuery(this).attr('value');
            jQuery(boxClass).show();
        }
    });

    jQuery('#post-formats-select input').on('change', function() {
        jQuery('.asalah_format_field').hide();
    	boxClass = '.asalah_format_field_' + jQuery(this).attr('value');
    	jQuery(boxClass).show();
    });

    var asalah = asalah || {};
    asalah.asalahpostFormats = function(jQuery) {
    	return {
    		asalahgallerySortable: function() {
    			$galleryPreview = jQuery('#asalah_box_for_post-format-gallery .gallery');
    			$galleryPreview.sortable({
    				containment: 'parent',
    				cursor: 'move',
    				forceHelperSize: true,
    				forcePlaceholderSize: true,
    				update: function() {
    					var ids = [];
    					$galleryPreview.find('img.attachment-thumbnail').each(function() {
    						ids.push(jQuery(this).data('id'));
    					});

    					jQuery.post(
    						ajaxurl,
    						{
    							'action': 'asalah_gallery_menu_order',
    							'order': ids
    						}
    					);
    				}
    			});
    		}
    	};
    }(jQuery);

    jQuery(document).on('click focus', '#cfpf-format-gallery-shortcode', function() {
    	jQuery('#cfpf-format-gallery-type-shortcode').prop('checked', true);
    });

    var gallery;
    var $gallery_ids = [];
    var $gallery_shortcode = '';

    var $addImageLink = jQuery('#asalah_box_for_post-format-gallery .none a');
    var $preview_images = jQuery('#asalah_box_for_post-format-gallery .srp-gallery');

    var update = function(){
    	var ids = '',
    		arr_images = [];

    	if( $preview_images.find('span').length > 0 ){
    		$preview_images.find('span').each(function(i){
    			arr_images[i] = jQuery(this).data('id');
    		});
    	}
    	else{
    		jQuery('#cfpf-format-gallery-shortcode').val('');
    	}


    	if (arr_images.length > 0){
    		ids = arr_images.join(',');
    	}

    	if( ids !== '' ){
    		$gallery_shortcode = '[gallery type="post_format" ids="' + ids + '"]';
    		jQuery('#cfpf-format-gallery-shortcode').val($gallery_shortcode);
    	}
    }

    // Remove image
    $preview_images.on('click', 'span i', function() {
    	jQuery(this).parent('span').css('border-color', '#f03').fadeOut(300, function() {
    		jQuery(this).remove();
    		update();
    	});
    });

    // Add New Images
    $addImageLink.on('click', function(e) {
    	//$('#wp-content-media-buttons .insert-media').mousedown().mouseup().click();
    	e.preventDefault();

    	if( gallery ){
    		gallery.open();
    		return;
    	}

    	gallery = wp.media.frames.gallery = wp.media({
    		title: 'Customize your own gallery',
    		library: {
    			type: 'image'
    		},
    		multiple: true
    	});
    

    	gallery.on('select', function() {
    		var files = gallery.state().get('selection').toJSON();
    		//$preview_images.find('em').remove();
    		
    		jQuery.each(files, function(i) {
    			$preview_images.append('<span data-id="' + this.id + '" title="' + this.title + '"><img src="' + this.url + '" alt="" /><i class="srp-dashicons"></i></span>');
    		});

    		update();
    	}).open();

    });


    $preview_images.sortable({
    	containment: 'parent',
    	cursor: 'move',
    	forceHelperSize: true,
    	forcePlaceholderSize: true,

    	stop: function() {
    		update();
    	}
    });


    asalah.asalahpostFormats.asalahgallerySortable();
});