<?php
/*
 * Folio — a Shopclass public theme.
 * Copyright (c) 2026 Navjot Tomer (Mindstellar) and contributors
 * SPDX-License-Identifier: GPL-3.0-or-later
 *
 * The seller contact form. Shared by the dialog on the item page and the
 * standalone item-contact.php, so the field contract lives in one file.
 *
 * Core draws the form when it can, so kept values and inline field errors come with it.
 */

if (!defined('ABS_PATH')) {
    exit('Direct access is not allowed.');
}
?>
<p class="safety safety-lead"><?php
    _e('Meet in a public place, inspect the item before paying, and never send money in advance.', 'folio'); ?></p>
<?php if (function_exists('osc_item_contact_form')) { ?>
    <?php osc_item_contact_form(array('prefix' => 'folio-contact')); ?>
    <form class="dialog-close" method="dialog">
        <button class="btn btn-quiet" type="submit" formnovalidate><?php _e('Cancel', 'folio'); ?></button>
    </form>
    <?php
    return;
} ?>
<?php // Core 7.0 has no contact form helper, so the theme draws its own. ?>
<form action="<?php echo osc_esc_html(osc_base_url(true)); ?>" method="post"
      <?php if (osc_item_attachment()) { echo 'enctype="multipart/form-data"'; } ?>>
    <input type="hidden" name="action" value="contact_post">
    <input type="hidden" name="page" value="item">
    <input type="hidden" name="id" value="<?php echo (int) osc_item_id(); ?>">

    <div class="field">
        <label for="yourName"><?php _e('Your name', 'folio'); ?></label>
        <input id="yourName" name="yourName" type="text" autocomplete="name" required
               value="<?php echo osc_esc_html(osc_logged_user_name()); ?>">
    </div>

    <div class="field">
        <label for="yourEmail"><?php _e('Your email address', 'folio'); ?></label>
        <input id="yourEmail" name="yourEmail" type="email" autocomplete="email" required
               value="<?php echo osc_esc_html(osc_logged_user_email()); ?>">
        <span class="hint"><?php _e('The seller replies to this address.', 'folio'); ?></span>
    </div>

    <div class="field">
        <label for="phoneNumber"><?php _e('Phone number', 'folio'); ?>
            <span class="muted">(<?php _e('optional', 'folio'); ?>)</span></label>
        <input id="phoneNumber" name="phoneNumber" type="tel" autocomplete="tel">
    </div>

    <div class="field">
        <label for="message"><?php _e('Message', 'folio'); ?></label>
        <textarea id="message" name="message" rows="5" required minlength="10"></textarea>
    </div>

    <?php if (osc_item_attachment()) { ?>
        <div class="field">
            <label for="attachment"><?php _e('Attachment', 'folio'); ?>
                <span class="muted">(<?php _e('optional', 'folio'); ?>)</span></label>
            <input id="attachment" name="attachment" type="file">
        </div>
    <?php } ?>

    <?php osc_run_hook('item_contact_form', osc_item_id()); ?>

    <div class="actions">
        <button class="btn" type="submit"><?php _e('Send message', 'folio'); ?></button>
        <button class="btn btn-quiet" type="submit" formmethod="dialog"
                formnovalidate><?php _e('Cancel', 'folio'); ?></button>
    </div>
</form>
