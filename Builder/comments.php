<?php
	if ( post_password_required() || ! builder_show_comments() ) {
		return;
	}
?>

<?php if ( have_comments() ) : ?>
	<div id="comments">
		<h3><?php _e( 'Comments', 'it-l10n-Builder' ); ?></h3>
		
		<ol class="commentlist">
			<?php wp_list_comments(); ?>
		</ol>
		
		<?php if ( get_comment_pages_count() > 1 ) : ?>
			<div class="navigation">
				<div class="alignleft"><?php previous_comments_link(); ?></div>
				<div class="alignright"><?php next_comments_link(); ?></div>
			</div>
		<?php endif; ?>
	</div>
	<!-- end #comments -->
<?php endif; ?>

<?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
	<?php echo builder_get_closed_comments_message( __( 'Comments are closed.', 'it-l10n-Builder' ) ); ?>
<?php endif; ?>

<?php
	// Configure the comment form to match the legacy Builder format.
	$commenter = wp_get_current_commenter();
	$req       = get_option( 'require_name_email' );
	$aria_req  = ( $req ? ' aria-required="true"' : '' );
	$html_req  = ( $req ? ' required="required"' : '' );
	
	$fields = array(
		'author' => '<p class="comment-form-author"><input type="text" name="author" id="author" value="' . esc_attr( $commenter['comment_author'] ) . '" size="22"' . $aria_req . $html_req . ' /><label for="author"><small>' . __( 'Name', 'it-l10n-Builder' ) . ( $req ? ' ' . __( "<span class='required'>(required)</span>", 'it-l10n-Builder' ) : '' ) . '</small></label></p>',
		'email'  => '<p class="comment-form-email"><input type="text" name="email" id="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="22" aria-describedby="email-notes"' . $aria_req . $html_req . ' /><label for="email"><small>' . __( 'Mail (will not be published)', 'it-l10n-Builder' ) . ( $req ? ' ' . __( "<span class='required'>(required)</span>", 'it-l10n-Builder' ) : '' ) . '</small></label></p>',
		'url'    => '<p class="comment-form-url"><input type="text" name="url" id="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="22" /><label for="url"><small>' . __( 'Website', 'it-l10n-Builder' ) . '</small></label></p>',
	);
	
	$args = array(
		'fields'               => $fields,
		'comment_field'        => '<p><textarea name="comment" id="comment" cols="45" rows="10" aria-required="true" required="required"></textarea></p>',
		'comment_notes_before' => '',
		'label_submit'         => __( 'Submit Comment', 'it-l10n-Builder' ),
		'submit_field'         => '<p class="comment-submit-wrapper">%1$s %2$s</p>',
	);
	
	comment_form( $args );
?>
