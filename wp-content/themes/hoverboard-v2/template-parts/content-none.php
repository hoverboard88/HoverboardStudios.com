<?php
/**
 * Template part for displaying a message that posts cannot be found.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package hoverboard-v2
 */

?>

<section class="no-results not-found container">
	<header class="page-header">
		<h1 style="padding-top: 30px;" class="h3 centered"><?php esc_html_e( 'Nothing Found', 'hb_v2' ); ?></h1>
	</header><!-- .page-header -->

	<div class="page-content">
		<?php
		if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p><?php printf( wp_kses( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'hb_v2' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

		<?php elseif ( is_search() ) : ?>

			<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'hb_v2' ); ?></p>
			<script>
			setTimeout(function () {
				document.querySelector('.toggle-search').click();
			}, 500);
			</script>

		<?php else : ?>

			<p class="centered"><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'hb_v2' ); ?></p>
			<?php

		endif; ?>
	</div><!-- .page-content -->
</section><!-- .no-results -->
