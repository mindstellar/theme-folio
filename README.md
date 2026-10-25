# Folio

A small classifieds theme that puts type first. It uses native HTML elements, one hand-written stylesheet and almost no JavaScript. It is also the reference for the theme chrome contract.

## Requirements

- Shopclass 7.0.0 or later
- PHP 8.0 or later
- No plugins needed.

## Install

1. Go to **Appearance → Manage themes**.
2. Find Folio in **Browse**, or upload `folio_X.Y.Z.zip` from the [releases](https://github.com/mindstellar/theme-folio/releases).
3. Click **Install**, then **Activate**.

## Set up

1. Go to **Appearance → Folio**:
   - **Logo**: shown in the masthead instead of the site name. A transparent PNG fits best.
   - **Brand colour**: replaces the navy of the masthead and footer.
   - **Footer note**: one line above the copyright. Leave it empty to omit it.
2. Go to **Appearance → Manage widgets** to fill the **Masthead** and **Colophon** areas.

## Features

- `<dialog>` for the seller contact form, `<details>` for filters, `<search>` around the search fields.
- Light and dark come from `color-scheme` and `light-dark()`. Right-to-left comes from logical properties.
- One stylesheet, `style.css`, with design tokens as CSS variables at the top.
- A small inline script in the footer. Links work without it.
- No build step. What is committed is what ships.
- Core draws the account and sign-in pages inside Folio's masthead and footer. Folio ships none of those views, and `style.css` styles core's markup. To change a page, add its file to the theme.

## Customising

Edit the variables at the top of `style.css` to change the palette or type scale. Use a child theme to keep changes through updates.

## For developers

- Folio declares its header and footer with `osc_add_theme_support('chrome', ...)` in `functions.php`. See the [theme chrome docs](https://mindstellar.com/docs/developers/theme-chrome/) and the [account pages docs](https://mindstellar.com/docs/developers/account-pages/).
- Hooks the theme fires: `header` (through `osc_head()`), `footer`, `item_detail` and `item_contact_form`. Core fires the account and form hooks inside Folio's chrome.
- Strings use the text domain `folio`. Run `node bin/i18n.mjs` to update `languages/folio.pot`. It needs only Node. No translations ship yet.
- To work on the theme, clone it and symlink it into `oc-content/themes/folio`.
- A `vX.Y.Z` tag runs `.github/workflows/release.yml`, which publishes `folio_X.Y.Z.zip`.

## Support

Report problems at [github.com/mindstellar/theme-folio/issues](https://github.com/mindstellar/theme-folio/issues).

## License

GPL-3.0-or-later. Copyright Navjot Tomer (Mindstellar) and contributors.
