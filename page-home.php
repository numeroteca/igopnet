<?php  /* Template Name: Home */ ?>
<?php get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post();?>
<?php endwhile; endif;?>
	<div id="primary" role="main">
		<div id="content">
			<?php global $more;    // Declare global $more (before the loop). "para que seguir leyendo funcione"
			$args = array( //arguments for showing newsletters custom post type
			'caller_get_posts' => 1, 
			'posts_per_page' => 5, 
			//'orderby' =>  'title'
			);

			if ( $paged > 1 ) {
			 $args['paged'] = $paged;
				}

			$my_query = new WP_Query($args);
		
			if ( $my_query->have_posts() ) :  while ( $my_query->have_posts() ) :  $my_query->the_post();  
				//necessary to show the tags 
				global $wp_query;
				$wp_query->in_the_loop = true;
		
				$more = 0;       // Set (inside the loop) to display content above the more "seguir leyendo" tag. ?>
				<?php 	get_template_part( 'content', get_post_format() );?>
		
	
			<?php endwhile; else: ?>
			<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
			<?php endif; ?>
			
		</div>
	</div><!-- #content -->
	<div id="secondary" class="widget-area" role="complementary">
		<a href="http://igopnet.cc/wp-content/uploads/2012/12/diptic-igopnet.pdf" alt="Download IGOPnet brochure"><img title="Download IGOPnet brochure" src="http://igopnet.cc/wp-content/uploads/2012/12/brochure-1-219x300.png" alt="Download IGOPnet brochure" width="219" height="300" /></a>
		<strong>IGOPnet</strong> is the area of Internet, Politics and Commons of the Institute of government and public policies (IGOP) of the Autonomous University of Barcelona (UAB).
	<a href="https://twitter.com/igopbcn" class="twitter-follow-button" data-show-count="false">Follow @igopbcn</a>
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
	</div>
</div>
			


		

<?php get_sidebar(); ?>
<?php get_footer(); ?>
