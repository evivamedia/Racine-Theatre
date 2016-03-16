
<?php 
	$date = $_GET['d'];
	$dateSearch = $date;
	$output = productions_func(array('date' => $dateSearch));
?>

<?php if($output !=""): ?>
	<h2><strong>Production</strong> Result</h2>
	<div class="prod_result-container">
		<?php echo $output; ?>
	</div>
<?php else: ?>
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

<?php endif; ?>
