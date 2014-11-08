<?php

$args = array( 'post_type' => 'profile', 'posts_per_page' => 10 );
$loop = new WP_Query( $args );
while ( $loop->have_posts() ) : $loop->the_post();
  echo '<h1>'.the_title().'</h1>';
  echo '<div class="entry-content">';
  the_content();
  echo '</div>';
endwhile;