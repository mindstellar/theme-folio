<?php
/*
 * Folio — a Shopclass public theme.
 * Copyright (c) 2026 Mindstellar Community
 * SPDX-License-Identifier: GPL-3.0-or-later
 *
 * Served with HTTP 503 while the owner works on the site. Self-contained: core
 * renders this before the theme's own chrome is safe to assume.
 */

if (!defined('ABS_PATH')) {
    exit('Direct access is not allowed.');
}
?><!doctype html>
<html lang="<?php echo osc_esc_html(str_replace('_', '-', osc_current_user_locale())); ?>">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo osc_esc_html(osc_page_title()); ?></title>
<link rel="stylesheet" href="<?php echo osc_esc_html(osc_current_web_theme_url('style.css')); ?>">
</head>
<body>
<header class="masthead"><div class="spine"><span class="wordmark"><?php echo osc_esc_html(osc_page_title()); ?></span></div></header>
<main id="content" class="spine prose" style="padding-block:4rem">
    <h1><?php _e('Back shortly', 'folio'); ?></h1>
    <p><?php _e('The site is being worked on right now. Please try again in a few minutes.', 'folio'); ?></p>
</main>
</body>
</html>
