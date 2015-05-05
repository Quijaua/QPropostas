<?php
class Propostas_Admin {

    private $name;
    private $version;
    private $custom_post;
    private $taxonomy;
    private $meta_box;
    private $settings_page;

    private $db_version;

    public function __construct( $name, $version ) {

        $this->name = $name;
        $this->version = $version;
        $this->db_version = '1.0';

        $this->custom_post = new Propostas_Custom_Post();
        $this->taxonomy = new Propostas_Taxonomy();
        $this->meta_box = new Propostas_Meta_Box();
        //if( is_admin() )
        $this->settings_page = new SettingsPage();

        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_front_scripts' ) );
        add_action( 'init', array($this, 'post_form'));
        add_shortcode('inscreva-se', array($this, 'inscreva_se_shortcode'));
        add_shortcode('propostas', array($this, 'propostas_shortcode'));

        if(is_admin()) {
            // admin actions/filters
            add_action('admin_footer-edit.php', array(&$this, 'custom_bulk_admin_footer'));
            add_action('load-edit.php',         array(&$this, 'custom_bulk_action'));
            add_action('admin_notices',         array(&$this, 'custom_bulk_admin_notices'));
        }
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
        wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css' );

        wp_enqueue_style( 'mdp', PLUGIN_URL . 'frontend/assets/js/multidates-picker/css/mdp.css' );
        wp_enqueue_style( 'prettify', PLUGIN_URL . 'frontend/assets/js/multidates-picker/css/prettify.css' );
        wp_enqueue_style( 'proposta', PLUGIN_URL . 'frontend/assets/css/propostas.css' );
        wp_enqueue_style( 'bootstrap', PLUGIN_URL . 'frontend/assets/css/bootstrap.css' );
        wp_enqueue_style( 'datepicker', PLUGIN_URL . 'frontend/assets/css/datepicker.css' );


        wp_enqueue_script( 'jquery-ui',  '//code.jquery.com/ui/1.11.1/jquery-ui.js', array('jquery'), '1.0.0', true );
        wp_enqueue_script( 'scrollTo',  '//cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/1.4.11/jquery.scrollTo.min.js', array('jquery'), '1.0.0', true );
        wp_enqueue_script( 'multidates-picker', PLUGIN_URL . 'frontend/assets/js/multidates-picker/jquery-ui.multidatespicker.js', array('jquery'), '1.0.0', true );
        wp_enqueue_script( 'plugins', PLUGIN_URL . 'frontend/assets/js/plugins.js', array('jquery'), '1.0.0', true );
        wp_enqueue_script( 'bootstrap-datepicker', PLUGIN_URL . 'frontend/assets/js/bootstrap-datepicker.js', array('jquery'), '1.0.0', true );
        wp_enqueue_script( 'bootstrap-datepicker-pt-BR', PLUGIN_URL . 'frontend/assets/js/bootstrap-datepicker.pt-BR.js', array('jquery'), '1.0.0', true );
        wp_enqueue_script( 'inscrevase', PLUGIN_URL . 'frontend/assets/js/inscreva_se.js', array('jquery', 'plugins'), '1.0.0', true );

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

                $fields = $this->settings_page->get_custom_fields();

                $wp_title = $wp_contet = $date_range = '';
                $files_id = array();
                if(!empty($fields))
                {
                    foreach($fields as $indexField => $field)
                    {
                        if('wp_title' == $field['tipo'])
                        {
                            $wp_title = $field['nome'];
                        }

                        if('wp_content' == $field['tipo'])
                        {
                            $wp_content = $field['nome'];
                        }

                        if('wp_content' == $field['tipo'])
                        {
                            $wp_content = $field['nome'];
                        }
                        if('date-range' == $field['tipo'])
                        {
                            $date_range = $field['nome'];
                        }

                        if('file' == $field['tipo'])
                        {
                            $files_id[] = array(
                                'name' => $field['nome'],
                                'is_featured_image' => true,

                            );

                        }

                        if('attachment' == $field['tipo'])
                        {
                            $files_id[] = array(
                                'name' => $field['nome'],
                                'is_featured_image' => false,

                            );
                        }
                    }
                }

                if(!empty($date_range))
                {
                    $postdata[$date_range] = $postdata['start'] . ' - ' . $postdata['end'];
                    unset($postdata['start']);
                    unset($postdata['end']);
                }

                $titulo = sanitize_text_field($postdata[$wp_title]);
                $descricao = sanitize_text_field($postdata[$wp_content]);

                $proposta = array(
                    'post_type'     => 'propostas',
                    'post_title'    => $titulo,
                    'post_content'  => $descricao,
                    'post_status'   => 'draft',
                    'post_author'   => 1,

                );
                $post_id = wp_insert_post( $proposta );


                if(false !== $post_id)
                {

                    
                    if( !empty($files_id))
                    {
                        foreach($files_id as $file_id)
                        {
                            $attachment_id = $this->upload_media($post_id, $file_id['name'], $file_id['is_featured_image']);
                        }

                    }


                    $data = unserialize(get_post_meta($post_id, 'detalhes_proposta', true));

                    foreach($postdata as $indexItem => $item)
                    {
                        $data[$indexItem] = $item;

                    }
                   
                    update_post_meta($post_id, 'detalhes_proposta', serialize($data));

                    if(isset($postdata['categorias_apresentacao']))
                    {
                        $tag = array( (int) $postdata['categorias_apresentacao'] );
                        wp_set_post_terms( $post_id, $tag, 'categoria-apresentacao-artistica' );
                    }
                    set_transient( 'flash_message', 'Proposta enviada com sucesso!');
                }

            }
        }
    }
    public function inscreva_se_shortcode($atts) {

        $shortcode_atts = shortcode_atts( array(
            'use_category' => true,
        ), $atts );

        $fields = $this->settings_page->get_custom_fields();

        $html = '<form id="frm-inscricao" method="post" action="" enctype="multipart/form-data">
            <fieldset>';

        $flash_message = get_transient( 'flash_message' );

        if(false !== $flash_message) {
            $html .= '<div class="alert success">'.$flash_message.'</div>';
            delete_transient( 'flash_message' );
        }


        foreach($fields as $field)
        {
            if( "text" == $field['tipo'] OR "calendario" == $field['tipo'] OR "email" == $field['tipo'] OR "wp_title" == $field['tipo'] )
            {
                $required = '';
                //var_dump($field['nome'] . '-' .$field['obrigatorio']);
                if(absint($field['obrigatorio']) === 1 )
                {
                    $required = 'data-rule-required="true" data-msg-required="Campo Obrigatório"';
                    if($field['tipo'] === "email")
                    {
                        $required .= ' data-rule-email="true" data-msg-email="Digite um email vÃ¡lido"';
                    }

                    $class = '';
                    if("calendario" == $field['tipo'])
                    {
                        $class = 'class="calendario"';
                    }

                }
                $html .= '<label for="'.$field['nome'].'">'.$field['label'].':
                            <input '.$class.' name="'.$field['nome'].'" type="text" id="'.$field['nome'].'" value="" '.$required.'/>
                        </label><br />';

                if("calendario" == $field['tipo'])
                {
                    $html .= '<div id="dialog-confirm" title="Alerta" style="display:none;">
                                    <p>O dia de domingo Ã© reservado para atividades para o pÃºblico infantil, caso a sua nÃ£o seja, favor escolher outros dias</p>
                            </div>';
                }


            }

            if("date-range" == $field['tipo'])
            {
                if(absint($field['obrigatorio']) === 1 )
                {
                    $required = 'data-rule-required="true" data-msg-required="Campo Obrigatório"';
                    $html .= '<label for="'.$field['nome'].'">'.$field['label'].':
                            <div class="input-daterange" id="datepicker" >
                    <input type="text" class="input-small" name="start" />
                    <span class="add-on" style="vertical-align: top;height:20px"> a </span>
                    <input type="text" class="input-small" name="end" />
                </div>
                        </label><br />';

                }
            }

            if( "checkbox" == $field['tipo'] OR "checkbox_with_text" == $field['tipo'])
            {
                if(absint($field['obrigatorio']) === 1 )
                {
                    $required = 'data-rule-required="true" data-msg-required="Campo Obrigatório"';
                }

                $html .= '<label for="'.$field['nome'].'">'.$field['label'].':</br><ul>';

                foreach($field['valores'] as $key => $option)
                {
                    $html .= '<li><input name="'.$field['nome'].'[]" type="checkbox" value="'.$option.'"  '.$required.'/>'.$option;
                    
                    if("checkbox_with_text" === $field['tipo'] AND !empty($field['texto_complementar'])) {
                        $html .= '<label for="'.$field['nome'].'">'.$field['texto_complementar'].':</br>';
                        $html .= '<input type="text" name="'.$field['nome'].'[]">'; 
                    }
                    $html .=  '</li>';
                }
                if("checkbox" === $field['tipo'] AND !empty($field['texto_complementar'] )) {
                        $html .= '<li><input type="checkbox" name="'.$field['nome'].'[]" value="'.$field['texto_complementar'].'"><label for="'.$field['nome'].'">'.$field['texto_complementar'].':</br>';
                        $html .= '<input type="text" name="'.$field['nome'].'[]"></li>';                      
                }
                $html .= '</ul>';
                


                $html .='</label><br />';
            }

            if( "textarea" == $field['tipo'] OR "wp_content" == $field['tipo'])
            {
                if(absint($field['obrigatorio']) === 1 )
                {
                    $required = 'data-rule-required="true" data-msg-required="Campo Obrigatório"';
                }
                $html .= '<label for="'.$field['nome'].'">'.$field['label'].':
                            <textarea id="'.$field['nome'].'" name="'.$field['nome'].'" cols="80" rows="10" '.$required .'></textarea>
                        </label><br />';

            }

            if( "file" == $field['tipo'] OR "attachment" == $field['tipo'])
            {
                if(absint($field['obrigatorio']) === 1 )
                {
                    $required = 'data-rule-required="true" data-msg-required="Campo Obrigatório"';
                }
                $html .= '<label for="'.$field['nome'].'">'.$field['label'].':
                        <input type="file" id="'.$field['nome'].'" name="'.$field['nome'].'" '.$required.'/>
                     </label><br />';
            }

            if( "select_estado" == $field['tipo'] OR "select_municipio" == $field['tipo'] )
            {
                if(absint($field['obrigatorio']) === 1 )
                {
                    $required = 'data-rule-required="true" data-msg-required="Campo Obrigatório"';
                }
                $html .= '<label for="'.$field['nome'].'">'.$field['label'].':
                    <select '.$required.' name="'.$field['nome'].'" id="'.$field['nome'].'">
                        <option selected="selected" value="">Selecione</option>
                    </select>
                </label><br />';
            }


        }
        if("true" == $shortcode_atts["use_category"]) {
        $html .= ' <label for="categorias_apresentacao">Categoria:
                    <select name="categorias_apresentacao" id="categorias_apresentacao" data-rule-required="true" data-msg-required="Campo Obrigatório">
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

        $html .= wp_nonce_field("handle_form_inscricao", "nonce_form_inscricao");
        $html .='
                <input type="submit" value="Enviar" /   >

            </fieldset>
        </form>';

        return $html;

    }

    public function propostas_shortcode($atts) {
        global $post;
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
            $thumbnail = get_the_post_thumbnail( $post->ID, 'thumbnail' );
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
        return $html;
    }


    private function upload_media($post_id, $file_id, $is_featured_image = true) {

        require_once( ABSPATH . 'wp-admin/includes/image.php' );
        require_once( ABSPATH . 'wp-admin/includes/file.php' );
        require_once( ABSPATH . 'wp-admin/includes/media.php' );

        
        if($is_featured_image)
        {
            $attachment_id = media_handle_upload( $file_id, (int)$post_id) ;

            if ( is_wp_error( $attachment_id ) ) {
                return false;
            }
            return set_post_thumbnail( $post_id , $attachment_id);
        }

        if( !$is_featured_image)
        {

            // Make sure the file array isn't empty
    if(!empty($_FILES[$file_id]['name'])) {

        // Setup the array of supported file types. In this case, it's just PDF.
        $supported_types = array('application/pdf',
                                'application/msword',
                                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                'application/vnd.ms-excel',
                                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        );

        // Get the file type of the upload
        $arr_file_type = wp_check_filetype(basename($_FILES[$file_id]['name']));
        $uploaded_type = $arr_file_type['type'];

        // Check if the type is supported. If not, throw an error.
        if(in_array($uploaded_type, $supported_types)) {

            // Use the WordPress API to upload the file
            $upload = wp_upload_bits($_FILES[$file_id]['name'], null, file_get_contents($_FILES[$file_id]['tmp_name']));

            if(isset($upload['error']) && $upload['error'] != 0) {
                wp_die('There was an error uploading your file. The error is: ' . $upload['error']);
            } else {


                $metadata[$file_id] = $upload['url'];
                add_post_meta($post_id, 'detalhes_proposta', serialize($metadata));
                update_post_meta($post_id, 'detalhes_proposta', serialize($metadata));
            } // end if/else

        } else {
            wp_die("The file type that you've uploaded is not a PDF.");
        } // end if/else

    } // end if
        }

    }


    // Export para CSV
    function custom_bulk_admin_footer() {
        global $post_type;

        if($post_type == 'propostas') {
            ?>
                <script type="text/javascript">
                    jQuery(document).ready(function() {
                        jQuery('<option>').val('export').text('<?php _e('Export')?>').appendTo("select[name='action']");
                        jQuery('<option>').val('export').text('<?php _e('Export')?>').appendTo("select[name='action2']");
                    });
                </script>
            <?php
        }
    }

    function custom_bulk_action() {
            global $typenow;
            $post_type = $typenow;

            if($post_type == 'propostas') {

                // get the action
                $wp_list_table = _get_list_table('WP_Posts_List_Table');  // depending on your resource type this could be WP_Users_List_Table, WP_Comments_List_Table, etc
                $action = $wp_list_table->current_action();

                $allowed_actions = array("export");
                if(!in_array($action, $allowed_actions)) return;

                // security check
                check_admin_referer('bulk-posts');

                // make sure ids are submitted.  depending on the resource type, this may be 'media' or 'ids'
                if(isset($_REQUEST['post'])) {
                    $post_ids = array_map('intval', $_REQUEST['post']);
                }

                if(empty($post_ids)) return;

                // this is based on wp-admin/edit.php
                $sendback = remove_query_arg( array('exported', 'untrashed', 'deleted', 'ids'), wp_get_referer() );
                if ( ! $sendback )
                    $sendback = admin_url( "edit.php?post_type=$post_type" );

                $pagenum = $wp_list_table->get_pagenum();
                $sendback = add_query_arg( 'paged', $pagenum, $sendback );

                switch($action) {
                    case 'export':
                        $exported = count($post_ids);
                        if ( !$this->perform_export($post_ids) )
                                wp_die( __('Error exporting post.') );


                        $sendback = add_query_arg( array('exported' => $exported, 'ids' => join(',', $post_ids) ), $sendback );
                    break;

                    default: return;
                }

                $sendback = remove_query_arg( array('action', 'action2', 'tags_input', 'post_author', 'comment_status', 'ping_status', '_status',  'post', 'bulk_edit', 'post_view'), $sendback );

                wp_redirect($sendback);
                exit();
            }
        }
	

        function custom_bulk_admin_notices() {
            global $post_type, $pagenow;

            if($pagenow == 'edit.php' && $post_type == 'propostas' && isset($_REQUEST['exported']) && (int) $_REQUEST['exported']) {
                $message = sprintf( _n( 'Propostas exportadas.', '%s propostas exportadas.', $_REQUEST['exported'] ), number_format_i18n( $_REQUEST['exported'] ) );
                echo "<div class=\"updated\"><p>{$message}</p></div>";
            }
        }

        function perform_export($post_ids) {

            $query = new WP_Query( array( 'post_type' => 'propostas', 'post__in' => $post_ids, 'posts_per_page' => -1 ) );
            $proposals = array();
            // The Loop
            if ( $query->have_posts() ) {
                while ( $query->have_posts() ) {
                    global $post;
                    $query->the_post();

                    $title = get_the_title();
                    $content = get_the_content();
                    $excerpt = get_the_excerpt();
                    $thumbnail = get_the_post_thumbnail( $post->ID, 'thumbnail' );
                    $permalink = get_the_permalink();


                    $detalhes_proposta = unserialize(get_post_meta($post->ID, 'detalhes_proposta', true));
                    $terms = wp_get_post_terms($post->ID, 'categoria-apresentacao-artistica');
                   

                    $settings = new SettingsPage();
                    $fields = $settings->get_custom_fields();

                    if(!empty($fields))
                    {
                        foreach ($fields as $field) {
                            $postMeta[$field['nome']] = isset($detalhes_proposta[$field['nome']]) ? $detalhes_proposta[$field['nome']] : '' ;
                        }
                    }

                    $postInfo = array(
                        'title'     => $title,
                        'content'   => $content,
                        'excerpt'   => $excerpt,
                        'thumbnail' => $thumbnail,
                        'permalink' => $permalink,
                        'category'  => isset($terms[0]->name) ? $terms[0]->name : ''
                    );

                    $proposals[] = array_merge($postInfo, $postMeta);

                }

            }
            /* Restore original Post Data */
            wp_reset_postdata();
           
	    if( !empty($proposals)) {
            	
		foreach($proposals as $indexProposal => $proposal) {
			foreach($proposal as $key => $item) {
				if(is_array($item)) {
					$tempArray = array_filter($item);
					$proposals[$indexProposal][$key] = implode(',', $tempArray);
				}
				
			}
			
		}
            }		
	    
            // output headers so that the file is downloaded rather than displayed
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename=propostas'.time().'.csv');

            // create a file pointer connected to the output stream
            $output = fopen('php://output', 'w');

            // output the column headings
            if( !empty($proposals))
            {
                fputcsv($output, array_keys($proposals[0]));
                foreach($proposals as $proposal)
                {
		    fputcsv($output, $proposal);
                }
            }
            exit;

        }

}
