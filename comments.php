<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password,
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}

$boilerplate_comment_count = get_comments_number();
?>

<div id="comments" class="comments <?php echo get_option( 'show_avatars' ) ? 'comments__avatars--show' : ''; ?>">


    <?php
	if ( have_comments() ) :
		?>

		<h2 class="comments__title">
			<?php if ( '1' === $boilerplate_comment_count ) : ?>
				<?php esc_html_e( '1 comment', THEME_NAME ); ?>
			<?php else : ?>
				<?php
				printf(
					/* translators: %s: Comment count number. */
					esc_html( _nx( '%s comment', '%s comments', $boilerplate_comment_count, 'Comments title', THEME_NAME ) ),
					esc_html( number_format_i18n( $boilerplate_comment_count ) )
				);
				?>
			<?php endif; ?>
		</h2>

		<ol class="comments__list">
			<?php
			$args = array( 
				'type' => 'comment', 
				'callback' => 'boilerplate_format_comment' 
			);
    		wp_list_comments( $args ); 
			?>
		</ol>

		<?php
		the_comments_pagination(
			array(
				'before_page_number' => esc_html__( 'Page', THEME_NAME ) . ' ',
				'mid_size'           => 0,
				'prev_text'          => sprintf(
					'<span class="nav-prev-text">%s</span>',
					esc_html__( 'Older comments', THEME_NAME )
				),
				'next_text'          => sprintf(
					'<span class="nav-next-text">%s</span>',
					esc_html__( 'Newer comments', THEME_NAME ),
				),
			)
		);
		?>

		<?php if ( ! comments_open() ) : ?>
			<p class="comments__none"><?php esc_html_e( 'Comments are closed.', THEME_NAME ); ?></p>
		<?php endif; ?>


	<?php endif; ?>

	<?php
	comment_form(
		array(
			'logged_in_as'       => null,
			'title_reply'        => esc_html__( 'Leave a comment', 'twentytwentyone' ),
			'title_reply_before' => '<h2 id="reply-title" class="comment-reply-title">',
			'title_reply_after'  => '</h2>',
		)
	);
	?>


</div>