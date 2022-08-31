<?php
/**
 * Plugin Name: Plugin Prueba Taxonomías con Custom Fields
 * Description: Plugin realizado para la prueba de taxonomías con custom fields a un custom post type
 * Version: 1.0
 * Author: Maximiliano Casanova
 * Text Domain: plugin_prueba
 * Domain Path: /languages
 */

/**
 * Registrar un custom post type llamado "pelicula"
 */

function plugin_prueba_register_post_type_pelicula() {
    $labels = array(
        'name'          => _x( 'Peliculas', 'Post type general name', 'plugin_prueba' ),
        'singular_name' => _x( 'Pelicula', 'Post type singular name', 'plugin_prueba' ),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
    );
    register_post_type( 'pelicula', $args );
  }
add_action( 'init', 'plugin_prueba_register_post_type_pelicula' );

/**
 * 
 */

function plugin_prueba_register_taxonomy_saga() {
    $labels = array(
        'name'          => _x ( 'Sagas', 'taxonomy general name', 'plugin_prueba' ),
        'singular_name' => _x ( 'Saga', 'taxonomy singular name', 'plugin_prueba' ),
    );

    $args = array(
        'labels'       => $labels,
        'hierarchical' => true,
    );

    register_taxonomy( 'saga', 'pelicula', $args);
}
add_action( 'init', 'plugin_prueba_register_taxonomy_saga' );

/**
 * 
 */

function plugin_prueba_register_taxonomy_actor() {
    $labels = array(
        'name'          => _x ( 'Actores', 'taxonomy general name', 'plugin_prueba' ),
        'singular_name' => _x ( 'Actor', 'taxonomy singular name', 'plugin_prueba' ),
    );

    $args = array(
        'labels'       => $labels,
        'hierarchical' => false,
    );

    register_taxonomy( 'actor', 'pelicula', $args);
}
add_action( 'init', 'plugin_prueba_register_taxonomy_actor' );

/**
 * 
 */

function plugin_prueba_actor_add_form_fields() {

    ?>
    <div class="form-field">
        <label class="tag-description" for="_fec_nac">Fecha de Nacimiento</label>
        <input type="date" name="_fec_nac" id="_fec_nac">
        <p><?php _e( 'Esta es la fecha de nacimiento del actor.', 'plugin_prueba' ) ?></p>
    </div>
    <div class="form-field">
        <label class="tag-description" for="_tip_pel">Tipos de Peliculas que hace</label>
        <input type="text" name="_tip_pel" id="_tip_pel">
        <p><?php _e( 'Estos son los tipos de peliculas que suele interpretar el actor.', 'plugin_prueba' ) ?></p>
    </div>
    <?php

}
add_action( 'actor_add_form_fields', 'plugin_prueba_actor_add_form_fields' );

/**
 * 
 */

function plugin_prueba_actor_edit_form_fields( $term ) {

    $term_id = $term->term_id;
    $_fec_nac = get_term_meta( $term_id, '_fec_nac', true );
    $_tip_pel = get_term_meta( $term_id, '_tip_pel', true );

    ?>
    <tr class="form-field">
        <th class="row">
            <label for="_fec_nac">Fecha de Nacimiento</label>    
        </th>
        <td>
            <input type="date" name="_fec_nac" id="_fec_nac" value="<?php echo $_fec_nac; ?>">
            <p class="description"><?php _e( 'Esta es la fecha de nacimiento del actor.', 'plugin_prueba' ) ?></p>    
        </td>
    </tr>
    <tr class="form-field">
        <th class="row">
            <label class="tag-description" for="_tip_pel">Tipos de Peliculas que hace</label>    
        </th>
        <td>
            <input type="text" name="_tip_pel" id="_tip_pel" value="<?php echo $_tip_pel; ?>">
            <p><?php _e( 'Estos son los tipos de peliculas que suele interpretar el actor.', 'plugin_prueba' ) ?></p>   
        </td>
    </tr>
    <?php

}
add_action( 'actor_edit_form_fields', 'plugin_prueba_actor_edit_form_fields', 10, 1 );

/**
 * 
 */

function plugin_prueba_created_actor( $term_id ) {

    $valores_personalizados = array( '_fec_nac', '_tip_pel' );

    foreach ( $valores_personalizados as $valor_personalizado ) {
        if ( isset( $_POST[ $valor_personalizado ] ) && !empty( $_POST[ $valor_personalizado ] ) ) {
            update_term_meta( $term_id, $valor_personalizado, $_POST[ $valor_personalizado ] );
        }    
    }
}
add_action( 'created_actor', 'plugin_prueba_created_actor', 10, 1 );
add_action( 'edit_actor', 'plugin_prueba_created_actor', 10, 1 );

