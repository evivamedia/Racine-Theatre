<?php

function render_content() {
	
?>
	<?php if ( have_posts() ) : ?>
		<div class="loop">
			<div class="loop-content">
				<?php while ( have_posts() ) : // The Loop ?>
					<?php the_post(); ?>
					
					<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<!-- title, meta, and date info -->
						<?php $hideheader=get_field('header_option');?>
						<?php if(!$hideheader): ?>
							<div class="entry-header clearfix">
									<h2 class="entry-title"><strong><?php the_title(); ?></strong></h2>
							</div>
						<?php endif;?>
						
						<!-- post content -->
						<div class="entry-content clearfix">
							<?php the_content(); ?>
						</div>
						
					</div>
					<!-- end .post -->
					
					<?php comments_template(); // include comments template ?>
				<?php endwhile; // end of one post ?>
			</div>
		</div>
	<?php else : // do not delete ?>
		<?php do_action( 'builder_template_show_not_found' ); ?>
	<?php endif; // do not delete ?>
<?php
	
}

add_action( 'builder_layout_engine_render_content', 'render_content' );

do_action( 'builder_layout_engine_render', basename( __FILE__ ) );
