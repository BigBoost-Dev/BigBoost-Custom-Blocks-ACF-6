<?php
/*
Plugin Name: BigBoost Custom Blocks (ACF 6+)
Description: Enqueues global assets, syncs ACF JSON, whitelists BigBoost blocks, and
             auto‑registers every block folder that contains a block.json file.
Version: 2.1
Author: BigBoost
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*--------------------------------------------------------------
 # 1.  Global CSS & JS
--------------------------------------------------------------*/
add_action( 'wp_enqueue_scripts', function () {

	// Bootstrap CSS
	wp_enqueue_style(
		'bigboost-bootstrap',
		'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css',
		[],
		'5.0.2'
	);

	// Plugin CSS
	$css = plugin_dir_path( __FILE__ ) . 'assets/global.css';
	if ( file_exists( $css ) ) {
		wp_enqueue_style(
			'bigboost-global',
			plugin_dir_url( __FILE__ ) . 'assets/global.css',
			[],
			filemtime( $css )
		);
	}

	// jQuery (core)
	wp_enqueue_script( 'jquery' );

	

	// Plugin JS
	$js = plugin_dir_path( __FILE__ ) . 'assets/global.js';
	if ( file_exists( $js ) ) {
		wp_enqueue_script(
			'bigboost-global',
			plugin_dir_url( __FILE__ ) . 'assets/global.js',
			[ 'jquery' ],
			filemtime( $js ),
			true
		);
	}
} );

/*--------------------------------------------------------------
 # 2.  ACF JSON sync
--------------------------------------------------------------*/
add_filter( 'acf/settings/save_json', fn() => plugin_dir_path( __FILE__ ) . 'acf-json' );

add_filter( 'acf/settings/load_json', function ( $paths ) {
	unset( $paths[0] );                                   // remove theme path
	$paths[] = plugin_dir_path( __FILE__ ) . 'acf-json';
	return $paths;
} );

/*--------------------------------------------------------------
 # 3.  **AUTO‑REGISTER** every block that has block.json
--------------------------------------------------------------*/
add_action( 'init', function () {

	$block_dirs = glob( plugin_dir_path( __FILE__ ) . 'blocks/*', GLOB_ONLYDIR );

	foreach ( $block_dirs as $dir ) {
		if ( file_exists( $dir . '/block.json' ) ) {
			register_block_type( $dir );                  // core function — ACF reads the "acf" section
		}
	}
} );

/*--------------------------------------------------------------
 # 4.  VIP‑Go whitelist
--------------------------------------------------------------*/
add_filter( 'allowed_block_types_all', function ( $allowed, $ctx ) {

	if ( empty( $ctx->post ) ) {
		return $allowed;
	}

	$custom = [
		'acf/banner-section',
		'acf/quote-section',
		'acf/call-to-action',
		'acf/gallery',
		'acf/faq',
        'acf/circle-slider',
	];

	if ( ! is_array( $allowed ) ) {
		return true;
	}

	return array_values( array_unique( array_merge( $allowed, $custom ) ) );

}, 100, 2 );

/*--------------------------------------------------------------
 # 5.  In‑code ACF field groups (same as before)
--------------------------------------------------------------*/
add_action( 'acf/init', function () {
    // Banner Section Block Fields
    acf_add_local_field_group( [
        'key'      => 'group_banner_section',
        'title'    => 'Banner Section Block',
        'fields'   => [
            [ 'key' => 'field_subheading',   'label' => 'Subheading',      'name' => 'subheading',   'type' => 'text'     ],
            [ 'key' => 'field_heading',      'label' => 'Heading',         'name' => 'heading',      'type' => 'text'     ],
            [ 'key' => 'field_description',  'label' => 'Description',     'name' => 'description',  'type' => 'textarea' ],
            [ 'key' => 'field_button',       'label' => 'Button Link',     'name' => 'button',       'type' => 'link'     ],
            [ 'key' => 'field_button_text',  'label' => 'Button Text',     'name' => 'button_text',  'type' => 'text'     ],
        ],
        'location' => [
            [ [ 'param' => 'block', 'operator' => '==', 'value' => 'acf/banner-section' ] ],
        ],
    ] );


	// Quote Section Block Fields
    acf_add_local_field_group( [
        'key'      => 'group_quote_section',
        'title'    => 'Quote Section Block',
        'fields'   => [
            [ 'key' => 'field_banner_image', 'label' => 'Banner Image', 'name' => 'banner_image', 'type' => 'image', 'return_format' => 'array', 'preview_size' => 'thumbnail', 'library' => 'all' ],
            [ 'key' => 'field_quote',        'label' => 'Quote',        'name' => 'quote',        'type' => 'textarea' ],
            [ 'key' => 'field_author',       'label' => 'Author',       'name' => 'author',       'type' => 'text'     ],
        ],
        'location' => [
            [ [ 'param' => 'block', 'operator' => '==', 'value' => 'acf/quote-section' ] ],
        ],
    ] );


	// FAQ Section
	acf_add_local_field_group( [
		'key'    => 'group_faq_section',
		'title'  => 'FAQ Section Block',
		'fields' => [
			[ 'key' => 'field_faq_title', 'label' => 'Title', 'name' => 'faq_title', 'type' => 'text' ],
			[
				'key' => 'field_faq_items',
				'label' => 'FAQ Items',
				'name' => 'faq_items',
				'type' => 'repeater',
				'button_label' => 'Add FAQ',
				'sub_fields' => [
					[ 'key' => 'field_faq_question', 'label' => 'Question', 'name' => 'question', 'type' => 'wysiwyg' ],
					[ 'key' => 'field_faq_answer',   'label' => 'Answer',   'name' => 'answer',   'type' => 'wysiwyg' ],
				],
			],
		],
		'location' => [ [ [ 'param' => 'block', 'operator' => '==', 'value' => 'acf/faq' ] ] ],
	] );

	// Call‑to‑Action
	acf_add_local_field_group( [
		'key'    => 'group_call_to_action',
		'title'  => 'Call to Action Block',
		'fields' => [
			[ 'key' => 'field_cta_title',       'label' => 'CTA Title',       'name' => 'cta_title',       'type' => 'text'     ],
			[ 'key' => 'field_cta_description', 'label' => 'CTA Description', 'name' => 'cta_description', 'type' => 'textarea' ],
			[ 'key' => 'field_cta_button',      'label' => 'CTA Button',      'name' => 'cta_button',      'type' => 'link'     ],
		],
		'location' => [ [ [ 'param' => 'block', 'operator' => '==', 'value' => 'acf/call-to-action' ] ] ],
	] );

	// Gallery
	acf_add_local_field_group( [
		'key'    => 'group_gallery',
		'title'  => 'Gallery Block',
		'fields' => [
			[
				'key'          => 'field_gallery_images',
				'label'        => 'Gallery Images',
				'name'         => 'gallery_images',
				'type'         => 'gallery',
				'preview_size' => 'thumbnail',
				'library'      => 'all',
			],
		],
		'location' => [ [ [ 'param' => 'block', 'operator' => '==', 'value' => 'acf/gallery' ] ] ],
	] );
// Circle Slider Block Fields
// Circle Slider Block Fields
        acf_add_local_field_group(array(
            'key' => 'group_circle_slider_section',
            'title' => 'Circle Slider Block',
            'fields' => array(
                array(
                    'key' => 'field_circle_slider_tag',
                    'label' => 'Section Tag',
                    'name' => 'section_tag',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_circle_slider_title',
                    'label' => 'Section Title',
                    'name' => 'section_title',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_circle_slider_items',
                    'label' => 'Slider Items',
                    'name' => 'slider_items',
                    'type' => 'repeater',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_circle_slider_number',
                            'label' => 'Step Number',
                            'name' => 'step_number',
                            'type' => 'number',
                        ),
                        array(
                            'key' => 'field_circle_slider_step_title',
                            'label' => 'Step Title',
                            'name' => 'step_title',
                            'type' => 'text',
                        ),
                        array(
                            'key' => 'field_circle_slider_description',
                            'label' => 'Step Description',
                            'name' => 'step_description',
                            'type' => 'textarea',
                        ),
                        array(
                            'key' => 'field_circle_slider_main_image',
                            'label' => 'Main Image',
                            'name' => 'main_image',
                            'type' => 'image',
                            'return_format' => 'array',
                            'preview_size' => 'thumbnail',
                        ),
                        array(
                            'key' => 'field_circle_slider_ui_image',
                            'label' => 'UI Image',
                            'name' => 'ui_image',
                            'type' => 'image',
                            'return_format' => 'array',
                            'preview_size' => 'thumbnail',
                        ),
                    ),
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'block',
                        'operator' => '==',
                        'value' => 'acf/circle-slider',
                    ),
                ),
            ),
        ));



} );