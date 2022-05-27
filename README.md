# Blokki

## Changes Required to start Development:

1. After Adding more files as you go, use composer to update autoload if you need to. You shall need to have composer
   installed on your computer. In Terminal in the plugin directory, run following:
    * `composer update`

1. To install NPM dependencies, run the following command:
    * `npm install`

1. After doing all the magic of coding, run:
    * `npm run build`

1. While developing you may use the watcher by using the command:
    * `npm run start`

1. To Updates WordPress packages to the latest version:
    * `npm run packages-update`

1. Complete list of commands can be found
   here: [https://www.npmjs.com/package/@wordpress/create-block](https://www.npmjs.com/package/@wordpress/create-block)

## Steps required to release plugin:

Once you have done all the build and plugin is ready to be released, you may follow these steps to issue the new plugin
release:

1. Clone the repo toa new location probably your desktop:
    * `git clone your_repo_link.git`

2. Run Composer Update to build and install composer dependencies:
    * `composer update`
3. install npm modules and run build
    * `npm install`
    * `npm run build`

4. Once everything is built, you should remove the git directories, node_modules and other unnecessary directories:
    * `find . | grep .git | xargs rm -rf` to remove all git related files and directories
    * `rm node_modules -r` to remove all node modules since these are not required after the build process is done.
    * `rm composer.lock` optionally remove composer lock file
    * `rm package-lock.json` optionally remove npm package lock file

### Post Type Config Possible values and defaults

####Cards
```php
$post_type_config_cards =
	array(
		'show_title'     => true,
		'show_image'     => true,
		'show_excerpt'   => true,
		'show_readmore'  => true,
		'show_meta'      => true,
		'show_date'      => true,
		'show_author'    => true,
		'show_taxonomy'  => true,
		'show_inner'     => true,
		'show_content'   => false,
		'link_card'      => false,
		'link_title'     => true,
		'link_target'    => '_self',
		'link_taxonomy'  => false,
		'card_html_tag'  => 'div',
		'taxonomy'       => '',
		'schema'         => '',
		'loop_schema'    => '',
		'template'       => 'card',
		'image_size'     => 'medium_large',
		'link_image'     => true,
		'title_html_tag' => 'h3',
		'partials'       => array(
			'image',
			'inner' => array(
				'title',
				'meta' => array(
					'date',
					'taxonomy',
					'author',
				),
				'excerpt',
				'readmore',
			),
		),
	);

```
####Accordions
```php

$post_type_config_accordions =
array(
	'show_title'     => true,
	'show_content'   => true,
	'link_card'      => false,
	'link_title'     => true,
	'link_target'    => '_self',
	'link_taxonomy'  => false,
	'card_html_tag'  => 'div',
	'taxonomy'       => '',
	'schema'         => '',
	'loop_schema'    => '',
	'template'       => 'accordion',
	'title_html_tag' => 'span',
	'partials'       => array(
		'accordion-button'  => array(
			'title',
		),
		'accordion-content' => array(
			'content',
		),
	),
);

```