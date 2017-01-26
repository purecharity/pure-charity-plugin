<?php 
/*
Template Name: Custom Purecharity Template
*/
  get_header();
  get_template_part( 'head'); 
?>


          <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
          <div class="post-body">
            <?php 
              $pattern = get_shortcode_regex();
              $content = get_the_content();
              
              preg_match_all( '/'. $pattern .'/s', $content, $matches );

              if( is_array( $matches ) && array_key_exists( 2, $matches ) 
                  && (
                    in_array( 'sponsorships', $matches[2] ) ||
                    in_array( 'sponsorship', $matches[2] ) ||
                    in_array( 'fundraisers', $matches[2] ) ||
                    in_array( 'fundraiser', $matches[2] ) ||
                    in_array( 'trips', $matches[2] ) ||
                    in_array( 'trip', $matches[2] ) ||
                    in_array( 'giving_circles', $matches[2] ) ||
                    in_array( 'giving_circle', $matches[2] )
                  )
                )
              {
                foreach ($matches[0] as $value) {
                  $value = wpautop( $value, true );
                  echo do_shortcode($value);
                }
              }
            ?>
          </div>
          <?php endwhile; else: ?>
          <?php _e('Sorry, no posts matched your criteria.'); ?>
          <?php endif; ?>        
 

<?php get_footer() ?>