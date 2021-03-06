<?php
// The template used for displaying stats of directory in page.php
$prefix = '_ig_';
$active_ecosytem = get_post_meta( $post->ID, $prefix . 'active_ecosystem' , true );
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
	$posts_array = get_posts( $args );
	
	//Get all the post ids
	foreach ($posts_array as $key => $post) {
		$posts_ids[$key] = $post->ID;
	}
	
	foreach ($posts_ids as $key => $value) {
		$organization_type[$key] = wp_get_post_terms($value , 'org-type', array("fields" => "names"));
		if (get_post_meta( $value , $prefix . 'origin_date', true ) != '') {
			$years_created[$key] = date( 'Y', get_post_meta( $value , $prefix . 'origin_date', true ) ); //Get all the years of creation of the organizations
		}
	}
	
	foreach ($organization_type as $key => $value) {//Flattens array
		$organization_type_clean[$key] = !empty($value[0]) ? $value[0] : "Falta por rellenar"; //prevents from crashing when value is empty
	}
	$organization_type_total = array_count_values($organization_type_clean); //counts values of organizations whit the same organization type
	
	$years_total = array_count_values($years_created); //counts values of organizations created every year
	ksort($years_total); //orders array by key
	
	//Website info
	foreach ($posts_array as $key => $value) {
		$url_info = get_post_meta( $value->ID, $prefix.'url_info', true );
		$last_url_item = end($url_info); //last item of the arrar TODO It should be the last item that has as url $main_url
		$google_page_rank_total[$value->post_title] = isset($last_url_item['google_page_rank']) ? $last_url_item['google_page_rank'] : '';
		$alexa_page_rank_total[$value->post_title] = isset($last_url_item['alexa_page_rank']) ? $last_url_item['alexa_page_rank']	: '' ;
		$alexa_inlinks_total[$value->post_title] = $last_url_item['alexa_inlinks'];
		$twitter_info[$value->post_title] = get_post_meta( $value->ID , $prefix . 'twitter_info', true );
		$facebook_info[$value->post_title] = get_post_meta( $value->ID , $prefix . 'facebook_info', true );
	}

	$google_page_rank_count = array_count_values($google_page_rank_total); //counts values of gogle page rank
	asort($alexa_page_rank_total); //orders array by value
	ksort($google_page_rank_count); //orders array by key
	arsort($alexa_inlinks_total); //orders array by value
	
	//Twiter info
	foreach ($twitter_info as $key => $value) {
		$twitter_followers[$key] = isset($value[0]['followers']) ? $value[0]['followers'] : ''; //TODO for last value of the main Twitter account. Now it just takes the first value.
	}
	arsort($twitter_followers);
	
	//Facebook info
	foreach ($facebook_info as $key => $value) {
		$facebook_likes[$key] = isset($value[0]['likes']) ? $value[0]['likes'] : ''; //TODO for last value of the main site. Now it just takes the first value.
	}
	arsort($facebook_likes);
	
	?>
	<div class="row">
		<h3>Index</h3>
		<p>
			<a href="#tipos-org">Tipos de organizaci&oacute;n</a><br>
			<a href="#fecha-inicio">Fecha inicio</a><br>
			<a href="#google-page-rank">Google Page Rank</a><br>
			<a href="#alexa-page-rank">Alexa Page Rank</a><br>
			<a href="#alexa-inlinks">Alexa inlinks</a><br>
			<a href="#twitter-followers">Twitter Followers</a><br>
			<a href="#facebook-likes">Facebook Likes</a><br>
			<a href="#nubes">Redes sociales por nubes de palabras</a><br>
		</p>
		<div id="tipos-org" class="col-md-12">
			<h3>Tipos de organizaci&oacute;n <small>nº de organizaciones</small></h3>
			<div class="row">
				<div class="col-md-5 col-sm-9 col-xs-9 text-right">
					<?php
					foreach ($organization_type_total as $key => $value) {
						echo '<p>'.$key.': </p>';
					}
					$max_count_org_type = 0;
					foreach ($organization_type_total as $value) {
						$max_count_org_type = $value > $max_count_org_type ? $value : $max_count_org_type;
					}
					?>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-3">
					<?php
					foreach ($organization_type_total as $key => $value) {
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
		<div id="fecha-inicio" class="col-md-4">
			<h3>Fecha de inicio <small>nº de organizaciones por a&ntilde;o</small></h3>
			<div class="row years">
				<?php
					$max=0;
					foreach ($years_total as $year => $value) {
						$max = max( array( $max, $value) ); //calculates max value
					}
					foreach ($years_total as $year => $value) {
						echo '<div class="row"><div class="col-md-2 col-sm-2 col-xs-2 text-right">';
						echo '<p>'. $year .'</p>';
						echo '</div>';
						echo '<div class="col-md-7 col-sm-4 col-xs-4">
									<div class="progress">
						 			<div class="progress-bar" style="width:'. 100*$value/$max. '%;background-color:#999;color:black">
									<span title="'. $value .'organizations formed">';
						echo $value;
						echo '</span></div></div>';
						//for ($i = 1; $i <= $value; $i++ ) {
						//	echo '|';
						//}
						echo '</div></div>	';
					}
				?>
			</div>
		</div>
		<div id="google-page-rank" class="col-md-4">
			<h3>Google Page Rank de la web principal (1-10) <small>nº de organizaciones con cada valor (histograma)</small></h3>
			<div class="row">
				<?php
				$max = 0;
				foreach ($google_page_rank_count as $key => $value) {
					$max = max( array( $max, $value) ); //calculates max value
				}
				foreach ($google_page_rank_count as $key => $value) {
					echo '<div class="row"><div class="col-md-4 col-sm-2 col-xs-2 text-right">';
						if ($key == '0') {
						$key = '0';
					} elseif ($key == '') {
						$key = '-';
					} else {
						$key = $key;
					}
					echo '<p>'.$key.'</p>';
					echo '</div>';
					echo '<div class="col-md-8 col-sm-8 col-xs-8">
									<div class="progress">
					 					<div class="progress-bar" style="width:'. 100*$value/$max. '%;background-color:#999;color:black">
											<span title="'. $value .'organizaciones con Google Page Rank">'. $value .'
											</span>
										</div>
									</div>
								</div>
							</div>';
				}
				?>
				<div class="row">
					<div class="col-md-4 col-sm-2 col-xs-2 text-right">
						<div class="text-right">
							<small><?php	echo stats_values( $google_page_rank_total );	?></small>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div id="alexa-page-rank" class="col-md-4">
			<h3 id="alexahistogram">Alexa Page Rank de la web principal <br><small>nº de organizaciones en cada rango (histograma)</small></h3>
			<?php
			//Flattens value of the array.
			foreach($alexa_page_rank_total as $key => $value) {
				$flattenedAlexa[] = $value;
			}
			
			//Sets up of max value and size of ranges
			$maxValue = 28000000;
			$splitValue = 2000000;
			$widths = range(0, $maxValue, $splitValue);
			
			//construct range-keys array
			$bins = array();
			foreach($widths as $key => $val)
			{
				if (!isset($widths[$key + 1])) break;
				$bins[] = number_format($val, 0, ',', '.').'-'. number_format(($widths[$key + 1]), 0, ',', '.');
			}
			
			//construct flotHistogram count array (values are converted to keys)
			$flotHistogram = array_fill_keys($bins, 0);
			//construct array of values for each key
			$histogram = array();
			foreach($flattenedAlexa as $price) {
				//if value doesn't exist, value is estored in the max key
				$key = $price ? floor(($price)/$splitValue) : floor(($maxValue-1)/$splitValue); //if value is 0 puts the value with the maximun value (lowest imporatance)
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
				<div class="col-md-5 col-sm-5 col-xs-5 text-right">
				<?php
					foreach ($flotHistogram as $key => $value) {
						echo '<p>'.$key.'</p>';
					}
				?>
					<div class="text-right">
						<small><?php	echo stats_values( $flattenedAlexa );	?></small>
					</div>
				</div>
				<div class="col-md-7 col-sm-6 col-xs-6">
				<?php
					$maxAlexaPR = 0;
					foreach ($rangeValuesAlexaPR as $key => $value) {
						$maxAlexaPR = max( array( $maxAlexaPR, $value) ); //calculates max value
					}
					for	($i = 0; $i <= 14; $i++) {
						?>
					<div class="progress">
						<div class="progress-bar" style="width:<?php echo 100*$rangeValuesAlexaPR[$i]/$maxAlexaPR; ?>%;background-color:#999;color:black">
							<span title="<?php echo $value; ?>">
								<?php echo $rangeValuesAlexaPR[$i]; ?>
							</span>
						</div>
					</div>
					<?php } ?>
					<small>Valores de Alexa Page Rank inexistentes o por encima de 26.000.000 se incluyen en el &uacute;ltimo rango.</small>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<h3>Alexa Page Rank web principal <small>Escala lineal</small></h3>
			<div class="row">
				<div class="col-md-12 just-bars">
					<?php
					$maxAlexaPR = 0;
					foreach ($alexa_page_rank_total as $key => $value) {
						$maxAlexaPR = max( array( $maxAlexaPR, $value) ); //calculates max value
					}
					$alexa_page_rank_total = array_filter($alexa_page_rank_total); //removes organizations with no value for alexa page rank
					foreach ($alexa_page_rank_total as $key => $value) {
						?>
					<div class="progress">
						<div class="progress-bar" style="width:<?php echo 100*$value/$maxAlexaPR; ?>%;background-color:#999;color:black" title="<?php echo number_format($value, 0, ',', '.'); echo ' Alexa Page Rank ('. $key .')'; ?>">
							<span title="<?php echo number_format($value, 0, ',', '.'); ?> Alexa Page Rank">
								<?php echo $value; ?>
							</span>
						</div>
					</div>
					<?php
					}
					?>
					<div class="row">
						<div class="col-md-6">
							<div class="text-left"><small>0</small></div>
						</div>
						<div class="col-md-6">
							<div class="text-right"><small><?php echo number_format($maxAlexaPR, 0, ',', '.'); ?></small></div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<h3>Alexa Page Rank web principal <small>Escala logar&iacute;tmica</small></h3>
			<div class="row">
				<div class="col-md-12 just-bars">
					<?php
					foreach ($alexa_page_rank_total as $key => $value) {
						?>
					<div class="progress">
						<div class="progress-bar" style="width:<?php echo log($value,1.5)*2; ?>%;background-color:#ccc;color:black" title="<?php echo number_format($value, 0, ',', '.'); echo ' Alexa Page Rank ('. $key .')'; ?>">
							<span title="<?php echo number_format($value, 0, ',', '.'); ?> Alexa Page Rank">
								<?php echo $value; ?>
							</span>
						</div>
					</div>
					<?php
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
			$maxAlexaInlinks = 0;
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
				$bins[] = number_format($val, 0, ',', '.').'-'. number_format(($widths[$key + 1]), 0, ',', '.');
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
				<div class="col-md-5 col-sm-5 col-xs-5 text-right">
				<?php
					foreach ($flotHistogramInlinks as $key => $value) {
						echo '<p>'.$key.'</p>';
					}
				?>
					<div class="text-right">
						<small><?php	echo stats_values( $flattenedAlexaInlinks ); ?></small>
					</div>
				</div>
				<div class="col-md-7 col-sm-6 col-xs-6">
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
			<h3>Alexa Inlinks web principal <small>Escala lineal</small></h3>
			<div class="row">
				<div class="col-md-12 just-bars">
					<?php
					$maxAlexaInlinks = 0; //can not start with o, otherwise it deosn't work
					foreach ($alexa_inlinks_total as $key => $value) {
						$maxAlexaInlinks = max( array( $maxAlexaInlinks , $value) ); //calculates max value
					} ?>
					<div class="row">
						<div class="col-md-6">
							<div class="text-left"><small>0</small></div>
						</div>
						<div class="col-md-6">
							<div class="text-right"><small><?php echo number_format($maxAlexaInlinks, 0, ',', '.'); ?></small></div>
						</div>
					</div>
					<?php
					foreach ($alexa_inlinks_total as $key => $value) {
					?>
						<div class="progress">
							<div class="progress-bar" style="width:<?php echo 100*$value/$maxAlexaInlinks; ?>%;background-color:#999;color:black" title="<?php echo number_format($value, 0, ',', '.'); echo ' Alexa Inlinks (' .$key. ')'; ?>">
								<span title="<?php echo $alexa_inlinks; ?>">
									<?php echo $alexa_page_rank; ?>
								</span>
							</div>
						</div>
					<?php
					}
					?>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<h3>Alexa Inlinks web principal <small>Escala logar&iacute;tmica</small></h3>
			<div class="row">
				<div class="col-md-12 just-bars">
					<?php
					foreach ($alexa_inlinks_total as $key => $value) {
						$log_value = ($value == 1) ? log(2,1.6)/2 : log($value,1.6); //TODO clarify
						?>
					<div class="progress">
						<div class="progress-bar" style="width:<?php echo $log_value*4.3; ?>%;background-color:#ccc;color:black" title="<?php echo number_format($value, 0, ',', '.'); echo ' Alexa Inlinks (' .$key. ')'; ?>">
							<span title="<?php echo $value; ?>">
								<?php echo $value; ?>
							</span>
						</div>
					</div>
					<?php
					}
					?>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div id="twitter-followers" class="col-md-4">
			<h3>Twitter Followers <small>Escala lineal</small></h3>
			<div class="row">
				<div class="col-md-12 just-bars">
					<?php
					$max_twitter = 0;
					foreach ($twitter_followers as $key => $value) {
						$max_twitter = max( array( $max_twitter, $value) ); //calculates max value
					} ?>
					<div class="row">
						<div class="col-md-6">
							<div class="text-left"><small>0</small></div>
						</div>
						<div class="col-md-6">
							<div class="text-right"><small><?php echo number_format($max_twitter, 0, ',', '.'); ?></small></div>
						</div>
					</div>
					<?php
					foreach ($twitter_followers as $key => $value) {
						?>
					<div class="progress">
						<div class="progress-bar" style="width:<?php echo 100*$value/$max_twitter; ?>%;background-color:#999;color:black" title="<?php echo number_format($value, 0, ',', '.'); echo ' Twitter Followers (' .$key. ')'; ?>">
							<span title="<?php echo $value; ?> Twitter Followers">
								<?php echo $value; ?>
							</span>
						</div>
					</div>
					<?php } ?>
					<div class="text-right">
						<small><?php	echo stats_values( $twitter_followers );	?></small>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div id="facebook-likes" class="col-md-4">
			<h3>Facebook likes <small></small></h3>
			<div class="row">
				<div class="col-md-12 just-bars">
					<?php
					$max=0;
					foreach ($facebook_likes as $key => $value) {
						$max = max( array( $max, $value) ); //calculates max value
					} ?>
					<div class="row">
						<div class="col-md-6">
							<div class="text-left"><small>0</small></div>
						</div>
						<div class="col-md-6">
							<div class="text-right"><small><?php echo number_format($max_twitter, 0, ',', '.'); ?></small></div>
						</div>
					</div>
					<?php
					foreach ($facebook_likes as $key => $value) {
						?>
					<div class="progress">
						<div class="progress-bar" style="width:<?php echo 100*$value/$max; ?>%;background-color:#999;color:black" title="<?php echo number_format($value, 0, ',', '.'); echo ' Facebook Likes (' .$key. ')'; ?>">
							<span title="<?php echo $value; ?> Facebook Likes">
								<?php echo $value; ?>
							</span>
						</div>
					</div>
					<?php } ?>
					<div class="text-right">
						<small><?php	echo stats_values( $facebook_likes );	?></small>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="nubes" class="row">
	<hr style="border-width:20px; margin-top:40px;">
	<h3>Google Page Rank <small>Escala lineal</small></h3>
	<?php
	foreach ($posts_array as $value) {
		$url_info = get_post_meta( $value->ID, $prefix.'url_info', true );
		$last_url_item = end($url_info); //last item of the arrar TODO It should be the last item that has as url $main_url
		$google_page_rank = $last_url_item['google_page_rank'];
		echo "<a href='" .
		$value->guid. "' title='Google Page Rank ".	$google_page_rank ." (". $value->post_title.")'><span style='font-size:". $google_page_rank*3.5 ."px;'>". $value->post_title. " </span></a>";
	}
	?>
	<hr style="border-width:20px;margin-top:40px;">
	<h3>Alexa Page Rank <small>Escala logar&iacute;tmica</small></h3>
	<?php
	foreach ($posts_array as $value) {
		$url_info = get_post_meta( $value->ID, $prefix.'url_info', true );
		$last_url_item = end($url_info); //last item of the array TODO It should be the last item that has as url $main_url
		if (isset($last_url_item['alexa_page_rank'])) {
			$alexa_page_rank = $last_url_item['alexa_page_rank'] ;
		}
		//$alexa_page_rank = $alexa_page_rank < 60000 ? 60000 :  $alexa_page_rank;
		$alexa_page_rank_log = log( $alexa_page_rank, 1.1 );
		echo "<a href='" .$value->guid. "' title=\"Alexa Page Rank ";
		//echo $alexa_page_rank == 60000 ? "valor minorado, tamaño real" : number_format($alexa_page_rank, 0, ',', '.');
		echo number_format($alexa_page_rank, 0, ',', '.');
		echo " (".$value->post_title.")\"><span style='font-size:". ((3000/$alexa_page_rank_log)-13)*2 ."px;'>".$value->post_title. " </span></a> | ";
	}
	?>
	<hr style="border-width:20px;margin-top:40px;">
	<h3>Alexa Page Rank <small>Escala lineal</small></h3>
	<?php
	foreach ($posts_array as $value) {
		$url_info = get_post_meta( $value->ID, $prefix.'url_info', true );
		$last_url_item = end($url_info); //last item of the arrar TODO It should be the last item that has as url $main_url
		if (isset($last_url_item['alexa_page_rank'])) {
			$alexa_page_rank = ($last_url_item['alexa_page_rank'] == 0) || ($alexa_page_rank == '') ? 8000000 : $last_url_item['alexa_page_rank'] ;
		}
		$alexa_page_rank = $alexa_page_rank < 60000 ? 60000 :  $alexa_page_rank;
		echo "<a href='" .$value->guid. "' title=\"Alexa Page Rank ";
		echo $alexa_page_rank == 60000 ? "valor minorado, tamaño real" : number_format($alexa_page_rank, 0, ',', '.');
		echo " (".$value->post_title.")\"><span style='font-size:". 5000000/$alexa_page_rank ."px;'>".$value->post_title. " </span></a>";
	}
	?>
	<hr style="border-width:20px;margin-top:40px;">
	<h3>Alexa Inlinks Logar&iacute;tmico <small>Escala logar&iacute;tmica</small></h3>
	<?php
	echo "Valo m&iacute;nimo: 1<br>";
	echo "Valo m&aacute;ximo: ".$maxAlexaInlinks."<br>";
	
	foreach ($posts_array as $value) {
		$url_info = get_post_meta( $value->ID, $prefix.'url_info', true );
		$last_url_item = end($url_info); //last item of the arrar TODO It should be the last item that has as url $main_url
		$alexa_inlinks = $last_url_item['alexa_inlinks'];
		//$alexa_inlinks = $alexa_inlinks > 3000 ? 3000 : $alexa_inlinks;
		$alexa_inlinks_log = log( $alexa_inlinks, 1.6 );
		echo "<a href='" .$value->guid. "' title=\"Alexa Inlinks ". number_format($alexa_inlinks, 0, ',', '.') ." (".$value->post_title.")\"><span style='font-size:". $alexa_inlinks_log*1.75 ."px;'>".$value->post_title. " </span></a> | ";
	}
	?>
	<hr style="border-width:20px;margin-top:40px;">
	<h3>Alexa Inlinks <small>Escala lineal</small></h3>
	<?php
	foreach ($posts_array as $value) {
		$url_info = get_post_meta( $value->ID, $prefix.'url_info', true );
		$last_url_item = end($url_info); //last item of the arrar TODO It should be the last item that has as url $main_url
		$alexa_inlinks = $last_url_item['alexa_inlinks'];
		$alexa_inlinks = $alexa_inlinks > 3000 ? 3000 : $alexa_inlinks; //se reducen a mano los valores demasiado altos (deben suprimirse de base de datos)
		echo "<a href='" .$value->guid. "' title=\"Alexa Inlinks ";
		echo 3000 == $alexa_inlinks ? "valor minorado " : "";
		echo number_format($alexa_inlinks, 0, ',', '.') ." (".$value->post_title.")\"><span style='font-size:". $alexa_inlinks/23.3 ."px;'>".$value->post_title. " </span></a>";
	}
	?>
	<hr style="border-width:20px;margin-top:40px;">
	<h3>Twitter Followers <small>Escala logar&iacute;tmica</small></h3>
	<?php
	foreach ($posts_array as $value) {
		$twitter_info = get_post_meta( $value->ID, $prefix.'twitter_info', true );
		if (isset($twitter_info[0]['followers'])) {
			$twitter_followers = ($twitter_info[0]['followers'] == '') || ($twitter_info[0]['followers'] == 0) ? 1 : $twitter_info[0]['followers'];
		}
		$twitter_followers_log = log($twitter_followers,1.1);
		echo "<a href='" .$value->guid. "' title=\"Twitter Folowers ". number_format($twitter_followers, 0, ',', '.') ." (".$value->post_title.")\"><span style='font-size:". $twitter_followers_log/5 ."px;'>".$value->post_title. " </span></a> | ";
	}
	?>
	<hr style="border-width:20px;margin-top:40px;">
	<h3>Twitter Followers <small>Escala lineal</small></h3>
	<?php
	foreach ($posts_array as $value) {
		$twitter_info = get_post_meta( $value->ID, $prefix.'twitter_info', true );
		if (isset($twitter_info[0]['followers'])) {
			$twitter_followers = $twitter_info[0]['followers'] == '' ? 0 : $twitter_info[0]['followers'];
		}
		echo "<a href='" .$value->guid. "' title=\"Twitter Folowers ". number_format($twitter_followers, 0, ',', '.') ." (".$value->post_title.")\"><span style='font-size:". $twitter_followers/1790 ."px;'>".$value->post_title. " </span></a>";
	}
	?>
	<hr style="border-width:20px;margin-top:40px;">
	</div>
</article><!-- #post -->
