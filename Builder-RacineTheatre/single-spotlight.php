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

						<!-- post content -->
						<div class="entry-content clearfix">
							<?php the_content(); ?>
							<hr>
							<div class="vc_btn3-container vc_btn3-center s_button"><a class="vc_general  vc_btn3 vc_btn3-size-lg vc_btn3-shape-square vc_btn3-style-outline vc_btn3-block vc_btn3-color-black" href="http://dev.evivamedia.com/racinetheatre/spotlight/first-name-last-name/" title="" target="_self">Click here to Volunteer</a></div>
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
