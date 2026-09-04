<?php
/*
 * Folio — a Shopclass public theme.
 * Copyright (c) 2026 Mindstellar Community
 * SPDX-License-Identifier: GPL-3.0-or-later
 */

if (!defined('ABS_PATH')) {
    exit('Direct access is not allowed.');
}

osc_current_web_theme_path('common/header.php');
$folio_user = osc_user();
?>
<div class="record-sheet">
    <section>
        <h1><?php _e('Your profile', 'folio'); ?></h1>

        <form action="<?php echo osc_esc_html(osc_base_url(true)); ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="page" value="user">
            <input type="hidden" name="action" value="profile_post">

            <div class="field">
                <label for="s_name"><?php _e('Name', 'folio'); ?></label>
                <?php UserForm::name_text($folio_user); ?>
            </div>
            <div class="field">
                <label for="s_website"><?php _e('Website', 'folio'); ?></label>
                <?php UserForm::website_text($folio_user); ?>
            </div>
            <div class="field">
                <label for="s_info"><?php _e('About you', 'folio'); ?></label>
                <?php UserForm::info_textarea($folio_user, osc_current_user_locale()); ?>
            </div>
            <div class="field">
                <label for="s_phone_land"><?php _e('Telephone', 'folio'); ?></label>
                <?php UserForm::phone_land_text($folio_user); ?>
            </div>
            <div class="field">
                <label for="s_phone_mobile"><?php _e('Mobile', 'folio'); ?></label>
                <?php UserForm::mobile_text($folio_user); ?>
            </div>
            <div class="field">
                <label for="countryId"><?php _e('Country', 'folio'); ?></label>
                <?php UserForm::country_select(osc_get_countries(), $folio_user); ?>
            </div>
            <div class="field">
                <label for="regionId"><?php _e('Region', 'folio'); ?></label>
                <?php UserForm::region_select(osc_get_regions(osc_user_field('fk_c_country_code')), $folio_user); ?>
            </div>
            <div class="field">
                <label for="cityId"><?php _e('City', 'folio'); ?></label>
                <?php UserForm::city_select(osc_get_cities(osc_user_field('fk_i_region_id')), $folio_user); ?>
            </div>
            <div class="field">
                <label for="address"><?php _e('Address', 'folio'); ?></label>
                <?php UserForm::address_text($folio_user); ?>
            </div>

            <?php osc_run_hook('user_profile_form'); ?>

            <div class="actions">
                <button class="btn" type="submit"><?php _e('Save changes', 'folio'); ?></button>
            </div>
        </form>
    </section>

    <?php osc_current_web_theme_path('common/account-nav.php'); ?>
</div>
<?php osc_current_web_theme_path('common/footer.php'); ?>
