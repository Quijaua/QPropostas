<div id="proposalss-navigation">
    <fieldset>
        <?php wp_nonce_field( 'detalhes_meta_box_nonce', 'meta_box_nonce' );
        $html = '';

        ?>

        <?php 
        foreach($fields as $field):

            if( "text" == $field['tipo'] OR "calendario" == $field['tipo'] OR "email" == $field['tipo'] OR "attachment" == $field['tipo'] OR "date-range" == $field['tipo'] )
                    {
                        $html .= '<label for="'.$field['nome'].'">'.$field['label'].':
                            <input  name="'.$field['nome'].'" type="text" id="'.$field['nome'].'" value="'.esc_attr($detalhes_proposta[$field['nome']]).'"  class="large-text"/>
                        </label><br />';

                    }

                    if( "checkbox_with_text" == $field['tipo'] OR  "checkbox" == $field['tipo'])
                    {
                      $html .= '<label for="'.$field['nome'].'">'.$field['label'].':
                            <input  name="'.$field['nome'].'" type="text" id="'.$field['nome'].'" value="'.esc_attr(implode(',', $detalhes_proposta[$field['nome']])).'"  class="large-text"/>
                        </label><br />';      
                    }

                    /*if( "checkbox" == $field['tipo'])
                    {
                        $html .= '<label for="'.$field['nome'].'">'.$field['label'].':</br>';

                        $checked = absint($detalhes_proposta[$field['nome']]);

                        foreach($field['valores'] as $key => $option)
                        {
                            $checked = $detalhes_proposta[$field['nome']];
                            $strChecked = '';
                            if($checked === $option)
                            {
                                $strChecked = 'checked="checked"';
                            }
                            $html .= '<input name="'.$field['nome'].'" type="checkbox" value="'.$option.'" '.$strChecked.'/>'.$option;
                        }
                        $html .= '</label><br />';
                    }*/

                    if( "textarea" == $field['tipo'])
                    {
                        if(absint($field['obrigatorio']) === 1 )
                        {
                            $required = 'data-rule-required="true" data-msg-required="Campo Obrigatório"';
                        }
                        $html .= '<label for="'.$field['nome'].'">'.$field['label'].':
                            <textarea id="'.$field['nome'].'" name="'.$field['nome'].'" cols="80" rows="10"  class="large-text" '.$required .'>'.esc_attr($detalhes_proposta[$field['nome']]).'</textarea>
                        </label><br />';

                    }


                    if( "select_estado" == $field['tipo'] OR "select_municipio" == $field['tipo'] )
                    {

                        $html .= '<label for="'.$field['nome'].'">'.$field['label'].':
                    <select name="'.$field['nome'].'" id="'.$field['nome'].'" value="'.esc_attr($detalhes_proposta[$field['nome']]).'">
                        <option selected="selected" value="">Selecione</option>
                    </select>
                </label><br />';
            }
        ?>

        <?php endforeach;
        echo $html;
        ?>


    </fieldset>

</div>