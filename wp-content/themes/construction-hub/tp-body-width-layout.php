<?php

	$construction_hub_theme_lay = get_theme_mod( 'construction_hub_tp_body_layout_settings','Full');
    if($construction_hub_theme_lay == 'Container'){
		$construction_hub_tp_theme_css .='body{';
			$construction_hub_tp_theme_css .='max-width: 1140px; width: 100%; padding-right: 15px; padding-left: 15px; margin-right: auto; margin-left: auto;';
		$construction_hub_tp_theme_css .='}';
		$construction_hub_tp_theme_css .='.page-template-custom-home-page .home-page-header{';
			$construction_hub_tp_theme_css .='width: 97%;';
		$construction_hub_tp_theme_css .='}';
	}else if($construction_hub_theme_lay == 'Container Fluid'){
		$construction_hub_tp_theme_css .='body{';
			$construction_hub_tp_theme_css .='width: 100%;padding-right: 15px;padding-left: 15px;margin-right: auto;margin-left: auto;';
		$construction_hub_tp_theme_css .='}';
	}else if($construction_hub_theme_lay == 'Full'){
		$construction_hub_tp_theme_css .='body{';
			$construction_hub_tp_theme_css .='max-width: 100%;';
		$construction_hub_tp_theme_css .='}';
	}

   	$construction_hub_scroll_position = get_theme_mod( 'construction_hub_scroll_top_position','Right');
    if($construction_hub_scroll_position == 'Right'){
        $construction_hub_tp_theme_css .='#return-to-top{';
            $construction_hub_tp_theme_css .='right: 20px;';
        $construction_hub_tp_theme_css .='}';
    }else if($construction_hub_scroll_position == 'Left'){
        $construction_hub_tp_theme_css .='#return-to-top{';
            $construction_hub_tp_theme_css .='left: 20px;';
        $construction_hub_tp_theme_css .='}';
    }else if($construction_hub_scroll_position == 'Center'){
        $construction_hub_tp_theme_css .='#return-to-top{';
            $construction_hub_tp_theme_css .='right: 50%;left: 50%;';
        $construction_hub_tp_theme_css .='}';
    }