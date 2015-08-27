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

			<article <?php post_class('group'); ?>>

				<?php get_template_part('inc/page-image'); ?>

				<h1 class="entry-title"><?php the_title(); ?></h1>

				<div class="entry themeform">

					<?php $hasbeenmodified = get_the_modified_date() != get_the_date() || get_the_modified_time() != get_the_time(); ?>

					<div class="entry-content"><?php the_content(); ?></div>
					<p class="post-byline"><?php _e('by','hueman'); ?>
						<span class="vcard author">
							<span class="fn"><a href="<?php get_the_author_link(); ?>" rel="author"><?php the_author() ?></a></span>
						</span> &middot; Published <time class="published<?php if( ! $hasbeenmodified ) : ?> updated<?php endif; ?>" datetime="<?php the_time('Y-m-d H:i:s'); ?>"><?php the_date('F j, Y'); ?></time>
						<?php if( $hasbeenmodified ) : ?> &middot; Last modified <time class="updated" datetime="<?php the_modified_time('Y-m-d H:i:s'); ?>"><?php the_modified_date('F j, Y'); ?></time><?php endif; ?>
					</p>

					<div class="clear"></div>
				</div><!--/.entry-->

			</article>

			<?php if ( ot_get_option('before-com-widget') == 'on' ): ?>
			<div id="before-com-widget">
				<?php dynamic_sidebar( 'before-com-widget' ); ?>
			</div><!--/#before-com-widget-->
			<?php endif; ?>

			<?php if ( ot_get_option('page-comments') == 'on' ) { comments_template('/comments.php',true); } ?>

		<?php endwhile; ?>

	</div><!--/.pad-->

	<?php if ( ot_get_option('after-content-widget') == 'on' ): ?>
	<div id="after-content-widget">
		<?php dynamic_sidebar( 'after-content-widget' ); ?>
	</div><!--/#after-content-widget-->
	<?php endif; ?>

</section><!--/.content-->

<?php get_sidebar(); ?>

<?php get_footer(); ?>