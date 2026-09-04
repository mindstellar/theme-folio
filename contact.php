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
<div class="sheet-wide stack">
    <div class="ruled"><h1><?php _e('Contact', 'folio'); ?></h1></div>

    <form action="<?php echo osc_esc_html(osc_base_url(true)); ?>" method="post" name="contact_form">
        <input type="hidden" name="page" value="contact">
        <input type="hidden" name="action" value="contact_post">

        <div class="field">
            <label for="yourName"><?php _e('Your name', 'folio'); ?></label>
            <input id="yourName" type="text" name="yourName" autocomplete="name" required>
        </div>
        <div class="field">
            <label for="yourEmail"><?php _e('Your email address', 'folio'); ?></label>
            <input id="yourEmail" type="email" name="yourEmail" autocomplete="email" required>
        </div>
        <div class="field">
            <label for="subject"><?php _e('Subject', 'folio'); ?></label>
            <input id="subject" type="text" name="subject" required>
        </div>
        <div class="field">
            <label for="message"><?php _e('Message', 'folio'); ?></label>
            <textarea id="message" name="message" rows="6" required minlength="10"></textarea>
        </div>

        <?php osc_run_hook('contact_form'); ?>

        <div class="actions">
            <button class="btn" type="submit"><?php _e('Send message', 'folio'); ?></button>
        </div>
    </form>
</div>
<?php osc_current_web_theme_path('common/footer.php'); ?>
