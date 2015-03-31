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
        //$this->settings_page = new SettingsPage();
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
        $settings = new SettingsPage();
        $fields = $settings->get_custom_fields();

        include_once( 'views/propostas-navigation.php' );
    }

    public function meta_box_save( $post_id ) {

        if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

        if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'detalhes_meta_box_nonce' ) ) return;

        if( !current_user_can( 'edit_post' ) ) return;
        $postdata = $_POST; 
        $data = array();

        foreach($postdata as $indexItem => $item)
        {
            $data[$indexItem] = $item;

        }

        update_post_meta($post_id, 'detalhes_proposta', serialize($data));
    }

}