<?php
class Propostas_Meta_Box {

    /**
     * Register this class with the WordPress API
     *
     * @since    0.2.0
     */
    public function __construct() {
        add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
        add_action( 'save_post', array( $this, 'meta_box_save' ) );
    }

    /**
     * The function responsible for creating the actual meta box.
     *
     * @since    0.2.0
     */
    public function add_meta_box() {

        add_meta_box(
            'propostas',
            "Detalhes da propostas",
            array( $this, 'display_meta_box' ),
            'propostas',
            'normal',
            'default'
        );

    }

    /**
     * Renders the content of the meta box.
     *
     * @since    0.2.0
     */
    public function display_meta_box() {
        global $post;
        $detalhes_proposta = unserialize(get_post_meta($post->ID, 'detalhes_proposta', true));
        include_once( 'views/propostas-navigation.php' );
    }

    public function meta_box_save( $post_id ) {

        if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

        if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'detalhes_meta_box_nonce' ) ) return;

        if( !current_user_can( 'edit_post' ) ) return;

        $serialized_data = serialize( array(
            'nome_proponente'         => sanitize_text_field($_POST['nome_proponente']),
            'cnpj'                    => sanitize_text_field($_POST['cnpj']),
            'email'                   => sanitize_email($_POST['email']),
            'estado'                  => sanitize_text_field($_POST['estado']),
            'municipio'               => sanitize_text_field($_POST['municipio']),
            'endereco'                => sanitize_text_field($_POST['endereco']),
            'telefone'                => sanitize_text_field($_POST['telefone']),
            'site'                    => sanitize_text_field($_POST['site']),
            'facebook'                => sanitize_text_field($_POST['facebook']),
            'twitter'                 => sanitize_text_field($_POST['twitter']),
            'instagram'               => sanitize_text_field($_POST['instagram']),
            'responsavel_nome'        => sanitize_text_field($_POST['responsavel_nome']),
            'responsavel_cpf'         => sanitize_text_field($_POST['responsavel_cpf']),
            'trabalho_duracao'        => sanitize_text_field($_POST['trabalho_duracao']),
            'trabalho_ficha_tecnica'  => sanitize_text_field($_POST['trabalho_ficha_tecnica']),
            'trabalho_pessoas'        => sanitize_text_field($_POST['trabalho_pessoas']),
            'calendario'              => sanitize_text_field($_POST['calendario']),
        ));

        update_post_meta($post_id, 'detalhes_proposta', $serialized_data);

    }

}