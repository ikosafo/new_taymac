<?php

	$construction_hub_tp_color_option = get_theme_mod('construction_hub_tp_color_option');
	$construction_hub_tp_color_option_link = get_theme_mod('construction_hub_tp_color_option_link');

	$construction_hub_tp_theme_css = '';

	if($construction_hub_tp_color_option != false){
		$construction_hub_tp_theme_css .='.readmore-btn a:hover, .search-box i, #theme-sidebar button[type="submit"], #footer button[type="submit"], span.meta-nav, .main-navigation ul ul a:hover, #comments input[type="submit"], .woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .page-numbers, .prev.page-numbers, .next.page-numbers, .toggle-nav button, .more-btn a, #our_project i, #slider .carousel-control-prev-icon, #slider .carousel-control-next-icon, .error-404 [type="submit"], button[type="submit"]{';
			$construction_hub_tp_theme_css .='background-color: '.esc_attr($construction_hub_tp_color_option).';';
		$construction_hub_tp_theme_css .='}';
	}
	if($construction_hub_tp_color_option != false){
		$construction_hub_tp_theme_css .='a, .box-content a, #theme-sidebar .textwidget a, #footer .textwidget a, .comment-body a, .entry-content a, .entry-summary a, .headerbox i, #theme-sidebar h3, #theme-sidebar a:hover, .main-navigation a:hover, #footer h3, .main-navigation .current_page_item > a, .main-navigation .current-menu-item > a, .main-navigation .current_page_ancestor > a{';
			$construction_hub_tp_theme_css .='color: '.esc_attr($construction_hub_tp_color_option).';';
		$construction_hub_tp_theme_css .='}';
	}
	if($construction_hub_tp_color_option != false){
		$construction_hub_tp_theme_css .='.wp-block-pullquote blockquote, .wp-block-quote:not(.is-large):not(.is-style-large), .wp-block-pullquote,.readmore-btn a, .search_inner form.search-form, #footer .tagcloud a:hover{';
			$construction_hub_tp_theme_css .='border-color: '.esc_attr($construction_hub_tp_color_option).'!important;';
		$construction_hub_tp_theme_css .='}';
	}

	if($construction_hub_tp_color_option_link != false){
		$construction_hub_tp_theme_css .='a:hover,#theme-sidebar a:hover{';
			$construction_hub_tp_theme_css .='color: '.esc_attr($construction_hub_tp_color_option_link).';';
		$construction_hub_tp_theme_css .='}';
	}
	