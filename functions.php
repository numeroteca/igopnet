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
	register_taxonomy( 'org-city', 'organization', array(
		'label' => __( 'City' ),
		'hierarchical' => true,
		'rewrite' => array( 'slug' => 'org-city' ) ) );
	register_taxonomy( 'org-region', 'organization', array(
		'label' => __( 'Region' ),
		'hierarchical' => true,
		'rewrite' => array( 'slug' => 'org-region' ) ) );
	register_taxonomy( 'org-country', 'organization', array(
		'label' => __( 'Country' ),
		'hierarchical' => true,
		'rewrite' => array( 'slug' => 'org-country' ) ) );
}

// Initialize the metabox class
function igopnet_init_meta_boxes() {
    if ( !class_exists( 'cmb_Meta_Box' ) ) {
        require_once( 'lib/metabox/init.php' );
    }
}

function igopnet_metaboxes( $meta_boxes ) {
	$prefix = '_ig_'; // Prefix for all fields
	
	//Basic information
	$meta_boxes[] = array(
		'id' => 'igopnet_organization_basic',
		'title' => __( 'Basic information' ),
		'pages' => array('organization'), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => __( 'Main Web' ),
				'desc' => __( 'Web of organization. Ex: http://juventudsinfuturo.net' ),
				'id' => $prefix . 'main_url',
				'type' => 'text_url'
			),
			array(
				'name' => 'Fecha de inicio',
				'desc' => 'Si se desconoce la fecha exacta, indicar 1 de enero de ese año',
				'id' => $prefix . 'origin_date',
				'type' => 'text_date_timestamp',
				'date_format' => 'j/M/Y',
			),
			array(
				'name' => 'Fecha de fin',
				'desc' => 'Si se desconoce la fecha exacta, indicar 1 de enero de ese año',
				'id' => $prefix . 'end_date',
				'type' => 'text_date_timestamp',
				'date_format' => 'j/M/Y',
			),
			array(
				'name' => 'Activa',
				'desc' => '',
				'id' => $prefix . 'active',
				'type' => 'radio_inline',
				'options' => array(
				    array('name' => 'yes', 'value' => 'yes'),
				    array('name' => 'no', 'value' => 'no'),
				)
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
		),
	);
	
	//Social networkng sites
	$meta_boxes[] = array(
		'id' => 'igopnet_social_networking_sites',
		'title' => __( 'Social Networks' ),
		'pages' => array('organization'), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => __( 'Facebook URL' ),
				'desc' => __( 'Ex: juventudsinfuturo' ),
				'id' => $prefix . 'facebook_site',
				'type' => 'text_url'
			),
			array(
				'name' => __( 'Facebook likes' ),
				'desc' => __( 'Include the number, without thousand separator. Ex: 15235' ),
				'id' => $prefix . 'facebook_likes',
				'type' => 'text_medium',
			),
			array(
				'name' => __( 'Youtube account' ),
				'desc' => __( 'Ex: https://www.youtube.com/user/' ),
				'id' => $prefix . 'youtube_account',
				'type' => 'text_medium',
			),
			array(
				'name' => __( 'Twitter main account' ),
				'desc' => __( 'Do not incluse the "@". Ex: juventudsin' ),
				'id' => $prefix . 'twitter_account',
				'type' => 'text_medium',
			),
			array(
				'name' => __( 'When Twittter accont started' ),
				'desc' => __( '' ),
				'id' => $prefix . 'twitter_origin',
				'type' => 'text_date_timestamp',
				'date_format' => 'j/M/Y',
			),
			array(
				'id' => $prefix . 'other_twitter_accounts',
				'type' => 'group',
				'description' => __( 'Secondary Twitter Accounts','igopnet' ),
				'options' => array(
					'add_button' => __( 'Add Another Twitter account', 'montera34' ),
					'remove_button' => __( 'Remove Twitter account', 'montera34' ),
				),
 				'fields' => array(
					array(
						'name' => 'Secondary Twitter account',
 						'id'   => 'url',
 						'desc' => __( 'Do not incluse the "@". Ex: juventudsin' ),
						'type' => 'text_medium',
					),
					array(
						'name' => __( 'When Twittter accont started' ),
						'desc' => __( '' ),
						'id' => $prefix . 'twitter_origin',
						'type' => 'text_date_timestamp',
						'date_format' => 'j/M/Y',
					),
				),
			),
		),
	);

	//Websites related information in time
	$meta_boxes[] = array(
		'id' => 'igopnet_website_info',
		'title' => __( 'Websites related information' ),
		'pages' => array('organization'), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'id' => $prefix . 'url_info',
				'type' => 'group',
				'description' => __( 'Info about websites','igopnet' ),
				'options' => array(
					'group_title' => __( 'Website data', 'igopnet' ),
					'add_button' => __( 'Add more data', 'montera34' ),
					'remove_button' => __( 'Remove data', 'montera34' ),
				),
				'fields' => array(
					array(
						'name' => 'Date',
						'id'   => 'url_data_date', //TODO only one value gets stored in database
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

	//Twitter information in time
	$meta_boxes[] = array(
		'id' => 'igopnet_twitter_info',
		'title' => __( 'Twitter in time information' ),
		'pages' => array('organization'), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'id' => $prefix . 'twitter_info',
				'type' => 'group',
				'description' => __( 'Info about websites','igopnet' ),
				'options' => array(
					'group_title' => __( 'Twitter data', 'igopnet' ),
					'add_button' => __( 'Add more data', 'montera34' ),
					'remove_button' => __( 'Remove data', 'montera34' ),
				),
				'fields' => array(
					array(
						'name' => 'Date',
						'id'   => 'url_data_date', //TODO only one value gets stored in database
						'desc' => __( 'Select date when date where obtained' ),
						'type' => 'text_date_timestamp',
						'date_format' => 'j/M/Y',
					),
					array(
						'name' => 'Twitter account',
						'id'   => 'twitter',
						'type' => 'text_small',
						'protocols' => array( 'http', 'https' )
					),
					array(
						'name' => 'Followers',
						'id'   => 'twitter_followers',
						'type' => 'text_small',
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
