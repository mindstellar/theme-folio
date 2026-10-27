<?php
/*
 * Folio — a Shopclass public theme.
 * Copyright (c) 2026 Navjot Tomer (Mindstellar) and contributors
 * SPDX-License-Identifier: GPL-3.0-or-later
 *
 * The seller contact form. Shared by the dialog on the item page and the
 * standalone item-contact.php, so the field contract lives in one file.
 *
 * Core draws the form, so kept values and inline field errors come with it.
 */

if (!defined('ABS_PATH')) {
    exit('Direct access is not allowed.');
}
?>
<p class="safety safety-lead"><?php
    _e('Meet in a public place, inspect the item before paying, and never send money in advance.', 'folio'); ?></p>
<?php osc_item_contact_form(array('prefix' => 'folio-contact')); ?>
<form class="dialog-close" method="dialog">
    <button class="btn btn-quiet" type="submit" formnovalidate><?php _e('Cancel', 'folio'); ?></button>
</form>
