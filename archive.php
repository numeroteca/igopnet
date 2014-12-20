<?php
/**
 * Template for displaying Archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 */

get_header(); ?>

		<section id="primary">
			<div id="content" role="main" class="archive">
				<?php if ( is_tax() ) : get_template_part( 'nav', 'directory-tecnopolitics' ); endif; ?>
				
			<?php if ( have_posts() ) : ?>

				<header class="page-header">
					<h1 class="page-title">
						<?php if ( is_day() ) : ?>
							<?php printf( __( 'Daily Archives: %s', 'twentyeleven' ), '<span>' . get_the_date() . '</span>' ); ?>
						<?php elseif ( is_month() ) : ?>
							<?php printf( __( 'Monthly Archives: %s', 'twentyeleven' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'twentyeleven' ) ) . '</span>' ); ?>
						<?php elseif ( is_year() ) : ?>
							<?php printf( __( 'Yearly Archives: %s', 'twentyeleven' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'twentyeleven' ) ) . '</span>' ); ?>
						<?php elseif ( is_tax() ) : ?>
							
							<?php single_cat_title(); ?>
						<?php else : ?>
							<?php _e( 'Blog Archives', 'twentyeleven' ); ?>
						<?php endif; ?>
					</h1>
				</header>

				<?php twentyeleven_content_nav( 'nav-above' ); ?>
				<?php $count = 0; ?>
				<?php $my_count = $wp_query->post_count; //The number of posts being displayed ?>
				<?php /* Start the Loop */?>
				<?php while ( have_posts() ) : the_post(); 

					if (get_post_type() == 'organization') { //if it is an organization
						$count++;
						if ( $count == 1 || $count % 3 == 1) { echo "<div class='row'>"; }
							get_template_part( 'content', 'organization-box' );
						if ( $count % 3 == 0 || $count == $my_count) { echo "</div><!-- .row -->";} 	
						
					} else {
						/* Include the Post-Format-specific template for the content.
						 * If you want to overload this in a child theme then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'content', get_post_format() );
					}
					?>

				<?php endwhile; ?>

				<?php twentyeleven_content_nav( 'nav-below' ); ?>

			<?php else : ?>
			
				<article id="post-0" class="post no-results not-found">
					<header class="entry-header">
						<h1 class="entry-title"><?php _e( 'Nothing Found', 'twentyeleven' ); ?></h1>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'twentyeleven' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->

			<?php endif; ?>

			</div><!-- #content -->
		</section><!-- #primary -->

<?php if ( is_tax() ) : else : get_sidebar(); endif; ?>
<?php get_footer(); ?>
