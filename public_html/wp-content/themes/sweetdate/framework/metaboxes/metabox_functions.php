<?php
/**
 * Include and setup custom metaboxes and fields.
 *
 */

add_filter( 'cmb_meta_boxes', 'kleo_metaboxes' );
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function kleo_metaboxes( array $meta_boxes ) {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_kleo_';

	$meta_boxes[] = array(
		'id'         => 'general_settings',
		'title'      => 'General settings',
		'pages'      => array( 'post','page' ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
            array(
				'name' => 'Media',
				'desc' => '',
				'id'   => 'kleomedia',
				'type' => 'tab'
			),
            array(
				'name' => 'Slider',
				'desc' => 'Upload an image or enter an URL.',
				'id'   => $prefix . 'slider',
				'type' => 'file_repeat',
                'allow' => 'url'
			),
			array(
				'name' => 'Video embed',
				'desc' => __('Enter a youtube or vimeo URL. Supports services listed at <a target="_blank" href="http://codex.wordpress.org/Embeds">http://codex.wordpress.org/Embeds</a>.', 'kleo_framework'),
				'id'   => $prefix . 'embed',
				'type' => 'oembed',
			),
			array(
				'name' => 'Audio',
				'desc' => __('Upload you audio file', 'kleo_framework'),
				'id'   => $prefix . 'audio',
				'type' => 'file',
			),
            array(
				'name' => 'Display settings',
				'desc' => '',
				'id'   => 'kleodisplay',
				'type' => 'tab'
			),
			array(
				'name' => 'Hide the title',
				'desc' => 'Check to hide the title when displaying the post/page',
				'id'   => $prefix . 'title_checkbox',
				'type' => 'checkbox',
                'value' => '1'
			),
			array(
				'name' => 'Centered text',
				'desc' => 'Check to have centered text on this page',
				'id'   => $prefix . 'centered_text',
				'type' => 'checkbox',
                'value' => '1'
			),            
            
			array(
				'name' => 'Hide post meta',
				'desc' => 'Check to hide the post meta when displaying a post',
				'id'   => $prefix . 'meta_checkbox',
				'type' => 'checkbox',
                'value' => '1'
			),
         
		),
	);

	$meta_boxes[] = array(
		'id'         => 'testimonials_metabox',
		'title'      => __('Testimonial - Author description', 'kleo_framework'),
		'pages'      => array( 'kleo-testimonials' ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => false, // Show field names on the left
		'fields' => array(
			array(
				'name' => 'Author description',
				'desc' => '',
				'id'   => $prefix . 'author_description',
				'type' => 'text',
			),
		)
	);
        
	// Add other metaboxes as needed

	return $meta_boxes;
}

add_action( 'init', 'initialize_meta_boxes', 9999 );
/**
 * Initialize the metabox class.
 */
function initialize_meta_boxes() {

    if ( ! class_exists( 'cmb_Meta_Box' ) )
            require_once 'init.php';

}