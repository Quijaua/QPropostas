<?php
class Propostas_Taxonomy {


    public function __construct() {
        add_action( 'init', array( $this, 'propostas_taxonomy' ) );
    }


    public function propostas_taxonomy() {

        $labels = array(
            'name'              => _x( 'Categorias de apresentações artísticas', 'taxonomy general name' ),
            'singular_name'     => _x( 'Categoria de apresentação artística', 'taxonomy singular name' ),
            'search_items'      => __( 'Pesquisar Categorias de apresentacões artísticas' ),
            'all_items'         => __( 'Todas Categorias de apresentacões artísticas' ),
            'parent_item'       => __( 'Parent Categorias de apresentacões artísticas' ),
            'parent_item_colon' => __( 'Parent Categorias de apresentacões artísticas:' ),
            'edit_item'         => __( 'Editar Categoria de apresentação artística' ),
            'update_item'       => __( 'Atualizar Categoria de apresentação artística' ),
            'add_new_item'      => __( 'Adicionar Nova Categoria de apresentação artística' ),
            'new_item_name'     => __( 'Nova Categoria de apresentação artística' ),
            'menu_name'         => __( 'Categoria de apresentação artística' ),
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