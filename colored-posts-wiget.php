<?php
/*
Plugin Name: Colored Posts Wiget
Plugin URI: http://mattrude.com/projects/
Description:
Version: 0.1
Author: Matt Rude
Author URI: http://mattrude.com/
*/

class colored_posts_wiget extends WP_Widget {
  function colored_posts() {
  }  

  function widget($args, $instance) {
  }
  
  function update($new_instance, $old_instance) {
  }

  function form($instance) {
  }
  
}

add_action('widgets_init', 'widget_colored_posts_init');
function widget_colored_posts_init() {
        register_widget('colored_posts_wiget');
}

?>
