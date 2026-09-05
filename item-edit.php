<?php
/*
 * Folio — a Shopclass public theme.
 * Copyright (c) 2026 Mindstellar Community
 * SPDX-License-Identifier: GPL-3.0-or-later
 *
 * Publish and edit share this file; $folio_edit decides which. The fields come
 * from core's ItemForm so the contract stays core's, not the theme's.
 */

if (!defined('ABS_PATH')) {
    exit('Direct access is not allowed.');
}

$folio_edit   = osc_is_edit_page();
$folio_action = $folio_edit ? 'item_edit_post' : 'item_add_post';
$folio_loc    = $folio_edit ? osc_item() : osc_user();
$folio_locale = osc_current_user_locale();

/*
 * The region and city lists follow the country and region already chosen: the
 * posted ones when the form comes back, otherwise the listing's or the seller's.
 * Without the posted branch a visitor who changes country with no JavaScript is
 * offered the previous country's regions on the re-render.
 */
$folio_country = Params::getParamString('countryId') !== ''
    ? Params::getParamString('countryId')
    : ($folio_edit ? osc_item_country_code() : osc_user_field('fk_c_country_code'));
$folio_region  = Params::getParamInt('regionId') > 0
    ? Params::getParamInt('regionId')
    : ($folio_edit ? osc_item_region_id() : osc_user_field('fk_i_region_id'));

if (osc_images_enabled_at_items()) {
    osc_enqueue_script('osc-uploader');
    osc_enqueue_style('osc-uploader');
}

osc_get_header();
?>
<div class="sheet-wide stack">
    <div class="ruled"><h1><?php echo $folio_edit ? osc_esc_html(__('Edit your listing', 'folio')) : osc_esc_html(__('Publish a listing', 'folio')); ?></h1></div>

    <form name="item" action="<?php echo osc_esc_html(osc_base_url(true)); ?>" method="post"
          enctype="multipart/form-data" id="item-post">
        <input type="hidden" name="page" value="item">
        <input type="hidden" name="action" value="<?php echo osc_esc_html($folio_action); ?>">
        <?php if ($folio_edit) { ?>
            <input type="hidden" name="id" value="<?php echo (int) osc_item_id(); ?>">
            <input type="hidden" name="secret" value="<?php echo osc_esc_html(osc_item_secret()); ?>">
        <?php } ?>

        <div class="field">
            <label for="catId"><?php _e('Category', 'folio'); ?></label>
            <?php ItemForm::category_select(); ?>
        </div>

        <div class="field">
            <label for="title[<?php echo osc_esc_html($folio_locale); ?>]"><?php _e('Title', 'folio'); ?></label>
            <?php ItemForm::title_input('title', $folio_locale, osc_esc_html(osc_item_title())); ?>
        </div>

        <div class="field">
            <label for="description[<?php echo osc_esc_html($folio_locale); ?>]"><?php _e('Description', 'folio'); ?></label>
            <?php ItemForm::description_textarea('description', $folio_locale, osc_esc_html(osc_item_description())); ?>
        </div>

        <?php if (osc_price_enabled_at_items()) { ?>
            <div class="field">
                <label for="price"><?php _e('Price', 'folio'); ?></label>
                <?php ItemForm::price_input_text(); ?>
                <?php ItemForm::currency_select(osc_get_currencies(), osc_item()); ?>
            </div>
        <?php } ?>

        <div class="field">
            <label for="countryId"><?php _e('Country', 'folio'); ?></label>
            <?php ItemForm::country_select(osc_get_countries(), $folio_loc); ?>
            <noscript>
                <span class="hint"><?php _e('The region and city lists follow the country once the form is sent back. Both may be left blank.', 'folio'); ?></span>
            </noscript>
        </div>
        <div class="field">
            <label for="regionId"><?php _e('Region', 'folio'); ?></label>
            <?php ItemForm::region_select(osc_get_regions($folio_country), $folio_loc); ?>
        </div>
        <div class="field">
            <label for="cityId"><?php _e('City', 'folio'); ?></label>
            <?php ItemForm::city_select(osc_get_cities($folio_region), $folio_loc); ?>
        </div>

        <?php if (osc_images_enabled_at_items()) { ?>
            <div class="field">
                <label><?php _e('Photographs', 'folio'); ?></label>
                <?php ItemForm::ajax_photos(); ?>
            </div>
        <?php } ?>

        <?php if (!osc_is_web_user_logged_in()) { ?>
            <div class="field">
                <label for="contactName"><?php _e('Your name', 'folio'); ?></label>
                <?php ItemForm::contact_name_text(); ?>
            </div>
            <div class="field">
                <label for="contactEmail"><?php _e('Your email address', 'folio'); ?></label>
                <?php ItemForm::contact_email_text(); ?>
            </div>
        <?php } ?>

        <?php osc_run_hook('item_form', osc_item_category_id()); ?>

        <div class="actions">
            <button class="btn" type="submit"><?php echo $folio_edit
                ? osc_esc_html(__('Save changes', 'folio'))
                : osc_esc_html(__('Publish', 'folio')); ?></button>
        </div>
    </form>

    <?php
    /*
     * Core's own cascade for dropdown location fields. Called after the form so
     * the selects exist when it runs -- it wires them on execution rather than on
     * DOMContentLoaded. location_javascript_new() is the wrong twin here: it wires
     * an autocomplete UI (#countryName, free-text #region/#city) and, against
     * selects, only clears the dependent fields without ever repopulating them.
     */
    ItemForm::location_javascript();
    ?>
</div>
<?php osc_get_footer(); ?>
