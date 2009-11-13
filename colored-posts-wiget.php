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
  function colored_posts_wiget() {
    $currentLocale = get_locale();
    if(!empty($currentLocale)) {
      $moFile = dirname(__FILE__) . "/languages/colored-posts-wiget_" .  $currentLocale . ".mo";
      if(@file_exists($moFile) && is_readable($moFile)) load_textdomain('', $moFile);
    }
    $colored_posts_name = __('Colored Posts Wiget', 'colored-posts-wiget');
    $colored_posts_description = __('Colored Posts Wiget for WordPress', 'colored-posts-wiget');
    $widget_ops = array('classname' => 'colored_posts_wiget', 'description' => $colored_posts_description );
    $this->WP_Widget('colored_posts_wiget', $colored_posts_name, $widget_ops);
  }  

  function widget($args, $instance) {
    extract($args);
    $posts_per_page = empty($instance['posts_per_page']) ? '&nbsp;' : apply_filters('post_per_page', $instance['posts_per_page']);
    $number_rows = empty($instance['number_rows']) ? '&nbsp;' : apply_filters('number_rows', $instance['number_rows']);
    $number_color_rows = $number_rows + 1;
    query_posts('posts_per_page="$posts_per_page"');
    ?> 
    <div class="widget bookmarks widget-bookmarks">
    <?php
    if (have_posts()) : while (have_posts()) : the_post();
      $rowclass = 1 + $rowclass;
      if ($rowclass == $number_color_rows ) {
        $rowclass = 1;
      } ?>
      <div class="cpw-rowcolor-<?php echo $rowclass ?>"> 
        <?php the_excerpt(); ?>
      </div>
      <?php
    endwhile;
    endif;
      wp_reset_query();
    ?> </div> <?php
  }
  
  function update($new_instance, $old_instance) {
    $instance = $old_instance;
    $instance['posts_per_page'] = strip_tags($new_instance['posts_per_page']);
    $instance['number_rows'] = strip_tags($new_instance['number_rows']);
    return $instance;
  }

  function form($instance) {
    $posts_per_page = strip_tags($instance['posts_per_page']);
    $number_rows = strip_tags($instance['number_rows']);
    ?>
    <p><label for="<?php echo $this->get_field_id('posts_per_page'); ?>"><?php _e('Posts per Page', 'colored-posts-wiget')?>:<input class="widefat" id="<?php echo $this->get_field_id('posts_per_page'); ?>" name="<?php echo $this->get_field_name('posts_per_page'); ?>" type="text" value="<?php echo attribute_escape($posts_per_page); ?>" /></label></p>
    <p><label for="<?php echo $this->get_field_id('number_rows'); ?>"><?php _e('Number of colors to display', 'colored-posts-wiget')?>:<input class="widefat" id="<?php echo $this->get_field_id('number_rows'); ?>" name="<?php echo $this->get_field_name('number_rows'); ?>" type="text" value="<?php echo attribute_escape($number_rows); ?>" /></label></p>
    <?php
  }
  
}

add_action('widgets_init', 'widget_colored_posts_init');
function widget_colored_posts_init() {
        register_widget('colored_posts_wiget');
}

?>
