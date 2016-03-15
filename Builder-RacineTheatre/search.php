<?php

function render_content() {
	$show_paging = false;
	$date = $_GET['d'];
	$search = $_GET['s'];
?>
	<div class="loop">
		<div class="loop-header">
			<h4 class="loop-title">
				<?php
					$title = sprintf( __( 'Search Results for "<em>%s %d</em>"', 'it-l10n-Builder' ), get_search_query() );
					
					if ( is_paged() )
						printf( '%s &ndash; Page %d', $title, get_query_var( 'paged' ) );
					else
						echo $title;
				?>
			</h4>
		</div>
		
		<div class="loop-content">
			<?php if(empty($search) && !empty($date)): ?>
			<?php get_template_part( 'template-parts/production', 'searchDate' ); ?>
			<?php else: ?>
			<?php get_template_part( 'template-parts/production', 'search' ); ?>
			<?php endif; ?>
		</div>
		
		<?php if ( $show_paging ) : ?>
			<div class="loop-footer">
				<!-- Previous/Next page navigation -->
				<div class="loop-utility clearfix">
					<div class="alignleft"><?php previous_posts_link( __( '&laquo; Previous Page', 'it-l10n-Builder' ) ); ?></div>
					<div class="alignright"><?php next_posts_link( __( 'Next Page &raquo;', 'it-l10n-Builder' ) ); ?></div>
				</div>
			</div>
		<?php endif; ?>
	</div>
<?php
	
}

add_action( 'builder_layout_engine_render_content', 'render_content' );

do_action( 'builder_layout_engine_render', basename( __FILE__ ) );


?>
