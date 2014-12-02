<?php
// Custom post types
add_action( 'init', 'create_post_type', 0 );
// Custom Taxonomies
add_action( 'init', 'build_taxonomies', 0 );
//Initializes Custom Meta Boxes
add_action( 'init', 'igopnet_init_meta_boxes', 9999 );
// Extra meta boxes in editor
add_filter( 'cmb_meta_boxes', 'igopnet_metaboxes' );


//Creates Custom Post Types
function create_post_type() {
	//Register Organization custom post type
	register_post_type( 'organization', array( // global meetings
		'labels' => array(
			'name' => __( 'Organizations' ),
			'singular_name' => __( 'Organization' ),
			'add_new_item' => __( 'Add Organization +' ),
			'edit' => __( 'Edit' ),
			'edit_item' => __( 'Edit this Organization' ),
			'new_item' => __( 'New Organization' ),
			'view' => __( 'View Organization' ),
			'view_item' => __( 'View Organization' ),
			'search_items' => __( 'Search Organization' ),
			'not_found' => __( 'We didn\'t found any Organization' ),
			'not_found_in_trash' => __( 'No Organization in the trash bin' ),
			'parent' => __( 'Parent Organization' )
			),
		'hierarchical' => true,
		'public' => true,
		'menu_position' => 5,
		'supports' => array('title', 'editor','custom-fields','author','comments','revisions','page-attributes','thumbnail','excerpt'),
		'rewrite' => array('slug'=>'organization','with_front'=>false),
		'menu_icon' => 'dashicons-groups',
		)
	);
}

//Creates Taxonomies
function build_taxonomies() {
	register_taxonomy( 'org-ecosystem', 'organization', array(
		'label' => __( 'Ecosystem' ),
		'hierarchical' => true,
		'rewrite' => array( 'slug' => 'org-ecosystem' ) ) );
	register_taxonomy( 'org-type', 'organization', array(
		'label' => __( 'Type' ),
		'hierarchical' => true,
		'rewrite' => array( 'slug' => 'org-type' ) ) );
	register_taxonomy( 'org-scope', 'organization', array(
		'label' => __( 'Scope' ),
		'hierarchical' => true,
		'rewrite' => array( 'slug' => 'org-scope' ) ) );
	register_taxonomy( 'org-whom', 'organization', array(
		'label' => __( 'A quién' ),
		'hierarchical' => true,
		'rewrite' => array( 'slug' => 'org-whom' ) ) );
	register_taxonomy( 'org-validation', 'organization', array(
		'label' => __( 'Validation' ),
		'hierarchical' => true,
		'rewrite' => array( 'slug' => 'org-validation' ) ) );
}

// Initialize the metabox class
function igopnet_init_meta_boxes() {
    if ( !class_exists( 'cmb_Meta_Box' ) ) {
        require_once( 'lib/metabox/init.php' );
    }
}

function igopnet_metaboxes( $meta_boxes ) {
	$prefix = '_ig_'; // Prefix for all fields
	$meta_boxes['test_metabox'] = array(
		'id' => 'test_metabox',
		'title' => __( 'Basic information' ),
		'pages' => array('organization'), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => __( 'Main Web' ),
				'desc' => __( 'Web of organization. Ex: http://juventudsinfuturo.net' ),
				'id' => $prefix . 'name',
				'type' => 'text_url'
			),
			array(
				'name' => __( 'Description' ),
				'desc' => __( '-' ),
				'id' => $prefix . 'description',
				'type' => 'wysiwyg',
				'options' => array(
					'wpautop' => true,
					'textarea_rows' => get_option('default_post_edit_rows',4),
					'teeny' => false, // output the minimal editor config used in Press This
					'tinymce' => true, // load TinyMCE, can be used to pass settings directly to TinyMCE using an array()
				),
			),
			array(
				'name' => __( 'Notes' ),
				'desc' => __( '-' ),
				'id' => $prefix . 'notes',
				'type' => 'wysiwyg',
				'options' => array(
					'wpautop' => true,
					'textarea_rows' => get_option('default_post_edit_rows',4),
					'teeny' => false, // output the minimal editor config used in Press This
					'tinymce' => true, // load TinyMCE, can be used to pass settings directly to TinyMCE using an array()
				),
			),
			array(
				'id' => $prefix . 'other_url',
				'type' => 'group',
				'description' => __( 'Secondary websites','igopnet' ),
				'options' => array(
					'add_button' => __( 'Add Another URL', 'montera34' ),
					'remove_button' => __( 'Remove URL', 'montera34' ),
				),
 				'fields' => array(
					array(
						'name' => 'Secondary website',
 						'id'   => 'url',
 						'desc' => __( 'Ex: http://juventudsinfuturo.net' ),
						'type' => 'text_url',
						'protocols' => array( 'http', 'https' )
					),
				),
			),
			array(
				'id' => $prefix . 'url_info',
				'type' => 'group',
				'description' => __( 'Extra info about website','igopnet' ),
				'options' => array(
					'group_title' => __( 'Website data', 'igopnet' ),
					'add_button' => __( 'Add more data', 'montera34' ),
					'remove_button' => __( 'Remove data', 'montera34' ),
				),
 				'fields' => array(
					array(
						'name' => 'Date',
 						'id'   => 'url_data_date',
 						'desc' => __( 'Select date when date where obtained' ),
						'type' => 'text_date_timestamp',
						'date_format' => 'j/M/Y',
					),
					array(
						'name' => 'URL',
 						'id'   => 'url',
						'type' => 'text_url',
						'protocols' => array( 'http', 'https' )
					),
					array(
						'name' => 'Google Page Rank',
 						'id'   => 'google_page_rank',
						'type' => 'text_small',
					),
					array(
						'name' => 'Alexa Page Rank',
 						'id'   => 'alexa_page_rank',
						'type' => 'text_medium',
					),
					array(
						'name' => 'Alexa Inlinks',
 						'id'   => 'alexa_inlinks',
						'type' => 'text_medium',
					),
				),
			),
		),
	);
  return $meta_boxes;
}

//Lists the active languages
function languages_list(){
    $languages = icl_get_languages('skip_missing=0&orderby=code');
    if(!empty($languages)){
        echo '<div id="language_list"><ul class="nav nav-pills">';
        foreach($languages as $l){
            if($l['active']) {echo '<li class="active">';} else {echo '<li>';};
            if(!$l['active']) {echo '<a href="'.$l['url'].'">';} else {echo '<a href="#">';};
            echo $l['native_name'];
           	echo '</a>';
            echo '</li>';
        }
        echo '</ul></div>';
    }
}
