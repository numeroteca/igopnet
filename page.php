<?php get_header(); ?>
<?php
$post_id = $post->ID;
$prefix = '_ig_';
$page_belongs_to = get_post_meta( $post_id, $prefix.'belongs_to' , true );
?>

<div id="primary" role="main">
	<div id="content">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php echo '<!-- ' . basename( get_page_template() ) . ' -->'; ?>
			<?php
				if (is_page('directory') || is_page('listado')) {
					get_template_part( 'content','directory-list' );
				} else if (is_page('Boxes 15M') || is_page('Boxes Independencia Cataluña') || is_page('Mosaico 15M') || is_page('Mosaico Independentista-soberanista catalana') || is_page('mosaico-cat')) {
					get_template_part( 'content','directory-boxes' );
				} else if (is_page('estadisticas-cat') || is_page('estadisticas-15m') ) {
					get_template_part( 'content','directory-stats' );
				} else if (is_page('Añadir organización')) {
					get_template_part( 'content','directory-form' );
				} else if ($page_belongs_to == 'directory tecnopolitics') { //if it belongs to directory
					get_template_part( 'content','directory-page' );
				} else {
					get_template_part( 'content', 'page' );
				} ?>

			<?php
			if (is_page('directory') || is_page('listado-indepencia-cataluna') || is_page('Boxes 15M') || is_page('Boxes Independencia Cataluña') || is_page('Estadísticas Cat') || is_page('Estadísticas 15M') || is_page('anadir-organizacion')) {
			} else {
				comments_template( '', true );
			}
			?>

		<?php endwhile; // end of the loop. ?>

	</div><!-- #content -->
</div><!-- #primary -->
<?php
if (is_page('directory') || is_page('listado-indepencia-cataluna') || is_page('Boxes 15M') || is_page('Boxes Independencia Cataluña') || is_page('Estadísticas Cat') || is_page('Estadísticas 15M') || is_page('Sobre el directorio') || is_page('anadir-organizacion')) {
	//Do nothing
} else { ?>
<div id="secondary" class="widget-area" role="complementary">
	<?php do_action('icl_language_selector'); ?>
</div>
<?php } ?>
<?php get_footer(); ?>
