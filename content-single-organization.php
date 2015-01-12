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
$other_youtube_accounts = get_post_meta( $post_id, $prefix.'other_youtube_accounts', true );
$twitter_account = get_post_meta( $post_id, $prefix.'twitter_account', true );
$twitter_origin = get_post_meta( $post_id, $prefix.'twitter_origin', true );
$other_twitter_accounts = get_post_meta( $post_id, $prefix.'other_twitter_accounts', true );
$site_technologies = get_post_meta( $post_id, $prefix.'site_technologies', true );
$url_info = get_post_meta( $post_id, $prefix.'url_info', true );
$twitter_info = get_post_meta( $post_id, $prefix.'twitter_info', true );
$facebook_info = get_post_meta( $post_id, $prefix.'facebook_info', true );
$data_date = get_post_meta( $post_id, $prefix . 'data_date', true );
$sources = get_post_meta( $post_id, $prefix.'info_source', true );
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
		<div class="col-md-4 col-md-push-8 side-bar"><!-- side column -->
			<?php
			echo "<dt>Web principal</dt><dd><a href='".$main_url."'>".$main_url."</a></dd>";
			if (isset($other_urls) && !empty($other_urls)) {
				if ($other_urls[0]['url'] != '') { //if first value is empty
					echo "<dt>Otras webs</dt><dd>";
					 	foreach ($other_urls as $key => $value) {
					 		echo "<a href='".$value['url']."'>".$value['url']."</a><br/>";
					 	}
					echo "</dd>";
				}
			}
			echo "<h2>Redes sociales en internet</h2>";
			echo "<dl>";
			echo !($twitter_account=='') ? "<dt><img src='".get_stylesheet_directory_uri()."/img/twitter_logo.png' alt='Twitter'> Twitter (cuenta principal)</dt><dd><a href='https://twitter.com/".$twitter_account. "'>@".$twitter_account."</a>" : "";
			echo !($twitter_origin=='') ? " comenz&oacute; en ".date( 'd/m/Y', $twitter_origin )."</dd>" : "";
			echo !($facebook_site=='') ? "<dt><img src='".get_stylesheet_directory_uri()."/img/facebook_logo.png' alt='Facebook'> Facebook</dt><dd><a href='https://facebook.com/".$facebook_site. "'>".$facebook_site."</a></dd>" : "";
			echo !($youtube_account=='') ? "<dt><img src='".get_stylesheet_directory_uri()."/img/youtube_logo.png' alt='YouTube'> Youtube</dt><dd><a href='https://youtube.com/".$youtube_account."'>".$youtube_account."</a></dd>" : "";
			echo "<hr>";
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
			if (isset($other_facebook_accounts) && !empty($other_facebook_accounts)) {
				if ($other_facebook_accounts[0]['user'] !='') {
					echo "<dt>Otras cuentas de Facebook</dt><dd>";
					foreach ($other_facebook_accounts as $key => $value) {
			 		echo "<a href='https://facebook.com/".$value['user']. "'>".$value['user']."</a><br/>";
					}
			 	}
			}
			echo "</dd>";
			if (isset($other_youtube_accounts) && !empty($other_youtube_accounts)) {
				if ($other_youtube_accounts[0]['user'] !='') {
					echo "<dt>Otras cuentas de Youtube</dt><dd>";
					foreach ($other_youtube_accounts as $key => $value) {
				 		echo "<a href='https://youtube.com/".$value['user']. "'>".$value['user']."</a><br/>";
				 	}
				}
			}
			echo "</dd>";
			echo  !($site_technologies=='') ? "<dt>Site technologies</dt><dd>".$site_technologies. "</dd>" : "";
			echo "</dl>";
			?>
		</div><!-- end side column -->
		<div class="col-md-7 col-md-pull-4">
			<div class="entry-content">
				<?php
				echo $content != '' ? "<dt><strong>Descripci&oacute;n</strong></dt>" : "";
				echo $content;
				//echo "<h2>Informaci&oacute;n b&aacute;sica</h2>";
				echo "<hr>";
				echo "<div class='row'><div class='col-md-3'>";
				echo "<dl>";
				echo list_taxonomy_terms($post_id,'org-city','Ciudad');
				echo list_taxonomy_terms($post_id,'org-region','Regi&oacute;n');
				echo "</dl>";
				echo "</div><div class='col-md-9'>";
				echo "<dl class='dl-horizontal'>";
				echo list_taxonomy_terms($post_id,'org-type','Tipo');
				echo list_taxonomy_terms($post_id,'org-scope','Alcance');
				echo list_of_items($post_id, $prefix.'active','Activa');
				echo "</dl>";
				echo "</div></div>";
				echo "<div class='row'><div class='col-md-3'>";
				echo "<dl>";
				echo !($origin_date=='') ? "<dt>Fecha de inicio</dt><dd>" .date( 'm/Y', $origin_date ). "</dd>" : "";
				echo !($end_date=='') ? "<dt>Fecha de fin</dt><dd>" .date( 'm/Y', $end_date ). "</dd>" : "";
				echo "</dl>";
				echo "</div><div class='col-md-6'>";
				echo "<dl>";
				echo list_taxonomy_terms($post_id,'org-whom','A qui&eacute;n se dirigen');
				echo "</dl>";
				echo "</div></div>";
				echo "<hr>";
				
				echo "<h2>Temas principales</h2>";
				echo "<dl class='dl-horizontal'>";
				echo list_of_items($post_id, $prefix.'theme_1','Tema principal 1');
				echo list_of_items($post_id, $prefix.'theme_2','Tema principal 2');
				echo list_of_items($post_id, $prefix.'theme_3','Tema principal 3');
				echo list_of_items($post_id, $prefix.'other_themes','Otros temas');
				
				echo "<h2>Demandas principales</h2>";
				echo "<dl class='dl-horizontal'>";
				echo list_of_items($post_id, $prefix.'demand_1','Demanda principal 1');
				echo list_of_items($post_id, $prefix.'demand_2','Demanda principal 2');
				echo list_of_items($post_id, $prefix.'demand_3','Demanda principal 3');
				echo list_of_items($post_id, $prefix.'other_demands','Otras demandas');
				
				echo "<h2>Acciones de reinvindicaci&oacute;n m&aacute;s frefuentes</h2>";
				echo "<dl class='dl-horizontal'>";
				echo list_of_items($post_id, $prefix.'action_1','Acci&oacute;n 1');
				echo list_of_items($post_id, $prefix.'action_2','Acci&oacute;n 2');
				echo list_of_items($post_id, $prefix.'action_3','Acci&oacute;n 3');
				echo list_of_items($post_id, $prefix.'other_actions','Otras acciones');
		
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
								<td>".number_format($value['alexa_page_rank'], 0, ',', '.')."</td>
								<td>".number_format($value['alexa_inlinks'], 0, ',', '.')."</td>
							</tr>
						";
					}
				}
				echo "
					</tbody>
				</table>"
				;
				echo "<dl><dt>Tecnolog&iacuteas usadas<br>en web principal</dt><dd>". $url_info[0]['site_technologies']."</dd></dl>";
				
				if (!empty($twitter_info[0]['user'])) {
					echo "<h2>Informaci&oacute;n sobre cuentas de Twitter</h2>
					<table class='table table-hover'>
						<thead>
							<tr>
								<th>Fecha</th>
								<th>Twitter</th>
								<th>Seguidores</th>
								<th>Le siguen</th>
								<th>Favoritos</th>
								<th>nº Tuits</th>
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
									<td>".number_format($value['followers'], 0, ',', '.')."</td>
									<td>".number_format($value['following'], 0, ',', '.')."</td>
									<td>".number_format($value['favorites'], 0, ',', '.')."</td>
									<td>".number_format($value['tweets'], 0, ',', '.')."</td>
								</tr>
							";
						}
					}
					echo "
						</tbody>
					</table>"
					;
				}
				
				if (!empty($facebook_info[0]['date'])) {
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
						if (isset($value['date'])) {
							echo "
								<tr>
									<td>".date( 'd/m/Y',$value['date'])."</td>
									<td><a href='https://facebook.com/".$value['user']. "'>".$value['user']."</a></td>
									<td>".$value['likes']."</td>
								</tr>
							";
							}
						}
					echo "
						</tbody>
					</table>"
					;
				}
			
				echo "<h2>Fuente de informaci&oacute;n</h2>";
				echo "<dl>";
				echo list_of_items($post_id, $prefix.'notes','Notas');
				echo list_of_items($post_id, $prefix.'coder','Codificador');
				echo !($data_date=='') ? "<dt>Fecha introducci&oacute;n<br>datos</dt><dd>" .date( 'd/m/Y', $data_date ). "</dd>" : "";
				if (isset($sources) && !empty($sources)) {
					if ($sources[0]['info'] !='') {
						echo "<dt>Fuente de los datos</dt><dd>";
						foreach ($sources as $key => $value) {
					 		echo $value['info']."<br/>";
					 	}
					}
				}
				echo "</dd>";
				echo list_of_items($post_id, $prefix.'validation','Validaci&oacute;n');
				echo "</dl>";
				?>
		
				<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'twentyeleven' ) . '</span>', 'after' => '</div>' ) ); ?>
			</div><!-- .entry-content -->
			
			<footer class="entry-meta">
				<?php edit_post_link( __( 'Edit', 'twentyeleven' ), '<span class="edit-link">', '</span>' ); ?>
			</footer><!-- .entry-meta -->
		</div>
	</div>
				
			<hr>
</article><!-- #post-<?php the_ID(); ?> -->
