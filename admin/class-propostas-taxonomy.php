<?php
class Propostas_Taxonomy {


    public function __construct() {
        add_action( 'init', array( $this, 'propostas_taxonomy' ) );
    }


    public function propostas_taxonomy() {

        $labels = array(
            'name'              => _x( 'Categoria', 'taxonomy general name' ),
            'singular_name'     => _x( 'Categoria', 'taxonomy singular name' ),
            'search_items'      => __( 'Pesquisar Categorias' ),
            'all_items'         => __( 'Todas Categorias'),
            'parent_item'       => __( 'Parent Categorias'),
            'parent_item_colon' => __( 'Parent Categorias :'),
            'edit_item'         => __( 'Editar Categoria' ),
            'update_item'       => __( 'Atualizar Categoria'),
            'add_new_item'      => __( 'Adicionar Nova Categoria'),
            'new_item_name'     => __( 'Nova Categoria'),
            'menu_name'         => __( 'Categoria' ),
        );

        $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array( 'slug' => 'categoria-apresentacao-artistica' ),
        );

        register_taxonomy( 'categoria-apresentacao-artistica', array( 'propostas' ), $args );

    }

}