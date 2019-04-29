<?php
  get_header();
?>
<!--/HEADER-->

<!--CONTENT-->
<?php
  global $post;
  $template = strtolower($post->post_name) . '.php';

  if (locate_template($template)) {
	  require_once($template);
  } else {
	  if (have_posts()):
		  while (have_posts()) : the_post();
			  the_content();
		  endwhile;
	  endif;
  }
?>
<!--/CONTENT-->

<!--FOOTER-->
<?php
  get_footer();
?>