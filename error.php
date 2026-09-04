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
    <h1><?php _e('Something went wrong', 'folio'); ?></h1>
    <p><?php echo isset($error) ? osc_esc_html($error) : osc_esc_html(__('Please try again.', 'folio')); ?></p>
    <p><a href="<?php echo osc_esc_html(osc_base_url()); ?>"><?php _e('Back to the home page', 'folio'); ?></a></p>
</div>
<?php osc_current_web_theme_path('common/footer.php'); ?>
