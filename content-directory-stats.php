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
	
	//Get all the years of creation of the organizations
	foreach ($posts_ids as $key => $value) {
		$years_created[$key] = date( 'Y', get_post_meta( $value , $prefix.'origin_date', true ) );
	}
	$years_total = array_count_values($years_created); //counts values of organizations created every year
	ksort($years_total); //orders array by key
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
			<h3>Fecha de inicio</h3>
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
	<footer class="entry-meta">
	</footer><!-- .entry-meta -->
</article><!-- #post -->
