<?php

	$construction_hub_tp_color_option = get_theme_mod('construction_hub_tp_color_option');
	$construction_hub_tp_color_option_link = get_theme_mod('construction_hub_tp_color_option_link');
	$construction_hub_tp_preloader_color1_option = get_theme_mod('construction_hub_tp_preloader_color1_option');
	$construction_hub_tp_preloader_color2_option = get_theme_mod('construction_hub_tp_preloader_color2_option');
	$construction_hub_tp_preloader_bg_color_option = get_theme_mod('construction_hub_tp_preloader_bg_color_option');

	$construction_hub_tp_theme_css = '';

	if($construction_hub_tp_color_option != false){
		$construction_hub_tp_theme_css .='.logo,.search-box i,.readmore-btn a:hover,#theme-sidebar button[type="submit"], #footer button[type="submit"],.main-navigation ul ul a:hover,.prev.page-numbers, .next.page-numbers,.page-numbers,#theme-sidebar .tagcloud a:hover,.site-info,.more-btn a,#slider .carousel-control-prev-icon:hover, #slider .carousel-control-next-icon:hover,#our_project i,span.meta-nav,#comments input[type="submit"],.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt{';
			$construction_hub_tp_theme_css .='background-color: '.esc_attr($construction_hub_tp_color_option).';';
		$construction_hub_tp_theme_css .='}';
	}
	if($construction_hub_tp_color_option != false){
		$construction_hub_tp_theme_css .='.headerbox i,.main-navigation a:hover,.main-navigation .current_page_item > a, .main-navigation .current-menu-item > a, .main-navigation .current_page_ancestor > a,a,.readmore-btn a,#theme-sidebar h3,#theme-sidebar a:hover,#footer h3{';
			$construction_hub_tp_theme_css .='color: '.esc_attr($construction_hub_tp_color_option).';';
		$construction_hub_tp_theme_css .='}';
	}
	if($construction_hub_tp_color_option != false){
		$construction_hub_tp_theme_css .='.readmore-btn a,#footer .tagcloud a:hover,.serach_inner form.search-form{';
			$construction_hub_tp_theme_css .='border-color: '.esc_attr($construction_hub_tp_color_option).';';
		$construction_hub_tp_theme_css .='}';
	}
	if($construction_hub_tp_color_option_link != false){
		$construction_hub_tp_theme_css .='.headerbox,.menubar,.main-navigation ul ul,span.page-numbers.current,.prev.page-numbers:focus, .prev.page-numbers:hover, .next.page-numbers:focus, .next.page-numbers:hover,#footer,.more-btn a:hover,.woocommerce #respond input#submit:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover, .woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover,.woocommerce span.onsale{';
			$construction_hub_tp_theme_css .='background-color: '.esc_attr($construction_hub_tp_color_option_link).';';
		$construction_hub_tp_theme_css .='}';
	}
	if($construction_hub_tp_color_option_link != false){
		$construction_hub_tp_theme_css .='a:hover,h2.woocommerce-loop-product__title, .woocommerce div.product .product_title,
		nav.woocommerce-MyAccount-navigation ul li a,h1, h2, h3, h4, h5, h6{';
			$construction_hub_tp_theme_css .='color: '.esc_attr($construction_hub_tp_color_option_link).';';
		$construction_hub_tp_theme_css .='}';
	}
	if($construction_hub_tp_color_option_link != false){
		$construction_hub_tp_theme_css .='nav.woocommerce-MyAccount-navigation ul li{';
			$construction_hub_tp_theme_css .='border-color: '.esc_attr($construction_hub_tp_color_option_link).';';
		$construction_hub_tp_theme_css .='}';
	}
	if($construction_hub_tp_preloader_color1_option != false){
		$construction_hub_tp_theme_css .='.center1{';
			$construction_hub_tp_theme_css .='border-color: '.esc_attr($construction_hub_tp_preloader_color1_option).' !important;';
		$construction_hub_tp_theme_css .='}';
	}
	if($construction_hub_tp_preloader_color1_option != false){
		$construction_hub_tp_theme_css .='.center1 .ring::before{';
			$construction_hub_tp_theme_css .='background: '.esc_attr($construction_hub_tp_preloader_color1_option).' !important;';
		$construction_hub_tp_theme_css .='}';
	}
	if($construction_hub_tp_preloader_color2_option != false){
		$construction_hub_tp_theme_css .='.center2{';
			$construction_hub_tp_theme_css .='border-color: '.esc_attr($construction_hub_tp_preloader_color2_option).' !important;';
		$construction_hub_tp_theme_css .='}';
	}
	if($construction_hub_tp_preloader_color2_option != false){
		$construction_hub_tp_theme_css .='.center2 .ring::before{';
			$construction_hub_tp_theme_css .='background: '.esc_attr($construction_hub_tp_preloader_color2_option).' !important;';
		$construction_hub_tp_theme_css .='}';
	}
	if($construction_hub_tp_preloader_bg_color_option != false){
		$construction_hub_tp_theme_css .='.loader{';
			$construction_hub_tp_theme_css .='background: '.esc_attr($construction_hub_tp_preloader_bg_color_option).';';
		$construction_hub_tp_theme_css .='}';
	}