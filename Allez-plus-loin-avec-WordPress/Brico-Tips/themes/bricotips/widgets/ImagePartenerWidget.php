<?php

/**
 * Adds Foo_Widget widget.
 */
class Image_Partener_Widget extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        parent::__construct(
            'partener_titre_widget', // Base ID
            'Widget Partener Titre', // Name
            array( 'description' => __( 'Widget d\'image de partenaires avec titre', 'text_domain' ), ) // Args
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        extract( $args );
        $name = $instance['partener-name'];
        $urlImage = $instance['url_image'];

        echo $before_widget;

        if ( ! empty( $urlImage ) ) {
            ?>
            <div class="partener-name-widget">
                <img src="<?= $urlImage ?>" alt="<?= $name ?>">
                <h4 class="partener-name"><?= $name ?></h4>
            </div>
            <?php
        }

        echo $after_widget;
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {
        if ( isset( $instance[ 'partener-name' ] ) ) {
            $name = $instance[ 'partener-name' ];
        }
        else {
            $name = "Nom du partenaire";
        }
        if ( isset( $instance[ 'url_image' ] ) ) {
            $urlImage = $instance[ 'url_image' ];
        }
        else {
            $urlImage = "";
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_name( 'partener-name' ); ?>">Nom du partenaire</label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'partener-name' ); ?>" name="<?php echo $this->get_field_name( 'partener-name' ); ?>" type="text" value="<?php echo esc_attr( $name ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_name( 'url_image' ); ?>">Url de L'image du partenaire</label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'url_image' ); ?>" name="<?php echo $this->get_field_name( 'url_image' ); ?>" type="text" value="<?php echo esc_attr( $urlImage ); ?>" />
        </p>
        <?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['partener-name'] = ( !empty( $new_instance['partener-name'] ) ) ? strip_tags( $new_instance['partener-name'] ) : '';
        $instance['url_image'] = ( !empty( $new_instance['url_image'] ) ) ? strip_tags( $new_instance['url_image'] ) : '';

        return $instance;
    }

} // class Foo_Widget

?>