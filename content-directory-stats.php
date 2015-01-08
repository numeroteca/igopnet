<?php
// The template used for displaying stats of directory in page.php
$prefix = '_ig_';
$active_ecosytem = get_post_meta( $post->ID, $prefix . 'active_ecosystem' , true );

$prefix = '_ig_';
$terms = get_terms( 'org-type', array(
	'orderby'    => 'count',
	'hide_empty' => 1,
	'order' => 'DESC'
	)
);
$max_count_org_type = 0;
foreach ($terms as $term) {
	$types[$term->name] = $term->count;
	$max_count_org_type = $term->count > $max_count_org_type ? $term->count : $max_count_org_type;
}
?>

<?php get_template_part( 'nav', 'directory-tecnopolitics' ); ?>
<article id="directory-stats" <?php post_class('container'); ?>>
	<header class="entry-header">
		<?php if ( ! is_page_template( 'page-templates/front-page.php' ) ) : ?>
		<?php the_post_thumbnail(); ?>
		<?php endif; ?>
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header>

	<div class="row">
		<div class="col-md-9 col-md-offset-3">
		<?php the_content(); ?>
		</div>
	</div>
	
	<?php
	//Iterate to all the available post of this ecosystem
	$args = array(
	'posts_per_page' => -1,
	'post_type' => 'organization',
	'tax_query' => array(
		array(
			'taxonomy' => 'org-ecosystem',
			'field'    => 'slug',
			'terms'    => $active_ecosytem,
			),
		),
	);
	$posts_array = get_posts( $args );
	
	//Get all the post ids
	foreach ($posts_array as $key => $post) {
		$posts_ids[$key] = $post->ID;
	}
	
	foreach ($posts_ids as $key => $value) {
		$years_created[$key] = date( 'Y', get_post_meta( $value , $prefix . 'origin_date', true ) ); //Get all the years of creation of the organizations
		$site_info[$key] = get_post_meta( $value , $prefix . 'url_info', true ); //Get all the web info of the organizations
		$twitter_info[$key] = get_post_meta( $value , $prefix . 'twitter_info', true );
		$facebook_info[$key] = get_post_meta( $value , $prefix . 'facebook_info', true );
	}
	$years_total = array_count_values($years_created); //counts values of organizations created every year
	ksort($years_total); //orders array by key
	
	//Website info
	foreach ($site_info as $key => $value) {
		$google_page_rank[$key] = $value[0]['google_page_rank']; //TODO for last value of the main site. Now it just takes the first value.
		$alexa_page_rank_total[$key] = $value[0]['alexa_page_rank']; //TODO for last value of the main site. Now it just takes the first value.
		$alexa_inlinks_total[$key] = $value[0]['alexa_inlinks']; //TODO for last value of the main site. Now it just takes the first value.
	}
	
	$google_page_rank_total = array_count_values($google_page_rank); //counts values of gogle page rank
	ksort($google_page_rank_total); //orders array by key
	
	asort($alexa_page_rank_total); //orders array by value
	asort($alexa_inlinks_total);
	rsort($alexa_inlinks_total);
	
	//Twiter info
	foreach ($twitter_info as $key => $value) {
		$twitter_followers[$key] = $value[0]['followers']; //TODO for last value of the main site. Now it just takes the first value.
	}
	
	asort($twitter_followers);
	rsort($twitter_followers);
	
	//Facebook info
	foreach ($facebook_info as $key => $value) {
		$facebook_likes[$key] = $value[0]['likes']; //TODO for last value of the main site. Now it just takes the first value.
	}
	
	asort($facebook_likes);
	rsort($facebook_likes);
	
	?>
	<div class="row">
		<div class="col-md-12">
			<h3>Tipos de organizaci&oacute;n <small>nº de organizaciones</small></h3>
			<div class="row">
				<div class="col-md-5 text-right">
					<?php
					foreach ($types as $key => $value) {
						echo '<p>'.$key.': </p>';
					}
					?>
				</div>
				<div class="col-md-3">
					<?php
					foreach ($types as $key => $value) {
						?>
					<div class="progress">
						<div class="progress-bar" style="width:<?php echo 100*$value/$max_count_org_type; ?>%;background-color:#999;color:black">
							<span title="<?php echo $value; ?>">
								<?php echo $value; ?>
							</span>
						</div>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-3">
			<h3>Fecha de inicio <small>nº de organizaciones</small></h3>
			<div class="row">
				<div class="col-md-4 text-right">
					<?php
					foreach ($years_total as $year => $value) {
						echo '<p>'.$year.'</p>';
					}
					?>
				</div>
				<div class="col-md-8">
					<?php
					$max=0;
					foreach ($years_total as $year => $value) {
						$max = max( array( $max, $value) ); //calculates max value
					}
					foreach ($years_total as $year => $value) {
						?>
					<div class="progress">
						<div class="progress-bar" style="width:<?php echo 100*$value/$max; ?>%;background-color:#999;color:black">
							<span title="<?php echo $value; ?> organizations formed">
								<?php echo $value; ?>
							</span>
						</div>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<h3>Google Page Rank de la web principal (1-10) <small>nº de organizaciones con cada valor (histograma)</small></h3>
			<div class="row">
				<div class="col-md-4 text-right">
					<?php
					foreach ($google_page_rank_total as $key => $value) {
						if ($key == '0') {
							$key = '0';
						} elseif ($key == '') {
							$key = '-';
						} else {
							$key = $key;
						}
						echo '<p>'.$key.'</p>';
					}
				?>
				</div>
				<div class="col-md-8">
					<?php
					$max=0;
					foreach ($google_page_rank_total as $key => $value) {
						$max = max( array( $max, $value) ); //calculates max value
					}
					foreach ($google_page_rank_total as $key => $value) {
						?>
					<div class="progress">
						<div class="progress-bar" style="width:<?php echo 100*$value/$max; ?>%;background-color:#999;color:black">
							<span title="<?php echo $value; ?> organizations formed">
								<?php echo $value; ?>
							</span>
						</div>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-5">
			<h3>Alexa Page Rank de la web principal <small></small></h3>
			<div class="row">
				<div class="col-md-1 text-right">
					<?php
					foreach ($alexa_page_rank_total as $key => $value) {
						echo '<p> </p>';
					}
				?>
				</div>
				<div class="col-md-8">
					<?php
					$max=0;
					foreach ($alexa_page_rank_total as $key => $value) {
						$max = max( array( $max, $value) ); //calculates max value
					}
					foreach ($alexa_page_rank_total as $key => $value) {
						?>
					<div class="progress">
						<div class="progress-bar" style="width:<?php echo 100*$value/$max; ?>%;background-color:#999;color:black">
							<span title="<?php echo $value; ?> organizations formed">
								<?php echo $value; ?>
							</span>
						</div>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<h3>Alexa Inlinks de la web principal <small></small></h3>
			<div class="row">
				<div class="col-md-1 text-right">
					<?php
					foreach ($alexa_inlinks_total as $key => $value) {
						echo '<p> </p>';
					}
				?>
				</div>
				<div class="col-md-8">
					<?php
					$max=0;
					foreach ($alexa_inlinks_total as $key => $value) {
						$max = max( array( $max, $value) ); //calculates max value
					}
					foreach ($alexa_inlinks_total as $key => $value) {
						?>
					<div class="progress">
						<div class="progress-bar" style="width:<?php echo 100*$value/$max; ?>%;background-color:#999;color:black">
							<span title="<?php echo $value; ?> organizations formed">
								<?php echo $value; ?>
							</span>
						</div>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-5">
			<h3>Twitter Followers <small></small></h3>
			<div class="row">
				<div class="col-md-1 text-right">
					<?php
					foreach ($twitter_followers as $key => $value) {
						echo '<p> </p>';
					}
				?>
				</div>
				<div class="col-md-8">
					<?php
					$max=0;
					foreach ($twitter_followers as $key => $value) {
						$max = max( array( $max, $value) ); //calculates max value
					}
					foreach ($twitter_followers as $key => $value) {
						?>
					<div class="progress">
						<div class="progress-bar" style="width:<?php echo 100*$value/$max; ?>%;background-color:#999;color:black">
							<span title="<?php echo $value; ?> organizations formed">
								<?php echo $value; ?>
							</span>
						</div>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
		<div class="col-md-5">
			<h3>Facebook likes <small></small></h3>
			<div class="row">
				<div class="col-md-1 text-right">
					<?php
					foreach ($facebook_likes as $key => $value) {
						echo '<p> </p>';
					}
				?>
				</div>
				<div class="col-md-8">
					<?php
					$max=0;
					foreach ($facebook_likes as $key => $value) {
						$max = max( array( $max, $value) ); //calculates max value
					}
					foreach ($facebook_likes as $key => $value) {
						?>
					<div class="progress">
						<div class="progress-bar" style="width:<?php echo 100*$value/$max; ?>%;background-color:#999;color:black">
							<span title="<?php echo $value; ?> organizations formed">
								<?php echo $value; ?>
							</span>
						</div>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
	<footer class="entry-meta">
	</footer><!-- .entry-meta -->
</article><!-- #post -->
