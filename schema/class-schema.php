<?php

namespace Blokki;

// if class already defined, bail out
if ( class_exists( 'Blokki\Schema' ) ) {
	return;
}

class Schema {
	protected $post_query_args = [];
	protected $schema_array;
	protected $schema;
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

		add_action( 'blokki_template_posts_loop_post', [ $this, 'setup_schema_for_post_in_loop' ], 10, 3 );

		add_action( 'wp_footer', [ $this, 'output_schema' ] );
	}

	/**
	 * Setup Schema for Post inside loop in a block
	 */
	public function setup_schema_for_post_in_loop( $post, $block, $loop ) {


		if ( ! $this->is_enable_schema_block( $block ) ) {
			return null;
		}
		blokki_dump( $post);

	}

	/**
	 *
	 */
	public function is_enable_schema_block( $block ) {

//		if ( isset( $block['data']['enable_schema'] ) && $block['data']['enable_schema'] ) {
//			return true;
//		}

		return false;

	}

	/**
	 * @hooked bjm_blocks_card_selection_args
	 */
	public function get_card_selection_args_from_bjm_cards( $query_args ) {

		$this->update_post_query_args( $query_args );

		return $query_args;

	}

	/**
	 *
	 */
	public function update_post_query_args( $query_args ) {
		$this->post_query_args[] = $query_args;

		$this->update_schema( $query_args );

	}

	/**
	 *
	 */
	public function update_schema( $query_args ) {

		if ( isset( $query_args['post_type'] ) && in_array( 'bjm_faq', $query_args['post_type'] ) ) {
			$this->update_faq_schema( $query_args );
		}

	}

	/**
	 *
	 */
	public function update_faq_schema( $query_args ) {

		// We need to update post type to filter any other post type selected in bjm cards plugin
		$query_args['post_type'] = [ 'bjm_faq' ];
		$faqs_query              = new WP_Query( $query_args );

		if ( empty( $faqs_query->posts ) ) {
			return null;
		}

		$faqs = $faqs_query->posts;


		$qa_page_schema               = [];
		$qa_page_schema['@context']   = "https://schema.org";
		$qa_page_schema['@type']      = "FAQPage";
		$qa_page_schema['name']       = "FAQs for " . get_the_title();
		$qa_page_schema['mainEntity'] = [];

		$question_schema             = [];
		$question_schema['@context'] = "https://schema.org";
		$question_schema['@type']    = "Question";

		$answer_schema          = [];
		$answer_schema['@type'] = "Answer";


		foreach ( $faqs as $faq ) {
			$faq_schema_question         = $question_schema;
			$faq_schema_question['name'] = $faq->post_title;

			$faq_answer         = $answer_schema;
			$faq_answer['text'] = $faq->post_content;

			$faq_schema_question['acceptedAnswer'] = $faq_answer;

			$qa_page_schema['mainEntity'][] = $faq_schema_question;
		}

		$this->schema_array[] = $qa_page_schema;

	}

	/**
	 * @hooked wp_footer
	 */
	public function output_schema() {

		if ( empty( $this->schema_array ) ) {
			return;
		}

		printf( '<!-- BJM-SEO Schema added by BJM --><script type="application/ld+json">%s</script>',
			wp_json_encode( $this->schema_array )
		);
	}

}