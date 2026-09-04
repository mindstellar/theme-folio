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
<div class="stack">
    <header>
        <h1><?php echo osc_esc_html(osc_user_name()); ?></h1>
        <?php if (osc_user_info() !== '') { ?>
            <div class="prose muted"><?php echo osc_user_info(); ?></div>
        <?php } ?>
    </header>

    <section>
        <div class="ruled"><h2><?php _e('Listings', 'folio'); ?></h2></div>
        <?php if (osc_count_items() === 0) { ?>
            <p class="empty"><?php _e('Nothing published.', 'folio'); ?></p>
        <?php } else { ?>
            <ol class="index">
                <?php $GLOBALS['folio_heading'] = 'h3';
                while (osc_has_items()) {
                    osc_current_web_theme_path('common/record.php');
                } ?>
            </ol>
        <?php } ?>
    </section>
</div>
<?php osc_current_web_theme_path('common/footer.php'); ?>
