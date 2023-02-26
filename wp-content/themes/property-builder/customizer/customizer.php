<?php 	

function property_builder_customize_register( $wp_customize ) {

    $wp_customize->add_setting('property_builder_location_text',array(
        'default'=> '',
        'sanitize_callback' => 'sanitize_text_field'
    )); 
    $wp_customize->add_control('property_builder_location_text',array(
        'priority' => 2,
        'label' => __('Add Location Text','property-builder'),
        'section'=> 'construction_hub_topbar',
        'type'=> 'text'
    ));

    $wp_customize->add_setting('property_builder_location',array(
        'default'=> '',
        'sanitize_callback' => 'sanitize_text_field'
    )); 
    $wp_customize->add_control('property_builder_location',array(
        'label' => __('Add Location','property-builder'),
        'priority' => 3,
        'section'=> 'construction_hub_topbar',
        'type'=> 'text'
    ));

    $wp_customize->add_setting('property_builder_about_page_count',array(
        'default'=> '',        
        'sanitize_callback' => 'sanitize_text_field'
    )); 
    $wp_customize->add_control('property_builder_about_page_count',array(
        'label' => __('Number of Projects','property-builder'),
        'section'=> 'construction_hub_about_section',
        'priority' => 3,
        'type'=> 'number'
    ));

    $project_count =  get_theme_mod('property_builder_about_page_count');

    for ( $count = 1; $count <= $project_count; $count++ ) {

        $wp_customize->add_setting( 'construction_hub_about_page' . $count, array(
            'default' => '',            
            'sanitize_callback' => 'construction_hub_sanitize_dropdown_pages'
        ));
        $wp_customize->add_control( 'construction_hub_about_page' . $count, array(
            'label'    => __( 'Select Project Page', 'property-builder' ),
            'section'  => 'construction_hub_about_section',
            'priority' => 5,
            'type'     => 'dropdown-pages'
        ));
    }
}
add_action( 'customize_register', 'property_builder_customize_register' );