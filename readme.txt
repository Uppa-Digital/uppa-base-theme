=== UPPA Base ===

Contributors:      uppadigital
Tags:              custom-menu, custom-logo, block-styles, wide-blocks, accessibility-ready, translation-ready
Requires at least: 6.4
Tested up to:      6.7
Requires PHP:      8.1
Stable tag:        1.0.0
License:           GPLv2 or later
License URI:       https://www.gnu.org/licenses/gpl-2.0.html

A lightweight, hook-driven parent theme for agency-built WordPress sites.

== Description ==

UPPA Base is a minimal WordPress parent theme built around a single principle: the parent should own
structure, and nothing else. Colours, typography choices, logos, and business logic belong in a child
theme or a companion plugin — not in the parent.

At its core, UPPA Base provides a CSS custom-property token system that child themes override in a
single :root block, a documented set of 14 action and filter hooks that act as a stable public API
for child-theme customisation, an accessibility-ready foundation including a skip link, semantic
landmark roles, and WCAG 2.1 AA focus styles, and a Gutenberg-compatible layout layer with
alignwide, alignfull, and core block style overrides.

Agency teams use UPPA Base as the single parent across all client sites. Each client receives a
private child theme — a thin layer containing only brand tokens, bespoke templates, and client-
specific logic. Because all structural fixes and accessibility improvements land in the parent, every
client site benefits from a single update. There is no duplication across projects.

UPPA Base is deliberately incomplete on its own. Install it, then create or install a child theme
before activating on a live site. For advanced functionality such as custom post types, ACF field
groups, and payment integrations, pair it with the free uppa-core companion plugin.

== Installation ==

1. Download the theme zip from WordPress.org or your GitHub release.
2. In WordPress admin go to Appearance → Themes → Add New → Upload Theme.
3. Upload the zip and click Install Now, then Activate.
4. Create a child theme with `Template: uppa-base` in its style.css header.
5. Activate the child theme instead of UPPA Base directly.

== Frequently Asked Questions ==

= Do I activate UPPA Base directly on a live site? =

No. UPPA Base is a parent theme and is intentionally unstyled on its own. Always create a child
theme that sets your brand tokens in :root and activate the child theme. UPPA Base will be loaded
automatically as the parent. Activating the parent directly will result in a visually bare site.

= How do I change colours, fonts, or the logo? =

Override the CSS custom properties in your child theme's style.css :root block. Every colour and
spacing value in UPPA Base is expressed as a var(--token) reference, so a handful of :root
declarations in the child stylesheet are all that is needed. For example:

  :root {
    --color-primary: #1A3C5E;
    --color-accent:  #F4A520;
    --container-max: 1440px;
  }

No selector overrides or !important rules are required.

= How do I replace the primary navigation with my own? =

Remove the default callback and register your own on the same hook:

  remove_action( 'uppa_nav_primary', 'uppa_render_nav_primary' );
  add_action( 'uppa_nav_primary', 'my_child_theme_nav' );

The same pattern applies to all 14 documented action hooks. See the Hook Reference in README.md for
the full list with priority values and usage examples.

== Screenshots ==

1. Front page showing the header, navigation, content area, and footer with default tokens applied.

== Changelog ==

= 1.0.0 =
* Initial release.
* CSS custom-property token system covering spacing, type scale, colour, and layout.
* 14 documented action and filter hooks as a public child-theme API.
* Accessibility-ready skip link, ARIA landmark roles, and WCAG 2.1 AA focus styles.
* Gutenberg block style overrides: image, quote, pullquote, code, separator, button, group, columns, table, media-text, search.
* Mobile-first navigation with hamburger toggle, focus trap, and keyboard dismiss.
* Translation-ready POT file location: languages/uppa-base.pot.

== Upgrade Notice ==

= 1.0.0 =
Initial release. No upgrade path required.
