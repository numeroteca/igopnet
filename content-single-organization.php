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
$tit = get_the_title();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php echo $tit; ?></h1>

		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			<?php twentyeleven_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
		$main_url = get_post_meta( $post_id, $prefix.'main_url', true );
		$origin_date = get_post_meta( $post_id, $prefix.'origin_date', true );
		$end_date = get_post_meta( $post_id, $prefix.'end_date', true );
		$other_urls = get_post_meta( $post_id, $prefix.'other_url', true );
		$other_themes = get_post_meta( $post_id, $prefix.'other_themes', true );
		$other_demands = get_post_meta( $post_id, $prefix.'other_demands', true );
		$other_actions = get_post_meta( $post_id, $prefix.'other_actions', true );
		$facebook_site = get_post_meta( $post_id, $prefix.'facebook_site', true );
		$other_facebook_accounts = get_post_meta( $post_id, $prefix.'other_facebook_accounts', true );
		$youtube_account = get_post_meta( $post_id, $prefix.'youtube_account', true );
		$twitter_account = get_post_meta( $post_id, $prefix.'twitter_account', true );
		$twitter_origin = get_post_meta( $post_id, $prefix.'twitter_origin', true );
		$other_twitter_accounts = get_post_meta( $post_id, $prefix.'other_twitter_accounts', true );
		$url_info = get_post_meta( $post_id, $prefix.'url_info', true );
		$twitter_info = get_post_meta( $post_id, $prefix.'twitter_info', true );
		$facebook_info = get_post_meta( $post_id, $prefix.'facebook_info', true );
		$data_date = get_post_meta( $post_id, $prefix . 'data_date', true );
		
		echo "<h2>Informaci&oacute;n b&aacute;sica</h2>";
		echo "<dt>Nombre</dt><dd>".$tit. "</dd>";
		echo "<dt>Web principal</dt><dd><a href='".$main_url."'>".$main_url."</a></dd>";
		echo "<dt>Ecosistema</dt><dd>".get_the_term_list( $post_id, 'org-ecosystem', ' ', ', ', '' ). "</dd>";
		echo "<dt>Tipo</dt><dd>".get_the_term_list( $post_id, 'org-type', ' ', ', ', '' ). "</dd>";
		echo "<dt>Alcance</dt><dd>".get_the_term_list( $post_id, 'org-scope', ' ', ', ', '' ). "</dd>";
		echo "<dt>A qui&eacute;n</dt><dd>".get_the_term_list( $post_id, 'org-whom', ' ', ', ', '' ). "</dd>";
		echo "<dt>Ciudad</dt><dd>".get_the_term_list( $post_id, 'org-city', ' ', ', ', '' ). "</dd>";
		echo "<dt>Regi&oacute;n</dt><dd>".get_the_term_list( $post_id, 'org-region', ' ', ', ', '' ). "</dd>";
		echo !($origin_date=='') ? "<dt>Fecha de inicio</dt><dd>" .date( 'm/Y', $origin_date ). "</dd>" : "";
		echo !($end_date=='') ? "<dt>Fecha de fin</dt><dd>" .date( 'm/Y', $end_date ). "</dd>" : "";
		echo "<dt>Activa</dt><dd>".get_post_meta( $post_id, $prefix.'active', true ). "</dd>";
		//echo "<dt>Descripci&oacute;n</dt><dd>".get_post_meta( $post_id, $prefix.'description', true ). "</dd>";
		echo "<p><strong>Descripci&oacute;n</strong></p>";
		echo the_content();
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
		
		echo "<h2>Acciones de reinvindicaci&oacute;n m&aacute;s frefuentes</h2>";
		echo "<dt>Accici&oacute;n 1</dt><dd>".get_post_meta( $post_id, $prefix.'action_1', true ). "</dd>";
		echo "<dt>Accici&oacute;n 2</dt><dd>".get_post_meta( $post_id, $prefix.'action_2', true ). "</dd>";
		echo "<dt>Accici&oacute;n 3</dt><dd>".get_post_meta( $post_id, $prefix.'action_3', true ). "</dd>";
		echo "<dt>Otras accioness</dt><dd>";
		foreach ($other_actions as $key => $value) {
	 		echo $value['action']."<br/>";
	 	}
		echo "</dd>";
		
		echo "<h2>Redes sociales en internet</h2>";
		echo "<dt>Facebook site</dt><dd><a href='https://facebook.com/".$facebook_site. "'>".$facebook_site."</a></dd>";
		echo "<dt>Youtube</dt><dd><a href='".$youtube_account."'>".$youtube_account."</a></dd>";
		echo !($twitter_account=='') ? "<dt>Twitter (cuenta principal)</dt><dd><a href='https://twitter.com/".$twitter_account. "'>@".$twitter_account."</a>" : "";
		echo !($twitter_origin=='') ? " comenz&oacute; en ".date( 'd/m/Y', $twitter_origin )."</dd>" : "";
		echo "<dt>Otras cuentas de Facebook</dt><dd>";
		if ($other_facebook_accounts[0]['user'] !='') {
			if ($other_facebook_accounts[0]['user'] !='') {
				foreach ($other_facebook_accounts as $key => $value) {
			 		echo "<a href='https://facebook.com/".$value['user']. "'>".$value['user']."</a><br/>";
			 	}
			}
		}
		echo "</dd>";
		echo "<dt>Otras cuentas de Twitter</dt><dd>";
		if ($other_twitter_accounts[0]['user'] !='') {
			foreach ($other_twitter_accounts as $key => $value) {
		 		echo "<a href='https://twitter.com/".$value['user']. "'>@".$value['user']."</a>";
	 			if (isset($value['twitter_origin'])) {
					echo " comenz&oacute; en ".	date( 'd/m/Y', $value['twitter_origin']).".";
		 		}
		 		echo "<br/>";
		 	}
		}
		echo "</dd>";
		echo "<dt>Site technologies</dt><dd>".get_post_meta( $post_id, $prefix.'site_technologies', true ). "</dd>";
		
		echo "
		<h2>Informaci&oacute;n sobre sitios web</h2>
		<table>
			<thead>
				<tr>
					<th>Fecha</th>
					<th>URL</th>
					<th>Google Page Rank</th>
					<th>Alexa Page Rank</th>
					<th>Alexa Inlinks</th>
				</tr>
			</thead>
			<tbody>
				
			";
		foreach ($url_info as $key => $value) {
			$the_date = $value['date'];
			if (isset($the_date)) {
				echo "
					<tr>
						<td>".date( 'd/m/Y',$value['date'])."</td>
						<td><a href='".$value['url']."'>".$value['url']."</a></td>
						<td>".$value['google_page_rank']."</td>
						<td>".$value['alexa_page_rank']."</td>
						<td>".$value['alexa_inlinks']."</td>
					</tr>
				";
			}
		}
		echo "
			</tbody>
  	</table>"
  	;
  	
  	echo "<h2>Informaci&oacute;n sobre cuentas de Twitter</h2>
		<table>
			<thead>
				<tr>
					<th>Fecha</th>
					<th>Twitter</th>
					<th>Seguidores</th>
				</tr>
			</thead>
			<tbody>
				
			";
		foreach ($twitter_info as $key => $value) {
			echo "
				<tr>
					<td>".date( 'd/m/Y',$value['date'])."</td>
					<td><a href='https://twitter.com/".$value['user']. "'>@".$value['user']."</a></td>
					<td>".$value['followers']."</td>
				</tr>
			";
			}
		echo "
			</tbody>
  	</table>"
  	;
  	
  	echo "<h2>Informaci&oacute;n sobre Facebook</h2>
		<table >
			<thead>
				<tr>
					<th>Fecha</th>
					<th>Facebook</th>
					<th>Likes</th>
				</tr>
			</thead>
			<tbody>
				
			";
		foreach ($facebook_info as $key => $value) {
			echo "
				<tr>
					<td>".date( 'd/m/Y',$value['date'])."</td>
					<td><a href='https://facebook.com/".$value['user']. "'>".$value['user']."</a></td>
					<td>".$value['likes']."</td>
				</tr>
			";
			}
		echo "
			</tbody>
  	</table>"
  	;
  	
		echo "<h2>Fuente de informaci&oacute;n</h2>";
		echo "<dt>Codificador</dt><dd>".get_post_meta( $post_id, $prefix . 'coder', true ). "</dd>";
		echo !($data_date=='') ? "<dt>Fecha de inicio</dt><dd>" .date( 'm/Y', $data_date ). "</dd>" : "";
		echo "<dt>Fuente de los datos</dt><dd>".get_post_meta( $post_id, $prefix . 'info_source', true ). "</dd>";
		echo "<dt>Validaci&oacute;n</dt><dd>".get_post_meta( $post_id, $prefix . 'validation', true ). "</dd>";
		?>
		
		<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'twentyeleven' ) . '</span>', 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->

	<footer class="entry-meta">
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
