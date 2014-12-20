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
						if (is_page('directory') || is_page('listado-indepencia-cataluna')) {
							get_template_part( 'content','directory-list' );
						} else if (is_page('Boxes 15M') || is_page('Boxes Independencia Cataluña')) { //if it belongs to directory
							get_template_part( 'content','directory-boxes' );
						} else if (is_page('Estadísticas')) { //if it belongs to directory
							get_template_part( 'content','directory-stats' );
						} else if ($page_belongs_to == 'directory tecnopolitics') { //if it belongs to directory
							get_template_part( 'content','directory-page' );
						} else {
							get_template_part( 'content', 'page' );
						} ?>

					<?php comments_template( '', true ); ?>

				<?php endwhile; // end of the loop. ?>

			</div><!-- #content -->
		</div><!-- #primary -->
		<div id="secondary" class="widget-area" role="complementary">
			<?php do_action('icl_language_selector'); ?>
		</div>
<?php get_footer(); ?>
