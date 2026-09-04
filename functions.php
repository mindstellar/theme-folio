<?php
/*
 * Folio — a Shopclass public theme.
 * Copyright (c) 2026 Mindstellar Community
 *
 * Distributed under the GNU General Public License v3.0 or later. See LICENSE.
 *
 * SPDX-License-Identifier: GPL-3.0-or-later
 */

if (!defined('ABS_PATH')) {
    exit('Direct access is not allowed.');
}

define('FOLIO_VERSION', '0.1.0');

/**
 * Where core should open and close a page it owns itself -- the account-delete
 * confirmation, the credits pages. Without this, core probes for header.php +
 * footer.php and then common/header.php + common/footer.php; Folio declares the
 * pair outright so the resolution never depends on where the files happen to sit.
 *
 * Requires Shopclass 6.3.0. Older cores ignore an unknown function, so the guard
 * keeps the theme loadable on 6.2 -- where the common/ probe answers anyway.
 */
if (function_exists('osc_add_theme_support')) {
    osc_add_theme_support('chrome', array(
        'header' => 'common/header.php',
        'footer' => 'common/footer.php',
    ));
}

/**
 * Core owns the document head: charset, viewport, title, description, keywords
 * and canonical all come from osc_head(), so a page core renders itself is
 * described as well as one of this theme's own.
 *
 * The feed link is the exception. Core's is titled after the site; this theme
 * names the current search on a results page, which is what a reader subscribing
 * from there expects to get.
 */
if (function_exists('osc_add_theme_support')) {
    osc_add_theme_support('head', array('feed' => false));
}

/**
 * The two places this theme renders widgets, named for the admin screen that
 * places them. Declared on `init` rather than at load: the labels are
 * translated, and the translation layer is initialised after a theme's
 * functions.php has already been required.
 *
 * Requires Shopclass 6.3.0. Older cores fall back to the `Widgets:` line in
 * index.php, which still lists both.
 */
function folio_widget_locations(): void
{
    osc_add_theme_support('widget_locations', array(
        'header' => array(
            'label'       => __('Masthead', 'folio'),
            'description' => __('Below the navigation, inside the navy band.', 'folio'),
        ),
        'footer' => array(
            'label'       => __('Colophon', 'folio'),
            'description' => __('In the footer, above the copyright line.', 'folio'),
        ),
    ));
}

if (function_exists('osc_add_theme_support')) {
    osc_add_hook('init', 'folio_widget_locations');
}

/**
 * One widget zone. Rendered into a buffer first so a zone holding nothing --
 * which is every zone on most sites -- emits no wrapper at all, rather than an
 * empty block with padding and a rule above it.
 */
function folio_widget_zone(string $location, string $class): void
{
    ob_start();
    osc_show_widgets($location);
    $html = trim((string) ob_get_clean());

    if ($html === '') {
        return;
    }

    echo '<div class="' . osc_esc_html($class) . '">' . $html . '</div>';
}

/**
 * One stylesheet. Registered under an id so a plugin can depend on it, and
 * cache-busted by file mtime rather than the theme version, so an edit during
 * development is picked up without a version bump.
 */
function folio_enqueue(): void
{
    osc_enqueue_style('folio', osc_asset_url_versioned(osc_current_web_theme_url('style.css')));
}

osc_add_hook('header', 'folio_enqueue', 5);

/**
 * The item's price as markup: the figure and the currency in separate spans so
 * the stylesheet can weight them apart. Core renders a whole formatted string
 * ("940 Dollar US$") and the currency name can be long enough to outshout the
 * number, so the symbol is located inside core's own output rather than
 * reassembled here -- locale order, separators and decimals stay core's.
 *
 * "Check with seller" and "Free" have no figure, so they come back as a note.
 */
function folio_price_html(): string
{
    $formatted = osc_item_formatted_price();
    $price     = osc_item_price();

    if ($price === null || (float) $price === 0.0) {
        return '<span class="price-note">' . osc_esc_html($formatted) . '</span>';
    }

    $out    = osc_esc_html($formatted);
    $symbol = osc_esc_html(osc_item_currency_symbol());

    if ($symbol !== '') {
        $at = strpos($out, $symbol);
        if ($at !== false) {
            $out = substr_replace($out, '<span class="cur">' . $symbol . '</span>', $at, strlen($symbol));
        }
    }

    return '<span class="amount">' . $out . '</span>';
}

/**
 * ISO date for a <time datetime>, from whatever core hands back.
 */
function folio_iso_date(?string $date): string
{
    $stamp = $date === null || $date === '' ? false : strtotime($date);

    return $stamp === false ? '' : date('Y-m-d', $stamp);
}
