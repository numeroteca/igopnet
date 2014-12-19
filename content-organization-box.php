<?php
	$post_id = $post->ID;
	$prefix = '_ig_';
	$main_url = get_post_meta( $post_id, $prefix.'main_url', true );
	$remove_this = array("http://","https://","www.");
	$mainurl_stripped = str_replace($remove_this, "", $main_url);
	$facebook_site = get_post_meta( $post_id, $prefix.'facebook_site', true );
	$youtube_account = get_post_meta( $post_id, $prefix.'youtube_account', true );
	$twitter_account = get_post_meta( $post_id, $prefix.'twitter_account', true );
	$url_info = get_post_meta( $post_id, $prefix.'url_info', true );
	$last_url_item = end($url_info);
	$twitter_info = get_post_meta( $post_id, $prefix.'twitter_info', true );
	
	$google_page_rank = $last_url_item['google_page_rank'];
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('col-md-4'); ?>>
	<div class="panel panel-default">
		<div class="row panel-body">
			<div class="col-md-4">
				<div class="progress">
					<div class="progress-bar" role="progressbar" aria-valuenow="2" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo 100*$google_page_rank/9; ?>%;">
						<?php echo $google_page_rank; ?> GPR
					</div>
				</div>
				APR: <?php echo $last_url_item['alexa_page_rank']; ?> <br/>
				TF: <?php echo (!empty($twitter_info)) ? $twitter_info[0]['followers'] : ""; ?>
			</div>
			<div class="col-md-8">
				<h2>
					<a href="<?php the_permalink() ?>" rel="bookmark" title="Ir a <?php the_title_attribute(); ?>">
						<?php the_title(); ?>
					</a>
				</h2>
				<span class="glyphicon glyphicon-link" aria-hidden="true"></span>
				<?php echo "<a href='".$main_url."'>".$mainurl_stripped."</a><br/>"; ?>
				<?php echo get_the_term_list( $post_id, 'org-type', ' ', ', ', '' ); ?>
				<?php
				echo !($twitter_account=='') ? "<a href='https://twitter.com/".$twitter_account. "'>Twitter</a> " : "" ;
				echo !($facebook_site=='') ? "<a href='https://facebook.com/".$facebook_site. "'>Facebook</a> " : "";
				echo !($youtube_account=='') ? "<a href='".$youtube_account."'>Youtube</a>" : "";
				?>
			</div>
		</div>
	</div>
</article>
