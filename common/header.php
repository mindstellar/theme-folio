<?php
/*
 * Folio — a Shopclass public theme.
 * Copyright (c) 2026 Mindstellar Community
 * SPDX-License-Identifier: GPL-3.0-or-later
 *
 * Opens the document, through the masthead. Declared as the theme's chrome in
 * functions.php, so core renders the pages it owns (account deletion, credits)
 * between this file and common/footer.php.
 *
 * ---------------------------------------------------------------------------
 * Direction contract. Kept in PHP, not an HTML comment: nothing that explains
 * a decision to us should be readable in view-source.
 *
 * THESIS: a classifieds site is a catalogue, not a shop window. It refuses the
 *   card grid — the arrangement every listings theme reaches for — and indexes
 *   listings as ruled records that scan by line.
 * OWN-WORLD: ink navy owning whole regions (masthead, colophon) against a
 *   neutral near-white reading surface; hairline rules instead of card borders;
 *   one system sans, tabular numerals, no display face, no shadows at rest.
 * STORY: the visitor scans an index, recognises a record by its plate and its
 *   line, opens it as a catalogue entry, and contacts the seller.
 * FIRST VIEWPORT: navy masthead with the site name and a native <search> field;
 *   below it, the index opens immediately — no hero, no promotional band. The
 *   primary action is the search field itself.
 * FORM: catalogue record + running index.
 * ---------------------------------------------------------------------------
 */

if (!defined('ABS_PATH')) {
    exit('Direct access is not allowed.');
}
?><!doctype html>
<html <?php osc_language_attributes(); ?>>
<head>
<?php osc_current_web_theme_path('common/head.php'); ?>
</head>
<body <?php osc_body_class(); ?>>
<a class="skip" href="#content"><?php _e('Skip to content', 'folio'); ?></a>

<?php
/*
 * The search control lives inside the navy band on the two pages that are an
 * index, so the region that carries the brand also carries the primary action
 * and the page opens on something solid rather than on a floating field.
 */
$folio_band = osc_is_home_page() || osc_is_search_page();
?>
<header class="masthead">
    <div class="spine masthead-bar">
        <a class="wordmark" href="<?php echo osc_esc_html(osc_base_url()); ?>"><?php echo osc_esc_html(osc_page_title()); ?></a>
        <nav aria-label="<?php echo osc_esc_html(__('Primary', 'folio')); ?>">
            <a href="<?php echo osc_esc_html(osc_search_show_all_url()); ?>"
               <?php echo osc_is_search_page() ? 'aria-current="page"' : ''; ?>><?php _e('Browse', 'folio'); ?></a>
            <?php if (osc_users_enabled()) { ?>
                <?php if (osc_is_web_user_logged_in()) { ?>
                    <a href="<?php echo osc_esc_html(osc_user_dashboard_url()); ?>"><?php echo osc_esc_html(osc_logged_user_name()); ?></a>
                    <a href="<?php echo osc_esc_html(osc_user_logout_url()); ?>"><?php _e('Log out', 'folio'); ?></a>
                <?php } else { ?>
                    <a href="<?php echo osc_esc_html(osc_user_login_url()); ?>"><?php _e('Log in', 'folio'); ?></a>
                    <a href="<?php echo osc_esc_html(osc_register_account_url()); ?>"><?php _e('Register', 'folio'); ?></a>
                <?php } ?>
            <?php } ?>
            <a href="<?php echo osc_esc_html(osc_contact_url()); ?>"><?php _e('Contact', 'folio'); ?></a>
            <?php if (osc_item_post_url_in_category() !== '') { ?>
                <a class="nav-action" href="<?php echo osc_esc_html(osc_item_post_url_in_category()); ?>"><?php _e('Publish a listing', 'folio'); ?></a>
            <?php } ?>
        </nav>
    </div>

    <?php if ($folio_band) { ?>
        <div class="spine masthead-band">
            <?php $GLOBALS['folio_search_band'] = true;
            osc_current_web_theme_path('common/searchbar.php'); ?>
        </div>
    <?php } ?>

    <?php folio_widget_zone('header', 'spine masthead-widgets'); ?>
</header>

<main id="content" class="spine">
<?php osc_show_flash_message(); ?>
