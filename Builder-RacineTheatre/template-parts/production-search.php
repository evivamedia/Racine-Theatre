<?php $date = $_GET['d']; $search = $_GET['s']; ?>
<?php if ( have_posts() ) : ?>
				<?php $show_paging = true; ?>
				<?php while ( have_posts() ) : // The Loop ?>
				<?php the_post(); ?>

				<?php if(get_post_type(get_the_ID())=='wp_theatre_prod' && !empty($search) && empty($date)): ?>
					<?php
						$postID=array();
						$postID[0] = get_the_ID();
						$output = productions_func(array('productionIDsearch' => $postID,'type'=>'search')); 
					?>

					<?php if(!empty($output)): ?>
						<h2><strong>Production</strong> Result</h2>
						<div class="prod_result-container">
							<?php echo $output; ?>
						</div>
					<?php endif; ?>

				<?php elseif(get_post_type(get_the_ID())=='wp_theatre_prod' && !empty($search) && !empty($date)): ?>
					<?php
						$postID=array();
						$postID[0] = get_the_ID();
						$output = productions_func(array('productionIDsearch' => $postID,'date' => $date,'type'=>'search')); 
					?>	

					<?php if(!empty($output)): ?>
						<h2><strong>Production</strong> Result</h2>
						<div class="prod_result-container">
							<?php echo $output; ?>
						</div>
					<?php endif; ?>

				<?php elseif(get_post_type(get_the_ID())!='wp_theatre_prod'): ?>
					<div class="search_result-container">
						<div class="search-result">
							<h3><?php the_title() ?> - <span class="label label-default"><a href="<?php the_permalink(); ?>"><small>visit</small></a></span></h3> 
						</div>
					</div>
				<?php endif; ?>	
				


				<?php endwhile; // end of one post ?>

<?php else : // do not delete ?>
		<div class="no-results-msg">
			<h3>Sorry, no results were found based on your search term.</h3>
		</div>
		
		<!--PRODUCTION SEARCH-->
		<section class="search_section light">
			<div class="container">
				<div class="vc_row wpb_row vc_row-fluid">
					<div class="wpb_column vc_column_container vc_col-sm-12">
						<div class="vc_column-inner ">
							<div class="wpb_wrapper">
								<?php echo do_shortcode('[productionsearchform]'); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
<?php endif; // do not delete ?>