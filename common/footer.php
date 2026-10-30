<?php
/*
 * Folio — a Shopclass public theme.
 * Copyright (c) 2026 Navjot Tomer (Mindstellar) and contributors
 * SPDX-License-Identifier: GPL-3.0-or-later
 *
 * Closes the document. Declared as the second half of the theme's chrome in
 * functions.php; core renders its own pages between this and common/header.php.
 */

if (!defined('ABS_PATH')) {
    exit('Direct access is not allowed.');
}

// A link the saved footer menu already shows is not repeated in the other columns.
$folio_footer_menu = folio_saved_menu('footer');
$folio_taken = array();
foreach ($folio_footer_menu['items'] ?? array() as $folio_link) {
    $folio_taken[folio_url_key((string) $folio_link['url'])] = true;
}
// $plain is the same page without friendly URLs, so "/contact" and "?page=contact" count as one.
$folio_link_shown = static fn(string $url, string $plain = ''): bool => !isset($folio_taken[folio_url_key($url)])
    && ($plain === '' || !isset($folio_taken[folio_url_key($plain)]));
$folio_contact_plain = osc_base_url() . 'index.php?page=contact';
$folio_pages = array();
osc_reset_static_pages();
while (osc_has_static_pages()) {
    if ($folio_link_shown(osc_static_page_url(), osc_base_url() . 'index.php?page=page&id=' . osc_static_page_id())) {
        $folio_pages[] = array(osc_static_page_url(), osc_static_page_title());
    }
}
$folio_contact_shown = $folio_link_shown(osc_contact_url(), $folio_contact_plain);
?>
</main>

<footer class="colophon">
    <div class="spine">
        <div class="colophon-grid">
            <div>
                <p class="colophon-mark"><?php echo osc_esc_html(osc_page_title()); ?></p>
                <?php if (osc_page_description() !== '') { ?>
                    <p><?php echo osc_esc_html(osc_page_description()); ?></p>
                <?php } ?>
            </div>

            <div>
                <h2><?php _e('Listings', 'folio'); ?></h2>
                <nav aria-label="<?php echo osc_esc_html(__('Listings', 'folio')); ?>">
                    <a href="<?php echo osc_esc_html(folio_browse_all_url()); ?>"><?php _e('Browse everything', 'folio'); ?></a>
                    <?php if (osc_item_post_url_in_category() !== '' && $folio_link_shown(osc_item_post_url_in_category())) { ?>
                        <a href="<?php echo osc_esc_html(osc_item_post_url_in_category()); ?>"><?php _e('Publish a listing', 'folio'); ?></a>
                    <?php } ?>
                    <a href="<?php echo osc_esc_html(osc_search_url(array('sFeed' => 'rss'))); ?>"><?php _e('Latest listings feed', 'folio'); ?></a>
                </nav>
            </div>

            <?php if ($folio_footer_menu !== null) {
                $folio_footer_title = $folio_footer_menu['label'] !== '' ? $folio_footer_menu['label'] : __('Links', 'folio'); ?>
                <div>
                    <h2><?php echo osc_esc_html($folio_footer_title); ?></h2>
                    <nav aria-label="<?php echo osc_esc_html($folio_footer_title); ?>">
                        <?php foreach ($folio_footer_menu['items'] as $folio_link) { ?>
                            <a href="<?php echo osc_esc_html((string) $folio_link['url']); ?>"><?php echo osc_esc_html((string) $folio_link['label']); ?></a>
                        <?php } ?>
                    </nav>
                </div>
            <?php } ?>

            <?php if (osc_users_enabled()) { ?>
                <div>
                    <h2><?php _e('Your account', 'folio'); ?></h2>
                    <nav aria-label="<?php echo osc_esc_html(__('Your account', 'folio')); ?>">
                        <?php if (osc_is_web_user_logged_in()) { ?>
                            <a href="<?php echo osc_esc_html(osc_user_dashboard_url()); ?>"><?php _e('Overview', 'folio'); ?></a>
                            <a href="<?php echo osc_esc_html(osc_user_list_items_url()); ?>"><?php _e('Your listings', 'folio'); ?></a>
                            <a href="<?php echo osc_esc_html(osc_user_logout_url()); ?>"><?php _e('Log out', 'folio'); ?></a>
                        <?php } else { ?>
                            <a href="<?php echo osc_esc_html(osc_user_login_url()); ?>"><?php _e('Log in', 'folio'); ?></a>
                            <a href="<?php echo osc_esc_html(osc_register_account_url()); ?>"><?php _e('Register', 'folio'); ?></a>
                        <?php } ?>
                    </nav>
                </div>
            <?php } ?>

            <?php if ($folio_pages !== array() || $folio_contact_shown) { ?>
                <div>
                    <h2><?php _e('This site', 'folio'); ?></h2>
                    <nav aria-label="<?php echo osc_esc_html(__('Footer', 'folio')); ?>">
                        <?php // Static pages the owner published, in their own order. ?>
                        <?php foreach ($folio_pages as $folio_page) { ?>
                            <a href="<?php echo osc_esc_html($folio_page[0]); ?>"><?php echo osc_esc_html($folio_page[1]); ?></a>
                        <?php } ?>
                        <?php if ($folio_contact_shown) { ?>
                            <a href="<?php echo osc_esc_html(osc_contact_url()); ?>"><?php _e('Contact', 'folio'); ?></a>
                        <?php } ?>
                    </nav>
                </div>
            <?php } ?>
        </div>

        <?php folio_widget_zone('footer', 'colophon-widgets'); ?>

        <?php $folio_note = (string) folio_setting('footer_note', ''); ?>
        <?php if ($folio_note !== '') { ?>
            <p class="colophon-note"><?php echo osc_esc_html($folio_note); ?></p>
        <?php } ?>

        <div class="colophon-foot">
            <span><?php printf(osc_esc_html(__('© %1$s %2$s', 'folio')), osc_esc_html(date('Y')), osc_esc_html(osc_page_title())); ?></span>

            <?php if (osc_count_web_enabled_locales() > 1) { ?>
                <nav class="colophon-langs" aria-label="<?php echo osc_esc_html(__('Language', 'folio')); ?>">
                    <?php
                    $folio_locale = osc_current_user_locale();
                    osc_goto_first_locale();
                    while (osc_has_web_enabled_locales()) {
                        $folio_code = osc_locale_code(); ?>
                        <a href="<?php echo osc_esc_html(osc_change_language_url($folio_code)); ?>"
                           hreflang="<?php echo osc_esc_html(str_replace('_', '-', $folio_code)); ?>"
                           <?php echo $folio_code === $folio_locale ? 'aria-current="true"' : ''; ?>><?php
                            echo osc_esc_html(osc_locale_name()); ?></a>
                    <?php } ?>
                </nav>
            <?php } ?>
        </div>
    </div>
</footer>

<?php
/*
 * The theme's entire script budget, and all of it is enhancement: every control
 * it touches either works without it or is hidden until it runs.
 *
 * Any link carrying data-folio-dialog opens the matching <dialog> in place
 * instead of navigating; without this the link still goes to the page it names,
 * which is why it is a link and not a button. A dialog holding an
 * [data-folio-plate] image is a reusable frame: the link's own target and alt
 * text are moved into it, so one panel serves every photograph on the page.
 *
 * Core prints a dismiss control on its flash messages as an <a> with no href
 * and no role, and leaves operating it to the theme. It is given the role,
 * tab stop and name here -- the stylesheet keeps it out of the page until that
 * has happened, so with scripting off there is no button that does nothing.
 */
?>
<script>
document.querySelectorAll('.flashmessage .ico-close').forEach(function (b) {
    b.setAttribute('role', 'button');
    b.setAttribute('tabindex', '0');
    b.setAttribute('aria-label', b.dataset.ocCloseLabel || 'Close');
});

document.addEventListener('click', function (e) {
    var el = e.target instanceof Element ? e.target : null;
    if (!el) { return; }

    var x = el.closest('.flashmessage .ico-close[role="button"]');
    if (x) {
        e.preventDefault();
        x.closest('.flashmessage').remove();
        return;
    }

    var a = el.closest('[data-folio-dialog]');
    if (!a) { return; }
    var d = document.getElementById(a.dataset.folioDialog);
    if (!d || typeof d.showModal !== 'function') { return; }
    var plate = d.querySelector('[data-folio-plate]');
    if (plate) {
        var shot = a.querySelector('img');
        plate.src = a.href;
        plate.alt = shot ? shot.alt : '';
    }
    e.preventDefault();
    d.showModal();
});

/* The phone menu strip: show the current link, and mark each end with more links past it. */
document.querySelectorAll('[data-folio-menu]').forEach(function (strip) {
    var current = strip.querySelector('[aria-current]');
    if (current && strip.scrollWidth > strip.clientWidth) {
        strip.scrollLeft += current.getBoundingClientRect().left - strip.getBoundingClientRect().left - strip.clientWidth / 3;
    }
    function mark() {
        var left = Math.abs(strip.scrollLeft);
        strip.toggleAttribute('data-more', strip.scrollWidth - strip.clientWidth - left > 4);
        strip.toggleAttribute('data-more-start', left > 4);
    }
    mark();
    strip.addEventListener('scroll', mark, { passive: true });
    window.addEventListener('resize', mark);
});

/* Wide screens: the saved menu stays on one row and the links that do not fit move into More. */
document.querySelectorAll('[data-folio-more]').forEach(function (more) {
    var menu = more.previousElementSibling;
    var bar = more.closest('.masthead-bar');
    var btn = more.querySelector('button');
    var panel = more.querySelector('.masthead-more-menu');
    var links = Array.prototype.slice.call(menu.children);
    var phone = window.matchMedia('(max-width: 40rem)');

    function close(focus) {
        if (panel.hidden) { return; }
        panel.hidden = true;
        btn.setAttribute('aria-expanded', 'false');
        if (focus) { btn.focus(); }
    }
    function tight() { return menu.scrollWidth > menu.clientWidth + 1 || bar.scrollWidth > bar.clientWidth + 1; }
    function fit() {
        close(false);
        links.forEach(function (a) { menu.appendChild(a); });
        more.hidden = true;
        btn.classList.remove('is-current');
        bar.classList.remove('masthead-wrap');
        if (phone.matches || !tight()) { return; }
        more.hidden = false;
        var inline = links.slice();
        while (inline.length && tight()) { panel.insertBefore(inline.pop(), panel.firstChild); }
        if (tight()) {
            links.forEach(function (a) { menu.appendChild(a); });
            more.hidden = true;
            bar.classList.add('masthead-wrap');
            return;
        }
        btn.classList.toggle('is-current', !!panel.querySelector('[aria-current]'));
    }
    var width = -1;
    function refit() { if (bar.clientWidth !== width) { width = bar.clientWidth; fit(); } }
    refit();
    window.addEventListener('resize', refit);
    if (document.fonts && document.fonts.ready) { document.fonts.ready.then(fit); }

    btn.addEventListener('click', function () {
        var open = panel.hidden;
        panel.hidden = !open;
        btn.setAttribute('aria-expanded', String(open));
    });
    more.addEventListener('focusout', function (e) {
        if (e.relatedTarget && !more.contains(e.relatedTarget)) { close(false); }
    });
    document.addEventListener('click', function (e) {
        if (!more.contains(e.target)) { close(false); }
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && !panel.hidden) { close(true); }
    });
});

/* A role=button element is not a button: Enter and Space have to be wired up. */
document.addEventListener('keydown', function (e) {
    if (e.key !== 'Enter' && e.key !== ' ') { return; }
    var x = e.target instanceof Element
        ? e.target.closest('.flashmessage .ico-close[role="button"]') : null;
    if (!x) { return; }
    e.preventDefault();
    x.click();
});
</script>

<?php // Deferred scripts and anything a plugin appends to the document. ?>
<?php osc_run_hook('footer'); ?>
</body>
</html>
