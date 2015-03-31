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

					 	if(1 === absint($field['visivel']) && "file" !== $field['tipo'] )
					 	{
					 		echo '<strong>'.$field['label'].':</strong> '.$detalhes_proposta[$field['nome']].'<br />';
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
