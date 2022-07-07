<div id="top"></div>

<!-- PROJECT INTRO -->
<br />
<div align="center">

<h3 align="center">Blokki</h3>

  <p align="center">
    Blocks functionality from BJM Digital
    <br />
    <a href="https://github.com/bjmdigital/blokki"><strong>Explore the docs »</strong></a>
    <br />
    <br />
    <a href="https://blokki.wpengine.com/">View Demo</a>
    ·
    <a href="https://github.com/bjmdigital/blokki/issues">Report Bug</a>
    ·
    <a href="https://github.com/bjmdigital/blokki/issues">Request Feature</a>
  </p>
</div>


<!-- TABLE OF CONTENTS -->
<details>
  <summary>Table of Contents</summary>
  <ol>
    <li>
      <a href="#about-the-project">About The Project</a>
    </li>
    <li>
      <a href="#installation">Installation</a>
    </li>
    <li>
      <a href="#getting-started">Getting Started</a>
      <ul>
        <li><a href="#prerequisites">Prerequisites</a></li>
        <li><a href="#setup">Setup</a></li>
        <li><a href="#development">Development</a></li>
        <li><a href="#releasing-update">Releasing Update</a></li>
      </ul>
    </li>
    <li>
        <a href="#blocks">Blocks</a>
        <ul>
            <li><a href="#cards-block">Cards Block</a></li>
            <li><a href="#accordions-block">Accordions Block</a></li>
            <li><a href="#grid-block">Grid Block</a></li>
      </ul>
    </li>
    <li>
        <a href="#block-controls">Block Controls</a>
        <ul>
            <li><a href="#visibility">Visibility</a></li>
            <li><a href="#spacing">Spacing</a></li>
            <li><a href="#link-type">Link Type</a></li>
      </ul>
    </li>
    <li>
        <a href="#usage">Usage</a>
        <ul>
            <li><a href="#cpt-config">CPT Config</a></li>
            <li><a href="#overriding-a-template">Overriding a Template</a></li>
            <li><a href="#creating-a-new-template">Creating a New Template</a></li>
      </ul>
    </li>
    <li>
        <a href="#examples">Examples</a>
        <ul>
            <li><a href="#hypothesis">Hypothesis</a></li>
            <li><a href="#card-config-example">Card config example</a></li>
            <li><a href="#accordion-config-example">Accordion config example</a></li>
            <li><a href="#custom-template-for-cpt">Custom Template for CPT</a></li>
      </ul>
    </li>
    <li><a href="#roadmap">Roadmap</a></li>
    <li><a href="#known-issues">Known Issues</a></li>
    <li><a href="#contributing">Contributing</a></li>
    <li><a href="#license">License</a></li>
    <li><a href="#contact">Contact</a></li>
    <li><a href="#acknowledgments">Acknowledgments</a></li>
  </ol>
</details>


<!-- ABOUT THE PROJECT -->

## About The Project

This plugin provides some blocks' functionality for BJM projects.

<p align="right">(<a href="#top">back to top</a>)</p>

<!-- Installation -->

## Installation

To get the latest installable plugin file, look for the `.zip` in assets of the latest release in
the [Releases](https://github.com/bjmdigital/blokki/releases)

You need to have ACF Pro installed and active on the site where the blokki is to be used.


<!-- GETTING STARTED -->

## Getting Started

Please refer to the following section for setting up your project locally.

### Prerequisites

1. [ACF Pro](https://www.advancedcustomfields.com/pro/) should be installed on the site to use this plugin as it relies on ACF functions for block options and plugin settings.

2. [Composer](https://getcomposer.org/) should be installed on your machine for dependencies autoload for the plugin

3. [Node.js](https://nodejs.org/en/) should also be installed on your machine as we shall need to install some node
   modules using `npm`

### Setup

1. Clone the repo in the plugins directory i.e. **/wp-content/plugins**
   ```sh
   git clone https://github.com/bjmdigital/blokki.git
   ```
2. Change the directory to your cloned repo
   ```sh
   cd blokki
   ```
4. Install NPM packages
   ```sh
   npm install
   ```
5. Install composer dependencies, this will create the `vendor` directory and the `autoload.php` file.
   ```sh
   composer update
   ```

### Development

1. While developing you may use the file watcher by using the command:
   ```sh
   npm run start
   ```
2. After doing all you magic, create the **build** directory with this command
   ```sh
   npm run build
   ```
3. Plugin is created using the [@wordpress/create-block](https://www.npmjs.com/package/@wordpress/create-block), so you
   can update the node dependencies using this command:
   ```sh
   npm run packages-update
   ```
   Complete list of commands can be found
   here: [@wordpress/create-block](https://www.npmjs.com/package/@wordpress/create-block)

### Releasing Updated

Once you have made all the changes and the build directory is created/updated and an update is ready to be released, you
may follow the steps described below.

:warning:
Please remember to update the readme.txt file with the new version number for the plugin as this version number shall be
sued to check for available update.

Follow these Steps:

#### Step 1: Creating Zip

you may run the following command to create a `.zip` file for plugin release:

   ```sh
   npm run plugin-zip
   ```

This command will create a `blokki.zip` file in the repo directory.

#### Step 2: Creating a Release

Go to [Releases](https://github.com/bjmdigital/blokki/releases) section in Github and create a new release. You should
create a new tag name corresponding to the new plugin version number and upload the `blokki.zip` to the release assets.
You may rename the `blokki.zip` to include the version number. e.g. `blokki-v1.0.1.zip`

Once you created a new release, remove the `blokki.zip` file from the plugin repo directory stat was created in Step-1
above.

<p align="right">(<a href="#top">back to top</a>)</p>

## Blocks

The plugin offers primarily 3 blocks:
<ul>
    <li><a href="#cards-block">Cards Block</a></li>
    <li><a href="#accordions-block">Accordions Block</a></li>
    <li><a href="#grid-block">Grid Block</a></li>
</ul>

### Cards Block

This block is to be used for creating a grid of CPT cards. You have many options to configure the block as per need.
Some of the configurations are:

- Block Heading with link (optional)
- Posts Selection
    - Post Type
    - Taxonomy
    - Order
    - Limit
- Layout Options to select the cards in a row for various screens
- Display options to control the visibility of various partials used in the card, like
    - title
    - image
    - meta
    - author etc.
- SEO Schema control to add the Rich data schema for the cards.
    - example: `FAQPage` schema for a certain CPT (you shall need to update Post Type Config using filter hook to use a
      schema )

### Accordions Block

This block is to create accordions for the selected CPTs. Most of the options from Cards Block are also available for
this block like

- Post Selection
- Layout Options
- Heading with link
- SEO Schema

### Grid Block

This block is an alternate for the core `columns` block in gutenberg and has child block `grid-column`
The prime objective is to control the spanning of `grid-column` for different screen sizes.

## Block Controls

The plugin also adds some block level controls to blocks. The controls are added to following block types to avoid
conflicts:

- core blocks
- acf blocks
- blokki blocks

The controls added by plugin are as follows:

### Visibility

Visibility control is added to control the visibility of a block for various screen sizes:

- Hide on Large
- Hide on Medium
- Hide on Small

### Spacing

Spacing controls are added to give a uniformity to spacing for blocks. These include **Padding** and **Margin** controls
with option to set all of set different options for

- All
- Top
- Bottom
- Left
- Right

### Link Type

The plugin also adds a control to open Video in Lightbox to `core/button` and `core/image` blocks. You need to select
the "Link Type" as Video Popup and provide the Youtube or Vimeo video url as the link to the image or button to open the
video in popup.

<!-- USAGE EXAMPLES -->

## Usage

This plugin extensively use [action and filter hooks](https://developer.wordpress.org/plugins/hooks/) and thus provides
an opportunity to pass post type configurations for cards and accordions.

### CPT Config

Following are the possible values and defaults that can be used to configure CPT card/accordion display.

#### Card

```php
$post_type_config_cards =  array(
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

**Note:** Please notice the `template` is set to `card`, so it will look for the `partials`
under `templates/card/partials`

#### Accordion

```php
$post_type_config_accordions = array(
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

### Overriding a Template

Plugin make use of template partials to build the markup of a card/accordion. These **templates** are located
here : 
```
wp-content/plugins/blokki/templates
```

If you need to override any template partial, you shall need to create a directory `blokki` in your theme directory and
then create a file with same name and folder structure to override the one provided by the plugin.

For instance, if you want to override the following template partial file:
```
wp-content/plugins/blokki/templates/partials/card/image.php
```

then, you shall need to create a file in your theme with following structure:
```
wp-content/your-theme/blokki/partials/card/image.php
```

### Creating a New Template

If you need an entirely new template partial, then you can follow the method described in the
section [Overriding a Template](#overriding-a-template) and create a new file with any name and then use this file name
in the `partials` defined in the CPT config. 

More on this in Example for [Custom Template for CPT](#custom-template-for-cpt)

<p align="right">(<a href="#top">back to top</a>)</p>

## Examples

In this section, we shall provide various examples and use cases to use the filter hooks to configure CPTs.

### Hypothesis

In these examples, we shall assume that we have these registered CPTs `bjm_resource`, `bjm_faq` and `bjm_document` for
the site.

- `bjm_resource` shall need to be displayed using *card* template
- `bjm_faq` shall be displayed using *accordion* template
- `bjm_document` shall use a *custom template* to show the CPT card

### Card config example

We shall make use of the filter hook `blokki_get_post_type_config_{CPT}` to configure `bjm_resource` CPT to:

- Use the *card* template
- do not show readmore
- do not show image
- title html tag to use *h4*

```php
add_filter( 'blokki_get_post_type_config_bjm_resource', function ( $post_type_config ) {

	$post_type_config = [
		'template'      => 'card', // this is default, adding it only for demonstration
		'show_readmore' => false,
		'show_image'    => false,
		'title_html_tag'=> 'h4'
	];

	return $post_type_config;

} );
```

### Accordion config example

We shall make use of the filter hook `blokki_get_post_type_config_{CPT}` to configure `bjm_faq` CPT to:

- Use the *accordion* template
- remove link to the post title
- use `FAQPage` schema for the CPT loop in the blocks

```php
add_filter( 'blokki_get_post_type_config_bjm_faq', function ( $post_type_config ) {
	$post_type_config = [
		'template'    => 'accordion',
		'link_title'  => false,
		'loop_schema' => 'FAQPage'
	];
	return $post_type_config;
} );
```

### Custom Template for CPT

In this example, we suppose that we do not want to use either *card* or *accordion* template, rather we want to
create our own template for the `bjm_document` CPT.

In this case, we shall need to create a file in our theme directory with following structure:
```
wp-content/your-theme/blokki/partials/card/document-info.php
```

The file `document-info.php` shall be used to output the markup for the card of CPT `bjm_document`.

now, to make use of this created file, we need to use the filter as follows:

```php
add_filter( 'blokki_get_post_type_config_bjm_document', function ( $post_type_config ) {

	$post_type_config = [
        'partials'      => [
            'document-info'
		],
        'template'      => 'card' // default value, added just for explanation 
		'taxonomy'      => 'bjm_document_category', // optional, a custom taxonomy to display in this CPT card
		'show_meta'     => false, // optional
		'show_readmore' => false, // optional
		'show_image'    => false, // optional
		'link_card'     => false, // optional
		'link_image'    => false, // optional
		'link_title'    => false, // optional
	];

	return $post_type_config;

} );
```

<!-- ROADMAP -->

## Roadmap

- [ ] Plugin Auto Update Feature
- [ ] Link Type to open Modal
- [ ] Breakpoints override
- [ ] More Schema options for CPT
- [ ] Pagination `rel` tags

See the [open issues](https://github.com/bjmdigital/blokki/issues) for a full list of proposed features (and known
issues).

<p align="right">(<a href="#top">back to top</a>)</p>

<!-- Known Issues -->

## Known Issues

- Blokki plugin is not compatible with BJM Blocks.

<!-- CONTRIBUTING -->

## Contributing

This plugin is primarily developed for use on BJM Projects and the site we build for clients. Please remember that we
only intend to add a feature if we consider it to be beneficial for our own use case.

Contributions are what make the open source community such an amazing place to learn, inspire, and create. Any
contributions you make are **greatly appreciated**.

If you have a suggestion that would make this better, please fork the repo and create a pull request. You can also
simply open an issue with the tag "enhancement". Don't forget to give the project a star! Thanks again!

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

<p align="right">(<a href="#top">back to top</a>)</p>


<!-- LICENSE -->

## License

Distributed under the GPL-3.0 License. See `LICENSE.txt` for more information.


<p align="right">(<a href="#top">back to top</a>)</p>



<!-- CONTACT -->

## Contact

<div align="center">

<h3 align="center">BJM Digital</h3>

  <p align="center">
    <a href="https://twitter.com/bjm_digital">Twitter</a>
    ·
    <a href="https://www.linkedin.com/company/bjm-design/">Linkedin</a>
    ·
    <a href="https://www.facebook.com/BJMDigital/">Facebook</a>
    ·
    <a href="https://www.instagram.com/bjmdigital/">Instagram</a>
    ·
    <a href="mailto:contact@bjmdigital.com.au">Email</a>
  </p>
</div>

<p align="right">(<a href="#top">back to top</a>)</p>


<!-- ACKNOWLEDGMENTS -->

## Acknowledgments

* [@wordpress/create-block](https://www.npmjs.com/package/@wordpress/create-block)
* [Gamajo-Template-Loader](https://github.com/GaryJones/Gamajo-Template-Loader)
* [Best-README-Template](https://github.com/othneildrew/Best-README-Template)

<p align="right">(<a href="#top">back to top</a>)</p>
