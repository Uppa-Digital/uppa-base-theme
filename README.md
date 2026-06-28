# UPPA Base Theme

WordPress Base theme for all Uppa-Digital WordPress Projects.

## Requirements

| Requirement | Version |
|---|---|
| WordPress | 6.4+ |
| PHP | 8.1+ |
| Node | 20 (see `.nvmrc`) |

## Getting Started

```bash
# Install Node dependencies
nvm use
npm install

# Build assets (one-off)
npm run build

# Watch Sass during development
npm run watch
```

## Directory Structure

```
uppa-base-theme/
├── assets/          # CSS (Sass), JS, and images
│   ├── css/src/     # Sass source — edit these
│   └── css/dist/    # Compiled output — do not edit
├── inc/             # PHP feature files (loaded by functions.php)
├── template-parts/  # Reusable template fragments
├── languages/       # Translation files (.pot/.po/.mo)
└── .github/         # CI/CD workflows
```

## Child Themes

Set `Template: uppa-base` in your child theme's `style.css` header. All
functions in `inc/` are prefixed `uppa_base_` and can be overridden via
standard WordPress hooks or by redeclaring them in the child theme.

## Coding Standards

```bash
# PHP
composer install
vendor/bin/phpcs

# CSS/JS
npm run lint:css
npm run lint:js
```

## Releasing

Push a semver tag (`v1.2.3`) to `main`. The `release.yml` workflow will build
the theme, create a GitHub Release, and push to WP.org SVN (requires
`SVN_USERNAME` and `SVN_PASSWORD` repository secrets).

## License

GNU General Public License v2 or later — see [LICENSE](https://www.gnu.org/licenses/gpl-2.0.html).
