<?php get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			<?php

				// Start the Loop.
				while ( have_posts() ) : the_post();
					global $post;
					$numero_pessoas = array('Individual', 'até 2 artistas envolvidos', '3 a 5 artistas envolvidos', '6 ou mais artistas envolvidos');
					 $title = get_the_title();
					 $content = get_the_content();
					 $image = get_the_post_thumbnail( $post_id, 'full' );
					 $post_id = $post->ID;
					$detalhes_proposta = unserialize(get_post_meta($post_id, 'detalhes_proposta', true));

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


					 echo $image;
					 echo '<h1>'. $title. '</h1>';
					 echo '<p>' . $content . '</p>';

					 echo '<p>';
					 echo '<strong>Nome do proponente:</strong> '.$nome_proponente.'<br />';
					 echo '<strong>CNPJ:</strong> '.$cnpj.'<br />';
					 echo '<strong>E-mail:</strong> '.$email.'<br />';
					 echo '<strong>Estado:</strong> '.$estado.'<br />';
					 echo '<strong>Munícipio:</strong> '.$municipio.'<br />';
					 echo '<strong>Endereço:</strong> '.$endereco.'<br />';
					 echo '<strong>Telefone:</strong> '.$telefone.'<br />';
					 echo '<strong>Site:</strong> '.$site.'<br />';
					 echo '<strong>Facebook:</strong> '.$facebook.'<br />';
					 echo '<strong>Twitter:</strong> '.$twitter.'<br />';
					 echo '<strong>Instagram:</strong> '.$instagram.'<br />';
					 echo '<strong>Nome do responsável legal, coordenador(a) ou pessoa de contato do grupo:</strong> '.$responsavel_nome.'<br />';
					 echo '<strong>CPF:</strong> '.$responsavel_cpf.'<br />';
					 echo '<strong>Duração:</strong> '.$trabalho_duracao.'<br />';
					 echo '<strong>Ficha Técnica:</strong> '.$trabalho_ficha_tecnica.'<br />';
					 echo '<strong>Número de pessoas nessa apresentacão:</strong> '.$numero_pessoas[(int)$trabalho_pessoas - 1].'<br />';
					 echo '<strong>Calendário:</strong> '.$calendario.'<br />';
					 echo '</p>';
				endwhile;
			?>
		</div><!-- #content -->
	</div><!-- #primary -->

<?php
get_footer();
