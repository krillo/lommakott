<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
get_header();
?>

<section id="primary">
  <div id="content" role="main">

<?php    
      $args = array( 'post_type' => 'produkt', 'posts_per_page' => 10 );
      $loop = new WP_Query( $args );
      while ( $loop->have_posts() ) : $loop->the_post(); 

      echo '<h2 class="entry-title">'; 
      echo '<a href="' . get_permalink() . '">' . get_the_title() . '</a>'; 
      echo '</h2>';   
      echo '<div class="entry-content">';
        the_content();
        echo '</div>';
      endwhile;
?>

    


  </div><!-- #content -->
</section><!-- #primary -->


<?php get_footer(); ?>