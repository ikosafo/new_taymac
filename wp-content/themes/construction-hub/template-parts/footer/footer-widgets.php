<?php
/**
 * Displays footer widgets if assigned
 *
 * @package Construction Hub
 * @subpackage construction_hub
 */

?>
<div class="container">
	<aisde class="widget-area row" role="complementary" aria-label="<?php esc_attr_e( 'Footer', 'construction-hub' ); ?>">
		<div class="col-lg-3 col-md-3">
			<?php dynamic_sidebar( 'footer-1' ); ?>
		</div>
		<div class="col-lg-3 col-md-3">
			<?php dynamic_sidebar( 'footer-2' ); ?>
		</div>
		<div class="col-lg-3 col-md-3">
			<?php dynamic_sidebar( 'footer-3' ); ?>
		</div>
		<div class="col-lg-3 col-md-3">
			<?php dynamic_sidebar( 'footer-4' ); ?>
		</div>
	</aisde>
</div>