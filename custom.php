<?php
/*
 * Folio — a Shopclass public theme.
 * Copyright (c) 2026 Mindstellar Community
 * SPDX-License-Identifier: GPL-3.0-or-later
 *
 * A page a plugin owns, in the theme's chrome.
 */

if (!defined('ABS_PATH')) {
    exit('Direct access is not allowed.');
}

osc_current_web_theme_path('common/header.php');
?>
<div class="stack"><?php osc_render_file(); ?></div>
<?php osc_current_web_theme_path('common/footer.php'); ?>
