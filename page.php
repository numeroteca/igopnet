<?php get_header(); ?>

		<div id="primary" role="main">
			<div id="content">

				<?php while ( have_posts() ) : the_post(); ?>
					<?php echo '<!-- ' . basename( get_page_template() ) . ' -->'; ?>
					<?php
						if (is_page('directory')) {
							get_template_part( 'content','directory-list' );
						} else if (is_page('sobre-el-directorio')) {//if it belongs to directory
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
