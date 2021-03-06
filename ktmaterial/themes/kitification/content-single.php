<?php
/**
 * @package Kitification
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>

		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'kitification' ),
				'after'  => '</div>',
			) );
		?>

		<div class="entry-meta">
			<?php the_tags( '<span class="entry-tags"><i class="icon-tag"></i>', ', ', '</span>' ); ?>

			<?php edit_post_link( __( '<i class="icon-pencil"></i> Edit', 'kitification' ), '<span class="edit-link">', '</span>' ); ?>
		</div><!-- .entry-meta -->
	</div><!-- .entry-content -->
</article><!-- #post-## -->
