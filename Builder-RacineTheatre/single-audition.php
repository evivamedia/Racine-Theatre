<?php


function render_content() {
	
?>
	<?php if ( have_posts() ) : ?>
		<div class="loop">
			<div class="loop-content">
				<?php while ( have_posts() ) : // The Loop ?>
					<?php the_post(); ?>
					
					<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<?php if ( has_post_thumbnail() ) : ?>
							<div class="ft_image-container">
						        <?php the_post_thumbnail(); ?>
						    </div>
						<?php endif; ?>
						<!-- title, meta, and date info -->
						<div class="entry-header clearfix"><h2 class="entry-title"><?php the_title(); ?></h2></div>
						<div class="aud_dates"><strong>Audition date: </strong><?php echo audition_dates($post->ID); ?></div>
						<div class="aud_excerpt "><strong>Remark: </strong><?php echo get_field('remark'); ?></div>
						<!-- post content -->
						<div class="entry-content clearfix">
							<?php the_content(); ?>
						</div>
						
					</div>
					<!-- end .post -->
					
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
