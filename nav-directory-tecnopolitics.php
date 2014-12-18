<nav class="navbar navbar-default" role="navigation">
	<div class="container-fluid">
	  <!-- Brand and toggle get grouped for better mobile display -->
	  <div class="navbar-header">
	    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
	      <span class="sr-only">Toggle navigation</span>
	      <span class="icon-bar"></span>
	      <span class="icon-bar"></span>
	      <span class="icon-bar"></span>
	    </button>
	  </div>
 <?php //Bootstrapized directory menu
wp_nav_menu(
	array(
		'menu'              => 'directory-tecnopol',
		'depth'             => 2,
		'container'         => 'div',
		'container_class'   => 'collapse navbar-collapse',
		'container_id'      => 'bs-example-navbar-collapse-1',
		'menu_class'        => 'nav navbar-nav',
		'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
		'walker'            => new wp_bootstrap_navwalker()
	)
);
?>
	</div>
</nav>
