<?php
/*
 * Folio — a Shopclass public theme.
 * Copyright (c) 2026 Mindstellar Community
 * SPDX-License-Identifier: GPL-3.0-or-later
 */

if (!defined('ABS_PATH')) {
    exit('Direct access is not allowed.');
}

osc_current_web_theme_path('common/header.php');
?>
<div class="prose stack">
    <div class="ruled"><h1><?php _e('That page is not here', 'folio'); ?></h1></div>
    <p><?php _e('The listing may have been sold and removed, or the address may be mistyped.', 'folio'); ?></p>
    <?php osc_current_web_theme_path('common/searchbar.php'); ?>
    <p><a href="<?php echo osc_esc_html(osc_base_url()); ?>"><?php _e('Back to the home page', 'folio'); ?></a></p>
</div>
<?php osc_current_web_theme_path('common/footer.php'); ?>
