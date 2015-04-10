<?php add_thickbox(); ?>
<?php
    if("POST" === $_SERVER['REQUEST_METHOD'])
    {
        
        if(isset($_POST['reset']))
        {
            $this->reset();
        }

        if(isset($_POST['delete']))
        {
            $this->delete_field($_POST['my_option_name']['nome']);
        }
        else
        {
            $this->update_field($_POST['my_option_name']['nome'], $_POST['my_option_name']);
        }
    }

?>
<div class="wrap">
    <form method="post" action="options.php">
        <?php
            // This prints out all hidden setting fields
            settings_fields( 'my_option_group' );
            do_settings_sections( 'campos-gerenciaveis' );
            submit_button();
        ?>
    </form>
    <?php screen_icon(); ?>

    <h2>QPropostas</h2>
    <form method="post" action="">
        <input type="submit" name="reset" id="reset" class="button button-primary" value="Reset" style="background-color:#ff0000;">
    </form>
    <table class="form-table">
    <tr>
        <th class="row-title">Nome</th>
        <th>Obrigatório</th>
        <th>Tipo</th>
        <th>Texto complementar</th>
        <th>Valores</th>
        <th>Exibir</th>
        <th>Ações</th>

    </tr>


    <?php foreach($this->proposals_custom_fields_options as $indexCustomField => $custom_field):

        if(!empty($custom_field))
        {

        $row_class = $indexCustomField % 2 !== 0 ? 'alternate' : '';
        $valores = $valores_form = '' ;

    if(!empty($custom_field['valores']))
    {

        $valores_form = implode("@", $custom_field['valores']);
        $valores = '<ul>';
        foreach ($custom_field['valores'] as $key => $value) {
            $valores .=  '<li>'. $value. '</li>' ;
        }
        $valores .= '</ul>';
    }
    $obrigatorio = 1 === absint($custom_field['obrigatorio']) ? "Sim" : "Não";
    $visivel = 1 === absint($custom_field['visivel']) ? "Sim" : "Não";
    ?>

    <tr valign="top" class="<?php echo $row_class; ?>">
        <td scope="row"><label for="tablecell"><?php echo $custom_field['label']; ?></label></td>
        <td><?php echo $obrigatorio; ?></td>
        <td><?php echo $custom_field['tipo']; ?></td>
        <td><?php echo $custom_field['texto_complementar']; ?></td>
        <td><?php echo $valores; ?></td>
        <td><?php echo $visivel; ?></td>
        <td>
            <div id="my-content-<?php echo $custom_field['nome']; ?>" style="display:none;">
             <p>
                    <?php

                    ?>
                   <form method="post" action="">
                        <input type="hidden" name="option_page" value="my_option_group">
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" id="_wpnonce" name="_wpnonce" value="dbbb0cfcfd">
                        <input type="hidden" name="my_option_name[nome]" value="<?php echo $custom_field['nome']; ?>">
                        <h3>Editar Campo</h3>
                        <table class="form-table">
                        <tbody>
                            <tr>
                                <th scope="row">Nome</th>
                                <td>
                                    <input type="text" id="label" name="my_option_name[label]" value="<?php echo $custom_field['label']; ?>" required="" class="regular-text">
                                </td>
                                </tr>
                                <tr>
                                    <th scope="row">Tipo</th>
                                    <td><select name="my_option_name[tipo]" id="tipo" required="">
                                    <option value="wp_title" <?php if($custom_field['tipo'] === "wp_title") echo 'selected="selected"';?>>Texto</option>
                                    <option value="wp_content" <?php if($custom_field['tipo'] === "wp_content") echo 'selected="selected"';?>>Texto</option>
                                    <option value="text" <?php if($custom_field['tipo'] === "text") echo 'selected="selected"';?>>Texto</option>
                                    <option value="email" <?php if($custom_field['tipo'] === "email") echo 'selected="selected"';?>>E-mail</option>
                                    <option value="checkbox" <?php if($custom_field['tipo'] === "checkbox") echo 'selected="selected"';?>>Checkbox</option>
                                    <option value="checkbox_with_text" <?php if($custom_field['tipo'] === "checkbox_with_text") echo 'selected="selected"';?>>Checkbox + Texto</option>
                                    <option value="textarea" <?php if($custom_field['tipo'] === "textarea") echo 'selected="selected"';?>>Textarea</option>
                                    <option value="radio" <?php if($custom_field['tipo'] === "radio") echo 'selected="selected"';?>>Radio</option>
                                    <option value="select" <?php if($custom_field['tipo'] === "select") echo 'selected="selected"';?>>Select</option>
                                    <option value="select_estado" <?php if($custom_field['tipo'] === "select_estado") echo 'selected="selected"';?>>Select Estado</option>
                                    <option value="select_municipio" <?php if($custom_field['tipo'] === "select_municipio") echo 'selected="selected"';?>>Select Munícipio</option>
                                    <option value="file" <?php if($custom_field['tipo'] === "file") echo 'selected="selected"';?>>Imagem destacada</option>
                                    <option value="attachment" <?php if($custom_field['tipo'] === "attachment") echo 'selected="selected"';?>>Anexo</option>
                                    <option value="calendario" <?php if($custom_field['tipo'] === "calendario") echo 'selected="selected"';?>>Calendario</option>
                                    <option value="date-range" <?php if($custom_field['tipo'] === "date-range") echo 'selected="selected"';?>>Periodo</option>
                                    
                                </select>
                                </td>
                                </tr>
                                <tr>
                                <th>Texto complementar</th>
                                <td>
                                    <input type="text" id="texto_complementar" name="my_option_name[texto_complementar]" value="<?php echo $custom_field['texto_complementar']; ?>" class="regular-text">
                                </td>
                                </tr>
                                <tr>
                                    <th scope="row">Opções</th>
                                    <td>
                                        <input type="text" id="valores" name="my_option_name[valores]" value="<?php echo $valores_form; ?>" class="large-text">

                                        <small> Digite os valores separados por @</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Obrigatório</th>
                                    <td>
                                        <input type="radio" id="obrigatorio" name="my_option_name[obrigatorio]" value="1" <?php if($obrigatorio === "Sim") echo 'checked="checked"';?>> Sim
                                        <input type="radio" id="obrigatorio" name="my_option_name[obrigatorio]" value="0" <?php if($obrigatorio === "Não") echo 'checked="checked"';?>> Não
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Visível</th>
                                    <td>
                                        <input type="radio" id="visivel" name="my_option_name[visivel]" value="1"  <?php if($visivel === "Sim") echo 'checked="checked"';?>> Sim
                                        <input type="radio" id="visivel" name="my_option_name[visivel]" value="0" <?php if($obrigatorio === "Não") echo 'checked="checked"';?>> Não
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <p class="submit">
                            <input type="submit" name="submit" id="submit" class="button button-primary" value="Salvar alterações">
                            <input type="submit" name="delete" id="delete" class="button button-primary" value="Excluir" style="background-color:#ff0000;">
                        </p>
                    </form>

                                 </p>
                            </div>
                            <a href="#TB_inline?width=600&height=550&inlineId=my-content-<?php echo $custom_field['nome']; ?>" class="thickbox">Editar</a></td>

                        </tr>
    <?php }
    endforeach; ?>
</table>


</div>
