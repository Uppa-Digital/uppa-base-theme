/**
 * Build script: create a clean release zip for WordPress.org submission.
 *
 * Produces: release/uppa-base-<version>.zip
 * Excludes: source files, dev tooling, and git metadata that must not be
 * shipped to WP.org (as required by the theme review guidelines).
 */

const { execSync } = require( 'child_process' );
const { existsSync, mkdirSync, readFileSync } = require( 'fs' );
const path = require( 'path' );

const root = path.resolve( __dirname, '..' );
const pkg  = JSON.parse( readFileSync( path.join( root, 'package.json' ), 'utf8' ) );
const ver  = pkg.version;
const out  = path.join( root, 'release' );
const zip  = path.join( out, `uppa-base-${ ver }.zip` );

if ( ! existsSync( out ) ) {
	mkdirSync( out, { recursive: true } );
}

const excludes = [
	'.git',
	'.github',
	'node_modules',
	'vendor',
	'release',
	'scripts',
	'assets/css/src',
	'assets/js/src',
	'package.json',
	'package-lock.json',
	'.nvmrc',
	'.editorconfig',
	'phpcs.xml',
	'eslint.config.js',
	'.stylelintrc.json',
	'README.md',
	'CHANGELOG.md',
].map( ( p ) => `--exclude="${ p }/*" --exclude="${ p }"` ).join( ' ' );

const cmd = `cd "${ root }" && zip -r "${ zip }" . ${ excludes }`;
console.log( `Creating ${ zip }` );
execSync( cmd, { stdio: 'inherit' } );
console.log( 'Done.' );
