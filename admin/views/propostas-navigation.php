<?php

/*$nome_proponente = !empty($detalhes_proposta['nome_proponente']) ? esc_attr($detalhes_proposta['nome_proponente']) : '';
$cnpj = !empty($detalhes_proposta['cnpj']) ? esc_attr($detalhes_proposta['cnpj']) : '';
$email = !empty($detalhes_proposta['email']) ? esc_attr($detalhes_proposta['email']) : '';
$estado = !empty($detalhes_proposta['estado']) ? esc_attr($detalhes_proposta['estado']) : '';
$municipio = !empty($detalhes_proposta['municipio']) ? esc_attr($detalhes_proposta['municipio']) : '';
$endereco = !empty($detalhes_proposta['endereco']) ? esc_attr($detalhes_proposta['endereco']) : '';
$telefone = !empty($detalhes_proposta['telefone']) ? esc_attr($detalhes_proposta['telefone']) : '';
$site = !empty($detalhes_proposta['site']) ? esc_attr($detalhes_proposta['site']) : '';
$facebook = !empty($detalhes_proposta['facebook']) ? esc_attr($detalhes_proposta['facebook']) : '';
$twitter = !empty($detalhes_proposta['twitter']) ? esc_attr($detalhes_proposta['twitter']) : '';
$instagram = !empty($detalhes_proposta['instagram']) ? esc_attr($detalhes_proposta['instagram']) : '';
$responsavel_nome = !empty($detalhes_proposta['responsavel_nome']) ? esc_attr($detalhes_proposta['responsavel_nome']) : '';
$responsavel_cpf = !empty($detalhes_proposta['responsavel_cpf']) ? esc_attr($detalhes_proposta['responsavel_cpf']) : '';
$trabalho_duracao = !empty($detalhes_proposta['trabalho_duracao']) ? esc_attr($detalhes_proposta['trabalho_duracao']) : '';
$trabalho_ficha_tecnica = !empty($detalhes_proposta['trabalho_ficha_tecnica']) ? esc_attr($detalhes_proposta['trabalho_ficha_tecnica']) : '';
$trabalho_pessoas = !empty($detalhes_proposta['trabalho_pessoas']) ? (int)$detalhes_proposta['trabalho_pessoas'] : 0;
$calendario = !empty($detalhes_proposta['calendario']) ? $detalhes_proposta['calendario'] : '';
*/
?>
<div id="proposalss-navigation">
    <fieldset>
        <?php wp_nonce_field( 'detalhes_meta_box_nonce', 'meta_box_nonce' ); 
        $html = '';
        ?>
        
        <?php foreach($fields as $field):

            if( "text" == $field['tipo'] OR "calendario" == $field['tipo'] OR "email" == $field['tipo'] )
                    {
                        $html .= '<label for="'.$field['nome'].'">'.$field['label'].':
                            <input  name="'.$field['nome'].'" type="text" id="'.$field['nome'].'" value="'.esc_attr($detalhes_proposta[$field['nome']]).'"  class="large-text"/>
                        </label><br />';

                        /*if("calendario" == $field['tipo']) 
                        {
                            $html .= '<div id="dialog-confirm" title="Alerta" style="display:none;">
                                    <p>O dia de domingo é reservado para atividades para o público infantil, caso a sua não seja, favor escolher outros dias</p>
                            </div>';
                        }*/
                    }

                    if( "checkbox" == $field['tipo'])
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
                    }

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