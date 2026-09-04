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
<div class="record-sheet">
    <section>
        <h1><?php _e('Alerts', 'folio'); ?></h1>
        <p class="muted prose"><?php _e('A saved search that emails you when something new matches it.', 'folio'); ?></p>
        <?php osc_run_hook('user_alerts'); ?>
    </section>

    <?php osc_current_web_theme_path('common/account-nav.php'); ?>
</div>
<?php osc_current_web_theme_path('common/footer.php'); ?>
