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

Once you have done all the build and plugin is ready to be released, you may run the following command to create a `.zip` file for plugin release:

 1. `npm run plugin-zip`
 2. Cut the `.zip` file and upload to the repo release


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

##Change Log

**1.0.1**
- Dev: Updated npm packages to the latest versions
- Dev: Ability to create `.zip` file for plugin release
- Dev: Code Optimization and Refactoring
- Fix: Blokki block controls for spacing and visibility only to core, acf and blokki block types
- Fix: composer autoload path
- Fix: visibility and spacing controls not adding CSS classes
- Fix: Block alignment class added to social share block
- Schema Feature: 
  - FAQPage Schema added for accordion block
  - Added ItemList schema for cards block
  - Option to turn off schema in plugin settings
  - Option to disable schema on Cards block
  - Caching System for Schema added by plugin for speed optimization

**1.0.0**
- Initial Release of plugin

## Known Issues 

- Blokki plugin is not compatible with BJM Blocks.