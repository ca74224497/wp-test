<?php 
// To display Clients-logo section on front page
//error_reporting(0);
?>
<?php
  $fino_clients_section_hideshow = get_theme_mod('fino_clients_section_hideshow','hide');
  $fino_clients_title = get_theme_mod('fino_clients_title');

  $fino_clients_no        = 5;
  $fino_clients_logo      = array();
  for( $i = 1; $i <= $fino_clients_no; $i++ ) {
    $fino_clients_logo[]    =  get_theme_mod( "fino_client_logo_$i", 1 );
  }

  $fino_client_args  = array(
      'post_type' => 'page',
      'post__in' => array_map( 'absint', $fino_clients_logo ),
      'posts_per_page' => absint($fino_clients_no),
      'orderby' => 'post__in'
  );

  $fino_client_query = new   wp_Query( $fino_client_args );
  

  if ($fino_clients_section_hideshow =='show' && $fino_client_query->have_posts()) { 
?>
<!-- Partners Section -->
  
<div class="partner">
      <div class="container">
            <div class="partner-slider owl-carousel main-slider" data-loop="false" data-pause-on-hover="true" data-autoplay="true" data-dots="true" data-nav="true"
            data-r-x-small="1" data-r-x-small-nav="false" data-r-x-small-dots="true" data-r-x-medium="2" data-r-x-medium-nav="false"
            data-r-x-medium-dots="true" data-r-small="3" data-r-small-nav="false" data-r-small-dots="true" data-r-medium="4" 
            data-r-medium-nav="true" data-r-medium-dots="false" data-r-large="5" data-r-large-nav="true" data-r-large-dots="false"> 
                    <?php
                      while($fino_client_query->have_posts()) :
                        $fino_client_query->the_post();
                    ?>
                    <div class="item">
                        <div class="partner-item">
                            <?php 
                                if(has_post_thumbnail()): 
                                  the_post_thumbnail('fino_client_img', array('class' => 'img-responsive'));

                                endif; 
                            ?>
                        </div>
                    </div>
                    <?php
                      endwhile;
                      wp_reset_postdata();
                    ?>
            </div>
      </div>
</div>

<!-- End partner section -->
 <?php } ?> 