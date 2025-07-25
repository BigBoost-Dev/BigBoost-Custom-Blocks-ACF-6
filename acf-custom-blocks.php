<?php
/*
Plugin Name: BigBoost Custom Blocks (ACF 6+)
Description: Enqueues global assets, syncs ACF JSON, whitelists BigBoost blocks, and
             auto‑registers every block folder that contains a block.json file.
Version: 2.0
Author: BigBoost
*/

if (!defined('ABSPATH')) exit;

// Enqueue global CSS & JS libraries
add_action('wp_enqueue_scripts', 'bigboost_enqueue_global_assets');
function bigboost_enqueue_global_assets() {
    // Example: Bootstrap CSS & JS from CDN
    wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css');

    wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js', array('jquery'), null, true);

    // Example: Swiper CSS & JS from CDN

    wp_enqueue_script('jquery-js', 'https://code.jquery.com/jquery-3.6.4.min.js', array(), null, true);

    // Example: Your plugin's custom CSS and JS (if you want)
    wp_enqueue_style('bigboost-global-css', plugin_dir_url(__FILE__) . 'assets/global.css');

    wp_enqueue_script('bigboost-global-js', plugin_dir_url(__FILE__) . 'assets/global.js', array('jquery'), null, true);
}

// Register blocks from block.json files
add_action('init', 'bigboost_register_blocks');
function bigboost_register_blocks() {
    foreach (glob(plugin_dir_path(__FILE__) . 'blocks/*/block.json') as $block) {
        register_block_type($block);
    }
}

// Add custom block category
add_filter('block_categories_all', 'bigboost_custom_block_category', 10, 2);
function bigboost_custom_block_category($categories, $post) {
    return array_merge(
        $categories,
        array(
            array(
                'slug'  => 'bigboost-blocks',
                'title' => __('BigBoost Blocks', 'bigboost-custom-blocks'),
                'icon'  => null,
            )
        )
    );
}

// ACF JSON Sync
add_filter('acf/settings/save_json', function() {
    return plugin_dir_path(__FILE__) . 'acf-json';
});

add_filter('acf/settings/load_json', function($paths) {
    $paths[] = plugin_dir_path(__FILE__) . 'acf-json';
    return $paths;
});

// Register ACF Fields Automatically
add_action('acf/init', 'bigboost_register_acf_fields');
function bigboost_register_acf_fields() {
    if (function_exists('acf_add_local_field_group')) {

        // Banner Section Block Fields
        acf_add_local_field_group(array(
            'key' => 'group_banner_section',
            'title' => 'Banner Section Block',
            'fields' => array(
                array(
                    'key' => 'field_subheading',
                    'label' => 'Subheading',
                    'name' => 'subheading',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_heading',
                    'label' => 'Heading',
                    'name' => 'heading',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_description',
                    'label' => 'Description',
                    'name' => 'description',
                    'type' => 'textarea',
                ),
                array(
                    'key' => 'field_button',
                    'label' => 'Button Link',
                    'name' => 'button',
                    'type' => 'link',
                ),
                array(
                    'key' => 'field_button_text',
                    'label' => 'Button Text',
                    'name' => 'button_text',
                    'type' => 'text',
                ),
               
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'block',
                        'operator' => '==',
                        'value' => 'acf/banner-section',
                    ),
                ),
            ),
        ));

        // Quote Section Block Fields
        acf_add_local_field_group(array(
            'key' => 'group_quote_section',
            'title' => 'Quote Section Block',
            'fields' => array(
				 array(
                    'key' => 'field_banner_image',
                    'label' => 'Banner Image',
                    'name' => 'banner_image',
                    'type' => 'image',
                    'return_format' => 'array',
                    'preview_size' => 'thumbnail',
                    'library' => 'all',
                ),
            
                array(
                    'key' => 'field_quote',
                    'label' => 'Quote',
                    'name' => 'quote',
                    'type' => 'textarea',
                ),
                array(
                    'key' => 'field_author',
                    'label' => 'Author',
                    'name' => 'author',
                    'type' => 'text',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'block',
                        'operator' => '==',
                        'value' => 'acf/quote-section',
                    ),
                ),
            ),
        ));

        // FAQ Section Block Fields
        acf_add_local_field_group(array(
            'key' => 'group_faq_section',
            'title' => 'FAQ Section Block',
            'fields' => array(
            
                array(
                    'key' => 'field_faq_title',
                    'label' => 'Title',
                    'name' => 'faq_title',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_faq_items',
                    'label' => 'FAQ Items',
                    'name' => 'faq_items',
                    'type' => 'repeater',
                    'button_label' => 'Add FAQ',
                    'sub_fields' => array(
                       array(
                            'key' => 'field_faq_question',
                            'label' => 'Question',
                            'name' => 'question',
                            'type' => 'wysiwyg', // changed from 'text' to 'wysiwyg'
                            'tabs' => 'all',
                            'toolbar' => 'basic',
                            'media_upload' => 0,
                        ),
                        array(
                            'key' => 'field_faq_answer',
                            'label' => 'Answer',
                            'name' => 'answer',
                            'type' => 'wysiwyg', // changed from 'textarea' to 'wysiwyg'
                            'tabs' => 'all',
                            'toolbar' => 'basic',
                            'media_upload' => 1,
                        ),
                    ),
                ),

            ),
            'location' => array(
                array(
                    array(
                        'param' => 'block',
                        'operator' => '==',
                        'value' => 'acf/faq',
                    ),
                ),
            ),
        ));


        // Call to Action Block Fields
        acf_add_local_field_group(array(
            'key' => 'group_call_to_action',
            'title' => 'Call to Action Block',
            'fields' => array(
                array(
                    'key' => 'field_cta_title',
                    'label' => 'CTA Title',
                    'name' => 'cta_title',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_cta_description',
                    'label' => 'CTA Description',
                    'name' => 'cta_description',
                    'type' => 'textarea',
                ),
                array(
                    'key' => 'field_cta_button',
                    'label' => 'CTA Button',
                    'name' => 'cta_button',
                    'type' => 'link',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'block',
                        'operator' => '==',
                        'value' => 'acf/call-to-action',
                    ),
                ),
            ),
        ));

        // Gallery Block Fields
        acf_add_local_field_group(array(
            'key' => 'group_gallery',
            'title' => 'Gallery Block',
            'fields' => array(
                array(
                    'key' => 'field_gallery_images',
                    'label' => 'Gallery Images',
                    'name' => 'gallery_images',
                    'type' => 'gallery',
                    'preview_size' => 'thumbnail',
                    'library' => 'all',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'block',
                        'operator' => '==',
                        'value' => 'acf/gallery',
                    ),
                ),
            ),
        ));

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
    }
}