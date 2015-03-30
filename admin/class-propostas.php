<?php
class Propostas_Admin {

    private $name;
    private $version;
    private $custom_post;
    private $taxonomy;
    private $meta_box;


    public function __construct( $name, $version ) {

        $this->name = $name;
        $this->version = $version;

        $this->custom_post = new Propostas_Custom_Post();
        $this->taxonomy = new Propostas_Taxonomy();
        $this->meta_box = new Propostas_Meta_Box();

        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_front_scripts' ) );
        add_action( 'init', array($this, 'post_form'));
        add_shortcode('inscreva-se', array($this, 'inscreva_se_shortcode'));
        add_shortcode('propostas', array($this, 'propostas_shortcode'));
    }

    public function enqueue_admin_styles() {

        wp_enqueue_style(
            $this->name . '-admin',
            plugins_url( 'propostas/admin/assets/css/admin.css' ),
            false,
            $this->version
        );
    }

    public function enqueue_admin_scripts() {

        if ( 'propostas' === get_current_screen()->id ) {

            wp_enqueue_script(
                $this->name . '-main',
                plugins_url( 'propostas/admin/assets/js/main.js' ),
                array( 'jquery' ),
                $this->version
            );
        }
    }

    public function enqueue_front_scripts() {
        wp_enqueue_style( 'jqueryui-theme', '//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css' );
        wp_enqueue_style( 'mdp', PLUGIN_URL . 'frontend/assets/js/multidates-picker/css/mdp.css' );
        wp_enqueue_style( 'prettify', PLUGIN_URL . 'frontend/assets/js/multidates-picker/css/prettify.css' );
        wp_enqueue_style( 'proposta', PLUGIN_URL . 'frontend/assets/css/propostas.css' );

        wp_enqueue_script( 'jquery-ui',  '//code.jquery.com/ui/1.11.1/jquery-ui.js', array('jquery'), '1.0.0', true );
        wp_enqueue_script( 'multidates-picker', PLUGIN_URL . 'frontend/assets/js/multidates-picker/jquery-ui.multidatespicker.js', array('jquery'), '1.0.0', true );
        wp_enqueue_script( 'plugins', PLUGIN_URL . 'frontend/assets/js/plugins.js', array('jquery'), '1.0.0', true );
        wp_enqueue_script( 'inscreva-se', PLUGIN_URL . 'frontend/assets/js/inscreva_se.js', array('jquery', 'plugins'), '1.0.0', true );


    }
    // http://wordpress.stackexchange.com/questions/134451/upload-featured-image-from-front-end-using-wordpress-add-media-button
    public function post_form() {

        if (!empty($_POST['nonce_form_inscricao']))
        {
            if (!wp_verify_nonce($_POST['nonce_form_inscricao'], 'handle_form_inscricao'))
            {
                die('Submit inválido');
            }
            else
            {
                $error = null;
                $postdata = $_POST;
                $files = $_FILES;

                $titulo = sanitize_text_field($postdata['trabalho_titulo']);
                $descricao = sanitize_text_field($postdata['trabalho_descricao']);

                $proposta = array(
                  'post_type'     => 'propostas',
                  'post_title'    => $titulo,
                  'post_content'  => $descricao,
                  'post_status'   => 'draft',
                  'post_author'   => 1,

                );
                $post_id = wp_insert_post( $proposta, $wp_error );

                if(false !== $post_id)
                {
                    $attachment_id = $this->upload_media($post_id);

                    // Meta
                    $serialized_data = serialize( array(
                        'nome_proponente'         => sanitize_text_field($postdata['nome_proponente']),
                        'cnpj'                    => sanitize_text_field($postdata['cnpj']),
                        'email'                   => sanitize_email($postdata['email']),
                        'estado'                  => sanitize_text_field($postdata['estado']),
                        'municipio'               => sanitize_text_field($postdata['municipio']),
                        'endereco'                => sanitize_text_field($postdata['endereco']),
                        'telefone'                => sanitize_text_field($postdata['telefone']),
                        'site'                    => sanitize_text_field($postdata['site']),
                        'facebook'                => sanitize_text_field($postdata['facebook']),
                        'twitter'                 => sanitize_text_field($postdata['twitter']),
                        'instagram'               => sanitize_text_field($postdata['instagram']),
                        'responsavel_nome'        => sanitize_text_field($postdata['responsavel_nome']),
                        'responsavel_cpf'         => sanitize_text_field($postdata['responsavel_cpf']),
                        'trabalho_duracao'        => sanitize_text_field($postdata['trabalho_duracao']),
                        'trabalho_ficha_tecnica'  => sanitize_text_field($postdata['trabalho_ficha_tecnica']),
                        'trabalho_pessoas'        => sanitize_text_field($postdata['trabalho_pessoas']),
                        'calendario'              => sanitize_text_field($postdata['calendario'])
                    ));

                    add_post_meta($post_id, 'detalhes_proposta', $serialized_data);
                    $tag = array( (int) $postdata['categorias_apresentacao'] );
                    wp_set_post_terms( $post_id, $tag, 'categoria-apresentacao-artistica' );
                    set_transient( 'flash_message', 'Proposta enviada com sucesso!');
                }

                // @todo: Tratamento de erros.

                /*echo '<pre>';
                print_r($postdata);
                echo '</pre>';
                echo '<pre>';
                print_r($files);
                echo '</pre>';
                die;
                if (empty($_POST['nome_proponente']))
                {
                    $error = new WP_Error('empty_error', __('Please enter name.', 'tahiryasin'));
                    wp_die($error->get_error_message(), __('CustomForm Error', 'tahiryasin'));
                }
                else
                {
                    die('Its safe to do further processing on submitted data.');
                }*/


            }
        }
    }
    public function inscreva_se_shortcode($atts) {

        $shortcode_atts = shortcode_atts( array(
            'use_category' => true,
        ), $atts );

        var_dump($shortcode_atts);
        var_dump($shortcode_atts["use_category"]);

        $html = '<form id="frm-inscricao" method="post" action="" enctype="multipart/form-data">
            <fieldset>';

                $flash_message = get_transient( 'flash_message' );

                if(false !== $flash_message) {
                    $html .= '<div class="alert success">'.$flash_message.'</div>';
                    delete_transient( 'flash_message' );
                }

                $html .= '<label for="nome_proponente">Nome do proponente:
                    <input name="nome_proponente" type="text" id="nome_proponente" value="" />
                </label><br />

                <label for="cnpj">CNPJ:
                    <input name="cnpj" type="text" id="cnpj" value=""/>
                </label><br />

                <label for="email">E-mail:
                    <input name="email" type="text" id="email" value="" />
                </label><br />

                <label for="estado">Estado:
                    <select name="estado" id="estado">
                        <option selected="selected" value="">Selecione</option>
                    </select>
                </label><br />

                <label for="municipio">Municipio:
                    <select name="municipio" id="municipio">
                        <option selected="selected" value="">Selecione</option>
                    </select>
                </label><br />

                <label for="endereco">Endereço:
                    <input name="endereco" type="text" id="endereco" value=""/>
                </label><br />

                <label for="telefone">Telefone:
                    <input name="telefone" type="text" id="telefone" value="" />
                </label><br />

                <label for="site">Site:
                    <input name="site" type="text" id="site" value="" />
                </label><br />

                <label for="facebook">Facebook:
                    <input name="facebook" type="text" id="facebook" value="" />
                </label><br />

                <label for="twitter">Twitter:
                    <input name="twitter" type="text" id="twitter" value="" />
                </label><br />

                <label for="instagram">Instagram:
                    <input name="instagram" type="text" id="instagram" value="" />
                </label><br />

                <label for="responsavel_nome">Nome do responsável legal, coordenador(a) ou pessoa de contato do grupo:
                    <input name="responsavel_nome" type="text" id="responsavel_nome" value=""  class="large-text"  />
                </label><br />

                <label for="responsavel_cpf">CPF:
                    <input name="responsavel_cpf" type="text" id="responsavel_cpf" value="" />
                </label><br />

                <label for="trabalho_titulo">Título:
                    <input name="trabalho_titulo" type="text" id="trabalho_titulo" value="" />
                </label><br />

                <label for="trabalho_duracao">Duração:
                    <input name="trabalho_duracao" type="text" id="trabalho_duracao" value="" />
                </label><br />

                <label for="trabalho_descricao">Descricão:
                    <textarea id="trabalho_descricao" name="trabalho_descricao" cols="80" rows="10" ></textarea>
                </label><br />

                <label for="trabalho_ficha_tecnica">Ficha Técnica:
                    <textarea id="trabalho_ficha_tecnica" name="trabalho_ficha_tecnica" cols="80" rows="10"></textarea>
                </label><br />

                <label for="trabalho_foto">Suba uma foto desse trabalho:
                    <input type="file" id="trabalho_foto" name="trabalho_foto" />
                </label><br />';

                if("true" == $shortcode_atts["use_category"]) {
                    $html .= '<label for="categorias_apresentacao">Categorias de apresentacões artísticas:
                    <select name="categorias_apresentacao" id="categorias_apresentacao">
                        <option value="">Selecione</option>';
                    $categorias = get_terms( 'categoria-apresentacao-artistica', array(
                        'orderby'    => 'count',
                        'hide_empty' => 0
                    ) );
                    foreach($categorias as $categoria) {
                        $html .= '<option value="'.$categoria->term_id.'">'.$categoria->name.'</option>';
                    }
                    $html .= '</select>
                </label><br />';
                }



        $html .='
                <label for="trabalho_pessoas">Número de pessoas nessa apresentacão:</br>
                    <input name="trabalho_pessoas" type="checkbox" id="trabalho_pessoas_1" value="1"  />individual
                    <input name="trabalho_pessoas" type="checkbox" id="trabalho_pessoas_2" value="2"  />até 2 artistas envolvidos
                    <input name="trabalho_pessoas" type="checkbox" id="trabalho_pessoas_3" value="3"  />3 a 5 artistas envolvidos
                    <input name="trabalho_pessoas" type="checkbox" id="trabalho_pessoas_4" value="4"  />6 ou mais artistas envolvidos
                </label><br />

                <label for="calendario">Calendário:

                <input type="text" id="calendario" name="calendario" value=""/>
                <label><br />
                <div id="dialog-confirm" title="Responda" style="display:none;">
                    <p>É uma apresentacão
voltada ao público infantil ou de leitura?</p>
                </div>

                '.wp_nonce_field("handle_form_inscricao", "nonce_form_inscricao").'
                <input type="submit" value="Enviar" /   >

            </fieldset>
        </form>';


         return $html;

    }

    public function propostas_shortcode($atts) {

        // Buscar propostas publicadas
        $args = array( 'post_type' => 'propostas', 'posts_per_page' => 10, 'post_status' => 'publish');
        $loop = new WP_Query( $args );
        $html = '<ul>';
        while ( $loop->have_posts() ) {
          $loop->the_post();
          $permalink = get_the_permalink();
          $title_attribute = the_title_attribute();
          $title = get_the_title();
          $excerpt = get_the_excerpt();
          $thumbnail = get_the_post_thumbnail( $post_id, 'thumbnail' );
          $html .= '<li>';
          $link_post = '<h3><a href="'.$permalink.'" title="'.$title_attribute.'">'.$title.'</a></h3>';

          if ( has_post_thumbnail() ) {
            $html .= $thumbnail;
          }
          $html .= $link_post;
          $html .= '<p>';
          $html .= $excerpt;
          $html .= '</p>';
          $html .= '</li>';
        }
        $html .= '</ul>';
        //var_dump($html);
        return $html;
    }


    private function upload_media($post_id) {

        require_once( ABSPATH . 'wp-admin/includes/image.php' );
        require_once( ABSPATH . 'wp-admin/includes/file.php' );
        require_once( ABSPATH . 'wp-admin/includes/media.php' );
        $attachment_id = media_handle_upload( 'trabalho_foto', (int)$post_id) ;

        if ( is_wp_error( $attachment_id ) ) {
            return false;
        }
        return set_post_thumbnail( $post_id , $attachment_id);
    }

}