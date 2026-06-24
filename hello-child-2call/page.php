<?php
/**
 * Template padrao de pagina — Hello Child 2Call
 *
 * Standalone: nao usa get_header()/get_footer() do Hello.
 * Reaproveita o header e footer da landing pra manter consistencia visual.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$theme_uri = esc_url( get_stylesheet_directory_uri() );
$home_url  = esc_url( home_url( '/' ) );
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<?php wp_head(); ?>
</head>
<body <?php body_class( 'two-call-page' ); ?>>

<!-- ============ HEADER ============ -->
<header class="site-header">
  <div class="container header-inner">
    <a class="brand" href="<?php echo $home_url; ?>" aria-label="2Call Cuiabá">
      <img src="<?php echo $theme_uri; ?>/assets/logo-2call.png" alt="2Call Cuiabá — Se tá na mão, você vê.">
    </a>
    <nav class="nav" aria-label="Navegação principal">
      <a href="<?php echo $home_url; ?>#porque">Por que SMS</a>
      <a href="<?php echo $home_url; ?>#beneficios">Benefícios</a>
      <a href="<?php echo $home_url; ?>#segmentacao">Segmentação</a>
      <a href="<?php echo $home_url; ?>#exemplos">Exemplos</a>
      <a href="<?php echo $home_url; ?>#orcamento" class="btn btn-red btn-sm cta-text">Faça um orçamento</a>
    </nav>
    <button class="menu-toggle" aria-label="Abrir menu">
      <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><line x1="4" y1="7" x2="20" y2="7"/><line x1="4" y1="12" x2="20" y2="12"/><line x1="4" y1="17" x2="20" y2="17"/></svg>
    </button>
  </div>
</header>

<!-- ============ PAGE CONTENT ============ -->
<main class="legal-page">
  <div class="container">
    <article class="legal-card">
      <header class="legal-head">
        <span class="kicker">Documento legal</span>
        <h1><?php the_title(); ?></h1>
      </header>
      <div class="legal-body">
        <?php
        while ( have_posts() ) :
          the_post();
          the_content();
        endwhile;
        ?>
      </div>
    </article>
  </div>
</main>

<!-- ============ FOOTER ============ -->
<footer class="footer">
  <div class="container">
    <div class="footer-grid">
      <div class="footer-brand">
        <img src="<?php echo $theme_uri; ?>/assets/logo-2call.png" alt="2Call Cuiabá">
        <p class="footer-slogan">Se tá na mão, você vê.</p>
        <p>SMS marketing em massa em Cuiabá e Várzea Grande — MT. Mais de 2 milhões de contatos segmentáveis prontos pra impulsionar o seu negócio.</p>
      </div>
      <div>
        <h4>Contato</h4>
        <ul class="footer-list">
          <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z"/></svg><a data-wa href="#">65 98116-4887</a></li>
          <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-10 5L2 7"/></svg><a data-mail href="#">junior.lannes@2cmovel.com.br</a></li>
          <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0z"/><circle cx="12" cy="10" r="3"/></svg><span>Rua Mário Motta, 383 — Centro Norte<br>Várzea Grande / MT — CEP 78.110-620</span></li>
        </ul>
      </div>
      <div>
        <h4>Navegação</h4>
        <ul class="footer-list">
          <li><a href="<?php echo $home_url; ?>#porque">Por que SMS</a></li>
          <li><a href="<?php echo $home_url; ?>#beneficios">Benefícios</a></li>
          <li><a href="<?php echo $home_url; ?>#segmentacao">Segmentação</a></li>
          <li><a href="<?php echo $home_url; ?>#exemplos">Exemplos reais</a></li>
          <li><a href="<?php echo $home_url; ?>#orcamento">Faça um orçamento</a></li>
          <li><a href="<?php echo esc_url( home_url( '/politica-de-privacidade/' ) ); ?>">Política de privacidade</a></li>
          <li><a href="<?php echo esc_url( home_url( '/termos-de-uso/' ) ); ?>">Termos de uso</a></li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      <span>© <span id="year"><?php echo esc_html( date( 'Y' ) ); ?></span> 2Call Cuiabá — Todos os direitos reservados.</span>
      <span>SMS marketing em massa · Várzea Grande / MT</span>
    </div>
  </div>
</footer>

<!-- floating whatsapp -->
<a class="fab" data-wa href="#" aria-label="Falar no WhatsApp">
  <svg viewBox="0 0 24 24" fill="currentColor"><path d="M.057 24l1.687-6.163a11.867 11.867 0 0 1-1.587-5.946C.16 5.335 5.495 0 12.05 0a11.817 11.817 0 0 1 8.413 3.488 11.824 11.824 0 0 1 3.48 8.414c-.003 6.557-5.338 11.892-11.893 11.892a11.9 11.9 0 0 1-5.688-1.448L.057 24zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884a9.86 9.86 0 0 0 1.51 5.26l-.999 3.648 3.978-1.607zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413z"/></svg>
</a>

<?php wp_footer(); ?>
</body>
</html>
