<?php  /* Template Name: Blog */ ?>
<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 */

get_header(); ?>

		<div id="primary">
			<div id="content" role="main">
				<div class="entry-content" >

<?php
// BEGIN PFC blogs posts list
//
// blogs array
$blogs = array(
	'0' => array(
		'feed' => 'http://www.onlinecreation.info/?feed=rss2',
		'url' => 'http://www.onlinecreation.info/',
		'tit' => 'Online Creation Communities',
		'desc' => 'Web-blog of Mayo Fuster Morell.'),
	'1' => array(
		'feed' => 'http://leyseca.net/comments/feed/',
		'url' => 'http://leyseca.net/',
		'tit' => 'Ley Seca',
		'desc' => 'Normalizar es gobernar.'),
	/*'2' => array(
		'feed' => 'http://memoria-ics.tumblr.com/rss',
		'url' => 'http://memoria-ics.tumblr.com/',
		'tit' => 'Industrias Creativas Santiago',
		'desc' => 'es un proyecto de Diego Sepúlveda para la Universidad de Chile. Se incluyen en el blog los originales descargables.'),
	'3' => array(
		'feed' => 'http://cuadernodepfc.wordpress.com/feed/',
		'url' => 'http://cuadernodepfc.wordpress.com/',
		'tit' => 'cuadernodepfc',
		'desc' => 'PFC sobre vivienda compartida y artesanía de la ETSA de Sevilla \"he ido elaborando un blog donde voy profundizando en temas teóricos en relación al proyecto y voy subiendo mi material de trabajo\" por Blanca Domínguez.')*/
);

// get each PFC blog feed using DOM
foreach ( $blogs as $blog ) {

	// building blog header
	$blog_pre = "
		<div class='blog-part'>
			<h2 class='blog-tit'>".$blog['tit']."</h2>
			<div class='blog-meta'><a href='".$blog['url']."'>".$blog['url']."</a></div>
			<div class='blog-desc'>".$blog['desc']."</div>
			<ul class='blog-items'>
	";
	// using DOM to extract feed items
	$doc = new DOMDocument();
	$doc->load($blog['feed']);

	// var to define how many feed items we want to retrieve
	$how_many_items = "3";
	// loop along each feed item until loop turn = $how_many_items
	$count = 0;
	$blog_items = "";
	foreach ($doc->getElementsByTagName('item') as $node) {
//		while ( $count <= $how_many_items ) {
		if ( $count == $how_many_items ) {
			break;
		}
			$item_tit = $node->getElementsByTagName('title')->item(0)->nodeValue;
			$item_link = $node->getElementsByTagName('link')->item(0)->nodeValue;
			$item_desc = $node->getElementsByTagName('description')->item(0)->nodeValue;

			$blog_items .= "
				<li class='item-part'>
					<h2 class='item-tit'><strong><a href='".$item_link."' title='Leer el artículo completo'>".$item_tit."</a></strong></h2>
					<div class='item-desc'>".$item_desc."</div>
					<div class='item-link'><a href='".$item_link."' title='Leer el artículo completo'>Read more</a></div>
				</li><!-- end .item-part -->
			";
			$count++;
//		}
	}
	$blog_epi = "
			</ul><!-- end .blog-items -->
		</div><!-- end .blog-part -->
	";
	// output
	echo $blog_pre;
	echo $blog_items;
	echo $blog_epi;
} // end each feed url loop
 
// END PFC blogs posts list
?>

			

				
					
				

			
					</div><!-- .entry-content -->
			</div><!-- #content -->
		</div><!-- #primary -->
<?php get_footer(); ?>
