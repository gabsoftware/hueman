<?php get_header(); ?>

<section class="content">

	<?php get_template_part('inc/page-title'); ?>

	<?php if ( ot_get_option('before-content-widget') == 'on' ): ?>
	<div id="before-content-widget">
		<?php dynamic_sidebar( 'before-content-widget' ); ?>
	</div><!--/#before-content-widget-->
	<?php endif; ?>

	<div class="pad group">

		<?php while ( have_posts() ): the_post(); ?>

			<article <?php post_class(); ?>>

				<div class="post-inner group">

					<h1 class="post-title entry-title"><?php the_title(); ?></h1>

					<?php $hasbeenmodified = get_the_modified_date() != get_the_date() || get_the_modified_time() != get_the_time(); ?>

					<p class="post-byline"><?php _e('by','hueman'); ?>
						<span class="vcard author">
							<span class="fn"><a href="<?php get_the_author_link(); ?>" rel="author"><?php the_author() ?></a></span>
						</span> &middot; Published <time class="published<?php if( ! $hasbeenmodified ) : ?> updated<?php endif; ?>" datetime="<?php the_time('Y-m-d H:i:s'); ?>"><?php the_time('F j, Y'); ?></time>
						<?php if( $hasbeenmodified ) : ?> &middot; Updated <time class="updated" datetime="<?php the_modified_time('Y-m-d H:i:s'); ?>"><?php the_modified_time('F j, Y'); ?></time><?php endif; ?>
					</p>

					<?php if( get_post_format() ) { get_template_part('inc/post-formats'); } ?>

					<div class="clear"></div>

					<div class="entry <?php if ( ot_get_option('sharrre') != 'off' ) { echo 'share'; }; ?>">
						<div class="entry-inner">

							<div class="entry-content"><?php the_content(); ?></div>

							<?php wp_link_pages(array('before'=>'<div class="post-pages">'.__('Pages:','hueman'),'after'=>'</div>')); ?>
						</div>
						<?php if ( ot_get_option('sharrre') != 'off' ) { get_template_part('inc/sharrre'); } ?>
						<div class="clear"></div>
					</div><!--/.entry-->

					<?php the_tags('<p class="post-tags"><span>'.__('Tags:','hueman').'</span> ','','</p>'); ?>

				</div><!--/.post-inner-->
			</article><!--/.post-->
		<?php endwhile; ?>

		<div class="clear"></div>

		<?php if ( ( ot_get_option( 'author-bio' ) != 'off' ) && get_the_author_meta( 'description' ) ): ?>
			<div class="author-bio">
				<div class="bio-avatar"><?php echo get_avatar(get_the_author_meta('user_email'),'128'); ?></div>
				<p class="bio-name"><?php the_author_meta('display_name'); ?></p>
				<p class="bio-desc"><?php the_author_meta('description'); ?></p>
				<div class="clear"></div>
			</div>
		<?php endif; ?>

		<?php if ( ot_get_option('before-nav-widget') == 'on' ): ?>
		<div id="before-nav-widget">
			<?php dynamic_sidebar( 'before-nav-widget' ); ?>
		</div><!--/#before-nav-widget-->
		<?php endif; ?>

		<?php if ( ot_get_option( 'post-nav' ) == 'content') { get_template_part('inc/post-nav'); } ?>

		<?php if ( ot_get_option('before-rel-widget') == 'on' ): ?>
		<div id="before-rel-widget">
			<?php dynamic_sidebar( 'before-rel-widget' ); ?>
		</div><!--/#before-rel-widget-->
		<?php endif; ?>

		<?php if ( ot_get_option( 'related-posts' ) != '1' ) { get_template_part('inc/related-posts'); } ?>

		<?php if ( ot_get_option('before-com-widget') == 'on' ): ?>
		<div id="before-com-widget">
			<?php dynamic_sidebar( 'before-com-widget' ); ?>
		</div><!--/#before-com-widget-->
		<?php endif; ?>

		<?php comments_template('/comments.php',true); ?>

	</div><!--/.pad-->

	<?php if ( ot_get_option('after-content-widget') == 'on' ): ?>
	<div id="after-content-widget">
		<?php dynamic_sidebar( 'after-content-widget' ); ?>
	</div><!--/#after-content-widget-->
	<?php endif; ?>

</section><!--/.content-->

<?php get_sidebar(); ?>

<?php get_footer(); ?>