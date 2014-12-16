<?php
/**
 * The template used for displaying page directory in page.php
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>

	<article id="directory-list" <?php post_class('container'); ?>>
		<header class="entry-header">
			<?php if ( ! is_page_template( 'page-templates/front-page.php' ) ) : ?>
			<?php the_post_thumbnail(); ?>
			<?php endif; ?>
			<h1 class="entry-title"><?php the_title(); ?></h1>
		</header>

		<div class="entry-content">
			<?php the_content(); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'twentytwelve' ), 'after' => '</div>' ) ); ?>
		
		<?php
			$args = array(
				'post_type' => 'organization', 
				'posts_per_page' => -1,
				'orderby' => 'title',
				'order' => 'ASC',
				);
			$my_query = new WP_Query($args);
			?>
			<table id="org-list" class="table table-hover">
			<thead>
				<tr>
					<th>Nombre</th>
					<th>URL</th>
					<!--<th>Alcance</th>-->
					<th>Tipo</th>
					<!--<th>Ciudad</th>-->
					<th>Regi&oacute;n</th>
					<th>Twitter</th>
					<th>Twitter Followers</th>
					<th>Ecosistema</th>
				</tr>
			</thead>
				<tbody>
			<?php if ( $my_query->have_posts() ) : while ( $my_query->have_posts() ) :  $my_query->the_post(); ?>
			<?php 	 //necessary to show the tags 
				global $wp_query;
				$wp_query->in_the_loop = true;
				$post_id = $post->ID;
				$prefix = '_ig_';
		
				$main_url = get_post_meta( $post_id, $prefix.'main_url', true );
				$origin_date = get_post_meta( $post_id, $prefix.'origin_date', true );
				$end_date = get_post_meta( $post_id, $prefix.'end_date', true );
				$other_urls = get_post_meta( $post_id, $prefix.'other_url', true );
				$other_themes = get_post_meta( $post_id, $prefix.'other_themes', true );
				$other_demands = get_post_meta( $post_id, $prefix.'other_demands', true );
				$facebook_site = get_post_meta( $post_id, $prefix.'facebook_site', true );
				$youtube_account = get_post_meta( $post_id, $prefix.'youtube_account', true );
				$twitter_account = get_post_meta( $post_id, $prefix.'twitter_account', true );
				$twitter_origin = get_post_meta( $post_id, $prefix.'twitter_origin', true );
				$other_twitter_accounts = get_post_meta( $post_id, $prefix.'other_twitter_accounts', true );
				$url_info = get_post_meta( $post_id, $prefix.'url_info', true );
				$twitter_info = get_post_meta( $post_id, $prefix.'twitter_info', true );
				$data_date = get_post_meta( $post_id, $prefix . 'data_date', true );
				?>

					<tr <?php post_class(''); ?> id="post-<?php the_ID(); ?>">
						<td> <a href="<?php the_permalink() ?>" rel="bookmark" title="Go to <?php the_title_attribute(); ?> page">
							<strong><?php the_title(); ?></strong></a> 
							<?php if ( is_user_logged_in() ) { ?><?php edit_post_link(__('Edit')); ?><?php } ?>
						</td>
						<td>
							<?php
								$remove_this = array("http://","https://","www.");
								$mainurl_stripped = str_replace($remove_this, "", $main_url);
								echo "<a href='".$main_url."'>".$mainurl_stripped."</a>"; ?>
						</td>
						<!--<td>
							<?php echo get_the_term_list( $post_id, 'org-scope', ' ', ', ', '' ); ?>
						</td>-->
						<td>
							<?php echo get_the_term_list( $post_id, 'org-type', ' ', ', ', '' ); ?>
						</td>
						<!--<td>
							<?php echo get_the_term_list( $post_id, 'org-city', ' ', ', ', '' ); ?>
						</td>-->
						<td>
							<?php echo get_the_term_list( $post_id, 'org-region', ' ', ', ', '' ); ?>
						</td>
						<td>
							<?php echo !($twitter_account=='') ? "<a href='https://twitter.com/".$twitter_account. "'>@".$twitter_account."</a>" : '' ; ?>
						</td>
						<td>
							<?php echo (!empty($twitter_info)) ? $twitter_info[0]['followers'] : ""; ?>
						</td>
						<td>
							<?php echo get_the_term_list( $post_id, 'org-ecosystem', ' ', ', ', '' ); ?>
						</td>
					</tr>
				</div>
			<?php endwhile; else: ?>
			<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
			<?php endif; ?>
				</tbody>
			</table>
		</div><!-- .entry-content -->
		
		<footer class="entry-meta">
			<?php // edit_post_link( __( 'Edit', 'twentytwelve' ), '<span class="edit-link">', '</span>' ); ?>
		</footer><!-- .entry-meta -->
	</article><!-- #post -->
