<?php
/*
Plugin Name: Dedup
Description: This plugin hooks into the Brafton WordPress Importer Plugin. It tries to catch duplicate posts and make them drafts.
Author: Edward Hornig at Brafton (and Nikita)
*/
add_action('brafton_article_after_save_hook', 'brafton_dedup', 1, 2);
add_action('brafton_video_after_save_hook', 'brafton_dedup', 1, 2);

function brafton_dedup($post_id, $article){
  //ed's original dedup
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
  //alternative method of dedup
  //loops through every post and trashes any duplicates
  //may be resource intensive so only use on sites with <200 posts
  /*
    $args = array(
        'post_type' => 'post',
        'meta_query' => array('key' => 'brafton_id')
    );

    $post_query = new WP_Query($args);
    if($post_query->have_posts() ) {
        while($post_query->have_posts() ) {
            $post_query->the_post();

            $title_check = sanitize_title(get_the_title($post_query->ID));
            $post_check = get_post($post_query->ID);
            $slug_check = $post_check->post_name;
            if ($title_check !== $slug_check) {
                // $post_check_array = array(
                //     'ID'            => $post_query->ID,
                //     'post_status'   => 'draft'
                // );
                // wp_update_post($post_check_array);
                wp_trash_post($post_query->ID);
            }
        }
    }
  */
}

?>
