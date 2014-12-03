<?php
/**
 * The template for displaying content in the single.php template
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
$post_id = $post->ID;
$prefix = '_ig_';
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>

		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			<?php twentyeleven_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
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
		
		echo "<dt>Main Web</dt><dd>".get_post_meta( $post_id, $prefix.'main_url', true ). "</dd>";
		echo "<dt>Fecha de inicio</dt><dd>" .date( 'm/Y', $origin_date ). "</dd>";
		echo "<dt>Fecha de fin</dt><dd>" .date( 'm/Y', $end_date ). "</dd>";
		echo "<dt>Activa</dt><dd>".get_post_meta( $post_id, $prefix.'active', true ). "</dd>";
		echo "<dt>Descripci&oacute;n</dt><dd>".get_post_meta( $post_id, $prefix.'description', true ). "</dd>";
		echo "<dt>Notas</dt><dd>".get_post_meta( $post_id, $prefix.'notes', true ). "</dd>";
		echo "<dt>Otras webs</dt><dd>";
	 	foreach ($other_urls as $key => $value) {
	 		echo "<a href='".$value['url']."'>".$value['url']."</a><br/>";
	 	}
		echo "</dd>";
		
		echo "<h2>Temas principales</h2>";
		echo "<dt>Tema principal 1</dt><dd>".get_post_meta( $post_id, $prefix.'theme_1', true ). "</dd>";
		echo "<dt>Tema principal 2</dt><dd>".get_post_meta( $post_id, $prefix.'theme_2', true ). "</dd>";
		echo "<dt>Tema principal 3</dt><dd>".get_post_meta( $post_id, $prefix.'theme_3', true ). "</dd>";
		echo "<dt>Otros temas</dt><dd>";
		foreach ($other_themes as $key => $value) {
	 		echo $value['theme']."<br/>";
	 	}
		echo "</dd>";
		
		echo "<h2>Demandas principales</h2>";
		echo "<dt>Demanda principal 1</dt><dd>".get_post_meta( $post_id, $prefix.'demand_1', true ). "</dd>";
		echo "<dt>Demanda principal 2</dt><dd>".get_post_meta( $post_id, $prefix.'demand_2', true ). "</dd>";
		echo "<dt>Demanda principal 3</dt><dd>".get_post_meta( $post_id, $prefix.'demand_3', true ). "</dd>";
		echo "<dt>Otras demandas</dt><dd>";
		foreach ($other_demands as $key => $value) {
	 		echo $value['demand']."<br/>";
	 	}
		echo "</dd>";
		
		echo "<h2>Redes sociales en internet</h2>";
		echo "<dt>Facebook site</dt><dd><a href='https://facebook.com/".$facebook_site. "'>".$facebook_site."</a></dd>";
		echo "<dt>Facebook likes</dt><dd>".get_post_meta( $post_id, $prefix.'facebook_likes', true ). "</dd>";
		echo "<dt>Youtube</dt><dd><a href='".$youtube_account."'>".$youtube_account."</a></dd>";
		echo "<dt>Twitter (cuenta principal)</dt><dd><a href='https://twitter.com/".$twitter_account. "'>@".$twitter_account."</a> comenz&oacute; en ".date( 'd/m/Y', $twitter_origin )."</dd>";
		echo "<dt>Otras cuentas de Twitter</dt><dd>";
		foreach ($other_twitter_accounts as $key => $value) {
	 		echo "<a href='https://twitter.com/".$value['user']. "'>@".$value['user']."</a> comenz&oacute; en ".date( 'd/m/Y', $value['twitter_origin'] )."<br/>";
	 	}
		echo "</dd>";
		echo "<dt>Site technologies</dt><dd>".get_post_meta( $post_id, $prefix.'site_technologies', true ). "</dd>";
		
		echo "<h2>Informaci&oacute;n sobre sitios web</h2>";
		echo "<dt>Otras webs</dt><dd>";
	 	foreach ($url_info as $key => $value) {
	 		echo "<a href='".$value['url']."'>".$value['url']."</a>; 
	 		Google Page Rank: ".$value['google_page_rank']."; 
	 		Alexa Page Rank: ".$value['alexa_page_rank']."; 
	 		Alexa Inlinks: ".$value['alexa_inlinks']."; 
	 		Date: ".date( 'd/m/Y',$value['url_data_date'])."<br/>";
	 	}
		?>
		
		<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'twentyeleven' ) . '</span>', 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->

	<footer class="entry-meta">
		<?php
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( __( ', ', 'twentyeleven' ) );

			/* translators: used between list items, there is a space after the comma */
			$tag_list = get_the_tag_list( '', __( ', ', 'twentyeleven' ) );
			if ( '' != $tag_list ) {
				$utility_text = __( 'This entry was posted in %1$s and tagged %2$s by <a href="%6$s">%5$s</a>. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'twentyeleven' );
			} elseif ( '' != $categories_list ) {
				$utility_text = __( 'This entry was posted in %1$s by <a href="%6$s">%5$s</a>. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'twentyeleven' );
			} else {
				$utility_text = __( 'This entry was posted by <a href="%6$s">%5$s</a>. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'twentyeleven' );
			}

			printf(
				$utility_text,
				$categories_list,
				$tag_list,
				esc_url( get_permalink() ),
				the_title_attribute( 'echo=0' ),
				get_the_author(),
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) )
			);
		?>
		<?php edit_post_link( __( 'Edit', 'twentyeleven' ), '<span class="edit-link">', '</span>' ); ?>

		<?php if ( get_the_author_meta( 'description' ) && ( ! function_exists( 'is_multi_author' ) || is_multi_author() ) ) : // If a user has filled out their description and this is a multi-author blog, show a bio on their entries ?>
		<div id="author-info">
			<div id="author-avatar">
				<?php
				/** This filter is documented in author.php */
				echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'twentyeleven_author_bio_avatar_size', 68 ) );
				?>
			</div><!-- #author-avatar -->
			<div id="author-description">
				<h2><?php printf( __( 'About %s', 'twentyeleven' ), get_the_author() ); ?></h2>
				<?php the_author_meta( 'description' ); ?>
				<div id="author-link">
					<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
						<?php printf( __( 'View all posts by %s <span class="meta-nav">&rarr;</span>', 'twentyeleven' ), get_the_author() ); ?>
					</a>
				</div><!-- #author-link	-->
			</div><!-- #author-description -->
		</div><!-- #author-info -->
		<?php endif; ?>
	</footer><!-- .entry-meta -->
</article><!-- #post-<?php the_ID(); ?> -->