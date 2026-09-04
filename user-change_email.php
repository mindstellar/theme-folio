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
    <section class="sheet">
        <h1><?php _e('Change your email address', 'folio'); ?></h1>

        <form action="<?php echo osc_esc_html(osc_base_url(true)); ?>" method="post">
            <input type="hidden" name="page" value="user">
            <input type="hidden" name="action" value="change_email_post">
            <div class="field">
                <label for="new_email"><?php _e('Email address', 'folio'); ?></label>
                <input id="new_email" type="email" name="new_email" required>
            </div>
            <div class="actions">
                <button class="btn" type="submit"><?php _e('Save', 'folio'); ?></button>
            </div>
        </form>
    </section>

    <?php osc_current_web_theme_path('common/account-nav.php'); ?>
</div>
<?php osc_current_web_theme_path('common/footer.php'); ?>
