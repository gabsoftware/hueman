<?php
/*
	AlxDualColPosts Widget

	License: GNU General Public License v3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html

	Copyright: (c) 2015 Gabriel "Gab" Hautclocq - http://gabsoftware.com

		@package AlxDualColPosts
		@version 1.0
*/

class AlxDualColPosts extends WP_Widget {

/*  Constructor                         */
/* ------------------------------------ */
	function AlxDualColPosts() {
		parent::__construct( false, 'AlxDualColPosts', array('description' => 'Display posts from a category, in two columns', 'classname' => 'widget_alx_dualcol_posts') );
	}

/*  Widget                              */
/* ------------------------------------ */
	public function widget($args, $instance) {
		extract( $args );
		$instance['title'] ? NULL : $instance['title'] = '';
		$title = apply_filters('widget_title',$instance['title']);
		$output = $before_widget."\n";
		if($title)
			$output .= $before_title.$title.$after_title;
		ob_start();

?>

	<?php
		$posts = new WP_Query( array(
			'post_type'				=> array( 'post' ),
			'showposts'				=> $instance['posts_num'],
			'cat'					=> $instance['posts_cat_id'],
			'ignore_sticky_posts'	=> true,
			'orderby'				=> $instance['posts_orderby'],
			'order'					=> 'dsc',
			'date_query' => array(
				array(
					'after' => $instance['posts_time'],
				),
			),
		) );
	?>

	<ul class="alx-dualcol-posts group">

		<?php if ( $posts->have_posts() ) : ?>

			<?php if ( ot_get_option('blog-standard') == 'on' ): ?>
				<?php while ( $posts->have_posts() ): $posts->the_post(); ?>
				<li>

					<?php get_template_part('content-standard'); ?>

				</li>
				<?php endwhile; ?>
			<?php else: ?>
			<div class="post-list group">
				<?php $i = 1; echo '<div class="post-row">'; while ( $posts->have_posts() ): $posts->the_post(); ?>
				<li>

					<?php get_template_part('content'); ?>

				</li>
				<?php if($i % 2 == 0) { echo '</div><div class="post-row">'; } $i++; endwhile; echo '</div>'; ?>
			</div><!--/.post-list-->
			<?php endif; ?>

		<?php endif; ?>

		<?php wp_reset_postdata(); //Restore original Post Data ?>

	</ul><!--/.alx-dualcol-posts-->

<?php
		$output .= ob_get_clean();
		$output .= $after_widget."\n";
		echo $output;
	}

/*  Widget update                       */
/* ------------------------------------ */
	public function update($new,$old) {
		$instance = $old;
		$instance['title'] = strip_tags($new['title']);
	// Posts
		$instance['posts_thumb'] = $new['posts_thumb']?1:0;
		$instance['posts_category'] = $new['posts_category']?1:0;
		$instance['posts_date'] = $new['posts_date']?1:0;
		$instance['posts_num'] = strip_tags($new['posts_num']);
		$instance['posts_cat_id'] = strip_tags($new['posts_cat_id']);
		$instance['posts_orderby'] = strip_tags($new['posts_orderby']);
		$instance['posts_time'] = strip_tags($new['posts_time']);
		return $instance;
	}

/*  Widget form                         */
/* ------------------------------------ */
	public function form($instance) {
		// Default widget settings
		$defaults = array(
			'title' 			=> '',
		// Posts
			'posts_thumb' 		=> 1,
			'posts_category'	=> 1,
			'posts_date'		=> 1,
			'posts_num' 		=> '4',
			'posts_cat_id' 		=> '0',
			'posts_orderby' 	=> 'date',
			'posts_time' 		=> '0',
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
?>

	<style>
	.widget .widget-inside .alx-options-dualcol-posts .postform { width: 100%; }
	.widget .widget-inside .alx-options-dualcol-posts p { margin: 3px 0; }
	.widget .widget-inside .alx-options-dualcol-posts hr { margin: 20px 0 10px; }
	.widget .widget-inside .alx-options-dualcol-posts h4 { margin-bottom: 10px; }
	</style>

	<div class="alx-options-dualcol-posts">
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>">Title:</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" type="text" value="<?php echo esc_attr( $instance["title"] ); ?>" />
		</p>

		<h4>List Posts</h4>

		<p>
			<input type="checkbox" class="checkbox" id="<?php echo esc_attr( $this->get_field_id('posts_thumb') ); ?>" name="<?php echo esc_attr( $this->get_field_name('posts_thumb') ); ?>" <?php checked( (bool) $instance["posts_thumb"], true ); ?>>
			<label for="<?php echo esc_attr( $this->get_field_id('posts_thumb') ); ?>">Show thumbnails</label>
		</p>
		<p>
			<label style="width: 55%; display: inline-block;" for="<?php echo esc_attr( $this->get_field_id("posts_num") ); ?>">Items to show</label>
			<input style="width:20%;" id="<?php echo esc_attr( $this->get_field_id("posts_num") ); ?>" name="<?php echo esc_attr( $this->get_field_name("posts_num") ); ?>" type="text" value="<?php echo absint($instance["posts_num"]); ?>" size='3' />
		</p>
		<p>
			<label style="width: 100%; display: inline-block;" for="<?php echo esc_attr( $this->get_field_id("posts_cat_id") ); ?>">Category:</label>
			<?php wp_dropdown_categories( array( 'name' => $this->get_field_name("posts_cat_id"), 'selected' => $instance["posts_cat_id"], 'show_option_all' => 'All', 'show_count' => true ) ); ?>
		</p>
		<p style="padding-top: 0.3em;">
			<label style="width: 100%; display: inline-block;" for="<?php echo esc_attr( $this->get_field_id("posts_orderby") ); ?>">Order by:</label>
			<select style="width: 100%;" id="<?php echo esc_attr( $this->get_field_id("posts_orderby") ); ?>" name="<?php echo esc_attr( $this->get_field_name("posts_orderby") ); ?>">
			  <option value="date"<?php selected( $instance["posts_orderby"], "date" ); ?>>Most recent</option>
			  <option value="comment_count"<?php selected( $instance["posts_orderby"], "comment_count" ); ?>>Most commented</option>
			  <option value="rand"<?php selected( $instance["posts_orderby"], "rand" ); ?>>Random</option>
			</select>
		</p>
		<p style="padding-top: 0.3em;">
			<label style="width: 100%; display: inline-block;" for="<?php echo esc_attr( $this->get_field_id("posts_time") ); ?>">Posts from:</label>
			<select style="width: 100%;" id="<?php echo esc_attr( $this->get_field_id("posts_time") ); ?>" name="<?php echo esc_attr( $this->get_field_name("posts_time") ); ?>">
			  <option value="0"<?php selected( $instance["posts_time"], "0" ); ?>>All time</option>
			  <option value="1 year ago"<?php selected( $instance["posts_time"], "1 year ago" ); ?>>This year</option>
			  <option value="1 month ago"<?php selected( $instance["posts_time"], "1 month ago" ); ?>>This month</option>
			  <option value="1 week ago"<?php selected( $instance["posts_time"], "1 week ago" ); ?>>This week</option>
			  <option value="1 day ago"<?php selected( $instance["posts_time"], "1 day ago" ); ?>>Past 24 hours</option>
			</select>
		</p>

		<hr>
		<h4>Post Info</h4>

		<p>
			<input type="checkbox" class="checkbox" id="<?php echo esc_attr( $this->get_field_id('posts_category') ); ?>" name="<?php echo esc_attr( $this->get_field_name('posts_category') ); ?>" <?php checked( (bool) $instance["posts_category"], true ); ?>>
			<label for="<?php echo esc_attr( $this->get_field_id('posts_category') ); ?>">Show categories</label>
		</p>
		<p>
			<input type="checkbox" class="checkbox" id="<?php echo esc_attr( $this->get_field_id('posts_date') ); ?>" name="<?php echo esc_attr( $this->get_field_name('posts_date') ); ?>" <?php checked( (bool) $instance["posts_date"], true ); ?>>
			<label for="<?php echo esc_attr( $this->get_field_id('posts_date') ); ?>">Show dates</label>
		</p>

		<hr>

	</div>
<?php

	}

}

/*  Register widget                     */
/* ------------------------------------ */
if ( ! function_exists( 'alx_register_widget_dualcol_posts' ) ) {

	function alx_register_widget_dualcol_posts() {
		register_widget( 'AlxDualColPosts' );
	}

}
add_action( 'widgets_init', 'alx_register_widget_dualcol_posts' );
