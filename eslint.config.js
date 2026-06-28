const globals = require( 'globals' );

/** @type {import('eslint').Linter.Config[]} */
module.exports = [
	{
		files: [ 'assets/js/src/**/*.js' ],
		languageOptions: {
			ecmaVersion: 2020,
			sourceType: 'script', // Theme JS is loaded as classic scripts, not ESM.
			globals: {
				...globals.browser,
				wp: 'readonly', // WordPress global exposed by wp_enqueue_script.
			},
		},
		rules: {
			// Errors
			'no-undef':           'error',
			'no-unused-vars':     [ 'error', { argsIgnorePattern: '^_' } ],
			'no-console':         'warn',

			// Match WordPress JS coding standards
			'eqeqeq':             [ 'error', 'always' ],
			'no-var':             'error',
			'prefer-const':       'error',
			'object-shorthand':   'error',
			'no-trailing-spaces': 'error',
			'semi':               [ 'error', 'always' ],
			'quotes':             [ 'error', 'single', { avoidEscape: true } ],
			'indent':             [ 'error', 'tab' ],
		},
	},
];
