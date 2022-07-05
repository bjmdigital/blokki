<?php

namespace Blokki;

/**
 * This class will create meta boxes for Shortcodes
 *
 * @package    Blokki
 * @subpackage Blokki/includes
 */
class AcfBlocks {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * @var array a list of removed blocks
	 */
	private $removed_blocks = [];

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $plugin_name The name of the plugin.
	 * @param string $version The version of this plugin.
	 *
	 * @since    1.0.0
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

		$this->register_acf_options();
		$this->register_hooks();

	}

	/**
	 * Register ACF Options
	 */
	public function register_acf_options() {


		if ( ! function_exists( 'acf_add_options_page' ) ) {
			return null;
		}

		acf_add_options_page(
			[
				'page_title' => esc_html__( 'Blokki Settings', 'blokki' ),
				'menu_title' => esc_html__( 'Blokki', 'blokki' ),
				'menu_slug'  => 'blokki-settings',
				'capability' => 'manage_options',
				'icon_url'   => 'dashicons-image-filter'
			]
		);

	}

	/**
	 * Register required hooks
	 */
	public function register_hooks() {


		/**
		 * Set location to load acf data from
		 */
		add_filter( 'acf/settings/load_json', [ $this, 'acf_add_json_path' ] );

		/**
		 * Update location for
		 */
		add_action( 'acf/update_field_group', [ $this, 'acf_group_save_path_correction' ], 1, 1 );


		/**
		 * Register ACF Blocks
		 */
		add_action( 'acf/init', [ $this, 'register_blocks_with_acf' ] );


		/**
		 * Add wp_block to the ACF post types
		 */
		add_filter( 'acf/get_post_types', [ $this, 'acf_add_blocks_to_post_types' ] );

		// include new field types
		add_action( 'acf/include_field_types', [ $this, 'include_field' ] ); // v5
		add_action( 'acf/register_fields', [ $this, 'include_field' ] ); // v4


		/**
		 * Dynamically update field choices
		 */
		add_filter( 'acf/load_field/name=post_type', [ $this, 'acf_field_choices_post_type' ] );
		add_filter( 'acf/load_field/name=additional_taxonomy_filtering_1', [ $this, 'acf_field_choices_taxonomies' ] );
		add_filter( 'acf/load_field/name=additional_taxonomy_filtering_2', [ $this, 'acf_field_choices_taxonomies' ] );
//		add_filter( 'acf/load_field/name=tax_query', [ $this, 'acf_field_choices_taxonomy_list' ] );


	}

	/*
	*  include_field
	*
	*  This function will include the field type class
	*
	*  @param	$version (int) major ACF version. Defaults to false
	*  @return	void
	*/

	function include_field( $version = false ) {

		$include_field_settings = array(
			'version' => BLOKKI_VERSION,
			'url'     => plugin_dir_url( BLOKKI_PLUGIN_FILE ),
			'path'    => plugin_dir_path( BLOKKI_PLUGIN_FILE )
		);

		/**
		 * Multiple Taxonomy Terms
		 */
		new ACF_Field_Multiple_Taxonomy_Terms( $include_field_settings );
	}

	/**
	 * Add JSO Path for ACF Fields
	 * @hooked acf/settings/load_json
	 */
	public function acf_add_json_path( $paths ) {

		$paths[] = blokki_acf_json_path();

		return $paths;

	}

	/**
	 * When field group is updated check for group type i.e. theme vs plugin, then save in the appropriate location
	 */
	public function acf_group_save_path_correction( $group ) {

		if ( strpos( $group['title'], 'Blokki' ) ) {
			add_action( 'acf/settings/save_json', 'blokki_acf_json_path', 9999 );

			return $group;
		} else {
			return $group;
		}

	}

	/**
	 * Register ACF Blocks
	 *
	 * @hooked acf/init
	 */
	public function register_blocks_with_acf() {

		/**
		 * If we do not have ACF activated, bail out early
		 */
		if ( ! function_exists( 'acf_register_block' ) ) {
			return null;
		}

		$remove_blocks = $this->get_removed_blocks();

		$blocks_to_register = $this->get_acf_blocks_config();

		if ( ! is_array( $blocks_to_register ) || empty( $blocks_to_register ) ) {
			return null;
		}

		foreach ( $blocks_to_register as $block ):

			$block_name = $block['name'] ?? null;

			/**
			 * If this block name is in $remove_blocks, continue
			 */
			if ( ! $block_name || in_array( "acf/$block_name", $remove_blocks, true ) ) {
				continue;
			}

			/**
			 * Set a render template if not defined
			 */
			if ( ! isset( $block['render_template'] ) ) {
				$block['render_template'] = blokki_locate_template( "blocks/{$block_name}.php" );
			}

			acf_register_block_type( $block );


		endforeach;


	}

	/**
	 * Get removed blocks
	 */
	public function get_removed_blocks() {

		return apply_filters( 'blokki_remove_block_types', $this->removed_blocks );

	}

	/**
	 * Get ACF blocks config array
	 */
	public function get_acf_blocks_config() {

		$blocks = [];

		$blocks[] = [
			'name'        => 'cards',
			'title'       => __( 'Blokki Cards' ),
			'description' => __( 'Add block of cards for a post type.' ),
			'category'    => 'theme',
			'icon'        => 'forms',
			'keywords'    => [ 'blokki', 'cards', 'cpt', 'grid' ],
		];

		$blocks[] = [
			'name'        => 'accordions',
			'title'       => __( 'Blokki Accordions' ),
			'description' => __( 'Add block of accordions for a post type.' ),
			'category'    => 'theme',
			'icon'        => 'excerpt-view',
			'keywords'    => [ 'blokki', 'accordions', 'cpt', 'grid', 'cards', 'post type' ],
		];

		$blocks[] = [
			'name'        => 'grid-with-filters',
			'title'       => __( 'Blokki Grid with filters' ),
			'description' => __( 'Add WPGB Grid with facets.' ),
			'category'    => 'theme',
			'icon'        => 'schedule',
			'keywords'    => [ 'blokki', 'wp grid builder', 'grid', 'cards', 'filter', 'facet' ],
			'mode'        => 'edit',
		];

		$blocks['social-share'] = [
			'name'        => 'social-share',
			'title'       => __( 'Blokki Social Share', 'blokki' ),
			'description' => __( 'Add social sharing buttons.', 'blokki' ),
			'category'    => 'theme',
			'icon'        => 'share',
			'keywords'    => [ 'blokki', 'social-share' ],
		];

		return apply_filters( 'blokki_acf_blocks_config', $blocks );


//		if ( ! in_array( 'acf/blokki-recent-posts', $remove_blocks, true ) ) {
//			acf_register_block( [
//				'name'            => 'blokki-recent-posts',
//				'title'           => __( 'Blokki Recent Posts', 'blokki' ),
//				'description'     => __( 'Block of 3 recent posts.' ),
//				'render_callback' => [ $this, 'acf_block_render_callback' ],
//				'render_template' => $this->get_acf_block_render_template( 'blokki-recent-posts' ),
//				'category'        => 'theme',
//				'icon'            => 'admin-comments',
//				'keywords'        => [ 'blokki', 'recent_posts' ],
//			] );
//		}
//		if ( ! in_array( 'acf/blokki-swiper', $remove_blocks ) ) {
//			acf_register_block( [
//				'name'            => 'blokki-swiper',
//				'title'           => __( 'Blokki Card Swiper' ),
//				'description'     => __( 'Horizontal swiper of items.' ),
//				'render_callback' => 'acf_blokki_gutenberg_render_callback',
//				'category'        => 'formatting',
//				'icon'            => 'admin-comments',
//				'keywords'        => [ 'blokki', 'swiper' ],
//			] );
//		}
//		if ( ! in_array( 'acf/blokki-icon', $remove_blocks ) ) {
//			acf_register_block( [
//				'name'            => 'blokki-icon',
//				'title'           => __( 'Fontawesome Icon' ),
//				'description'     => __( 'Fontawesome icon.' ),
//				'render_callback' => 'acf_blokki_gutenberg_render_callback',
//				'category'        => 'formatting',
//				'icon'            => 'admin-comments',
//				'keywords'        => [ 'blokki', 'icon' ],
//			] );
//		}
//		if ( ! in_array( 'acf/blokki-logos', $remove_blocks ) ) {
//
//			acf_register_block( [
//				'name'            => 'blokki-logos',
//				'title'           => __( 'Blokki Partner Logos' ),
//				'description'     => __( 'block of partner logos.' ),
//				'render_callback' => 'acf_blokki_gutenberg_render_callback',
//				'category'        => 'formatting',
//				'icon'            => 'admin-comments',
//				'keywords'        => [ 'blokki', 'logos' ],
//			] );
//		}
//		if ( ! in_array( 'acf/blokki', $remove_blocks ) ) {
//
//			acf_register_block( [
//				'name'            => 'blokki',
//				'title'           => __( 'Blokki' ),
//				'description'     => __( 'blocks of content.' ),
//				'render_callback' => 'acf_blokki_gutenberg_render_callback',
//				'category'        => 'formatting',
//				'icon'            => 'admin-comments',
//				'keywords'        => [ 'blokki', 'blocks' ],
//			] );
//		}
//		if ( ! in_array( 'acf/blokki-swiper-navigation', $remove_blocks ) ) {
//
//			acf_register_block( [
//				'name'            => 'blokki-swiper-navigation',
//				'title'           => __( 'Blokki Swiper Navigation' ),
//				'description'     => __( 'navigation tabs for the swiper.' ),
//				'render_callback' => 'acf_blokki_gutenberg_render_callback',
//				'category'        => 'formatting',
//				'icon'            => 'admin-comments',
//				'keywords'        => [ 'blokki', 'swiper-nav' ],
//			] );
//		}
//		if ( ! in_array( 'acf/blokki-quote', $remove_blocks ) ) {
//
//			acf_register_block( [
//				'name'            => 'blokki-quote',
//				'title'           => __( 'Blokki Quote' ),
//				'description'     => __( 'stylised quote panel.' ),
//				'render_callback' => 'acf_blokki_gutenberg_render_callback',
//				'category'        => 'formatting',
//				'icon'            => 'admin-comments',
//				'keywords'        => [ 'blokki', 'quote' ],
//			] );
//		}
//		if ( ! in_array( 'acf/blokki-hubspot-form', $remove_blocks ) ) {
//
//			acf_register_block( [
//				'name'            => 'blokki-hubspot-form',
//				'title'           => __( 'Blokki Hubspot Form' ),
//				'description'     => __( 'Embed a Hubspot form.' ),
//				'render_callback' => 'acf_blokki_gutenberg_render_callback',
//				'category'        => 'formatting',
//				'icon'            => 'admin-comments',
//				'keywords'        => [ 'blokki', 'hubspot-form' ],
//			] );
//		}
//		if ( ! in_array( 'acf/blokki-social-share', $remove_blocks ) ) {
//
//			acf_register_block( [
//				'name'            => 'blokki-social-share',
//				'title'           => __( 'Blokki Social Share' ),
//				'description'     => __( 'Add social sharing buttons.' ),
//				'render_callback' => 'acf_blokki_gutenberg_render_callback',
//				'category'        => 'formatting',
//				'icon'            => 'admin-comments',
//				'keywords'        => [ 'blokki', 'social-share' ],
//			] );
//		}
//		if ( ! in_array( 'acf/blokki-cards', $remove_blocks ) ) {
//
//			acf_register_block( [
//				'name'            => 'blokki-cards',
//				'title'           => __( 'Blokki Cards' ),
//				'description'     => __( 'Add block of cards for a post type.' ),
//				'render_callback' => 'acf_blokki_gutenberg_render_callback',
//				'category'        => 'formatting',
//				'icon'            => 'admin-comments',
//				'keywords'        => [ 'blokki', 'cards' ],
//			] );
//		}
//		if ( ! in_array( 'acf/blokki-breadcrumbs', $remove_blocks ) ) {
//
//			acf_register_block( [
//				'name'            => 'blokki-breadcrumbs',
//				'title'           => __( 'Blokki Breadcrumbs' ),
//				'description'     => __( 'Add content breadcrumbs.' ),
//				'render_callback' => 'acf_blokki_gutenberg_render_callback',
//				'category'        => 'formatting',
//				'icon'            => 'admin-comments',
//				'keywords'        => [ 'blokki', 'breadcrumbs' ],
//			] );
//		}
//		if ( ! in_array( 'acf/blokki-person-contacts', $remove_blocks ) ) {
//
//			acf_register_block( [
//				'name'            => 'blokki-person-contacts',
//				'title'           => __( 'Blokki Person Contacts' ),
//				'description'     => __( 'Add contact details for a person.' ),
//				'render_callback' => 'acf_blokki_gutenberg_render_callback',
//				'category'        => 'formatting',
//				'icon'            => 'admin-comments',
//				'keywords'        => [ 'blokki', 'person-contacts' ],
//			] );
//		}
//		if ( ! in_array( 'acf/blokki-contact-form-7', $remove_blocks ) ) {
//
//			acf_register_block( [
//				'name'            => 'blokki-contact-form-7',
//				'title'           => __( 'Blokki Contact Form 7' ),
//				'description'     => __( 'Add a contact form 7.' ),
//				'render_callback' => 'acf_blokki_gutenberg_render_callback',
//				'category'        => 'formatting',
//				'icon'            => 'admin-comments',
//				'keywords'        => [ 'blokki', 'contact-form' ],
//			] );
//		}
//		if ( ! in_array( 'acf/blokki-post-meta', $remove_blocks ) ) {
//
//			acf_register_block( [
//				'name'            => 'blokki-post-meta',
//				'title'           => __( 'Blokki Post Meta' ),
//				'description'     => __( 'Add post info (author, date, category, tags) to the page.' ),
//				'render_callback' => 'acf_blokki_gutenberg_render_callback',
//				'category'        => 'formatting',
//				'icon'            => 'admin-comments',
//				'keywords'        => [ 'blokki', 'post-meta' ],
//			] );
//		}
//		if ( ! in_array( 'acf/blokki-wc-placeholder', $remove_blocks ) ) {
//
//			acf_register_block( [
//				'name'            => 'blokki-wc-placeholder',
//				'title'           => __( 'Blokki Woocommerce Placeholder' ),
//				'description'     => __( 'Add Woocommerce content at this point in page' ),
//				'render_callback' => 'acf_blokki_gutenberg_render_callback',
//				'category'        => 'formatting',
//				'icon'            => 'admin-comments',
//				'keywords'        => [ 'blokki', 'wc-placeholder' ],
//			] );
//		}
//		if ( ! in_array( 'acf/blokki-wc-placeholder-product', $remove_blocks ) ) {
//
//			acf_register_block( [
//				'name'            => 'blokki-wc-placeholder-product',
//				'title'           => __( 'Blokki Woocommerce Product Placeholder' ),
//				'description'     => __( 'Add Woocommerce single product content at this point in page' ),
//				'render_callback' => 'acf_blokki_gutenberg_render_callback',
//				'category'        => 'formatting',
//				'icon'            => 'admin-comments',
//				'keywords'        => [ 'blokki', 'wc-product-placeholder' ],
//			] );
//		}
//		if ( ! in_array( 'acf/blokki-wc-header', $remove_blocks ) ) {
//
//			acf_register_block( [
//				'name'            => 'blokki-wc-header',
//				'title'           => __( 'Blokki Woocommerce Header' ),
//				'description'     => __( 'Add Woocommerce header at this point in page' ),
//				'render_callback' => 'acf_blokki_gutenberg_render_callback',
//				'category'        => 'formatting',
//				'icon'            => 'admin-comments',
//				'keywords'        => [ 'blokki', 'wc-header' ],
//			] );
//		}
//		if ( ! in_array( 'acf/blokki-title', $remove_blocks ) ) {
//
//			acf_register_block( [
//				'name'            => 'blokki-title',
//				'title'           => __( 'Blokki Single Title Block' ),
//				'description'     => __( 'Add page title and category' ),
//				'render_callback' => 'acf_blokki_gutenberg_render_callback',
//				'category'        => 'formatting',
//				'icon'            => 'admin-comments',
//				'keywords'        => [ 'blokki', 'wc-title' ],
//			] );
//		}


	}

	/**
	 * Populate ACF Field with choices
	 * @hooked 'acf/load_field/name=post_type'
	 */
	public function acf_field_choices_post_type( $field ) {

		$field['choices'] = [];
		$choices          = get_post_types( ['publicly_queryable' => true], 'labels' );

		if ( is_array( $choices ) ) {
			foreach ( $choices as $slug => $choice ) {
				$field['choices'][ $slug ] = $choice->label;
			}
		}

		return $field;

	}

	/**
	 * Populate ACF Field with choices
	 * @hooked 'acf/load_field/name=additional_taxonomy_filtering_1'
	 * @hooked 'acf/load_field/name=additional_taxonomy_filtering_2'
	 */
	public function acf_field_choices_taxonomies( $field ) {

		$field['choices']     = [];
		$field['choices'][''] = __( 'None', 'blokki' );

		$taxonomies = get_taxonomies( [ 'public' => true ], 'labels' );

		$post_types = [];

		foreach ( $taxonomies as $taxonomy_slug => $taxonomy ) {
			if ( ! empty( $taxonomy->object_type ) ) {
				foreach ( $taxonomy->object_type as $post_type ) {
					$post_types[ $post_type ][] = array(
						'label' => $taxonomy->label,
						'slug'  => $taxonomy->name,
					);
				}
			}
		}

		if ( ! empty( $post_types ) ) {
			foreach ( $post_types as $post_type_slug => $taxonomies ) {
				$post_type = get_post_type_object( $post_type_slug );
				foreach ( $taxonomies as $taxonomy ) {

					$field['choices'][ json_encode( [
						'post_type' => $post_type_slug,
						'taxonomy'  => $taxonomy['slug']
					] ) ] = $post_type->labels->singular_name . ' -> ' . $taxonomy['label'];
				}

			}
		}

		return $field;

	}

	/**
	 * Update field with Taxonomy List
	 * @hooked 'acf/load_field/name=taxonomy_list'
	 */
	public function acf_field_choices_taxonomy_list( $field ) {

		$field['choices']     = [];
		$field['choices'][''] = __( 'Show All', 'blokki' );
		$taxonomies           = get_taxonomies( [ 'public' => true ], 'labels' );

		foreach ( $taxonomies as $taxonomy_slug => $taxonomy ) {
			$taxonomy_entries = get_terms( [ 'taxonomy' => $taxonomy_slug, 'hide_empty' => false ] );

			if ( is_array( $taxonomy_entries ) ) {
				foreach ( $taxonomy_entries as $taxonomy_entry ) {
					$field['choices'][ json_encode( [
						'taxonomy' => $taxonomy_slug,
						'field'    => 'slug',
						'terms'    => $taxonomy_entry->slug
					] ) ] = $taxonomy->label . ' -> ' . $taxonomy_entry->name;
				}
			}
		}

		return $field;

	}

	/**
	 * Add wp_block to the ACF post types
	 */
	public function acf_add_blocks_to_post_types( $post_types ) {

		if ( ! in_array( 'wp_block', $post_types ) ) {
			$post_types[] = 'wp_block';
		}


		return $post_types;

	}

}