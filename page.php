<?php
/*
 * Folio — a Shopclass public theme.
 * Copyright (c) 2026 Navjot Tomer (Mindstellar) and contributors
 * SPDX-License-Identifier: GPL-3.0-or-later
 *
 * A static page the owner wrote, and the canvas the page builder renders into.
 */

if (!defined('ABS_PATH')) {
    exit('Direct access is not allowed.');
}

osc_get_header();
?>
<article class="prose stack">
    <h1><?php echo osc_esc_html(osc_static_page_title()); ?></h1>
    <?php echo osc_static_page_text(); ?>
</article>
<?php osc_get_footer(); ?>
