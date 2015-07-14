<?php
// Custom post types
add_action( 'init', 'create_post_type', 0 );
// Custom Taxonomies
add_action( 'init', 'build_taxonomies', 0 );
// Extra meta boxes in editor
add_filter( 'cmb2_meta_boxes', 'igopnet_metaboxes' );
/* Load JavaScript files on the 'wp_enqueue_scripts' action hook. */
add_action( 'wp_enqueue_scripts', 'igopnet_load_css' );
// Register Custom Navigation Walker from https://github.com/twittem/wp-bootstrap-navwalker
require_once('wp_bootstrap_navwalker.php');

// Loads Custom Meta Boxes
$url = $_SERVER[ 'SERVER_NAME' ];
if (strpos($url,'igopnet.cc') !== false) {
		require_once '/home/info_euromovements/webapps/igop/wp-content/themes/igopnet-child/CMB2/init.php';
} else {
		require_once  __DIR__ . '/CMB2/init.php';  //for some enviroments __DIR__ won't work. Use the home path '/home/pangea/info_euromovements/public_html/igop/wp-content/themes/igopnet-child/CMB2/init.php'
}
//register nave menu for Directory
add_action( 'after_setup_theme', 'register_directory_menu' );
function register_directory_menu() {
  register_nav_menu( 'directory-tecnopol', 'Directorio Teconpolitics' );
}

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
		'label' => __( 'Ecosistema' ),
		'hierarchical' => true,
		'rewrite' => array( 'slug' => 'org-ecosystem' ) ) );
	register_taxonomy( 'org-type', 'organization', array(
		'label' => __( 'Tipo' ),
		'hierarchical' => true,
		'rewrite' => array( 'slug' => 'org-type' ) ) );
	register_taxonomy( 'org-scope', 'organization', array(
		'label' => __( 'Alcance' ),
		'hierarchical' => true,
		'rewrite' => array( 'slug' => 'org-scope' ) ) );
	register_taxonomy( 'org-whom', 'organization', array(
		'label' => __( 'A quién' ),
		'hierarchical' => true,
		'rewrite' => array( 'slug' => 'org-whom' ) ) );
/*	register_taxonomy( 'org-validation', 'organization', array(//TODO validation as taxonomy or custom post type?
		'label' => __( 'Validation' ),
		'hierarchical' => true,
		'rewrite' => array( 'slug' => 'org-validation' ) ) );*/
	register_taxonomy( 'org-city', 'organization', array(
		'label' => __( 'Ciudad' ),
		'hierarchical' => true,
		'rewrite' => array( 'slug' => 'org-city' ) ) );
	register_taxonomy( 'org-region', 'organization', array(
		'label' => __( 'Región' ),
		'hierarchical' => true,
		'rewrite' => array( 'slug' => 'org-region' ) ) );
	register_taxonomy( 'org-country', 'organization', array(
		'label' => __( 'País' ),
		'hierarchical' => true,
		'rewrite' => array( 'slug' => 'org-country' ) ) );
}

function igopnet_metaboxes( $meta_boxes ) {
	$prefix = '_ig_'; // Prefix for all fields
	
	//Basic information
	$meta_boxes[] = array(
		'id' => 'igopnet_organization_basic',
		'title' => __( 'Basic information' ),
		'object_types' => array('organization'), // post type
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
				'date_format' => 'j/m/Y',
			),
			array(
				'name' => 'Fecha de fin',
				'desc' => 'Si se desconoce la fecha exacta, indicar 1 de enero de ese año',
				'id' => $prefix . 'end_date',
				'type' => 'text_date_timestamp',
				'date_format' => 'j/m/Y',
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
			/*array(
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
			),*/
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
					'add_button' => __( 'Add Another URL', 'igopnet' ),
					'remove_button' => __( 'Remove URL', 'igopnet' ),
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

	//Temas principales
	$main_themes = array(
					'' =>'',
		      'Derechos políticos y a minorías' => 'Derechos políticos y a minorías',
		      'Economía y finanzas' => 'Economía y finanzas',
		      'Juventud' => 'Juventud',
		      'Derecho de autodeterminación' => 'Derecho de autodeterminación',
		      'Defensa al Estado de Bienestar' => 'Defensa al Estado de Bienestar',
		      'Derechos digitales' => 'Derechos digitales',
		      'Ecología y medio ambiente' => 'Ecología y medio ambiente',
		      'todas las anteriores ' => 'todas las anteriores ',
		      'ninguna de las anteriores ' => 'ninguna de las anteriores ',
   			 );
	$meta_boxes[] = array(
		'id' => 'igopnet_main_themes',
		'title' => 'Temas principales',
		'object_types' => array('organization'), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => 'Tema principal 1',
				'desc' => __( '' ),
				'id' => $prefix . 'theme_1',
				'type'    => 'select',
				'options' => $main_themes,
				'default' => '',
			),
			array(
				'name' => 'Tema principal 2',
				'desc' => __( '' ),
				'id' => $prefix . 'theme_2',
				'type'    => 'select',
				'options' => $main_themes,
				'default' => '',
			),
			array(
				'name' => 'Tema principal 3',
				'desc' => __( '' ),
				'id' => $prefix . 'theme_3',
				'type'    => 'select',
				'options' => $main_themes,
				'default' => '',
			),
			array(
				'id' => $prefix . 'other_themes',
				'type' => 'textarea',
				'description' => 'Temas no incluidos en las anteriores',
			),
		),
	);
	
	//Demandas principales
	$main_demands = array(
					'' =>'',
		      'comercio justo' => 'comercio justo',
		      'consumo de proximidad' => 'consumo de proximidad',
		      'Defensa a la cultura' => 'Defensa a la cultura',
		      'Defensa a sanidad pública de calidad'     => 'Defensa a sanidad pública de calidad',
		      'Demanda de la tasa tobin' => 'Demanda de la  tasa tobin',
		      'Derecho a decidir' => 'Derecho a decidir',
		      'Derecho a Vivienda Digna' => 'Derecho a Vivienda Digna',
		      'Derechos a minorías LGBT' => 'Derechos a minorías LGBT',
		      'Disminución de emisiones' => 'Disminución de emisiones',
		      'Educación pública de calidad' => 'Educación pública de calidad',
		      'Eliminación de las Sociedades de Inversión de Capital Variable (SICAV)' => 'Eliminación de las Sociedades de Inversión de Capital Variable (SICAV)',
		      'Emancipación juvenil' => 'Emancipación juvenil',
		      'Igualdad de derechos de inmigrantes' => 'Igualdad de derechos de inmigrantes',
		      'Igualdad de género' => 'Igualdad de género',
		      'Impuestos progresivos ( o a grandes fortunas)' => 'Impuestos progresivos ( o a grandes fortunas)',
		      'Independencia de España' => 'Independencia de España',
		      'Independencia del poder judicial' => 'Independencia del poder judicial',
		      'libertad de información' => 'libertad de información',
		      'Más y mejores mecanismos de participación' => 'Más y mejores mecanismos de participación',
		      'mayor control a los bancos' => 'mayor control a los bancos',
		      'Memoria Histórica' => 'Memoria Histórica',
		      'No más exilio económico' => 'No más exilio económico',
		      'No más precariedad laboral' => 'No más precariedad laboral',
		      'No recortes a estado de bienestar' => 'No recortes a estado de bienestar',
		      'Por un Internet libre y abierto' => 'Por un Internet libre y abierto',
		      'Promoción y uso de energía renovables' => 'Promoción y uso de energía renovables',
		      'Que el rescate lo paguen los bancos' => 'Que el rescate lo paguen los bancos',
		      'Reducción de emisiones' => 'Reducción de emisiones',
		      'Reducción edad de jubilación' => 'Reducción edad de jubilación',
		      'Renta mínima universal' => 'Renta mínima universal',
		      'Respeto libertad de expresión' => 'Respeto libertad de expresión',
		      'Responsabilidad patrimonial a banqueros' => 'Responsabilidad patrimonial a banqueros',
		      'Responsabilidad política' => 'Responsabilidad política',
		      'Sistema electoral más proporcional' => 'Sistema electoral más proporcional',
		      'Stop privatizaciones' => 'Stop privatizaciones',
		      'Transparencia política' => 'Transparencia política',
		      'transporte público gratuito' => 'transporte público gratuito',
		      'todas las anteriores ' => 'todas las anteriores ',
		      'ninguna de las anteriores ' => 'ninguna de las anteriores ',
   			 );
	$meta_boxes[] = array(
		'id' => 'igopnet_main_demands',
		'title' => 'Demandas principales',
		'object_types' => array('organization'), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => 'Demanda principal 1',
				'desc' => __( '' ),
				'id' => $prefix . 'demand_1',
				'type'    => 'select',
				'options' => $main_demands,
				'default' => '',
			),
			array(
				'name' => 'Demanda principal 2',
				'desc' => __( '' ),
				'id' => $prefix . 'demand_2',
				'type'    => 'select',
				'options' => $main_demands,
				'default' => '',
			),
			array(
				'name' => 'Demanda principal 3',
				'desc' => __( '' ),
				'id' => $prefix . 'demand_3',
				'type'    => 'select',
				'options' => $main_demands,
				'default' => '',
			),
			array(
				'id' => $prefix . 'other_demands',
				'type' => 'textarea',
				'description' => 'Demanda no incluidas en las anteriores',
			),
		),
	);

	//Acciones de reivindicación más frecuentes
	$main_actions = array(
					'' =>'',
		      'Acampadas' => 'Acampadas',
		      'Amenazas' => 'Amenazas',
		      'Asesoría legal' => 'Asesoría legal',
		      'Ataques DDoS'     => 'Ataques DDoS',
		      'Asambleas' => 'Asambleas',
		      'bloqueos' => 'bloqueos',
		      'boicots' => 'boicots',
		      'denunciar abusos al interes público' => 'denunciar abusos al interes público',
		      'Obtener financiación' => 'Obtener financiación',
		      'promover el voto para ellos o terceras agrupaciones que apoyen' => 'promover el voto para ellos o terceras agrupaciones que apoyen',
		      'disuadir que se vote por ciertas agrupaciones' => 'disuadir que se vote por ciertas agrupaciones',
		      'encierros' => 'encierros',
		      'Escraches' => 'Escraches',
		      'flash mobs' => 'flash mobs',
		      'filtraciones de informacion de interés público' => 'filtraciones de informacion de interés público',
		      'obtener firmas de apoyo a acciones' => 'obtener firmas de apoyo a acciones',
		      'Grupos de trabajo' => 'Grupos de trabajo',
		      'hackeo' => 'hackeo',
		      'Huelgas' => 'Huelgas',
		      'lobby (cabildeo directo)' => 'lobby (cabildeo directo)',
		      'Ocupaciones' => ',Ocupaciones',
		      'Organizar manifestaciones' => 'Organizar manifestaciones',
		      'Participar en manifestaciones' => 'Participar en manifestaciones',
		      'quedadas' => 'quedadas',
		      'retenciones' => 'retenciones',
		      'Vandalismo' => 'Vandalismo',
		      'detener acciones judiciales (ej:parar desaucios)' => 'detener acciones judiciales (ej:parar desaucios)', //TODO erase ej
		      'campañas solidarias' => 'campañas solidarias',
		      'reclutar simpatizantes' => 'reclutar simpatizantes',
		      'todas las anteriores' => 'todas las anteriores',
   			 );
	$meta_boxes[] = array(
		'id' => 'igopnet_main_activities',
		'title' => 'Acciones de reinvindicación más frecuentes',
		'object_types' => array('organization'), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => 'Acciones de reinvindicación más frecuentes 1',
				'desc' => __( '' ),
				'id' => $prefix . 'action_1',
				'type'    => 'select',
				'options' => $main_actions,
				'default' => '',
			),
			array(
				'name' => 'Acciones de reinvindicación más frecuentes 2',
				'desc' => __( '' ),
				'id' => $prefix . 'action_2',
				'type'    => 'select',
				'options' => $main_actions,
				'default' => '',
			),
			array(
				'name' => 'Acciones de reinvindicación más frecuentes 3',
				'desc' => __( '' ),
				'id' => $prefix . 'action_3',
				'type'    => 'select',
				'options' => $main_actions,
				'default' => '',
			),
			array(
				'id' => $prefix . 'other_actions',
				'type' => 'textarea',
				'description' => 'Acciones de reinvindicación mas frecuentes no incluidas en las anteriores',
			),
		),
	);

	//Social networking sites information
	$meta_boxes[] = array(
		'id' => 'igopnet_social_networking_sites',
		'title' => __( 'Social Networks' ),
		'object_types' => array('organization'), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => __( 'Facebook URL' ),
				'desc' => __( 'Ex: juventudsinfuturo' ),
				'id' => $prefix . 'facebook_site',
				'type' => 'text_medium'
			),
			array(
				'name' => __( 'Youtube account' ),
				'desc' => __( 'Ex: https://www.youtube.com/user/' ),
				'id' => $prefix . 'youtube_account',
				'type' => 'text_medium',
			),
			array(
				'id' => $prefix . 'other_youtube_accounts',
				'type' => 'group',
				'description' => __( 'Secondary Youtube Accounts','igopnet' ),
				'options' => array(
					'add_button' => __( 'Add Another Youtube account', 'igopnet' ),
					'remove_button' => __( 'Remove Youtube account', 'igopnet' ),
				),
 				'fields' => array(
					array(
						'name' => 'Secondary Youtube account',
 						'id'   => 'user',
 						'desc' => __( 'Ex: juventudsin' ),
						'type' => 'text_medium',
					),
				),
			),
			array(
				'name' => 'Site technologies',
				'desc' => 'Main site techonologies. Ex: "Analytics: Google Analytics Blog: WordPress CMS: WordPress Font script: Google Font API JavaScript framework: jQuery Mobile framework: jQuery Mobile Web server: Nginx"',
				'id' => $prefix . 'site_technologies',
				'type' => 'textarea',
			),
			array(
				'name' => __( 'Twitter main account' ),
				'desc' => __( 'Do not incluse the "@". Ex: juventudsin' ),
				'id' => $prefix . 'twitter_account',
				'type' => 'text_medium',
			),
			array(
				'name' => __( 'When Twittter account started' ),
				'desc' => __( '' ),
				'id' => $prefix . 'twitter_origin',
				'type' => 'text_date_timestamp',
				'date_format' => 'j/m/Y',
			),
			array(
				'id' => $prefix . 'other_twitter_accounts',
				'type' => 'group',
				'description' => __( 'Secondary Twitter Accounts','igopnet' ),
				'options' => array(
					'add_button' => __( 'Add Another Twitter account', 'igopnet' ),
					'remove_button' => __( 'Remove Twitter account', 'igopnet' ),
				),
 				'fields' => array(
					array(
						'name' => 'Secondary Twitter account',
 						'id'   => 'user',
 						'desc' => __( 'Do not incluse the "@". Ex: juventudsin' ),
						'type' => 'text_medium',
					),
					array(
						'name' => __( 'When Twittter account started' ),
						'desc' => __( '' ),
						'id' => 'twitter_origin',
						'type' => 'text_date_timestamp',
						'date_format' => 'j/m/Y',
					),
				),
			),
			array(
				'id' => $prefix . 'other_facebook_accounts',
				'type' => 'group',
				'description' => __( 'Secondary Facebook Accounts','igopnet' ),
				'options' => array(
					'add_button' => __( 'Add Another Facebook account', 'igopnet' ),
					'remove_button' => __( 'Remove Facebook account', 'igopnet' ),
				),
 				'fields' => array(
					array(
						'name' => 'Secondary Facebook account',
 						'id'   => 'user',
 						'desc' => __( '' ),
						'type' => 'text_medium',
					),
				),
			),
		),
	);

	//Websites related information in time
	$meta_boxes[] = array(
		'id' => 'igopnet_website_info',
		'title' => __( 'Websites related information' ),
		'object_types' => array('organization'), // post type
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
					'add_button' => __( 'Add more data', 'igopnet' ),
					'remove_button' => __( 'Remove data', 'igopnet' ),
				),
				'fields' => array(
					array(
						'name' => 'Date',
						'id'   => 'date',
						'desc' => __( 'Select date when date where obtained' ),
						'type' => 'text_date_timestamp',
						//'date_format' => 'j/m/Y',
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
					array(
						'name' => 'Site Techonologies',
						'id'   => 'site_technologies',
						'type' => 'text',
					),
				),
			),
		),
	);

	//Twitter information in time
	$meta_boxes[] = array(
		'id' => 'igopnet_twitter_info',
		'title' => __( 'Twitter in time information' ),
		'object_types' => array('organization'), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'id' => $prefix . 'twitter_info',
				'type' => 'group',
				'description' => __( 'Info about Twitter accounts','igopnet' ),
				'options' => array(
					'group_title' => __( 'Twitter data', 'igopnet' ),
					'add_button' => __( 'Add more data', 'igopnet' ),
					'remove_button' => __( 'Remove data', 'igopnet' ),
				),
				'fields' => array(
					array(
						'name' => 'Fecha',
						'id'   => 'date',
						'desc' => __( 'Select date when date where obtained' ),
						'type' => 'text_date_timestamp',
						//'date_format' => 'j/m/Y',
					),
					array(
						'name' => 'Cuenta de Twitter',
						'id'   => 'user',
						'desc' => 'No incluyas "@". Ex: juventudsin',
						'type' => 'text_small',
					),
					array(
						'name' => 'Followers',
						'id'   => 'followers',
						'type' => 'text_small',
					),
					array(
						'name' => 'Following',
						'id'   => 'following',
						'type' => 'text_small',
					),
					array(
						'name' => 'Favorites',
						'id'   => 'favorites',
						'type' => 'text_small',
					),
					array(
						'name' => 'Tweets',
						'id'   => 'tweets',
						'type' => 'text_small',
					),
				),
			),
		),
	);
	
	//Facebook information in time
	$meta_boxes[] = array(
		'id' => 'igopnet_facebook_info',
		'title' => __( 'Facebook in time information' ),
		'object_types' => array('organization'), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'id' => $prefix . 'facebook_info',
				'type' => 'group',
				'description' => __( 'Info about Facebook','igopnet' ),
				'options' => array(
					'group_title' => __( 'Facebook data', 'igopnet' ),
					'add_button' => __( 'Add more data', 'igopnet' ),
					'remove_button' => __( 'Remove data', 'igopnet' ),
				),
				'fields' => array(
					array(
						'name' => 'Fecha',
						'id'   => 'date',
						'desc' => __( 'Select date when date where obtained' ),
						'type' => 'text_date_timestamp',
						//'date_format' => 'j/m/Y',
					),
					array(
						'name' => 'Cuenta de Facebook',
						'id'   => 'user',
						'desc' => 'Ex: juventudsin',
						'type' => 'text_small',
					),
					array(
						'name' => 'Likes',
						'id'   => 'likes',
						'type' => 'text_small',
					),
				),
			),
		),
	);
	
	//Source of information
	$meta_boxes[] = array(
		'id' => 'igopnet_organization_information_source',
		'title' => __( 'Source of information' ),
		'object_types' => array('organization'), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => 'Codificador',
				'desc' => __( '' ),
				'id' => $prefix . 'coder',
				'type' => 'text_medium'
			),
			array(
				'name' => 'Fecha de incorporación de los datos',
				'desc' => '',
				'id' => $prefix . 'data_date',
				'type' => 'text_date_timestamp',
				'date_format' => 'j/m/Y',
			),
			array(
				'name' => 'Email (del formulario) de quien aporta los datos',
				'desc' => 'Este apartado no se publica en la web',
				'id' => $prefix . 'email_informant',
				'type' => 'text',
			),
			array(
				'name' => 'Fuente de los datos',
				'id' => $prefix . 'info_source',
				'type' => 'group',
				'description' => __( '','igopnet' ),
				'options' => array(
					'add_button' => __( 'Add Another information source', 'igopnet' ),
					'remove_button' => __( 'Remove information source', 'igopnet' ),
				),
 				'fields' => array(
					array(
						'name' => 'Other source of information',
 						'id'   => 'info',
 						'desc' => __( '' ),
						'type' => 'text',
					),
				),
			),
			array(
				'name' => 'Validación',
				'desc' => '',
				'id' => $prefix . 'validation',
				'type' => 'radio_inline',
				'options' => array(
				    array('name' => 'yes', 'value' => 'yes'),
				    array('name' => 'no', 'value' => 'no'),
				)
			),
		),
	);
	
	//Pages belong to directory tecnopolitics
	$meta_boxes[] = array(
		'id' => 'igopnet_directory_pages',
		'title' => __( 'Página pertenece a...' ),
		'object_types' => array('page'), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => 'Página pertenece a',
				'desc' => __( '' ),
				'id' => $prefix . 'belongs_to',
				'type'    => 'select',
				'options' => array(
					'' =>'',
		      'directory tecnopolitics' => 'directory tecnopolitics',
		      ),
		    'default' => '',
			),
			array(
				'name' => 'Active ecosystem',
				'desc' => __( '' ),
				'id' => $prefix . 'active_ecosystem',
				'type'    => 'select',
				'options' => array(
					'15m' =>'15m',
		      'independencia-cataluna' => 'independencia-cataluna',
		      ),
		    'default' => '15M',
			),
		),
	);
	
				
	
  return $meta_boxes;
}

// Function to list values of custom metaboxes in dd dt format.
function list_of_items($postid,$value,$name) {
	$items = get_post_meta($postid,$value,true);
	if ($items!='') {
		echo "<dt>".$name."</dt>";
		echo "<dd>".$items."</dd>";
		}
}

// Function to list taxonomy terms of Waste Picker Organization in dt-dd format
function list_taxonomy_terms($post_id='',$slug='',$name='') {
	$term_list = get_the_term_list( $post_id, $slug , ' ', ', ', '' );
	if (!empty($term_list)) {
		echo "<dt>" .$name. "</dt>";
		echo "<dd>". display_tax_link_with_ecosystem( $post_id, $slug). "</dd>";
	}
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

// load js scripts to avoid conflicts
function igopnet_load_css() {
	//Prepares data to checks if this page belongs to directory
	global $post;
	$page_belongs_to = get_post_meta( $post->ID, '_ig_belongs_to' , true );
	
	if (($page_belongs_to == 'directory tecnopolitics') || (get_post_type() == 'organization')) {
		wp_register_style( 'bootstrap-css', get_stylesheet_directory_uri() . '/bootstrap/css/bootstrap.css',array(),null );
		wp_register_style( 'directory-css', get_stylesheet_directory_uri() . '/directory.css',array(),null );
		wp_enqueue_style( 'bootstrap-css' );
		wp_enqueue_style( 'directory-css' );
		wp_enqueue_script( 'jquery', '/wp-includes/js/jquery/jquery.js',array(),null);
		wp_enqueue_script( 'bootstrap-js', get_stylesheet_directory_uri() . '/bootstrap/js/bootstrap.js',array(),null);
	} else {
		wp_register_style( 'igop-css', get_stylesheet_uri());
		wp_enqueue_style( 'igop-css' );
	}
} // end load js scripts to avoid conflicts

//Function to get the number of waste picker groups that have certain custom fields and are 'waste pickers'
function get_number_posts($meta_key,$meta_value) {
	$args = array(
				'posts_per_page' => -1,
				'post_type' => 'organization',
				'meta_query' => array(
					 array(
						'key'     => $meta_key,
						'value'   => $meta_value,
						'compare' => 'LIKE',
						),
					),
				);
	$posts_array = get_posts( $args );
	$result = count($posts_array);
	return $result;
}

//Hook archive.php to display only organizations in archive from one ecosystem $active_ecosystem
add_action( 'pre_get_posts', 'be_change_event_posts_per_page' );
function be_change_event_posts_per_page( $query ) {
	if (is_tax()) {//TODO change if new taxonomies are created for the standard post
		$base_url = get_permalink();
		preg_match('/\?/',$base_url,$matches); // check if pretty permalinks enabled
		if ( $matches[0] == "?" ) {
			$param_url = "&ecosystem=";
		} else {
			$param_url = "?ecosystem=";
		}

		$active_ecosystem = sanitize_text_field( $_GET['ecosystem'] );
		if ($active_ecosystem == '' ) {
			$active_ecosystem = '15m';//TODO chage by default to all
		}
	
		if( $query->is_main_query() && $query->is_archive() ) {
			$query->set( 'posts_per_page', '-1' );

			$meta_query = array(
				array(
					'taxonomy' => 'org-ecosystem',
					'field'    => 'slug',
					'terms'    => $active_ecosystem,
				),
			);
			$query->set( 'tax_query', $meta_query );
			$query->set( 'orderby', 'title' );
			$query->set( 'order', 'ASC' );
		}
	}
}

function display_tax_link_with_ecosystem($post_id, $tax) {
	//Displays organization type and links to the taxonomy archive page with the propper url related to active ecosystem
	$tax_data = wp_get_post_terms($post_id, $tax, array("fields" => "all"));
	$ecosystem = wp_get_post_terms($post_id, 'org-ecosystem', array("fields" => "all"));
	return "<a href='/". $tax_data[0]->taxonomy ."/". $tax_data[0]->slug ."/?ecosystem=". $ecosystem[0]->slug ."'>". $tax_data[0]->name ."</a>";
}

//Calculates median of an array of values via http://codereview.stackexchange.com/questions/220/calculate-a-median
function array_median($array) {
  // perhaps all non numeric values should filtered out of $array here?
  $iCount = count($array);
  if ($iCount == 0) {
    throw new DomainException('Median of an empty array is undefined');
  }
  // if we're down here it must mean $array
  // has at least 1 item in the array.
  $middle_index = floor($iCount / 2);
  sort($array, SORT_NUMERIC);
  $median = $array[$middle_index]; // assume an odd # of items
  // Handle the even case by averaging the middle 2 items
  if ($iCount % 2 == 0) {
    $median = ($median + $array[$middle_index - 1]) / 2;
  }
  return $median;
}

//Calculates Average
function array_average($array) {
	return array_sum($array)/count($array);
}

//Calculates standard deviation
function stats_standard_deviation(array $a, $sample = false) {
  $n = count($a);
  if ($n === 0) {
      trigger_error("The array has zero elements", E_USER_WARNING);
      return false;
  }
  if ($sample && $n === 1) {
      trigger_error("The array has only 1 element", E_USER_WARNING);
      return false;
  }
  $mean = array_sum($a) / $n;
  $carry = 0.0;
  foreach ($a as $val) {
      $d = ((double) $val) - $mean;
      $carry += $d * $d;
  };
  if ($sample) {
     --$n;
  }
  return sqrt($carry / $n);
}

//Calculates stats values
function stats_values($array) {
	$text =	"<bbr title='Número de elementos'>n</abbr> = ". count( $array ) ."<br>
	<bbr title='Mediana'>M</abbr> = ". number_format( array_median( $array ), 0, ',', '.') ."<br>
	<bbr title='Media'>μ</abbr> = ". number_format(array_average( $array ), 1, ',', '.') ."<br>
	<abbr title='Desviación típica'>σ</abbr> = ".  number_format(stats_standard_deviation ( $array ), 1, ',', '.') ."<br>";
	return $text;
}

//Submit organization form
function creates_form() {

	$action = get_permalink();

	//Stores terms for taxonomies
	$ecosystem_terms = get_terms( 'org-ecosystem', 'hide_empty=0' );
	$type_terms = get_terms( 'org-type', 'hide_empty=0' );
	$scope_terms = get_terms( 'org-scope', 'hide_empty=0'  );
	$city_terms = get_terms( 'org-city', 'hide_empty=0' );
	
	//Creates array
	foreach ($ecosystem_terms as $key) {
		$ecosystems[$key->name] = $key->name;
	}
	foreach ($type_terms as $key) {
		$types[$key->name] = $key->name;
	}
	foreach ($scope_terms as $key) {
		$scopes[$key->name] = $key->name;
	}
	$scopes= array_merge(array_flip(array('Local','Autonómico','Nacional')), $scopes);
	foreach ($city_terms as $key) {
		$cities[$key->name] = $key->name;
	}
	
	//Creates options for multicheck in html
	$options_ecosystems = "";
	while ( $ecosystem = current($ecosystems) ) {
		$options_ecosystems .= "<div class='checkbox'><label><input type='checkbox' name='ecosystem_list[]' value='" .key($ecosystems). "'>" .ucfirst(key($ecosystems)). "</label></div>";
		next($ecosystems);
	}
	
	$options_types = "";
	while ( $type = current($types) ) {
		$options_types .= "<div class='checkbox'><label><input type='checkbox' name='type_list[]'' value='" .key($types). "'>" .ucfirst(key($types)). "</label></div>";
		next($types);
	}

	$options_scopes = "";
	while ( $scope = current($scopes) ) {
		$options_scopes .= "<div class='checkbox'><label><input type='checkbox' name='scopes_list[]'' value='" .key($scopes). "'>" .ucfirst(key($scopes)). "</label></div>";
		next($scopes);
	}
	$options_cities = "";
	while ( $city = current($cities) ) {
		$options_cities .= "<div class='checkbox'><label><input type='checkbox' name='cities_list[]'' value='" .key($cities). "'>" .ucfirst(key($cities)). "</label></div>";
		next($cities);
	}
	
	$form_out = "
<form id='directory-form-content' method='post' action='" .$action. "' enctype='multipart/form-data'>
<div class='row'>
	<div class='form-horizontal col-md-10'>
		<legend>Informaci&oacute;n b&aacute;sica</legend>
		<div class='form-group'>
			<label for='org-name' class='col-sm-4 control-label'>Nombre de organizaci&oacute;n*</label>
			<div class='col-sm-6'>
				<input class='form-control req' type='text' value='' name='org-name' />
			</div>
		</div>
		<div class='form-group'>
			<label for='org-website' class='col-sm-4 control-label'>P&aacutegina web principal*</label>
			<div class='col-sm-6'>
				<input class='form-control req' type='text' value='' name='org-website' />
				<p class='help-block'><small>URL de la organizaci&oacute;n. Ej.: http://example.org</small></p>
			</div>
		</div>
		<div class='form-group'>
			<label for='org-website' class='col-sm-4 control-label'>Facebook</label>
			<div class='col-sm-6'>
				<input class='form-control req' type='text' value='' name='facebook' />
				<p class='help-block'><small>Si la url es 'https://www.facebook.com/democraciarealya' pon solo lo que va detrás de 'facebook.com/'. Ej.: 'democraciarealya' </small></p>
			</div>
		</div>
		<div class='form-group'>
			<label for='org-website' class='col-sm-4 control-label'>Youtube</label>
			<div class='col-sm-6'>
				<input class='form-control req' type='text' value='' name='youtube' />
				<p class='help-block'><small>Si la url es 'https://www.youtube.com/user/15MpaRato' pon solo lo que va detrás de 'youtube.com/'. Ej.: '15MpaRato' </small></p>
			</div>
		</div>
		<div class='form-group'>
			<label for='org-website' class='col-sm-4 control-label'>Twitter</label>
			<div class='col-sm-6'>
				<input class='form-control req' type='text' value='' name='twitter' />
				<p class='help-block'><small>Si la url es 'https://twitter.com/juventudsin' pon solo lo que va detrás de 'twitter.com/'. Ej.: 'juventudsin' </small></p>
			</div>
		</div>
		<div class='form-group'>
			<label class='col-sm-4 control-label'>Ecosistema</label>
			<div class='col-sm-6'>
				" .$options_ecosystems. "
			</div>
		</div>
		<!--<div class='form-group'>
			<label for='org-avatar' class='col-sm-4 control-label'>Image or Logo</label>
			<div class='col-sm-6'>
				<input type='file' name='org-avatar' />
				<input type='hidden' name='MAX_FILE_SIZE' value='4000000' />
			<p class='help-block'><small>Image or logotype of the organization. Not bigger than<strong> 4MB</strong> and <strong>must be JPG, PNG or GIF</strong>.</small></p>
			</div>
		</div>-->

		<legend>Primary Information</legend>
		<div class='form-group'>
			<label class='col-sm-4 control-label'>Tipo de organizaci&oacute;n</label>
			<div class='col-sm-6'>
				" .$options_types. "
			</div>
		</div>
		<div class='form-group'>
			<label class='col-sm-4 control-label'>Alcance</label>
			<div class='col-sm-6'>
				". $options_scopes ."
			</div>
		</div>
		<div class='form-group'>
			<label class='col-sm-4 control-label'>Ciudad</label>
			<div class='col-sm-6'>
				". $options_cities ."
			</div>
		</div>
		<div class='form-group'>
			<label for='org-website' class='col-sm-4 control-label'>Email informador</label>
			<div class='col-sm-6'>
				<input class='form-control req' type='text' value='' name='email-informant' />
				<p class='help-block'><small>Danos tu email si quieres ampliar la informaci&oacute;n sobre esta organizaci&oacute;n.</small></p>
			</div>
		</div>
		<div class='form-group'>
		  <div class='col-sm-offset-4 col-sm-6'>
		  	<input class='btn btn-default' type='submit' value='Enviar' name='org-form-submit' />
				<span class='help-block'><small><strong></strong>.</small></span>
		  </div>
  	</div>
	</div>
</div>
</form>
";
	echo $form_out;

} // end add WPG

// insert wpg data in database
function inserts_form() {

	// messages and locations for redirection
	$perma = get_permalink();
	$location_form = $perma."?form=success";
	$error = "<div class='alert alert-danger'>
		<p>Uno o varios campos están vacíos o no tienen un formato válido.</p>
		<p>En cualquier caso el formulario no se envió correctamente. Por favor, inténtalo de nuevo.</p>
	</div>";
	$success = "<div class='alert alert-success'>El formulario ha sido enviado correctamente: hemos recibido tus datos. Vamos a revisarlos y nos pondremos en contacto con el email que nos has proporcionado.</div> ";

	if ( array_key_exists('form', $_GET) ) {
		if ( sanitize_text_field( $_GET['form']) == 'success' ){
			echo "<strong>" .$success. "</strong>";
			return;
		}
	}

	if ( !array_key_exists('org-form-submit', $_POST) ) {
		creates_form();
		return;

	} elseif ( sanitize_text_field( $_POST['org-form-submit'] ) != 'Enviar' ) {
		creates_form();
		echo "har";
		return;
	}

	// check if all fields have been filled
	// sanitize them all
	$org_name = sanitize_text_field( $_POST['org-name'] );
	$main_website = sanitize_text_field( $_POST['org-website'] );
	$email_informant = sanitize_text_field( $_POST['email-informant'] );
	$facebook = sanitize_text_field( $_POST['facebook'] );
	$youtube = sanitize_text_field( $_POST['youtube'] );
	$twitter = sanitize_text_field( $_POST['twitter'] );
		//terms
	$ecosystem = $_POST['ecosystem_list'];
	$org_type = $_POST['type_list'];
	$org_scope = $_POST['scopes_list'];
	$org_city = $_POST['cities_list'];
	
	// check that all required fields were filled
	$fields = array(
		//'title' => $wpg_name, TODO how to check name exists and not include it in this array (used for custom field inserts)
		'_ig_main_url' => $main_website,
		'_ig_email_informant' => $email_informant,
		'_ig_facebook_site' => $facebook,
		'_ig_youtube_account' => $youtube,
		'_ig_twitter_account' => $twitter,
	);
	
	$terms = array(
		'org-ecosystem' => $ecosystem,
		'org-type' => $org_type,
		'org-scope' => $org_scope,
		'org-city' => $org_city,
	);
	//print_r($fields);
	foreach ( $fields as $name => $field ) {
		//echo $name.' is: '. $field. '<br>';
		//echo $name;
		if ( $field == '' ) {
			echo $error;
			echo '<p>El campo <strong>';
				if ($name == '_ig_main_url') {
					echo 'Pagina Web principal';
				} elseif ($name == '_ig_email_informant') {
					echo 'Email';
				} else {
					echo $name;
				}
			echo '</strong> est&aacute; vac&iacute;o.</p>';
			creates_form();
			return;
			}
	}
	
	// end checking

	// if everything ok, do insert

	// insert waste picker group
	$org_id = wp_insert_post(array(
		'post_type' => 'organization',
		'post_status' => 'draft',
		'post_author' => 1,
		'post_title' => $org_name,
	));

	if ( $org_id == 0 ) {
		echo $error;
		creates_form();
		return;
	}

	// insert custom fields
	reset($fields);
	while ( $field = current($fields) ) {//TODO do not use current, becasue it is the title, and it is not a custom field
		add_post_meta($org_id, key($fields), $field, TRUE);
		next($fields);
	}
	
	////echo "the id is " .$org_id. ".<br>";
	//echo $permalink;
	
	// insert taxonomies
	foreach ( $terms as $key => $value ) {
		//echo "insert: ".$value." in" . $key .".<br>";
		wp_set_object_terms( $org_id, $value, $key);
	}
	
	echo "<div class='alert alert-success' role='alert'>Gracias, nos pondremos en contacto contigo si hace falta m&aacute; informaci&oacute;n.</div>";
	//wp_redirect( $location_form ); TODO wp_redirect gives Warning: Cannot modify header information - headers already sent by
	//exit;

} // end insert wpg data in database
?>
