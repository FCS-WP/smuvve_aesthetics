/* global jQuery:false, elementorFrontend:false */

(function() {

	"use strict";

	var trx_addons_once_resize = false;

	var $window          = jQuery( window ),
		$document        = jQuery( document ),
		$body            = jQuery( 'body' ),
		$scheme_watchers = jQuery('.watch_scheme');



	// Update links and values after the new post added
	$document.on( 'action.got_ajax_response', update_jquery_links );
	$document.on( 'action.init_hidden_elements', update_jquery_links );
	var first_run = true;
	function update_jquery_links(e) {
		if ( first_run && e && e.namespace == 'init_hidden_elements' ) {
			first_run = false;
			return; 
		}
	}
	update_jquery_links();

	$document.on( 'action.init_hidden_elements', function(e, cont) {
		// Disable Elementor's lightbox on the .esgbox links
		cont.find('a.esgbox').attr('data-elementor-open-lightbox', 'no');

		// Disable Elementor's lightbox on every link to the large image
		cont.find('a[href$=".jpg"],a[href$=".jpeg"],a[href$=".png"],a[href$=".gif"]').attr('data-elementor-open-lightbox', 'no');

	} );

	$window.on( 'elementor/frontend/init', function() {

		if ( typeof window.elementorFrontend !== 'undefined' && typeof window.elementorFrontend.hooks !== 'undefined' ) {

			// If Elementor is in the Editor's Preview mode
			if ( elementorFrontend.isEditMode() ) {

				// Init elements after creation
				elementorFrontend.hooks.addAction( 'frontend/element_ready/global', function( $cont ) {

					// Add 'sc_layouts_item'
					if ( $body.hasClass('cpt_layouts-template') || $body.hasClass('cpt_layouts-template-default') || $body.hasClass('single-cpt_layouts') ) {
						$body.find('.elementor-element.elementor-widget').addClass('sc_layouts_item');
					}
					
					// Remove TOC if exists (rebuild on init_hidden_elements)
					jQuery('#toc_menu').remove();

					// Init hidden elements (widgets, shortcodes) when its added to the preview area
					$document.trigger( 'action.init_hidden_elements', [$cont] );

					// Trigger 'resize' actions after the element is added (inited)
					if ( $cont.parents('.elementor-section-stretched').length > 0 && ! trx_addons_once_resize ) {
						trx_addons_once_resize = true;
						$document.trigger( 'action.resize_trx_addons', [$cont.parents('.elementor-section-stretched')] );
					} else {
						$document.trigger( 'action.resize_trx_addons', [$cont] );
					}

				} );

				// First init - add wrap 'sc_layouts_item'
				if ( $body.hasClass('cpt_layouts-template') || $body.hasClass('cpt_layouts-template-default') || $body.hasClass('single-cpt_layouts') ) {
					$body.find('.elementor-element.elementor-widget').addClass('sc_layouts_item');
				}

				// Load theme-specific shape to the container
				var trx_addons_load_shape = function(cont, shape) {
					if (cont.length > 0 && shape !== '') {
						cont.empty().attr( 'data-shape', shape );
						shape = TRX_ADDONS_STORAGE['shapes_url'] + shape.replace('trx_addons_', '') + '.svg';
						jQuery.get( shape, function( data ) {
							cont.append(data.childNodes[0]).attr('data-negative', 'false');
						} );
					}
				};

				// First init - refresh theme-specific shapes
				jQuery('.elementor-shape').each(function() {
					var shape = jQuery(this).data('shape');
					if (shape !== undefined && shape.indexOf('trx_addons_') === 0) {
						trx_addons_load_shape(jQuery(this), shape);
					}
				});

				// Shift elements down under fixed rows
				elementorFrontend.hooks.addFilter( 'frontend/handlers/menu_anchor/scroll_top_distance', function( scrollTop ) {
					return scrollTop - trx_addons_fixed_rows_height();
				} );

			// If Elementor is in Frontend
			} else {
				// Add page settings to the elementorFrontend object
				// in the frontend for non-Elementor pages (blog pages, categories, tags, etc.)
				if (typeof elementorFrontend.config !== 'undefined'
					&& typeof elementorFrontend.config.settings !== 'undefined'
					&& typeof elementorFrontend.config.settings.general === 'undefined'
				) {
					elementorFrontend.config.settings.general = {
						'elementor_stretched_section_container': TRX_ADDONS_STORAGE['elementor_stretched_section_container']
					};
				}
				// Call 'resize' handlers after Elementor inited
				// Use setTimeout to run our code after Elementor's stretch row code!
				setTimeout(function() {
					trx_addons_once_resize = true;
					$document.trigger('action.resize_trx_addons');
				}, 0);
			}
		}

	});

})();
