<?php
/**
 * Displays footer site info
 *
 * @package Construction Hub
 * @subpackage construction_hub
 */

?>
<div class="site-info">
    <div class="container">
        <p><?php construction_hub_credit();?> <?php echo esc_html(get_theme_mod('construction_hub_footer_text',__('By Themespride','construction-hub'))); ?></p>
    </div>
</div>