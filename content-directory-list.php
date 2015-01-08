<?php
/**
 * The template used for displaying page directory in page.php
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
			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'twentytwelve' ), 'after' => '</div>' ) ); ?>
		
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
			?>
			<table id="org-list" class="table table-hover">
			<thead>
				<tr>
					<th>Nombre</th>
					<th>URL</th>
					<th>Tipo</th>
					<th>Redes sociales</th>
					<th>Google <abbr title="Page Rank">PR</abbr></th>
					<th>Alexa <abbr title="Page Rank">PR</abbr></th>
					<th>Alexa inlinks</th>
					<th>Twitter Followers</th>
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
				
				$last_url_item = end($url_info);
				$twitter_info = get_post_meta( $post_id, $prefix.'twitter_info', true );
				$alexa_page_rank = $last_url_item['alexa_page_rank'];
				$google_page_rank = $last_url_item['google_page_rank'];
				$alexa_inlinks = $last_url_item['alexa_inlinks'];
				
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
								$max_length = 25;
								if ( strlen($mainurl_stripped) > $max_length ) {
									$mainurl_stripped = substr($mainurl_stripped,0,$max_length).'...';
								}
								echo "<a href='".$main_url."'>".$mainurl_stripped."</a>"; ?>
						</td>
						<td>
							<?php echo get_the_term_list( $post_id, 'org-type', ' ', ', ', '' ); ?>
						</td>
						<td>
							<?php
							echo !($twitter_account=='') ? "<a href='https://twitter.com/".$twitter_account. "'>Twitter</a>, " : "" ;
							echo !($facebook_site=='') ? "<a href='https://facebook.com/".$facebook_site. "'>Facebook</a>, " : "";
							echo !($youtube_account=='') ? "<a href='https://youtube.com/".$youtube_account."'>Youtube</a>" : "";
							?>
						</td>
						<td>
							<div class="progress">
								<div class="progress-bar" role="progressbar" aria-valuenow="2" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo 100*$google_page_rank/9; ?>%;">
									<?php echo $google_page_rank; ?>
								</div>
							</div>							
						</td>
						<td>
							<!--<div class="progress"> TODO how to represent graphicaly alexa page rank
								<div class="progress-bar" role="progressbar" aria-valuenow="2" aria-valuemin="0" aria-valuemax="100" style="width:
								<?php echo 100-(100*$alexa_page_rank/5000000); ?>%;">
									<?php echo $alexa_page_rank; ?>
								</div>
							</div>-->
							<?php //echo 100-(100*$alexa_page_rank/5000000); ?>
							<?php echo $alexa_page_rank; ?>
						</td>
						<td>
							<div class="progress">
								<div class="progress-bar" role="progressbar" aria-valuenow="2" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo 100*$alexa_inlinks/1600; ?>%;">
									<?php echo $alexa_inlinks; ?>
								</div>
							</div>
							<?php echo $alexa_inlinks; ?>
						</td>
						<td>
							<?php echo (!empty($twitter_info)) ? $twitter_info[0]['followers'] : ""; ?>
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
