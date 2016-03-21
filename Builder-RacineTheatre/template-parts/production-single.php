<?php
/**
 * The template part for displaying single posts
 *
 * @package WordPress
 *
 */
?>
<?php 
	$production = new WPT_Production();
	$event = new WPT_Event();

	$title = $production->title();
	$dates = $production->dates();
	if(empty($dates)){$dates = event_startDate(get_the_ID());}
	$bannerURL = get_field('production_banner'); 
	$prod_ticketURL = get_field('main_ticket_url'); 
	$mainticketLABEL = get_field('main_ticket_label');
	if(empty($mainticketLABEL)){$mainticketLABEL = "Buy Ticket";}
	$thumbnailID = $production->thumbnail();
	$posterURL = wp_get_attachment_url($thumbnailID);	
	$prod_ticketINFO = get_field('production_ticket_info');
	$prod_categories = $production->categories();
	$castncrew = get_field('cast_and_crew');
	$advertising = get_field('advertising');
	$press = get_field('press');
	$images = get_field('photo_gallery');
?>

<!--PRODUCTION SEARCH-->
<section class="search_section dark">
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

<!-- PRODCTION BANNER -->

<section class="prod_banner" style="background:url(<?php echo $bannerURL; ?>) no-repeat #383838;background-size:cover;">
	<div class="container">
		<div class="vc_row wpb_row vc_row-fluid">
			<div class="wpb_column vc_column_container vc_col-sm-12">
				<div class="vc_column-inner ">
					<div class="wpb_wrapper">
							<div class="prod_dates"><?php echo $dates; ?></div>
							<div class="prod_title"><h1><?php echo $title; ?></h1></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="prod_moreinfo">
	<div class="container">
		<div class="vc_row wpb_row vc_row-fluid">
			<div class="wpb_column vc_column_container vc_col-sm-12">
				<div class="vc_column-inner ">
					<div class="wpb_wrapper">
							<div class="ticket_button-wrapper">
									<!--<div class="prod_ticketbutton"><a href="<?php echo $main_ticket_url; ?>" target="_BLANK"><?php echo $mainticketLABEL; ?></a></div>-->
									<?php echo prod_ticketbutton(get_the_ID()); ?>
							</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="table prod_container">
		<div class="table-row vc_row wpb_row vc_row-fluid">
			<!-- LEFT BAR -->
			<div class="table-cell prod_left-container wpb_column vc_column_container vc_col-sm-5">
				<div class="vc_column-inner ">
					<div class="wpb_wrapper">
						<div class="prod_left-wrap">

							<div class="prod_poster"><img src="<?php echo $posterURL; ?>"></div>
							<div class="clearboth"></div>

							<?php if(!prod_ended(get_the_ID()) && !empty($prod_ticketURL)): ?>
								<div class="prod_buyticket text-center"><a href="<?php echo $prod_ticketURL; ?>" class="vc_general vc_btn3 vc_btn3-size-lg vc_btn3-shape-square vc_btn3-style-outline vc_btn3-block  vc_btn3-color-white"> BUY TICKET</a></div>
							<?php endif;?>

							<?php if(!empty($prod_ticketINFO)): ?>
								<div class="prod_left_box prod_ticket-info white-scheme">
									<h3>Tickets</h3>
									<?php echo $prod_ticketINFO; ?>
								</div>
							<?php endif; ?>

							<div class="prod_left_box prod_category white-scheme">
								<h3>Categories</h3>
								<ul>
									<?php 
									foreach ($prod_categories as $category_id) {
										$category = get_category( $category_id );
										$category_link = get_category_link( $category_id );
										$category_link = esc_url( $category_link );
										echo '<li class="wpt_production_category wpt_production_category_'.$category->slug.'"><a href="'.get_site_url().'/production/?category='.$category->slug.'">'.$category->name.'</a></li>';
									}
									?>
								</ul>
							</div>

							<div class="prod_left_box prod_share prod_category white-scheme">
								<h3>Share</h3>
								<!-- Go to www.addthis.com/dashboard to customize your tools -->
								<div class="addthis_sharing_toolbox"></div>
							</div>

						</div>
					</div>
				</div>
			</div      >

			<!-- RIGHT BAR -->
			<div class="table-cell prod_right-container wpb_column vc_column_container vc_col-sm-7">
				<div class="vc_column-inner ">
					<div class="wpb_wrapper">	
						<div class="prod_right-wrap">
							<div class="prod-container event_table-wrapper">
								<div class="prod_title-container"><h2><strong><?php echo $title; ?></strong> Events</h2></div>
								<div class="prod_content-container">

									<?php echo events_table_func(array('production' => get_the_ID())); ?>
								</div>
							</div>

							<?php if(!empty($castncrew)): ?>
								<div class="prod-container">
									<div class="prod_title-container"><h2><strong>Cast &</strong> Crew</h2></div>
									<div class="prod_content-container">
										<?php echo $castncrew ?>
									</div>
								</div>
							<?php endif; ?>

							<?php if(!empty($advertising)): ?>
							<div class="prod-container">
								<div class="prod_title-container"><h2><strong>Advertising</strong></h2></div>
								<div class="prod_content-container">
									<?php echo $advertising ?>
								</div>
							</div>
							<?php endif; ?>

							<?php if(!empty($press)): ?>
							<div class="prod-container">
								<div class="prod_title-container"><h2><strong>Press</strong></h2></div>
								<div class="prod_content-container">
									<?php echo $press ?>
								</div>
							</div>
							<?php endif; ?>

							<?php if($images): ?>
							<div class="prod-container">
								<div class="prod_title-container"><h2><strong>Photo</strong> Gallery</h2></div>
								<div class="prod_content-container">
									<?php if( $images ): ?>
									    <ul class="prod_gallery">
									        <?php foreach( $images as $image ): ?>
									            <li>
									                <a href="<?php echo $image['url']; ?>" target="_BLANK">
									                     <img src="<?php echo $image['sizes']['thumbnail']; ?>" alt="<?php echo $image['alt']; ?>" />
									                </a>
									                <p><?php echo $image['caption']; ?></p>
									            </li>
									        <?php endforeach; ?>
									    </ul>
									<?php endif; ?>
									<div class="clearboth"></div>
								</div>
							</div>
							<?php endif; ?>

						</div>
					</div>
				</div>
			</div>

		</div>
</section>