<?php
/*
 * Folio — a Shopclass public theme.
 * Copyright (c) 2026 Mindstellar Community
 * SPDX-License-Identifier: GPL-3.0-or-later
 *
 * The standalone contact page. The item page opens the same fields in a
 * <dialog>; this is where the link lands when that is unavailable.
 */

if (!defined('ABS_PATH')) {
    exit('Direct access is not allowed.');
}

osc_current_web_theme_path('common/header.php');
?>
<div class="sheet-wide stack">
    <h1><?php _e('Contact the seller', 'folio'); ?></h1>
    <p class="muted"><?php printf(osc_esc_html(__('About “%s”', 'folio')), osc_esc_html(osc_item_title())); ?></p>
    <?php osc_current_web_theme_path('common/contact-fields.php'); ?>
</div>
<?php osc_current_web_theme_path('common/footer.php'); ?>
