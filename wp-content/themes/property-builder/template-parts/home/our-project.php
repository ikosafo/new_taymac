<?php
/**
 * Template part for displaying Our Project section
 *
 * @package Property Builder
 * @subpackage property_builder
 */
?>

<section id="our_project">
  <div class="container">
    <?php if( get_theme_mod('construction_hub_our_project_title') != '' || get_theme_mod('construction_hub_our_project_para') != ''){ ?>
      <div class="project_bg">
        <?php if( get_theme_mod('construction_hub_our_project_title') != ''){ ?>
          <h3><?php echo esc_html(get_theme_mod('construction_hub_our_project_title','')); ?></h3>
        <?php }?>
        <?php if( get_theme_mod('construction_hub_our_project_para') != ''){ ?>
          <p><?php echo esc_html(get_theme_mod('construction_hub_our_project_para','')); ?></p>
        <?php }?>
      </div>
    <?php }?>
    <div class="owl-carousel mt-5">
        <?php $construction_hub_project_pages = array();

        $project_count = get_theme_mod('property_builder_about_page_count','');

        for ( $count = 1; $count <= $project_count; $count++ ) {
            $mod = intval( get_theme_mod( 'construction_hub_about_page' . $count ));
          if ( 'page-none-selected' != $mod ) {
            $construction_hub_project_pages[] = $mod;
          }
        }
        if( !empty($construction_hub_project_pages) ) :
          $args = array(
            'post_type' => 'page',
            'post__in' => $construction_hub_project_pages,
            'orderby' => 'post__in'
          );
          $query = new WP_Query( $args );
        if ( $query->have_posts() ) :
          $count = 0;
          while ( $query->have_posts() ) : $query->the_post(); ?>
            <div class="project_box">
              <div class="project-img">
                <img src="<?php esc_url(the_post_thumbnail_url('full')); ?>"/>
              </div>
              <div class="project_text">
                <div class="row">
                  <div class="col-lg-10 col-md-10 col-8 align-self-center">
                    <h4><?php the_title(); ?></h4>
                  </div>
                  <div class="col-lg-2 col-md-2 col-4 align-self-center">
                    <a href="<?php the_permalink(); ?>"><i class="fas fa-angle-right"></i></a>
                  </div>
                </div>
              </div>
            </div>
          <?php $count++; endwhile; 
          wp_reset_postdata();?>
          <?php else : ?>
            <div class="no-postfound"></div>
          <?php endif;
        endif;?>
    </div>
  </div>
</section>