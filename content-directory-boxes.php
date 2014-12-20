<?php
/**
 * The template used for displaying boxes of directory in page.php
 */
$prefix = '_ig_';
$active_ecosytem = get_post_meta( $post->ID, $prefix . 'active_ecosystem' , true );
?>
<?php get_template_part( 'nav', 'directory-tecnopolitics' ); ?>
<article id="directory-list" <?php post_class('container'); ?>>
	<header class="entry-header">
		<?php if ( ! is_page_template( 'page-templates/front-page.php' ) ) : ?>
		<?php the_post_thumbnail(); ?>
		<?php endif; ?>
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header>

	<div class="entry-content">
		<?php the_content(); ?>
	</div><!-- .entry-content -->
	
	<div class="row">
		<div class="col-md-12">
			<?php 
			$args = array(
				'post_type' => 'organization', 
				'posts_per_page' => -1,
				'orderby' => 'title',
				'order' => 'ASC',
				'tax_query' => array(
						array(
							'taxonomy' => 'org-ecosystem',
							'field'    => 'slug',
							'terms'    => $active_ecosytem,
						),
					),
			);
			$my_query = new WP_Query($args);
			$my_count = $my_query->post_count; //The number of posts being displayed
			$count = 0;
			if ( $my_query->have_posts() ) : while ( $my_query->have_posts() ) :  $my_query->the_post(); ?>
					<?php
					$count++;
			
					if ( $count == 1 || $count % 3 == 1) { 
						echo "<div class='row'>";
					}
			
					get_template_part( 'content', 'organization-box' );
				
					if ( $count % 3 == 0 || $count == $my_count) {
						echo "</div><!-- .row -->";
						$count = 0;
					}
					?>
				<?php endwhile; else: ?>
			<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
			<?php endif; ?>
			</div>
	</div>
	<footer class="entry-meta">
	</footer><!-- .entry-meta -->
</article><!-- #post -->
