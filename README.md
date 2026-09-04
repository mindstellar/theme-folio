# Folio

A minimal public theme for [Shopclass](https://github.com/mindstellar/shopclass). Typography-first,
no framework, no build step — and the reference implementation of the theme chrome contract.

## The premise

Folio is built out of the elements the browser already ships. `<dialog>` is the seller-contact
modal, `<details>`/`<summary>` are the collapsible filters, `<search>` wraps the search regions,
`<time>` carries the machine-readable dates. Native form validation, `loading="lazy"` and
`autocomplete` hints do the rest. Light and dark come from `color-scheme` and `light-dark()`; RTL
comes from logical properties, so there is no second stylesheet for either.

What that buys:

- **One stylesheet.** `style.css`, ~26 KB unminified, hand-written, no preprocessor. Design tokens
  are CSS custom properties at the top of the file — change the palette or the type scale by editing
  them.
- **Eight lines of JavaScript**, inline in the footer, with no library behind them: a click delegate
  that opens a `<dialog>` in place. Every link it enhances is a real link first, so the page works
  with scripting off.
- **No build.** What is committed is what ships. Clone it, symlink it, edit it.

The theme consumes only the public theme API (`osc_*` helpers and hooks) and reaches into no core
internals.

## Requirements

- Shopclass 6.3.0 or newer
- PHP 8.0 or newer

## Install

Download `folio_X.Y.Z.zip` from the [releases](https://github.com/mindstellar/theme-folio/releases),
unzip it into `oc-content/themes/` so you have `oc-content/themes/folio/`, and activate it under
**Settings → Appearance**.

For local development, clone next to your Shopclass checkout and symlink it in:

```bash
git clone git@github.com:mindstellar/theme-folio.git
ln -s "$(pwd)/theme-folio" /path/to/shopclass/oc-content/themes/folio
```

`oc-content/themes/*` is gitignored in the core repo, so the symlink won't show up there.

## Theme chrome

Some pages belong to core rather than to the theme — the account-delete confirmation, the credits
and billing screens. Core renders those inside the theme's own header and footer when the theme says
where they are. Folio declares the pair outright in `functions.php`:

```php
osc_add_theme_support('chrome', array(
    'header' => 'common/header.php',
    'footer' => 'common/footer.php',
));
```

So Folio **deliberately ships no `user-delete_account.php` and no `user-billing-*.php`**. Those
pages are not missing; core draws them, and they come out wearing Folio's masthead, Folio's footer
and Folio's type. Shipping stub copies of them would defeat the point.

The contract is documented at
[mindstellar.com/docs/developers/theme-chrome](https://mindstellar.com/docs/developers/theme-chrome/).
The declaration is guarded by `function_exists()`, so the theme still loads on 6.2 — where core's
`common/header.php` + `common/footer.php` probe finds the same pair anyway.

## Plugin hooks

Folio fires the hook names existing plugins already target:

| Hook | Where |
|---|---|
| `header`, `footer` | `<head>` end / before `</body>` |
| `item_detail`, `item_form` | Item page body / post + edit form |
| `item_contact_form`, `contact_form` | Inside the seller-contact and site-contact forms |
| `user_dashboard`, `user_alerts` | Account pages |
| `user_form`, `user_profile_form`, `user_register_form` | Account and registration forms |

## Translations

UI strings use the gettext domain **`folio`** (`__()` / `_e()`), which core loads from
`languages/<locale>/theme.mo` for the active locale. No catalogue ships yet; the theme falls back to
the English source strings.

## Releases

Pushing a `vX.Y.Z` tag runs `.github/workflows/release.yml`, which packages the theme as
`folio_X.Y.Z.zip` and publishes a GitHub release. There is nothing to build first.

## License

GPL-3.0-or-later. © Mindstellar Community.
