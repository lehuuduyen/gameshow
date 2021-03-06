<?php
	return [
		/*
		|--------------------------------------------------------------------------
		| Module Namespace
		|--------------------------------------------------------------------------
		|
		| Default module namespace.
		|
		*/
		'namespace' => 'Modules',
		/*
		|--------------------------------------------------------------------------
		| Module Stubs
		|--------------------------------------------------------------------------
		|
		| Default module stubs.
		|
		*/
		'stubs' => [
			'enabled'      => FALSE,
			'path'         => base_path() . '/vendor/nwidart/laravel-modules/src/Commands/stubs',
			'files'        => [
				'start'           => 'start.php',
				'routes'          => 'Http/routes.php',
				'views/index'     => 'Resources/views/index.blade.php',
				'views/master'    => 'Resources/views/layouts/master.blade.php',
				'scaffold/config' => 'Config/config.php',
				'composer'        => 'composer.json',
			],
			'replacements' => [
				'start'           => [
					'LOWER_NAME',
					'ROUTES_LOCATION'
				],
				'routes'          => [
					'LOWER_NAME',
					'STUDLY_NAME',
					'MODULE_NAMESPACE'
				],
				'json'            => [
					'LOWER_NAME',
					'STUDLY_NAME',
					'MODULE_NAMESPACE'
				],
				'views/index'     => [ 'LOWER_NAME' ],
				'views/master'    => [ 'STUDLY_NAME' ],
				'scaffold/config' => [ 'STUDLY_NAME' ],
				'composer'        => [
					'LOWER_NAME',
					'STUDLY_NAME',
					'VENDOR',
					'AUTHOR_NAME',
					'AUTHOR_EMAIL',
					'MODULE_NAMESPACE',
				],
			],
			'gitkeep'      => TRUE,
		],
		'paths' => [
			/*
			|--------------------------------------------------------------------------
			| Modules path
			|--------------------------------------------------------------------------
			|
			| This path used for save the generated module. This path also will be added
			| automatically to list of scanned folders.
			|
			*/
			'modules' => base_path( 'Modules' ),
			/*
			|--------------------------------------------------------------------------
			| Modules assets path
			|--------------------------------------------------------------------------
			|
			| Here you may update the modules assets path.
			|
			*/
			'assets' => public_path( 'modules' ),
			/*
			|--------------------------------------------------------------------------
			| The migrations path
			|--------------------------------------------------------------------------
			|
			| Where you run 'module:publish-migration' command, where do you publish the
			| the migration files?
			|
			*/
			'migration' => base_path( 'database/migrations' ),
			/*
			|--------------------------------------------------------------------------
			| Generator path
			|--------------------------------------------------------------------------
			| Customise the paths where the folders will be generated.
			| Set the generate key to false to not generate that folder
			*/
			'generator' => [
				'config'        => [
					'path'     => 'Config',
					'generate' => TRUE
				],
				'command'       => [
					'path'     => 'Console',
					'generate' => TRUE
				],
				'migration'     => [
					'path'     => 'Database/Migrations',
					'generate' => TRUE
				],
				'seeder'        => [
					'path'     => 'Database/Seeders',
					'generate' => TRUE
				],
				'factory'       => [
					'path'     => 'Database/factories',
					'generate' => TRUE
				],
				'model'         => [
					'path'     => 'Entities',
					'generate' => TRUE
				],
				'controller'    => [
					'path'     => 'Http/Controllers',
					'generate' => TRUE
				],
				'filter'        => [
					'path'     => 'Http/Middleware',
					'generate' => TRUE
				],
				'request'       => [
					'path'     => 'Http/Requests',
					'generate' => TRUE
				],
				'provider'      => [
					'path'     => 'Providers',
					'generate' => TRUE
				],
				'assets'        => [
					'path'     => 'Resources/assets',
					'generate' => TRUE
				],
				'lang'          => [
					'path'     => 'Resources/lang',
					'generate' => TRUE
				],
				'views'         => [
					'path'     => 'Resources/views',
					'generate' => TRUE
				],
				'test'          => [
					'path'     => 'Tests',
					'generate' => TRUE
				],
				'repository'    => [
					'path'     => 'Repositories',
					'generate' => FALSE
				],
				'event'         => [
					'path'     => 'Events',
					'generate' => FALSE
				],
				'listener'      => [
					'path'     => 'Listeners',
					'generate' => FALSE
				],
				'policies'      => [
					'path'     => 'Policies',
					'generate' => FALSE
				],
				'rules'         => [
					'path'     => 'Rules',
					'generate' => FALSE
				],
				'jobs'          => [
					'path'     => 'Jobs',
					'generate' => FALSE
				],
				'emails'        => [
					'path'     => 'Emails',
					'generate' => FALSE
				],
				'notifications' => [
					'path'     => 'Notifications',
					'generate' => FALSE
				],
				'resource'      => [
					'path'     => 'Transformers',
					'generate' => FALSE
				],
			],
		],
		/*
		|--------------------------------------------------------------------------
		| Scan Path
		|--------------------------------------------------------------------------
		|
		| Here you define which folder will be scanned. By default will scan vendor
		| directory. This is useful if you host the package in packagist website.
		|
		*/
		'scan' => [
			'enabled' => FALSE,
			'paths'   => [
				base_path( 'vendor/*/*' ),
			],
		],
		/*
		|--------------------------------------------------------------------------
		| Composer File Template
		|--------------------------------------------------------------------------
		|
		| Here is the config for composer.json file, generated by this package
		|
		*/
		'composer' => [
			'vendor' => 'nwidart',
			'author' => [
				'name'  => 'Nicolas Widart',
				'email' => 'n.widart@gmail.com',
			],
		],
		/*
		|--------------------------------------------------------------------------
		| Caching
		|--------------------------------------------------------------------------
		|
		| Here is the config for setting up caching feature.
		|
		*/
		'cache'    => [
			'enabled'  => FALSE,
			'key'      => 'laravel-modules',
			'lifetime' => 60,
		],
		/*
		|--------------------------------------------------------------------------
		| Choose what laravel-modules will register as custom namespaces.
		| Setting one to false will require you to register that part
		| in your own Service Provider class.
		|--------------------------------------------------------------------------
		*/
		'register' => [
			'translations' => TRUE,
			/**
			 * load files on boot or register method
			 *
			 * Note: boot not compatible with asgardcms
			 *
			 * @example boot|register
			 */
			'files'        => 'register',
		],
	];
