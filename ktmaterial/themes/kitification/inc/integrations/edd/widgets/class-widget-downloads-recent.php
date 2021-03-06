<?php
/**
 * Related Items
 *
 * @since Kitification 1.0
 */
class Kitification_Widget_Recent_Downloads extends Kitification_Widget {

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->widget_cssclass    = 'kitification_widget_recent_downloads';
		$this->widget_description = sprintf( __( 'Display recent %s in a grid.', 'kitification' ), edd_get_label_plural() );
		$this->widget_id          = 'kitification_widget_recent_downloads';
		$this->widget_name        = sprintf( __( 'Kitification - Home: Recent %s', 'kitification' ), edd_get_label_plural() );
		$this->settings           = array(
			'title' => array(
				'type'  => 'text',
				'std'   => 'Recent',
				'label' => __( 'Title:', 'kitification' )
			),
			'number' => array(
				'type'  => 'number',
				'step'  => 1,
				'min'   => 1,
				'max'   => '',
				'std'   => 8,
				'label' => __( 'Number to display:', 'kitification' )
			),
			'columns' => array(
				'type'  => 'number',
				'step'  => 1,
				'min'   => 1,
				'max'   => 4,
				'std'   => 4,
				'label' => __( 'Number of columns:', 'kitification' )
			),
			'description' => array(
				'type'  => 'textarea',
				'std'   => '',
				'label' => __( 'Description:', 'kitification' )
			)
		);
		parent::__construct();
	}

	/**
	 * widget function.
	 *
	 * @see WP_Widget
	 * @access public
	 * @param array $args
	 * @param array $instance
	 * @return void
	 */
	function widget( $args, $instance ) {
		if ( $this->get_cached_widget( $args ) )
			return;

		ob_start();

		global $post;

		extract( $args );

		$title        = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		$description  = isset( $instance[ 'description' ] ) ? $instance[ 'description' ] : null;
		$number       = isset ( $instance[ 'number' ] ) ? absint( $instance[ 'number' ] ) : 8;
		$columns      = isset ( $instance[ 'columns' ] ) ? absint( $instance[ 'columns' ] ) : 4;

		$downloads = new WP_Query( array(
			'post_type'              => 'download',
			'posts_per_page'         => $number,
			'no_found_rows'          => true,
			'update_post_term_cache' => false,
			'update_post_meta_cache' => false,
			'cache_results'          => false
		) );

		if ( ! $downloads->have_posts() )
			return;

		echo $before_widget;

		if ( $title ) echo $before_title . $title . $after_title;
		?>

		<?php if ( $description ) : ?>
			<h2 class="home-widget-description"><?php echo $description; ?></h2>
		<?php endif; ?>

		<div class="download-grid-wrapper columns-<?php echo $columns; ?> row" data-columns>
			<?php while ( $downloads->have_posts() ) : $downloads->the_post(); ?>
			<?php get_template_part( 'content-grid', 'download' ); ?>
			<?php endwhile; ?>
		</div>

		<?php
		echo $after_widget;

		$content = ob_get_clean();

		echo $content;

		$this->cache_widget( $args, $content );
	}
}