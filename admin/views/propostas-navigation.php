<?php
$nome_proponente = !empty($detalhes_proposta['nome_proponente']) ? esc_attr($detalhes_proposta['nome_proponente']) : '';
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

?>
<div id="proposalss-navigation">
    <fieldset>
        <?php wp_nonce_field( 'detalhes_meta_box_nonce', 'meta_box_nonce' ); ?>
        <label for="nome_proponente">Nome do proponente:
            <input name="nome_proponente" type="text" id="nome_proponente" value="<?php echo $nome_proponente; ?>"  class="large-text"  />
        </label>

        <label for="cnpj">CNPJ:
            <input name="cnpj" type="text" id="cnpj" value="<?php echo $cnpj; ?>"  class="large-text"  />
        </label>

        <label for="email">E-mail:
            <input name="email" type="text" id="email" value="<?php echo $email; ?>"  class="large-text"  />
        </label>

        <label for="estado">Estado:
            <select name="estado" id="estado" value="<?php echo $estado; ?>">
            </select>
        </label>

        <label for="municipio">Municipio:
            <select name="municipio" id="municipio" value="<?php echo $municipio; ?>">
            </select>
        </label><br />

        <label for="endereco">Endereço:
            <input name="endereco" type="text" id="endereco" value="<?php echo $endereco; ?>"  class="large-text"  />
        </label>

        <label for="telefone">Telefone:
            <input name="telefone" type="text" id="telefone" value="<?php echo $telefone; ?>"  class="large-text"  />
        </label>

        <label for="site">Site:
            <input name="site" type="text" id="site" value="<?php echo $site; ?>"  class="large-text"  />
        </label>

        <label for="facebook">Facebook:
            <input name="facebook" type="text" id="facebook" value="<?php echo $facebook; ?>"  class="large-text"  />
        </label>

        <label for="twitter">Twitter:
            <input name="twitter" type="text" id="twitter" value="<?php echo $twitter; ?>"  class="large-text"  />
        </label>

        <label for="instagram">Instagram:
            <input name="instagram" type="text" id="instagram" value="<?php echo $instagram; ?>"  class="large-text"  />
        </label>

        <label for="responsavel_nome">Nome do responsável legal, coordenador(a) ou pessoa de contato do grupo:
            <input name="responsavel_nome" type="text" id="responsavel_nome" value="<?php echo $responsavel_nome; ?>"  class="large-text"  />
        </label>

        <label for="responsavel_cpf">CPF:
            <input name="responsavel_cpf" type="text" id="responsavel_cpf" value="<?php echo $responsavel_cpf; ?>"  class="large-text"  />
        </label>

        <label for="trabalho_duracao">Duração:
            <input name="trabalho_duracao" type="text" id="trabalho_duracao" value="<?php echo $trabalho_duracao; ?>"  class="large-text"  />
        </label>

        <label for="trabalho_ficha_tecnica">Ficha Técnica:
            <textarea id="trabalho_ficha_tecnica" name="trabalho_ficha_tecnica" cols="80" rows="10" class="large-text"><?php echo $trabalho_ficha_tecnica; ?></textarea>
        </label>

        <label for="trabalho_pessoas">Número de pessoas nessa apresentacão:</br>
            <input name="trabalho_pessoas" type="checkbox" id="trabalho_pessoas_1" value="1" <?php checked( $trabalho_pessoas, 1 ); ?> />individual
            <input name="trabalho_pessoas" type="checkbox" id="trabalho_pessoas_2" value="2" <?php checked( $trabalho_pessoas, 2 ); ?> />até 2 artistas envolvidos
            <input name="trabalho_pessoas" type="checkbox" id="trabalho_pessoas_3" value="3" <?php checked( $trabalho_pessoas, 3 ); ?> />3 a 5 artistas envolvidos
            <input name="trabalho_pessoas" type="checkbox" id="trabalho_pessoas_4" value="4" <?php checked( $trabalho_pessoas, 4 ); ?> />6 ou mais artistas envolvidos
        </label>
        <label for="calendario">Calendário:
            <input name="calendario" type="text" id="calendario" value="<?php echo $calendario; ?>"  class="large-text"  />
        </label>

    </fieldset>

</div>