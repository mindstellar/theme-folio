<?php
/*
 * Folio — a Shopclass public theme.
 * Copyright (c) 2026 Mindstellar Community
 * SPDX-License-Identifier: GPL-3.0-or-later
 *
 * Contents of <head>. Included by common/header.php.
 */

if (!defined('ABS_PATH')) {
    exit('Direct access is not allowed.');
}

$folio_on_search = osc_is_search_page();
$folio_on_item   = osc_is_ad_page();
$folio_desc      = meta_description();

// Readers get the current search's feed on a results page, the site-wide one
// everywhere else. Core serves RSS on the search route when sFeed=rss.
$folio_feed = $folio_on_search
    ? osc_update_search_url(array('sFeed' => 'rss'))
    : osc_search_url(array('sFeed' => 'rss'));

// The share card's plate. Reading a resource moves core's internal pointer, so
// it is rewound before the page's own loop runs.
$folio_share_image = '';
if ($folio_on_item && osc_images_enabled_at_items() && osc_count_item_resources() > 0) {
    osc_reset_resources();
    if (osc_has_item_resources()) {
        $folio_share_image = osc_resource_preview_url();
    }
    osc_reset_resources();
}
?>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="theme-color" content="#1b2c5e">
<title><?php echo meta_title(); ?></title>
<?php if ($folio_desc !== '') { ?>
<meta name="description" content="<?php echo osc_esc_html($folio_desc); ?>">
<?php } ?>
<?php if (meta_keywords() !== '') { ?>
<meta name="keywords" content="<?php echo osc_esc_html(meta_keywords()); ?>">
<?php } ?>
<?php if (osc_get_canonical() !== '') { ?>
<link rel="canonical" href="<?php echo osc_get_canonical(); ?>">
<?php } ?>

<?php // Share cards. A listing without one is shared as a bare link. ?>
<meta property="og:type" content="<?php echo $folio_on_item ? 'product' : 'website'; ?>">
<meta property="og:site_name" content="<?php echo osc_esc_html(osc_page_title()); ?>">
<meta property="og:title" content="<?php echo osc_esc_html($folio_on_item ? osc_item_title() : strip_tags(meta_title())); ?>">
<?php if ($folio_desc !== '') { ?>
<meta property="og:description" content="<?php echo osc_esc_html($folio_desc); ?>">
<?php } ?>
<?php if (osc_get_canonical() !== '') { ?>
<meta property="og:url" content="<?php echo osc_get_canonical(); ?>">
<?php } ?>
<?php if ($folio_share_image !== '') { ?>
<meta property="og:image" content="<?php echo osc_esc_html($folio_share_image); ?>">
<meta name="twitter:card" content="summary_large_image">
<?php } else { ?>
<meta name="twitter:card" content="summary">
<?php } ?>

<link rel="alternate" type="application/rss+xml"
      title="<?php echo osc_esc_html($folio_on_search ? __('Search results', 'folio') : __('Latest listings', 'folio')); ?>"
      href="<?php echo osc_esc_html($folio_feed); ?>">
<?php // Enqueued styles and scripts, from this theme and from every plugin. ?>
<?php osc_run_hook('header'); ?>
