const globals = require( 'globals' );

const sharedRules = {
	'no-undef':           'error',
	'no-unused-vars':     [ 'error', { argsIgnorePattern: '^_' } ],
	'no-console':         'warn',
	'eqeqeq':             [ 'error', 'always' ],
	'no-var':             'error',
	'prefer-const':       'error',
	'object-shorthand':   'error',
	'no-trailing-spaces': 'error',
	'semi':               [ 'error', 'always' ],
	'quotes':             [ 'error', 'single', { avoidEscape: true } ],
	'indent':             [ 'error', 'tab' ],
};

const sharedGlobals = {
	...globals.browser,
	wp: 'readonly',
};

/** @type {import('eslint').Linter.Config[]} */
module.exports = [
	// Entry point uses ES module import syntax (consumed by esbuild, not the browser).
	{
		files: [ 'assets/js/src/main.js' ],
		languageOptions: {
			ecmaVersion: 2020,
			sourceType: 'module',
			globals: sharedGlobals,
		},
		rules: sharedRules,
	},
	// Source modules are classic scripts loaded directly by WordPress.
	{
		files: [ 'assets/js/src/!(main).js' ],
		languageOptions: {
			ecmaVersion: 2020,
			sourceType: 'script',
			globals: sharedGlobals,
		},
		rules: sharedRules,
	},
];
