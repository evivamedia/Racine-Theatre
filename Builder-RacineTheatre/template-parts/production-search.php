<?php $date = $_GET['d']; $search = $_GET['s']; ?>
<?php if ( have_posts() ) : ?>
				<?php $show_paging = true; ?>
				<?php while ( have_posts() ) : // The Loop ?>
				<?php the_post(); ?>
				<?php 
					if(get_post_type(get_the_ID())=='wp_theatre_prod' && !empty($search) && empty($date)):
						$postID=array();
						$postID[0] = get_the_ID();
						echo productions_func(array('productionIDsearch' => $postID));
					endif;

					if(get_post_type(get_the_ID())=='wp_theatre_prod' && !empty($search) && !empty($date)):
						$postID=array();
						$postID[0] = get_the_ID();
						echo productions_func(array('productionIDsearch' => $postID,'date' => $date));
					endif;
				?>	

				<?php endwhile; // end of one post ?>

<?php else : // do not delete ?>
				<div class="hentry">
					<div class="entry-content">
						<p><?php _e( 'No results found.', 'it-l10n-Builder' ); ?></p>
						
						<?php get_search_form(); ?>
					</div>
				</div>
<?php endif; // do not delete ?>