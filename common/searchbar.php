<?php
/*
 * Folio — a Shopclass public theme.
 * Copyright (c) 2026 Mindstellar Community
 * SPDX-License-Identifier: GPL-3.0-or-later
 *
 * The site's one search control, in the native <search> landmark. GET to the
 * base URL with the parameter names core's search route already reads, so it
 * needs no JavaScript and survives with the stylesheet switched off.
 *
 * $folio_search_band renders the variant that sits on the navy masthead; unset,
 * it renders on the reading surface.
 */

if (!defined('ABS_PATH')) {
    exit('Direct access is not allowed.');
}

// Set by the caller through $GLOBALS: core require()s this file from inside a
// function, so a local in the calling template is not in scope here.
$folio_band = !empty($GLOBALS['folio_search_band']);
unset($GLOBALS['folio_search_band']);
?>
<search>
    <form action="<?php echo osc_esc_html(osc_base_url(true)); ?>" method="get" role="search"
          class="searchbar<?php echo $folio_band ? ' searchbar-band' : ''; ?>">
        <input type="hidden" name="page" value="search">
        <div class="field field-wide">
            <label for="folio-q"><?php _e('What are you looking for?', 'folio'); ?></label>
            <input id="folio-q" type="search" name="sPattern" autocomplete="off"
                   value="<?php echo osc_esc_html(osc_search_pattern()); ?>"
                   placeholder="<?php echo osc_esc_html(__('Bicycle, sofa, guitar…', 'folio')); ?>">
        </div>
        <div class="field field-narrow">
            <label for="folio-city"><?php _e('Town or city', 'folio'); ?></label>
            <input id="folio-city" type="text" name="sCity" autocomplete="address-level2"
                   placeholder="<?php echo osc_esc_html(__('Anywhere', 'folio')); ?>"
                   value="<?php echo osc_esc_html(osc_search_city()); ?>">
        </div>
        <button class="btn" type="submit"><?php _e('Search', 'folio'); ?></button>
    </form>
</search>
