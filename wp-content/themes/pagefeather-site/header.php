<?php
/**
 * Site header.
 *
 * @package Pagefeather_Site
 */
if (!defined('ABSPATH')) {
	exit;
}
$current = pagefeather_current_path();
$pf_desc = 'WordPress and WooCommerce on Cloudflare, in your own Cloudflare account. Open source. No hosted funnel.';
$pf_title = wp_get_document_title();
$pf_url = wp_get_canonical_url();
if (!$pf_url) {
	$pf_url = home_url($current === '/' ? '/' : $current);
}
$pf_image = get_template_directory_uri() . '/assets/img/og.png';
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="<?php echo esc_attr($pf_desc); ?>">
	<meta property="og:type" content="website">
	<meta property="og:title" content="<?php echo esc_attr($pf_title); ?>">
	<meta property="og:description" content="<?php echo esc_attr($pf_desc); ?>">
	<meta property="og:url" content="<?php echo esc_url($pf_url); ?>">
	<meta property="og:image" content="<?php echo esc_url($pf_image); ?>">
	<meta property="og:image:width" content="1280">
	<meta property="og:image:height" content="640">
	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:title" content="<?php echo esc_attr($pf_title); ?>">
	<meta name="twitter:description" content="<?php echo esc_attr($pf_desc); ?>">
	<meta name="twitter:image" content="<?php echo esc_url($pf_image); ?>">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<script>document.documentElement.classList.add("js");</script>
<a class="skip" href="#main">Skip to content</a>
<div class="atmosphere" aria-hidden="true">
	<div class="grid-field"></div>
	<div class="glow glow--left"></div>
	<div class="glow glow--right"></div>
</div>
<header class="shell">
	<nav class="nav" aria-label="Primary">
		<a class="nav-link<?php echo $current === '/' ? ' is-active' : ''; ?>" href="/">Pagefeather</a>
		<?php foreach (pagefeather_nav_items() as $item) :
			$href = $item['href'];
			$external = str_starts_with($href, 'http');
			$active = !$external && ($current === $href);
			$cls = 'nav-link' . (!empty($item['accent']) ? ' nav-link--accent' : '') . ($active ? ' is-active' : '');
			?>
			<a class="<?php echo esc_attr($cls); ?>" href="<?php echo esc_url($href); ?>"<?php echo $external ? ' rel="noopener noreferrer"' : ''; ?>><?php echo esc_html($item['label']); ?></a>
		<?php endforeach; ?>
	</nav>
</header>
