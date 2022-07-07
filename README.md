<div id="top"></div>

<!-- PROJECT SHIELDS -->
[![Contributors][contributors-shield]][contributors-url]
[![Stargazers][stars-shield]][stars-url]
[![Issues][issues-shield]][issues-url]
[![GNU License][license-shield]][license-url]


<!-- PROJECT INTRO -->
<br />
<div align="center">

<h3 align="center">Blokki</h3>

  <p align="center">
    a WordPress Plugin by BJM
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
      <a href="#getting-started">Getting Started</a>
      <ul>
        <li><a href="#prerequisites">Prerequisites</a></li>
        <li><a href="#installation">Installation</a></li>
        <li><a href="#development">Development</a></li>
      </ul>
    </li>
    <li><a href="#usage">Usage</a></li>
    <li><a href="#roadmap">Roadmap</a></li>
    <li><a href="#contributing">Contributing</a></li>
    <li><a href="#license">License</a></li>
    <li><a href="#contact">Contact</a></li>
    <li><a href="#acknowledgments">Acknowledgments</a></li>
  </ol>
</details>


<!-- ABOUT THE PROJECT -->
## About The Project

This plugin provides some blocks functionality for BJM projects.

<p align="right">(<a href="#top">back to top</a>)</p>



<!-- GETTING STARTED -->
## Getting Started

Please refer to the following section for setting up your project locally.

### Prerequisites

* ACF Pro
 You should have the ACF Pro installed on the site to use this plugin as it relies on ACF functions for block options and plugin settings.

* Composer
 [Composer](https://getcomposer.org/) should be installed on your machine for dependencies autoload for the plugin  

* node
 [node](https://nodejs.org/en/) should also be installed on your machine as we shall need to install some node modules using `npm`
  ```sh
  npm install npm@latest -g
  ```

### Installation

1. Clone the repo in your plugins directory i.e. **/wp-content/plugins**
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

1. While developing you may use the watcher by using the command:
   ```sh
   npm run start
   ```
2. After doing all you magic, create the **build** directory with this command
   ```sh
   npm run build
   ```
3. Plugin is created using the [@wordpress/create-block](https://www.npmjs.com/package/@wordpress/create-block), so you can update the node dependencies using this command:
   ```sh
   npm run packages-update
   ```
   Complete list of commands can be found here: [@wordpress/create-block](https://www.npmjs.com/package/@wordpress/create-block)


<p align="right">(<a href="#top">back to top</a>)</p>



<!-- USAGE EXAMPLES -->
## Usage

Use this space to show useful examples of how a project can be used. Additional screenshots, code examples and demos work well in this space. You may also link to more resources.

_For more examples, please refer to the [Documentation](https://example.com)_

<p align="right">(<a href="#top">back to top</a>)</p>



<!-- ROADMAP -->
## Roadmap

- [ ] Feature 1
- [ ] Feature 2
- [ ] Feature 3
   - [ ] Nested Feature

See the [open issues](https://github.com/bjmdigital/blokki/issues) for a full list of proposed features (and known issues).

<p align="right">(<a href="#top">back to top</a>)</p>



<!-- CONTRIBUTING -->
## Contributing

Contributions are what make the open source community such an amazing place to learn, inspire, and create. Any contributions you make are **greatly appreciated**.

If you have a suggestion that would make this better, please fork the repo and create a pull request. You can also simply open an issue with the tag "enhancement".
Don't forget to give the project a star! Thanks again!

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

<p align="right">(<a href="#top">back to top</a>)</p>



<!-- LICENSE -->
## License

Distributed under the MIT License. See `LICENSE.txt` for more information.

<p align="right">(<a href="#top">back to top</a>)</p>



<!-- CONTACT -->
## Contact

Your Name - [@bjm_digital](https://twitter.com/bjm_digital) - contact@bjmdigital.com.au

Project Link: [https://github.com/bjmdigital/blokki](https://github.com/bjmdigital/blokki)

<p align="right">(<a href="#top">back to top</a>)</p>



<!-- ACKNOWLEDGMENTS -->
## Acknowledgments

* []()
* []()
* []()

<p align="right">(<a href="#top">back to top</a>)</p>



<!-- MARKDOWN LINKS & IMAGES -->
<!-- https://www.markdownguide.org/basic-syntax/#reference-style-links -->
[contributors-shield]: https://img.shields.io/github/contributors/bjmdigital/blokki.svg?style=for-the-badge
[contributors-url]: https://github.com/bjmdigital/blokki/graphs/contributors
[forks-shield]: https://img.shields.io/github/forks/bjmdigital/blokki.svg?style=for-the-badge
[forks-url]: https://github.com/bjmdigital/blokki/network/members
[stars-shield]: https://img.shields.io/github/stars/bjmdigital/blokki.svg?style=for-the-badge
[stars-url]: https://github.com/bjmdigital/blokki/stargazers
[issues-shield]: https://img.shields.io/github/issues/bjmdigital/blokki.svg?style=for-the-badge
[issues-url]: https://github.com/bjmdigital/blokki/issues
[license-shield]: https://img.shields.io/github/license/bjmdigital/blokki.svg?style=for-the-badge
[license-url]: https://github.com/bjmdigital/blokki/blob/master/LICENSE.txt
[linkedin-shield]: https://img.shields.io/badge/-LinkedIn-black.svg?style=for-the-badge&logo=linkedin&colorB=555
[linkedin-url]: https://linkedin.com/in/bjm-design
[product-screenshot]: images/screenshot.png
[Next.js]: https://img.shields.io/badge/next.js-000000?style=for-the-badge&logo=nextdotjs&logoColor=white
[Next-url]: https://nextjs.org/
[React.js]: https://img.shields.io/badge/React-20232A?style=for-the-badge&logo=react&logoColor=61DAFB
[React-url]: https://reactjs.org/
[Vue.js]: https://img.shields.io/badge/Vue.js-35495E?style=for-the-badge&logo=vuedotjs&logoColor=4FC08D
[Vue-url]: https://vuejs.org/
[Angular.io]: https://img.shields.io/badge/Angular-DD0031?style=for-the-badge&logo=angular&logoColor=white
[Angular-url]: https://angular.io/
[Svelte.dev]: https://img.shields.io/badge/Svelte-4A4A55?style=for-the-badge&logo=svelte&logoColor=FF3E00
[Svelte-url]: https://svelte.dev/
[Laravel.com]: https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white
[Laravel-url]: https://laravel.com
[Bootstrap.com]: https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white
[Bootstrap-url]: https://getbootstrap.com
[JQuery.com]: https://img.shields.io/badge/jQuery-0769AD?style=for-the-badge&logo=jquery&logoColor=white
[JQuery-url]: https://jquery.com

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

#### Cards
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
#### Accordions
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

## Known Issues 

- Blokki plugin is not compatible with BJM Blocks.