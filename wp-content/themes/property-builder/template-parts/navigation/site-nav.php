<?php 
/*
* Display Theme menus
*/
?>

<div class="menubar">
	<div class="row m-0">
		<div class="col-lg-3 col-md-5 col-sm-5 align-self-center">
	        <div class="logo">
          		<?php if( has_custom_logo() ) construction_hub_the_custom_logo(); ?>
          		<?php if(get_theme_mod('construction_hub_site_title',true) != ''){ ?>
            		<h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
	          	<?php }?>
	          	<?php $construction_hub_description = get_bloginfo( 'description', 'display' );
	          		if ( $construction_hub_description || is_customize_preview() ) : ?>
		            <?php if(get_theme_mod('construction_hub_site_tagline',true) != ''){ ?>
	              		<p class="site-description"><?php echo esc_html($construction_hub_description); ?></p>
		            <?php }?>
	          	<?php endif; ?>
	        </div>
      	</div>
    	<div class="menubox col-lg-8 col-md-3 col-sm-3 col-6 align-self-center">
      		<div class="innermenubox">	      			
      			<?php if(has_nav_menu('primary-menu')){ ?>
		          	<div class="toggle-nav mobile-menu">
            			<button onclick="construction_hub_open_nav()" class="responsivetoggle"><i class="fas fa-bars"></i><span class="screen-reader-text"><?php esc_html_e('Open Button','property-builder'); ?></span></button>
          			</div>
          		<?php }?>
     	 		<div id="mySidenav" class="nav sidenav">
        			<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Top Menu', 'property-builder' ); ?>">
		              	<?php if(has_nav_menu('primary-menu')){
		                  	wp_nav_menu( array( 
			                    'theme_location' => 'primary-menu',
			                    'container_class' => 'main-menu clearfix' ,
			                    'menu_class' => 'clearfix',
			                    'items_wrap' => '<ul id="%1$s" class="%2$s mobile_nav">%3$s</ul>',
			                    'fallback_cb' => 'wp_page_menu',
		                  	) );
		              	} ?>
          				<a href="javascript:void(0)" class="closebtn mobile-menu" onclick="construction_hub_close_nav()"><i class="fas fa-times"></i><span class="screen-reader-text"><?php esc_html_e('Close Button','property-builder'); ?></span></a>
            		</nav>
          		</div>
      			<div class="clearfix"></div>
    		</div>
    	</div>
    	<div class="col-lg-1 col-md-4 col-sm-4 col-6 align-self-center">
    		<?php if(get_theme_mod('construction_hub_search_icon',true) != ''){ ?>
	    		<div class="search-box">
	    			<button class="search_btn"><i class="fas fa-search"></i></button>
		    	</div>
		    <?php }?>
      	</div>
    </div>
    <div class="search_outer">
      	<div class="search_inner">
        	<?php get_search_form(); ?>
        </div>
  	</div>
</div>