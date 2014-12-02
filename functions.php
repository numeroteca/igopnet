<?php
// Custom post types
add_action( 'init', 'create_post_type', 0 );
// Custom Taxonomies
add_action( 'init', 'build_taxonomies', 0 );

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
		'rewrite' => array( 'slug' => 'org-ecosystem' ) ) );
	register_taxonomy( 'org-type', 'organization', array(
		'label' => __( 'Type' ),
		'rewrite' => array( 'slug' => 'org-type' ) ) );
	register_taxonomy( 'org-scope', 'organization', array(
		'label' => __( 'Scope' ),
		'rewrite' => array( 'slug' => 'org-scope' ) ) );
	register_taxonomy( 'org-whom', 'organization', array(
		'label' => __( 'A quién' ),
		'rewrite' => array( 'slug' => 'org-whom' ) ) );
	register_taxonomy( 'org-validation', 'organization', array(
		'label' => __( 'Validation' ),
		'rewrite' => array( 'slug' => 'org-validation' ) ) );
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
