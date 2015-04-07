<?php
class SettingsPage
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;
    private $proposal_custom_fields;
    private $proposals_custom_fields_options;
    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );

        $this->proposal_custom_fields = array(
             array(
                'label'       => 'Nome do Propoponente',
                'nome'        => sanitize_title('Nome do Propoponente'),
                'obrigatorio' => 1,
                'visivel'     => 1,
                'tipo'        => 'text',
                'valores'     => '',
            ),

            array(
                'label'       => 'CNPJ',
                'nome'        => sanitize_title('CNPJ'),
                'obrigatorio' => 1,
                'visivel'     => 1,
                'tipo'        => 'text',
                'valores'     => '',
            ),

            array(
                'label'       => 'E-mail',
                'nome'        => sanitize_title('Email'),
                'obrigatorio' => 1,
                'visivel'     => 1,
                'tipo'        => 'email',
                'valores'     => '',
            ),

            array(
                'label'       => 'Estado',
                'nome'        => sanitize_title('Estado'),
                'obrigatorio' => 1,
                'visivel'     => 1,
                'tipo'        => 'select_estado',
                'valores'     => '',
            ),

            array(
                'label'       => 'Municipio',
                'nome'        => sanitize_title('Municipio'),
                'obrigatorio' => 1,
                'visivel'     => 1,
                'tipo'        => 'select_municipio',
                'valores'     => '',
            ),

            array(
                'label'       => 'Endereço',
                'nome'        => sanitize_title('Endereço'),
                'obrigatorio' => 1,
                'visivel'     => 1,
                'tipo'        => 'text',
                'valores'     => '',
            ),

            array(
                'label'       => 'Telefone',
                'nome'        => sanitize_title('Telefone'),
                'obrigatorio' => 1,
                'visivel'     => 1,
                'tipo'        => 'text',
                'valores'     => '',
            ),

            array(
                'label'       => 'Site',
                'nome'        => sanitize_title('Site'),
                'obrigatorio' => 1,
                'visivel'     => 1,
                'tipo'        => 'text',
                'valores'     => '',
            ),

            array(
                'label'       => 'Facebook',
                'nome'        => sanitize_title('Facebook'),
                'obrigatorio' => 1,
                'visivel'     => 1,
                'tipo'        => 'text',
                'valores'     => '',
            ),

            array(
                'label'       => 'Twitter',
                'nome'        => sanitize_title('Twitter'),
                'obrigatorio' => 1,
                'visivel'     => 1,
                'tipo'        => 'text',
                'valores'     => '',
            ),

            array(
                'label'       => 'Instagram',
                'nome'        => sanitize_title('Instagram'),
                'obrigatorio' => 1,
                'visivel'     => 1,
                'tipo'        => 'text',
                'valores'     => '',
            ),

            array(
                'label'       => 'Nome do responsável legal, coordenador(a) ou pessoa de contato do grupo',
                'nome'        => sanitize_title('Nome do responsável legal, coordenador(a) ou pessoa de contato do grupo'),
                'obrigatorio' => 1,
                'visivel'     => 1,
                'tipo'        => 'text',
                'valores'     => '',
            ),

             array(
                'label'       => 'CPF',
                'nome'        => sanitize_title('CPF'),
                'obrigatorio' => 1,
                'visivel'     => 1,
                'tipo'        => 'text',
                'valores'     => '',
            ),
             array(
                'label'       => 'Título',
                'nome'        => sanitize_title('Título'),
                'obrigatorio' => 1,
                'visivel'     => 1,
                'tipo'        => 'text',
                'valores'     => '',
            ),

             array(
                'label'       => 'Duração',
                'nome'        => sanitize_title('Duração'),
                'obrigatorio' => 1,
                'visivel'     => 1,
                'tipo'        => 'text',
                'valores'     => '',
            ),

              array(
                'label'       => 'Descricão',
                'nome'        => sanitize_title('Descricão'),
                'obrigatorio' => 1,
                'visivel'     => 1,
                'tipo'        => 'textarea',
                'valores'     => '',
            ),

             array(
                'label'       => 'Ficha Técnica',
                'nome'        => sanitize_title('Ficha Técnica'),
                'obrigatorio' => 1,
                'visivel'     => 1,
                'tipo'        => 'textarea',
                'valores'     => '',
            ),

             array(
                'label'       => 'Número de pessoas nessa apresentacão',
                'nome'        => sanitize_title('Número de pessoas nessa apresentacão'),
                'obrigatorio' => 1,
                'visivel'     => 1,
                'tipo'        => 'checkbox',
                'valores'     => array('Individual', 'até 2 artistas envolvidos', '3 a 5 artistas envolvidos', '6 ou mais artistas envolvidos '),
            ),

            array(
                'label'       => 'Calendário',
                'nome'        => sanitize_title('Calendário'),
                'obrigatorio' => 1,
                'visivel'     => 1,
                'tipo'        => 'calendario',
                'valores'     => '',
            ),

             array(
                'label'       => 'Suba uma foto desse trabalho',
                'nome'        => 'trabalho_foto',
                'obrigatorio' => 1,
                'visivel'     => 1,
                'tipo'        => 'file',
                'valores'     => '',
            ),


        );
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {

        // This page will be under "Settings"
        add_options_page(
            'Settings Admin',
            'QPropostas',
            'manage_options',
            'campos-gerenciaveis',
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {

        $this->get_custom_fields();
    	include_once( 'views/campos-gerenciaveis.php' );

    }
    public function get_custom_fields()
    {
        //delete_option('proposals_custom_fields');
        $this->options = get_option( 'proposals_custom_fields' );


        if(FALSE === $this->options )
        {
            $proposal_custom_fields_options = serialize($this->proposal_custom_fields);
            add_option( 'proposals_custom_fields', $proposal_custom_fields_options, '', 'yes' );
        }

        $this->proposals_custom_fields_options = unserialize(get_option('proposals_custom_fields'));
        return $this->proposals_custom_fields_options;
    }

    public function update_field($name, $updated_field)
    {
        foreach($this->proposals_custom_fields_options as $key => $field)
        {
            if($field['nome'] === $name)
            {
                $fieldsContainOptions = array('select', 'radio', 'checkbox');
               if(in_array($updated_field['tipo'], $fieldsContainOptions))
               {
                   $updated_field['valores'] = explode('@', $updated_field['valores']);
               }
               $this->proposals_custom_fields_options[$key] = $updated_field;
               $this->update_custom_fields();
               break;
            }

        }
    }

    public function delete_field($name)
    {
        foreach($this->proposals_custom_fields_options as $key => $field)
        {
            if($field['nome'] === $name)
            {
               unset($this->proposals_custom_fields_options[$key]);
               $this->update_custom_fields();
               break;
            }
        }
    }

    public function reset()
    {
        $this->proposals_custom_fields_options = array();
        update_option('proposals_custom_fields', serialize($this->proposals_custom_fields_options));
    }

    private function update_custom_fields()
    {
        update_option('proposals_custom_fields', serialize($this->proposals_custom_fields_options));
    }
    /**
     * Register and add settings
     */
    public function page_init()
    {

        register_setting(
            'my_option_group', // Option group
            'my_option_name', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'setting_section_id', // ID
            'Adicionar Campo', // Title
            array( $this, 'print_section_info' ), // Callback
            'campos-gerenciaveis' // Page
        );

        /*add_settings_field(
            'id_number', // ID
            'ID Number', // Title
            array( $this, 'id_number_callback' ), // Callback
            'campos-gerenciaveis', // Page
            'setting_section_id' // Section
        );*/

        add_settings_field(
            'label',
            'Nome',
            array( $this, 'label_callback' ),
            'campos-gerenciaveis',
            'setting_section_id'
        );

        add_settings_field(
            'tipo',
            'Tipo',
            array( $this, 'tipo_callback' ),
            'campos-gerenciaveis',
            'setting_section_id'
        );

        add_settings_field(
            'valores',
            'Opções',
            array( $this, 'opcoes_callback' ),
            'campos-gerenciaveis',
            'setting_section_id'
        );


        add_settings_field(
            'obrigatorio',
            'Obrigatório',
            array( $this, 'obrigatorio_callback' ),
            'campos-gerenciaveis',
            'setting_section_id'
        );

        add_settings_field(
            'visivel',
            'Visível',
            array( $this, 'visivel_callback' ),
            'campos-gerenciaveis',
            'setting_section_id'
        );



    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $this->get_custom_fields();
        $sanitized_input = array();
        /*if( isset( $input['id_number'] ) )
            $sanitized_input['id_number'] = absint( $input['id_number'] );
            */

        if( isset( $input['label'] ) )
        {
            $sanitized_input['label'] = sanitize_text_field( $input['label'] );
            $sanitized_input['nome'] = sanitize_title( $input['label'] );
        }


        if( isset( $input['tipo'] ) )
        {
            if( in_array($input['tipo'], array('wp_title', 'wp_content', 'text', 'checkbox', 'radio', 'textarea', 'select', 'email', 'select_estado', 'select_municipio', 'calendario', 'file', 'attachment', 'date-range')))
            {
                $sanitized_input['tipo'] = $input['tipo'];
            }
        }

        if( isset( $input['valores'] ) )
        {
            $sanitized_input['valores'] = '';
            if(!empty($input['valores']))
            {
                $sanitized_input['valores'] = explode("@", $input['valores']);
            }


        }

        if( isset( $input['obrigatorio'] ) )
            $sanitized_input['obrigatorio'] = absint( $input['obrigatorio'] );

        if( isset( $input['visivel'] ) )
            $sanitized_input['visivel'] = absint( $input['visivel'] );


        $this->proposals_custom_fields_options[] = $sanitized_input;

        $this->update_custom_fields();

    }

    /**
     * Print the Section text
     */
    public function print_section_info()
    {
        print 'Digite os dados do novo campo:';
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function id_number_callback()
    {
        printf(
            '<input type="text" id="id_number" name="my_option_name[id_number]" value="%s" />',
            isset( $this->options['id_number'] ) ? esc_attr( $this->options['id_number']) : ''
        );
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function label_callback()
    {
        printf(
            '<input type="text" id="label" name="my_option_name[label]" value="%s" required class="regular-text" />',
            isset( $this->options['label'] ) ? esc_attr( $this->options['label']) : ''
        );
    }

    public function obrigatorio_callback()
    {
        printf(
            '<input type="radio" id="obrigatorio" name="my_option_name[obrigatorio]" value="1" checked="checked" /> Sim
             <input type="radio" id="obrigatorio" name="my_option_name[obrigatorio]" value="0" /> Não
            '
        );
    }

    public function tipo_callback()
    {
        printf(
            '<select name="my_option_name[tipo]" id="tipo" required>
                <option value="text">Texto</option>
                <option value="wp_title">Titulo WordPress</option>
                <option value="wp_content">Conteudo WordPress</option>
                <option value="email">E-mail</option>
                <option value="checkbox">Checkbox</option>
                <option value="textarea">Textarea</option>
                <option value="radio">Radio</option>
                <option value="select">Select</option>
                <option value="select_estado">Select Estado</option>
                <option value="select_municipio">Select Munícipio</option>
                <option value="file">Imagem destacada</option>
                <option value="attachment">Anexo</option>
                <option value="calendario">Calendario</option>
                <option value="date-range">Periodo</option>
            </select>
            '
        );
    }

    public function visivel_callback()
    {
        printf(
            '<input type="radio" id="visivel" name="my_option_name[visivel]" value="1" checked="checked"/> Sim
             <input type="radio" id="visivel" name="my_option_name[visivel]" value="0" /> Não
            '
        );
    }

    public function opcoes_callback()
    {
        printf(
            '<input type="text" id="valores" name="my_option_name[valores]" value="%s" class="large-text"/><small> Digite os valores separados por @</small>',
            isset( $this->options['valores'] ) ? esc_attr( $this->options['valores']) : ''
        );
    }

}

