jQuery(document).ready(function() {

	jQuery(".sliding_item").click(function()
	{
		if ( jQuery(".loader_container").hasClass("hidden") ) {
			if ( jQuery(this).attr('rel') != '' ) {
				var slider_id = "#" + jQuery(this).attr('rel');
				jQuery(".slide_content").addClass("hidden");
				jQuery(slider_id).removeClass("hidden");
				jQuery(slider_id).addClass("current_slide_row");
				jQuery(this).addClass("current_sliding_item");
			}
			jQuery(this).find(".sliding_arrow").slideDown("fast").removeClass("hidden");
			jQuery(".loader_container").slideToggle("fast").removeClass("hidden");


		}else{
			var slider_id = "#" + jQuery(this).attr('rel');
			if ( slider_id != '' && jQuery(slider_id).hasClass("current_slide_row") ) {
				jQuery(".loader_container").slideToggle("fast").addClass("hidden");
				if ( jQuery(this).attr('rel') != '' ) {
					var slider_id = "#" + jQuery(this).attr('rel');
					jQuery(this).find(".sliding_arrow").slideUp("fast").addClass("hidden");
					jQuery(slider_id).addClass("hidden");
					jQuery(slider_id).removeClass("current_slide_row");
				}
			}else{

				jQuery(".current_slide_row").addClass("hidden").removeClass("current_slide_row");
				jQuery(".current_sliding_item > .sliding_arrow").addClass("hidden");
				jQuery(".loader_container").slideToggle("fast").addClass("hidden");
				var slider_id = jQuery(this).attr('rel');
				jQuery("#"+ slider_id).removeClass("hidden");
				jQuery("#"+ slider_id).addClass("current_slide_row");
				jQuery(this).addClass("current_sliding_item");
				jQuery(this).find(".sliding_arrow").slideDown("fast").removeClass("hidden");
				jQuery(".loader_container").slideToggle("fast").removeClass("hidden");



			}
		}
	});


	var belowheader = (jQuery('#below_header').offset().top) ;


	if (jQuery('#below_header').hasClass('headerissticky')) {
	jQuery(window).scroll(function(){
		fixedheader();
	});
	jQuery(document).ready(function(){
		fixedheader();
	});
	jQuery(window).resize(function(){
		fixedheader();
	});


	var headerHeight = jQuery('.below_header').innerHeight();
	jQuery('body').append('<div class="below_header fixed_header" style="opacity:0; z-index:-2; position:absolute;top:0;"><div class="logo"><img class="default_logo" style="display:block;" /></div></div>');
	var fixedHeight = jQuery('.fixed_header').innerHeight();
	var belowheader = (jQuery('#below_header').offset().top) + (headerHeight) - fixedHeight;
	
	jQuery('.hidden_header').height(headerHeight);
	function fixedheader(){
		var scrolling = jQuery(window).scrollTop();

		if(scrolling > (belowheader)){
			jQuery('.hidden_header').addClass('show');
			jQuery('#below_header .gototop').addClass('show');
			jQuery('#below_header').addClass('fixed_header');
			if (jQuery('.admin-bar').length !== false && jQuery('#wpadminbar').css('position') == 'fixed') {
				var adminHeight = jQuery('#wpadminbar').innerHeight();
				jQuery('#below_header.fixed_header').css('top', adminHeight);
			}
			} else if(scrolling < (belowheader)){
			jQuery('#below_header .gototop').removeClass('show');
			jQuery('.hidden_header').removeClass('show');
			jQuery('#below_header').removeClass('fixed_header');
		}
	}
	}

	jQuery('.gototop').click(function(){
		jQuery('html, body').animate({scrollTop: '0px'}, 800);
		return false;
	});
});


jQuery(document).ready(function() {


	jQuery('.galleryslider').flexslider({
		animation: "fade",
		directionNav: true,
		controlNav: false,
		slideshow: false,
		pauseOnHover: true,
	});



	// portfolio icon hoever effect
	jQuery(".portfolio_item").hover(
	function()
	{
		jQuery(this).find(".he-view").addClass("he-view-show");
		// jQuery(".center-bar a").addClass("elasticInUp");
		jQuery(this).find(".goup").addClass("elasticInUp");
		jQuery(this).find(".godown").addClass("elasticInDown");
		jQuery(this).find(".he-view .bg").addClass("fadeIn");


	},function()
	{
		jQuery(this).find(".he-view").removeClass("he-view-show");
		// jQuery(".center-bar a").removeClass("elasticInUp");
		jQuery(this).find(".goup").removeClass("elasticInUp");
		jQuery(this).find(".godown").removeClass("elasticInDown");
		jQuery(this).find(".he-view .bg").removeClass("fadeIn");
	});

	jQuery('.mobile_menu_select').bind('change', function () {
          var url = jQuery(this).val();
          if (url) {
              window.location = url;
          }
          return false;
	});

	// jQuery("a.prettyPhoto").prettyPhoto();
	//
	// jQuery(".prettyPhotolink").click(function() {
	// 	var thisgal = jQuery(this).attr('rel');
	//    jQuery("a.prettyPhoto." + thisgal + ":first").click()
	// });

	//tooltip();
    jQuery('.ttip , .tooltip-n').tipsy({fade: true, gravity: 's'});
    jQuery('.tooldown, .tooltip-s').tipsy({fade: true, gravity: 'n'});

    jQuery('.tooltip-nw').tipsy({fade: true, gravity: 'nw'});
    jQuery('.tooltip-ne').tipsy({fade: true, gravity: 'ne'});
    jQuery('.tooltip-w').tipsy({fade: true, gravity: 'w'});
    jQuery('.tooltip-e').tipsy({fade: true, gravity: 'e'});
    jQuery('.tooltip-sw').tipsy({fade: true, gravity: 'w'});
    jQuery('.tooltip-se').tipsy({fade: true, gravity: 'e'});


	jQuery(".video_fit_container").fitVids();




});


// tipsy, version 1.0.0a
// (c) 2008-2010 jason frame [jason@onehackoranother.com]
// released under the MIT license
(function(a){function b(a,b){return typeof a=="function"?a.call(b):a}function c(a){while(a=a.parentNode){if(a==document)return true}return false}function d(b,c){this.$element=a(b);this.options=c;this.enabled=true;this.fixTitle()}d.prototype={show:function(){var c=this.getTitle();if(c&&this.enabled){var d=this.tip();d.find(".tipsy-inner")[this.options.html?"html":"text"](c);d[0].className="tipsy";d.remove().css({top:0,left:0,visibility:"hidden",display:"block"}).prependTo(document.body);var e=a.extend({},this.$element.offset(),{width:this.$element[0].offsetWidth,height:this.$element[0].offsetHeight});var f=d[0].offsetWidth,g=d[0].offsetHeight,h=b(this.options.gravity,this.$element[0]);var i;switch(h.charAt(0)){case"n":i={top:e.top+e.height+this.options.offset,left:e.left+e.width/2-f/2};break;case"s":i={top:e.top-g-this.options.offset,left:e.left+e.width/2-f/2};break;case"e":i={top:e.top+e.height/2-g/2,left:e.left-f-this.options.offset};break;case"w":i={top:e.top+e.height/2-g/2,left:e.left+e.width+this.options.offset};break}if(h.length==2){if(h.charAt(1)=="w"){i.left=e.left+e.width/2-15}else{i.left=e.left+e.width/2-f+15}}d.css(i).addClass("tipsy-"+h);d.find(".tipsy-arrow")[0].className="tipsy-arrow tipsy-arrow-"+h.charAt(0);if(this.options.className){d.addClass(b(this.options.className,this.$element[0]))}if(this.options.fade){d.stop().css({opacity:0,display:"block",visibility:"visible"}).animate({opacity:this.options.opacity})}else{d.css({visibility:"visible",opacity:this.options.opacity})}}},hide:function(){if(this.options.fade){this.tip().stop().fadeOut(function(){a(this).remove()})}else{this.tip().remove()}},fixTitle:function(){var a=this.$element;if(a.attr("title")||typeof a.attr("original-title")!="string"){a.attr("original-title",a.attr("title")||"").removeAttr("title")}},getTitle:function(){var a,b=this.$element,c=this.options;this.fixTitle();var a,c=this.options;if(typeof c.title=="string"){a=b.attr(c.title=="title"?"original-title":c.title)}else if(typeof c.title=="function"){a=c.title.call(b[0])}a=(""+a).replace(/(^\s*|\s*$)/,"");return a||c.fallback},tip:function(){if(!this.$tip){this.$tip=a('<div class="tipsy"></div>').html('<div class="tipsy-arrow"></div><div class="tipsy-inner"></div>');this.$tip.data("tipsy-pointee",this.$element[0])}return this.$tip},validate:function(){if(!this.$element[0].parentNode){this.hide();this.$element=null;this.options=null}},enable:function(){this.enabled=true},disable:function(){this.enabled=false},toggleEnabled:function(){this.enabled=!this.enabled}};a.fn.tipsy=function(b){function e(c){var e=a.data(c,"tipsy");if(!e){e=new d(c,a.fn.tipsy.elementOptions(c,b));a.data(c,"tipsy",e)}return e}function f(){var a=e(this);a.hoverState="in";if(b.delayIn==0){a.show()}else{a.fixTitle();setTimeout(function(){if(a.hoverState=="in")a.show()},b.delayIn)}}function g(){var a=e(this);a.hoverState="out";if(b.delayOut==0){a.hide()}else{setTimeout(function(){if(a.hoverState=="out")a.hide()},b.delayOut)}}if(b===true){return this.data("tipsy")}else if(typeof b=="string"){var c=this.data("tipsy");if(c)c[b]();return this}b=a.extend({},a.fn.tipsy.defaults,b);if(!b.live)this.each(function(){e(this)});if(b.trigger!="manual"){var h=b.live?"live":"bind",i=b.trigger=="hover"?"mouseenter":"focus",j=b.trigger=="hover"?"mouseleave":"blur";this[h](i,f)[h](j,g)}return this};a.fn.tipsy.defaults={className:null,delayIn:0,delayOut:0,fade:false,fallback:"",gravity:"n",html:false,live:false,offset:0,opacity:.8,title:"title",trigger:"hover"};a.fn.tipsy.revalidate=function(){a(".tipsy").each(function(){var b=a.data(this,"tipsy-pointee");if(!b||!c(b)){a(this).remove()}})};a.fn.tipsy.elementOptions=function(b,c){return a.metadata?a.extend({},c,a(b).metadata()):c};a.fn.tipsy.autoNS=function(){return a(this).offset().top>a(document).scrollTop()+a(window).height()/2?"s":"n"};a.fn.tipsy.autoWE=function(){return a(this).offset().left>a(document).scrollLeft()+a(window).width()/2?"e":"w"};a.fn.tipsy.autoBounds=function(b,c){return function(){var d={ns:c[0],ew:c.length>1?c[1]:false},e=a(document).scrollTop()+b,f=a(document).scrollLeft()+b,g=a(this);if(g.offset().top<e)d.ns="n";if(g.offset().left<f)d.ew="w";if(a(window).width()+a(document).scrollLeft()-g.offset().left<b)d.ew="e";if(a(window).height()+a(document).scrollTop()-g.offset().top<b)d.ns="s";return d.ns+(d.ew?d.ew:"")}}})(jQuery);


jQuery(document).ready(function() {

	var $container = jQuery('#portfolio_container');

	// $container.isotope({
	//   itemSelector : '.portfolio_element'
	// });

	var $pagination_item = jQuery('.portfolio_items .pagination a');


	$container.imagesLoaded( function() {
		$container.isotope({
			itemSelector : '.portfolio_element',
		});
	});


var $optionSets = jQuery('#portfolio_filter_options .option-set'),
	$optionLinks = $optionSets.find('a');

$optionLinks.click(function(){
var $this = jQuery(this);
// don't proceed if already selected
if ( $this.closest('li').hasClass('active') ) {
	return false;
}
var $optionSet = $this.parents('.option-set');
$optionLinks.closest('li').removeClass('active');
$this.closest('li').addClass('active');

// make option object dynamically, i.e. { filter: '.my-filter-class' }
var options = {},
	key = $optionSet.attr('data-option-key'),
	value = $this.attr('data-option-value');
	// if (value == "*") {
	// 	jQuery('.portfolio_items .pagination').show();
	// } else {
	// 	jQuery('.portfolio_items .pagination').hide();
	// }
// parse 'false' as false boolean
value = value === 'false' ? false : value;
options[ key ] = value;
var tagexist = $this.attr('data-option-value');
var posts_per_page_limit = jQuery(this).attr('data-postsperpage');
var termpostcount = jQuery(this).attr('data-termpostcount');
		var posts_excluded = [];
		var postsnumber = 0;

			jQuery(tagexist).each( function() {
				var post_item = jQuery(this);
				posts_excluded.push(post_item.attr('data-projectid'));
				if (postsnumber >= posts_per_page_limit) {

					post_item.remove();
				}
				postsnumber++;
			});

		var ajax_nav_container = jQuery(this);
		var ajaxcontainer = jQuery('.portfolio_grid.filterable_portfolio_grid');
		var posttype = ajax_nav_container.attr('data-posttype');
		var postsperpage = ajax_nav_container.attr('data-postsperpage') - postsnumber;
		var loopfile = 'project-content';

		var count = parseInt( ajax_nav_container.attr('data-cycle') );
		var lang_data = ajax_nav_container.attr('data-lang');
		var pageid = ajax_nav_container.attr('data-pageid');
		var exclude = posts_excluded;
		var tag = ajax_nav_container.attr('data-tag');
		var taglink = ajax_nav_container.attr('data-taglink');
		var project_item = jQuery('.portfolio_element');
		if (project_item.hasClass('span4')) {
			var projectspan = 'span4';
		} else if (project_item.hasClass('span3')) {
			var projectspan = 'span3';
		} else if (project_item.hasClass('span6')) {
			var projectspan = 'span6';
		} else {
			var projectspan = 'span4';
		}

		if (((posts_per_page_limit >= termpostcount) && (postsnumber < termpostcount)) || ((postsnumber < termpostcount) && (termpostcount >= posts_per_page_limit)) || (value == '.showallposts')) {
		if (postsnumber < ajax_nav_container.attr('data-postsperpage')) {
			jQuery('#portfolio_container').animate({ opacity: 0.4 }, 100);
			if (value == '.showallposts') {
			newLoadArticle(count, 'project', postsperpage, loopfile, ajaxcontainer, '', '', '', '', projectspan, false);
			} else {
			newLoadArticle(count, posttype, postsperpage, loopfile, ajaxcontainer, pageid, '', exclude, tag, projectspan, false);
		}

		}
		}

		$container.isotope('reloadItems').isotope();
		if (value == '.showallposts') {
			ajaxPagination(count, 'project', ajax_nav_container.attr('data-postsperpage'), loopfile, jQuery('.portfolio_items'), '', '', '', '', '');
		} else {
			ajaxPagination(count, posttype, ajax_nav_container.attr('data-postsperpage'), loopfile,  jQuery('.portfolio_items'), pageid, '', exclude, tag, taglink);
		}
		ajax_nav_container.attr('data-cycle', count);

			if ( key === 'layoutMode' && typeof changeLayoutMode === 'function' ) {
				// changes in layout modes need extra logic
				changeLayoutMode( $this, options )
			} else {
					// otherwise, apply new options
					$container.isotope( options );
					$container.imagesLoaded( function() {
						$container.isotope( options );
				});
			}

return false;
});
});
var $container = jQuery('#portfolio_container');
if (jQuery('#portfolio_filter_options').length > 0) {
jQuery(document).on('click', '.portfolio_items .pagination a', function(e) {
	e.stopPropagation();
	e.preventDefault();
	var $optionSets = jQuery('#portfolio_filter_options ul');
	var $tagfilter = $optionSets.find('li.active');
	var $this = jQuery(this);
	// var options = {},
	// 	key = $optionSet.attr('data-option-key'),

	// 	// if (value == "*") {
	// 	// 	jQuery('.portfolio_items .pagination').show();
	// 	// } else {
	// 	// 	jQuery('.portfolio_items .pagination').hide();
	// 	// }
	// // parse 'false' as false boolean
	// value = value === 'false' ? false : value;
	// options[ key ] = value;

		var count = jQuery($this).text();




		var ajaxcontainer = jQuery('.portfolio_grid.filterable_portfolio_grid');
		var ajax_nav_container = $tagfilter.find('a');
		var posttype = ajax_nav_container.attr('data-posttype');
		var postsperpage = ajax_nav_container.attr('data-postsperpage');
		value = ajax_nav_container.attr('data-option-value');
		//var loopfile = ajax_nav_container.attr('data-loopfile');
		if (jQuery('body').hasClass('page-template-portfolio-full')) {
			var loopfile = 'content-projectfull.php';
		} else {
			var loopfile = 'content-project.php';
		}
		var totalpages = ( ajax_nav_container.attr('data-totalpages') );
		var count = jQuery($this).text();
		var lang_data = ajax_nav_container.attr('data-lang');
		var pageid = ajax_nav_container.attr('data-pageid');
		var exclude = '';
		var tag = ajax_nav_container.attr('data-tag');
		var taglink = ajax_nav_container.attr('data-taglink');
		var project_item = jQuery('.portfolio_element');
		if (project_item.hasClass('span4')) {
			var projectspan = 'span4';
		} else if (project_item.hasClass('span3')) {
			var projectspan = 'span3';
		} else if (project_item.hasClass('span6')) {
			var projectspan = 'span6';
		} else {
			var projectspan = 'span4';
		}
		// $container.html('');
		// $container.height(0);
			jQuery('#portfolio_container').animate({ opacity: 0.4 }, 100);

			if (value == '.showallposts') {
				newLoadArticle(count, 'project', postsperpage, loopfile, ajaxcontainer, '', '', '', '', projectspan, true);
				ajaxPagination(count, 'project', ajax_nav_container.attr('data-postsperpage'), loopfile, jQuery('.portfolio_items'), '', '', '', '', '');
			} else {
				newLoadArticle(count, posttype, postsperpage, loopfile, ajaxcontainer, pageid, totalpages, exclude, tag, projectspan, true);
				ajaxPagination(count, posttype, ajax_nav_container.attr('data-postsperpage'), loopfile,  jQuery('.portfolio_items'), pageid, totalpages, exclude, tag, taglink);
			}

			ajax_nav_container.attr('data-cycle', count);
	// 		if ( key === 'layoutMode' && typeof changeLayoutMode === 'function' ) {
	// 			// changes in layout modes need extra logic
	// 			changeLayoutMode( $this, options );
	// 		} else {
	// 			// otherwise, apply new options
	// 			$container.isotope( options );
	//
	// }



});}


	jQuery(window).resize(function() {
		if (jQuery(window).width() > 768) {
		jQuery('.main_nav li .dropdown-menu').slideUp();
		jQuery('.main_nav li.opened').removeClass('opened');
		jQuery('.main_nav li a i.icon-up-open').removeClass('icon-up-open').addClass('icon-down-open');
		jQuery('.main_navbar').addClass('desktop_menu');
		jQuery('#below_header_span').removeClass('mobile_menu_opened');
	}

	});

// /*
//  * Project: Twitter Bootstrap Hover Dropdown
//  * Author: Cameron Spear
//  * Contributors: Mattia Larentis
//  *
//  * Dependencies?: Twitter Bootstrap's Dropdown plugin
//  *
//  * A simple plugin to enable twitter bootstrap dropdowns to active on hover and provide a nice user experience.
//  *
//  * No license, do what you want. I'd love credit or a shoutout, though.
//  *
//  * http://cameronspear.com/blog/twitter-bootstrap-dropdown-on-hover-plugin/
//  */
// ;(function($, window, undefined) {
//     // outside the scope of the jQuery plugin to
//     // keep track of all dropdowns
//     var $allDropdowns = $();
//
//     // if instantlyCloseOthers is true, then it will instantly
//     // shut other nav items when a new one is hovered over
//     $.fn.dropdownHover = function(options) {
//
//         // the element we really care about
//         // is the dropdown-toggle's parent
//         $allDropdowns = $allDropdowns.add(this.parent());
//
//         return this.each(function() {
//             var $this = $(this).parent(),
//                 defaults = {
//                     delay: 500,
//                     instantlyCloseOthers: true
//                 },
//                 data = {
//                     delay: $(this).data('delay'),
//                     instantlyCloseOthers: $(this).data('close-others')
//                 },
//                 settings = $.extend(true, {}, defaults, options, data),
//                 timeout;
//
//             //// Return Menu Height to its original state
//             //$this.children('.dropdown-menu').css({ height: 'auto' });
//             //// Get original height
//             //var ulDropMenuHeight = $this.children('.dropdown-menu').height();
//             //// Return Height to Zero state
//             //$this.children('.dropdown-menu').css({ height: "0", overflow: "hidden" });
//
//             $this.hover(function () {
//
//                 //// Fix issues in responsive mode
//                 //// Return Menu Height to its original state
//                 //$this.children('.dropdown-menu').css({ height: 'auto' });
//                 //// Get original height
//                 //var ulDropMenuHeight = $this.children('.dropdown-menu').height();
//                 //// Return Height to Zero state
//                 //$this.children('.dropdown-menu').css({ height: "0", overflow: "hidden" });
//
//                 if (settings.instantlyCloseOthers === true) {
//                     $allDropdowns.removeClass('open');
//                     $allDropdowns.children('.dropdown-menu').slideUp(50);
//                     //$allDropdowns.children('.dropdown-menu').css({ display: "none", overflow: "hidden" });
//                     //$allDropdowns.children('.dropdown-menu').stop().animate({ height: '0' }, { queue: false, duration: 50, easing: 'jswing' });
//                 }
//
//                 window.clearTimeout(timeout);
//
//                 $('> .dropdown-menu', this).slideDown(0);
//                 $(this).addClass('open');
//
//                 //$(this).children('.dropdown-menu').css({ display: "block", overflow: "hidden" });
//                 //$(this).children('.dropdown-menu').stop().animate({ height: ulDropMenuHeight + "px" }, { queue: false, duration: 50, easing: 'jswing' });
//
//             }, function() {
//                 timeout = window.setTimeout(function() {
//                     $this.removeClass('open');
//
//                     $this.children('.dropdown-menu').slideUp(0);
//
//                     //$this.children('.dropdown-menu').css({ display: "none", overflow: "hidden" });
//                     //$this.children('.dropdown-menu').stop().animate({ height: '0' }, { queue: false, duration: 50, easing: 'jswing' });
//
//                 }, settings.delay);
//             });
//
//             $this.children('.dropdown-menu').find('.dropdown-submenu').hover(function () {
//                 $(this).parent().css({ overflow: "visible" });
//
//             });
//         });
//     };
//
//     // apply dropdownHover to all elements with the data-hover="dropdown" attribute
//     $(document).ready(function() {
//         $('[data-hover="dropdown"]').dropdownHover();
//     });
//
//
//
//
// })(jQuery, this);

function newLoadArticle(pagenumber, posttype, postsperpage, loopfile, ajaxcontainer, pageid, totalpages, exclude, tag, projectspan, pagination){


  jQuery.ajax({
    url: bostan_core_vars.ajax_load,
    type:'POST',
    data: "action=loadposts&page_no="+ pagenumber + '&loop_file='+loopfile+'&posts_per_page='+postsperpage+'&post_type='+posttype+'&tag='+tag+'&exclude='+exclude+'&totalpages='+totalpages+'&pageid='+pageid+'&projectspan='+projectspan,
    success: function(html){
      var content = jQuery(html);

        var $container = jQuery('#portfolio_container');
				if (pagination) {
					$container.isotope('remove', $container.isotope('getItemElements'));
					$container.isotope('reloadItems');
					$container.html('');
				}
				//$container.removeClass('portfolio_fadeout');
				jQuery('#portfolio_container').animate({ opacity: 1 }, 100);
        $container.append( content ).isotope( 'appended', content );
        // $container.isotope();
				// $container.isotope('reloadItems');
				$container.imagesLoaded( function() {
					$container.isotope('reloadItems').isotope();
				});



			  }});


};

jQuery(document).ready( function() {
	jQuery('.accordions_shortcode_group').each( function(){

	});
	
	jQuery('.social_icons_list .header_search_icon_mobile').on('click', function() {
		
			if (jQuery(this).hasClass('search_inactive')) {
			jQuery(this).removeClass('search_inactive');
			jQuery('.search_bar_mobile').show();
			jQuery('.search_bar_mobile').animate({ height: 43});
		} else {
			jQuery(this).addClass('search_inactive');
				jQuery('.search_bar_mobile').animate({ height: 0}, 250);
				jQuery('.search_bar_mobile').hide(130);
			
		}
		
	});
	
	jQuery(document).on('click', '.social_icons_list .header_search_icon i', function() {
	 	if (jQuery(this).hasClass('search_active')) {
			jQuery(this).removeClass('search_active');
			jQuery(this).addClass('search_inactive');
			jQuery('.social_icons_list .header_search_icon form').animate({ width: 0});
			jQuery('.social_icons_list .header_search_icon form').hide(150);
			jQuery('.social_icons_list .header_search_icon form').css('left', 'auto');
		} else {
			jQuery(this).removeClass('search_inactive');
			jQuery(this).addClass('search_active');
			if (jQuery('.top_header_tools_holder ul.social_icons_list').width() > 253) {
				var bar_width = jQuery('.top_header_tools_holder ul.social_icons_list').width();
			} else {
				var bar_width = 253;
			}
			var width = bar_width - 2;
			var left = (width - jQuery('.social_icons_list .header_search_icon').width() + 2) * -1;
			jQuery('.top_header_tools_holder').addClass('search_active');
			jQuery('.social_icons_list .header_search_icon form').show(150);
			jQuery('.social_icons_list .header_search_icon form').animate({ width: width, left: left}, 150);
		}
	
	});

});
function ajaxPagination(pagenumber, posttype, postsperpage, loopfile, ajaxcontainer, pageid, totalpages, exclude, tag, taglink){


  jQuery.ajax({
    url: bostan_core_vars.ajax_load_pagination,
    type:'POST',
    data: "action=loadposts&page_no="+ pagenumber + '&loop_file='+loopfile+'&posts_per_page='+postsperpage+'&post_type='+posttype+'&tag='+tag+'&pageid='+pageid,
    success: function(html){

				jQuery('.pagination').slideUp();
				jQuery('.portfolio_pagination').slideUp();
				if (jQuery('.portfolio_pagination').length) {
					var content = html;
					$container = jQuery('.portfolio_pagination');
				} else {
					var content = '<div class="portfolio_pagination">'+html+'</div>';
					var $container = jQuery(ajaxcontainer);
				}
        $container.append(content);
				jQuery('.portfolio_pagination').slideDown();
        // $container.find('a').each( function() {
        //   var oldlink = jQuery(this).attr('href');
        //   var replink = bostan_core_vars.ajax_load_pagination;
        //   var newlink = oldlink.replace('index.php/','');
        //   newlink = newlink.replace(replink+'/', taglink);
        //   jQuery(this).attr('href', newlink);
        // });
			  }});


};