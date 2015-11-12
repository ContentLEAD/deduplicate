
<?php
/*
Plugin Name: Dedup
Description: This plugin hooks into the Brafton WordPress Importer Plugin. It tries to catch duplicate posts and make them drafts.
Author: Edward Hornig at Brafton
*/
add_action('brafton_article_after_save_hook', 'brafton_dedup', 1, 2);
add_action('brafton_video_after_save_hook', 'brafton_dedup', 1, 2);

function brafton_dedup($post_id, $article){
  $title_check = sanitize_title(get_the_title($post_id));
  $post_check = get_post($post_id);
  $slug_check = $post_check->post_name;
  if ($title_check !== $slug_check) {
      $post_check_array = array(
          'ID'            => $post_id,
          'post_status'   => 'draft'
      );
      wp_update_post($post_check_array);
  }
}

?>
