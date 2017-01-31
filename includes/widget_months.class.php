<?php

/**
 * Trips month filter
 *
 * @since    1.0.0
 */
class purecharity_trips_month_widget extends WP_Widget
{

    function __construct()
    {
        parent::__construct(
        // Base ID of your widget
            'purecharity_trips_month_widget',

            // Widget name will appear in UI
            __('Pure Charity Trips (Month filter)', 'purecharity_trips_month_widget_domain'),

            // Widget description
            array('description' => __('Filter Pure Charity Trips by Region', 'purecharity_trips_month_widget_domain'),)
        );
    }

    /**
     * Widget frontend
     *
     * @since    1.0.0
     */
    public function widget($args, $instance)
    {
        $title = apply_filters('widget_title', $instance['title']);
        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        if (!empty($title))
            echo $args['before_title'] . $title . $args['after_title'];

        echo Purecharity_Wp_Base::widget_month_list();

        echo $args['after_widget'];
    }

    /**
     * Widget backend
     *
     * @since    1.0.0
     */
    public function form($instance)
    {
        if (isset($instance['title'])) {
            $title = $instance['title'];
        } else {
            $title = __('New widget', 'purecharity_trips_month_widget_domain');
        }
        // Widget admin form
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" type="text"
                   value="<?php echo esc_attr($title); ?>"/>
        </p>
        <?php
    }

    /**
     * Widget update function
     *
     * @since    1.0.0
     */
    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        return $instance;
    }
}

/**
 * Widget register and load
 *
 * @since    1.0.0
 */
function purecharity_trips_month_load_widget()
{
    register_widget('purecharity_trips_month_widget');
}

add_action('widgets_init', 'purecharity_trips_month_load_widget');