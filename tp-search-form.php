<?php
/*
Plugin Name: TP Search Form
Plugin URI: https://github.com/pdutie94/tp-search-form
Description: Display searh form with background.
Author: Tien Pham
Version: 1.0
Author URI: https://github.com/pdutie94
*/

// Register and load the widget
function wpb_load_widget() {
	register_widget( 'tpsf_widget' );
}
add_action( 'widgets_init', 'wpb_load_widget' );

// Creating the widget 
class tpsf_widget extends WP_Widget {
    function __construct() {
        parent::__construct(

        // Base ID of your widget
        'tpsf_widget', 

        // Widget name will appear in UI
        __('TP Search Form', 'tpsf_widget'), 

        // Widget description
        array( 'description' => __( 'Display searh form with background.', 'tpsf_widget' ), ) 
        );
    }

    // Creating widget front-end
    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', $instance['title'] );
        $bg = apply_filters( 'use_bg', $instance['use_bg'] );
        $imgUrl = apply_filters( 'img_url', $instance['img_url'] );
        $bgReapeat = apply_filters( 'widget_bg_repeat', $instance['bg_repeat'] );
        $bgPosition = apply_filters( 'widget_bg_position', $instance['bg_position'] );
        $bgAttachment = apply_filters( 'widget_bg_attachment', $instance['bg_attachment'] );
        $bgSize = apply_filters( 'widget_bg_size', $instance['bg_size'] );
        $btnLabel =  apply_filters( 'widget_btn_label', $instance['btn_label'] );
        $btnBg =  apply_filters( 'widget_btn_bg', $instance['btn_bg'] );
        $placeHolder =  apply_filters( 'placeholder', $instance['placeholder'] );

        $style = 'background-image: url('.$imgUrl.');';

        //css background repeat
        if($bgReapeat != 'none') {
            if($bgReapeat == 'no')
                $style .= 'background-repeat: no-repeat;';
            else if($bgReapeat == 'repeat')
                $style .= 'background-repeat: repeat;';
            else if($bgReapeat == 'x')
                $style .= 'background-repeat: repeat-x;';
            else if($bgReapeat == 'y')
                $style .= 'background-repeat: repeat-y;';
            else
                $style .= 'background-repeat: '.$bgReapeat.';';
        } else {
            $style .= 'background-repeat: unset;';
        }

        //css background attachment
        if($bgAttachment != 'none') {
            $style .= 'background-attachment: '.$bgAttachment.';';
        } else {
            $style .= 'background-attachment: unset;';
        }

        //css background size
        if($bgSize != 'none') {
            $style .= 'background-size: '.$bgSize.';';
        } else {
            $style .= 'background-size: unset;';
        }

        //css background position
        if($bgPosition != '') {
            if($bgPosition == 'center')
                $style .= 'background-position: center center;';
            else if($bgPosition == 'default')
                $style .= 'background-position: top left;';
            else
                $style .= 'background-position: '.$bgPosition.';';
        } else {
            $style .= 'background-position: unset;';
        }
        $mts_options = get_option(MTS_THEME_NAME);

        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        if($bg == 1)
            echo "<div class='search-form-wrap' style='{$style}'>";
        else
            echo "<div class='search-form-wrap'>";
        echo "<div class='search-form-container clearfix'>";
        if ( ! empty( $title ) )
            echo $args['before_title'] . $title . $args['after_title'];

        // This is where you run the code and display the output
        ?>
        <form method="get" id="searchform" class="search-form" action="<?php echo esc_attr( home_url() ); ?>" _lpchecked="1">
            <fieldset>
                <input type="text" name="s" id="s" value="<?php the_search_query(); ?>" placeholder="<?php _e($placeHolder, 'tpsf_widget' ); ?>" <?php if (!empty($mts_options['mts_ajax_search'])) echo ' autocomplete="off"'; ?> />
                <input type="hidden" name="post_type" value="post" /></form>
                <?php if($placeHolder != '') : ?>
                    <button id="search-image" class="sbutton" type="submit" value="">
                <?php else : ?>
                    <button id="search-image" class="sbutton" type="submit" value="" style="background-image: url(<?php echo $btnBg ?>)">
                <?php endif; ?>
                    <span><?php echo $btnLabel ?></span>
                </button>
            </fieldset>
        </form>
        <?php

        echo $args['after_widget'];
        echo "</div>";
        echo "</div>";
    }

    // Widget Backend 
    public function form( $instance ) {
        //Title
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
        else {
            $title = __( 'New title', 'tpsf_widget' );
        }
        //Use bg
        if ( isset( $instance[ 'img_url' ] ) && ($instance['use_bg' ] == 1) ) {
            $checked = 'checked';
        } else {
            $checked = '';
        }
        //img url
        if ( isset( $instance[ 'img_url' ] ) ) {
            $imgUrl = $instance[ 'img_url' ];
        }
        else {
            $imgUrl = __( '', 'tpsf_widget' );
        }
        //background repeat
        if ( isset( $instance[ 'bg_repeat' ] ) ) {
            $bgReapeat = $instance[ 'bg_repeat' ];
        }
        else {
            $bgReapeat = __( 'none', 'tpsf_widget' );
        }
        //background position
        if ( isset( $instance[ 'bg_position' ] ) ) {
            $bgPosition = $instance[ 'bg_position' ];
        }
        else {
            $bgPosition = __( 'none', 'tpsf_widget' );
        }
        //background attachment
        if ( isset( $instance[ 'bg_attachment' ] ) ) {
            $bgAttachment = $instance[ 'bg_attachment' ];
        }
        else {
            $bgAttachment = __( 'none', 'tpsf_widget' );
        }
        //background Size
        if ( isset( $instance[ 'bg_size' ] ) ) {
            $bgSize = $instance[ 'bg_size' ];
        }
        else {
            $bgSize = __( 'none', 'bg_size' );
        }
        //Button label
        if ( isset( $instance[ 'btn_label' ] ) ) {
            $label = $instance[ 'btn_label' ];
        }
        else {
            $label = __( 'Search', 'tpsf_widget' );
        }
        //Button bg
        if ( isset( $instance[ 'btn_bg' ] ) ) {
            $btnBg = $instance[ 'btn_bg' ];
        }
        else {
            $btnBg = __( '', 'tpsf_widget' );
        }
        //Placeholder text
        if ( isset( $instance[ 'placeholder' ] ) ) {
            $placeHolder = $instance[ 'placeholder' ];
        }
        else {
            $placeHolder = __( '', 'tpsf_widget' );
        }

        // Widget admin form
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'btn_label' ); ?>"><?php _e( 'Button Label:' ); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id( 'btn_label' ); ?>" name="<?php echo $this->get_field_name( 'btn_label' ); ?>" type="text" value="<?php echo esc_attr( $label ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'btn_bg' ); ?>"><?php _e( 'Button Background Image URL:' ); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id( 'btn_bg' ); ?>" name="<?php echo $this->get_field_name( 'btn_bg' ); ?>" type="text" value="<?php echo esc_attr( $btnBg ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'placeholder' ); ?>"><?php _e( 'Input Place Holder:' ); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id( 'placeholder' ); ?>" name="<?php echo $this->get_field_name( 'placeholder' ); ?>" type="text" value="<?php echo esc_attr( $placeHolder ); ?>" />
        </p>
        <p>
            <input class="checkbox" id="<?php echo $this->get_field_id( 'use_bg' ); ?>" name="<?php echo $this->get_field_name( 'use_bg' ); ?>" type="checkbox" value="1" <?php echo $checked ?>/>
            <label for="<?php echo $this->get_field_id( 'use_bg' ); ?>"><?php _e( 'Use background' ); ?></label> 
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'img_url' ); ?>"><?php _e( 'Background Image URL:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'img_url' ); ?>" name="<?php echo $this->get_field_name( 'img_url' ); ?>" type="text" value="<?php echo esc_attr( $imgUrl ); ?>"/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'bg_repeat' ); ?>"><?php _e( 'Background Repeat:' ); ?></label>
            <select name="<?php echo $this->get_field_name( 'bg_repeat' ); ?>" id="<?php echo $this->get_field_id( 'bg_repeat' ); ?>">
                <option value="none" <?php echo $bgReapeat == 'none' ? 'selected' : '' ?>>— None —</option>
                <option value="no" <?php echo $bgReapeat == 'no' ? 'selected' : '' ?>>No</option>
                <option value="repeat" <?php echo $bgReapeat == 'repeat' ? 'selected' : '' ?>>Repeat</option>
                <option value="x" <?php echo $bgReapeat == 'x' ? 'selected' : '' ?>>X</option>
                <option value="y" <?php echo $bgReapeat == 'y' ? 'selected' : '' ?>>Y</option>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'bg_position' ); ?>"><?php _e( 'Background Position:' ); ?></label>
            <input id="<?php echo $this->get_field_id( 'bg_position' ); ?>" name="<?php echo $this->get_field_name( 'bg_position' ); ?>" type="text" value="<?php echo esc_attr( $bgPosition ); ?>"/>
            <br>
            <span><i>Available value:</i> <code>center</code>, <code>default</code>. <i>You also can custom (use %):</i> <code>50% 50%</code> <i>or</i> <code>0% 20%</code>, ...</span>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'bg_attachment' ); ?>"><?php _e( 'Background Attachment:' ); ?></label>
            <select name="<?php echo $this->get_field_name( 'bg_attachment' ); ?>" id="<?php echo $this->get_field_id( 'bg_attachment' ); ?>">
                <option value="none" <?php echo $bgAttachment == 'none' ? 'selected' : '' ?>>— None —</option>
                <option value="fixed" <?php echo $bgAttachment == 'fixed' ? 'selected' : '' ?>>Fixed</option>
                <option value="scroll" <?php echo $bgAttachment == 'scroll' ? 'selected' : '' ?>>Scroll</option>
                <option value="local" <?php echo $bgAttachment == 'local' ? 'selected' : '' ?>>Local</option>
                <option value="inherit" <?php echo $bgAttachment == 'inherit' ? 'selected' : '' ?>>Inherit</option>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'bg_size' ); ?>"><?php _e( 'Background Size:' ); ?></label>
            <select name="<?php echo $this->get_field_name( 'bg_size' ); ?>" id="<?php echo $this->get_field_id( 'bg_size' ); ?>">
                <option value="none" <?php echo $bgSize == 'none' ? 'selected' : '' ?>>— None —</option>
                <option value="auto" <?php echo $bgSize == 'auto' ? 'selected' : '' ?>>Auto</option>
                <option value="cover" <?php echo $bgSize == 'cover' ? 'selected' : '' ?>>Cover</option>
                <option value="contain" <?php echo $bgSize == 'contain' ? 'selected' : '' ?>>Contain</option>
                <option value="inherit" <?php echo $bgSize == 'inherit' ? 'selected' : '' ?>>Inherit</option>
            </select>
        </p>
    <?php 
    }

    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['use_bg'] = ( ! empty( $new_instance['use_bg'] ) ) ? strip_tags( $new_instance['use_bg'] ) : '';
        $instance['img_url'] = ( ! empty( $new_instance['img_url'] ) ) ? strip_tags( $new_instance['img_url'] ) : '';
        $instance['bg_repeat'] = ( ! empty( $new_instance['bg_repeat'] ) ) ? strip_tags( $new_instance['bg_repeat'] ) : '';
        $instance['bg_position'] = ( ! empty( $new_instance['bg_position'] ) ) ? strip_tags( $new_instance['bg_position'] ) : '';
        $instance['bg_attachment'] = ( ! empty( $new_instance['bg_attachment'] ) ) ? strip_tags( $new_instance['bg_attachment'] ) : '';
        $instance['bg_size'] = ( ! empty( $new_instance['bg_size'] ) ) ? strip_tags( $new_instance['bg_size'] ) : '';
        $instance['btn_label'] = ( ! empty( $new_instance['btn_label'] ) ) ? strip_tags( $new_instance['btn_label'] ) : '';
        $instance['btn_bg'] = ( ! empty( $new_instance['btn_bg'] ) ) ? strip_tags( $new_instance['btn_bg'] ) : '';
        $instance['placeholder'] = ( ! empty( $new_instance['placeholder'] ) ) ? strip_tags( $new_instance['placeholder'] ) : '';
        return $instance;
    }
}
