<?php
/*
Template Name: Insert data script
*/
get_header();
$prefix = '_ig_';
$prefix_org = 'org-';

function print_r2($val){
        echo '<pre>';
        print_r($val);
        echo  '</pre>';
}

		$csv_filename = "http://localhost/igopnet/wp-content/themes/igopnet-child/insert/data.insert.05"; // name (no extension)
		//$csv_filename = "/home/pangea/info_euromovements/public_html/igop/wp-content/themes/igopnet-child/insert/data.insert.02_r"; // name (no extension)
		$line_length = "4024"; // max line lengh (increase in case you have longer lines than 1024 characters)
		$delimiter = ";"; // field delimiter character
		$enclosure = '"'; // field enclosure character

		// open the data file
		$fp = fopen($csv_filename.".csv",'r');
	
		// get data and store it in array
		if ( $fp !== FALSE ) { // if the file exists and is readable
	
			// data array generation
			$data = array();
			$line = 0;
			while ( ($fp_csv = fgetcsv($fp,$line_length,$delimiter,$enclosure)) !== FALSE ) { // begin main loop
				if ( $line == 0 ) {}
				else {
					// vars to do the inserts
					$tit = $fp_csv[0]; //title
					$website = $fp_csv[1]; // cf
					$website_others = explode(", ", ($fp_csv[2])); // cf
					$ecosystem = $fp_csv[3];// tx
					$country = $fp_csv[4];// tx
					$region = $fp_csv[5]; // tx
					$city = $fp_csv[6]; // tx
					$type = $fp_csv[7]; // cf
					$theme_1 = $fp_csv[8]; // cf
					$theme_2 = $fp_csv[9]; // cf
					$theme_3 = $fp_csv[10]; // cf
					$theme_extra = $fp_csv[11]; // cf
					$demand_1 = $fp_csv[12]; // cf
					$demand_2 = $fp_csv[13]; // cf
					$demand_3 = $fp_csv[14]; // cf
					$demand_extra = $fp_csv[15]; // cf
					$scope = $fp_csv[16]; // tx
					$description = $fp_csv[17]; // content
					$action_1 = $fp_csv[18]; // cf
					$action_2 = $fp_csv[19]; // cf
					$action_3 = $fp_csv[20]; // cf
					$action_extra = $fp_csv[21]; // cf
					$whom = $fp_csv[22]; // tx
					$notes = $fp_csv[23]; // cf
					$facebook_main = $fp_csv[24]; // cf
					$facebook_others = explode(", ", $fp_csv[25]); //cf
					$facebook_likes = $fp_csv[26]; //cf
					$facebook_date = strtotime($fp_csv[27]); //cf
					$twitter_main = $fp_csv[28]; //cf
					$twitter_others = explode(", ", $fp_csv[29]); //cf
					$twitter_init_date = strtotime($fp_csv[30]); //cf
					$twitter_followers = $fp_csv[31]; // cf
					$twitter_date = strtotime($fp_csv[32]); //
					$youtube = $fp_csv[33]; // cf
					$youtube_others = explode(", ", $fp_csv[34]); // cf
					$google_page_rank = $fp_csv[35]; // cf
					$google_inlinks = $fp_csv[36]; // cf
					$alexa_page_rank = $fp_csv[37]; //cf
					$alexa_inlinks = $fp_csv[38]; //cf
					//$ = $fp_csv[38]; // cf
					$website_date = strtotime($fp_csv[40]); // cf
					$org_init_date = strtotime($fp_csv[41]); // cf
					$org_end_date = strtotime($fp_csv[42]); // cf
					$active = $fp_csv[43]; // cf
					$source = explode("; ", $fp_csv[44]); // cf
					$coder = $fp_csv[45]; // cf
					$register = $fp_csv[46]; // cf
					$data_date = strtotime($fp_csv[47]); // cf
					$update_date = strtotime($fp_csv[48]); //
					
					echo "other facebook users: ";
					print_r2($facebook_others); 
					foreach ($facebook_others as $key => $facebook_other) {
						$other_facebook_users[$key]['user'] = $facebook_other;
					}
					echo "other_facebook_users: ";
					print_r2($other_facebook_users);
					
					echo "other twitter users: ";
					print_r2($twitter_others); 
					foreach ($twitter_others as $key => $twitter_other) {
						$other_twitter_users[$key]['user'] = $twitter_other;
					}
					echo "other_twitter_users: ";
					print_r2($other_twitter_users);
					
					echo "other youtube users: ";
					print_r2($youtube_others);
					foreach ($youtube_others as $key => $youtube_other) {
						$other_youtube_users[$key]['user'] = $youtube_other;
					}
					echo "other_youtube_users: ";
					print_r2($other_twitter_users);
					
					echo "other website_others: ";
					print_r2($website_others); 
					foreach ($website_others as $key => $web) {
						$other_websites[$key]['url'] = $web;
					}
					echo "other websites: ";
					print_r2($other_websites);
					
					echo "sources: ";
					print_r2($source);
					foreach ($source as $key => $web) {
						$other_sources[$key]['info'] = $web;
					}
					echo "other websites: ";
					print_r2($other_sources);
					
					//simple custom fields
					$fields = array(
						$prefix . 'main_url' => $website,
						$prefix . 'other_url' => $other_websites,
						$prefix . 'theme_1' => $theme_1,
						$prefix . 'theme_2' => $theme_2,
						$prefix . 'theme_3' => $theme_3,
						$prefix . 'other_themes' => $theme_extra,
						$prefix . 'demand_1' => $demand_1,
						$prefix . 'demand_2' => $demand_2,
						$prefix . 'demand_3' => $demand_3,
						$prefix . 'other_demands' => $demand_extra,
						$prefix . 'action_1' => $action_1,
						$prefix . 'action_2' => $action_2,
						$prefix . 'action_3' => $action_3,
						$prefix . 'other_actions' => $action_extra,
						$prefix . 'notes' => $notes,
						$prefix . 'facebook_site' => $facebook_main,
						$prefix . 'other_facebook_accounts' => $other_facebook_users,
						$prefix . 'twitter_info' => array(
							array(
								'date' => $twitter_date,
								'user' => $twitter_main,
								'followers' => $twitter_followers,
								)
							),
						$prefix . 'facebook_info' => array(
							array(
								'date' => $facebook_date,
								'user' => $facebook_main,
								'likes' => $facebook_likes,
							)
						),
						$prefix . 'url_info' => array(
							array(
								'date' => $website_date,
								'url' => $website,
								'google_page_rank' => $google_page_rank,
								'alexa_page_rank' => $alexa_page_rank,
								'alexa_inlinks' => $alexa_inlinks,
							)
						),
						$prefix . 'twitter_account' => $twitter_main,
						$prefix . 'other_twitter_accounts' => $other_twitter_users,
						$prefix . 'twitter_origin' => $twitter_init_date,
						$prefix . 'youtube_account' => $youtube,
						$prefix . 'other_youtube_accounts' => $other_youtube_users,
						$prefix . 'origin_date' => $org_init_date,
						$prefix . 'end_date' => $org_end_date,
						$prefix . 'active' => $active,
						$prefix . 'coder' => $coder,
						$prefix . 'data_date' => $data_date,
						$prefix . 'info_source' => $source,
					);
					
					//Taxonomies
					$terms = array( //taxonomy => values
						$prefix_org . 'ecosystem' => $ecosystem,
						$prefix_org . 'type' => $type,
						$prefix_org . 'city' => $city,
						$prefix_org . 'region' => $region,
						$prefix_org . 'country' => $country,
						$prefix_org . 'scope' => $scope,
						$prefix_org . 'whom' => $whom,
					);
					
					print_r2($fields);
					print_r2($terms);

					// insert post
					$wpg = wp_insert_post(array(
						'post_type' => 'organization',
						'post_status' => 'publish',
						'post_author' => 1,
						'post_title' => $tit,
						'post_content' => $description,
					));
					
					// get organization id if already inserted
					$organization = get_page_by_title( $tit, OBJECT, 'organization' );
					$organization_id = $organization->ID;
					
					if ( $wpg != 0 ) {
						print_r2($fields);
						// insert custom fields
						reset($fields);
						// while ( $field = current($fields) ) {
						foreach ( $fields as $key => $value ) {
							if ($value != '') {
								add_post_meta($wpg, $key, $value, TRUE);
								echo "Added <strong>'" .$value. "'</strong> to key " .$key. "<br/>";
							}
						//	next($fields);
						}
						
						//insert multickech as array
						/*foreach ( $multicheck as $key => $value ) {
   							update_post_meta($wpg, $key, $value);
						}*/

						echo "
							<div>
								<h3>Organization " .$wpg. " is " .$tit. "</h3>
								<p>Organization Insert ok</p>
							</div>
						";
						
						// insert terms in taxonomies
						foreach ( $terms as $taxonomy => $values ) { //$values might be string or array
							echo "00. Starting.<br/>";
							print_r2($taxonomy);
							print_r2($values);
							if (is_string($values)) {
								if ( $value != '' ) {
									echo '01. Inserting value <strong>' .$values.'</strong><br/>';
									$term = term_exists( $values, $taxonomy ); // return the term ID or 0 if doesn't exist
									echo "The term_exists array: ";
									print_r2($term);
									$term_id = $term['term_id'];
									$term_taxonomy_id = $term['term_taxonomy_id'];
									echo "02. The term_id is <strong>" .$term_id. "</strong>; tax_id: ".$term_taxonomy_id.".  <br/>";
									if ( $term['term_id'] == 0 || $term['term_id'] == null ) { // if the term doesn't exist, then create it
										echo "03. Taxonomy term id didn't exist before<br/>";
										echo "value: " .$values. "; taxonomy: " .$taxonomy."<br/>";
										$new_term = wp_insert_term( $values, $taxonomy );
										//$term_id = $new_term['term_id'];
										//echo "4. Taxonomy term id inserted is " .$term_id."<br/>";
										echo "05. Taxonomy term inserted is " .$values."<br/>";
									}
								}
							} else {
								foreach ( $values as $value ) {
									if ( $value == '' ) {
										echo "1. Empty value.<br/>";
									}	else if ( $value != '' ) {
										echo '1. Inserting value <strong>' .$value.'</strong><br/>';
										$term = term_exists( $value, $taxonomy ); // return the term ID or 0 if doesn't exist
										echo "The term_exists array: ";
										print_r2($term);
										$term_id = $term['term_id'];
										$term_taxonomy_id = $term['term_taxonomy_id'];
										echo "2. The term_id is <strong>" .$term_id. "</strong>; tax_id: ".$term_taxonomy_id.".  <br/>";
										if ( $term['term_id'] == 0 || $term['term_id'] == null ) { // if the term doesn't exist, then create it
											echo "3. Taxonomy term id didn't exist before<br/>";
											echo "value: ". $value ."; taxonomy: " .$taxonomy."<br/>";
											$new_term = wp_insert_term( $value, $taxonomy );
											//$term_id = $new_term['term_id'];
											//echo "4. Taxonomy term id inserted is " .$term_id."<br/>";
											echo "5. Taxonomy term inserted is " .$value."<br/>";
										}
									}
								}
							}
	
							wp_set_object_terms( $organization_id, $values, $taxonomy );
	
							echo  "	<p>Final. Terms inserted ok: ID = " .$term_id. "; value:";
							print_r2($values);
							echo ".</p>";
							echo "<hr>";
	
							next($terms);
							unset($other_websites,$other_facebook_users,$other_twitter_users); //empties values
						}
						
					} // if project has been inserted

				} // end if not line 0
				$line++;
			}
			fclose($fp);

		} else {
			echo "<h2>Error</h2>
				<p>File with contents not found or not accesible.</p>
				<p>Check the path: " .$csv_filename. ". Maybe it has to be absolute...</p>";
		} // end if file exist and is readable

?>

<?php get_footer() ;?>
