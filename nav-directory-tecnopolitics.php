<!--<nav class="navbar navbar-default" role="navigation">
	<div class="container-fluid">-->
	  <!-- Brand and toggle get grouped for better mobile display -->
	  <!--<div class="navbar-header">
	    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
	      <span class="sr-only">Toggle navigation</span>
	      <span class="icon-bar"></span>
	      <span class="icon-bar"></span>
	      <span class="icon-bar"></span>
	    </button>
	  </div>-->
 <?php //Bootstrapized directory menu TODO make this menu work!
/*wp_nav_menu(
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
);*/
?>
<!--	</div>
</nav>-->
<ul class="nav nav-tabs" role="tablist">
	<li role="presentation"><a href="/es/ecologias-tecnopoliticas/"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Sobre el directorio</a></li>
	<li role="presentation" class="dropdown">
	<a class="dropdown-toggle" data-toggle="dropdown" href="" role="button" aria-expanded="false">
	  Ecolog&iacute;a 15M <span class="caret"></span>
	</a>
	<ul class="dropdown-menu" role="menu">
		<li role="presentation"><a href="/es/listado/?ecosystem=15m">
			<span class="glyphicon glyphicon-list" aria-hidden="true"></span> Listado</a>
		</li>
		<li role="presentation"><a href="/es/ecologias-tecnopoliticas/mosaico-15m/"><span class="glyphicon glyphicon glyphicon-th" aria-hidden="true"></span> Mosaico</a></li>
		<li role="presentation"><a href="/es/ecologias-tecnopoliticas/estadisticas-15m/"><span class="glyphicon glyphicon-stats" aria-hidden="true"></span> Estad&iacute;sticas</a></li>
	</ul>
	</li>
	<li role="presentation" class="dropdown">
	<a class="dropdown-toggle" data-toggle="dropdown" href="" role="button" aria-expanded="false">
	  Ecolog&iacute;a Independentista-soberanista catalana <span class="caret"></span>
	</a>
	<ul class="dropdown-menu" role="menu">
		<li role="presentation"><a href="/es/listado/?ecosystem=independencia-cataluna">
			<span class="glyphicon glyphicon-list" aria-hidden="true"></span> Listado</a>
		</li>
		<li role="presentation"><a href="/es/ecologias-tecnopoliticas/mosaico-cat/"><span class="glyphicon glyphicon glyphicon-th" aria-hidden="true"></span> Mosaico</a>
		<li role="presentation"><a href="/es/ecologias-tecnopoliticas/estadisticas-cat/"><span class="glyphicon glyphicon-stats" aria-hidden="true"></span> Estad&iacute;sticas</a></li>
	</ul>
	<li role="presentation"><a href="/es/ecologias-tecnopoliticas/anadir-organizacion/">A&ntilde;adir organizaci&oacute;n</a></li>
</ul>
