<?php 
/*
* Display Theme menus
*/
?>

<div class="container">
  	<div class="menubar">
  		<div class="row m-0">
	    	<div class="menubox col-lg-11 col-md-10 col-6 align-self-center">
	      		<div class="innermenubox">	      			
	      			<?php if(has_nav_menu('primary-menu')){ ?>
			          	<div class="toggle-nav mobile-menu">
	            			<button onclick="construction_hub_open_nav()" class="responsivetoggle"><i class="fas fa-bars"></i><span class="screen-reader-text"><?php esc_html_e('Open Button','construction-hub'); ?></span></button>
	          			</div>
	          		<?php }?>
         	 		<div id="mySidenav" class="nav sidenav">
            			<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Top Menu', 'construction-hub' ); ?>">
			              	<?php if(has_nav_menu('primary-menu')){
			                  	wp_nav_menu( array( 
				                    'theme_location' => 'primary-menu',
				                    'container_class' => 'main-menu clearfix' ,
				                    'menu_class' => 'clearfix',
				                    'items_wrap' => '<ul id="%1$s" class="%2$s mobile_nav">%3$s</ul>',
				                    'fallback_cb' => 'wp_page_menu',
			                  	) );
			              	} ?>
              				<a href="javascript:void(0)" class="closebtn mobile-menu" onclick="construction_hub_close_nav()"><i class="fas fa-times"></i><span class="screen-reader-text"><?php esc_html_e('Close Button','construction-hub'); ?></span></a>
	            		</nav>
	          		</div>
          			<div class="clearfix"></div>
        		</div>
	    	</div>
	    	<div class=" col-lg-1 col-md-2 col-6 align-self-center">
	    		<div class="search-box">
	    			<?php if(get_theme_mod('construction_hub_search_icon',true) != ''){ ?>
	    				<button class="search_btn"><i class="fas fa-search"></i></button>
	    			<?php }?>
			    </div>
	      	</div>
	    </div>
	    <div class="search_outer">
	      	<div class="search_inner">
	        	<?php get_search_form(); ?>
	        </div>
      	</div>
  	</div>
</div>