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
					 $image = get_the_post_thumbnail( $post->ID, 'full' );
					 $post_id = $post->ID;


					$detalhes_proposta = unserialize(get_post_meta($post_id, 'detalhes_proposta', true));


					 echo $image;
					 echo '<h1>'. $title. '</h1>';
					 echo '<p>' . $content . '</p>';

					 $settings = new SettingsPage();
					 $fields = $settings->get_custom_fields();

					 echo '<p>';
					 foreach ($fields as $field) {

					 	if(1 === absint($field['visivel']) && !in_array($field['tipo'],array('file', 'attachment')))
					 	{
					 		echo '<strong>'.$field['label'].':</strong> '.$detalhes_proposta[$field['nome']].'<br />';
					 	}
					 	if(1 === absint($field['visivel']) && in_array($field['tipo'],array('attachment')))
					 	{
					 		$urlStriped = explode(".", $detalhes_proposta[$field['nome']);
					 		$extension = array_pop($urlStriped);

					 		$faIconMap = array(
					 			'pdf' => 'fa-file-pdf-o',
					 			'doc' => 'fa-file-word-o',
					 			'docx'=> 'fa-file-word-o',
					 			'xls' => 'fa-file-excel-o',
					 			'xlsx'=> 'fa-file-excel-o'
					 		);


					 		echo '<strong>'.$field['label'].':</strong><a href="'.$detalhes_proposta[$field['nome']].'"><i class="fa '.$faIconMap[$extension].'></i><a><br />';
					 	}
					 	# code...
					 }
					echo '</p>';
				endwhile;
			?>
		</div><!-- #content -->
	</div><!-- #primary -->

<?php
get_footer();
