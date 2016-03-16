<?php

function render_content() {
	
?>
	<?php if ( have_posts() ) : ?>
		<div class="loop">
			<div class="loop-header">
				<h2 class="loop-title">
					<strong>
					<?php
						the_post();
						
						if ( is_category() ) { // Category Archive
							$title = sprintf( __( 'Archive for %s', 'it-l10n-Builder' ), single_cat_title( '', false ) );
						}
						else if ( is_tag() ) { // Tag Archive
							$title = sprintf( __( 'Archive for %s', 'it-l10n-Builder' ), single_tag_title( '', false ) );
						}
						else if ( is_tax() ) { // Tag Archive
							$title = sprintf( __( 'Archive for %s', 'it-l10n-Builder' ), builder_get_tax_term_title() );
						}
						else if ( function_exists( 'is_post_type_archive' ) && is_post_type_archive() && function_exists( 'post_type_archive_title' ) ) { // Post Type Archive
							$title = post_type_archive_title( '', false );
						}
						else if ( is_author() ) { // Author Archive
							$title = sprintf( __( 'Author Archive for %s', 'it-l10n-Builder' ), get_the_author() );
						}
						else if ( is_year() ) { // Year-Specific Archive
							$title = sprintf( __( 'Archive for %s', 'it-l10n-Builder' ), get_the_time( 'Y' ) );
						}
						else if ( is_month() ) { // Month-Specific Archive
							$title = sprintf( __( 'Archive for %s', 'it-l10n-Builder' ), get_the_time( 'F Y' ) );
						}
						else if ( is_day() ) { // Day-Specific Archive
							$title = sprintf( __( 'Archive for %s', 'it-l10n-Builder' ), get_the_date() );
						}
						else if ( is_time() ) { // Time-Specific Archive
							$title = __( 'Time Archive', 'it-l10n-Builder' );
						}
						else { // Default catchall just in case
							$title = __( 'Archive', 'it-l10n-Builder' );
						}
						
						if ( is_paged() )
							printf( '%s &ndash; Page %d', $title, get_query_var( 'paged' ) );
						else
							echo $title;
						
						rewind_posts();
					?>
					</strong>
				</h2>
			</div>
			
			<div class="loop-content">
				<?php while ( have_posts() ) : // The Loop ?>
					<?php the_post(); ?>
					
					<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

						<!-- title, meta, and date info -->
						<div class="entry-header clearfix">
									<h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						</div>
						<div class="aud_dates"><strong>Audition date: </strong><?php echo audition_dates(get_the_ID()); ?></div>
						<div class="aud_remark"><strong>Remark: </strong><?php echo get_field('remark',get_the_ID()); ?></div>
						<div class="vc_btn3-container vc_btn3-center a_button"><a class="vc_general  vc_btn3 vc_btn3-size-xs vc_btn3-shape-square vc_btn3-style-outline vc_btn3-icon-left vc_btn3-color-black" href="<?php the_permalink(); ?>" title="" target="_self"><i class="vc_btn3-icon fa fa-plus"></i> AUDITION DETAILS</a></div>
						<!-- post content -->
						
					</div>
					<!-- end .post -->
				
				<?php endwhile; // end of one post ?>
			</div>
			
			<div class="loop-footer">
				<!-- Previous/Next page navigation -->
				<div class="loop-utility clearfix">
					<div class="alignleft"><?php previous_posts_link( __( '&laquo; Previous Page', 'it-l10n-Builder' ) ); ?></div>
					<div class="alignright"><?php next_posts_link( __( 'Next Page &raquo;', 'it-l10n-Builder' ) ); ?></div>
				</div>
			</div>
		</div>
	<?php else : // do not delete ?>
		<?php do_action( 'builder_template_show_not_found' ); ?>
	<?php endif; // do not delete ?>
<?php
	
}

add_action( 'builder_layout_engine_render_content', 'render_content' );

do_action( 'builder_layout_engine_render', basename( __FILE__ ) );
