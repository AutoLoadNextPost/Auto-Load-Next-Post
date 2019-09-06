<?php
/**
 * Admin View: WordPress Requirment Notice.
 *
 * @since    1.0.0
 * @version  1.6.0
 * @author   Sébastien Dumont
 * @category Admin
 * @package  Auto Load Next Post/Admin/Views
 * @license  GPL-2.0+
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="notice notice-error">
	<p><?php echo sprintf( __( 'Sorry, %1$s%3$s%2$s requires WordPress %4$s or higher. Please upgrade your WordPress setup.', 'auto-load-next-post' ), '<strong>', '</strong>', esc_html__( 'Auto Load Next Post', 'auto-load-next-post' ), AUTO_LOAD_NEXT_POST_WP_VERSION_REQUIRE ); ?></p>
</div>
