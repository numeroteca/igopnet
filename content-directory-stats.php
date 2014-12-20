<?php
// The template used for displaying stats of directory in page.php

//Type of asssociaion get_terms( 'category', 'orderby=count&hide_empty=0' );
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
	<div class="row">
		<div class="col-md-12">
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
				</div>
			</div>
	</div>	
	<footer class="entry-meta">
	</footer><!-- .entry-meta -->
</article><!-- #post -->
