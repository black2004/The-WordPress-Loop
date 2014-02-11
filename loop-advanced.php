<?php
/**
 * File Name loop-advanced.php
 * @package the-wp-loop-demystified
 * @license GPL v2 - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * @version 1.0.0
 * @updated 00.00.00
 **/
#################################################################################################### */

$query = array(
	'posts_per_page' => 3,
	'post_type' => 'post',
);
$wp_query = new WP_Query();
$wp_query->query( $query );


if ( have_posts() ) {
	while ( have_posts() ) {
		the_post();
		
		echo "<article "; post_class(); echo ">";

			if ( has_post_thumbnail() ) {
				echo "<div class=\"post-thumbnail\">";
					the_post_thumbnail();
				echo "</div>";
			}

			echo "<header class=\"entry-header\">";

				// Add Category list
				if ( in_array( 'category', get_object_taxonomies( get_post_type() ) ) AND twentyfourteen_categorized_blog() ) {
					echo "<div class=\"entry-meta\">";
						echo "<span class=\"cat-links\">" . get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'twentyfourteen' ) ) . "</span>";
					echo "</div>";
				}


				// The title
				the_title( '<h1 class="entry-title">', '</h1>' );


				// post meta data
				echo "<div class=\"entry-meta\">";

					// Set up and print post meta information.
					echo "<span class=\"entry-date\">";
						echo "<a href=\"" . esc_url( get_permalink() ) . "\" rel=\"bookmark\">";
							echo "<time class=\"entry-date\" datetime=\"" . esc_attr( get_the_date( 'c' ) ) . "\">" . esc_attr( get_the_date() ) . "</time>";
						echo "</a>";
					echo "</span>";
					echo "<span class=\"byline\">";
						echo "<span class=\"author vcard\">";
							echo "<a class=\"url fn n\" href=\"" . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . "\" rel=\"author\">" . get_the_author() . "</a>";
						echo "</span>";
					echo "</span>";


					// Comments
					if ( ! post_password_required() AND ( comments_open() OR get_comments_number() ) ) {

						echo "<span class=\"comments-link\">";
							comments_popup_link( __( 'Leave a comment', 'twentyfourteen' ), __( '1 Comment', 'twentyfourteen' ), __( '% Comments', 'twentyfourteen' ) );
						echo "</span>";

					} // end comments


					// Edit post
					edit_post_link( __( 'Edit', 'twentyfourteen' ), '<span class="edit-link">', '</span>' );

				echo "</div><!-- .entry-meta -->";
			echo "</header><!-- .entry-header -->";


			// Post content
			echo "<div class=\"entry-content\">";
				the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentyfourteen' ) );
			echo "</div><!-- .entry-content -->";


			// Display Tags
			the_tags( '<footer class="entry-meta"><span class="tag-links">', '', '</span></footer>' );


		echo "</article><!-- #post-## -->";
		
	} // end while ( have_posts() )
	
	/*
	Use this function to restore the global $post variable of the main query loop after a secondary query loop using new WP_Query. It restores the $post variable to the current post in the main query.
	*/
	wp_reset_postdata();
	
} // end if ( have_posts() )

/*
restores the $wp_query and global post data to the original main query. This function should be called after query_posts(), if you must use that function. As noted in the examples below, it's heavily encouraged to use the pre_get_posts filter to alter query parameters before the query is made.
*/
wp_reset_query();