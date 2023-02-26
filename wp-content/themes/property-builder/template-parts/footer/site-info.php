<?php
/**
 * Displays footer site info
 *
 * @package Property Builder
 * @subpackage property_builder
 */

?>
<div class="site-info">
    <div class="container">
        <p><?php property_builder_credit(); ?> <?php echo esc_html(get_theme_mod('construction_hub_footer_text',__('By Themespride','property-builder'))); ?></p>
    </div>
</div>