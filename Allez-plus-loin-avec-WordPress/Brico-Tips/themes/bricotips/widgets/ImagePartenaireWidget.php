<?php

/**
 * Adds Foo_Widget widget.
 */
class Image_Partenaire_Widget extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        parent::__construct(
            'partenaire_nom_widget', // Base ID
            'Widget Partenaire Titre', // Name
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
        $nom = $instance['partenaire-nom'];
        $urlImage = $instance['url_image'];
        $urlLien = $instance['url_lien'];

        echo $before_widget;

        if ( !empty( $urlImage ) && !empty( $urlLien )) {
            ?>            
            
            <a class="partenaire-nom-widget" href="<?= $urlLien ?>" style="background-image: url(<?= $urlImage ?>)">
                <span class="partenaire-nom"><?= $nom ?></span>
            </a>

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
        // if ( isset( $instance[ 'partenaire-nom' ] ) ) {
        //     $name = $instance[ 'partenaire-nom' ];
        // }
        // else {
        //     $name = "Nom du partenaire";
        // }
        
        $nom = $instance[ 'partenaire-nom' ] ?? "Nom du partenaire";
        $urlImage = $instance[ 'url_image' ] ?? "";
        $urlLien = $instance['url_lien'] ?? "#";

        ?>
        <p>
            <label for="<?php echo $this->get_field_name( 'partenaire-nom' ); ?>">Nom du partenaire</label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'partenaire-nom' ); ?>" name="<?php echo $this->get_field_name( 'partenaire-nom' ); ?>" type="text" value="<?php echo esc_attr( $nom ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_name( 'url_image' ); ?>">Url de L'image du partenaire</label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'url_image' ); ?>" name="<?php echo $this->get_field_name( 'url_image' ); ?>" type="text" value="<?php echo esc_attr( $urlImage ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_name( 'url_lien' ); ?>">Url du lien du partenaire</label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'url_lien' ); ?>" name="<?php echo $this->get_field_name( 'url_lien' ); ?>" type="text" value="<?php echo esc_attr( $urlLien ); ?>" />
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
        $instance['partenaire-nom'] = ( !empty( $new_instance['partenaire-nom'] ) ) ? strip_tags( $new_instance['partenaire-nom'] ) : '';
        $instance['url_image'] = ( !empty( $new_instance['url_image'] ) ) ? strip_tags( $new_instance['url_image'] ) : '';
        $instance['url_lien'] = ( !empty( $new_instance['url_lien'] ) ) ? strip_tags( $new_instance['url_lien'] ) : '';

        return $instance;
    }

} // class Foo_Widget

?>