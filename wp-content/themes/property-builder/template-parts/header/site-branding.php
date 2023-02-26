<?php 
/*
* Display Logo and contact details
*/
?>

<div class="headerbox">
  <div class="row m-0 contact-section">
    <div class="col-lg-5 col-md-5 col-sm-5 align-self-center">
      <?php if(get_theme_mod( 'property_builder_location' ) != '') { ?>
      <i class="fas fa-map-marker-alt mr-2"></i><span class="infotext"><?php echo esc_html( get_theme_mod('property_builder_location_text','') ); ?></span>      
        <span class="simplep"><?php echo esc_html( get_theme_mod('property_builder_location','') ); ?></span>
      <?php } ?>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-5 align-self-center">
      <?php if(get_theme_mod( 'construction_hub_call' ) != '') { ?>
        <i class="fas fa-phone  mr-2"></i><span class="infotext"><?php echo esc_html( get_theme_mod('construction_hub_call_text','') ); ?></span>      
        <span class="simplep"><?php echo esc_html( get_theme_mod('construction_hub_call','') ); ?></span>
      <?php } ?>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-4 email align-self-center">
      <span class="infotext"><?php echo esc_html( get_theme_mod('construction_hub_mail_text','')); ?></span>
      <?php if( get_theme_mod( 'construction_hub_mail' ) != '') { ?>
        <span class="simplep"><?php echo esc_html( get_theme_mod('construction_hub_mail','') ); ?></span><i class="fas fa-at ml-2"></i>
      <?php } ?>
    </div>
  </div>
</div>