<?php get_header(); ?>

		<div id="primary" role="main">
			<div id="content">

				<?php while ( have_posts() ) : the_post(); ?>
					
					<?php
						if (is_page() == 'directory') {
							get_template_part( 'content','directory' );
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
