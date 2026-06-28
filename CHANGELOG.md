# Changelog

All notable changes to UPPA Base are documented here.
Format: [keepachangelog.com](https://keepachangelog.com/en/1.1.0/) | Versioning: [semver.org](https://semver.org/spec/v2.0.0.html)

## [Unreleased]

## [1.0.0] — 2025-06-28

### Added

#### Theme foundation
- `style.css` — WP.org-required theme header; no CSS rules (all CSS enqueued from `assets/css/dist/`).
- `functions.php` — loader-only entry point defining `UPPA_VERSION`, `UPPA_DIR`, `UPPA_URI` constants and requiring all `inc/` files.
- `screenshot.png` placeholder at `assets/images/screenshot.png` (1200×900px required before WP.org submission).

#### Core template files
- `index.php` — mandatory fallback template with loop via `get_template_part()`.
- `single.php` — single post template with post navigation (`the_post_navigation()`).
- `page.php` — static page template.
- `archive.php` — archive (category, tag, author, date) template with page header.
- `search.php` — search results template with escaped `get_search_query()`.
- `404.php` — not-found template with inline search form fallback.
- `sidebar.php` — widget area output via `dynamic_sidebar()`.
- `comments.php` — comment list and form via `wp_list_comments()` / `comment_form()`.

#### Template parts
- `template-parts/global/skip-link.php` — accessibility skip link targeting `#main`.
- `template-parts/global/breadcrumbs.php` — plugin-free breadcrumb trail; handles singular posts with primary category, taxonomy, author, date, search, and 404 contexts.
- `template-parts/header/site-branding.php` — outputs custom logo or site title/description with correct heading level (`<h1>` on front page, `<p>` elsewhere).
- `template-parts/header/navigation.php` — primary `wp_nav_menu()` with hamburger toggle button, `aria-expanded`, and `aria-controls` attributes.
- `template-parts/content/content.php` — default post loop item with featured image, title, meta, excerpt, tag list, and `wp_link_pages()`.
- `template-parts/content/content-none.php` — empty-state partial with context-sensitive message and inline search form.
- `template-parts/content/content-page.php` — page content partial with featured image and `the_content()`.

#### `inc/` feature files
- `inc/setup.php` — `after_setup_theme`: loads text domain, registers all `add_theme_support()` calls (post-thumbnails, title-tag, custom-logo, html5, wp-block-styles, align-wide, responsive-embeds, editor-styles), registers `primary` and `footer` nav menus, registers `sidebar-1` and `footer-1` widget areas.
- `inc/enqueue.php` — enqueues `uppa-base-style` from `assets/css/dist/main.min.css` and `uppa-base-scripts` from `assets/js/dist/main.min.js`; fires `uppa_enqueue_styles` and `uppa_enqueue_scripts` action hooks for child-theme extension; registers editor style.
- `inc/hooks.php` — defines and fires all 14 documented action and filter hooks with default render callbacks; every callback is individually removable by child themes.
- `inc/nav-walkers.php` — `UPPA_Base_Nav_Walker` extending `Walker_Nav_Menu`; adds `aria-haspopup` and `aria-expanded` to sub-menu parent items.
- `inc/template-tags.php` — `uppa_posted_on()`, `uppa_posted_by()`, `uppa_post_thumbnail()` reusable template helper functions with full escaping.
- `inc/accessibility.php` — outputs skip-link template part on `wp_body_open` priority 1; prints condensed `.screen-reader-text` inline CSS on `wp_head`; provides `uppa_aria_header()`, `uppa_aria_main()`, `uppa_aria_footer()` landmark role helpers.
- `inc/compat.php` — defines `UPPA_CORE_VERSION`, `UPPA_CORE_DIR`, `UPPA_CORE_URI`, `UPPA_CORE_MIN_VERSION` with safe defaults; shims `uppa_core_get_option()`, `uppa_core_feature_enabled()`, `uppa_core_get_label()` via `function_exists` guards; displays admin notice only when the plugin is active but below minimum compatible version.

#### CSS token and stylesheet system
- `assets/css/src/_tokens.scss` — full CSS custom-property system on `:root`: spacing scale (`--space-xs` → `--space-3xl`), type scale (`--text-xs` → `--text-4xl`), colour tokens (`--color-primary: #0D1B2A`, `--color-accent: #E8500A`, surface, text, border), layout tokens (`--container-max`, `--container-gutter`, `--sidebar-width`).
- `assets/css/src/_reset.scss` — modern CSS reset; `box-sizing: border-box`; margin/padding zeroed; `img max-width: 100%`; `:focus-visible` outline using `var(--color-accent)`; `prefers-reduced-motion` media query disabling all transitions and animations; `[hidden]` display guard.
- `assets/css/src/_typography.scss` — `body`, `h1`–`h6` mapped to type-scale tokens, `p` with `max-width: 70ch`, `a` with `var(--color-accent)`, `blockquote` with accent border, `code` and `pre` blocks, `.screen-reader-text` utility with token-based `:focus` state.
- `assets/css/src/_layout.scss` — `.container`, `.site` flex column, `.site-header` sticky with `z-index: 100`, `.site-content` with `:has(.widget-area)` two-column grid and `@supports not selector(:has(*))` fallback, `.widget-area`, `.site-footer`, `.footer-widgets` auto-fit grid, `.entry-header/content/footer`, `.page-header`, `.post-thumbnail`, pagination.
- `assets/css/src/_navigation.scss` — `.menu-toggle` at 44×44px WCAG touch target, hamburger-to-X CSS animation via `[aria-expanded='true']` state, `.nav-menu` mobile dropdown → desktop inline row at `768px`, `.sub-menu` dropdowns, `.skip-link:focus` fixed positioning, `.breadcrumbs` and `.breadcrumb__item` with `::after` separator.
- `assets/css/src/_blocks.scss` — `.alignwide`, `.alignfull`, `.alignleft/right/center`; `.wp-block-image`, `.wp-block-quote` (including `.is-style-large`), `.wp-block-pullquote`, `.wp-block-code/.wp-block-preformatted`, `.wp-block-separator` (wide and dots variants), `.wp-block-button` (solid and outline), `.wp-block-buttons`, `.wp-block-group`, `.wp-block-columns`, `.wp-block-table` (stripes variant), `.wp-block-media-text`, `.wp-block-search`.
- `assets/css/src/main.scss` — `@use` entry point importing all six partials in dependency order.

#### JavaScript
- `assets/js/src/navigation.js` — vanilla JS mobile menu toggle; manages `aria-expanded` state; traps Tab/Shift+Tab focus within open menu with live `getFocusableItems()` query; closes on Escape with focus returned to toggle; closes on click outside.
- `assets/js/src/skip-link-focus.js` — WebKit skip-link focus fix; attaches to all `.skip-link` elements; temporarily sets `tabindex="-1"` on the target element and calls `.focus()`; self-removing `blur` listener restores original state.

#### Build toolchain and CI
- `package.json` — npm scripts matching plan §5.2: `build`, `build:css` (expanded + compressed via Sass), `build:js` (esbuild bundle + minify), `watch`, `lint:php`, `lint:js`, `lint:css`, `lint`, `pot`, `zip`.
- `.nvmrc` — Node 20 LTS pin.
- `.editorconfig` — `indent_style=space`, `indent_size=2`, `end_of_line=lf`, `charset=utf-8`, `trim_trailing_whitespace=true`.
- `phpcs.xml` — `WordPress-Core` and `WordPress-Docs` rulesets; excludes `vendor/` and `node_modules/`; enforces `uppa-base` text domain; targets PHP 8.1+.
- `.github/workflows/lint.yml` — single-job workflow triggered on `pull_request`; runs `npm ci && npm run lint`.
- `.github/workflows/release.yml` — triggered on `v*` tag push; runs `npm ci && npm run build && npm run zip`; deploys to WordPress.org SVN via `10up/action-wordpress-plugin-deploy@stable`.

#### Public hook API (14 hooks)
- Actions: `uppa_before_header`, `uppa_header_open`, `uppa_after_branding`, `uppa_nav_primary`, `uppa_header_close`, `uppa_before_content`, `uppa_after_content`, `uppa_before_footer`, `uppa_footer_widgets`, `uppa_footer_credits`.
- Filters: `uppa_body_classes`, `uppa_post_classes`.
- Extension points: `uppa_enqueue_styles`, `uppa_enqueue_scripts`.
