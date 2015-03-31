<?php
class Propostas_Custom_Post {

    /**
     * Register this class with the WordPress API
     *
     * @since    0.2.0
     */
    public function __construct() {
        add_action( 'init', array( $this, 'propostas_cpt_init' ) );
        add_filter( 'enter_title_here', array($this, 'change_default_title' ));
    }

    /**
     * The function responsible for creating the actual meta box.
     *
     * @since    0.2.0
     */
    public function propostas_cpt_init() {

    $labels = array(
        'name'               => _x( 'Propostas', 'post type general name', 'your-plugin-textdomain' ),
        'singular_name'      => _x( 'Proposta', 'post type singular name', 'your-plugin-textdomain' ),
        'menu_name'          => _x( 'Propostas', 'admin menu', 'your-plugin-textdomain' ),
        'name_admin_bar'     => _x( 'Proposta', 'add new on admin bar', 'your-plugin-textdomain' ),
        'add_new'            => _x( 'Adicionar proposta', 'book', 'your-plugin-textdomain' ),
        'add_new_item'       => __( 'Adicionar Nova Proposta', 'your-plugin-textdomain' ),
        'new_item'           => __( 'Nova Proposta', 'your-plugin-textdomain' ),
        'edit_item'          => __( 'Editar Proposta', 'your-plugin-textdomain' ),
        'view_item'          => __( 'Ver Proposta', 'your-plugin-textdomain' ),
        'all_items'          => __( 'Todas as Propostas', 'your-plugin-textdomain' ),
        'search_items'       => __( 'Pesquisar Propostas', 'your-plugin-textdomain' ),
        'parent_item_colon'  => __( 'Proposta Pai:', 'your-plugin-textdomain' ),
        'not_found'          => __( 'Nenhuma proposta cadastrada.', 'your-plugin-textdomain' ),
        'not_found_in_trash' => __( 'Nenhuma proposta no lixo.', 'your-plugin-textdomain' )
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'propostas' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor', 'thumbnail' )
    );

    register_post_type( 'propostas', $args );

    }


    function change_default_title( $title ){
        $screen = get_current_screen();

        if  ( 'propostas' == $screen->post_type ) {
            $title = 'Título da Proposta';
        }
        return $title;
    }

}