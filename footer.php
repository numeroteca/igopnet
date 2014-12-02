<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
?>

	</div><!-- #main -->

	<footer id="colophon" role="contentinfo">

			<?php
				/* A sidebar in the footer? Yep. You can can customize
				 * your footer with three columns of widgets.
				 */
				if ( ! is_404() )
					get_sidebar( 'footer' );
			?>

			<div id="site-generator"> <a href="http://creativecommons.org/licenses/by-nc-sa/3.0/es/">Creative Commons Attribution-NonCommercial-ShareAlike</a> |
				<?php do_action( 'twentyeleven_credits' ); ?>
				<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'twentyeleven' ) ); ?>" title="<?php esc_attr_e( 'Semantic Personal Publishing Platform', 'twentyeleven' ); ?>" rel="generator"><?php printf( __( 'Powered by %s', 'twentyeleven' ), 'WordPress' ); ?></a> | Credits: <a href="http://montera34.com">Montera34</a> | RSS: <a href="http://igopnet.cc/?feed=rss2">Entries</a> + <a href="http://igopnet.cc/?feed=comments-rss2">Comments</a> | Contact: igopnet(at)lists.contrast.org
			</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
