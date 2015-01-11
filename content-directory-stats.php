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
foreach ($terms as $term) { //TODO separate by $active_exosystem. Now it is counting both ecosystem at the same time
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
		if (get_post_meta( $value , $prefix . 'origin_date', true ) != '') {
			$years_created[$key] = date( 'Y', get_post_meta( $value , $prefix . 'origin_date', true ) ); //Get all the years of creation of the organizations
		}
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
		<h3>Inex</h3>
		<p>
			<a href="#tipos-org">Tipos de organizaci&oacute;n</a><br>
			<a href="#fecha-inicio">Fecha inicio</a><br>
			<a href="#google-page-rank">Google Page Rank</a><br>
			<a href="#alexa-page-rank">Alexa Page Rank</a><br>
			<a href="#alexa-inlinks">Alexa inlinks</a><br>
			<a href="#twitter-followers">Twitter Followers</a><br>
			<a href="#facebook-likes">Facebook Likes</a><br>
		</p>
		<div id="tipos-org" class="col-md-12">
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
		<div id="fecha-inicio" class="col-md-3">
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
		<div id="google-page-rank" class="col-md-4">
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
							<span title="<?php echo $value; ?> organizaciones con Google Page Rank">
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
		<div id="alexa-page-rank" class="col-md-5">
			<h3 id="alexahistogram">Alexa Page Rank de la web principal <small>nº de organizaciones en cada rango (histograma)</small></h3>
			<?php
			//Flattens value of the array.
			foreach($alexa_page_rank_total as $key => $value) {
				$flattenedAlexa[] = $value;
			}
			
			//Sets up of max value and size of ranges
			$maxValue = 30000000;
			$splitValue = 2500000;
			$widths = range(0, $maxValue, $splitValue);
			
			//construct range-keys array
			$bins = array();
			foreach($widths as $key => $val)
			{
				if (!isset($widths[$key + 1])) break;
				$bins[] = $val.'-'. ($widths[$key + 1]);
			}
			
			//construct flotHistogram count array (values are converted to keys)
			$flotHistogram = array_fill_keys($bins, 0);
			//construct array of values for each key
			$histogram = array();
			foreach($flattenedAlexa as $price)
			{
				//if value doesn't exist, value is estored in the max key
				$key = $price ? floor(($price)/$splitValue) : floor(($maxValue-1)/$splitValue);
				if (!isset($histogram[$key])) $histogram[$key] = array();
				$histogram[$key][] = $price;
			}
			
			//counts the values for every range
			foreach($histogram as $key => $value) {
				$rangeValuesAlexaPR[$key] = count($value);
			}
			//reorders array by key value
			ksort($rangeValuesAlexaPR);
			?>
			<div class="row">
				<div class="col-md-5 text-right">
				<?php
					foreach ($flotHistogram as $key => $value) {
						echo '<p>'.$key.'</p>';
					}
				?>
				</div>
				<div class="col-md-7">
				<?php
					$maxAlexaPR = 0;
					foreach ($rangeValuesAlexaPR as $key => $value) {
						$maxAlexaPR = max( array( $maxAlexaPR, $value) ); //calculates max value
					}
					foreach ($rangeValuesAlexaPR as $key => $value) {
						?>
					<div class="progress">
						<div class="progress-bar" style="width:<?php echo 100*$value/$maxAlexaPR; ?>%;background-color:#999;color:black">
							<span title="<?php echo $value; ?>">
								<?php echo $value; ?>
							</span>
						</div>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<h3>Alexa Page Rank de la web principal <small></small></h3>
			<div class="row">
				<div class="col-md-12 just-bars">
					<?php
					$max = 0;
					foreach ($alexa_page_rank_total as $key => $value) {
						$max = max( array( $max, $value) ); //calculates max value
					}
					foreach ($alexa_page_rank_total as $key => $value) {
						if ($value == 0) {
							//Do nothing
						} else {
						?>
					<div class="progress">
						<div class="progress-bar" style="width:<?php echo 100*$value/$max; ?>%;background-color:#999;color:black">
							<span title="<?php echo $value; ?> Alexa Page Rank">
								<?php echo $value; ?>
							</span>
						</div>
					</div>
					<?php
						}
					}
					?>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div id="alexa-inlinks" class="col-md-4">
			<h3>Alexa Inlinks de la web principal <small>nº de organizaciones en cada rango (histograma)</small></h3>
			<?php
			//Flattens value of the array.
			foreach($alexa_inlinks_total as $key => $value) {
				$flattenedAlexaInlinks[] = $value;
			}
			
			//Sets up of max value and size of ranges
			$maxAlexaInlinks = 1600; //can not start with o, otherwise it deosn't work
			foreach ($alexa_inlinks_total as $key => $value) {
				$maxAlexaInlinks = max( array( $maxAlexaInlinks , $value) ); //calculates max value
			}
			$maxValue = 1600;
			$splitValue = 200;
			$widths = range(0, $maxValue, $splitValue);
			
			//construct range-keys array
			$bins = array();
			foreach($widths as $key => $val) {
				if (!isset($widths[$key + 1])) break;
				$bins[] = $val.'-'. ($widths[$key + 1]);
			}
			
			//construct flotHistogram count array (values are converted to keys)
			$flotHistogramInlinks = array_fill_keys($bins, 0);
			$flotHistogramInlinks = array_reverse($flotHistogramInlinks,true); //reverse array to display high values at the top
			
			//construct array of values for each key
			$histogram = array();
			foreach($flattenedAlexaInlinks as $price) {
				//if value doesn't exist, value is estored in the max key
				$key = floor($price/$splitValue);
				if (!isset($histogram[$key])) $histogram[$key] = array();
				$histogram[$key][] = $price;
			}
			
			//counts the values for every range
			foreach($histogram as $key => $value) {
				$rangeValuesAlexaInlinks[$key] = count($value);
			}
			//reorders array by key value
			ksort($rangeValuesAlexaInlinks);
			?>
			<div class="row">
				<div class="col-md-5 text-right">
				<?php
					foreach ($flotHistogramInlinks as $key => $value) {
						echo '<p>'.$key.'</p>';
					}
				?>
				</div>
				<div class="col-md-7">
				<?php
					$maxAlexaInlinks = 0;
					foreach ($rangeValuesAlexaInlinks as $key => $value) {
						$maxAlexaInlinks = max( array( $maxAlexaInlinks, $value) ); //calculates max value
					}
					
					for	($i = 7; $i >= 0; $i--) { //iterates to all the keys, even if there is no value in them to match the ranges to the left
						?>
					<div class="progress">
						<div class="progress-bar" style="width:<?php echo 100*$rangeValuesAlexaInlinks[$i]/$maxAlexaInlinks; ?>%;background-color:#999;color:black">
							<span title="<?php echo $rangeValuesAlexaInlinks[$i]; ?>">
								<?php echo $rangeValuesAlexaInlinks[$i]; ?>
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
				<div class="col-md-12 just-bars">
					<?php
					$maxAlexaInlinks = 0; //can not start with o, otherwise it deosn't work
					foreach ($alexa_inlinks_total as $key => $value) {
						$maxAlexaInlinks = max( array( $maxAlexaInlinks , $value) ); //calculates max value
					}
					foreach ($alexa_inlinks_total as $key => $value) {
						if ($value == -1) {
							//Do nothing
						} else {
						?>
					<div class="progress">
						<div class="progress-bar" style="width:<?php echo 100*$value/$maxAlexaInlinks ; ?>%;background-color:#999;color:black" title="<?php echo $value; ?> Alexa Inlinks">
							<span title="<?php echo $value; ?>">
								<?php echo $value; ?>
							</span>
						</div>
					</div>
					<?php
						}
					}
					?>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div id="twitter-followers" class="col-md-4">
			<h3>Twitter Followers <small></small></h3>
			<div class="row">
				<div class="col-md-12 just-bars">
					<?php
					$max=0;
					foreach ($twitter_followers as $key => $value) {
						$max = max( array( $max, $value) ); //calculates max value
					}
					foreach ($twitter_followers as $key => $value) {
						?>
					<div class="progress">
						<div class="progress-bar" style="width:<?php echo 100*$value/$max; ?>%;background-color:#999;color:black" title="<?php echo $value; ?> Twitter Followers">
							<span title="<?php echo $value; ?> Twitter Followers">
								<?php echo $value; ?>
							</span>
						</div>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
		<div id="facebook-likes" class="col-md-4">
			<h3>Facebook likes <small></small></h3>
			<div class="row">
				<div class="col-md-12 just-bars">
					<?php
					$max=0;
					foreach ($facebook_likes as $key => $value) {
						$max = max( array( $max, $value) ); //calculates max value
					}
					foreach ($facebook_likes as $key => $value) {
						?>
					<div class="progress">
						<div class="progress-bar" style="width:<?php echo 100*$value/$max; ?>%;background-color:#999;color:black" title="<?php echo $value; ?> Facebook Likes">
							<span title="<?php echo $value; ?> Facebook Likes">
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
