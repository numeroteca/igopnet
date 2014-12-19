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
$content = get_the_content();
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
$site_technologies = get_post_meta( $post_id, $prefix.'site_technologies', true );
$url_info = get_post_meta( $post_id, $prefix.'url_info', true );
$twitter_info = get_post_meta( $post_id, $prefix.'twitter_info', true );
$facebook_info = get_post_meta( $post_id, $prefix.'facebook_info', true );
$data_date = get_post_meta( $post_id, $prefix . 'data_date', true );
?>
<?php get_template_part( 'nav', 'directory-tecnopolitics' ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class('organization-single'); ?>>
	<header class="entry-header">
		<div class="row">
			<div class="col-md-10">
				<?php
				echo "<h1>" .$tit. " <small><a href='".$main_url."'><span class='glyphicon glyphicon-link' aria-hidden='true'></span></a></small></h1>";
				?>
			</div>
			<div class="col-md-2">
				<?php echo "<dt>Ecosistema</dt><dd>". get_the_term_list( $post_id, 'org-ecosystem', ' ', ', ', '' ). "</dd>"; ?>
			</div>
		</div>
	</header><!-- .entry-header -->
	<hr>
	<div class="row">
		<div class="col-md-3"><!-- side column -->
			<?php
			echo "<dt>Web principal</dt><dd><a href='".$main_url."'>".$main_url."</a></dd>";
			if (isset($other_urls) && !empty($other_urls)) {
				echo "<dt>Otras webs</dt><dd>";
				 	foreach ($other_urls as $key => $value) {
				 		echo "<a href='".$value['url']."'>".$value['url']."</a><br/>";
				 	}
				echo "</dd>";
			}
			echo "<h2>Redes sociales en internet</h2>";
			echo "<dl>";
			echo !($facebook_site=='') ? "<dt>Facebook site</dt><dd><a href='https://facebook.com/".$facebook_site. "'>".$facebook_site."</a></dd>" : "";
			echo !($youtube_account=='') ? "<dt>Youtube</dt><dd><a href='".$youtube_account."'>".$youtube_account."</a></dd>" : "";
			echo !($twitter_account=='') ? "<dt>Twitter (cuenta principal)</dt><dd><a href='https://twitter.com/".$twitter_account. "'>@".$twitter_account."</a></dd>" : "";
			echo !($twitter_origin=='') ? " comenz&oacute; en ".date( 'd/m/Y', $twitter_origin )."</dd>" : "";
			if (isset($other_facebook_accounts) && !empty($other_facebook_accounts)) {
				if ($other_facebook_accounts[0]['user'] !='') {
					echo "<dt>Otras cuentas de Facebook</dt><dd>";
					foreach ($other_facebook_accounts as $key => $value) {
			 		echo "<a href='https://facebook.com/".$value['user']. "'>".$value['user']."</a><br/>";
					}
			 	}
			}
			echo "</dd>";
			if (isset($other_twitter_accounts) && !empty($other_twitter_accounts)) {
				if ($other_twitter_accounts[0]['user'] !='') {
					echo "<dt>Otras cuentas de Twitter</dt><dd>";
					foreach ($other_twitter_accounts as $key => $value) {
				 		echo "<a href='https://twitter.com/".$value['user']. "'>@".$value['user']."</a>";
			 			if (isset($value['twitter_origin'])) {
							echo " comenz&oacute; en ".	date( 'd/m/Y', $value['twitter_origin']).".";
				 		}
				 		echo "<br/>";
				 	}
				}
			}
			echo "</dd>";
			echo  !($site_technologies=='') ? "<dt>Site technologies</dt><dd>".$site_technologies. "</dd>" : "";
			echo "</dl>";
			?>
		</div><!-- end side column -->
		<div class="col-md-7">
			<div class="entry-content">
				<?php
				echo $content != '' ? "<dt><strong>Descripci&oacute;n</strong></dt>" : "";
				echo $content;
				//echo "<h2>Informaci&oacute;n b&aacute;sica</h2>";
				echo "<hr>";
				echo "<div class='row'><div class='col-md-2'>";
				echo "<dl>";
				echo list_taxonomy_terms($post_id,'org-city','Ciudad');
				echo list_taxonomy_terms($post_id,'org-region','Regi&oacute;n');
				echo "</dl>";
				echo "</div><div class='col-md-10'>";
				echo "<dl class='dl-horizontal'>";
				echo list_taxonomy_terms($post_id,'org-type','Tipo');
				echo list_taxonomy_terms($post_id,'org-scope','Alcance');
				echo list_of_items($post_id, $prefix.'active','Activa');
				echo "</dl>";
				echo "</div></div>";
				echo "<div class='row'><div class='col-md-4'>";
				echo "<dl>";
				echo !($origin_date=='') ? "<dt>Fecha de inicio</dt><dd>" .date( 'm/Y', $origin_date ). "</dd>" : "";
				echo !($end_date=='') ? "<dt>Fecha de fin</dt><dd>" .date( 'm/Y', $end_date ). "</dd>" : "";
				echo "</dl>";
				echo "</div><div class='col-md-6'>";
				echo "<dl>";
				echo list_taxonomy_terms($post_id,'org-whom','A qui&eacute;n');
				echo "</dl>";
				echo "</div></div>";
				
				echo "<h2>Temas principales</h2>";
				echo "<dl>";
				echo list_of_items($post_id, $prefix.'theme_1','Tema principal 1');
				echo list_of_items($post_id, $prefix.'theme_2','Tema principal 2');
				echo list_of_items($post_id, $prefix.'theme_3','Tema principal 3');
				if (isset($other_themes[0]['theme'])) {
					if ($other_themes[0]['theme'] != '') {
						echo "<dt>Otros temas</dt><dd>";
						foreach ($other_themes as $key => $value) {
					 		echo $value['theme']."<br/>";
					 	}
						echo "</dd>";
					}
				}
				echo "</dl>";
				
				echo "<h2>Demandas principales</h2>";
				echo "<dl>";
				echo list_of_items($post_id, $prefix.'demand_1','Demanda principal 1');
				echo list_of_items($post_id, $prefix.'demand_2','Demanda principal 2');
				echo list_of_items($post_id, $prefix.'demand_3','Demanda principal 3');
				if (isset($other_demands[0]['demand'] )) {
					if ($other_demands[0]['demand'] != '') {
						echo "<dt>Otras demandas</dt><dd>";
						foreach ($other_demands as $key => $value) {
					 		echo $value['demand']."<br/>";
					 	}
						echo "</dd>";
					}
				}
				echo "</dl>";
				
				echo "<h2>Acciones de reinvindicaci&oacute;n m&aacute;s frefuentes</h2>";
				echo "<dl>";
				echo list_of_items($post_id, $prefix.'action_1','Accici&oacute;n 1');
				echo list_of_items($post_id, $prefix.'action_2','Accici&oacute;n 2');
				echo list_of_items($post_id, $prefix.'action_3','Accici&oacute;n 3');
				if (isset($other_actions[0]['action'])) {
					if ($other_actions[0]['action'] != '') {
						echo "<dt>Otras acciones</dt><dd>";
						foreach ($other_actions as $key => $value) {
					 		echo $value['action']."<br/>";
					 	}
						echo "</dd>";
					}
				}
				echo "</dl>";	
		
				
		
				echo "
				<h2>Informaci&oacute;n sobre sitios web</h2>
				<table class='table table-hover'>
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
					if (isset($value['date'])) {
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
				<table class='table table-hover'>
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
					if (isset($value['date'])) {
						echo "
							<tr>
								<td>".date( 'd/m/Y',$value['date'])."</td>
								<td><a href='https://twitter.com/".$value['user']. "'>@".$value['user']."</a></td>
								<td>".$value['followers']."</td>
							</tr>
						";
					}
				}
				echo "
					</tbody>
				</table>"
				;
			
				echo "<h2>Informaci&oacute;n sobre Facebook</h2>
				<table class='table table-hover'>
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
				echo "<dl>";
				echo list_of_items($post_id, $prefix.'notes','Notas');
				echo list_of_items($post_id, $prefix.'coder','Codificador');
				echo !($data_date=='') ? "<dt>Fecha de inicio</dt><dd>" .date( 'm/Y', $data_date ). "</dd>" : "";
				echo list_of_items($post_id, $prefix.'info_source','Fuente de los datos');
				echo list_of_items($post_id, $prefix.'validation','Validaci&oacute;n');
				echo "</dl>";
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
		</div>
	</div>
				
			<hr>
</article><!-- #post-<?php the_ID(); ?> -->
