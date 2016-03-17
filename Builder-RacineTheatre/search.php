<?php

function render_content() {
	$show_paging = false;
	$date="";
	$search="";
	$date = $_GET['d'];
	$search = $_GET['s'];
?>
	<div class="loop">
		<div class="loop-header">
			<h4 class="loop-title">
				<?php
					if(empty($date)):
						$title = '<h2 class="loop-title"><strong>Search Results</strong> for " <em>'.$search.'</em> "</h2>';
					else:
						$title = '<h2 class="loop-title">Search Results for " <em> '.$search.' '.$date.'</em> " Production</h2>';
					endif;
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
