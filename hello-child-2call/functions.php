<?php
/**
 * Hello Child 2Call — functions.php
 *
 * Enqueue de fontes, CSS e JS da landing 2Call Cuiabá e SEO básico
 * (title + meta description) para a homepage.
 *
 * O template front-page.php é standalone (não chama get_header/get_footer
 * do Hello), então NÃO enfileiramos o style.css do tema pai.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'wp_enqueue_scripts', function () {
	$uri = get_stylesheet_directory_uri();
	$ver = '1.1.0';

	wp_enqueue_style(
		'two-call-fonts',
		'https://fonts.googleapis.com/css2?family=Permanent+Marker&family=Caveat:wght@600;700&family=Shantell+Sans:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap',
		array(),
		null
	);

	wp_enqueue_style(
		'two-call-landing',
		$uri . '/css/landing.css',
		array( 'two-call-fonts' ),
		$ver
	);

	wp_enqueue_script(
		'two-call-landing',
		$uri . '/js/landing.js',
		array(),
		$ver,
		true
	);
}, 20 );

add_filter( 'pre_get_document_title', function ( $title ) {
	if ( is_front_page() ) {
		return '2Call Cuiabá — SMS Marketing em Massa | Se tá na mão, você vê.';
	}
	return $title;
} );

add_action( 'wp_head', function () {
	if ( is_front_page() ) {
		echo '<meta name="description" content="SMS marketing em massa em Cuiabá e Várzea Grande - MT. Mais de 2 milhões de contatos segmentáveis prontos pra receber sua mensagem. Faça um orçamento.">' . "\n";
	}
}, 1 );

add_action( 'after_setup_theme', function () {
	add_theme_support( 'title-tag' );
} );

/**
 * Cria/atualiza as paginas legais (Politica de Privacidade e Termos de Uso)
 * usando o conteudo HTML em /pages-content/.
 *
 * - Se ja existe pagina com o slug (ex: Privacidade auto-criada pelo WP cheia
 *   de "Texto sugerido"), SOBRESCREVE o conteudo, titulo e status dela.
 * - Se ja existe ANEXO (PDF) com o slug claimando a URL, renomeia o slug do
 *   anexo. O arquivo PDF em si permanece intacto.
 * - Aponta a Politica de Privacidade do WP (Configuracoes -> Privacidade)
 *   pra nossa pagina.
 *
 * Roda uma unica vez. Pra forcar rerun, apague 'two_call_legal_pages_v3'
 * em wp_options.
 */
function two_call_setup_legal_pages() {
	if ( get_option( 'two_call_legal_pages_v3' ) ) {
		return;
	}

	$pages = array(
		'politica-de-privacidade' => array(
			'title'      => 'Política de Privacidade',
			'file'       => 'politica-de-privacidade.html',
			'is_privacy' => true,
		),
		'termos-de-uso' => array(
			'title'      => 'Termos de Uso',
			'file'       => 'termos-de-uso.html',
			'is_privacy' => false,
		),
	);

	foreach ( $pages as $slug => $data ) {
		$path = get_stylesheet_directory() . '/pages-content/' . $data['file'];
		if ( ! is_readable( $path ) ) {
			continue;
		}
		$content = file_get_contents( $path );
		if ( '' === $content ) {
			continue;
		}

		// Libera o slug se um anexo estiver claimando (defesa contra re-upload de PDF).
		$attachments = get_posts( array(
			'name'           => $slug,
			'post_type'      => 'attachment',
			'post_status'    => 'any',
			'posts_per_page' => -1,
		) );
		foreach ( $attachments as $att ) {
			wp_update_post( array(
				'ID'        => $att->ID,
				'post_name' => $slug . '-arquivo-' . $att->ID,
			) );
		}

		// Procura pagina existente pelo slug em qualquer status.
		$existing = get_page_by_path( $slug, OBJECT, 'page' );

		if ( $existing ) {
			$page_id = wp_update_post( array(
				'ID'             => $existing->ID,
				'post_title'     => $data['title'],
				'post_name'      => $slug,
				'post_content'   => $content,
				'post_status'    => 'publish',
				'comment_status' => 'closed',
				'ping_status'    => 'closed',
			) );
		} else {
			$page_id = wp_insert_post( array(
				'post_title'     => $data['title'],
				'post_name'      => $slug,
				'post_content'   => $content,
				'post_status'    => 'publish',
				'post_type'      => 'page',
				'post_author'    => 1,
				'comment_status' => 'closed',
				'ping_status'    => 'closed',
			) );
		}

		// Aponta o setting nativo de Privacidade do WP pra nossa pagina.
		if ( $data['is_privacy'] && $page_id && ! is_wp_error( $page_id ) ) {
			update_option( 'wp_page_for_privacy_policy', $page_id );
		}
	}

	flush_rewrite_rules();
	update_option( 'two_call_legal_pages_v3', 1 );
}
add_action( 'after_switch_theme', 'two_call_setup_legal_pages' );
add_action( 'admin_init', 'two_call_setup_legal_pages' );
