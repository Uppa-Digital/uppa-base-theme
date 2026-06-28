# Changelog

All notable changes to UPPA Base will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.0.0] - 2024-01-01

### Added
- Initial theme scaffold with complete file and folder structure.
- Core template files: `index.php`, `single.php`, `page.php`, `archive.php`, `search.php`, `404.php`, `comments.php`.
- `inc/` feature files: `setup.php`, `enqueue.php`, `nav-walkers.php`, `template-tags.php`, `hooks.php`, `accessibility.php`, `compat.php`.
- Sass source partials: `_tokens.scss`, `_reset.scss`, `_typography.scss`, `_layout.scss`, `_navigation.scss`, `_blocks.scss`.
- JavaScript source files: `navigation.js`, `skip-link-focus.js`.
- Bootstrap-compatible `UPPA_Base_Nav_Walker`.
- Accessibility skip-link template part.
- Breadcrumb template part with uppa-core fallback.
- GitHub Actions workflows for linting and releasing.
- `package.json` build toolchain (Sass, esbuild, clean-css, ESLint, Stylelint).
- `phpcs.xml` enforcing WordPress Coding Standards with `uppa-base` prefix rules.
